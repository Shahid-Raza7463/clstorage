<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_general_ci';
            $table->integer('id', true, false);
            $table->unsignedInteger('employee_name')->nullable();
            $table->string('employee_status', 30)->nullable();
            $table->string('dateofjoining', 20)->nullable();
            $table->string('twentysix', 50)->nullable();
            $table->string('twentyseven', 50)->nullable();
            $table->string('twentyeight', 50)->nullable();
            $table->string('twentynine', 50)->nullable();
            $table->string('thirty', 50)->nullable();
            $table->string('thirtyone', 50)->nullable();
            $table->string('one', 50)->nullable();
            $table->string('two', 50)->nullable();
            $table->string('three', 50)->nullable();
            $table->string('four', 50)->nullable();
            $table->string('five', 50)->nullable();
            $table->string('six', 50)->nullable();
            $table->string('seven', 50)->nullable();
            $table->string('eight', 50)->nullable();
            $table->string('nine', 50)->nullable();
            $table->string('ten', 50)->nullable();
            $table->string('eleven', 50)->nullable();
            $table->string('twelve', 50)->nullable();
            $table->string('thirteen', 50)->nullable();
            $table->string('fourteen', 50)->nullable();
            $table->string('fifteen', 50)->nullable();
            $table->string('sixteen', 50)->nullable();
            $table->string('seventeen', 50)->nullable();
            $table->string('eighteen', 50)->nullable();
            $table->string('ninghteen', 50)->nullable();
            $table->string('twenty', 50)->nullable();
            $table->string('twentyone', 50)->nullable();
            $table->string('twentytwo', 50)->nullable();
            $table->string('twentythree', 50)->nullable();
            $table->string('twentyfour', 50)->nullable();
            $table->string('twentyfive', 50)->nullable();
            $table->string('total_no_of_days', 15)->nullable();
            $table->string('no_of_days_present', 15)->nullable();
            $table->string('casual_leave', 200)->nullable();
            $table->string('unplanned_leave', 200)->nullable();
            $table->string('sick_leave', 200)->nullable();
            $table->string('comp_off', 200)->nullable();
            $table->string('birthday_religious', 15)->nullable();
            $table->integer('exam_leave')->default(0);
            $table->integer('absent')->default(0);
            $table->string('lwp', 200)->nullable();
            $table->integer('weekend')->nullable();
            $table->string('totaldaystobepaid', 15)->nullable();
            $table->string('comment', 200)->nullable();
            $table->string('month', 20)->nullable();
            $table->integer('year')->nullable();
            $table->integer('holidays')->nullable();
            $table->integer('travel')->nullable();
            $table->integer('offholidays')->nullable();
            $table->integer('sundaycount')->nullable();
            $table->date('fulldate')->nullable();
            $table->integer('beforejoiningcount')->default(0);
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
        Schema::dropIfExists('attendances');
    }
}
