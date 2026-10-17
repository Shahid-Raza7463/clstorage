<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVsaclientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vsaclient', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->integer('id')->nullable();
            $table->string('client_name', 42)->nullable();
            $table->string('c_address', 130)->nullable();
            $table->string('legalstatus', 13)->nullable();
            $table->string('panno', 11)->nullable();
            $table->string('tanno', 10)->nullable();
            $table->string('gstno', 15)->nullable();
            $table->integer('status')->nullable();
            $table->integer('classification')->nullable();
            $table->integer('client_code')->nullable();
        });

        $this->addForeignKeys();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->dropForeignKeys();

        Schema::dropIfExists('vsaclient');
    }

    private function addForeignKeys()
    {
        foreach ($this->foreignKeys() as $tableName => $foreignKeys) {
            Schema::table($tableName, function (Blueprint $table) use ($foreignKeys) {
                foreach ($foreignKeys as $foreignKey) {
                    $table->foreign($foreignKey['column'])
                        ->references($foreignKey['references'])
                        ->on($foreignKey['on'])
                        ->onDelete($foreignKey['onDelete']);
                }
            });
        }
    }

    private function dropForeignKeys()
    {
        foreach (array_reverse($this->foreignKeys()) as $tableName => $foreignKeys) {
            Schema::table($tableName, function (Blueprint $table) use ($foreignKeys) {
                foreach (array_reverse($foreignKeys) as $foreignKey) {
                    $table->dropForeign([$foreignKey['column']]);
                }
            });
        }
    }

    private function foreignKeys()
    {
        return [
            'activitylogs' => [
                ['column' => 'user_id', 'references' => 'id', 'on' => 'users', 'onDelete' => 'set null'],
            ],
            'activitylogs_details' => [
                ['column' => 'teammember_id', 'references' => 'id', 'on' => 'teammembers', 'onDelete' => 'set null'],
            ],
            'annual_independence_declarations' => [
                ['column' => 'partner', 'references' => 'id', 'on' => 'teammembers', 'onDelete' => 'set null'],
            ],
            'applyleaves' => [
                ['column' => 'approver', 'references' => 'id', 'on' => 'teammembers', 'onDelete' => 'set null'],
            ],
            'appointmentletters' => [
                ['column' => 'assignment_id', 'references' => 'id', 'on' => 'assignments', 'onDelete' => 'set null'],
                ['column' => 'client_id', 'references' => 'id', 'on' => 'clients', 'onDelete' => 'set null'],
                ['column' => 'teammember_id', 'references' => 'id', 'on' => 'teammembers', 'onDelete' => 'set null'],
            ],
            'articles' => [
                ['column' => 'created_by', 'references' => 'id', 'on' => 'teammembers', 'onDelete' => 'set null'],
            ],
            'assignmentbudgetings' => [
                ['column' => 'client_id', 'references' => 'id', 'on' => 'clients', 'onDelete' => 'set null'],
                ['column' => 'assignment_id', 'references' => 'id', 'on' => 'assignments', 'onDelete' => 'set null'],
                ['column' => 'created_by', 'references' => 'id', 'on' => 'teammembers', 'onDelete' => 'set null'],
            ],
            'assignmentbudgetingudins' => [
                ['column' => 'partner', 'references' => 'id', 'on' => 'teammembers', 'onDelete' => 'set null'],
                ['column' => 'created_by', 'references' => 'id', 'on' => 'teammembers', 'onDelete' => 'set null'],
            ],
            'assignmentfolderfiles' => [
                ['column' => 'assignmentfolder_id', 'references' => 'id', 'on' => 'assignmentfolders', 'onDelete' => 'cascade'],
            ],
            'assignmentmappings' => [
                ['column' => 'assignment_id', 'references' => 'id', 'on' => 'assignments', 'onDelete' => 'set null'],
                ['column' => 'roleassignment', 'references' => 'id', 'on' => 'roles', 'onDelete' => 'set null'],
            ],
            'assignmentteammappings' => [
                ['column' => 'assignmentmapping_id', 'references' => 'id', 'on' => 'assignmentmappings', 'onDelete' => 'cascade'],
                ['column' => 'teammember_id', 'references' => 'id', 'on' => 'teammembers', 'onDelete' => 'cascade'],
            ],
            'auditquestions' => [
                ['column' => 'financialstatemantclassfication_id', 'references' => 'id', 'on' => 'financialstatementclassifications', 'onDelete' => 'set null'],
            ],
            'audittrails' => [
                ['column' => 'created_by', 'references' => 'id', 'on' => 'teammembers', 'onDelete' => 'set null'],
            ],
            'balanceconfirmationreminder' => [
                ['column' => 'debtorsid', 'references' => 'id', 'on' => 'debtors', 'onDelete' => 'cascade'],
                ['column' => 'created_by', 'references' => 'id', 'on' => 'teammembers', 'onDelete' => 'set null'],
            ],
            'checklistanswers' => [
                ['column' => 'audit_id', 'references' => 'id', 'on' => 'auditquestions', 'onDelete' => 'cascade'],
                ['column' => 'financialstatemantclassfication_id', 'references' => 'id', 'on' => 'financialstatementclassifications', 'onDelete' => 'set null'],
                ['column' => 'created_by', 'references' => 'id', 'on' => 'teammembers', 'onDelete' => 'set null'],
                ['column' => 'modify_by', 'references' => 'id', 'on' => 'teammembers', 'onDelete' => 'set null'],
            ],
            'clientcontacts' => [
                ['column' => 'client_id', 'references' => 'id', 'on' => 'clients', 'onDelete' => 'cascade'],
            ],
            'clientdocuments' => [
                ['column' => 'client_id', 'references' => 'id', 'on' => 'clients', 'onDelete' => 'cascade'],
                ['column' => 'created_by', 'references' => 'id', 'on' => 'teammembers', 'onDelete' => 'set null'],
            ],
            'clients' => [
                ['column' => 'parent_id', 'references' => 'id', 'on' => 'clients', 'onDelete' => 'set null'],
            ],
            'criticalnotes' => [
                ['column' => 'created_by', 'references' => 'id', 'on' => 'teammembers', 'onDelete' => 'set null'],
            ],
            'debtorbatchshare' => [
                ['column' => 'createdby', 'references' => 'id', 'on' => 'teammembers', 'onDelete' => 'set null'],
                ['column' => 'revokeby', 'references' => 'id', 'on' => 'teammembers', 'onDelete' => 'set null'],
            ],
            'debtorconfirmations' => [
                ['column' => 'debtor_id', 'references' => 'id', 'on' => 'debtors', 'onDelete' => 'cascade'],
            ],
            'debtors' => [
                ['column' => 'created_by', 'references' => 'id', 'on' => 'teammembers', 'onDelete' => 'set null'],
                ['column' => 'confirmationsentby', 'references' => 'id', 'on' => 'teammembers', 'onDelete' => 'set null'],
            ],
            'discusesteammebers' => [
                ['column' => 'teammember_id', 'references' => 'id', 'on' => 'teammembers', 'onDelete' => 'cascade'],
            ],
            'financialstatementclassifications' => [
                ['column' => 'assignment_id', 'references' => 'id', 'on' => 'assignments', 'onDelete' => 'set null'],
            ],
            'leaveapprove' => [
                ['column' => 'teammemberid', 'references' => 'id', 'on' => 'teammembers', 'onDelete' => 'set null'],
                ['column' => 'leavetype', 'references' => 'id', 'on' => 'leavetypes', 'onDelete' => 'set null'],
            ],
            'leaverequest' => [
                ['column' => 'approver', 'references' => 'id', 'on' => 'teammembers', 'onDelete' => 'set null'],
            ],
            'leaveroles' => [
                ['column' => 'leavetype_id', 'references' => 'id', 'on' => 'leavetypes', 'onDelete' => 'cascade'],
                ['column' => 'role', 'references' => 'id', 'on' => 'roles', 'onDelete' => 'set null'],
            ],
            'leaveteams' => [
                ['column' => 'leave_id', 'references' => 'id', 'on' => 'leaverequest', 'onDelete' => 'cascade'],
                ['column' => 'teammember_id', 'references' => 'id', 'on' => 'teammembers', 'onDelete' => 'cascade'],
            ],
            'leavetypes' => [
                ['column' => 'leavetypemonth', 'references' => 'id', 'on' => 'leavetypemonth', 'onDelete' => 'set null'],
                ['column' => 'leavetypedays', 'references' => 'id', 'on' => 'leavetypedays', 'onDelete' => 'set null'],
                ['column' => 'leavetypemonthly', 'references' => 'id', 'on' => 'leavetypemonthly', 'onDelete' => 'set null'],
            ],
            'notificationreadorunread' => [
                ['column' => 'notifications_id', 'references' => 'id', 'on' => 'notifications', 'onDelete' => 'cascade'],
            ],
            'notifications' => [
                ['column' => 'created_by', 'references' => 'id', 'on' => 'teammembers', 'onDelete' => 'set null'],
            ],
            'notificationtargets' => [
                ['column' => 'notification_id', 'references' => 'id', 'on' => 'notifications', 'onDelete' => 'cascade'],
                ['column' => 'teammember_id', 'references' => 'id', 'on' => 'teammembers', 'onDelete' => 'cascade'],
            ],
            'permissions' => [
                ['column' => 'role_id', 'references' => 'id', 'on' => 'roles', 'onDelete' => 'cascade'],
                ['column' => 'page_id', 'references' => 'id', 'on' => 'pages', 'onDelete' => 'cascade'],
            ],
            'rejoiningsamepost' => [
                ['column' => 'teammember_id', 'references' => 'id', 'on' => 'teammembers', 'onDelete' => 'cascade'],
            ],
            'teammembers' => [
                ['column' => 'mentor_id', 'references' => 'id', 'on' => 'teammembers', 'onDelete' => 'set null'],
                ['column' => 'title_id', 'references' => 'id', 'on' => 'titles', 'onDelete' => 'set null'],
                ['column' => 'role_id', 'references' => 'id', 'on' => 'roles', 'onDelete' => 'set null'],
                ['column' => 'created_by', 'references' => 'id', 'on' => 'teammembers', 'onDelete' => 'set null'],
            ],
            'teammember_document_files' => [
                ['column' => 'teamember_id', 'references' => 'id', 'on' => 'teammembers', 'onDelete' => 'cascade'],
            ],
            'teamrolehistory' => [
                ['column' => 'teammember_id', 'references' => 'id', 'on' => 'teammembers', 'onDelete' => 'cascade'],
                ['column' => 'roleid_old', 'references' => 'id', 'on' => 'roles', 'onDelete' => 'set null'],
                ['column' => 'roleid_new', 'references' => 'id', 'on' => 'roles', 'onDelete' => 'set null'],
            ],
            'templates' => [
                ['column' => 'client_id', 'references' => 'id', 'on' => 'clients', 'onDelete' => 'set null'],
                ['column' => 'createdby', 'references' => 'id', 'on' => 'teammembers', 'onDelete' => 'set null'],
            ],
            'timesheetday' => [
                ['column' => 'createdby', 'references' => 'id', 'on' => 'teammembers', 'onDelete' => 'set null'],
            ],
            'timesheetreport' => [
                ['column' => 'teamid', 'references' => 'id', 'on' => 'teammembers', 'onDelete' => 'set null'],
                ['column' => 'partnerid', 'references' => 'id', 'on' => 'teammembers', 'onDelete' => 'set null'],
            ],
            'timesheetrequests' => [
                ['column' => 'client_id', 'references' => 'id', 'on' => 'clients', 'onDelete' => 'set null'],
                ['column' => 'assignment_id', 'references' => 'id', 'on' => 'assignments', 'onDelete' => 'set null'],
                ['column' => 'partner', 'references' => 'id', 'on' => 'teammembers', 'onDelete' => 'set null'],
                ['column' => 'createdby', 'references' => 'id', 'on' => 'teammembers', 'onDelete' => 'set null'],
            ],
            'timesheets' => [
                ['column' => 'created_by', 'references' => 'id', 'on' => 'teammembers', 'onDelete' => 'set null'],
            ],
            'timesheetupdatelogs' => [
                ['column' => 'timesheetusers_id', 'references' => 'id', 'on' => 'timesheetusers', 'onDelete' => 'cascade'],
            ],
            'timesheetusers' => [
                ['column' => 'timesheetid', 'references' => 'id', 'on' => 'timesheets', 'onDelete' => 'cascade'],
                ['column' => 'client_id', 'references' => 'id', 'on' => 'clients', 'onDelete' => 'set null'],
                ['column' => 'partner', 'references' => 'id', 'on' => 'teammembers', 'onDelete' => 'set null'],
                ['column' => 'assignment_id', 'references' => 'id', 'on' => 'assignments', 'onDelete' => 'set null'],
                ['column' => 'createdby', 'references' => 'id', 'on' => 'teammembers', 'onDelete' => 'set null'],
                ['column' => 'rejectedby', 'references' => 'id', 'on' => 'teammembers', 'onDelete' => 'set null'],
                ['column' => 'updatedby', 'references' => 'id', 'on' => 'teammembers', 'onDelete' => 'set null'],
            ],
            'trail' => [
                ['column' => 'createdby', 'references' => 'id', 'on' => 'teammembers', 'onDelete' => 'set null'],
                ['column' => 'pageid', 'references' => 'id', 'on' => 'pages', 'onDelete' => 'set null'],
            ],
            'userloginactiviteies' => [
                ['column' => 'teammember_id', 'references' => 'id', 'on' => 'teammembers', 'onDelete' => 'cascade'],
            ],
            'users' => [
                ['column' => 'teammember_id', 'references' => 'id', 'on' => 'teammembers', 'onDelete' => 'set null'],
                ['column' => 'role_id', 'references' => 'id', 'on' => 'roles', 'onDelete' => 'set null'],
            ],
        ];
    }
}
