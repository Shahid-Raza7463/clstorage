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
                                <img src="{{ asset('img/portfolio/project-1 (7).png') }}" alt="">
                            </div>
                            <div class="swiper-slide">
                                <img src="{{ asset('img/portfolio/project-1 (71).png') }}" alt="">
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
                            <li><strong>Project Title</strong>: Google Drive Clone</li>
                            <li><strong>Category</strong>: Web design</li>
                            <li><strong>College</strong>: ISM</li>
                            <li><strong>Project date</strong>: 01 October, 2022</li>
                            <li><strong>Tools & Technologies</strong>: avaScript,
                                HTML, CSS, jQuery, Bootstrap,</li>
                            <li><strong>Project URL</strong>:</li>
                            <li> <a href="https://shahid-raza7463.github.io/Google-drive-clone/"
                                    target="_blank">https://Googledrive.com</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Project Description -->
            <div class="portfolio-description" data-aos="fade-up" data-aos-delay="300"
                style="margin-top: 30px; font-size: 1.05rem; line-height: 1.8; padding: 25px; background-color: #fff; border-radius: 10px;">
                <h5><strong>Google Drive Clone:</strong></h5>
                <p>
                    This project entails developing a cloud-based file management system inspired by Google
                    Drive. It replicates essential features such as file storage, sharing, and organization,
                    providing users with a robust platform for managing their digital files efficiently.
                </p>
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
