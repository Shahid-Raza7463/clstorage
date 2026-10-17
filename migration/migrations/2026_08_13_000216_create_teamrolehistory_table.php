<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamrolehistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teamrolehistory', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_general_ci';
            $table->integer('id', true, false);
            $table->unsignedInteger('teammember_id');
            $table->integer('roleid_old')->nullable();
            $table->integer('roleid_new')->nullable();
            $table->string('oldstaff_code', 30)->nullable();
            $table->string('newstaff_code', 30)->nullable();
            $table->string('old_staffcodenumber', 30)->nullable();
            $table->string('new_staffcodenumber', 30)->nullable();
            $table->date('promotion_date')->nullable();
            $table->timestamp('promotioncreated')->nullable();
            $table->date('rejoiningdate')->nullable();
            $table->string('rejoiniedexitdate', 20)->nullable();
            $table->dateTime('rejoiningcreated')->nullable();
            $table->integer('rejointimesheetstatus')->nullable()->default(0);
            $table->string('change_type', 30)->nullable();
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
        Schema::dropIfExists('teamrolehistory');
    }
}
