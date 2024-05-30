<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('carreras', function (Blueprint $table) {
            $table->unsignedBigInteger('dispositivo_id');
            $table->foreign('dispositivo_id')->references('id')->on('dispositivos')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('carreras', function (Blueprint $table) {
            $table->dropForeign(['dispositivo_id']);
            $table->dropColumn('dispositivo_id');
        });
    }
};
