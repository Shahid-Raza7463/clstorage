<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DocumentassigmentExport implements FromCollection, WithHeadings, WithColumnWidths, WithStyles
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
        $processedData = collect();
        
        foreach ($this->assignments as $row) {
            // Convert object to array if needed
            $statusCounts = is_array($row->status_counts) ? (object)$row->status_counts : $row->status_counts;
            $reviewerStatusCounts = is_array($row->reviewer_status_counts) ? (object)$row->reviewer_status_counts : $row->reviewer_status_counts;
            
            // Calculate Open count
            $openCount = ($statusCounts->TOTAL ?? 0) 
                - (($statusCounts->SUBMITTED ?? 0)
                    + ($statusCounts->CLOSE ?? 0)
                    + ($statusCounts->{"REVIEW-TL"} ?? 0)
                    + ($statusCounts->{"NOT-APPLICABLE"} ?? 0));
            
            // Calculate Reviewer Open count
            $reviewerOpenCount = ($reviewerStatusCounts->TOTAL ?? 0)
                - (($reviewerStatusCounts->SUBMITTED ?? 0)
                    + ($reviewerStatusCounts->CLOSE ?? 0)
                    + ($reviewerStatusCounts->{"REVIEW-TL"} ?? 0));
            
            $processedData->push([
                'ID' => $row->id ?? 'N/A',
                'Assignment Generate ID' => $row->assignmentgenerate_id ? "'" . $row->assignmentgenerate_id : 'N/A',
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
                
                'OverAll Documentation Status' => isset($row->assignmentbudgetingsstatus) 
                    ? ($row->assignmentbudgetingsstatus == 1 ? 'OPEN' : 'CLOSED')
                    : 'N/A',
                
                '% of Documentation Completed (Close)' => isset($row->documentation_percentage) 
                    ? number_format($row->documentation_percentage, 2) . '%'
                    : '0%',
                
                // ----- Status Counts -----
                'Not Applicable' => $statusCounts->{"NOT-APPLICABLE"} ?? 0,
                'Open' => $openCount,
                'Submitted' => $statusCounts->SUBMITTED ?? 0,
                'Review TL' => $statusCounts->{"REVIEW-TL"} ?? 0,
                'Closed' => $statusCounts->CLOSE ?? 0,
                'Total' => $statusCounts->TOTAL ?? 0,
                'Total ( Expect NA )' => ($statusCounts->TOTAL ?? 0) - ($statusCounts->{"NOT-APPLICABLE"} ?? 0),
                
                // ----- EQCR -----
                'EQCR Type' => $row->eqcr_type_name ?? 'N/A',
                
                // ----- Reviewer -----
                'Reviewer Status' => $row->reviewer_status ?? 'N/A',
                'Reviewer Documentation %' => isset($row->reviewer_documentation_percentage) 
                    ? number_format($row->reviewer_documentation_percentage, 2) . '%'
                    : '0%',
                'Reviewer Submitted' => $reviewerStatusCounts->SUBMITTED ?? 0,
                'Reviewer Review TL' => $reviewerStatusCounts->{"REVIEW-TL"} ?? 0,
                'Reviewer Closed' => $reviewerStatusCounts->CLOSE ?? 0,
                'Reviewer Total' => $reviewerStatusCounts->TOTAL ?? 0,
                'Reviewer Open' => $reviewerOpenCount,
            ]);
        }
        
        return $processedData;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Assignment Generate ID',
            'Assignment',
            'Assignment Name',
            'Client',
            'Billing Date',
            'Period Start',
            'Period End',
            'Assigned Partner',
            'Other Partner',
            'Manager',
            'OverAll Documentation Status',
            '% of Documentation Completed (Close)',
            'Not Applicable',
            'Open',
            'Submitted',
            'Review TL',
            'Closed',
            'Total',
            'Total ( Expect NA )',
            'EQCR Type',
            'Reviewer Status',
            'Reviewer Documentation %',
            'Reviewer Submitted',
            'Reviewer Review TL',
            'Reviewer Closed',
            'Reviewer Total',
            'Reviewer Open',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 10,  // ID
            'B' => 20,  // Assignment Generate ID
            'C' => 25,  // Assignment
            'D' => 25,  // Assignment Name
            'E' => 25,  // Client
            'F' => 15,  // Billing Date
            'G' => 15,  // Period Start
            'H' => 15,  // Period End
            'I' => 20,  // Assigned Partner
            'J' => 20,  // Other Partner
            'K' => 30,  // Manager
            'L' => 25,  // OverAll Documentation Status
            'M' => 30,  // % of Documentation Completed (Close)
            'N' => 15,  // Not Applicable
            'O' => 10,  // Open
            'P' => 15,  // Submitted
            'Q' => 15,  // Review TL
            'R' => 15,  // Closed
            'S' => 10,  // Total
            'T' => 20,  // Total ( Expect NA )
            'U' => 15,  // EQCR Type
            'V' => 20,  // Reviewer Status
            'W' => 25,  // Reviewer Documentation %
            'X' => 20,  // Reviewer Submitted
            'Y' => 20,  // Reviewer Review TL
            'Z' => 20,  // Reviewer Closed
            'AA' => 20, // Reviewer Total
            'AB' => 15, // Reviewer Open
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the header row
            1 => [
                'font' => ['bold' => true, 'size' => 11],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FFE0E0E0']
                ]
            ],
            
            // Format percentage columns
            'M' => ['alignment' => ['horizontal' => 'right']],
            'W' => ['alignment' => ['horizontal' => 'right']],
            
            // Format numeric columns
            'N:Z' => ['alignment' => ['horizontal' => 'center']],
            'AB' => ['alignment' => ['horizontal' => 'center']],
        ];
    }
}