<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        $users = User::where("role",1)->get();
        return view("admin.users.index",compact("users"));
    }

    public function store(Request $request){
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8']
        ];

        $messages = [
            'name.required' => 'Es necesario ingresar el nombre del usuario.',
    	    'name.max' => 'El nombre es demasiado extenso.',
    		'email.required' => 'Es indispensable ingresar el e-mail del usuario.',
    		'email.email' => 'El e-mail ingresado no es válido.',
    		'email.max' => 'El e-mail es demasiado extenso.',
    		'email.unique' => 'Este e-mail ya se encuentra en uso.',
    		'password.required' => 'Olvidó ingresar una contraseña.',
    		'password.min' => 'La contraseña debe presentar al menos 6 caracteres.'
        ];

        $this->validate($request, $rules, $messages);

    	$user = new User();
    	$user->name = $request->name;
    	$user->email = $request->email;
    	$user->password = bcrypt($request->password);
    	$user->role = 1; //0: Admin | 1: Support | 2:Client	
    	$user->save();

        
        return back()->with("notification","Usuario registrado exitosamente.");
    }

    public function edit($id){
        $user = User::findOrFail($id);

        return view("admin.users.edit", compact("user"));
    }

    public function update($id, Request $request){

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'password' => ["nullable",'string', 'min:6']
        ];

        $messages = [
    		'name.required' => 'Es necesario ingresar el nombre del usuario.',
    		'name.max' => 'El nombre es demasiado extenso.',
    		'password.min' => 'La contraseña debe presentar al menos 6 caracteres.'
    	];

        $this->validate($request, $rules, $messages);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        
        $password = $request->password;
        if($password){
            $user->password = bcrypt($password);
        }

        $user->save();


        return back()->with("notification","Usuario modificado exitosamente.");
    }

    public function destroy($id){
        $user = User::findOrFail($id);

		$user->delete();
        return back()->with("notification","Usuario eliminado exitosamente.");

	}
}
