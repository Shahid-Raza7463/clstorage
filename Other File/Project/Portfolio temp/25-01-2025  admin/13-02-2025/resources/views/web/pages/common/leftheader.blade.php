<header id="header" class="header dark-background d-flex flex-column">
    <i class="header-toggle d-xl-none bi bi-list"></i>

    <div class="profile-img">
        {{-- <img src="assets/img/my-profile-img.jpg" alt="" class="img-fluid rounded-circle"> --}}
        {{-- <img src="{{ asset('img/my-profile-img.jpg') }}" alt="" class="img-fluid rounded-circle"> --}}
        {{-- <img src="{{ asset('img/my-profile-img (2).png') }}" alt="" class="img-fluid rounded-circle"> --}}
        {{-- <img src="{{ asset('img/my-profile-img (3).png') }}" alt="" class="img-fluid rounded-circle"> --}}
        <img src="{{ asset('img/my-profile-img1 (1).png') }}" alt="" class="img-fluid rounded-circle">
    </div>

    <a href="{{ url('/') }}" class="logo d-flex align-items-center justify-content-center">

        {{-- <img src="{{ asset('img/logo.png') }}" alt=""> --}}
        <h1 class="sitename">Shahid Raza</h1>
    </a>

    <div class="social-links text-center">
        <a href="https://wa.me/917488952139" class="whatsapp" target="_blank">
            <i class="bi bi-whatsapp"></i>
        </a>
        {{-- <a href="https://www.facebook.com/md.shahidraza.3954546?mibextid=ZbWKwL" class="facebook" target="_blank">
            <i class="bi bi-facebook"></i>
        </a> --}}
        <a href="https://www.facebook.com/share/UbuEW2ucYCpR4MBK/?mibextid=qi2Omg" class="facebook" target="_blank">
            <i class="bi bi-facebook"></i>
        </a>
        {{-- <a href="https://www.instagram.com/shahil_solo_boy?utm_source=qr&igsh=bWk2dnU3MTliejdm" class="instagram"
            target="_blank">
            <i class="bi bi-instagram"></i>
        </a> --}}
        <a href="#" class="instagram" target="_blank">
            <i class="bi bi-instagram"></i>
        </a>
        <a href="https://github.com/Shahid-Raza7463?tab=repositories" class="github" target="_blank">
            <i class="bi bi-github"></i>
        </a>
        <a href="https://www.linkedin.com/in/mdshahidraza7886" class="linkedin" target="_blank">
            <i class="bi bi-linkedin"></i>
        </a>
    </div>
    <nav id="navmenu" class="navmenu">
        <ul>
            <li><a href="#hero" class="active"><i class="bi bi-house navicon"></i>Home</a></li>
            <li><a href="#about"><i class="bi bi-person navicon"></i> About</a></li>
            <li><a href="#resume"><i class="bi bi-file-earmark-text navicon"></i> Resume</a></li>
            <li><a href="#portfolio"><i class="bi bi-images navicon"></i> Portfolio</a></li>
            {{-- <li><a href="#services"><i class="bi bi-hdd-stack navicon"></i> Services</a></li> --}}
            {{-- <li class="dropdown"><a href="#"><i class="bi bi-menu-button navicon"></i> <span>Dropdown</span>
                    <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                <ul>
                    <li><a href="#">Dropdown 1</a></li>
                    <li class="dropdown"><a href="#"><span>Deep Dropdown</span> <i
                                class="bi bi-chevron-down toggle-dropdown"></i></a>
                        <ul>
                            <li><a href="#">Deep Dropdown 1</a></li>
                            <li><a href="#">Deep Dropdown 2</a></li>
                            <li><a href="#">Deep Dropdown 3</a></li>
                            <li><a href="#">Deep Dropdown 4</a></li>
                            <li><a href="#">Deep Dropdown 5</a></li>
                        </ul>
                    </li>
                    <li><a href="#">Dropdown 2</a></li>
                    <li><a href="#">Dropdown 3</a></li>
                    <li><a href="#">Dropdown 4</a></li>
                </ul>
            </li> --}}
            <li><a href="#contact"><i class="bi bi-envelope navicon"></i> Contact</a></li>
        </ul>
    </nav>

</header>
