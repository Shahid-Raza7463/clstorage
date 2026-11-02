<main class="main">
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

                            @foreach ($projectsimages as $projectsimage)
                                <div class="swiper-slide">
                                    <img src="{{ asset($projectsimage->image) }}" alt="">
                                </div>
                            @endforeach
                        </div>
                        <!--  <style>
                            .portfolio-details .portfolio-details-slider .swiper-pagination {
                                margin-top: -20px !important;
                                position: relative !important;
                                ;
                            }
                        </style> -->
                        <div class="swiper-pagination"></div>
                    </div>
                </div>

                <!-- Project Info -->
                <div class="col-lg-4">
                    <div class="portfolio-info" data-aos="fade-up" data-aos-delay="200"
                        style="background-color: #fff; padding: 35px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); height: 506px;">
                        <h3>Project information</h3>
                        <ul>
                            <li><strong>Project Title</strong>: {{ $projectsdetails->projectname }}</li>
                            <li><strong>Category</strong>: {{ $projectsdetails->categoryname }}</li>
                            {{-- <li><strong>Client</strong>: ASU Company</li> --}}
                            <li><strong>Company</strong>: {{ $projectsdetails->companyname }}</li>
                            <li><strong>Project date</strong>:
                                {{ date('d-M-Y', strtotime($projectsdetails->projectenddate)) }}
                            </li>
                            <li><strong>Tools & Technologies</strong>: {{ $projectsdetails->toolsandtechnologies }}
                            </li>
                            <li><strong>Project URL</strong>:</li>
                            <li><a href="{{ $projectsdetails->projectliveurl }}"
                                    target="_blank">{{ $projectsdetails->projectliveurl }}</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Project Description -->
            <div class="portfolio-description" data-aos="fade-up" data-aos-delay="300"
                style="margin-top: 30px; font-size: 1.05rem; line-height: 1.8; padding: 25px; background-color: #fff; border-radius: 10px;">
                <h5><strong>{{ $projectsdetails->projectname }}:</strong></h5>
                {!! $projectsdetails->descreption !!}

                @if (isset($projectsdetails->highlightnote1))
                    <p>
                        <b style="color: #0040f0;">Note: </b>{{ $projectsdetails->highlightnote1 }}
                    </p>
                @endif
                @if (isset($projectsdetails->listheading))
                    <h4>
                        {{ $projectsdetails->listheading }}:
                    </h4>
                @endif
                <ul style="line-height: 1.9; margin-top: 20px; padding-left: 20px;">
                    {!! $projectsdetails->listdescreption !!}
                </ul>

                @if (isset($projectsdetails->listheading2))
                    <p>{{ $projectsdetails->listheading2 }}:</p>
                @endif

                @if (isset($projectsdetails->listdescreption2))
                    <ul style="line-height: 1.9; margin-top: 0px; padding-left: 20px;">
                        {!! $projectsdetails->listdescreption2 !!}
                    </ul>
                @endif

                @if (isset($projectsdetails->anotherdescreption))
                    <p>{{ $projectsdetails->anotherdescreption }}:</p>
                @endif
                @if (isset($projectsdetails->highlightnote2))
                    <p><b style="color: #0040f0;">Note: </b>{{ $projectsdetails->highlightnote2 }}</p>
                @endif
            </div>
        </div>
    </section>
</main>
