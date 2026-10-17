<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAtrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('atrs', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf16';
            $table->collation = 'utf16_croatian_ci';
            $table->integer('id', true, false);
            $table->integer('client_id')->nullable();
            $table->string('fy', 100)->nullable();
            $table->string('quarter', 100)->nullable();
            $table->string('area', 255)->nullable();
            $table->text('observations')->nullable();
            $table->text('management_comments')->nullable();
            $table->string('risk', 255)->nullable();
            $table->integer('responsible_person')->nullable();
            $table->string('duedate_for_closure', 20)->nullable();
            $table->string('attachments', 255)->nullable();
            $table->string('auditors_final_comments', 255)->nullable();
            $table->integer('status')->nullable();
            $table->integer('createdby')->nullable();
            $table->string('further_remarks', 255)->nullable();
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
        Schema::dropIfExists('atrs');
    }
}
