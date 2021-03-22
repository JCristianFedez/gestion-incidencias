<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    use HasFactory;

    public static $rules = [
        "category_id" => ["nullable","exists:categories,id"],
        "severity" => ["required","in:M,N,A"],
        "title" => ["required","min:5","max:255"],
        "description" => ["required","min:15","max:255"]
    ];

    public static $messages = [
        "category_id.exists" => "La categoria seleccionada no existe en nuestra base de datos.",
        "title.required" => "Es necesario ingresar un título para la incidencia.",
        "title.min" => "El título debe presentar al menos 5 caracteres.",
        "title.max" => "El título debe presentar menos de 255 caracteres.",
        "description.required" => "Es necesario ingresar una descripción para la incidencia.",
        "description.min" => "La descripción debe presentar al menos 15 caracteres.",
        "description.max" => "La descripción debe presentar menos de 255 caracteres."
    ];

    public function category(){
        return $this->belongsTo("App\Models\Category");
    }

    public function project(){
        return $this->belongsTo("App\Models\Project");
    }

    public function support(){
        return $this->belongsTo("App\Models\User","support_id");
    }

    public function client(){
        return $this->belongsTo("App\Models\User","client_id");
    }

    public function level(){
        return $this->belongsTo("App\Models\Level");
    }

    public function messages(){
        return $this->hasMany("App\Models\Message");
    }

    // Accesors

    /**
     * Return full name of the severity
     */
    public function getSeverityFullAttribute(){
        switch ($this->severity) {
            case 'M':
                return "Menor";
                break;
            case 'N':
                return "Normal";
                break;
            case 'A':
                return "Alta";
                break;
            default:
                return "Desconocida";
                break;
        }
    }

    /**
     * Return short title
     */
    public function getTitleShortAttribute(){
        return mb_strimwidth($this->title, 0, 20, "...");
    }

    /**
     * Return name of category
     */
    public function getCategoryNameAttribute(){
        if($this->category){
            return $this->category->name;
        }
        return "General";
    }

    /**
     * Return name of Support
     */
    public function getSupportNameAttribute(){
        if($this->support){
            return $this->support->name;
        }
        return "Sin asignar";
    }

    /**
     * Return name of state
     */
    public function getStateAttribute(){
        if($this->active == 0){
            return "Resuelto";
        }

        if($this->support_id){
            return "Asignado";
        }

        return "Pendiente";
    }
}
