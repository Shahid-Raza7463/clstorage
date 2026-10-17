<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignmentevaluationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assignmentevaluations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf16';
            $table->collation = 'utf16_croatian_ci';
            $table->integer('id', true, false);
            $table->string('date_of_joining', 20)->nullable();
            $table->integer('clients_name')->nullable();
            $table->integer('nature_of_assignment')->nullable();
            $table->string('assignmentgenerate_id', 30)->nullable();
            $table->integer('assignment_partner')->nullable();
            $table->string('start_date_of_assignment', 20)->nullable();
            $table->string('end_date_of_assignment', 20)->nullable();
            $table->string('total_assignment_hours', 30)->nullable();
            $table->string('assignment_date_record', 20)->nullable();
            $table->string('level_of_complexity', 100)->nullable();
            $table->string('difficulties_assignment', 100)->nullable();
            $table->string('issues_team', 100)->nullable();
            $table->string('conveyance_request', 100)->nullable();
            $table->string('document_policies', 100)->nullable();
            $table->string('record_keeper', 100)->nullable();
            $table->string('staff_record_keeper', 100)->nullable();
            $table->string('team_leader_signed', 100)->nullable();
            $table->integer('assignment_report_manager')->nullable();
            $table->string('technical_knowledge', 100)->nullable();
            $table->string('general_awareness', 100)->nullable();
            $table->string('planning_organizing', 100)->nullable();
            $table->string('job_management', 100)->nullable();
            $table->string('written_communication', 100)->nullable();
            $table->string('verbal_communication', 100)->nullable();
            $table->string('teamwork', 100)->nullable();
            $table->string('motivation', 100)->nullable();
            $table->string('maturity', 100)->nullable();
            $table->string('time_consciousness', 100)->nullable();
            $table->string('problem_solving', 100)->nullable();
            $table->string('documentation', 100)->nullable();
            $table->string('qualityofwork', 100)->nullable();
            $table->string('achievement_of_tasks_targets', 100)->nullable();
            $table->string('initiative_displayed', 100)->nullable();
            $table->integer('rate_over_all_performance')->nullable();
            $table->integer('RateOver')->nullable();
            $table->string('areas_performed_extremely', 100)->nullable();
            $table->string('areas_needs_improvement', 100)->nullable();
            $table->string('training_needs', 100)->nullable();
            $table->integer('status')->nullable();
            $table->integer('createdby')->nullable();
            $table->string('approveddate', 20)->nullable();
            $table->integer('rate_over_all_performance_partner')->nullable();
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
        Schema::dropIfExists('assignmentevaluations');
    }
}
