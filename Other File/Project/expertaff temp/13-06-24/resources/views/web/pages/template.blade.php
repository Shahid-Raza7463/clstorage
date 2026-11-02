<html lang="en">
<!-- Required meta tags -->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Latest compiled and minified CSS 22-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
    <!-- multi select 22-->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/css/multi-select-tag.css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer">
    <!-- Custom CSS -->
    <link href="{{ asset('web/css/index.css') }}" rel="stylesheet">
    <!--responsive css -->
    <link href="{{ asset('web/css/responsive.css') }}" rel="stylesheet">
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <!--javascript -->
    <script src="{{ asset('web/js/index.js') }}"></script>
    {{-- for google recapcha --}}
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <!-- Include the Font Awesome JS (if needed) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    {{-- implement lightbox for review image --}}
    <link href="{{ asset('web/css/lightbox.min.css') }}" rel="stylesheet">
    <script src="{{ asset('web/js/lightbox.min.js') }}"></script>
    {{-- include header js from admin dashboard --}}
    {!! $web_logo[6]['option_value'] !!}
    {{-- Seo Tag --}}
    @yield('seo')
</head>

<body>
    <!-- Header Nav -->
    <nav class="navbar navbar-expand-lg navbar-dark header-nav">
        <div class="container-fluid nav-text">
            <ul class="navbar-nav">
                <li class="nav-item mx-1">
                    <a class="nav-link" aria-current="page" href="{{ url('/networks/create') }}">Add
                        Network/Program</a>
                </li>
            </ul>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse nav-head justify-content-end" id="navbarSupportedContent">
                <ul class="navbar-nav">
                    <li class="nav-item mx-2">
                        <a class="nav-link h-nav" aria-current="page" href="{{ url('/') }}">Networks</a>
                    </li>

                    <li class="nav-item mx-2">
                        <a class="nav-link h-nav" href="{{ url('/offers') }}">Offers</a>
                    </li>


                    <li class="nav-item mx-2">
                        <a class="nav-link h-nav" href="{{ url('/resources') }}">Resources</a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link h-nav" href="{{ url('/reviews') }}">Reviews</a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link h-nav" href="{{ url('/blogs') }}">Blog</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Search Navigation -->
    <nav class="navbar navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}"><img src="{{ asset($web_logo[0]['option_value']) }}"
                    class="logo-img img-fluid"></a>
            <form class="d-flex search-form" action="/affiliate-networks#network">
                <div class="input-group">
                    {{-- searching functionality --}}
                    <button class="input-group-text search-field basic-addon1"><i class="fa fa-search text-light mx-1"
                            aria-hidden="true"></i></button>
                    <input type="search" name="search" value="{{ isset($search) ? $search : '' }}"
                        class="form-control input-text" placeholder="Search Network" aria-label="Search"
                        aria-describedby="basic-addon1" fdprocessedid="frpdeh">
                </div>
            </form>
        </div>
    </nav>
    <!-- content -->
    <div class=" top-div bg-light">
        <section class="content">
            <div class="col">
                @yield('content')
            </div>
        </section>
        <!-- /.content -->
        <!-- Footer -->
        <div class="container" style="background-color: #f3f3f3;">
            <div class=" mt-5 mx-5 footer-div">
                <footer class="footer">
                    <div class="footer-cols">
                        <ul>
                            <li>
                                <h5>Site Links</h5>
                            </li>
                            {{-- <li><a href="#">Search Network</a></li>
                            <li><a href="#">Industry News</a></li> --}}
                            <li><a href="{{ url('/resources') }}">Resources</a></li>
                            <li><a href="{{ url('/blogs') }}">Blog</a></li>
                        </ul>
                        <ul>
                            <li>
                                <h5>Industry Friends</h5>
                            </li>
                            {{-- <li><a href="https://affiedeal.co.in/">AffDeal</a></li>
                            <li><a href="https://www.affvoice.com/">AffVoice</a></li> --}}
                            <li><a href="{{ url('/contact') }}">Contact Us</a></li>
                        </ul>
                        <ul>
                            <li class="p-4" style="background-color: #f3f3f3;">
                                <h5>Connect with us</h5>
                                <a href="https://www.linkedin.com/company/trakaff/" class="text-primary">LinkedIn</a>
                                <h5 class="mt-4">Advertise on this Site</h5>
                                <a href="https://www.facebook.com/trakaff/" class="text-primary">Facebook</a>
                            </li>
                        </ul>
                    </div>
                </footer>
            </div>
        </div>
        <div class="container" style="background-color: #2C1B47;">
            <div class="d-flex justify-content-between text-light copyright">
                <p class="m-1">Copyright © 2023 ExpertAff All rights reserved.</p>
                <a href="{{ url('/networks/create') }}" class="m-1 text-light">Add Network / Program</a>
            </div>
        </div>
    </div>
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script type="text/javascript" src="index.js"></script>

    <!-- multi slide crousel -->
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
    <script
        src="https://cdn.jsdelivr.net/npm/@splidejs/splide-extension-auto-scroll@0.5.3/dist/js/splide-extension-auto-scroll.min.js">
    </script>
    <script>
        const splide = new Splide('.splide', {
            type: 'loop',
            drag: 'free',
            focus: 'center',
            perPage: 6,
            autoScroll: {
                speed: 1,
            },
        }).mount(window.splide.Extensions);

        splide.mount();
    </script>

    <!--reply function-->
    <script>
        // Get all reply buttons
        const replyButtons = document.querySelectorAll('.reply-btn');

        // Add event listeners to each reply button
        replyButtons.forEach(button => {
            button.addEventListener('click', () => {
                // Toggle the display of the reply section
                const replySection = button.parentElement.querySelector('.reply-section');
                replySection.style.display = replySection.style.display === 'none' ? 'block' : 'none';
            });
        });

        // Get all reply inputs
        const replyInputs = document.querySelectorAll('.reply-input');

        // Add event listeners to each reply input
        replyInputs.forEach(input => {
            input.addEventListener('click', () => {
                // Expand the input field
                input.classList.add('reply-input-expanded');
            });

            input.addEventListener('blur', () => {
                // Collapse the input field if it's empty
                if (input.value === '') {
                    input.classList.remove('reply-input-expanded');
                }
            });
        });

        // Get all send reply buttons
        const sendReplyButtons = document.querySelectorAll('.send-reply-btn');

        // Add event listeners to each send reply button
        sendReplyButtons.forEach(button => {
            button.addEventListener('click', () => {
                // Get the input field and the reply message
                const replyInput = button.parentElement.parentElement.querySelector('.reply-input');
                const replyMessage = replyInput.value;

                // Create a new reply message element
                const reply = document.createElement('div');
                reply.classList.add('message', 'reply');
                reply.innerHTML = `<p>${replyMessage}</p>`;

                // Append the reply message after the original message
                button.parentElement.parentElement.appendChild(reply);

                // Clear the input field
                replyInput.value = '';

                // Collapse the input field
                replyInput.classList.remove('reply-input-expanded');

                // Hide the reply section
                button.parentElement.style.display = 'none';
            });
        });
        // Get all cancel reply buttons
        const cancelReplyButtons = document.querySelectorAll('.cancel-reply-btn');

        // Add event listeners to each cancel reply button
        cancelReplyButtons.forEach(button => {
            button.addEventListener('click', () => {
                const replyInput = button.parentElement.parentElement.querySelector('.reply-input');

                // Clear the input field
                replyInput.value = '';

                // Collapse the input field
                replyInput.classList.remove('reply-input-expanded');
                // Hide the reply section
                button.parentElement.style.display = 'none';

            });
        });
    </script>

    <!-- Latest compiled and minified JavaScript 222-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/js/multi-select-tag.js"></script>

    <script>
        new MultiSelectTag('countries') // id
        new MultiSelectTag('commission') // id
        new MultiSelectTag('payment') // id
        new MultiSelectTag('paymentmethod') // id
    </script>

    {{-- set active and inactive nav tab --}}
    <script>
        // Get the current URL
        const currentUrl = window.location.href;
        const menuItems = document.querySelectorAll('nav a');
        menuItems.forEach((menuItem) => {
            if (menuItem.href === currentUrl) {
                menuItem.classList.add('active');
            }
        });
    </script>

    {{-- include footer js from admin dashboard --}}
    {!! $web_logo[7]['option_value'] !!}

</body>

</html>
