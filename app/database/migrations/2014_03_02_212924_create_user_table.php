<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
            Schema::create("users", function($table){
               
                    $table->increments('id');
                    $table->string('username');
                    $table->string('email');
                    $table->string('code');
                    $table->boolean('isAdmin');
                    $table->string('temp_password');
                    $table->string('password');
                    $table->boolean('enabled');
                    $table->timestamps();
                
            });
            
            
            Schema::create("machines", function(Blueprint $table)
                {
                    $table->increments('id');
                    $table->boolean('isActive');
                    $table->timestamps();
                    $table->text('description');
                    $table->string("name");
                });
            
           Schema::create("mpictures", function($table){
              
               $table->increments('id');
               $table->integer('machine_id')->references('id')->on('machines')->onDelete('cascade');
               $table->text('pic_url');
               $table->timestamps();

               
           }); 
                
                
            Schema::create("scores", function($table)
                {
                    $table->increments('id');
                    $table->timestamps();
                    $table->text('picture_url');
                    $table->integer('score');
                    $table->integer('user_id')->references('id')->on('users')->onDelete('cascade');
                    $table->integer('machine_id')->references('id')->on('machines');
                    
                    
                });
                
            
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop("users");
                Schema::drop("scores");
                Schema::drop("machines");
                Schema::drop("mpictures");
	}

}
