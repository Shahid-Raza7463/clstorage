<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChecklistanswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checklistanswers', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigInteger('id', true, false);
            $table->bigInteger('assignment_id');
            $table->integer('audit_id');
            $table->integer('steplist_id')->nullable();
            $table->integer('financialstatemantclassfication_id')->nullable();
            $table->integer('subclassfied_id')->nullable();
            $table->text('answer')->nullable();
            $table->text('checklist_note')->nullable();
            $table->string('refdocument', 255)->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->integer('_wysihtml5_mode')->nullable();
            $table->unsignedInteger('modify_by')->nullable();
            $table->string('critical_notes', 255)->nullable();
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
        Schema::dropIfExists('checklistanswers');
    }
}
