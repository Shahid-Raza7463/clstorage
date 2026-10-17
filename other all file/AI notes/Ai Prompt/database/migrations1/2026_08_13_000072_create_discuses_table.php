<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discuses', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf16';
            $table->collation = 'utf16_croatian_ci';
            $table->integer('id', true, false);
            $table->string('topic', 255)->nullable();
            $table->longText('description')->nullable();
            $table->string('discuss_with', 255)->nullable();
            $table->integer('relatedto');
            $table->integer('related_id')->nullable();
            $table->integer('related_ids')->nullable();
            $table->integer('client_id')->nullable();
            $table->string('other', 255)->nullable();
            $table->integer('status')->nullable();
            $table->integer('createdby')->nullable();
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
        Schema::dropIfExists('discuses');
    }
}
