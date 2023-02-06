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
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('details')->nullable();
            $table->string('email')->nullable();
            $table->string('phone_no')->nullable();
            $table->string('created_by');
            $table->string('hash')->unique();
            $table->string('imagepath');
            $table->string('stego_mark')->nullable();
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
