<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopsTable extends Migration
{
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->string('shop_name');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('area_id')->constrained()->onDelete('restrict');
            $table->foreignId('genre_id')->constrained()->onDelete('restrict');
            $table->string('overview', 300);
            $table->string('img');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('shops');
    }
}
