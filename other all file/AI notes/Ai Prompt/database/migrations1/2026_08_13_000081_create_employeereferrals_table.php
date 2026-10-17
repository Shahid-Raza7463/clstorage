<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeereferralsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employeereferrals', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf16';
            $table->collation = 'utf16_croatian_ci';
            $table->integer('id', true, false);
            $table->string('Name', 100)->nullable();
            $table->string('Contact', 50)->nullable();
            $table->string('Position_Referred', 30)->nullable();
            $table->string('other', 255)->nullable();
            $table->string('attachresume', 255)->nullable();
            $table->string('Current_Organization', 100)->nullable();
            $table->string('Relationship', 255)->nullable();
            $table->string('Email', 100)->nullable();
            $table->string('Department', 100)->nullable();
            $table->string('Designation', 100)->nullable();
            $table->string('Comment', 255)->nullable();
            $table->string('feedback', 30)->nullable();
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
        Schema::dropIfExists('employeereferrals');
    }
}
