<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCheckinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checkins', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->integer('id', true, false);
            $table->integer('teammember_id')->nullable();
            $table->string('checkin_from', 20)->nullable();
            $table->integer('month')->nullable();
            $table->string('typeval', 30)->nullable();
            $table->integer('client_id')->nullable();
            $table->bigInteger('assignment_id')->nullable();
            $table->string('place', 100)->nullable();
            $table->string('date', 20)->nullable();
            $table->string('time', 255);
            $table->string('checkout_time', 255)->nullable();
            $table->float('latitude')->nullable();
            $table->float('longitude')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('checkins');
    }
}
