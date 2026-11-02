<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
    // use HasFactory;
    // protected $fillable = [
    //     'id',
    //     'title',
    //     'description',
    //     'preview_image',
    //     'category',
    //     'network_id',
    //     'add_user',
    //     'update_user',
    //     'status',
    //     'sponsored',
    //     'featured',
    //     'meta_title',
    //     'meta_description',
    //     'tags',
    //     'slug'
    // ];

    // id (Primary)	int(11)	No		
    // category_id	int(11)	Yes	NULL	
    // projectname	varchar(400)	Yes	NULL	
    // projectdescription	text	Yes	NULL	
    // projectlurl	varchar(100)	Yes	NULL	
    // projectmage	varchar(200)	Yes	NULL	
    // projectimagezoom	varchar(200)	Yes	NULL	
    // categoryname	varchar(200)	Yes	NULL	
    // companyname	varchar(200)	Yes	NULL	
    // projectenddate	varchar(200)	Yes	NULL	
    // toolsandtechnologies	text	Yes	NULL	
    // projectliveurl	varchar(200)	Yes	NULL	
    // descreption	text	Yes	NULL	
    // highlightnote1	varchar(200)	Yes	NULL	
    // highlightnote2	varchar(200)	Yes	NULL	
    // listdescreption	text	Yes	NULL	
    // listheading	varchar(200)	Yes	NULL	
    // listdescreption2	text	Yes	NULL	
    // listheading2	varchar(200)	Yes	NULL	
    // anotherdescreption	text	Yes	NULL	
    // created_at	timestamp	Yes	NULL	
    // updated_at	timestamp	Yes	NULL

    // Another way 
    use HasFactory;
    protected $table = "projects";
    protected $guarded = [];
}
