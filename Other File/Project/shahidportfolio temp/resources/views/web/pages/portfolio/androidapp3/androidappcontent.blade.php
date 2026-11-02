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
                                <img src="{{ asset('img/app/friendslist (4).png') }}" alt="Image Description"
                                    style="height: 460px; width: 302px;">
                            </div>
                            <div class="swiper-slide">
                                <img src="{{ asset('img/app/friendslist (3).png') }}" alt="Image Description"
                                    style="height: 460px; width: 302px;">
                            </div>
                            <div class="swiper-slide">
                                <img src="{{ asset('img/app/friendslist (2).png') }}" alt="Image Description"
                                    style="height: 460px; width: 302px;">
                            </div>

                            <div class="swiper-slide">
                                <img src="{{ asset('img/app/friendslist (5).png') }}" alt="Image Description"
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
                            <li><strong>Project Title</strong>: FriendsList App</li>
                            <li><strong>Category</strong>: Mobile App</li>
                            <li><strong>Company</strong>: Capitall India Private Limited</li>
                            <li><strong>Project date</strong>: 01 November, 2024</li>
                            <li><strong>Tools & Technologies</strong>: React Native, Apis, Android Studio</li>
                            {{-- <li><strong>Project URL</strong>:</li>
                            <li><a href="http://shahid1.infinityfreeapp.com"
                                    target="_blank">http://shahid1.infinityfreeapp.com</a></li> --}}
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Project Description -->
            <div class="portfolio-description" data-aos="fade-up" data-aos-delay="300"
                style="margin-top: 30px; font-size: 1.05rem; line-height: 1.8; padding: 25px; background-color: #fff; border-radius: 10px;">
                <h5><strong>FriendsList App:</strong></h5>
                <p>
                    The FriendsList App is a simple and interactive application that allows users to manage their list
                    of friends effectively.
                    It provides essential functionalities such as creating, viewing, editing, and deleting friend
                    details, ensuring a smooth user experience.
                </p>
                <ul style="line-height: 1.9; margin-top: 20px; padding-left: 20px;">
                    <li><strong>Login Page:</strong>
                        <ul>
                            <li>When the app opens, users are greeted with a login page.</li>
                            <li>Users need to log in to access the app's features securely.</li>
                        </ul>
                    </li>
                    <li><strong>Home Page:</strong>
                        <ul>
                            <li>Displays a list of all added friends with their basic details.</li>
                            <li>Provides intuitive options to manage friends' data.</li>
                        </ul>
                    </li>
                    <li><strong>Core Functionalities:</strong>
                        <ul>
                            <li><b>Create:</b> Add new friends with their details (e.g., name, contact, etc.).</li>
                            <li><b>View:</b> View detailed information of each friend.</li>
                            <li><b>Edit:</b> Update or modify friend details as needed.</li>
                            <li><b>Delete:</b> Remove friends from the list seamlessly.</li>
                        </ul>
                    </li>
                    <li><strong>Technologies Used:</strong> Designed and developed using modern tools and frameworks
                        (e.g., React Native, Apis, Android Studio).</li>
                    <li><strong>Learning Outcome:</strong>
                        <ul>
                            <li>Gained hands-on experience with CRUD operations.</li>
                            <li>Improved understanding of user authentication and data management.</li>
                            <li>Enhanced UI/UX design skills for building clean and responsive interfaces.</li>
                        </ul>
                    </li>
                </ul>
                <p>
                    The FriendsList App showcases my ability to build functional, user-friendly applications with
                    features that simplify daily tasks, such as managing friends' information.
                </p>
            </div>
        </div>
    </section>
</main>
