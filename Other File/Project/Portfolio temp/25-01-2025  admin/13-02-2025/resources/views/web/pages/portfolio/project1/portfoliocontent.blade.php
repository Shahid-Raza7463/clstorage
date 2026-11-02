<main class="main">
    <!-- Page Title -->
    <div class="page-title dark-background">
        <div class="container d-lg-flex justify-content-between align-items-center">
            <h1 class="mb-2 mb-lg-0">Portfolio Details</h1>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li class="current">Portfolio Details</li>
                </ol>
            </nav>
        </div>
    </div><!-- End Page Title -->

    <!-- Portfolio Details Section -->
    <!--<section id="portfolio-details" class="portfolio-details section" style="padding: 60px 0; background-color: #f7f9fc;"> -->
    <section id="portfolio-details" class="portfolio-details section" style="padding: 60px 0;">
        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="row gy-4">

                <!-- Image Carousel -->
                <div class="col-lg-8">
                    <div class="portfolio-details-slider swiper init-swiper"
                        style="box-shadow: 0 8px 16px rgba(0,0,0,0.1); border-radius: 10px; ">
                        <div class="swiper-wrapper align-items-center">
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
                                  }
                                }
                              </script>
                            <div class="swiper-slide">
                                <img src="{{ asset('img/portfolio/project-sopping (1).jpg') }}" alt="">
                            </div>

                            <div class="swiper-slide">
                                <img src="{{ asset('img/portfolio/project-sopping (4).png') }}" alt="">
                            </div>

                            <div class="swiper-slide">
                                <img src="{{ asset('img/portfolio/project-sopping (5).png') }}" alt="">
                            </div>

                            <div class="swiper-slide">
                                <img src="{{ asset('img/portfolio/project-sopping (6).png') }}" alt="">
                            </div>

                            <div class="swiper-slide">
                                <img src="{{ asset('img/portfolio/project-sopping (1).png') }}" alt="">
                            </div>

                            <div class="swiper-slide">
                                <img src="{{ asset('img/portfolio/project-sopping (2).png') }}" alt="">
                            </div>

                            <div class="swiper-slide">
                                <img src="{{ asset('img/portfolio/project-sopping (3).png') }}" alt="">
                            </div>

                            <div class="swiper-slide">
                                <img src="{{ asset('img/portfolio/project-sopping (7).png') }}" alt="">
                            </div>

                            <div class="swiper-slide">
                                <img src="{{ asset('img/portfolio/project-sopping (8).png') }}" alt="">
                            </div>
                            {{-- if more than 5 then copy paste above line --}}
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>

                <!-- Project Info -->
                <div class="col-lg-4">
                    <div class="portfolio-info" data-aos="fade-up" data-aos-delay="200"
                        style="background-color: #fff; padding: 35px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); height: 506px;">
                        <h3>Project information</h3>
                        <ul>
                            <li><strong>Project Title</strong>: Shopping Mart</li>
                            <li><strong>Category</strong>: Web design</li>
                            {{-- <li><strong>Client</strong>: ASU Company</li> --}}
                            <li><strong>College</strong>: ISM</li>
                            <li><strong>Project date</strong>: 1 Julu, 2022</li>
                            <li><strong>Tools & Technologies</strong>: Php, Mysql, Ajax, Json, JavaScript,
                                HTML, CSS, jQuery, Bootstrap,</li>
                            <li><strong>Project URL</strong>:</li>
                            <li><a href="https://github.com/Shahid-Raza7463/E-commerce-website-shopping-mart"
                                    target="_blank">https://shopping.mart.com</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Project Description -->
            <div class="portfolio-description" data-aos="fade-up" data-aos-delay="300"
                style="margin-top: 30px; font-size: 1.05rem; line-height: 1.8; padding: 25px; background-color: #fff; border-radius: 10px;">
                <h5><strong>Shopping Mart:</strong></h5>

                <p>My second project, Shopping Mart, is an e-commerce website that I developed during my college
                    years. The platform allows users to browse products, view detailed product information, and
                    in the future, purchase items. While the payment system is not yet implemented, this feature
                    is planned for future updates.</p>
                <p>To build this project, I utilized HTML, CSS, and JavaScript for the frontend, and PHP with
                    MySQL for the backend. The site includes essential features such as user authentication,
                    allowing users to sign up, log in, and log out. Additionally, users can submit their
                    location, which will enable efficient product delivery when the shopping feature is fully
                    functional.</p>
                {{-- <ul style="line-height: 1.9; margin-top: 20px; padding-left: 20px;">
                    <li><strong>Add Network/Program</strong>: Allows users to create new networks.</li>
                    <li><strong>Networks</strong>: View and manage all listed networks in one place.</li>
                    <li><strong>Offers</strong>: Lists all available offers related to the networks.</li>
                    <li><strong>Resources</strong>: Provides resources related to affiliate marketing.</li>
                    <li><strong>Reviews</strong>: Allows users to give reviews on networks and reply to them.
                    </li>
                    <li><strong>Blog</strong>: Users can create and browse blogs related to affiliate marketing.
                    </li>
                </ul> --}}
            </div>
        </div>
    </section>
</main>
