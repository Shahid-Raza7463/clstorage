<main class="main">
    {{-- Android application styling --}}
    <style>
        /* General styles for responsiveness */
        .responsive-image {

            /* height: 360px;
            width: 230px; */

            /* height: 446px;
            width: 290px; */

            /* height: 446px;
            width: 280px; */

            height: 400px;
            width: 280px;
        }

        /* Adjust parent container for better control */
        .portfolio-image-container {
            height: auto;
            width: 100%;
            display: flex;
            justify-content: center;
            /* background-color: red; */
        }

        /* Media query for smaller screens */
        @media (max-width: 759px) {
            .hello {
                /* background-color: pink; */
                width: 33rem;
            }

            .portfolio-image-container {
                height: 446px;
            }

            .responsive-image {
                height: 100%;
                width: auto;
            }
        }

        /* Media query for smaller screens (up to 576px) */
        @media (max-width: 576px) {
            .hello {
                /* background-color: green; */
                width: 35rem;
                /* margin-left: 1rem */
                /* Adjust the width for smaller screens */
            }

            .portfolio-image-container {
                height: 446px;
                /* Adjust the height for smaller screens */
            }

            .responsive-image {
                height: 100%;
                /* width: auto; */
                width: 350px;
                /* Maintain aspect ratio */
            }
        }
    </style>
    {{-- Android application styling end hare --}}

    <!-- Hero Section -->
    <section id="hero" class="hero section dark-background">
        {{-- <img src="{{ asset('img/hero-bg.jpg') }}" alt="" data-aos="fade-in" class=""> --}}
        <img src="{{ asset($homeimages->image) }}" alt="" data-aos="fade-in" class="">
        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <h2>{{ $homeimages->name }}</h2>
            <p>I'm <span class="typed" data-typed-items= "{{ $homeimages->skills }}">Developer</span><span
                    class="typed-cursor typed-cursor--blink" aria-hidden="true"></span><span
                    class="typed-cursor typed-cursor--blink" aria-hidden="true"></span></p>
        </div>
    </section>
    <!-- /Hero Section -->

    <!-- About Section -->
    <section id="about" class="about section">
        <div class="container section-title" data-aos="fade-up">
            <h2>About</h2>
            <p>{{ $about->description }}</p>
        </div>
        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="row gy-4 justify-content-center">
                <div class="col-lg-4">
                    <img src="{{ asset($about->image) }}" class="img-fluid" alt="">
                </div>
                <div class="col-lg-8 content">
                    <h2>{{ $about->skillheading }}</h2>
                    <p class="py-3">
                        {{ $about->skilldescription1 }}
                    </p>
                    <p> {{ $about->skilldescription2 }}</p>
                    <div class="row">
                        <div class="col-lg-6">
                            <ul>
                                <li><i class="bi bi-chevron-right"></i> <strong>Birthday:</strong>
                                    <span>{{ date('d-M-Y', strtotime($about->dateofbirth)) }}</span>
                                </li>
                                <li><i class="bi bi-chevron-right"></i> <strong>Website:</strong>
                                    <span>{{ $about->websitelink }}</span>
                                </li>
                                <li><i class="bi bi-chevron-right"></i> <strong>Phone:</strong>
                                    <span>+91{{ $about->mobile_no }}</span>
                                </li>
                                <li><i class="bi bi-chevron-right"></i> <strong>City:</strong>
                                    <span>{{ $about->cityname }}</span>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-6">
                            <ul>
                                <li><i class="bi bi-chevron-right"></i> <strong>Age:</strong>
                                    <span>{{ \Carbon\Carbon::parse($about->dateofbirth)->age }}</span>
                                </li>
                                <li><i class="bi bi-chevron-right"></i> <strong>Degree:</strong>
                                    <span>{{ $about->degree }}</span>
                                </li>
                                <li><i class="bi bi-chevron-right"></i> <strong>Email:</strong>
                                    <span>{{ $about->emailid }}</span>
                                </li>
                                <li><i class="bi bi-chevron-right"></i> <strong>Freelance:</strong>
                                    <span>{{ $about->freelance }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /About Section -->

    <!-- Skills Section -->
    <section id="skills" class="skills section light-background">
        <div class="container section-title" data-aos="fade-up">
            <h2>Skills</h2>
            <p>Basic knowledge in
                @foreach ($skills as $skill)
                    {{ $skill->skill_name }}
                    @if (count((array) $skill->skill_name) > 1)
                        ,
                    @endif
                @endforeach
            </p>
        </div>
        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="row skills-content skills-animation">
                @php
                    // Skills data ko half-half split karte hain
                    $half = ceil($skills->count() / 2);
                    $skillsChunked = $skills->chunk($half);
                @endphp

                @foreach ($skillsChunked as $chunk)
                    <div class="col-lg-6">
                        @foreach ($chunk as $skill)
                            <div class="progress">
                                <span class="skill"><span>{{ $skill->skill_name }}</span> <i
                                        class="val">{{ $skill->skill_rating }}%</i></span>
                                <div class="progress-bar-wrap">
                                    <div class="progress-bar" role="progressbar"
                                        aria-valuenow="{{ $skill->skill_rating }}" aria-valuemin="0"
                                        aria-valuemax="100">
                                    </div>
                                </div>
                            </div>
                            <!-- End Skills Item -->
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- /Skills Section -->

    <!--Resume Section-->
    <section id="resume" class="resume section">
        <div class="container section-title" data-aos="fade-up">
            <h2>Resume</h2>
            <p>{{ $resumes->description }}</p>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                    <h3 class="resume-title">Objective</h3>
                    <div class="resume-item pb-0">
                        <p>{{ $resumes->objective }}</p>
                    </div>
                    <h3 class="resume-title">Education</h3>
                    @foreach ($educations as $education)
                        <div class="resume-item">
                            <h4>{{ $education->degreename }}</h4>
                            <h5>{{ $education->startdate }} - {{ $education->enddate }}</h5>
                            <p><em>{{ $education->universityname }}</em></p>
                            <p>
                                @if (!empty($education->grade))
                                    Grade: {{ $education->grade }} CGPA
                                    @if (!empty($education->percentage))
                                        /
                                    @endif
                                @endif
                                @if (!empty($education->percentage))
                                    Percentage: {{ $education->percentage }}%
                                @endif
                            </p>
                        </div>
                    @endforeach
                    <h3 class="resume-title">Technical Skills</h3>
                    <div class="resume-item pb-0">
                        <ul>
                            <li>{{ $resumes->technicalskills }}</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
                    <h3 class="resume-title">Professional Experience</h3>
                    @foreach ($experiences as $experience)
                        <div class="resume-item">
                            <h4>{{ $experience->jobname }}</h4>
                            <h5>{{ date('d-m-Y', strtotime($experience->startdate)) }} -
                                {{ date('d-m-Y', strtotime($experience->enddate)) }}</h5>
                            <a href="https://capitall.io/" target="_blank">
                                <p><em>{{ $experience->companyname }}</em></p>
                            </a>
                            <ul>
                                {!! $experience->jobdescription !!}
                            </ul>
                        </div>
                        <!-- End Resume Item -->
                    @endforeach

                    <h3 class="resume-title">Certifications & Training</h3>
                    <div class="resume-item pb-0">
                        <ul>
                            {!! $resumes->certificationstraining !!}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /Resume Section -->


    <!-- Portfolio Section -->
    <section id="portfolio" class="portfolio section light-background">
        <div class="container section-title" data-aos="fade-up">
            <h2>Portfolio</h2>
            <p>Welcome to my portfolio. Here you'll find a collection of projects that highlight my expertise in
                software development and web technologies. Each project demonstrates my dedication to creating effective
                solutions and my passion for coding.</p>
        </div>
        <div class="container">
            <div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">
                <ul class="portfolio-filters isotope-filters" data-aos="fade-up" data-aos-delay="100">
                    <li data-filter="*" class="filter-active">All</li>
                    <li data-filter=".filter-product">Product</li>
                    {{-- <li data-filter=".filter-branding">Branding</li> --}}
                    <li data-filter=".filter-books">Books</li>
                    {{-- <li data-filter=".filter-app">App</li> --}}
                    <li data-filter="#">App</li>
                </ul><!-- End Portfolio Filters -->
                <div class="row gy-4 isotope-container" data-aos="fade-up" data-aos-delay="200">
                    @foreach ($portfolios as $portfolio)
                        <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-product">
                            <div class="portfolio-content h-100">
                                <img src="{{ asset($portfolio->projectmage) }}" class="img-fluid" alt="">
                                <div class="portfolio-info">
                                    <h4>{{ $portfolio->projectname }}</h4>
                                    <p>{{ $portfolio->projectdescription }}</p>
                                    <a href="{{ asset($portfolio->projectimagezoom) }}"
                                        data-gallery="portfolio-gallery-product" class="glightbox preview-link"><i
                                            class="bi bi-zoom-in"></i></a>
                                    <a href="{{ url('/portfolio-details/' . $portfolio->id) }}" title="More Details"
                                        class="details-link">
                                        <i class="bi bi-link-45deg"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- End Portfolio Item -->
                    @endforeach
                </div>
            </div>
            <hr />
        </div>

        <div class="container">
            <div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">
                <div class="portfolio-filters isotope-filters" data-aos="fade-up" data-aos-delay="100">
                    <h5>Android applications</h5>
                </div>
                <hr />
                <div class="row gy-4 isotope-container" data-aos="fade-up" data-aos-delay="200">
                    @foreach ($applications as $application)
                        <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-product hello">
                            <div class="portfolio-content h-100">
                                <div class="portfolio-image-container">
                                    <img src="{{ asset($application->projectmage) }}" alt="Portfolio Image"
                                        class="responsive-image">
                                </div>

                                <div class="portfolio-info">
                                    <h4>{{ $application->projectname }}</h4>
                                    <a href="{{ asset($application->projectimagezoom) }}"
                                        data-gallery="portfolio-gallery-product" class="glightbox preview-link"><i
                                            class="bi bi-zoom-in"></i></a>
                                    <a href=" {{ url('/android-app/' . $application->id) }}" title="More Details"
                                        class="details-link">
                                        <i class="bi bi-link-45deg"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- End Portfolio Item -->
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <!-- /Portfolio Section -->

    <!-- Services Section -->
    {{-- <section id="services" class="services section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Services</h2>
            <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint
                consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia
                fugiat sit
                in iste officiis commodi quidem hic quas.</p>
        </div><!-- End Section Title -->

        <div class="container">

            <div class="row gy-4">

                <div class="col-lg-4 col-md-6 service-item d-flex" data-aos="fade-up" data-aos-delay="100">
                    <div class="icon flex-shrink-0"><i class="bi bi-briefcase"></i></div>
                    <div>
                        <h4 class="title"><a href="{{ url('/service-details') }}" class="stretched-link">Lorem
                                Ipsum</a>
                        </h4>
                        <p class="description">shahid deleniti atque corrupti quos dolores et quas molestias
                            excepturi sint
                            occaecati cupiditate non provident</p>
                    </div>
                </div>
                <!-- End Service Item -->

                <div class="col-lg-4 col-md-6 service-item d-flex" data-aos="fade-up" data-aos-delay="200">
                    <div class="icon flex-shrink-0"><i class="bi bi-card-checklist"></i></div>
                    <div>
                        <h4 class="title"><a href="{{ url('/service-details') }}" class="stretched-link">Dolor
                                Sitema</a>
                        </h4>
                        <p class="description">Minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                            aliquip ex ea
                            commodo consequat tarad limino ata</p>
                    </div>
                </div><!-- End Service Item -->

                <div class="col-lg-4 col-md-6 service-item d-flex" data-aos="fade-up" data-aos-delay="300">
                    <div class="icon flex-shrink-0"><i class="bi bi-bar-chart"></i></div>
                    <div>
                        <h4 class="title"><a href="{{ url('/service-details') }}" class="stretched-link">Sed ut
                                perspiciatis</a></h4>
                        <p class="description">Duis aute irure dolor in reprehenderit in voluptate velit esse
                            cillum dolore eu
                            fugiat nulla pariatur</p>
                    </div>
                </div><!-- End Service Item -->

                <div class="col-lg-4 col-md-6 service-item d-flex" data-aos="fade-up" data-aos-delay="400">
                    <div class="icon flex-shrink-0"><i class="bi bi-binoculars"></i></div>
                    <div>
                        <h4 class="title"><a href="{{ url('/service-details') }}" class="stretched-link">Magni
                                Dolores</a></h4>
                        <p class="description">Excepteur sint occaecat cupidatat non proident, sunt in culpa qui
                            officia deserunt
                            mollit anim id est laborum</p>
                    </div>
                </div><!-- End Service Item -->

                <div class="col-lg-4 col-md-6 service-item d-flex" data-aos="fade-up" data-aos-delay="500">
                    <div class="icon flex-shrink-0"><i class="bi bi-brightness-high"></i></div>
                    <div>
                        <h4 class="title"><a href="{{ url('/service-details') }}" class="stretched-link">Nemo
                                Enim</a>
                        </h4>
                        <p class="description">At vero eos et accusamus et iusto odio dignissimos ducimus qui
                            blanditiis
                            praesentium voluptatum deleniti atque</p>
                    </div>
                </div><!-- End Service Item -->

                <div class="col-lg-4 col-md-6 service-item d-flex" data-aos="fade-up" data-aos-delay="600">
                    <div class="icon flex-shrink-0"><i class="bi bi-calendar4-week"></i></div>
                    <div>
                        <h4 class="title"><a href="{{ url('/service-details') }}"
                                class="stretched-link">Eiusmod
                                Tempor</a></h4>
                        <p class="description">Et harum quidem rerum facilis est et expedita distinctio. Nam libero
                            tempore, cum
                            soluta nobis est eligendi</p>
                    </div>
                </div><!-- End Service Item -->

            </div>

        </div>

    </section> --}}
    <!-- /Services Section -->

    <!-- Testimonials Section -->
    {{-- <section id="testimonials" class="testimonials section light-background">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Testimonials</h2>
            <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
        </div><!-- End Section Title -->

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="swiper init-swiper">
                <script type="application/json" class="swiper-config">
        {
          "loop": true,
          "speed": 600,
          "autoplay": {
            "delay": 5000
          },
          "slidesPerView": "auto",
          "pagination": {
            "el": ".swiper-pagination",
            "type": "bullets",
            "clickable": true
          },
          "breakpoints": {
            "320": {
              "slidesPerView": 1,
              "spaceBetween": 40
            },
            "1200": {
              "slidesPerView": 3,
              "spaceBetween": 1
            }
          }
        }
      </script>
                <div class="swiper-wrapper">

                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <p>
                                <i class="bi bi-quote quote-icon-left"></i>
                                <span>Proin iaculis purus consequat sem cure digni ssim donec porttitora entum
                                    suscipit rhoncus.
                                    Accusantium quam, ultricies eget id, aliquam eget nibh et. Maecen aliquam, risus
                                    at semper.</span>
                                <i class="bi bi-quote quote-icon-right"></i>
                            </p>
                            <img src="{{ asset('img/testimonials/testimonials-1.jpg') }}" class="testimonial-img"
                                alt="">
                            <h3>Saul Goodman</h3>
                            <h4>Ceo &amp; Founder</h4>
                        </div>
                    </div><!-- End testimonial item -->

                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <p>
                                <i class="bi bi-quote quote-icon-left"></i>
                                <span>Export tempor illum tamen malis malis eram quae irure esse labore quem cillum
                                    quid malis quorum
                                    velit fore eram velit sunt aliqua noster fugiat irure amet legam anim
                                    culpa.</span>
                                <i class="bi bi-quote quote-icon-right"></i>
                            </p>
                            <img src="{{ asset('img/testimonials/testimonials-2.jpg') }}" class="testimonial-img"
                                alt="">
                            <h3>Sara Wilsson</h3>
                            <h4>Designer</h4>
                        </div>
                    </div><!-- End testimonial item -->

                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <p>
                                <i class="bi bi-quote quote-icon-left"></i>
                                <span>Enim nisi quem export duis labore cillum quae magna enim sint quorum nulla
                                    quem veniam duis
                                    minim tempor labore quem eram duis noster aute amet eram fore quis sint
                                    minim.</span>
                                <i class="bi bi-quote quote-icon-right"></i>
                            </p>
                            <img src="{{ asset('img/testimonials/testimonials-3.jpg') }}" class="testimonial-img"
                                alt="">
                            <h3>Jena Karlis</h3>
                            <h4>Store Owner</h4>
                        </div>
                    </div><!-- End testimonial item -->

                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <p>
                                <i class="bi bi-quote quote-icon-left"></i>
                                <span>Fugiat enim eram quae cillum dolore dolor amet nulla culpa multos export minim
                                    fugiat dolor enim
                                    duis veniam ipsum anim magna sunt elit fore quem dolore labore illum
                                    veniam.</span>
                                <i class="bi bi-quote quote-icon-right"></i>
                            </p>
                            <img src="{{ asset('img/testimonials/testimonials-4.jpg') }}" class="testimonial-img"
                                alt="">
                            <h3>Matt Brandon</h3>
                            <h4>Freelancer</h4>
                        </div>
                    </div><!-- End testimonial item -->

                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <p>
                                <i class="bi bi-quote quote-icon-left"></i>
                                <span>Quis quorum aliqua sint quem legam fore sunt eram irure aliqua veniam tempor
                                    noster veniam sunt
                                    culpa nulla illum cillum fugiat legam esse veniam culpa fore nisi cillum
                                    quid.</span>
                                <i class="bi bi-quote quote-icon-right"></i>
                            </p>
                            <img src="{{ asset('img/testimonials/testimonials-5.jpg') }}" class="testimonial-img"
                                alt="">
                            <h3>John Larson</h3>
                            <h4>Entrepreneur</h4>
                        </div>
                    </div><!-- End testimonial item -->

                </div>
                <div class="swiper-pagination"></div>
            </div>

        </div>

    </section> --}}
    <!-- /Testimonials Section -->

    <!-- Contact Section -->
    <section id="contact" class="contact section">
        <div class="container section-title" data-aos="fade-up">
            <h2>Contact</h2>
            <p>Below is my contact information. Feel free to reach out to me anytime!</p>
        </div>
        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="row gy-4">
                <div class="col-lg-5">
                    <div class="info-wrap">
                        <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="200">
                            <i class="bi bi-geo-alt flex-shrink-0"></i>
                            <div>
                                <h3>Address</h3>
                                <p>{{ $contactdetails->address }}</p>
                            </div>
                        </div>
                        <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
                            <i class="bi bi-telephone flex-shrink-0"></i>
                            <div>
                                <h3>Call Us</h3>
                                <p>+{{ $contactdetails->contact_number }}</p>
                            </div>
                        </div>

                        <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
                            <i class="bi bi-envelope flex-shrink-0"></i>
                            <div>
                                <h3>Email Us</h3>
                                <p>{{ $contactdetails->emailid }}</p>
                            </div>
                        </div>
                        {{-- Go to google map and serach location and click share and click embaded map tab and copy html --}}
                        <iframe src="{{ $contactdetails->maplink }}" frameborder="0"
                            style="border:0; width: 100%; height: 270px;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
                <div class="col-lg-7">
                    <form id="submitform" method="POST" action="{{ url('/contact') }}" class="php-email-form"
                        data-aos="fade-up" data-aos-delay="200" enctype="multipart/form-data">
                        @csrf
                        <div class="row gy-4">
                            <div class="col-md-6">
                                <label for="name-field" class="pb-2">Your Name</label>
                                <input type="text" name="name" id="name-field" class="form-control"
                                    required="">
                            </div>

                            <div class="col-md-6">
                                <label for="email-field" class="pb-2">Your Email</label>
                                <input type="email" class="form-control" name="email" id="email-field"
                                    required="">
                            </div>

                            <div class="col-md-12">
                                <label for="subject-field" class="pb-2">Subject</label>
                                <input type="text" class="form-control" name="subject" id="subject-field"
                                    required="">
                            </div>

                            <div class="col-md-12">
                                <label for="message-field" class="pb-2">Message</label>
                                <textarea class="form-control" name="message" rows="10" id="message-field" required=""></textarea>
                            </div>

                            <div class="col-md-12 text-center">
                                <div class="loading">Loading</div>
                                <div class="error-container1"></div>
                                <div class="success-container1"></div>
                                <button type="submit">Send Message</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- /Contact Section -->

</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#submitform').on('submit', function(e) {
            e.preventDefault();
            // Create a FormData object
            var formData = new FormData(this);
            $('.success-container1').empty();
            $.ajax({
                type: 'POST',
                url: "{{ url('/contact') }}",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.success) {
                        $('.loading').removeClass('d-block');
                        $('.success-container1').html(
                            '<p style="color:green;">Your message has been sent. Thank you!</p>'
                        );
                        $('#submitform')[0].reset();

                    } else {
                        $('.error-container1').html('<p style="color:red;margin: 0px;">' +
                            response
                            .msg + '</p>');
                    }
                },
                error: function(xhr) {
                    var errors = xhr.responseJSON.errors;
                    $('.error-container1').html('');
                    if (errors) {
                        $.each(errors, function(key, value) {
                            $('.error-container1').append(
                                '<p style="color:red;margin: 0px;">' +
                                value + '</p>');
                        });
                    }
                }
            });
        });
    });
</script>
