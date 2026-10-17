<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeavetypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leavetypes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf16';
            $table->collation = 'utf16_croatian_ci';
            $table->integer('id', true, false);
            $table->integer('year')->nullable();
            $table->string('name', 100)->nullable();
            $table->integer('holiday')->nullable();
            $table->string('color', 255)->nullable();
            $table->string('code', 30)->nullable();
            $table->string('type', 30)->nullable();
            $table->string('unit', 255)->nullable();
            $table->string('Fixed', 255)->nullable();
            $table->string('description', 255)->nullable();
            $table->string('startdate', 20)->nullable();
            $table->string('enddate', 20)->nullable();
            $table->string('effective', 255)->nullable();
            $table->string('effective1', 255)->nullable();
            $table->string('effective2', 255)->nullable();
            $table->integer('leavetypemonth')->nullable();
            $table->integer('leavetypedays')->nullable();
            $table->integer('leavetypemonthly')->nullable();
            $table->string('noofdays', 11)->nullable();
            $table->string('Accrualtype', 30)->nullable();
            $table->string('Leavegrant', 100)->nullable();
            $table->integer('Accrual')->nullable();
            $table->string('gender', 30)->nullable();
            $table->string('martialstatus', 30)->nullable();
            $table->integer('role')->nullable();
            $table->string('allow_past_days', 15)->nullable();
            $table->string('allowfuture_date', 20)->nullable();
            $table->string('notificationdate', 255)->nullable();
            $table->string('notificationdate1', 255)->nullable();
            $table->unsignedInteger('createdby')->nullable();
            $table->unsignedInteger('updatedby')->nullable();
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
        Schema::dropIfExists('leavetypes');
    }
}
