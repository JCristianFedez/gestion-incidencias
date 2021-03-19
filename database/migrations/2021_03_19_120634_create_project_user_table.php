<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_user', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });

        Schema::table("project_user", function (Blueprint $table){
            
            //Clave foranea a projects
            $table->unsignedBigInteger("project_id");
            $table->foreign("project_id")->references("id")->on("projects");

            //Clave foranea a users
            $table->unsignedBigInteger("user_id");
            $table->foreign("user_id")->references("id")->on("users");

            //Clave foranea a levels
            $table->unsignedBigInteger("level_id");
            $table->foreign("level_id")->references("id")->on("levels");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_user');
    }
}
