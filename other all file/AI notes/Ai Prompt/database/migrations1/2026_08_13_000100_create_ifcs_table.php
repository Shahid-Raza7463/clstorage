<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIfcsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ifcs', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_general_ci';
            $table->integer('id', true, false);
            $table->integer('ifcfolder_id')->nullable();
            $table->integer('client_id')->nullable();
            $table->string('control_number', 30)->nullable();
            $table->string('sub_process', 255)->nullable();
            $table->text('control_objective')->nullable();
            $table->text('identification_risk')->nullable();
            $table->text('as_is_control')->nullable();
            $table->string('fraud_risk', 255)->nullable();
            $table->string('risk_rating', 255)->nullable();
            $table->string('whether_key', 255)->nullable();
            $table->string('automated_manual', 255)->nullable();
            $table->string('preventive_detective', 255)->nullable();
            $table->string('control_frequency', 255)->nullable();
            $table->string('concerned_person', 255)->nullable();
            $table->integer('responsible_person')->nullable();
            $table->string('process_design_gap', 50)->nullable();
            $table->string('design_gap', 255)->nullable();
            $table->string('Methodology', 255)->nullable();
            $table->string('Result', 255)->nullable();
            $table->string('Remarks', 255)->nullable();
            $table->text('Recommendations')->nullable();
            $table->text('Management_Comments')->nullable();
            $table->integer('assign_member')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('status')->nullable();
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
        Schema::dropIfExists('ifcs');
    }
}
