<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIlranswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ilranswers', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigInteger('id', true, true);
            $table->integer('informationresource_id')->nullable();
            $table->integer('move')->nullable();
            $table->string('url', 255)->nullable();
            $table->text('remark')->nullable();
            $table->text('Reviewersmarks')->nullable();
            $table->integer('updateby')->nullable();
            $table->integer('clientlogin_id')->nullable();
            $table->string('particular', 255)->nullable();
            $table->string('statusicon', 30)->nullable();
            $table->integer('status')->nullable();
            $table->string('filedate', 100)->nullable();
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
        Schema::dropIfExists('ilranswers');
    }
}
