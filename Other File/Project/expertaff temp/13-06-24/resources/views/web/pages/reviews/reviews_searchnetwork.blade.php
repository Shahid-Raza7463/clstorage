<!--search filter -->
<div class="border rounded mx-3 mt-4">
    <div class="search-bar " style="display:flex;">
        <div class="text-network">
            <p style="margin-right: 9px">Search by Network</p>
        </div>
        <div class="form-container">
            <form class="" action="/affiliate-networks#reviews" style="display:flex;">
                <div>
                    <input type="text" class="form-control" name="searchReviews"
                        value="{{ isset($searchReviews) ? $searchReviews : '' }}" placeholder=" Network Name"
                        id="network-input">
                </div>
                <div>
                    <button type="submit"><i class="fas fa-search"></i></button>
                    <button type="reset" id="clear-button">Clear</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#clear-button').click(function() {
            $('#network-input').val('');
        });
    });
</script>
