<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectUser extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "project_user";

    public function project(){
        return $this->belongsTo("App\Models\Project");
    }

    public function level(){
        return $this->belongsTo("App\Models\Level");
    }

    public function getStatusAttribute(){
        if($this->trashed()){
            return "Inactivo";
        }else{
            return "Activo";
        }
    }
}
