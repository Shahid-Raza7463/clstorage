<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlepayrollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articlepayrolls', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_general_ci';
            $table->integer('id', true, false);
            $table->string('emailid', 31)->nullable();
            $table->string('month', 20)->nullable();
            $table->string('entity', 100)->nullable();
            $table->string('location', 50)->nullable();
            $table->string('category', 50)->nullable();
            $table->string('doj', 20)->nullable();
            $table->string('year', 20)->nullable();
            $table->string('stipend', 11)->nullable();
            $table->string('totalnoofdays', 11)->nullable();
            $table->string('noofdayspresent', 11)->nullable();
            $table->string('leave', 11)->nullable();
            $table->integer('el')->nullable();
            $table->string('co', 11)->nullable();
            $table->string('birthdayleave', 11)->nullable();
            $table->string('totaldaystobepaid', 11)->nullable();
            $table->string('totalstipend', 11)->nullable();
            $table->string('arrear', 11)->nullable();
            $table->string('amounttobepaid', 11)->nullable();
            $table->integer('neftstatus')->nullable();
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
        Schema::dropIfExists('articlepayrolls');
    }
}
