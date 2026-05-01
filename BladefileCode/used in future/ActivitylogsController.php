<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class ActivitylogsController extends Controller
{
    /**
     * Allowed modules for activity logs
     */
    private const ALLOWED_MODULES = [
        'timesheet_rejceted',
        'teammember_credential',
        'notification',
        'teammember_status',
        'teammember',
        'assignment',
        'leave',
        'client',
        'confirmation',
        'timesheet_requests',
        'teammember_rejoining',
        'teammember_promotion',
        'assignment_team',
        'assignment_partner',
        'leave_revert'
    ];

    /**
     * Status mappings for different modules
     */
    private const STATUS_MAPPINGS = [
        'teammember' => [1 => 'Active', 0 => 'Inactive'],
        'teammember_rejoining' => [1 => 'Active', 0 => 'Inactive'],
        'teammember_status' => [1 => 'Active', 0 => 'Inactive'],
        'timesheet_rejceted' => [1 => 'Submitted', 0 => 'Rejected'],
        'confirmation' => [1 => 'Opened', 0 => 'Closed'],
        'leave' => [0 => 'Created', 1 => 'Approved', 2 => 'Rejected'],
        'leave_revert' => [0 => 'Created', 1 => 'Approved', 2 => 'Rejected'],
        'rolemapped' => [13 => 'Partner', 14 => 'Manager', 15 => 'Staff'],
        'timesheet_requests' => [0 => 'Created', 1 => 'Approved', 2 => 'Rejected'],
    ];

    /**
     * Field name mappings for display
     */
    private const FIELD_NAME_MAPPINGS = [
        'balanceconfirmationstatus' => 'Confirmation',
        'status' => 'Status',
        'rejoiniedexitdate' => 'Rejoining Exit Date',
        'rejoiningdate' => 'Rejoining Date',
        'emergencycontactnumber' => 'Emergency Contact Number',
        'team_member' => 'Team Member Name',
        'mobile_no' => 'Mobile Number',
        'dateofbirth' => 'Date Of Birth',
        'pancardno' => 'PAN Card Number',
        'adharcardnumber' => 'Aadhar Number',
        'role_id' => 'Role Name',
        'staffcodenumber' => 'Staff Code Number',
        'staffcode' => 'Staff Code',
        'rejectedby' => 'Rejected By',
        'updatedby' => 'Updated By',
        'otherpartner' => 'Other Partner',
        'leadpartner' => 'Lead Partner',
        'stdcost' => 'Std cost',
        'emailid' => 'Email Id',
        'personalemail' => 'Personal Email',
        'address_proof' => 'Address Proof',
        'mothername' => 'Mother Name',
        'mothernumber' => 'Mother contact Number',
        'fathername' => 'Father Name',
        'fathernumber' => 'Father contact Number',
        'leavingdate' => 'Leaving Date',
        'created_by' => 'Created By',
    ];

    /**
     * Fields to hide in modal display per module
     */
    private const MODULE_HIDE_FIELDS = [
        'default' => ['id', 'created_at', 'updated_at'],
        'teammember' => ['created_by', 'updated_by', 'change_type'],
        'assignment' => ['created_at', 'updated_at', 'id'],
        'leave' => ['updated_at'],
        'timesheet_rejceted' => ['updated_at', 'created_at'],
        'notification' => ['created_by', 'updated_at'],
        'confirmation' => [],
    ];

    /**
     * Fields that reference team members
     */
    private const TEAM_MEMBER_FIELDS = ['leadpartner', 'otherpartner', 'updatedby', 'rejectedby', 'performed_by', 'created_by'];

    /**
     * Cache for team members to prevent N+1 queries
     */
    private $teamMembersCache = [];

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get logs for specific modules (API endpoint)
     */
    public function getModuleLogs(Request $request, $module)
    {
        $modules = explode(',', $module);

        // Validate modules
        foreach ($modules as $mod) {
            if (!in_array(trim($mod), self::ALLOWED_MODULES)) {
                return response()->json(['success' => false, 'message' => 'Invalid module: ' . $mod], 400);
            }
        }

        $logs = $this->fetchLogs(['logs.module' => $modules]);
        $activitylogs = $this->formatLogs($logs, false);

        return response()->json([
            'success' => true,
            'module' => $module,
            'data' => $activitylogs
        ]);
    }

    /**
     * Get all activity logs (View page)
     */
    public function activitylogs(Request $request)
    {
        $logs = $this->fetchLogs();
        $activitylogs = $this->formatLogs($logs, true);

        return view('backEnd.teammember.activitylogs', compact('activitylogs'));
    }

    /**
     * Fetch logs with necessary joins
     */
    private function fetchLogs($whereConditions = null)
    {
        $query = DB::table('activitylogs_details as logs')
            ->leftJoin('teammembers as createdby', 'createdby.id', '=', 'logs.performed_by')
            ->leftJoin('teammembers as teamname', 'teamname.id', '=', 'logs.teammember_id')
            ->select(
                'logs.*',
                'createdby.team_member as created_by',
                'teamname.team_member as team_name'
            );

        if ($whereConditions) {
            foreach ($whereConditions as $column => $values) {
                $query->whereIn($column, (array)$values);
            }
        }

        return $query->orderByDesc('logs.id')->get();
    }

    /**
     * Format logs for output
     * 
     * @param $logs Collection of log records
     * @param $includeFullData Boolean to include old/new data for modal
     */
    private function formatLogs($logs, $includeFullData = false)
    {
        // Pre-load all team members to prevent N+1 queries
        $this->loadTeamMembersCache($logs);

        return $logs->map(function ($log) use ($includeFullData) {
            $changes = json_decode($log->changed_fields, true);

            $log->formatted_date = Carbon::parse($log->created_at)->format('d-m-Y h:i A');
            $log->formatted_changes = $this->formatChanges($changes, $log->module);

            if ($includeFullData) {
                $oldData = json_decode($log->old_data, true);
                $newData = json_decode($log->new_data, true);

                $log->formatted_old = $this->formatDataForModal($oldData, $log->module);
                $log->formatted_new = $this->formatDataForModal($newData, $log->module);
            }

            return $log;
        });
    }

    /**
     * Pre-load all team members to prevent N+1 queries
     */
    private function loadTeamMembersCache($logs)
    {
        $memberIds = collect($logs)
            ->flatMap(function ($log) {
                return array_filter([$log->performed_by, $log->teammember_id]);
            })
            ->unique()
            ->values();

        if ($memberIds->isNotEmpty()) {
            $this->teamMembersCache = DB::table('teammembers')
                ->whereIn('id', $memberIds)
                ->pluck('team_member', 'id')
                ->toArray();
        }
    }

    /**
     * Format all changed fields
     */
    private function formatChanges($changes, $module)
    {
        $formatted = [];

        if (empty($changes)) {
            return $formatted;
        }

        foreach ($changes as $field => $change) {
            $oldValue = $this->formatValue($change['old'] ?? null);
            $newValue = $this->formatValue($change['new'] ?? null);

            // Get appropriate status mapping key
            $statusKey = $this->getStatusMappingKey($field, $module);

            // Apply status and team member mappings
            $oldValue = $this->applyValueMapping($oldValue, $field, $statusKey);
            $newValue = $this->applyValueMapping($newValue, $field, $statusKey);

            $formatted[] = [
                'field' => $this->mapFieldName($field),
                'old' => $this->formatDisplayValue($oldValue),
                'new' => $this->formatDisplayValue($newValue),
            ];
        }

        return $formatted;
    }

    /**
     * Determine which status mapping key to use for a field
     */
    private function getStatusMappingKey($field, $module)
    {
        if ($field === 'role_id') {
            return 'rolemapped';
        }

        if ($field === 'status') {
            // Check for leave_revert first, then other modules
            if (in_array($module, ['leave', 'leave_revert'])) {
                return 'leave';
            }
            if (in_array($module, ['timesheet_rejceted', 'confirmation', 'timesheet_requests'])) {
                return $module;
            }
            if (in_array($module, ['teammember', 'teammember_rejoining', 'teammember_status'])) {
                return 'teammember';
            }
        }

        if ($field === 'balanceconfirmationstatus' && $module === 'confirmation') {
            return 'confirmation';
        }

        if ($field === 'timesheet_access' && $module === 'teammember') {
            return 'teammember';
        }

        return null;
    }

    /**
     * Apply status and team member mappings to a value
     */
    private function applyValueMapping($value, $field, $statusKey = null)
    {
        // Apply status mapping
        if ($statusKey) {
            $value = $this->mapStatusValue($value, $statusKey);
        }

        // Apply team member ID mapping
        if (in_array($field, self::TEAM_MEMBER_FIELDS)) {
            $value = $this->getTeamMemberName($value);
        }

        return $value;
    }

    /**
     * Map status value using the configuration
     */
    private function mapStatusValue($value, $module)
    {
        if ($value === null || $value === 'NULL') {
            return 'N/A';
        }

        $mappings = self::STATUS_MAPPINGS[$module] ?? [];

        if (array_key_exists($value, $mappings)) {
            return $mappings[$value];
        }

        return $value;
    }

    /**
     * Get team member name from cache or return N/A
     */
    private function getTeamMemberName($value)
    {
        if (empty($value) || $value === 'NULL') {
            return 'N/A';
        }

        return $this->teamMembersCache[$value] ?? 'N/A';
    }

    /**
     * Format display value
     */
    private function formatDisplayValue($value)
    {
        if ($value === null || $value === 'NULL' || $value === '') {
            return 'N/A';
        }

        return $value;
    }

    /**
     * Map field name for display
     */
    private function mapFieldName($field)
    {
        if (array_key_exists($field, self::FIELD_NAME_MAPPINGS)) {
            return self::FIELD_NAME_MAPPINGS[$field];
        }

        // Default formatting
        return ucfirst(str_replace('_', ' ', $field));
    }

    /**
     * Format raw values (datetime parsing)
     */
    private function formatValue($value)
    {
        if ($value === null || $value === '') {
            return 'NULL';
        }

        // Parse datetime values
        if (is_string($value) && preg_match('/^\d{4}-\d{2}-\d{2}/', $value)) {
            try {
                return Carbon::parse($value)->format('d-m-Y H:i');
            } catch (\Exception $e) {
                return $value;
            }
        }

        return $value;
    }

    /**
     * Format data for modal display with filtering
     */
    private function formatDataForModal($data, $module)
    {
        if (empty($data)) {
            return [];
        }

        // Get fields to hide (default + module-specific)
        $hideFields = array_merge(
            self::MODULE_HIDE_FIELDS['default'] ?? [],
            self::MODULE_HIDE_FIELDS[$module] ?? []
        );

        $formattedData = [];

        foreach ($data as $key => $value) {
            // Skip hidden fields
            if (in_array($key, $hideFields)) {
                continue;
            }

            // Get readable field name
            $readableKey = $this->mapFieldName($key);

            // Format value with all mappings
            $statusKey = $this->getStatusMappingKey($key, $module);
            $formattedValue = $this->applyValueMapping(
                $this->formatValue($value),
                $key,
                $statusKey
            );

            $formattedData[$readableKey] = $this->formatDisplayValue($formattedValue);
        }

        return $formattedData;
    }
}
