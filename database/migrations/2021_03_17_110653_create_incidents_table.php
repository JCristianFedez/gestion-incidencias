<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncidentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incidents', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->string("description");
            $table->string("severity",1);
            $table->boolean("active")->default(1);

            $table->timestamps();
        });
        Schema::table("incidents", function (Blueprint $table){
            
            //Clave foranea a categoria
            $table->unsignedBigInteger("category_id")->nullable();
            $table->foreign("category_id")->references("id")->on("categories");

            //Clave foranea a projects
            $table->unsignedBigInteger("project_id")->nullable();
            $table->foreign("project_id")->references("id")->on("projects");

            //Clave foranea a levels
            $table->unsignedBigInteger("level_id")->nullable();
            $table->foreign("level_id")->references("id")->on("levels");

            //Clave foranea a users, que tiene una incidencia
            $table->unsignedBigInteger("client_id");
            $table->foreign("client_id")->references("id")->on("users");
            
            //Clave foranea a users, que resuelve una incidencia
            $table->unsignedBigInteger("support_id")->nullable();
            $table->foreign("support_id")->references("id")->on("users");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('incidents');
    }
}
