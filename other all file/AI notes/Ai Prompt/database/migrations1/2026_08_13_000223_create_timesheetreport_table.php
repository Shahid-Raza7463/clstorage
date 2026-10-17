<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimesheetreportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timesheetreport', function (Blueprint $table) {
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
            $table->integer('dayscount')->nullable()->default(0);
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
        Schema::dropIfExists('timesheetreport');
    }
}
