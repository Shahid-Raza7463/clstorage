<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHolidaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('holidays', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf16';
            $table->collation = 'utf16_croatian_ci';
            $table->integer('id', true, false);
            $table->string('holidayname', 100)->nullable();
            $table->string('startdate', 20)->nullable();
            $table->string('enddate', 20)->nullable();
            $table->string('restricted', 255)->nullable();
            $table->string('description', 255)->nullable();
            $table->string('number_of_dates', 20)->nullable();
            $table->integer('year')->nullable();
            $table->string('notify', 255)->nullable();
            $table->string('status', 30)->nullable();
            $table->integer('createdby')->nullable();
            $table->integer('updatedby')->nullable();
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
        Schema::dropIfExists('holidays');
    }
}
