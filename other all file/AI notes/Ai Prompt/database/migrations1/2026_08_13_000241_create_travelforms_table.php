<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTravelformsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travelforms', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf16';
            $table->collation = 'utf16_croatian_ci';
            $table->integer('id', true, false);
            $table->string('client_id', 30)->nullable();
            $table->string('assignment', 100)->nullable();
            $table->string('partener', 100)->nullable();
            $table->string('mode_of_transport', 30)->nullable();
            $table->string('budget', 30)->nullable();
            $table->string('flightfood1', 100)->nullable();
            $table->string('destination', 100)->nullable();
            $table->string('duration_from', 30)->nullable();
            $table->string('duration_to', 30)->nullable();
            $table->string('teammember_designation', 100)->nullable();
            $table->string('accomodation', 255)->nullable();
            $table->integer('no_of_hotel_type')->nullable();
            $table->integer('no_of_rooms')->nullable();
            $table->string('hotellocation', 100)->nullable();
            $table->string('hotel_budget', 30)->nullable();
            $table->string('hotel_from', 20)->nullable();
            $table->string('hotel_to', 20)->nullable();
            $table->integer('meal_plan')->nullable();
            $table->integer('travelstatus')->nullable();
            $table->string('remark', 255)->nullable();
            $table->integer('createdby')->nullable();
            $table->integer('billedtoclient')->nullable();
            $table->integer('updatedby')->nullable();
            $table->integer('feedback')->nullable();
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
        Schema::dropIfExists('travelforms');
    }
}
