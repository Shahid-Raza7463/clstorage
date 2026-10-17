<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigInteger('id', true, false);
            $table->integer('parent_id')->nullable();
            $table->string('client_name', 100)->nullable();
            $table->string('name', 100)->nullable();
            $table->string('clientdesignation', 100)->nullable();
            $table->string('client_code', 30)->nullable();
            $table->string('kind_attention', 100)->nullable();
            $table->string('emailid', 100)->nullable();
            $table->string('password', 255)->nullable();
            $table->text('c_address')->nullable()->charset('utf8')->collation('utf8_general_ci');
            $table->text('scopeofwork')->nullable()->charset('utf8')->collation('utf8_general_ci');
            $table->string('c_state', 100)->nullable();
            $table->string('mobileno', 15)->nullable();
            $table->string('associatedfrom', 20)->nullable();
            $table->string('leadpartner', 100)->nullable();
            $table->string('panno', 12)->nullable();
            $table->string('legalstatus', 30)->nullable();
            $table->string('tanno', 10)->nullable();
            $table->string('gstno', 15)->nullable();
            $table->string('dateofincorporation', 20)->nullable();
            $table->string('otherpartner', 100)->nullable();
            $table->string('companygroup', 100)->nullable();
            $table->string('engagementpartner', 100)->nullable();
            $table->string('clientdob', 20)->nullable();
            $table->string('createdbyadmin_id', 30)->nullable();
            $table->integer('updatedbyadmin_id')->nullable();
            $table->integer('status')->nullable();
            $table->integer('classification')->nullable();
            $table->string('otherclassification', 255)->nullable();
            $table->string('capital', 255)->nullable();
            $table->string('borrowings', 255)->nullable();
            $table->string('networth', 30)->nullable();
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
        Schema::dropIfExists('clients');
    }
}
