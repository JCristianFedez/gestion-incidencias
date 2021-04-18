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

    public function project(){
        return $this->belongsTo("App\Models\Project");
    }


    /**
     * @return String Returns a string with the path of the public directory
     */
    public function getPublicDirectoryPathAttribute(){
        $path = "/public";
        $path .= "/Project-".$this->project->name;
        $path .= "/Category-".$this->name;
        return $path;
    }
}
