<footer id="footer" class="footer position-relative light-background">
    <div class="container">
        <div class="social-links text-center" style="padding: 12px;">
            @foreach ($socialmedias as $socialmedia)
                <a href="{{ $socialmedia->link }}" class="{{ $socialmedia->socialmedia_name }}" target="_blank"
                    style="margin-right: 0.5rem;">
                    <i class="{{ $socialmedia->icon }}"></i>
                </a>
            @endforeach
        </div>
        <div class="copyright text-center ">
            <p>© <span>Copyright</span> <strong class="px-1 sitename">Shahid Raza</strong> <span></span>
            </p>
        </div>
        {{-- <div class="credits">
            Designed by111 <a href="https://bootstrapmade.com/">BootstrapMade</a>
        </div>

        <div class="credits">
            <a href="{{ url('/starter-page') }}">starter-page</a>
        </div> --}}
    </div>
</footer>
