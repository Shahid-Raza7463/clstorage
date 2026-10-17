<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'latin1';
            $table->collation = 'latin1_swedish_ci';
            $table->integer('id', true, false);
            $table->integer('teammember_id')->nullable();
            $table->integer('relatedto')->nullable();
            $table->bigInteger('assignment_id')->nullable();
            $table->integer('kgsclient_id')->nullable();
            $table->integer('dataroomclient_id')->nullable();
            $table->string('other', 255)->nullable();
            $table->integer('supportby')->nullable();
            $table->text('taskname')->nullable();
            $table->string('file', 100)->nullable();
            $table->string('attachment', 255)->nullable();
            $table->text('description')->nullable();
            $table->string('duedate', 20)->nullable();
            $table->text('remark')->nullable();
            $table->string('reminder', 50)->nullable();
            $table->integer('status')->nullable();
            $table->integer('createdby')->nullable();
            $table->integer('client_id')->nullable();
            $table->string('priority', 30)->nullable();
            $table->integer('task_type')->nullable();
            $table->string('amount', 30)->nullable();
            $table->text('addtional_details')->nullable();
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
        Schema::dropIfExists('tasks');
    }
}
