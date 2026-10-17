<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePoliciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('policies', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf16';
            $table->collation = 'utf16_croatian_ci';
            $table->integer('id', true, false);
            $table->integer('folder_id')->nullable();
            $table->string('filename', 255)->nullable();
            $table->string('file', 255)->nullable();
            $table->string('descripation', 255)->nullable();
            $table->integer('markasacknowledge')->nullable();
            $table->integer('notify')->nullable();
            $table->string('date', 20)->nullable();
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
        Schema::dropIfExists('policies');
    }
}
