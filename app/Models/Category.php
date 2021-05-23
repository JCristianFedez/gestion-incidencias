<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "name",
        "project_id"
    ];

    public static $rules = [
        'name' => ["required", "min:5", "max:255"],
        'project_id' => ["required", "exists:projects,id"]
    ];

    public static $messages = [
        'name.required' => 'Es necesario ingresar un nombre para la categoría.',
        'name.min' => 'La categoría necesita un minimo de 5 caracteres.',
        'name.max' => 'La categoría no puede tener mas de 255 caracteres.',
    ];

    public function project()
    {
        return $this->belongsTo("App\Models\Project");
    }


    /**
     * @return String Devuelve un string con la ruta del directorio de los archivos adjuntos a la categoria
     */
    public function getPublicDirectoryPathAttribute()
    {
        $path = "/public";
        $path .= "/Project-" . $this->project->id;
        $path .= "/Category-" . $this->id;
        return $path;
    }

    /**
     * @return String Devuelve un string con la ruta del directorio de los archivos adjuntos a la categoria, usado in InfinityFree
     */
    public function getInfinityFreeDirectoryPathAttribute()
    {
        $path = "/storage";
        $path .= "/Project-" . $this->project->id;
        $path .= "/Category-" . $this->id;
        return $path;
    }
}
