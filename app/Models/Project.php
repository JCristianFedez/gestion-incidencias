<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    public static $rules = [
        'name' => 'required',
        // 'description' => '',
        'start' => 'date'
    ];

    public static $messages = [
        'name.required' => 'Es necesario ingresar un nombre para el proyecto.',
        'start.date' => 'La fecha no tiene un formato adecuado.'
    ];

    protected $fillable = [
        'name', 'description', 'start'
    ];

    // Relationships
    public function categories(){
        return $this->hasMany("App\Models\Category");
    }

    public function levels(){
        return $this->hasMany("App\Models\Level");
    }

    public function users(){
        return $this->belongsToMany("App\Models\User");
    }

    // Accesors
    public function getFirstLevelIdAttribute(){
        return $this->levels->first()->id;
    }
}
