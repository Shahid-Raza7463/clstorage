{{-- * ajax dd output --}}

when ajax use karte hai to jab uske controller me function me dd() output karte hai to vo inspact karne per network
section me show hoga


{{-- *    alert();  ka use kare --}}
<script>
    $('#client').on('change', function() {
        var cid = $(this).val();
        {{-- !   alert();  ka use kare --}}
        alert(cid);
        $.ajax({
            type: "get",
            url: "{{ url('timesheet/create') }}",
            data: "cid=" + cid,
            success: function(res) {
                $('#assignment').html(res);
            },
            error: function() {},
        });
    });
</script>
