<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function store(Request $request){
        
        $rules = [
            'name' => ["required","min:5","max:255"],
            'project_id' => ["required","exists:projects,id"]
        ];
    
        $messages = [
            'name.required' => 'Es necesario ingresar un nombre para la categoría.',
            'name.min' => 'La categoría necesita un minimo de 5 caracteres.',
            'name.max' => 'La categoría no puede tener mas de 255 caracteres.',
        ];

        $this->validate($request, $rules, $messages);

        //It is verified that there is not a category with the same name in the same project
        if(Category::where("project_id",$request->project_id)->where("name",$request->name)->first()){
            return back()->with('notificationError', 'El proyecto ya tiene una categoria con ese nombre.');
        }

        Category::create($request->all());

        return back()->with('notification', 'La categoria se ha creado correctamente.');
    }

    public function update(Request $request){

        $rules = [
            'name' => ["required","min:5","max:255"],
            'category_id' => ["required","exists:projects,id"]
        ];
    
        $messages = [
            'name.required' => 'Es necesario ingresar un nombre para la categoría.',
            'name.min' => 'La categoría necesita un minimo de 5 caracteres.',
            'name.max' => 'La categoría no puede tener mas de 255 caracteres.',
        ];

        $this->validate($request, $rules, $messages);

        $category = Category::find($request->category_id);
        
        //It is verified that there is not a category with the same name in the same project
        if(Category::where("project_id",$category->project_id)->where("name",$request->name)->first()){
            
            if($request->ajax()){
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

        if($request->ajax()){
            return response()->json([
                "head" => "¡Correcto!",
                "message" => "La categoria se ha actualizado correctamente.",
                "type" => "success",
                ]);
        }

        return back()->with('notification', 'La categoria se ha actualizado correctamente.');
    }

    
    public function destroy($id){
        $category = Category::find($id);
        $publicPath = $category->public_directory_path;

        Storage::deleteDirectory($publicPath);

        $category->delete();
        $category->forceDelete();
        return back()->with('notification', 'La categoria se ha eliminado correctamente.');
    }
}
