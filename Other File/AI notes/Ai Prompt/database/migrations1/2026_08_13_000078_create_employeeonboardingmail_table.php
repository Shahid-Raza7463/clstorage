<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeonboardingmailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employeeonboardingmail', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->integer('id', true, false);
            $table->integer('employeeonboarding_id')->nullable();
            $table->string('name', 100)->nullable();
            $table->string('gender', 30)->nullable();
            $table->string('photograph', 255)->nullable();
            $table->string('designation', 100)->nullable();
            $table->string('degree', 255)->nullable();
            $table->string('Stream', 255)->nullable();
            $table->string('university', 255)->nullable();
            $table->string('location', 100)->nullable();
            $table->integer('exp_year')->nullable();
            $table->integer('exp_month')->nullable();
            $table->string('pre_org', 255)->nullable();
            $table->string('pre_des', 255)->nullable();
            $table->string('work_area', 255)->nullable();
            $table->string('hobbies', 255)->nullable();
            $table->string('off_email', 100)->nullable();
            $table->integer('status')->nullable();
            $table->binary('content')->nullable();
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
        Schema::dropIfExists('employeeonboardingmail');
    }
}
