<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePbdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pbds', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'latin1';
            $table->collation = 'latin1_swedish_ci';
            $table->integer('id', true, false);
            $table->string('Date_of_Successful_Call', 20)->nullable();
            $table->string('Contact_Name', 50)->nullable();
            $table->string('company', 50)->nullable();
            $table->string('Designation', 50)->nullable();
            $table->string('minutes_of__the_meeting', 50)->nullable();
            $table->string('short_time_business', 50)->nullable();
            $table->string('Indicative_date_for_next_follow_up', 20)->nullable();
            $table->integer('createdby')->nullable();
            $table->integer('updatedby')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pbds');
    }
}
