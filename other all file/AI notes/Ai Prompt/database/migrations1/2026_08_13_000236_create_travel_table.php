<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTravelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travel', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'latin1';
            $table->collation = 'latin1_swedish_ci';
            $table->integer('id', true, false);
            $table->integer('teammember_id')->nullable();
            $table->string('EmployeeID', 30)->nullable();
            $table->integer('client_id')->nullable();
            $table->integer('assignment_id')->nullable();
            $table->integer('assignmentgenerate_id')->nullable();
            $table->string('Nature_of_Assignment', 100)->nullable();
            $table->string('Place_of_visit', 100)->nullable();
            $table->string('Purpose_of_visit', 255)->nullable();
            $table->string('Expected_date_of_arrival', 20)->nullable();
            $table->string('Expected_date_of_departure', 20)->nullable();
            $table->string('Expected_duration_in_days', 15)->nullable();
            $table->integer('Billable')->nullable();
            $table->string('chooseconveyance', 100)->nullable();
            $table->string('Travel_arrangement', 255)->nullable();
            $table->string('Train_Flight', 255)->nullable();
            $table->string('Food', 100)->nullable();
            $table->string('Conveyance', 100)->nullable();
            $table->string('Other', 255)->nullable();
            $table->string('total', 30)->nullable();
            $table->string('Advance_Amount', 30)->nullable();
            $table->integer('Status')->nullable();
            $table->integer('travelstatus')->nullable();
            $table->integer('createdby')->nullable();
            $table->integer('updatedby')->nullable();
            $table->text('comment')->nullable();
            $table->string('remark', 255)->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->integer('advanceamount')->nullable();
            $table->integer('adjust')->nullable();
            $table->integer('adjustablestatus')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('travel');
    }
}
