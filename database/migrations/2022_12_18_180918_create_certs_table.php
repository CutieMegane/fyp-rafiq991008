<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Storage;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
        Schema::connection('mongodb') -> create('certs', function ($collection) {
        });*/

        Schema::create('certs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('details')->nullable();
            $table->string('created_by');
            $table->string('hash')->unique();
            $table->string('imagepath');
            $table->string('stegopath')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Schema::connection('mongodb')-> dropIfExists('certs');
        Schema::dropIfExists('certs');
        Storage::deleteDirectory('public/images');
    }
};
