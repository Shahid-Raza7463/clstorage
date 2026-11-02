<?php

namespace Database\Seeders;

use App\Models\Portfolio\ContactInfo;
use App\Models\Portfolio\PortfolioCategory;
use App\Models\Portfolio\PortfolioItem;
use App\Models\Portfolio\PortfolioProfile;
use App\Models\Portfolio\PortfolioStat;
use App\Models\Portfolio\ResumeItem;
use App\Models\Portfolio\ResumeSection;
use App\Models\Portfolio\Service;
use App\Models\Portfolio\Skill;
use App\Models\Portfolio\SocialLink;
use App\Models\Portfolio\Testimonial;
use Illuminate\Database\Seeder;

class PortfolioSeeder extends Seeder
{
    public function run(): void
    {
        $profile = PortfolioProfile::updateOrCreate(
            ['email' => 'shahidraza7463@gmail.com'],
            [
                'name' => 'Shahid Raza',
                'title' => 'Full Stack Web Developer',
                'typed_items' => 'Full Stack Web Developer, Software Tester, Laravel Developer',
                'profile_image' => 'img/my-profile-img1 (1).png',
                'hero_image' => 'img/home/home1 (1).jpg',
                'about_image' => 'img/my-profile-img (3).png',
                'about_summary' => "Hey there, Name's Shahid Raza and I'm a Full Stack Web Developer,worked @TrakAff as a laravel backend web developer and currently working as laravel backend web developer @Capitall. I'm proficient in working with and implementing backend for web apps using Php, Laravel, Mysql, Ajax, Json, JavaScript, React Js, Node Js, React Native, HTML, CSS, jQuery, Bootstrap. And I enjoy taking on new challenges.I have 2 year of experience in Backend Web Development.",
                'about_description' => 'I am currently expanding my skills in React Native and have recently developed an app called FriendsList. This project has allowed me to explore the fundamentals of mobile app development.',
                'about_extra_description' => 'I have completed nearly 9 projects that have helped me become a skilled professional in Backend web development.',
                'birthday' => '2001-01-01',
                'website' => 'shahid1.infinityfreeapp.com',
                'phone' => '+917488952139',
                'city' => 'Sursand, Sitamarhi, India',
                'age' => 23,
                'degree' => 'Master',
                'freelance' => 'Not Available',
                'skills_intro' => 'Basic knowledge in Php, Laravel, Mysql, Ajax, Json, JavaScript, React Js, Node Js, React Native, HTML, CSS, jQuery, Bootstrap, GitHub, C Programming, MS Power Point, MS Word, MS Excel, Touch Typing.',
                'resume_intro' => 'Passionate and experienced Backend Web Developer with a solid foundation in full-stack development. Skilled in a variety of technologies, from PHP and Laravel to React and Node.js, I am driven to build innovative web solutions that meet and exceed client expectations. My journey in web development has been marked by a commitment to continuous learning and adapting to the latest industry trends. Below is a summary of my professional experience, education, skills, and certifications.',
                'portfolio_intro' => "Welcome to my portfolio. Here you'll find a collection of projects that highlight my expertise in software development and web technologies. Each project demonstrates my dedication to creating effective solutions and my passion for coding.",
                'contact_intro' => 'Below is my contact information. Feel free to reach out to me anytime!',
                'map_embed_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3501.974898484312!2d77.27280758321282!3d28.630514405676287!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390cfcad2277af7d%3A0xe68dd5cbcfe7d692!2sLaxmi%20Nagar%20Metro%20Station!5e0!3m2!1sen!2sus!4v1725388219908!5m2!1sen!2sus',
            ]
        );

        foreach ([
            ['WhatsApp', 'bi bi-whatsapp', 'https://wa.me/917488952139', 1],
            ['Facebook', 'bi bi-facebook', 'https://www.facebook.com/share/UbuEW2ucYCpR4MBK/?mibextid=qi2Omg', 2],
            ['Instagram', 'bi bi-instagram', '#', 3],
            ['GitHub', 'bi bi-github', 'https://github.com/Shahid-Raza7463?tab=repositories', 4],
            ['LinkedIn', 'bi bi-linkedin', 'https://www.linkedin.com/in/mdshahidraza7886', 5],
        ] as [$name, $icon, $url, $order]) {
            SocialLink::updateOrCreate(
                ['portfolio_profile_id' => $profile->id, 'name' => $name],
                ['icon_class' => $icon, 'url' => $url, 'sort_order' => $order, 'is_active' => true]
            );
        }

        $skills = [
            ['PHP', 80], ['Mysql', 80], ['Json', 90], ['jQuery', 80], ['CSS', 70],
            ['React Js', 60], ['React Native', 70], ['Laravel', 80], ['Ajax', 90],
            ['Javascript', 80], ['HTML', 90], ['Bootstrap', 90], ['Node js', 60],
        ];

        Skill::where('portfolio_profile_id', $profile->id)
            ->whereNotIn('name', collect($skills)->pluck(0)->all())
            ->update(['is_active' => false]);

        foreach ($skills as $index => [$name, $percentage]) {
            Skill::updateOrCreate(
                ['portfolio_profile_id' => $profile->id, 'name' => $name],
                ['percentage' => $percentage, 'sort_order' => $index + 1, 'is_active' => true]
            );
        }

        $objective = ResumeSection::updateOrCreate(
            ['portfolio_profile_id' => $profile->id, 'name' => 'Objective'],
            ['column' => 'left', 'sort_order' => 1, 'is_active' => true]
        );
        ResumeItem::updateOrCreate(
            ['resume_section_id' => $objective->id, 'title' => 'Experienced Backend Web Developer'],
            ['description' => 'Experienced Backend Web Developer with a passion for developing innovative web applications.Skilled in full-stack development,including front-end and back-end technologies.Seeking to use my skills and experience to contribute to a dynamic web development team', 'sort_order' => 1, 'is_active' => true]
        );

        $education = ResumeSection::updateOrCreate(
            ['portfolio_profile_id' => $profile->id, 'name' => 'Education'],
            ['column' => 'left', 'sort_order' => 2, 'is_active' => true]
        );
        foreach ([
            ['Master of Computer Applications (MCA)', '2023 - 2025', 'Chandigarh University, Punjab.', 'Grade: 7.30 CGPA'],
            ['Bachelor of Computer Applications (BCA)', '2019 - 2022', 'International School of Management, Patna, affiliated with Aryabhatta Knowledge University', 'Grade: 7.48 CGPA / 71.06%'],
            ['Intermediate in Science', '2017 - 2019', 'Saryu High School, Sursand, Sitamarhi, affiliated with Bihar School Examination Board', 'Percentage: 71.8%'],
            ['Matriculation (10th)', '2016 - 2017', 'Saryu High School, Sursand, Sitamarhi, affiliated with Bihar School Examination Board', 'Percentage: 64.2%'],
        ] as $index => [$title, $period, $subtitle, $description]) {
            ResumeItem::updateOrCreate(
                ['resume_section_id' => $education->id, 'title' => $title],
                ['period' => $period, 'subtitle' => $subtitle, 'description' => $description, 'sort_order' => $index + 1, 'is_active' => true]
            );
        }

        $technical = ResumeSection::updateOrCreate(
            ['portfolio_profile_id' => $profile->id, 'name' => 'Technical Skills'],
            ['column' => 'left', 'sort_order' => 3, 'is_active' => true]
        );
        ResumeItem::updateOrCreate(
            ['resume_section_id' => $technical->id, 'title' => 'Programming Languages, Tools & Technologies'],
            ['bullets' => ['PHP, Laravel, MySQL, AJAX, JSON, JavaScript, React.js, Node.js, React Native, HTML, CSS, jQuery, Bootstrap, Git, and C Programming.'], 'sort_order' => 1, 'is_active' => true]
        );

        $experience = ResumeSection::updateOrCreate(
            ['portfolio_profile_id' => $profile->id, 'name' => 'Professional Experience'],
            ['column' => 'right', 'sort_order' => 1, 'is_active' => true]
        );
        foreach ([
            ['Laravel Backend Web Developer', '29-09-2023 - Present', 'Capitall India Private Limited, New Delhi', 'https://capitall.io/', ['Developed the Vsa Data Room.', 'Developed Balance confirmation project.', 'Gained significant experience and learned a lot during this period.', 'Acquired basic knowledge in React.js, Node.js and React native.', 'Collaborated with clients to understand their requirements and successfully delivered projects based on their specifications.', 'Gained valuable experience in software testing during this period.']],
            ['Laravel Backend Web Developer Intern', '01-03-2023 - 26-09-2023', 'TrakAff-Affiliate Tracking Software , New Delhi', 'https://www.trakaff.com/', ['Developed the Dynamic Expertaff web application projects.', 'Developed the Dynamic Linktester web application projects.', 'Gained expertise in Php, Laravel, Mysql, Ajax, Json, JavaScript.', 'Successfully applied theoretical knowledge in practical situations.']],
        ] as $index => [$title, $period, $subtitle, $link, $bullets]) {
            ResumeItem::updateOrCreate(
                ['resume_section_id' => $experience->id, 'title' => $title],
                ['period' => $period, 'subtitle' => $subtitle, 'link_url' => $link, 'bullets' => $bullets, 'sort_order' => $index + 1, 'is_active' => true]
            );
        }

        $certs = ResumeSection::updateOrCreate(
            ['portfolio_profile_id' => $profile->id, 'name' => 'Certifications & Training'],
            ['column' => 'right', 'sort_order' => 2, 'is_active' => true]
        );
        ResumeItem::updateOrCreate(
            ['resume_section_id' => $certs->id, 'title' => 'Certificates'],
            ['bullets' => ['Certificate of Appreciation of frontend web development - Issuing Organization: DevTown, Year of Completion: 2022', 'Certificate of Completion front end web development bootcamp - Issuing Organization: DevTown, Year of Completion: 2022', 'Masterclass on Javascript Bootcamp - Issuing Organization: Scaler Academy, Year of Completion: 2022', 'Certificate of Completion Php Language - Issuing Organization: Great Learning, Year of Completion: 2023'], 'sort_order' => 1, 'is_active' => true]
        );

        $categories = [];
        foreach ([['Product', 'product', 1], ['Books', 'books', 2], ['App', 'app', 3]] as [$name, $slug, $order]) {
            $categories[$slug] = PortfolioCategory::updateOrCreate(
                ['slug' => $slug],
                ['name' => $name, 'sort_order' => $order, 'is_active' => true]
            );
        }

        foreach ([
            ['Virtual Data Room', 'A VDR is a secure online repository for storing and sharing confidential documents.', 'img/portfolio/project-vsaedit.png', '/portfolio-details/8', 'product', false],
            ['Portfolio', 'My aim to provide a clear and organized overview of my work and experiences.', 'img/portfolio/project-portfolio (2).png', '/portfolio-details/10', 'product', false],
            ['ExpertAff', 'ExpertAff is a network listing site.', 'img/portfolio/project-expertaff (1).png', '/portfolio-details/7', 'product', false],
            ['Linktester', 'This project is related to URL tracking.', 'img/portfolio/project-linktester (6).png', '/portfolio-details/9', 'app', false],
            ['Shopping Mart', 'Shopping Mart is an online shopping e-commerce site..', 'img/portfolio/project-sopping (1).png', '/portfolio-details/1', 'product', false],
            ['Online Book Store', 'An e-commerce platform tailored for purchasing books online.', 'img/portfolio/project-book (1).jpg', '/portfolio-details/5', 'books', false],
            ['E-commerce site', 'This project showcases my ability to build dynamic E-commerce site.', 'img/portfolio/project-1 (8).png', '/portfolio-details/4', 'product', false],
            ['Login System', 'This project is a robust Login System', 'img/portfolio/project-login (3).jpg', '/portfolio-details/6', 'product', false],
            ['Google Drive Clone', 'This project similar to Google Drive.', 'img/portfolio/project-1 (7).png', '/portfolio-details/3', 'product', false],
            ['Analog Digital Clock', 'The clock is designed to display the current time.', 'img/portfolio/project-1 (6).png', '/portfolio-details/2', 'product', false],
            ['Portfolio Drawer App', null, 'img/app/portfoliodrawer1.jpg', '/android-app/5', 'app', true],
            ['Portfolio Bottom App', null, 'img/app/portfoliotop1.jpg', '/android-app/4', 'app', true],
            ['FriendsList App', null, 'img/app/friendslist (2).png', '/android-app/3', 'app', true],
            ['Login', null, 'img/app/friendslist (1).png', '/android-app/2', 'app', true],
            ['Calculater', null, 'img/app/calcullater (2).png', '/android-app/1', 'app', true],
        ] as $index => [$title, $description, $image, $url, $category, $isMobile]) {
            PortfolioItem::updateOrCreate(
                ['title' => $title],
                ['portfolio_category_id' => $categories[$category]->id, 'description' => $description, 'image' => $image, 'details_url' => $url, 'is_mobile' => $isMobile, 'sort_order' => $index + 1, 'is_active' => true]
            );
        }

        foreach ([
            ['Address', 'Laxmi Nagar Metro Station New Delhi.', 'bi bi-geo-alt', 1],
            ['Call Us', '+917488952139', 'bi bi-telephone', 2],
            ['Email Us', 'shahidraza7463@gmail.com', 'bi bi-envelope', 3],
        ] as [$label, $value, $icon, $order]) {
            ContactInfo::updateOrCreate(
                ['portfolio_profile_id' => $profile->id, 'label' => $label],
                ['value' => $value, 'icon_class' => $icon, 'sort_order' => $order, 'is_active' => true]
            );
        }

        foreach ([
            ['Happy Clients', 'consequuntur quae', 'bi bi-emoji-smile', 232],
            ['Projects', 'adipisci atque cum quia aut', 'bi bi-journal-richtext', 521],
            ['Hours Of Support', 'aut commodi quaerat', 'bi bi-headset', 1453],
            ['Hard Workers', 'rerum asperiores dolor', 'bi bi-people', 32],
        ] as $index => [$label, $description, $icon, $value]) {
            PortfolioStat::updateOrCreate(
                ['portfolio_profile_id' => $profile->id, 'label' => $label],
                ['description' => $description, 'icon_class' => $icon, 'value' => $value, 'sort_order' => $index + 1, 'is_active' => false]
            );
        }

        foreach ([
            ['Lorem Ipsum', 'shahid deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident', 'bi bi-briefcase'],
            ['Dolor Sitema', 'Minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat tarad limino ata', 'bi bi-card-checklist'],
            ['Sed ut perspiciatis', 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur', 'bi bi-bar-chart'],
            ['Magni Dolores', 'Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum', 'bi bi-binoculars'],
            ['Nemo Enim', 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque', 'bi bi-brightness-high'],
            ['Eiusmod Tempor', 'Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi', 'bi bi-calendar4-week'],
        ] as $index => [$title, $description, $icon]) {
            Service::updateOrCreate(
                ['portfolio_profile_id' => $profile->id, 'title' => $title],
                ['description' => $description, 'icon_class' => $icon, 'details_url' => '/service-details', 'sort_order' => $index + 1, 'is_active' => false]
            );
        }

        foreach ([
            ['Saul Goodman', 'Ceo & Founder', 'Proin iaculis purus consequat sem cure digni ssim donec porttitora entum suscipit rhoncus.', 'img/testimonials/testimonials-1.jpg'],
            ['Sara Wilsson', 'Designer', 'Export tempor illum tamen malis malis eram quae irure esse labore quem cillum quid malis quorum.', 'img/testimonials/testimonials-2.jpg'],
            ['Jena Karlis', 'Store Owner', 'Enim nisi quem export duis labore cillum quae magna enim sint quorum nulla quem veniam.', 'img/testimonials/testimonials-3.jpg'],
            ['Matt Brandon', 'Freelancer', 'Fugiat enim eram quae cillum dolore dolor amet nulla culpa multos export minim fugiat.', 'img/testimonials/testimonials-4.jpg'],
            ['John Larson', 'Entrepreneur', 'Quis quorum aliqua sint quem legam fore sunt eram irure aliqua veniam tempor noster.', 'img/testimonials/testimonials-5.jpg'],
        ] as $index => [$name, $designation, $message, $image]) {
            Testimonial::updateOrCreate(
                ['portfolio_profile_id' => $profile->id, 'name' => $name],
                ['designation' => $designation, 'message' => $message, 'image' => $image, 'sort_order' => $index + 1, 'is_active' => false]
            );
        }
    }
}
