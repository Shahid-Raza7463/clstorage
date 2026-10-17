<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHomeInternshipTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('home_internship', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->charset = 'latin1';
            $table->collation = 'latin1_swedish_ci';
            $table->integer('sno', true, false);
            $table->string('project_name', 100);
            $table->string('name', 100);
            $table->string('gender', 30);
            $table->date('dob');
            $table->string('address', 200);
            $table->string('email', 100);
            $table->string('contact_no', 10);
            $table->string('school_name', 100);
            $table->integer('year_12');
            $table->string('stream', 50);
            $table->string('ug_course', 50);
            $table->string('ug_institute', 200);
            $table->integer('ug_year');
            $table->string('pg_course', 50);
            $table->string('pg_institute', 200);
            $table->integer('pg_year');
            $table->string('professional_qualifications', 100);
            $table->string('work_experience', 150);
            $table->string('volunteer_work', 150);
            $table->string('skills', 100);
            $table->string('past_internship', 150);
            $table->string('interest_field', 150);
            $table->string('resume', 100);
            $table->dateTime('applied_on');
            $table->boolean('status');
            $table->integer('interviewerone')->nullable();
            $table->string('mrn_nro_cro_wro', 100)->nullable();
            $table->integer('age')->nullable();
            $table->string('highest_qualification', 100)->nullable();
            $table->string('interviewertwo', 255)->nullable();
            $table->string('jobprofile', 255)->nullable();
            $table->integer('type')->nullable();
            $table->string('hrcomment', 255)->nullable();
            $table->text('feedbackone')->nullable();
            $table->text('feedbacktwo')->nullable();
            $table->integer('ratingone');
            $table->integer('ratingtwo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('home_internship');
    }
}
