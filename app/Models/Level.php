<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Level extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "name",
        "project_id",
        "difficulty"
    ];

    public function project(){
        return $this->belongsTo("App\Models\Project");
    }

    // public function category(){
    //     return $this->belongsTo("App\Models\Category");
    // }

    /**
     * Devuelve el siguiente nivel
     */
    public function getNextLevelAttribute(){
        $project = $this->project;

        if($this->difficulty == null){
            $nextLevel = Level::where("project_id",$project->id)->where("difficulty",1)->first();
            
            return $nextLevel;
        }

        $nextLevel = Level::where("project_id",$project->id)->where("difficulty",($this->difficulty+1))->first();
        
        return $nextLevel;
    }

    /**
     * Devuelve el nivel anterior
     */
    public function getPreviousLevelAttribute(){
        $project = $this->project;

        if($this->difficulty == null){
            $nextLevel = Level::where("project_id",$project->id)->where("difficulty",1)->first();
            
            return $nextLevel;
        }

        $nextLevel = Level::where("project_id",$project->id)->where("difficulty",($this->difficulty-1))->first();
        
        return $nextLevel;
    }

}
