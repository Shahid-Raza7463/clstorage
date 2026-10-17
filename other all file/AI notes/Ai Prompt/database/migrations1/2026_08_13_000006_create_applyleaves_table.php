<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplyleavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applyleaves', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf16';
            $table->collation = 'utf16_croatian_ci';
            $table->integer('id', true, false);
            $table->string('leavetype', 30)->nullable();
            $table->integer('type')->nullable();
            $table->integer('examtype')->nullable();
            $table->string('otherexam', 255)->nullable();
            $table->string('from', 20)->nullable();
            $table->string('to', 20)->nullable();
            $table->string('report', 255)->nullable();
            $table->string('reasonleave', 255)->nullable();
            $table->text('remark')->nullable();
            $table->integer('approver')->nullable();
            $table->integer('createdby')->nullable();
            $table->integer('status')->nullable();
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
        Schema::dropIfExists('applyleaves');
    }
}
