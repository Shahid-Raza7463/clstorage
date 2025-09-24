{{-- *   --}}
{{--  Start Hare --}}
{{-- *   --}}
{{--  Start Hare --}}
{{-- *   --}}
{{--  Start Hare --}}
{{-- * --}}
{{--  Start Hare --}}
$("#otpmessage1", "#otpmessage3", "#otpmessage", "#otpmessage2").text('');
{{-- resources\views\backEnd\timesheet\create.blade.php
find  $('#partner1').on('change', function() { --}}
<script>
    $(function() {
        // Function to handle client selection
        function handleClientSelection(client, assignment, partner) {
            var clientValue = $(client).val();
            var assignmentValue = $(assignment).val();
            var partnerValue = $(partner).val();

            if (clientValue != "" && clientValue != "Select Client") {
                if (assignmentValue == "Select Assignment" || assignmentValue == "") {
                    alert("Please select an assignment");
                    $(assignment).focus();
                    return false;
                } else if (partnerValue == "Select Partner" || partnerValue == "") {
                    alert("Please select a partner");
                    $(partner).focus();
                    return false;
                }
            }
            return true;
        }

        // Event listeners for client selections
        $('#timesheet-form').on('submit', function(e) {
            if (!handleClientSelection('#client1', '#assignment1', '#partner1')) {
                e.preventDefault();
            }
        });

        $('#timesheet-form').on('submit', function(e) {
            if (!handleClientSelection('#client2', '#assignment2', '#partner2')) {
                e.preventDefault();
            }
        });

        $('#timesheet-form').on('submit', function(e) {
            if (!handleClientSelection('#client3', '#assignment3', '#partner3')) {
                e.preventDefault();
            }
        });

        $('#timesheet-form').on('submit', function(e) {
            if (!handleClientSelection('#client4', '#assignment4', '#partner4')) {
                e.preventDefault();
            }
        });

        // Event listeners for partner selection
        $('[id^=partner]').on('change', function() {
            var partnerValue = $(this).val();
            var index = $(this).attr('id').slice(-1);
            $('.workItem' + index).prop('required', true);
            $('.location' + index).prop('required', true);
            $('.hour' + index).prop('required', true);
        });
    });
</script>
