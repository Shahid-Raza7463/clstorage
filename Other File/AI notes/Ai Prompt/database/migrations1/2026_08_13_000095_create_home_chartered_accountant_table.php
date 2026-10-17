<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHomeCharteredAccountantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('home_chartered_accountant', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->charset = 'latin1';
            $table->collation = 'latin1_swedish_ci';
            $table->integer('sno', true, false);
            $table->string('name', 100)->nullable();
            $table->string('gender', 30)->nullable();
            $table->integer('interviewerone')->nullable();
            $table->integer('age')->nullable();
            $table->string('address', 200)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('contact_no', 10)->nullable();
            $table->integer('marks_12')->nullable();
            $table->integer('year_12')->nullable();
            $table->string('work_experience', 150)->nullable();
            $table->string('reference', 30)->nullable();
            $table->string('resume', 100)->nullable();
            $table->string('remarks', 200)->nullable();
            $table->dateTime('applied_on')->nullable();
            $table->boolean('status')->nullable();
            $table->string('feedbackone', 30)->nullable();
            $table->string('hrcomment', 255)->nullable();
            $table->integer('interviewertwo')->nullable();
            $table->integer('ratingone')->nullable();
            $table->integer('ratingtwo')->nullable();
            $table->string('jobprofile', 255)->nullable();
            $table->string('feedbacktwo', 30)->nullable();
            $table->integer('type')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->string('mrn_nro_cro_wro', 255)->nullable();
            $table->string('scheme', 255)->nullable();
            $table->string('highest_qualification', 100)->nullable();
            $table->string('other_certification_course', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('home_chartered_accountant');
    }
}
