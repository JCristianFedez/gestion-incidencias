<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function store(Request $request){
        
        $rules = [
            'name' => ["required","min:5","max:255"]
        ];
    
        $messages = [
            'name.required' => 'Es necesario ingresar un nombre para la categoría.',
            'name.min' => 'La categoría necesita un minimo de 5 caracteres.',
            'name.max' => 'La categoría no puede tener mas de 255 caracteres.',
        ];

        $this->validate($request, $rules, $messages);

        Category::create($request->all());

        return back()->with('notification', 'La categoria se ha creado correctamente.');
    }

    public function update(Request $request){
        $rules = [
            'name' => ["required","min:5","max:255"]
        ];
    
        $messages = [
            'name.required' => 'Es necesario ingresar un nombre para la categoría.',
            'name.min' => 'La categoría necesita un minimo de 5 caracteres.',
            'name.max' => 'La categoría no puede tener mas de 255 caracteres.',
        ];

        $this->validate($request, $rules, $messages);

        $category = Category::find($request->category_id);
        $category->name = $request->name;
        $category->save();

        return back()->with('notification', 'La categoria se ha actualizado correctamente.');
    }

    
    public function destroy($id){

        Category::find($id)->delete();
        return back()->with('notification', 'La categoria se ha eliminado correctamente.');
    }
}
