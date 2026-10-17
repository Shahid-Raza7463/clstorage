<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCapitallUploadArticleMay2023Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('capitall_upload_article_may_2023', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->integer('id', true, false);
            $table->string('emailid', 31)->nullable();
            $table->string('entity', 22)->nullable();
            $table->string('category', 10)->nullable();
            $table->dateTime('doj')->nullable();
            $table->string('year', 3)->nullable();
            $table->string('location', 6)->nullable();
            $table->integer('stipend')->nullable();
            $table->integer('totalnoofdays')->nullable();
            $table->integer('noofdayspresent')->nullable();
            $table->integer('leave')->nullable();
            $table->integer('co')->nullable();
            $table->integer('birthdayleave')->nullable();
            $table->integer('totaldaystobepaid')->nullable();
            $table->integer('totalstipend')->nullable();
            $table->integer('arrear')->nullable();
            $table->integer('amounttobepaid')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('capitall_upload_article_may_2023');
    }
}
