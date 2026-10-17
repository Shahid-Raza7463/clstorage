<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMissubmitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('missubmits', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'latin1';
            $table->collation = 'latin1_swedish_ci';
            $table->integer('id', true, false);
            $table->string('missno', 30)->nullable();
            $table->text('remarks')->nullable();
            $table->string('serailno', 30)->nullable();
            $table->text('remark')->nullable();
            $table->string('submissiondate', 50)->nullable();
            $table->integer('createdby')->nullable();
            $table->integer('clientloginid')->nullable();
            $table->integer('updatedby')->nullable();
            $table->integer('status')->nullable();
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
        Schema::dropIfExists('missubmits');
    }
}
