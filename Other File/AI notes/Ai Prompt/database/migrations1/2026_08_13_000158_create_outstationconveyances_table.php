<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOutstationconveyancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outstationconveyances', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf16';
            $table->collation = 'utf16_croatian_ci';
            $table->integer('id', true, false);
            $table->string('uniqueid', 30)->nullable();
            $table->string('client_id', 30)->nullable();
            $table->integer('assignment_id')->nullable();
            $table->string('assignmentgenerate_id', 30)->nullable();
            $table->string('conveyance', 100)->nullable();
            $table->string('chooseconveyance', 100)->nullable();
            $table->text('rejectremarks')->nullable();
            $table->string('Conveyance_file', 255)->nullable();
            $table->string('During_Journeyfile', 255)->nullable();
            $table->string('Miscellaneous_Expfile', 255)->nullable();
            $table->string('Assignment', 100)->nullable();
            $table->string('Audit_from_date', 20)->nullable();
            $table->string('Audit_period_date', 30)->nullable();
            $table->string('Visiting_from_date', 20)->nullable();
            $table->string('Visiting_date', 20)->nullable();
            $table->string('Tickets_Booked_By', 255)->nullable();
            $table->string('Food_Expensesfile', 255)->nullable();
            $table->string('Fare', 255)->nullable();
            $table->string('Conveyance_Charges', 100)->nullable();
            $table->string('Coolie_Charges', 255)->nullable();
            $table->string('During_Journey', 255)->nullable();
            $table->string('Miscellaneous_Exp', 255)->nullable();
            $table->string('Food_Expenses', 100)->nullable();
            $table->string('invoiceno', 30)->nullable();
            $table->string('Recoverable', 50)->nullable();
            $table->string('Approved_Rate', 30)->nullable();
            $table->string('TA_Claimed', 255)->nullable();
            $table->string('travelfoodremark', 100)->nullable();
            $table->string('TravelMiscellaneoussupportingfile', 255)->nullable();
            $table->text('travelMiscellaneousremark')->nullable();
            $table->integer('Approved_Conveyance')->nullable();
            $table->string('Travelfoodsupportingfile', 255)->nullable();
            $table->string('Travelling_BILL', 255)->nullable();
            $table->string('Travelsupportingfile', 255)->nullable();
            $table->string('localtravel', 255)->nullable();
            $table->string('localfood', 100)->nullable();
            $table->string('travelMiscellaneous', 255)->nullable();
            $table->string('travelremark', 255)->nullable();
            $table->string('billpaid', 50)->nullable();
            $table->text('correction')->nullable();
            $table->integer('outstationnnreceivable_payable')->nullable();
            $table->string('advanceoffice', 30)->nullable();
            $table->string('advanceamountrequired', 30)->nullable();
            $table->integer('Total_Value')->nullable();
            $table->string('AdvanceAmountgiven', 30)->nullable();
            $table->string('anycomment', 255)->nullable();
            $table->string('oval', 255)->nullable();
            $table->string('bill', 255)->nullable();
            $table->string('attachment', 255)->nullable();
            $table->string('localsreceivable_payable', 200)->nullable();
            $table->string('Remarks', 255)->nullable();
            $table->string('Status', 30)->nullable();
            $table->integer('adjustablestatus')->nullable();
            $table->string('paiddate', 20)->nullable();
            $table->string('processingdate', 20)->nullable();
            $table->integer('localapprovedrate')->nullable();
            $table->integer('localnoofday')->nullable();
            $table->integer('outstationnoofday')->nullable();
            $table->integer('createdby')->nullable();
            $table->integer('updatedby')->nullable();
            $table->string('approveddate', 20)->nullable();
            $table->string('finalamount', 30)->nullable();
            $table->text('finalremarks')->nullable();
            $table->text('payment')->nullable();
            $table->text('paidfrom')->nullable();
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
        Schema::dropIfExists('outstationconveyances');
    }
}
