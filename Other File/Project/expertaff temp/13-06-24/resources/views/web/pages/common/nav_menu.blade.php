<!-- Nav menu -->
<div class="nav-tabs border mx-3">
    <ul class="nav nav-pills nav-grid">
        <li class="nav-item text-center">
            <a href="{{ url('/') }}" class="nav-link nav-tab-btn border text-dark fw-bold bg-light">
                <i class="fa-solid fa-diagram-project"></i>
                <span class="f-icon">NETWORK</span>
            </a>
        </li>
        <li class="nav-item text-center">
            <a href="{{ url('/offers') }}" class="nav-link nav-tab-btn border text-dark fw-bold bg-light">
                <i class="fa-sharp fa-solid fa-bars"></i>
                <span class="f-icon">OFFERS</span>
            </a>
        </li>
        <li class="nav-item text-center">
            <a href="{{ url('/resources') }}" class="nav-link nav-tab-btn border text-dark fw-bold bg-light">
                <i class="fa-sharp fa-regular fa-folder-open"></i>
                <span class="f-icon">RESOURCES</span>
            </a>
        </li>
        <li class="nav-item text-center">
            <a href="{{ url('/reviews') }}" class="nav-link nav-tab-btn border text-dark fw-bold bg-light">
                <i class="fa-regular fa-file"></i>
                <span class="f-icon">REVIEWS</span>
            </a>
        </li>
    </ul>
</div>

{{-- set active and inactive nav tab --}}
<script>
    // Get the current URL
    const currentUrl = window.location.href;
    const menuItems = document.querySelectorAll('ul a');
    menuItems.forEach((menuItem) => {
        if (menuItem.href === currentUrl) {
            menuItem.classList.add('active');
        }
    });
</script>
