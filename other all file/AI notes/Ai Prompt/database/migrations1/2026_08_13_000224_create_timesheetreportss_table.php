<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimesheetreportssTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timesheetreportss', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'latin1';
            $table->collation = 'latin1_swedish_ci';
            $table->integer('id', true, false);
            $table->integer('teamid')->nullable();
            $table->string('week', 50)->nullable();
            $table->integer('totaldays')->nullable();
            $table->integer('totaltime')->nullable();
            $table->string('startdate', 20)->nullable();
            $table->string('enddate', 20)->nullable();
            $table->integer('partnerid')->nullable();
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
        Schema::dropIfExists('timesheetreportss');
    }
}
