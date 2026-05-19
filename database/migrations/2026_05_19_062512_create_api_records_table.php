<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApiRecordsTable extends Migration
{
    public function up()
    {
        Schema::create('api_records', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('name');
            $table->text('description')->nullable();
            $table->boolean('active')->default(true);
            $table->integer('crew_capacity')->nullable();
            $table->json('api_response');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('api_records');
    }
}