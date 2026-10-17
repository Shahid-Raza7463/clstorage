<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignmentfolderfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assignmentfolderfiles', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'latin1';
            $table->collation = 'latin1_swedish_ci';
            $table->integer('id', true, false);
            $table->integer('assignmentfolder_id')->nullable();
            $table->string('assignmentgenerateid', 30)->nullable();
            $table->string('particular', 150)->nullable();
            $table->string('filesname', 150)->nullable();
            $table->string('realname', 100)->nullable();
            $table->string('filesize', 100)->nullable();
            $table->integer('createdby')->nullable();
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('assignmentfolderfiles');
    }
}
