<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Funcion para almacenar una nueva categoria
     * @param Request $request Datos pasados por el usuario los cuales se usan para crear la categoria
     */
    public function store(Request $request)
    {

        $this->validate($request, Category::$rules, Category::$messages);

        //Se verifica que no existe una categoría con el mismo nombre en el mismo proyecto
        if (Category::where("project_id", $request->project_id)->where("name", $request->name)->first()) {
            return back()->with('notificationError', 'El proyecto ya tiene una categoria con ese nombre.');
        }

        Category::create($request->all());

        return back()->with('notification', 'La categoria se ha creado correctamente.');
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////
    
    /**
     * Funcion para actualizar una categoria
     * @param Request $request Datos pasados por el usuario los cuales se usan para actualizar la categoria
     */
    public function update(Request $request)
    {
        $rules = [
            'name' => ["required", "min:5", "max:255"],
            'category_id' => ["required", "exists:categories,id"]
        ];

        $messages = [
            'name.required' => 'Es necesario ingresar un nombre para la categoría.',
            'name.min' => 'La categoría necesita un minimo de 5 caracteres.',
            'name.max' => 'La categoría no puede tener mas de 255 caracteres.',
        ];

        $this->validate($request, $rules, $messages);

        $category = Category::findOrFail($request->category_id);

        //Se verifica que no existe una categoría con el mismo nombre en el mismo proyecto
        $temp = $this->verifiedProjectDoesNotHaveCategoryWithSameName($category, $request);
        if ($temp != null) {
            return $temp;
        }

        $category->name = $request->name;
        $category->save();

        if ($request->ajax()) {
            return response()->json([
                "head" => "¡Correcto!",
                "message" => "La categoria se ha actualizado correctamente.",
                "type" => "success",
            ]);
        }

        return back()->with('notification', 'La categoria se ha actualizado correctamente.');
    }

    /**
     * Se verifica que si existe en un proyecto una categoria con el mismo nombre que el pasado
     * @param Category $category Categoria que se va a comprobar
     * @param Request $request Datos pasadsos por por el usuario
     * @return return Devuelve si ha el fallo a devolver si ya habia una categoria con el mismo nombre
     */
    private function verifiedProjectDoesNotHaveCategoryWithSameName(Category $category, Request $request)
    {
        if (Category::where("project_id", $category->project_id)->where("name", $request->name)->first()) {

            if ($request->ajax()) {
                return response()->json([
                    "head" => "¡Error!",
                    "message" => "El proyecto ya tiene una categoria con ese nombre",
                    "type" => "error",
                ]);
            }

            return back()->with('notificationError', 'El proyecto ya tiene una categoria con ese nombre.');
        }
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Funcion para eliminar una categoria
     * @param Integer $id Id de la categoria a eliminar
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        // Parte local //
        // $this->localDeleteDirectory($category);
        // Fin parte local//

        // Parte para infinityfree //
        $this->infinityFreeDeleteDirectory($category);
        //Fin parte infinityfree //

        $category->delete();
        $category->forceDelete();
        return back()->with('notification', 'La categoria se ha eliminado correctamente.');
    }

    /**
     * Elimina los archivos de la categoria pasada.
     * Usado para laravel en local
     * @param Category $category Categoria con la cual se sacara la ruta para eliminar el directorio
     */
    private function localDeleteDirectory(Category $category)
    {
        $publicPath = $category->public_directory_path;
        // Elimino el directorio de dicha categoria
        Storage::deleteDirectory($publicPath);
    }

    /**
     * Elimina los archivos de la categoria pasada.
     * Usado para laravel en infinityFree
     * @param Category $category Categoria con la cual se sacara la ruta para eliminar el directorio
     */
    private function infinityFreeDeleteDirectory(Category $category)
    {
        $publicPath = $category->infinity_free_directory_path;
        // Elimino el directorio de dicha categoria
        $filesistem = new Filesystem();
        $filesistem->deleteDirectory(substr($publicPath, 1));
    }
}
