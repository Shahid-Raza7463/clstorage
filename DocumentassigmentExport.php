<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DocumentassigmentExport implements FromCollection, WithHeadings
{
    protected $assignments;
    protected $visibleColumns;

    public function __construct($assignments, $visibleColumns = [])
    {
        $this->assignments = $assignments;
        $this->visibleColumns = $visibleColumns;
    }

    public function collection()
    {
        return $this->assignments->map(function ($row) {
            $allData = [
                'ID' => $row->id ?? 'N/A',
                'Assignment Generate ID' => $row->assignmentgenerate_id ? "\t" . $row->assignmentgenerate_id : 'N/A',
                'Assignment' => $row->assignment_name ?? 'N/A',
                'Assignment Name' => $row->assignmentname ?? 'N/A',
                'Client' => $row->client_name ?? 'N/A',

                'Billing Date' => $row->invoicedate
                    ? date('d-M-Y', strtotime($row->invoicedate))
                    : 'N/A',

                'Period Start' => $row->periodstart
                    ? date('d-M-Y', strtotime($row->periodstart))
                    : 'N/A',

                'Period End' => $row->periodend
                    ? date('d-M-Y', strtotime($row->periodend))
                    : 'N/A',

                'Assigned Partner' => $row->leadpartner_name ?? 'N/A',
                'Other Partner' => $row->otherpartner_name ?? 'N/A',
                'Manager' => $row->sub_team_members ?? 'N/A',

                'OverAll Documentation Status' => $row->assignmentbudgetingsstatus == 1 ? 'OPEN' : 'CLOSED',

                '% of Documentation Completed (Close)' => ($row->documentation_percentage ?? 0) . '%',

                // ----- Status Counts -----
                'Not Applicable' => $row->status_counts->{"NOT-APPLICABLE"} ?? 0,
                'Open' => ($row->status_counts->TOTAL ?? 0)
                    - (($row->status_counts->SUBMITTED ?? 0)
                        + ($row->status_counts->CLOSE ?? 0)
                        + ($row->status_counts->{"REVIEW-TL"} ?? 0)
                        + ($row->status_counts->{"NOT-APPLICABLE"} ?? 0)),
                'Submitted' => $row->status_counts->SUBMITTED ?? 0,
                'Review TL' => $row->status_counts->{"REVIEW-TL"} ?? 0,
                'Closed' => $row->status_counts->CLOSE ?? 0,
                'Total' => $row->status_counts->TOTAL ?? 0,
                'Total ( Expect NA )' => ($row->status_counts->TOTAL ?? 0)
                    - ($row->status_counts->{"NOT-APPLICABLE"} ?? 0),

                // ----- EQCR -----
                'EQCR Type' => $row->eqcr_type_name ?? 'N/A',

                // ----- Reviewer -----
                'Reviewer Status' => $row->reviewer_status ?? 'N/A',
                'Reviewer Documentation %' => ($row->reviewer_documentation_percentage ?? 0) . '%',
                'Reviewer Open' => ($row->reviewer_status_counts->TOTAL ?? 0)
                    - (($row->reviewer_status_counts->SUBMITTED ?? 0)
                        + ($row->reviewer_status_counts->CLOSE ?? 0)
                        + ($row->reviewer_status_counts->{"REVIEW-TL"} ?? 0)),
                'Reviewer Submitted' => $row->reviewer_status_counts->SUBMITTED ?? 0,
                'Reviewer Review TL' => $row->reviewer_status_counts->{"REVIEW-TL"} ?? 0,
                'Reviewer Closed' => $row->reviewer_status_counts->CLOSE ?? 0,
                'Reviewer Total' => $row->reviewer_status_counts->TOTAL ?? 0,
            ];

            // Apply filter without breaking keys
            if (!empty($this->visibleColumns)) {
                $allowed = $this->getHeadingsByIndex($this->visibleColumns);
                return collect($allData)->only($allowed)->toArray();
            }

            return $allData; // keep keys intact
        });
    }

    public function headings(): array
    {
        $allHeadings = $this->getHeadingsByIndex();

        if (!empty($this->visibleColumns)) {
            return array_values($this->getHeadingsByIndex($this->visibleColumns));
        }

        return array_values($allHeadings);
    }

    private function getHeadingsByIndex($onlyKeys = null)
    {
        $map = [
            0  => 'ID',
            1  => 'Assignment Generate ID',
            2  => 'Assignment',
            3  => 'Assignment Name',
            4  => 'Client',
            5  => 'Billing Date',
            6  => 'Period Start',
            7  => 'Period End',
            8  => 'Assigned Partner',
            9  => 'Other Partner',
            10 => 'Manager',
            11 => 'OverAll Documentation Status',
            12 => '% of Documentation Completed (Close)',
            13 => 'Not Applicable',
            14 => 'Submitted',
            15 => 'Review TL',
            16 => 'Closed',
            17 => 'Total',
            18 => 'Open',
            19 => 'Total ( Expect NA )',
            20 => 'EQCR Type',
            21 => 'Reviewer Status',
            22 => 'Reviewer Documentation %',
            23 => 'Reviewer Submitted',
            24 => 'Reviewer Review TL',
            25 => 'Reviewer Closed',
            26 => 'Reviewer Total',
            27 => 'Reviewer Open',
        ];

        return $onlyKeys ? collect($map)->only($onlyKeys)->toArray() : $map;
    }
}
