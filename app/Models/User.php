<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    // Relationships
    public function projects(){
        return $this->belongsToMany("App\Models\Project");
    }


    /**
     * Devuelve true si el nivel de la incidencia y del usuario
     * son el mismo
     */
    public function canTake(Incident $incident){
        return ProjectUser::where("user_id",$this->id)
                ->where("level_id",$incident->level_id)
                ->first();
    }


    // Accesors

    /**
     * Devuelve la lista de projectos dependiendo del rol de usuario
     */
    public function getListOfProjectsAttribute(){

        if($this->role == 1){ //0: Admin | 1: Support | 2: Client
            return $this->projects;
        }
        
        return Project::all();
    }

    /**
     * Devuelve true si es admin
     */
    public function getIsAdminAttribute(){
        return $this->role == 0;
    }

    /**
     * Devuelve true si es cliente
     */
    public function getIsClientAttribute(){
        return $this->role == 2;
    }

    /**
     * Devuelve true si es support
     */
    public function getIsSupportAttribute(){
        return $this->role == 1;
    }

    /**
     * Devuelve la ruta de la imagen de avatar
     */
    public function getAvatarPathAttribute(){
        if($this->is_client){
            return "/images/client.png";
        }
        return "/images/support.png";
    }

    /**
     * Return full name of the severity
     */
    public function getRoleNameAttribute(){
        switch ($this->role) {
            case 0:
                return "Admin";
                break;
            case 1:
                return "Support";
                break;
            case 2:
                return "Cliente";
                break;
            default:
                return "Desconocido";
                break;
        }
    }

}
