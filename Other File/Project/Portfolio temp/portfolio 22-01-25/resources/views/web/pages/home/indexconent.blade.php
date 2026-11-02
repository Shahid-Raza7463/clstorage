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
    {{-- @component('web.pages.common.alert')
    @endcomponent --}}
    <section id="hero" class="hero section dark-background">
        {{-- <img src="{{ asset('img/hero-bg.jpg') }}" alt="" data-aos="fade-in" class=""> --}}
        <img src="{{ asset('img\home\home1 (1).jpg') }}" alt="" data-aos="fade-in" class="">

        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <h2>Shahid Raza</h2>
            <p>I'm <span class="typed"
                    data-typed-items="Backend Web Developer, Frontend Web Developer, Full Stack Web Developer, Software Tester">Developer</span><span
                    class="typed-cursor typed-cursor--blink" aria-hidden="true"></span><span
                    class="typed-cursor typed-cursor--blink" aria-hidden="true"></span></p>
        </div>

    </section><!-- /Hero Section -->

    <!-- About Section -->
    <section id="about" class="about section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>About</h2>
            {{-- <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint
                consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia
                fugiat sit
                in iste officiis commodi quidem hic quas.</p> --}}
            <p>Hey there, Name's Shahid Raza and I'm a Full Stack Web Developer,worked @TrakAff as a laravel
                backend web
                developer and currently working as laravel backend web developer @Capitall. I'm proficient in
                working with and implementing backend for web apps using Php, Laravel, Mysql, Ajax, Json,
                JavaScript, React Js, Node Js, React Native, HTML,
                CSS, jQuery, Bootstrap. And I enjoy taking on new challenges.I have 2 year of experience in Backend
                Web
                Development.</p>
        </div><!-- End Section Title -->
        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="row gy-4 justify-content-center">
                <div class="col-lg-4">
                    {{-- <img src="{{ asset('img/my-profile-img1 (1).png') }}" class="img-fluid" alt=""> --}}
                    <img src="{{ asset('img/my-profile-img (3).png') }}" class="img-fluid" alt="">
                </div>
                <div class="col-lg-8 content">
                    {{-- <h2>Full Stack Web Developer &amp; Software Tester.</h2> --}}
                    <h2>Full Stack Web Developer</h2>
                    {{-- <p class="fst-italic py-3">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                        labore et
                        dolore
                        magna aliqua.
                    </p> --}}
                    <p class="py-3">
                        I am currently expanding my skills in React Native and have recently developed an app called
                        FriendsList. This project has allowed me to explore the fundamentals of mobile app
                        development.
                    </p>
                    <p>I have completed nearly 9 projects that have helped me become a skilled professional in
                        Backend web development.</p>
                    <div class="row">
                        <div class="col-lg-6">
                            <ul>
                                <li><i class="bi bi-chevron-right"></i> <strong>Birthday:</strong> <span>1 Jan
                                        2001</span></li>
                                <li><i class="bi bi-chevron-right"></i> <strong>Website:</strong>
                                    <span>shahid1.infinityfreeapp.com</span>
                                </li>
                                <li><i class="bi bi-chevron-right"></i> <strong>Phone:</strong>
                                    <span>+917488952139</span>
                                </li>
                                <li><i class="bi bi-chevron-right"></i> <strong>City:</strong> <span>Sursand,
                                        Sitamarhi,
                                        India</span></li>
                            </ul>
                        </div>
                        <div class="col-lg-6">
                            <ul>
                                <li><i class="bi bi-chevron-right"></i> <strong>Age:</strong> <span>23</span></li>
                                <li><i class="bi bi-chevron-right"></i> <strong>Degree:</strong>
                                    <span>Master</span>
                                </li>
                                <li><i class="bi bi-chevron-right"></i> <strong>Email:</strong>
                                    <span>shahidraza7463@gmail.com</span>
                                </li>
                                <li><i class="bi bi-chevron-right"></i> <strong>Freelance:</strong>
                                    <span>Not Available</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    {{-- <p class="py-3">
                        Officiis eligendi itaque labore et dolorum mollitia officiis optio vero. Quisquam sunt
                        adipisci omnis et
                        ut. Nulla accusantium dolor incidunt officia tempore. Et eius omnis.
                        Cupiditate ut dicta maxime officiis quidem quia. Sed et consectetur qui quia repellendus
                        itaque neque.
                    </p> --}}
                    {{-- <p class="py-3">
                        I have completed nearly 9 projects that have helped me become a skilled professional in
                        Backend web development.
                    </p> --}}

                </div>
            </div>

        </div>

    </section><!-- /About Section -->

    <!-- Stats Section -->
    {{-- <section id="stats" class="stats section">

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="row gy-4">

                <div class="col-lg-3 col-md-6">
                    <div class="stats-item">
                        <i class="bi bi-emoji-smile"></i>
                        <span data-purecounter-start="0" data-purecounter-end="232" data-purecounter-duration="1"
                            class="purecounter"></span>
                        <p><strong>Happy Clients</strong> <span>consequuntur quae</span></p>
                    </div>
                </div><!-- End Stats Item -->

                <div class="col-lg-3 col-md-6">
                    <div class="stats-item">
                        <i class="bi bi-journal-richtext"></i>
                        <span data-purecounter-start="0" data-purecounter-end="521" data-purecounter-duration="1"
                            class="purecounter"></span>
                        <p><strong>Projects</strong> <span>adipisci atque cum quia aut</span></p>
                    </div>
                </div><!-- End Stats Item -->

                <div class="col-lg-3 col-md-6">
                    <div class="stats-item">
                        <i class="bi bi-headset"></i>
                        <span data-purecounter-start="0" data-purecounter-end="1453"
                            data-purecounter-duration="1" class="purecounter"></span>
                        <p><strong>Hours Of Support</strong> <span>aut commodi quaerat</span></p>
                    </div>
                </div><!-- End Stats Item -->

                <div class="col-lg-3 col-md-6">
                    <div class="stats-item">
                        <i class="bi bi-people"></i>
                        <span data-purecounter-start="0" data-purecounter-end="32" data-purecounter-duration="1"
                            class="purecounter"></span>
                        <p><strong>Hard Workers</strong> <span>rerum asperiores dolor</span></p>
                    </div>
                </div><!-- End Stats Item -->

            </div>

        </div>

    </section> --}}
    <!-- /Stats Section -->

    <!-- Skills Section -->
    <section id="skills" class="skills section light-background">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Skills</h2>
            <p>Basic knowledge in Php, Laravel, Mysql, Ajax, Json, JavaScript, React Js, Node Js, React Native, HTML,
                CSS, jQuery, Bootstrap, GitHub, C Programming, MS Power Point, MS Word, MS Excel,
                Touch Typing.</p>
        </div><!-- End Section Title -->

        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="row skills-content skills-animation">
                <div class="col-lg-6">
                    <div class="progress">
                        <span class="skill"><span>PHP</span> <i class="val">80%</i></span>
                        <div class="progress-bar-wrap">
                            <div class="progress-bar" role="progressbar" aria-valuenow="80" aria-valuemin="0"
                                aria-valuemax="100">
                            </div>
                        </div>
                    </div>
                    <!-- End Skills Item -->
                    <div class="progress">
                        <span class="skill"><span>Mysql</span> <i class="val">80%</i></span>
                        <div class="progress-bar-wrap">
                            <div class="progress-bar" role="progressbar" aria-valuenow="80" aria-valuemin="0"
                                aria-valuemax="100">
                            </div>
                        </div>
                    </div>
                    <!-- End Skills Item -->

                    <div class="progress">
                        <span class="skill"><span>Json</span> <i class="val">90%</i></span>
                        <div class="progress-bar-wrap">
                            <div class="progress-bar" role="progressbar" aria-valuenow="90" aria-valuemin="0"
                                aria-valuemax="100">
                            </div>
                        </div>
                    </div>
                    <!-- End Skills Item -->
                    <div class="progress">
                        <span class="skill"><span>jQuery</span> <i class="val">80%</i></span>
                        <div class="progress-bar-wrap">
                            <div class="progress-bar" role="progressbar" aria-valuenow="80" aria-valuemin="0"
                                aria-valuemax="100">
                            </div>
                        </div>
                    </div>
                    <!-- End Skills Item -->
                    <div class="progress">
                        <span class="skill"><span>CSS</span> <i class="val">70%</i></span>
                        <div class="progress-bar-wrap">
                            <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0"
                                aria-valuemax="100">
                            </div>
                        </div>
                    </div>
                    <!-- End Skills Item -->

                    <div class="progress">
                        <span class="skill"><span>React Js</span> <i class="val">60%</i></span>
                        <div class="progress-bar-wrap">
                            <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0"
                                aria-valuemax="100">
                            </div>
                        </div>
                    </div>
                    <!-- End Skills Item -->

                    <div class="progress">
                        <span class="skill"><span>React Native</span> <i class="val">70%</i></span>
                        <div class="progress-bar-wrap">
                            <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0"
                                aria-valuemax="100">
                            </div>
                        </div>
                    </div>
                    <!-- End Skills Item -->

                </div>

                <div class="col-lg-6">
                    <div class="progress">
                        <span class="skill"><span>Laravel</span> <i class="val">80%</i></span>
                        <div class="progress-bar-wrap">
                            <div class="progress-bar" role="progressbar" aria-valuenow="80" aria-valuemin="0"
                                aria-valuemax="100">
                            </div>
                        </div>
                    </div>
                    <!-- End Skills Item -->

                    <div class="progress">
                        <span class="skill"><span>Ajax</span> <i class="val">90%</i></span>
                        <div class="progress-bar-wrap">
                            <div class="progress-bar" role="progressbar" aria-valuenow="90" aria-valuemin="0"
                                aria-valuemax="100">
                            </div>
                        </div>
                    </div><!-- End Skills Item -->

                    <div class="progress">
                        <span class="skill"><span>Javascript</span> <i class="val">80%</i></span>
                        <div class="progress-bar-wrap">
                            <div class="progress-bar" role="progressbar" aria-valuenow="80" aria-valuemin="0"
                                aria-valuemax="100">
                            </div>
                        </div>
                    </div>
                    <!-- End Skills Item -->
                    <div class="progress">
                        <span class="skill"><span>HTML</span> <i class="val">90%</i></span>
                        <div class="progress-bar-wrap">
                            <div class="progress-bar" role="progressbar" aria-valuenow="90" aria-valuemin="0"
                                aria-valuemax="100">
                            </div>
                        </div>
                    </div>
                    <!-- End Skills Item -->
                    <div class="progress">
                        <span class="skill"><span>Bootstrap</span> <i class="val">90%</i></span>
                        <div class="progress-bar-wrap">
                            <div class="progress-bar" role="progressbar" aria-valuenow="90" aria-valuemin="0"
                                aria-valuemax="100">
                            </div>
                        </div>
                    </div>
                    <!-- End Skills Item -->
                    <div class="progress">
                        <span class="skill"><span>Node js</span> <i class="val">60%</i></span>
                        <div class="progress-bar-wrap">
                            <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0"
                                aria-valuemax="100">
                            </div>
                        </div>
                    </div>
                    <!-- End Skills Item -->
                </div>

            </div>

        </div>

    </section><!-- /Skills Section -->

    <!-- Resume Section -->
    <!--   resume 1 -->
    {{-- <section id="resume" class="resume section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Resume</h2>
            <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint
                consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia
                fugiat sit
                in iste officiis commodi quidem hic quas.</p>
        </div><!-- End Section Title -->

        <div class="container">

            <div class="row">

                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                    <h3 class="resume-title">Sumary</h3>

                    <div class="resume-item pb-0">
                        <h4>Brandon Johnson</h4>
                        <p><em>Innovative and deadline-driven Graphic Designer with 3+ years of experience designing
                                and
                                developing user-centered digital/print marketing material from initial concept to
                                final, polished
                                deliverable.</em></p>
                        <ul>
                            <li>Portland par 127,Orlando, FL</li>
                            <li>(123) 456-7891</li>
                            <li>alice.barkley@example.com</li>
                        </ul>
                    </div><!-- Edn Resume Item -->

                    <h3 class="resume-title">Education</h3>
                    <div class="resume-item">
                        <h4>Master of Fine Arts &amp; Graphic Design</h4>
                        <h5>2015 - 2016</h5>
                        <p><em>Rochester Institute of Technology, Rochester, NY</em></p>
                        <p>Qui deserunt veniam. Et sed aliquam labore tempore sed quisquam iusto autem sit. Ea vero
                            voluptatum qui
                            ut dignissimos deleniti nerada porti sand markend</p>
                    </div><!-- Edn Resume Item -->

                    <div class="resume-item">
                        <h4>Bachelor of Fine Arts &amp; Graphic Design</h4>
                        <h5>2010 - 2014</h5>
                        <p><em>Rochester Institute of Technology, Rochester, NY</em></p>
                        <p>Quia nobis sequi est occaecati aut. Repudiandae et iusto quae reiciendis et quis Eius vel
                            ratione eius
                            unde vitae rerum voluptates asperiores voluptatem Earum molestiae consequatur neque
                            etlon sader mart
                            dila</p>
                    </div><!-- Edn Resume Item -->

                </div>

                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
                    <h3 class="resume-title">Professional Experience</h3>
                    <div class="resume-item">
                        <h4>Senior graphic design specialist</h4>
                        <h5>2019 - Present</h5>
                        <p><em>Experion, New York, NY </em></p>
                        <ul>
                            <li>Lead in the design, development, and implementation of the graphic, layout, and
                                production
                                communication materials</li>
                            <li>Delegate tasks to the 7 members of the design team and provide counsel on all
                                aspects of the
                                project. </li>
                            <li>Supervise the assessment of all graphic materials in order to ensure quality and
                                accuracy of the
                                design</li>
                            <li>Oversee the efficient use of production project budgets ranging from $2,000 -
                                $25,000</li>
                        </ul>
                    </div><!-- Edn Resume Item -->

                    <div class="resume-item">
                        <h4>Graphic design specialist</h4>
                        <h5>2017 - 2018</h5>
                        <p><em>Stepping Stone Advertising, New York, NY</em></p>
                        <ul>
                            <li>Developed numerous marketing programs (logos, brochures,infographics, presentations,
                                and
                                advertisements).</li>
                            <li>Managed up to 5 projects or tasks at a given time while under pressure</li>
                            <li>Recommended and consulted with clients on the most appropriate graphic design</li>
                            <li>Created 4+ design presentations and proposals a month for clients and account
                                managers</li>
                        </ul>
                    </div><!-- Edn Resume Item -->

                </div>

            </div>

        </div>

    </section> --}}

    {{-- <!--   resume 2 -->
    <section id="resume" class="resume section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Resume</h2>
            <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint
                consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia
                fugiat sit
                in iste officiis commodi quidem hic quas.</p>
        </div><!-- End Section Title -->

        <div class="container">

            <!-- Personal Information -->
            <div class="row">
                <div class="col-lg-12" data-aos="fade-up" data-aos-delay="100">
                    <h3 class="resume-title">[Your Name]</h3>
                    <p>[Your Address]<br>
                        [City, State, Pincode]<br>
                        [Phone Number] | [Email Address]<br>
                        [LinkedIn Profile] (optional)</p>
                </div>
            </div>

            <!-- Objective -->
            <div class="row">
                <div class="col-lg-12" data-aos="fade-up" data-aos-delay="100">
                    <h3 class="resume-title">Objective</h3>
                    <p>A brief statement (2-3 sentences) summarizing your career goals, skills, and what you aim to
                        achieve in the desired position.</p>
                </div>
            </div>

            <!-- Professional Experience -->
            <div class="row">
                <div class="col-lg-12" data-aos="fade-up" data-aos-delay="200">
                    <h3 class="resume-title">Professional Experience</h3>

                    <!-- Job 1 -->
                    <div class="resume-item">
                        <h4>[Job Title]</h4>
                        <h5>[Company Name] - [City, State]</h5>
                        <p>[Month Year] – [Month Year]</p>
                        <h6>Key Responsibilities:</h6>
                        <ul>
                            <li>Bullet points detailing your primary responsibilities.</li>
                            <li>Focus on specific skills or technologies you used.</li>
                            <li>Include quantifiable achievements or contributions (e.g., "Increased sales by 15%
                                through targeted marketing strategies").</li>
                        </ul>
                        <h6>Key Achievements:</h6>
                        <ul>
                            <li>Highlight major accomplishments in the role.</li>
                            <li>Use bullet points for easy readability.</li>
                        </ul>
                    </div><!-- End Resume Item -->

                    <!-- Repeat for each job -->
                    <!-- Example Job 2 -->
                    <div class="resume-item">
                        <h4>[Another Job Title]</h4>
                        <h5>[Another Company Name] - [City, State]</h5>
                        <p>[Month Year] – [Month Year]</p>
                        <h6>Key Responsibilities:</h6>
                        <ul>
                            <li>List specific duties and responsibilities.</li>
                        </ul>
                        <h6>Key Achievements:</h6>
                        <ul>
                            <li>List key achievements in this role.</li>
                        </ul>
                    </div><!-- End Resume Item -->

                </div>
            </div>

            <!-- Education -->
            <div class="row">
                <div class="col-lg-12" data-aos="fade-up" data-aos-delay="300">
                    <h3 class="resume-title">Education</h3>
                    <div class="resume-item">
                        <h4>[Degree Name (e.g., Bachelor of Technology in Computer Science)]</h4>
                        <p><em>[University/College Name], [City, State]</em></p>
                        <p>[Year of Passing]</p>
                        <p>Percentage/CGPA: [Your Score]</p>
                    </div><!-- End Resume Item -->
                    <!-- Repeat for additional degrees or certifications -->
                </div>
            </div>

            <!-- Technical Skills -->
            <div class="row">
                <div class="col-lg-12" data-aos="fade-up" data-aos-delay="400">
                    <h3 class="resume-title">Technical Skills</h3>
                    <div class="resume-item">
                        <ul>
                            <li>Programming Languages: List relevant languages (e.g., Python, Java, C++)</li>
                            <li>Tools & Technologies: Mention software, tools, or technologies you are proficient in
                                (e.g., MATLAB, Git, Tableau)</li>
                            <li>Frameworks & Libraries: (e.g., React, Django, Angular)</li>
                        </ul>
                    </div><!-- End Resume Item -->
                </div>
            </div>

            <!-- Projects -->
            <div class="row">
                <div class="col-lg-12" data-aos="fade-up" data-aos-delay="500">
                    <h3 class="resume-title">Projects</h3>
                    <div class="resume-item">
                        <h4>[Project Name]</h4>
                        <p>Brief description of the project (1-2 sentences)</p>
                        <p>Technologies Used: [List of Technologies]</p>
                        <h6>Responsibilities:</h6>
                        <ul>
                            <li>[What you specifically did in this project, using bullet points]</li>
                        </ul>
                    </div><!-- End Resume Item -->
                    <!-- Repeat for additional projects -->
                </div>
            </div>

            <!-- Certifications & Training -->
            <div class="row">
                <div class="col-lg-12" data-aos="fade-up" data-aos-delay="600">
                    <h3 class="resume-title">Certifications & Training</h3>
                    <div class="resume-item">
                        <ul>
                            <li>[Certification Name] - [Issuing Organization, Year of Completion]</li>
                            <li>[Certification Name] - [Issuing Organization, Year of Completion]</li>
                        </ul>
                    </div><!-- End Resume Item -->
                </div>
            </div>

            <!-- Personal Details -->
            <div class="row">
                <div class="col-lg-12" data-aos="fade-up" data-aos-delay="700">
                    <h3 class="resume-title">Personal Details</h3>
                    <div class="resume-item">
                        <p>Date of Birth: [DD/MM/YYYY]</p>
                        <p>Languages Known: [List languages you are fluent in]</p>
                        <p>Nationality: [Indian]</p>
                        <p>Marital Status: [Single/Married]</p>
                    </div><!-- End Resume Item -->
                </div>
            </div>

            <!-- Hobbies & Interests -->
            <div class="row">
                <div class="col-lg-12" data-aos="fade-up" data-aos-delay="800">
                    <h3 class="resume-title">Hobbies & Interests</h3>
                    <div class="resume-item">
                        <p>List a few hobbies or interests relevant to the job or showcasing your well-rounded
                            personality (e.g., “Reading technical blogs, playing chess, volunteering for community
                            service”).</p>
                    </div><!-- End Resume Item -->
                </div>
            </div>

            <!-- References -->
            <div class="row">
                <div class="col-lg-12" data-aos="fade-up" data-aos-delay="900">
                    <h3 class="resume-title">References</h3>
                    <div class="resume-item">
                        <p>Available upon request.</p>
                    </div><!-- End Resume Item -->
                </div>
            </div>

        </div>

    </section> --}}

    <!--   resume 3-->
    {{-- <section id="resume" class="resume section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Resume</h2>
            <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint
                consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia
                fugiat sit
                in iste officiis commodi quidem hic quas.</p>
        </div><!-- End Section Title -->

        <div class="container">

            <div class="row">

                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                    <h3 class="resume-title">Objective</h3>
                    <div class="resume-item pb-0">
                        <p><em>Aiming to leverage my skills and experience to successfully fill the [Desired Job
                                Title] position at your company.</em></p>
                    </div><!-- End Resume Item -->

                    <h3 class="resume-title">Professional Experience</h3>

                    <div class="resume-item">
                        <h4>Senior Graphic Design Specialist</h4>
                        <h5>2019 - Present</h5>
                        <p><em>Experion, New York, NY</em></p>
                        <ul>
                            <li>Lead in the design, development, and implementation of the graphic, layout, and
                                production communication materials.</li>
                            <li>Delegate tasks to the 7 members of the design team and provide counsel on all
                                aspects of the project.</li>
                            <li>Supervise the assessment of all graphic materials in order to ensure quality and
                                accuracy of the design.</li>
                            <li>Oversee the efficient use of production project budgets ranging from $2,000 -
                                $25,000.</li>
                        </ul>
                    </div><!-- End Resume Item -->

                    <div class="resume-item">
                        <h4>Graphic Design Specialist</h4>
                        <h5>2017 - 2018</h5>
                        <p><em>Stepping Stone Advertising, New York, NY</em></p>
                        <ul>
                            <li>Developed numerous marketing programs (logos, brochures, infographics,
                                presentations, and advertisements).</li>
                            <li>Managed up to 5 projects or tasks at a given time while under pressure.</li>
                            <li>Recommended and consulted with clients on the most appropriate graphic design.</li>
                            <li>Created 4+ design presentations and proposals a month for clients and account
                                managers.</li>
                        </ul>
                    </div><!-- End Resume Item -->

                </div>

                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">

                    <h3 class="resume-title">Education</h3>

                    <div class="resume-item">
                        <h4>Master of Fine Arts &amp; Graphic Design</h4>
                        <h5>2015 - 2016</h5>
                        <p><em>Rochester Institute of Technology, Rochester, NY</em></p>
                        <p>Qui deserunt veniam. Et sed aliquam labore tempore sed quisquam iusto autem sit. Ea vero
                            voluptatum qui ut dignissimos deleniti nerada porti sand markend</p>
                    </div><!-- End Resume Item -->

                    <div class="resume-item">
                        <h4>Bachelor of Fine Arts &amp; Graphic Design</h4>
                        <h5>2010 - 2014</h5>
                        <p><em>Rochester Institute of Technology, Rochester, NY</em></p>
                        <p>Quia nobis sequi est occaecati aut. Repudiandae et iusto quae reiciendis et quis Eius vel
                            ratione eius unde vitae rerum voluptates asperiores voluptatem Earum molestiae
                            consequatur neque etlon sader mart dila</p>
                    </div><!-- End Resume Item -->

                    <h3 class="resume-title">Technical Skills</h3>
                    <div class="resume-item pb-0">
                        <ul>
                            <li>Programming Languages: Python, Java, C++</li>
                            <li>Tools & Technologies: MATLAB, Git, Tableau</li>
                            <li>Frameworks & Libraries: React, Django, Angular</li>
                        </ul>
                    </div><!-- End Resume Item -->

                    <h3 class="resume-title">Certifications & Training</h3>
                    <div class="resume-item pb-0">
                        <ul>
                            <li>Certification Name - Issuing Organization, Year of Completion</li>
                            <li>Certification Name - Issuing Organization, Year of Completion</li>
                        </ul>
                    </div><!-- End Resume Item -->

                </div>

            </div>

        </div>

    </section> --}}

    <!--   resume 4-->
    <section id="resume" class="resume section">
        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Resume</h2>
            <p>Passionate and experienced Backend Web Developer with a solid foundation in full-stack development.
                Skilled in a variety of technologies, from PHP and Laravel to React and Node.js, I am driven to
                build innovative web solutions
                that meet and exceed client expectations. My journey in web development has been marked by a
                commitment to continuous learning and
                adapting to the latest industry trends. Below is a summary of my professional experience, education,
                skills, and certifications.</p>
        </div>
        <!-- End Section Title -->

        <div class="container">

            <div class="row">

                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                    <h3 class="resume-title">Objective</h3>
                    <div class="resume-item pb-0">
                        <p>Experienced Backend Web Developer with a passion for developing innovative web
                            applications.Skilled in full-stack development,including front-end and back-end
                            technologies.Seeking to use my skills and experience to contribute to a dynamic web
                            development team</p>
                    </div>
                    <!-- End Resume Item -->

                    <h3 class="resume-title">Education</h3>
                    <div class="resume-item">
                        <h4>Master of Computer Applications (MCA)</h4>
                        <h5>2023 - 2025</h5>
                        <p><em>Chandigarh University, Punjab.</em></p>
                        <p>Grade: 7.30 CGPA</p>
                    </div><!-- End Resume Item -->

                    <div class="resume-item">
                        <h4>Bachelor of Computer Applications (BCA)</h4>
                        <h5>2019 - 2022</h5>
                        <p><em>International School of Management, Patna, affiliated with Aryabhatta Knowledge
                                University</em></p>
                        <p>Grade: 7.48 CGPA / 71.06%</p>
                    </div><!-- End Resume Item -->

                    <div class="resume-item">
                        <h4>Intermediate in Science</h4>
                        <h5>2017 - 2019</h5>
                        <p><em>Saryu High School, Sursand, Sitamarhi, affiliated with Bihar School Examination
                                Board</em></p>
                        <p>Percentage: 71.8%</p>
                    </div><!-- End Resume Item -->

                    <div class="resume-item">
                        <h4>Matriculation (10th)</h4>
                        <h5>2016 - 2017</h5>
                        <p><em>Saryu High School, Sursand, Sitamarhi, affiliated with Bihar School Examination
                                Board</em></p>
                        <p>Percentage: 64.2%</p>
                    </div><!-- End Resume Item -->

                    <h3 class="resume-title">Technical Skills</h3>
                    <div class="resume-item pb-0">
                        {{-- <ul>
                            <li>Programming Languages: Php, Ajax, Json, JavaScript, HTML, CSS, C Programming,</li>
                            <li>Frameworks & Libraries: Laravel, React, Node Js, Bootstrap, jQuery</li>
                            <li>Tools & Technologies: Mysql, GitHub</li>
                        </ul> --}}
                        <ul>
                            <li>Programming Languages, Tools & Technologies, and Frameworks & Libraries: PHP,
                                Laravel, MySQL, AJAX, JSON,
                                JavaScript, React.js, Node.js, React Native, HTML, CSS, jQuery, Bootstrap, Git, and C
                                Programming.
                            </li>
                        </ul>
                    </div>
                    <!-- End Resume Item -->
                </div>

                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">

                    <h3 class="resume-title">Professional Experience</h3>

                    <div class="resume-item">
                        <h4>Laravel Backend Web Developer</h4>
                        <h5>29-09-2023 - Present</h5>
                        <a href="https://capitall.io/" target="_blank">
                            <p><em>Capitall India Private Limited, New Delhi</em></p>
                        </a>
                        <ul>
                            <li>Developed the Vsa Data Room.</li>
                            <li>Developed Balance confirmation project.</li>
                            <li>Gained significant experience and learned a lot during this period.</li>
                            {{-- <li>Acquired proficiency in React.js and Node.js.</li> --}}
                            <li>Acquired basic knowledge in React.js, Node.js and React native.</li>
                            <li>Collaborated with clients to understand their requirements and successfully delivered
                                projects based on their specifications.</li>
                            <li>Gained valuable experience in software testing during this period.</li>
                        </ul>
                    </div><!-- End Resume Item -->

                    <div class="resume-item">
                        <h4>Laravel Backend Web Developer Intern</h4>
                        <h5>01-03-2023 - 26-09-2023</h5>
                        <a href="https://www.trakaff.com/" target="_blank">
                            <p><em>TrakAff-Affiliate Tracking Software , New Delhi</em></p>
                        </a>
                        <ul>
                            <li>Developed the Dynamic Expertaff web application projects.</li>
                            <li>Developed the Dynamic Linktester web application projects.</li>
                            <li>Gained expertise in Php, Laravel, Mysql, Ajax, Json, JavaScript.</li>
                            <li>Successfully applied theoretical knowledge in practical situations.</li>
                        </ul>
                    </div><!-- End Resume Item -->

                    <h3 class="resume-title">Certifications & Training</h3>
                    <div class="resume-item pb-0">
                        <ul>
                            <li>Certificate of Appreciation of frontend web development - Issuing Organization:
                                DevTown, Year
                                of Completion: 2022</li>
                            <li>Certificate of Completion front end web development bootcamp - Issuing Organization:
                                DevTown, Year of
                                Completion: 2022</li>
                            <li>Masterclass on Javascript Bootcamp - Issuing Organization: Scaler Academy, Year of
                                Completion: 2022</li>
                            <li>Certificate of Completion Php Language - Issuing Organization: Great Learning, Year
                                of Completion: 2023</li>
                        </ul>
                    </div><!-- End Resume Item -->

                </div>

            </div>

        </div>

    </section>

    <!-- /Resume Section -->


    <!-- Portfolio Section -->
    <section id="portfolio" class="portfolio section light-background">
        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Portfolio</h2>
            <p>Welcome to my portfolio. Here you'll find a collection of projects that highlight my expertise in
                software development and web technologies. Each project demonstrates my dedication to creating effective
                solutions and my passion for coding.</p>

        </div>
        <!-- End Section Title -->
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

                    <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-product">
                        <div class="portfolio-content h-100">
                            <img src="{{ asset('img\portfolio\project-vsaedit.png') }}" class="img-fluid"
                                alt="">
                            <div class="portfolio-info">
                                <h4>Virtual Data Room</h4>
                                <p>A VDR is a secure online repository for storing and sharing
                                    confidential documents.</p>
                                <a href="{{ asset('img/portfolio/project-vsaedit.png') }}"
                                    data-gallery="portfolio-gallery-product" class="glightbox preview-link"><i
                                        class="bi bi-zoom-in"></i></a>
                                <a href="{{ url('/portfolio-details/8') }}" title="More Details"
                                    class="details-link">
                                    <i class="bi bi-link-45deg"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- End Portfolio Item -->

                    <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-product">
                        <div class="portfolio-content h-100">
                            <img src="{{ asset('img\portfolio\project-portfolio (2).png') }}" class="img-fluid"
                                alt="">
                            <div class="portfolio-info">
                                <h4>Portfolio</h4>
                                <p>My aim to provide a clear and organized overview of my work and experiences.</p>
                                <a href="{{ asset('img/portfolio/project-portfolio (2).png') }}"
                                    data-gallery="portfolio-gallery-product" class="glightbox preview-link"><i
                                        class="bi bi-zoom-in"></i></a>
                                <a href="{{ url('/portfolio-details/10') }}" title="More Details"
                                    class="details-link">
                                    <i class="bi bi-link-45deg"></i>
                                </a>
                            </div>
                        </div>
                    </div><!-- End Portfolio Item -->


                    <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-product">
                        <div class="portfolio-content h-100">
                            <img src="{{ asset('img/portfolio/project-expertaff (1).png') }}" class="img-fluid"
                                alt="">
                            <div class="portfolio-info">
                                <h4>ExpertAff</h4>
                                {{-- <p>My first project, ExpertAff, focuses on creating an effective affiliate management
                                    system.</p> --}}
                                <p>ExpertAff is a network listing site.</p>
                                <a href="{{ asset('img/portfolio/project-expertaff (1).png') }}"
                                    data-gallery="portfolio-gallery-product" class="glightbox preview-link"><i
                                        class="bi bi-zoom-in"></i></a>
                                <a href="{{ url('/portfolio-details/7') }}" title="More Details"
                                    class="details-link">
                                    <i class="bi bi-link-45deg"></i>
                                </a>
                            </div>
                        </div>
                    </div><!-- End Portfolio Item -->

                    <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-app">
                        <div class="portfolio-content h-100">
                            <img src="{{ asset('img/portfolio/project-linktester (6).png') }}" class="img-fluid"
                                alt="">
                            <div class="portfolio-info">
                                <h4>Linktester</h4>
                                <p>This project is related to URL tracking.</p>
                                <a href="{{ asset('img/portfolio/project-linktester (6).png') }}"
                                    data-gallery="portfolio-gallery-app" class="glightbox preview-link"><i
                                        class="bi bi-zoom-in"></i></a>
                                <a href="{{ url('/portfolio-details/9') }}" title="More Details"
                                    class="details-link">
                                    <i class="bi bi-link-45deg"></i>
                                </a>
                            </div>
                        </div>
                    </div><!-- End Portfolio Item -->

                    <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-product">
                        <div class="portfolio-content h-100">
                            <img src="{{ asset('img/portfolio/project-sopping (1).png') }}" class="img-fluid"
                                alt="">
                            <div class="portfolio-info">
                                <h4>Shopping Mart</h4>
                                <p>Shopping Mart is an online shopping e-commerce site..</p>
                                <a href="{{ asset('img/portfolio/project-sopping (1).png') }}"
                                    data-gallery="portfolio-gallery-product" class="glightbox preview-link"><i
                                        class="bi bi-zoom-in"></i></a>

                                <a href="{{ url('/portfolio-details/1') }}" title="More Details"
                                    class="details-link"><i class="bi bi-link-45deg"></i></a>
                            </div>
                        </div>
                    </div><!-- End Portfolio Item -->

                    <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-books">
                        <div class="portfolio-content h-100">
                            <img src="{{ asset('img/portfolio/project-book (1).jpg') }}" class="img-fluid"
                                alt="">
                            <div class="portfolio-info">
                                <h4>Online Book Store</h4>
                                <p>An e-commerce platform tailored for purchasing books online.</p>
                                <a href="{{ asset('img/portfolio/project-book (1).jpg') }}"
                                    data-gallery="portfolio-gallery-book" class="glightbox preview-link"><i
                                        class="bi bi-zoom-in"></i></a>
                                <a href="{{ url('/portfolio-details/5') }}" title="More Details"
                                    class="details-link"><i class="bi bi-link-45deg"></i></a>
                            </div>
                        </div>
                    </div><!-- End Portfolio Item -->

                    <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-product">
                        <div class="portfolio-content h-100">
                            <img src="{{ asset('img/portfolio/project-1 (8).png') }}" class="img-fluid"
                                alt="">
                            <div class="portfolio-info">
                                <h4>E-commerce site</h4>
                                <p>This project showcases my ability to build dynamic E-commerce site.</p>
                                <a href="{{ asset('img/portfolio/project-1 (8).png') }}"
                                    data-gallery="portfolio-gallery-product" class="glightbox preview-link"><i
                                        class="bi bi-zoom-in"></i></a>

                                <a href="{{ url('/portfolio-details/4') }}" title="More Details"
                                    class="details-link"><i class="bi bi-link-45deg"></i></a>
                            </div>
                        </div>
                    </div><!-- End Portfolio Item -->

                    <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-product">
                        <div class="portfolio-content h-100">
                            <img src="{{ asset('img/portfolio/project-login (3).jpg') }}" class="img-fluid"
                                alt="">
                            <div class="portfolio-info">
                                <h4>Login System</h4>
                                <p>This project is a robust Login System</p>
                                <a href="{{ asset('img/portfolio/project-login (3).jpg') }}"
                                    data-gallery="portfolio-gallery-product" class="glightbox preview-link"><i
                                        class="bi bi-zoom-in"></i></a>

                                <a href="{{ url('/portfolio-details/6') }}" title="More Details"
                                    class="details-link"><i class="bi bi-link-45deg"></i></a>
                            </div>
                        </div>
                    </div><!-- End Portfolio Item -->

                    <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-product">
                        <div class="portfolio-content h-100">
                            <img src="{{ asset('img/portfolio/project-1 (7).png') }}" class="img-fluid"
                                alt="">
                            <div class="portfolio-info">
                                <h4>Google Drive Clone</h4>
                                <p>This project similar to Google Drive.</p>
                                <a href="{{ asset('img/portfolio/project-1 (7).png') }}"
                                    data-gallery="portfolio-gallery-product" class="glightbox preview-link"><i
                                        class="bi bi-zoom-in"></i></a>

                                <a href="{{ url('/portfolio-details/3') }}" title="More Details"
                                    class="details-link"><i class="bi bi-link-45deg"></i></a>
                            </div>
                        </div>
                    </div><!-- End Portfolio Item -->

                    <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-product">
                        <div class="portfolio-content h-100">
                            <img src="{{ asset('img/portfolio/project-1 (6).png') }}" class="img-fluid"
                                alt="">
                            <div class="portfolio-info">
                                <h4>Analog Digital Clock</h4>
                                <p>The clock is designed to display the current time.</p>
                                <a href="{{ asset('img/portfolio/project-1 (6).png') }}"
                                    data-gallery="portfolio-gallery-product" class="glightbox preview-link"><i
                                        class="bi bi-zoom-in"></i></a>

                                <a href="{{ url('/portfolio-details/2') }}" title="More Details"
                                    class="details-link"><i class="bi bi-link-45deg"></i></a>
                            </div>
                        </div>
                    </div><!-- End Portfolio Item -->


                    {{-- <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-product">
                        <div class="portfolio-content h-100">
                            <img src="{{ asset('img/portfolio/app-1.jpg') }}" class="img-fluid" alt="">
                            <div class="portfolio-info">
                                <h4>ExpertAff</h4>
                                <p>My first project, ExpertAff, focuses on creating an effective affiliate management
                                    system.</p>

                                <a href="assets/img/portfolio/app-1.jpg" title="App 1"
                                    data-gallery="portfolio-gallery-app" class="glightbox preview-link"><i
                                        class="bi bi-zoom-in"></i></a>

                                <a href="{{ asset('img/portfolio/expertaff.png') }}" title="ExpertAff"
                                    data-gallery="portfolio-gallery-app" class="glightbox preview-link"><i
                                        class="bi bi-zoom-in"></i></a>


                                <a href="{{ url('/portfolio-details') }}" title="More Details" class="details-link">
                                    <i class="bi bi-link-45deg"></i>
                                </a>

                            </div>
                        </div>
                    </div><!-- End Portfolio Item --> --}}

                    {{-- <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-branding">
                        <div class="portfolio-content h-100">
                            <img src="{{ asset('img/portfolio/branding-2.jpg') }}" class="img-fluid"
                                alt="">
                            <div class="portfolio-info">
                                <h4>Branding 2</h4>
                                <p>Lorem ipsum, dolor sit amet consectetur</p>
                                <a href="{{ asset('img/portfolio/branding-2.jpg') }}" title="Branding 2"
                                    data-gallery="portfolio-gallery-branding" class="glightbox preview-link"><i
                                        class="bi bi-zoom-in"></i></a>
                                <a href="{{ url('/portfolio-details') }}" title="More Details"
                                    class="details-link"><i class="bi bi-link-45deg"></i></a>
                            </div>
                        </div>
                    </div><!-- End Portfolio Item -->
                    <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-books">
                        <div class="portfolio-content h-100">
                            <img src="{{ asset('img/portfolio/books-2.jpg') }}" class="img-fluid"
                                alt="">
                            <div class="portfolio-info">
                                <h4>Books 2</h4>
                                <p>Lorem ipsum, dolor sit amet consectetur</p>
                                <a href="{{ asset('img/portfolio/books-2.jpg') }}" title="Branding 2"
                                    data-gallery="portfolio-gallery-book" class="glightbox preview-link"><i
                                        class="bi bi-zoom-in"></i></a>
                                <a href="{{ url('/portfolio-details') }}" title="More Details"
                                    class="details-link"><i class="bi bi-link-45deg"></i></a>
                            </div>
                        </div>
                    </div><!-- End Portfolio Item -->

                    <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-app">
                        <div class="portfolio-content h-100">
                            <img src="{{ asset('img/portfolio/app-3.jpg') }}" class="img-fluid" alt="">
                            <div class="portfolio-info">
                                <h4>App 3</h4>
                                <p>Lorem ipsum, dolor sit amet consectetur</p>
                                <a href="{{ asset('img/portfolio/app-3.jpg') }}" title="App 3"
                                    data-gallery="portfolio-gallery-app" class="glightbox preview-link"><i
                                        class="bi bi-zoom-in"></i></a>
                                <a href="{{ url('/portfolio-details') }}" title="More Details"
                                    class="details-link"><i class="bi bi-link-45deg"></i></a>
                            </div>
                        </div>
                    </div><!-- End Portfolio Item -->

                    <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-product">
                        <div class="portfolio-content h-100">
                            <img src="{{ asset('img/portfolio/product-3.jpg') }}" class="img-fluid"
                                alt="">
                            <div class="portfolio-info">
                                <h4>Product 3</h4>
                                <p>Lorem ipsum, dolor sit amet consectetur</p>
                                <a href="{{ asset('img/portfolio/product-3.jpg') }}" title="Product 3"
                                    data-gallery="portfolio-gallery-product" class="glightbox preview-link"><i
                                        class="bi bi-zoom-in"></i></a>
                                <a href="{{ url('/portfolio-details') }}" title="More Details"
                                    class="details-link"><i class="bi bi-link-45deg"></i></a>
                            </div>
                        </div>
                    </div><!-- End Portfolio Item -->

                    <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-branding">
                        <div class="portfolio-content h-100">
                            <img src="{{ asset('img/portfolio/branding-3.jpg') }}" class="img-fluid"
                                alt="">
                            <div class="portfolio-info">
                                <h4>Branding 3</h4>
                                <p>Lorem ipsum, dolor sit amet consectetur</p>
                                <a href="{{ asset('img/portfolio/branding-3.jpg') }}" title="Branding 2"
                                    data-gallery="portfolio-gallery-branding" class="glightbox preview-link"><i
                                        class="bi bi-zoom-in"></i></a>
                                <a href="{{ url('/portfolio-details') }}" title="More Details"
                                    class="details-link"><i class="bi bi-link-45deg"></i></a>
                            </div>
                        </div>
                    </div><!-- End Portfolio Item -->

                    <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-books">
                        <div class="portfolio-content h-100">
                            <img src="{{ asset('img/portfolio/books-3.jpg') }}" class="img-fluid"
                                alt="">
                            <div class="portfolio-info">
                                <h4>Books 3</h4>
                                <p>Lorem ipsum, dolor sit amet consectetur</p>
                                <a href="{{ asset('img/portfolio/books-3.jpg') }}" title="Branding 3"
                                    data-gallery="portfolio-gallery-book" class="glightbox preview-link"><i
                                        class="bi bi-zoom-in"></i></a>
                                <a href="{{ url('/portfolio-details') }}" title="More Details"
                                    class="details-link"><i class="bi bi-link-45deg"></i></a>
                            </div>
                        </div>
                    </div><!-- End Portfolio Item --> --}}

                </div><!-- End Portfolio Container -->

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

                    <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-product hello">
                        <div class="portfolio-content h-100">
                            <div class="portfolio-image-container">
                                <img src="{{ asset('img/app/portfolioapp2.png') }}" alt="Portfolio Image"
                                    class="responsive-image">
                            </div>

                            <div class="portfolio-info">
                                <h4>Portfolio App</h4>
                                {{-- <p>My aim to provide a clear and organized overview of my work and experiences.</p> --}}
                                <a href="{{ asset('img/app/portfolioapp2.png') }}"
                                    data-gallery="portfolio-gallery-product" class="glightbox preview-link"><i
                                        class="bi bi-zoom-in"></i></a>
                                <a href="{{ url('/android-app/4') }}" title="More Details" class="details-link">
                                    <i class="bi bi-link-45deg"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-product hello">
                        <div class="portfolio-content h-100">
                            <div class="portfolio-image-container">
                                <img src="{{ asset('img/app/friendslist (2).png') }}" alt="Portfolio Image"
                                    class="responsive-image">
                            </div>

                            <div class="portfolio-info">
                                <h4>FriendsList App</h4>
                                {{-- <p>My aim to provide a clear and organized overview of my work and experiences.</p> --}}
                                <a href="{{ asset('img/app/friendslist (2).png') }}"
                                    data-gallery="portfolio-gallery-product" class="glightbox preview-link"><i
                                        class="bi bi-zoom-in"></i></a>
                                <a href="{{ url('/android-app/3') }}" title="More Details" class="details-link">
                                    <i class="bi bi-link-45deg"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-product hello">
                        <div class="portfolio-content h-100">
                            <div class="portfolio-image-container">
                                <img src="{{ asset('img/app/friendslist (1).png') }}" alt="Portfolio Image"
                                    class="responsive-image">
                            </div>

                            <div class="portfolio-info">
                                <h4>Login</h4>
                                {{-- <p>My aim to provide a clear and organized overview of my work and experiences.</p> --}}
                                <a href="{{ asset('img/app/friendslist (1).png') }}"
                                    data-gallery="portfolio-gallery-product" class="glightbox preview-link"><i
                                        class="bi bi-zoom-in"></i></a>
                                <a href="{{ url('/android-app/2') }}" title="More Details" class="details-link">
                                    <i class="bi bi-link-45deg"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-product hello">
                        <div class="portfolio-content h-100">
                            <div class="portfolio-image-container">
                                <img src="{{ asset('img/app/calcullater (2).png') }}" alt="Portfolio Image"
                                    class="responsive-image">
                            </div>

                            <div class="portfolio-info">
                                <h4>Calculater</h4>
                                {{-- <p>My aim to provide a clear and organized overview of my work and experiences.</p> --}}
                                <a href="{{ asset('img/app/calcullater (2).png') }}"
                                    data-gallery="portfolio-gallery-product" class="glightbox preview-link"><i
                                        class="bi bi-zoom-in"></i></a>
                                <a href="{{ url('/android-app/1') }}" title="More Details" class="details-link">
                                    <i class="bi bi-link-45deg"></i>
                                </a>
                            </div>
                        </div>
                    </div>


                </div>

            </div>

        </div>

    </section><!-- /Portfolio Section -->

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

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Contact</h2>
            <p>Below is my contact information. Feel free to reach out to me anytime!</p>
        </div><!-- End Section Title -->

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="row gy-4">

                <div class="col-lg-5">

                    <div class="info-wrap">
                        <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="200">
                            <i class="bi bi-geo-alt flex-shrink-0"></i>
                            <div>
                                <h3>Address</h3>
                                <p>Laxmi Nagar Metro Station New Delhi.</p>
                            </div>
                        </div><!-- End Info Item -->

                        <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
                            <i class="bi bi-telephone flex-shrink-0"></i>
                            <div>
                                <h3>Call Us</h3>
                                <p>+917488952139</p>
                            </div>
                        </div><!-- End Info Item -->

                        <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
                            <i class="bi bi-envelope flex-shrink-0"></i>
                            <div>
                                <h3>Email Us</h3>
                                <p>shahidraza7463@gmail.com</p>
                            </div>
                        </div><!-- End Info Item -->
                        {{-- Go to google map and serach location and click share and click embaded map tab and copy html --}}
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3501.974898484312!2d77.27280758321282!3d28.630514405676287!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390cfcad2277af7d%3A0xe68dd5cbcfe7d692!2sLaxmi%20Nagar%20Metro%20Station!5e0!3m2!1sen!2sus!4v1725388219908!5m2!1sen!2sus"
                            frameborder="0" style="border:0; width: 100%; height: 270px;" allowfullscreen=""
                            loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
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
                </div><!-- End Contact Form -->
            </div>

        </div>

    </section><!-- /Contact Section -->

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
