@php
    $profileName = $profile->name ?? 'Shahid Raza';
    $profileTitle = $profile->title ?? 'Full Stack Web Developer';
    $typedItems = $profile->typed_items ?? 'Full Stack Web Developer, Software Tester, Laravel Developer';
    $assetPath = fn($path) => asset($path ?: 'img/portfolio/product-1.jpg');
    $webPortfolioItems = $portfolioItems->where('is_mobile', false);
    $androidPortfolioItems = $portfolioItems->where('is_mobile', true);
@endphp

<main class="main">
    <style>
        .responsive-image {
            height: 400px;
            width: 280px;
        }

        .portfolio-image-container {
            height: auto;
            width: 100%;
            display: flex;
            justify-content: center;
        }

        @media (max-width: 759px) {
            .hello {
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

        @media (max-width: 576px) {
            .hello {
                width: 35rem;
            }

            .portfolio-image-container {
                height: 446px;
            }

            .responsive-image {
                height: 100%;
                width: 350px;
            }
        }
    </style>

    <section id="hero" class="hero section dark-background">
        <img src="{{ asset($profile->hero_image ?? 'img/home/home1 (1).jpg') }}" alt="" data-aos="fade-in"
            class="">
        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <h2>{{ $profileName }}</h2>
            <p>I'm <span class="typed" data-typed-items="{{ $typedItems }}">{{ $profileTitle }}</span></p>
        </div>
    </section>

    <section id="about" class="about section">
        <div class="container section-title" data-aos="fade-up">
            <h2>About</h2>
            <p>{{ $profile->about_summary ?? "Hey there, Name's Shahid Raza and I'm a Full Stack Web Developer." }}</p>
        </div>

        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="row gy-4 justify-content-center">
                <div class="col-lg-4">
                    <img src="{{ asset($profile->about_image ?? 'img/my-profile-img (3).png') }}" class="img-fluid"
                        alt="">
                </div>
                <div class="col-lg-8 content">
                    <h2>{{ $profileTitle }}</h2>
                    <p class="py-3">
                        {{ $profile->about_description ?? 'I have completed nearly 9 projects that have helped me become a skilled professional in web development and software testing.' }}
                    </p>
                    <p>
                        {{ $profile->about_extra_description ?? 'I have completed nearly 9 projects that have helped me become a skilled professional in Backend web development.' }}
                    </p>
                    <div class="row">
                        <div class="col-lg-6">
                            <ul>
                                <li><i class="bi bi-chevron-right"></i> <strong>Birthday:</strong>
                                    <span>{{ optional($profile->birthday ?? null)->format('j M Y') ?: '1 Jan 2001' }}</span>
                                </li>
                                <li><i class="bi bi-chevron-right"></i> <strong>Website:</strong>
                                    <span>{{ $profile->website ?? 'www.shahidraza.com' }}</span>
                                </li>
                                <li><i class="bi bi-chevron-right"></i> <strong>Phone:</strong>
                                    <span>{{ $profile->phone ?? '+917488952139' }}</span>
                                </li>
                                <li><i class="bi bi-chevron-right"></i> <strong>City:</strong>
                                    <span>{{ $profile->city ?? 'Sursand, Bihar' }}</span>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-6">
                            <ul>
                                <li><i class="bi bi-chevron-right"></i> <strong>Age:</strong>
                                    <span>{{ $profile->age ?? '23' }}</span>
                                </li>
                                <li><i class="bi bi-chevron-right"></i> <strong>Degree:</strong>
                                    <span>{{ $profile->degree ?? 'Master' }}</span>
                                </li>
                                <li><i class="bi bi-chevron-right"></i> <strong>Email:</strong>
                                    <span>{{ $profile->email ?? 'shahidraza7463@gmail.com' }}</span>
                                </li>
                                <li><i class="bi bi-chevron-right"></i> <strong>Freelance:</strong>
                                    <span>{{ $profile->freelance ?? 'Available' }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if (($profile->stats ?? collect())->isNotEmpty())
        <section id="stats" class="stats section">
            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="row gy-4">
                    @foreach ($profile->stats as $stat)
                        <div class="col-lg-3 col-md-6">
                            <div class="stats-item">
                                <i class="{{ $stat->icon_class }}"></i>
                                <span data-purecounter-start="0" data-purecounter-end="{{ $stat->value }}"
                                    data-purecounter-duration="1" class="purecounter"></span>
                                <p><strong>{{ $stat->label }}</strong> <span>{{ $stat->description }}</span></p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section id="skills" class="skills section light-background">
        <div class="container section-title" data-aos="fade-up">
            <h2>Skills</h2>
            <p>{{ $profile->skills_intro ?? 'Basic knowledge in Php, Laravel, Mysql, Ajax, Json, JavaScript, React Js, Node Js, React Native, HTML, CSS, Bootstrap, jQuery, Git and C Programming.' }}
            </p>
        </div>
        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="row skills-content skills-animation">
                @foreach (($profile->skills ?? collect())->values()->chunk(7) as $skillColumn)
                    <div class="col-lg-6">
                        @foreach ($skillColumn as $skill)
                            <div class="progress">
                                <span class="skill"><span>{{ $skill->name }}</span> <i
                                        class="val">{{ $skill->percentage }}%</i></span>
                                <div class="progress-bar-wrap">
                                    <div class="progress-bar" role="progressbar"
                                        aria-valuenow="{{ $skill->percentage }}" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section id="resume" class="resume section">
        <div class="container section-title" data-aos="fade-up">
            <h2>Resume</h2>
            <p>{{ $profile->resume_intro ?? '' }}</p>
        </div>
        <div class="container">
            <div class="row">
                @foreach (['left' => 100, 'right' => 200] as $column => $delay)
                    <div class="col-lg-6" data-aos="fade-up" data-aos-delay="{{ $delay }}">
                        @foreach (($profile->resumeSections ?? collect())->where('column', $column) as $section)
                            <h3 class="resume-title">{{ $section->name }}</h3>
                            @foreach ($section->items as $item)
                                <div class="resume-item {{ $loop->last ? 'pb-0' : '' }}">
                                    @if ($section->name !== 'Objective' && $item->title !== 'Certificates')
                                        <h4>{{ $item->title }}</h4>
                                    @endif
                                    @if ($item->period)
                                        <h5>{{ $item->period }}</h5>
                                    @endif
                                    @if ($item->subtitle)
                                        @if ($item->link_url)
                                            <a href="{{ $item->link_url }}" target="_blank">
                                                <p><em>{{ $item->subtitle }}</em></p>
                                            </a>
                                        @else
                                            <p><em>{{ $item->subtitle }}</em></p>
                                        @endif
                                    @endif
                                    @if ($item->description)
                                        <p>{{ $item->description }}</p>
                                    @endif
                                    @if ($item->bullets)
                                        <ul>
                                            @foreach ($item->bullets as $bullet)
                                                <li>{{ $bullet }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            @endforeach
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section id="portfolio" class="portfolio section light-background">
        <div class="container section-title" data-aos="fade-up">
            <h2>Portfolio</h2>
            <p>{{ $profile->portfolio_intro ?? '' }}</p>
        </div>
        <div class="container">
            <div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">
                <ul class="portfolio-filters isotope-filters" data-aos="fade-up" data-aos-delay="100">
                    <li data-filter="*" class="filter-active">All</li>
                    @foreach ($portfolioCategories as $category)
                        <li data-filter=".filter-{{ $category->slug }}">{{ $category->name }}</li>
                    @endforeach
                </ul>
                <div class="row gy-4 isotope-container" data-aos="fade-up" data-aos-delay="200">
                    @foreach ($webPortfolioItems as $item)
                        <div
                            class="col-lg-4 col-md-6 portfolio-item isotope-item filter-{{ $item->category->slug ?? 'product' }}">
                            <div class="portfolio-content h-100">
                                <img src="{{ $assetPath($item->image) }}" class="img-fluid" alt="">
                                <div class="portfolio-info">
                                    <h4>{{ $item->title }}</h4>
                                    @if ($item->description)
                                        <p>{{ $item->description }}</p>
                                    @endif
                                    <a href="{{ $assetPath($item->image) }}"
                                        data-gallery="portfolio-gallery-{{ $item->category->slug ?? 'product' }}"
                                        class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                                    @if ($item->details_url)
                                        <a href="{{ url($item->details_url) }}" title="More Details"
                                            class="details-link"><i class="bi bi-link-45deg"></i></a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if ($androidPortfolioItems->isNotEmpty())
                    <div class="portfolio-filters isotope-filters" data-aos="fade-up" data-aos-delay="100">
                        <h5>Android applications</h5>
                    </div>

                    <hr />

                    <div class="row gy-4 isotope-container" data-aos="fade-up" data-aos-delay="200">
                        <style>
                            .borderstyle {
                                border: 1px solid transparent;
                                border-image: linear-gradient(to right, #0c121e, #698cbf) 1;
                            }
                        </style>
                        @foreach ($androidPortfolioItems as $item)
                            <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-product hello">
                                <div class="portfolio-content h-100">
                                    <div class="portfolio-image-container">
                                        <img src="{{ $assetPath($item->image) }}" alt="Portfolio Image"
                                            class="responsive-image borderstyle">
                                    </div>

                                    <div class="portfolio-info">
                                        <h4>{{ $item->title }}</h4>
                                        @if ($item->description)
                                            <p>{{ $item->description }}</p>
                                        @endif
                                        <a href="{{ $assetPath($item->image) }}"
                                            data-gallery="portfolio-gallery-product" class="glightbox preview-link"><i
                                                class="bi bi-zoom-in"></i></a>
                                        @if ($item->details_url)
                                            <a href="{{ url($item->details_url) }}" title="More Details"
                                                class="details-link"><i class="bi bi-link-45deg"></i></a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </section>

    @if (($profile->services ?? collect())->isNotEmpty())
        <section id="services" class="services section">
            <div class="container section-title" data-aos="fade-up">
                <h2>Services</h2>
                <p>{{ $profile->services_intro ?? '' }}</p>
            </div>
            <div class="container">
                <div class="row gy-4">
                    @foreach ($profile->services as $service)
                        <div class="col-lg-4 col-md-6 service-item d-flex" data-aos="fade-up"
                            data-aos-delay="{{ $loop->iteration * 100 }}">
                            <div class="icon flex-shrink-0"><i class="{{ $service->icon_class }}"></i></div>
                            <div>
                                <h4 class="title"><a href="{{ url($service->details_url ?? '/service-details') }}"
                                        class="stretched-link">{{ $service->title }}</a></h4>
                                <p class="description">{{ $service->description }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if (($profile->testimonials ?? collect())->isNotEmpty())
        <section id="testimonials" class="testimonials section light-background">
            <div class="container section-title" data-aos="fade-up">
                <h2>Testimonials</h2>
            </div>
            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="swiper init-swiper">
                    <script type="application/json" class="swiper-config">
                        {"loop": true, "speed": 600, "autoplay": {"delay": 5000}, "slidesPerView": "auto", "pagination": {"el": ".swiper-pagination", "type": "bullets", "clickable": true}, "breakpoints": {"320": {"slidesPerView": 1, "spaceBetween": 40}, "1200": {"slidesPerView": 3, "spaceBetween": 1}}}
                    </script>
                    <div class="swiper-wrapper">
                        @foreach ($profile->testimonials as $testimonial)
                            <div class="swiper-slide">
                                <div class="testimonial-item">
                                    <p><i
                                            class="bi bi-quote quote-icon-left"></i><span>{{ $testimonial->message }}</span><i
                                            class="bi bi-quote quote-icon-right"></i></p>
                                    @if ($testimonial->image)
                                        <img src="{{ asset($testimonial->image) }}" class="testimonial-img"
                                            alt="">
                                    @endif
                                    <h3>{{ $testimonial->name }}</h3>
                                    <h4>{{ $testimonial->designation }}</h4>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </section>
    @endif

    <section id="contact" class="contact section">
        <div class="container section-title" data-aos="fade-up">
            <h2>Contact</h2>
            <p>{{ $profile->contact_intro ?? 'Below is my contact information. Feel free to reach out to me anytime!' }}
            </p>
        </div>
        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="row gy-4">
                <div class="col-lg-5">
                    <div class="info-wrap">
                        @foreach ($profile->contactInfos ?? collect() as $info)
                            <div class="info-item d-flex" data-aos="fade-up"
                                data-aos-delay="{{ 100 + $loop->iteration * 100 }}">
                                <i class="{{ $info->icon_class }} flex-shrink-0"></i>
                                <div>
                                    <h3>{{ $info->label }}</h3>
                                    <p>{{ $info->value }}</p>
                                </div>
                            </div>
                        @endforeach
                        @if ($profile?->map_embed_url)
                            <iframe src="{{ $profile->map_embed_url }}" frameborder="0"
                                style="border:0; width: 100%; height: 270px;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                        @endif
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
</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#submitform').on('submit', function(e) {
            e.preventDefault();
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
                            response.msg + '</p>');
                    }
                },
                error: function(xhr) {
                    var errors = xhr.responseJSON.errors;
                    $('.error-container1').html('');
                    if (errors) {
                        $.each(errors, function(key, value) {
                            $('.error-container1').append(
                                '<p style="color:red;margin: 0px;">' + value +
                                '</p>');
                        });
                    }
                }
            });
        });
    });
</script>
