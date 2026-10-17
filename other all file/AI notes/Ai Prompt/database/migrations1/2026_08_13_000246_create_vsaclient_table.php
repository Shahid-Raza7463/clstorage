<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVsaclientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vsaclient', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->integer('id')->nullable();
            $table->string('client_name', 42)->nullable();
            $table->string('c_address', 130)->nullable();
            $table->string('legalstatus', 13)->nullable();
            $table->string('panno', 11)->nullable();
            $table->string('tanno', 10)->nullable();
            $table->string('gstno', 15)->nullable();
            $table->integer('status')->nullable();
            $table->integer('classification')->nullable();
            $table->integer('client_code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vsaclient');
    }
}
