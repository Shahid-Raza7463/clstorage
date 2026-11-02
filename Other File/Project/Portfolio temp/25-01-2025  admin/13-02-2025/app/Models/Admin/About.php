<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    // use HasFactory;
    // protected $table = "commission_types";
    // protected $fillable = [
    //     'id ',
    //     'name',
    // ];

    // Another way 
    use HasFactory;
    protected $table = "about";
    protected $guarded = [];


    // "id" => 1
    //         "teammember_id" => 1
    //         "description" => "Hey there, Name's Shahid Raza and I'm a Full Stack Web Developer,worked @TrakAff as a laravel backend web developer and currently working as laravel backend web developer @Capitall. I'm proficient in "
    //         "image" => "img/my-profile-img (3).png"
    //         "skillheading" => "Full Stack Web Developer"
    //         "skilldescription1" => "I am currently expanding my skills in React Native and have recently developed an app called FriendsList. This project has allowed me to explore the fundamentals of mobile app development."
    //         "skilldescription2" => "I have completed nearly 9 projects that have helped me become a skilled professional in Backend web development."
    //         "websitelink" => "shahid1.infinityfreeapp.com"
    //         "cityname" => "Sursand, Sitamarhi, India"
    //         "degree" => "Master"
    //         "freelance" => "Not Available"
    //         "created_at" => "2023-07-28 12:41:12"
    //         "updated_at" => "2023-07-28 12:41:12"
    //       ]




}
