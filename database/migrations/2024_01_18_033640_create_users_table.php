<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration {
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // creates an 'id' column that auto-increments
            $table->string('name'); // creates a 'name' column to store the user's name
            $table->timestamps(); // optional: creates 'created_at' and 'updated_at' columns
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
