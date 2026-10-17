<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternalauditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internalaudits', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'latin1';
            $table->collation = 'latin1_swedish_ci';
            $table->integer('id', true, false);
            $table->string('Audit_Ref', 30)->nullable();
            $table->string('Audit_Report', 100)->nullable();
            $table->double('Report_Year')->nullable();
            $table->string('Report_Rating', 100)->nullable();
            $table->string('Report_Issue_Date', 20)->nullable();
            $table->double('YearMonth')->nullable();
            $table->double('Finding_Ref')->nullable();
            $table->double('Finding')->nullable();
            $table->string('Sub_Action', 30)->nullable();
            $table->string('Finding_Description', 100)->nullable();
            $table->string('Finding_Rating', 100)->nullable();
            $table->string('Recommendation', 100)->nullable();
            $table->string('Management_Action', 30)->nullable();
            $table->string('Responsible_Owner', 100)->nullable();
            $table->string('Entity', 100)->nullable();
            $table->string('Business_Unit', 100)->nullable();
            $table->string('Due_Date', 20)->nullable();
            $table->string('Extended_Date', 20)->nullable();
            $table->string('No_Extensions', 100)->nullable();
            $table->string('Status', 30)->nullable();
            $table->string('Management_Update', 20)->nullable();
            $table->string('Update_provided', 20)->nullable();
            $table->string('Date_of_last_update', 20)->nullable();
            $table->string('Reporting_Month', 20)->nullable();
            $table->string('Ageing_against_original_due_date', 20)->nullable();
            $table->string('Internal_Audit_Comment', 100)->nullable();
            $table->string('Date_Closed', 20)->nullable();
            $table->double('Closed_YearMonth')->nullable();
            $table->string('Reason_for_closure', 100)->nullable();
            $table->string('Management_Sign_Off_Provided', 100)->nullable();
            $table->string('Management_Sign_Off_Link', 100)->nullable();
            $table->string('Supporting_Evidence', 100)->nullable();
            $table->string('Internal_Audit_Assessor', 100)->nullable();
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
        Schema::dropIfExists('internalaudits');
    }
}
