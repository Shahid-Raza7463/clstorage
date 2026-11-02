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

    </div>

    <!-- End Page Title -->



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

                            {{-- slider speed and slider controler normal "delay": 5000 and  "speed": 600, --}}

                            <script type="application/json" class="swiper-config">

                                {

                                  "loop": true,

                                  "speed": 1700,

                                  "autoplay": {

                                    "delay": 3000

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

                                <img src="{{ asset('img/portfolio/project-portfolio (2).png') }}" alt="">

                            </div>

                            <div class="swiper-slide">

                                <img src="{{ asset('img/portfolio/project-portfolio (4).png') }}" alt="">

                            </div>

                            <div class="swiper-slide">

                                <img src="{{ asset('img/portfolio/project-portfolio (5).png') }}" alt="">

                            </div>

                            <div class="swiper-slide">

                                <img src="{{ asset('img/portfolio/project-portfolio (3).png') }}" alt="">

                            </div>

                            <div class="swiper-slide">

                                <img src="{{ asset('img/portfolio/project-portfolio (1).png') }}" alt="">

                            </div>

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

                            <li><strong>Project Title</strong>: Portfolio</li>

                            <li><strong>Category</strong>: Web Design</li>

                            {{-- <li><strong>Client</strong>: ASU Company</li> --}}

                            <li><strong>Company</strong>: Capitall India Private Limited</li>

                            <li><strong>Project date</strong>: 01 October, 2023</li>
                            <li><strong>Tools & Technologies</strong>: Php, Laravel, Mysql, Ajax, Json, JavaScript,
                                HTML, CSS, jQuery, Bootstrap,</li>

                            <li><strong>Project URL</strong>:</li>

                            <li><a href="http://shahid1.infinityfreeapp.com"
                                    target="_blank">http://shahid1.infinityfreeapp.com</a></li>

                        </ul>

                    </div>

                </div>

            </div>



            <!-- Project Description -->

            <div class="portfolio-description" data-aos="fade-up" data-aos-delay="300"
                style="margin-top: 30px; font-size: 1.05rem; line-height: 1.8; padding: 25px; background-color: #fff; border-radius: 10px;">

                <h5><strong>Portfolio:</strong></h5>

                <p>

                    Welcome to my portfolio website! This is a comprehensive showcase of my professional journey,

                    skills, and projects.

                    Through this platform, I aim to provide a clear and organized overview of my work and experiences,

                    all managed

                    seamlessly through an intuitive admin dashboard.

                </p>

                <p><b style="color: #0040f0;">Note: </b>Admin can manage all front-end functionalities through the admin

                    dashboard</p>

                <ul style="line-height: 1.9; margin-top: 20px; padding-left: 20px;">

                    <li><strong>Home</strong>: The homepage provides a brief introduction to me and my professional

                        journey.

                        It serves as an overview of my portfolio and allows visitors to explore further.</li>

                    <li><strong>About</strong>: This section is dedicated to sharing more about me, including my

                        background,

                        skills, and what drives my passion for web development.</li>

                    <li><strong>Resume</strong>: In this section, you can find detailed information about my education,

                        professional experience, technical skills, and certifications.</li>

                    <li><strong>Portfolio</strong>: A collection of projects that I have worked on, showcasing my

                        technical

                        expertise and ability to deliver innovative solutions. Each project is described in detail with

                        its key features.</li>

                    <li><strong>Contact</strong>: This section provides my contact information, including email, phone

                        number,

                        and a contact form for inquiries. It also includes my location for better accessibility.</li>

                </ul>

            </div>

        </div>

    </section>

</main>
