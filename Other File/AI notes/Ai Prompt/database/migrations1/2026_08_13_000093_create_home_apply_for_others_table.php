<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHomeApplyForOthersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('home_apply_for_others', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->charset = 'latin1';
            $table->collation = 'latin1_swedish_ci';
            $table->integer('sno', true, false);
            $table->string('name', 100);
            $table->string('address', 200);
            $table->string('email', 100);
            $table->string('contact_no', 10);
            $table->string('qualification', 100);
            $table->string('position_applied', 100);
            $table->string('work_experience', 150);
            $table->string('resume', 100);
            $table->dateTime('applied_on');
            $table->boolean('status');
            $table->string('mrn_nro_cro_wro', 255)->nullable();
            $table->integer('age')->nullable();
            $table->string('scheme', 255)->nullable();
            $table->string('jobprofile', 255)->nullable();
            $table->string('highest_qualification', 100)->nullable();
            $table->string('other_certification_course', 100)->nullable();
            $table->string('reference', 30)->nullable();
            $table->string('hrcomment', 255)->nullable();
            $table->integer('type')->nullable();
            $table->string('interviewerone', 255)->nullable();
            $table->string('interviewertwo', 11)->nullable();
            $table->integer('ratingone')->nullable();
            $table->integer('ratingtwo')->nullable();
            $table->text('feedbackone')->nullable();
            $table->text('feedbacktwo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('home_apply_for_others');
    }
}
