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

    /**
     * Funcion para actualizar una categoria
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

        $category = Category::find($request->category_id);

        //Se verifica que no existe una categoría con el mismo nombre en el mismo proyecto
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
     * Funcion para eliminar una categoria
     */
    public function destroy($id)
    {
        $category = Category::find($id);

        // Parte local //
        $publicPath = $category->public_directory_path;

        // Elimino los archivos adjuntos de dicha categoria
        Storage::deleteDirectory($publicPath);
        // Fin parte local//

        // Parte para infinityfree //
        /*
            $publicPath = $category->infinity_free_directory_path;
            // Elimino los archivos adjuntos a dicha categoria
            $filesistem = new Filesystem();
            $filesistem->deleteDirectory(substr($publicPath, 1));
        */
        //Fin parte infinityfree //


        $category->delete();
        $category->forceDelete();
        return back()->with('notification', 'La categoria se ha eliminado correctamente.');
    }
}
