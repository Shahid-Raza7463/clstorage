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
                        style="box-shadow: 0 8px 16px rgba(0,0,0,0.1); border-radius: 10px; width: 302px;">
                        <div class="swiper-wrapper align-items-center">
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
                                <img src="{{ asset('img/app/calcullater (2).png') }}" alt="Image Description"
                                    style="height: 460px; width: 302px;">
                            </div>

                            <div class="swiper-slide">
                                <img src="{{ asset('img/app/calcullater (1).png') }}" alt="Image Description"
                                    style="height: 460px; width: 302px;">
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
                            <li><strong>Project Title</strong>: Calculator App</li>
                            <li><strong>Category</strong>: Mobile App</li>
                            <li><strong>Company</strong>: Capitall India Private Limited</li>
                            <li><strong>Project date</strong>: 01 November, 2024</li>
                            <li><strong>Tools & Technologies</strong>: React Native, Apis, Android Studio</li>
                            <!-- <li><strong>Project URL</strong>:</li>
                            <li><a href="http://shahid1.infinityfreeapp.com"
                                    target="_blank">http://shahid1.infinityfreeapp.com</a></li> -->
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Project Description -->
            <!-- Project Description -->
            <div class="portfolio-description" data-aos="fade-up" data-aos-delay="300"
                style="margin-top: 30px; font-size: 1.05rem; line-height: 1.8; padding: 25px; background-color: #fff; border-radius: 10px;">
                <h5><strong>Calculator App:</strong></h5>
                <p>
                    The Calculator App is one of my beginner-level projects developed while learning mobile app
                    development.
                    This project demonstrates my understanding of user interface design, input handling, and basic
                    computation logic.
                </p>
                <p>
                    The application allows users to input both positive and negative numbers in two input fields. Upon
                    clicking the
                    <strong>"Calculate Total"</strong> button, the app performs the necessary calculations and displays
                    the
                    result instantly.
                </p>
                <ul style="line-height: 1.9; margin-top: 20px; padding-left: 20px;">
                    <li><strong>Features:</strong>
                        <ul>
                            <li>Two input fields to accept positive and negative values.</li>
                            <li>Interactive "Calculate Total" button to perform calculations.</li>
                            <li>Displays the result in real-time with clear visibility.</li>
                        </ul>
                    </li>
                    <li><strong>Technologies Used:</strong> Designed and developed using modern tools and frameworks
                        (e.g., React Native, Apis, Android Studio).</li>
                    <li><strong>Learning Outcome:</strong>
                        <ul>
                            <li>Gained hands-on experience in handling user inputs.</li>
                            <li>Learned basic arithmetic operations and event-driven programming.</li>
                            <li>Improved UI design skills for a seamless user experience.</li>
                        </ul>
                    </li>
                </ul>
                <p>
                    This project served as a foundation for understanding the core concepts of mobile app development
                    and
                    building dynamic applications.
                </p>
            </div>

        </div>
    </section>
</main>
