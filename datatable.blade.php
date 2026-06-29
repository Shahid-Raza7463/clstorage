@forelse($records as $row)
    <tr>
        <td>{{ $row->team_member ?? '-' }}</td>
        <td>{{ $row->emailid ?? '-' }}</td>
        <td>{{ $row->rolename ?? '-' }}</td>
        <td>{{ $row->date ?? '-' }}</td>
        <td>{{ $row->month ?? '-' }}</td>
        <td>{{ $row->client_name ?? '-' }}</td>
        <td>
            @if (!empty($row->assignment_name))
                {{ $row->assignment_name }}
                @if (!empty($row->assignmentname))
                    ({{ $row->assignmentname }})
                @endif
            @else
                {{ $row->assignmentname ?? '-' }}
            @endif
        </td>
        <td>{{ $row->assignmentgenerate_id ?? '-' }}</td>
        <td>{{ $row->workitem ?? '-' }}</td>
        <td>{{ $row->teampartner ?? '-' }}</td>
        <td>{{ $row->hour ?? '-' }}</td>
        <td>{{ $row->billable_status ?? '-' }}</td>
    </tr>
@empty
    <tr>
        <td colspan="12" class="text-center">No Data Found</td>
    </tr>
@endforelse
