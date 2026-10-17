<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->integer('id', true, false);
            $table->integer('teammember_id')->nullable();
            $table->integer('role_id')->nullable();
            $table->text('fcm')->nullable();
            $table->string('email', 100);
            $table->string('passwordResetToken', 255)->nullable();
            $table->string('passwordResetExpiresAt', 20)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 100);
            $table->integer('status')->nullable();
            $table->string('remember_token', 100)->nullable();
            $table->integer('two_factor_code')->nullable();
            $table->integer('otp')->nullable();
            $table->dateTime('two_factor_expires_at')->nullable();
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
        Schema::dropIfExists('users');
    }
}
