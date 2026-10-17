<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDebtorbatchshareTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('debtorbatchshare', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->integer('id', true, false);
            $table->bigInteger('batchid')->nullable();
            $table->string('name', 100)->nullable();
            $table->string('phone', 15)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('otp', 30)->nullable();
            $table->string('otp_expires_at', 30)->nullable();
            $table->string('verification_token', 255)->nullable();
            $table->string('session_active_until', 255)->nullable();
            $table->string('last_verified_at', 255)->nullable();
            $table->unsignedInteger('createdby')->nullable();
            $table->integer('status')->nullable()->default(1);
            $table->integer('accessstatus')->default(0);
            $table->unsignedInteger('revokeby')->nullable();
            $table->string('accessdate', 20)->nullable();
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
        Schema::dropIfExists('debtorbatchshare');
    }
}
