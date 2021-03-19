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
}
