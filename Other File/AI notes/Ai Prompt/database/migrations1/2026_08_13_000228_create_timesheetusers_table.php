<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimesheetusersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timesheetusers', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf16';
            $table->collation = 'utf16_croatian_ci';
            $table->integer('id', true, false);
            $table->integer('timesheetid')->nullable();
            $table->integer('client_id')->nullable();
            $table->string('assignmentgenerate_id', 30)->nullable()->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->integer('partner')->nullable();
            $table->string('totalhour', 11)->nullable();
            $table->integer('assignment_id')->nullable();
            $table->string('project_id', 30)->nullable();
            $table->string('date', 20)->nullable();
            $table->string('job_id', 30)->nullable();
            $table->string('workitem', 255)->nullable();
            $table->string('location', 100)->nullable();
            $table->string('billable_status', 30)->nullable();
            $table->string('description', 255)->nullable();
            $table->integer('status')->default(0);
            $table->string('hour', 30)->nullable();
            $table->integer('createdby')->nullable();
            $table->integer('rejectedby')->nullable();
            $table->integer('updatedby')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('timesheetusers');
    }
}
