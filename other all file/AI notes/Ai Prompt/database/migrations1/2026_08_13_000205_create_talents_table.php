<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTalentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('talents', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'latin1';
            $table->collation = 'latin1_swedish_ci';
            $table->integer('id', true, false);
            $table->string('Agreement', 255)->nullable()->charset('utf8')->collation('utf8_general_ci');
            $table->integer('S_No')->nullable();
            $table->integer('client_id')->nullable();
            $table->integer('createdby')->nullable();
            $table->string('Agreement_With', 5)->nullable()->charset('utf8')->collation('utf8_general_ci');
            $table->string('Universities_Name', 84)->nullable()->charset('utf8')->collation('utf8_general_ci');
            $table->text('Course_Name')->nullable()->charset('utf8')->collation('utf8_general_ci');
            $table->string('Certificate_Type', 255)->nullable()->charset('utf8')->collation('utf8_general_ci');
            $table->string('file', 255)->nullable();
            $table->text('remark')->nullable();
            $table->string('Certificate_issued_by', 195)->nullable()->charset('utf8')->collation('utf8_general_ci');
            $table->string('Date_of_Agreement', 20)->nullable()->charset('utf8')->collation('utf8_general_ci');
            $table->string('starting_date_for_the_course', 20)->nullable()->charset('utf8')->collation('utf8_general_ci');
            $table->string('End_date_for_the_course', 19)->nullable()->charset('utf8')->collation('utf8_general_ci');
            $table->string('Batch_No', 2)->nullable()->charset('utf8')->collation('utf8_general_ci');
            $table->text('Period_of_Course')->nullable()->charset('utf8')->collation('utf8_general_ci');
            $table->string('Type_of_Agreement', 255)->nullable()->charset('utf8')->collation('utf8_general_ci');
            $table->text('Total_Fees_Fees_INR')->nullable()->charset('utf8')->collation('utf8_general_ci');
            $table->text('Total_Fees_Fees_USD')->nullable()->charset('utf8')->collation('utf8_general_ci');
            $table->text('Fees_rendered_to_the_university')->nullable()->charset('utf8')->collation('utf8_general_ci');
            $table->text('Fees_rendered_to_the_AESPL')->nullable()->charset('utf8')->collation('utf8_general_ci');
            $table->string('Installments', 255)->nullable()->charset('utf8')->collation('utf8_general_ci');
            $table->string('Date_of_Installments_upto', 20)->nullable()->charset('utf8')->collation('utf8_general_ci');
            $table->string('Amount_of_Installment_In_INR', 30)->nullable()->charset('utf8')->collation('utf8_general_ci');
            $table->string('Amount_of_Installment_In_USD', 30)->nullable()->charset('utf8')->collation('utf8_general_ci');
            $table->string('Total_value_of_contract', 1)->nullable()->charset('utf8')->collation('utf8_general_ci');
            $table->integer('Total_value_of_collection')->nullable();
            $table->integer('Total_Value_of_collection_up_31st_March')->nullable();
            $table->integer('Total_Amount_to_be_collected')->nullable();
            $table->text('Remarks_as_per_agreements')->nullable()->charset('utf8')->collation('utf8_general_ci');
            $table->string('Other_Remarks', 255)->nullable()->charset('utf8')->collation('utf8_general_ci');
            $table->string('Assignment_Permitited_or_not', 100)->nullable();
            $table->text('Termination_grounds_by_Arrina_including_notice_period')->nullable();
            $table->text('Termination_grounds_by_Counterparties_including_notice_period')->nullable();
            $table->text('Termination_consequences_By_Arrina')->nullable();
            $table->text('Termination_consequences_by_Counterparties')->nullable();
            $table->text('including_arbitration_Governing_law_Jurisdiction_of_courts')->nullable();
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
        Schema::dropIfExists('talents');
    }
}
