<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecruitmentformsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recruitmentforms', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf16';
            $table->collation = 'utf16_croatian_ci';
            $table->integer('id', true, false);
            $table->string('categoryname', 100)->nullable();
            $table->string('other', 50)->nullable();
            $table->string('type', 30);
            $table->integer('employee')->nullable();
            $table->string('required_experience', 255)->nullable();
            $table->string('assignment_project', 100)->nullable();
            $table->string('number_of_vacancies', 30)->nullable();
            $table->string('timeline', 255)->nullable();
            $table->string('priority', 30)->nullable();
            $table->string('detailed_Job_profile', 255)->nullable();
            $table->string('specific_skills', 100)->nullable();
            $table->string('status', 30)->nullable();
            $table->string('teammember_id', 30)->nullable();
            $table->integer('createdby')->nullable();
            $table->integer('organization_id')->nullable();
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
        Schema::dropIfExists('recruitmentforms');
    }
}
