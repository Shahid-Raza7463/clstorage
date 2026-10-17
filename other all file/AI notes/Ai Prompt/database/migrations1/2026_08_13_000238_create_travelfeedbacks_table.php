<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTravelfeedbacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travelfeedbacks', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_general_ci';
            $table->integer('id', true, false);
            $table->integer('travelform_id')->nullable();
            $table->integer('mode_of_transport')->nullable();
            $table->text('mode_of_transportothers')->nullable();
            $table->integer('accomodation')->nullable();
            $table->text('accomodationothers')->nullable();
            $table->integer('experience')->nullable();
            $table->text('experienceothers')->nullable();
            $table->integer('createdby')->nullable();
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
        Schema::dropIfExists('travelfeedbacks');
    }
}
