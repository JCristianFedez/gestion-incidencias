<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    use HasFactory;

    public function category(){
        return $this->belongsTo("App\Models\Category");
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
}
