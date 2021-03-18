<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Level;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    public function store(Request $request){
        
        $rules = [
            'name' => 'required'
        ];
    
        $messages = [
            'name.required' => 'Es necesario ingresar un nombre para el nivel.',
        ];

        $this->validate($request, $rules, $messages);

        Level::create($request->all());

        return back()->with('notification', 'El nivel se ha creado correctamente.');
    }

    public function update(Request $request){
        $rules = [
            'name' => 'required'
        ];
    
        $messages = [
            'name.required' => 'Es necesario ingresar un nombre para el nivel.',
        ];

        $this->validate($request, $rules, $messages);

        $level = Level::find($request->level_id);
        $level->name = $request->name;
        $level->save();

        return back()->with('notification', 'El nivel se ha actualizado correctamente.');
    }

    public function destroy($id){

        Level::find($id)->delete();
        return back()->with('notification', 'El nivel se ha eliminado correctamente.');
    }
}
