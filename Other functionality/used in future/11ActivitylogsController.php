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
     * Status field module mappings
     */
    private const STATUS_FIELD_MODULES = [
        'teammember_modules' => ['teammember', 'teammember_rejoining', 'teammember_status'],
        'leave_modules' => ['leave', 'leave_revert'],
    ];

    /**
     * Cache for team members to prevent N+1 queries
     */
    private $teamMembersCache = [];

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get activity logs for specific modules with pagination support
     * Optimized to reduce N+1 queries
     */
    public function getModuleLogs(Request $request, $module)
    {
        $modules = array_map('trim', explode(',', $module));

        // Validate modules
        if (!$this->validateModules($modules)) {
            return response()->json(['success' => false, 'message' => 'Invalid module(s)'], 400);
        }

        // Load logs with preloaded team members
        $logs = $this->getLogsQuery()
            ->whereIn('logs.module', $modules)
            ->orderByDesc('logs.id')
            ->get();

        // Pre-cache all team members needed
        $this->preLoadTeamMembers($logs);

        $activitylogs = $logs->map(fn($log) => $this->formatLogForResponse($log));

        return response()->json([
            'success' => true,
            'module' => $module,
            'data' => $activitylogs
        ]);
    }

    /**
     * Display all activity logs with full details
     */
    public function activitylogs(Request $request)
    {
        $logs = $this->getLogsQuery()
            ->orderByDesc('logs.id')
            ->get();

        // Pre-cache all team members needed
        $this->preLoadTeamMembers($logs);

        $activitylogs = $logs->map(fn($log) => $this->formatLogFull($log));

        return view('backEnd.teammember.activitylogs', compact('activitylogs'));
    }

    /**
     * Base query for activity logs with joins
     */
    private function getLogsQuery()
    {
        return DB::table('activitylogs_details as logs')
            ->leftJoin('teammembers as createdby', 'createdby.id', '=', 'logs.performed_by')
            ->leftJoin('teammembers as teamname', 'teamname.id', '=', 'logs.teammember_id')
            ->select(
                'logs.*',
                'createdby.team_member as created_by',
                'teamname.team_member as team_name'
            );
    }

    /**
     * Pre-load team members to avoid N+1 queries
     */
    private function preLoadTeamMembers($logs)
    {
        $memberIds = [];

        foreach ($logs as $log) {
            $changes = json_decode($log->changed_fields, true) ?? [];
            foreach (self::TEAM_MEMBER_FIELDS as $field) {
                if (isset($changes[$field])) {
                    $memberIds[] = $changes[$field]['old'] ?? null;
                    $memberIds[] = $changes[$field]['new'] ?? null;
                }
            }
        }

        // Load all team members in one query
        if (!empty($memberIds)) {
            $members = DB::table('teammembers')
                ->whereIn('id', array_filter($memberIds))
                ->pluck('team_member', 'id')
                ->toArray();

            $this->teamMembersCache = array_merge($this->teamMembersCache, $members);
        }
    }

    /**
     * Format log for JSON response (getModuleLogs)
     */
    private function formatLogForResponse($log)
    {
        $changes = json_decode($log->changed_fields, true) ?? [];
        $formattedChanges = [];

        foreach ($changes as $field => $change) {
            $oldValue = $this->formatValue($change['old'] ?? null);
            $newValue = $this->formatValue($change['new'] ?? null);

            // Apply status mapping if needed
            $mappingKey = $this->getStatusMappingKey($field, $log->module);
            if ($mappingKey) {
                $oldValue = $this->mapStatusValue($oldValue, $mappingKey);
                $newValue = $this->mapStatusValue($newValue, $mappingKey);
            }

            // Map team member IDs to names
            if (in_array($field, self::TEAM_MEMBER_FIELDS)) {
                $oldValue = $this->getTeamMemberName($oldValue);
                $newValue = $this->getTeamMemberName($newValue);
            }

            $formattedChanges[] = [
                'field' => $this->mapFieldName($field),
                'old' => $this->formatDisplayValue($oldValue),
                'new' => $this->formatDisplayValue($newValue),
            ];
        }

        $log->formatted_date = Carbon::parse($log->created_at)->format('d-m-Y h:i A');
        $log->formatted_changes = $formattedChanges;

        return $log;
    }

    /**
     * Format log with full old/new data (activitylogs view)
     */
    private function formatLogFull($log)
    {
        $changes = json_decode($log->changed_fields, true) ?? [];
        $oldData = json_decode($log->old_data, true) ?? [];
        $newData = json_decode($log->new_data, true) ?? [];

        // Format only the changed fields
        $formattedChanges = [];
        foreach ($changes as $field => $change) {
            $oldValue = $this->formatValue($change['old'] ?? null);
            $newValue = $this->formatValue($change['new'] ?? null);

            $mappingKey = $this->getStatusMappingKey($field, $log->module);
            if ($mappingKey) {
                $oldValue = $this->mapStatusValue($oldValue, $mappingKey);
                $newValue = $this->mapStatusValue($newValue, $mappingKey);
            }

            if (in_array($field, self::TEAM_MEMBER_FIELDS)) {
                $oldValue = $this->getTeamMemberName($oldValue);
                $newValue = $this->getTeamMemberName($newValue);
            }

            $formattedChanges[] = [
                'field' => $this->mapFieldName($field),
                'old' => $this->formatDisplayValue($oldValue),
                'new' => $this->formatDisplayValue($newValue),
            ];
        }

        // Format full data sets for modal
        $log->formatted_date = Carbon::parse($log->created_at)->format('d-m-Y h:i A');
        $log->formatted_changes = $formattedChanges;
        $log->formatted_old = $this->formatDataForModal($oldData, $log->module);
        $log->formatted_new = $this->formatDataForModal($newData, $log->module);

        return $log;
    }

    /**
     * Validate modules against allowed list
     */
    private function validateModules($modules)
    {
        return !empty($modules) && empty(array_diff($modules, self::ALLOWED_MODULES));
    }

    /**
     * Get status mapping key for a field and module combination
     */
    private function getStatusMappingKey($field, $module)
    {
        // Handle specific field + module combinations
        if ($field === 'status') {
            foreach (self::STATUS_FIELD_MODULES as $key => $moduleList) {
                if (in_array($module, $moduleList)) {
                    return str_replace('_modules', '', $key);
                }
            }
            // Generic status mapping
            return $module;
        }

        if ($field === 'balanceconfirmationstatus' && $module === 'confirmation') {
            return 'confirmation';
        }

        if ($field === 'timesheet_access' && $module === 'teammember') {
            return 'teammember';
        }

        if ($field === 'role_id') {
            return 'rolemapped';
        }

        return null;
    }

    /**
     * Map status value using constants
     */
    private function mapStatusValue($value, $mappingKey)
    {
        if ($value === null || $value === 'NULL') {
            return 'N/A';
        }

        // Direct mapping from constants
        if (isset(self::STATUS_MAPPINGS[$mappingKey])) {
            return self::STATUS_MAPPINGS[$mappingKey][$value] ?? $value;
        }

        return $value;
    }

    /**
     * Get team member name from cache, preventing N+1 queries
     */
    private function getTeamMemberName($value)
    {
        if (empty($value)) {
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
     * Format value (handle dates)
     */
    private function formatValue($value)
    {
        if ($value === null || $value === '') {
            return 'NULL';
        }

        // Parse and format dates
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
     * Map field names using constants
     */
    private function mapFieldName($field)
    {
        return self::FIELD_NAME_MAPPINGS[$field]
            ?? ucfirst(str_replace('_', ' ', $field));
    }

    /**
     * Format data for modal display
     */
    private function formatDataForModal($data, $module)
    {
        if (empty($data)) {
            return [];
        }

        $alwaysHideFields = ['id', 'created_at', 'updated_at'];
        $hideFields = array_merge($alwaysHideFields, self::MODULE_HIDE_FIELDS[$module] ?? []);

        $formattedData = [];

        foreach ($data as $key => $value) {
            // Skip hidden fields
            if (in_array($key, $hideFields)) {
                continue;
            }

            // Format the value
            $formattedValue = $this->formatModalValue($key, $value, $module);

            // Get readable field name
            $readableKey = $this->mapFieldName($key);

            $formattedData[$readableKey] = $formattedValue;
        }

        return $formattedData;
    }

    /**
     * Format single value for modal display
     */
    private function formatModalValue($key, $value, $module = null)
    {
        if ($value === null || $value === 'NULL' || $value === '') {
            return 'N/A';
        }

        // Handle team member fields
        if (in_array($key, self::TEAM_MEMBER_FIELDS)) {
            return $this->getTeamMemberName($value);
        }

        // Handle role mapping
        if ($key === 'role_id') {
            return $this->mapStatusValue($value, 'rolemapped');
        }

        // Handle status field based on module
        if ($key === 'status') {
            $mappingKey = $this->getStatusMappingKey('status', $module);
            if ($mappingKey) {
                return $this->mapStatusValue($value, $mappingKey);
            }
        }

        // Handle balance confirmation status
        if ($key === 'balanceconfirmationstatus' && $module === 'confirmation') {
            return $this->mapStatusValue($value, 'confirmation');
        }

        // Handle timesheet access
        if ($key === 'timesheet_access' && $module === 'teammember') {
            return $this->mapStatusValue($value, 'teammember');
        }

        // Format datetime values
        if (is_string($value) && preg_match('/^\d{4}-\d{2}-\d{2}/', $value)) {
            try {
                return Carbon::parse($value)->format('d-m-Y H:i');
            } catch (\Exception $e) {
                return $value;
            }
        }

        return $value;
    }
}
