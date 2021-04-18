<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    public static $rules = [
        'name' => ['required',"min:5","max:255"],
        'description' => ["required","min:15","max:255"],
        'start' => 'date'
    ];

    public static $messages = [
        'name.required' => 'Es necesario ingresar un nombre para el proyecto.',
        'name.min' => "El nombre del proyecto debe de contener un minimo de 5 caracteres",
        'name.max' => "El nombre del proyecto debe de contener un maximo de 255 caracteres",
        'description.required' => "Es necesario ingresar una descripccion valida",
        'description.min' => "La descripccion debe de contener un minimo de 15 caracteres",
        'description.max' => "La descripccion debe de contener un maximo de 255 caracteres",
        'start.date' => 'La fecha no tiene un formato adecuado.'
    ];

    protected $fillable = [
        'name', 'description', 'start'
    ];

    // Para filtar por nombre | Sustituido por DataTables
    // public static function scopeSearchName($query, $scope=""){
    //     return $query->where("name","like","%$scope%");
    // }

    // Relationships
    public function categories(){
        return $this->hasMany("App\Models\Category");
    }

    public function levels(){
        return $this->hasMany("App\Models\Level")->orderBy('difficulty');
    }

    public function users(){
        return $this->belongsToMany("App\Models\User");
    }

    // Accesors
    public function getFirstLevelIdAttribute(){
        if($this->levels->first())
            return $this->levels->first()->id;
        
        return null;
    }

    public function getStatusAttribute(){
        if($this->trashed()){
            return "Inactivo";
        }else{
            return "Activo";
        }
    }

        /**
     * @return String Returns a string with the path of the public directory
     */
    public function getPublicDirectoryPathAttribute(){
        $path = "/public";
        $path .= "/Project-".$this->name;
        return $path;
    }
}
