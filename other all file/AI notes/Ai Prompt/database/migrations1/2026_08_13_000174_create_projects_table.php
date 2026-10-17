<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_general_ci';
            $table->integer('id', true, false);
            $table->string('client_id', 30)->nullable()->charset('utf16')->collation('utf16_croatian_ci');
            $table->string('project_name', 100)->nullable()->charset('utf16')->collation('utf16_croatian_ci');
            $table->string('teammember_id', 30)->nullable()->charset('utf16')->collation('utf16_croatian_ci');
            $table->string('projectmanager', 100)->nullable()->charset('utf16')->collation('utf16_croatian_ci');
            $table->string('projectuser', 100)->nullable()->charset('utf16')->collation('utf16_croatian_ci');
            $table->string('description', 255)->nullable()->charset('utf16')->collation('utf16_croatian_ci');
            $table->integer('organization_id')->nullable();
            $table->integer('createdby')->nullable();
            $table->integer('updatedby')->nullable();
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
        Schema::dropIfExists('projects');
    }
}
