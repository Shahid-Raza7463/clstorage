<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanydetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companydetails', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'latin1';
            $table->collation = 'latin1_swedish_ci';
            $table->bigInteger('id', true, false);
            $table->string('company_name', 100)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('state', 100)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('gstno', 15)->nullable();
            $table->string('company_email', 100)->nullable();
            $table->string('phone_no', 15)->nullable();
            $table->string('created_by', 50)->nullable();
            $table->string('updated_by', 50)->nullable();
            $table->string('companylogo', 50)->nullable();
            $table->string('pancard_no', 12)->nullable();
            $table->string('website', 50)->nullable();
            $table->string('bankname', 50)->nullable();
            $table->string('accountname', 50)->nullable();
            $table->string('company_code', 30)->nullable();
            $table->string('accounttype', 30)->nullable();
            $table->string('accountnumber', 30)->nullable();
            $table->string('ifsc_code', 11)->nullable();
            $table->string('bankbranchaddress', 50)->nullable();
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
        Schema::dropIfExists('companydetails');
    }
}
