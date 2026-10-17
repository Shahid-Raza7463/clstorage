<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimesheetrequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timesheetrequests', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_general_ci';
            $table->integer('id', true, false);
            $table->bigInteger('client_id')->nullable();
            $table->integer('assignment_id')->nullable();
            $table->unsignedInteger('partner')->nullable();
            $table->text('reason')->nullable();
            $table->unsignedInteger('createdby')->nullable();
            $table->integer('status')->nullable();
            $table->string('validate', 20)->nullable();
            $table->string('remark', 255)->nullable();
            $table->string('attachment', 255)->nullable();
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
        Schema::dropIfExists('timesheetrequests');
    }
}
