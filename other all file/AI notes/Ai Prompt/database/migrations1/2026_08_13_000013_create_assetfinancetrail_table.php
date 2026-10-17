<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetfinancetrailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assetfinancetrail', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'latin1';
            $table->collation = 'latin1_swedish_ci';
            $table->integer('id', true, false);
            $table->integer('createdby')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->string('pagetitle', 50)->nullable();
            $table->integer('pageid')->nullable();
            $table->string('type', 30)->nullable();
            $table->string('description', 255)->nullable();
            $table->string('amount', 30)->nullable();
            $table->string('bill', 255)->nullable();
            $table->string('vendor', 100)->nullable();
            $table->string('refrence', 30)->nullable();
            $table->string('problem', 255)->nullable();
            $table->string('solution', 255)->nullable();
            $table->string('comment', 255)->nullable();
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
        Schema::dropIfExists('assetfinancetrail');
    }
}
