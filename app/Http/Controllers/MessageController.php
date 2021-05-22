<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Funcion encargada de almacenar un nuevo mensaje
     */
    public function store(Request $request, $id)
    {

        $rules = [
            "message" => ["required", "max:255", "string"]
        ];

        $messages = [
            "message.required" => "Olvido ingresar un mensaje.",
            "message.max" => "Ingrese como máximo 255 caracteres"
        ];

        $this->validate($request, $rules, $messages);

        $message = new Message();
        $message->incident_id = $id;
        $message->message = $request->message;
        $message->user_id = auth()->user()->id;
        $message->save();

        return back()->with("notification", "Mensaje enviado");
    }
}
