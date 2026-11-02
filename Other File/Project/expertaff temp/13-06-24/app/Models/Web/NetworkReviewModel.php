<?php

namespace App\Models\Web;

use App\Models\Admin\ReviewModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use ReCaptcha\RequestMethod\Post;

class NetworkReviewModel extends Model
{
    use HasFactory;
    protected $table = "network_review";
    protected $primaryKey = 'review_id';
    protected $fillable = [
        'review_id',
        'network_id',
        'user_id',
        'all_rating',
        'offer_rating',
        'payout_rating',
        'tracking_rating',
        'support_rating',
        'review_text',
        'review_img',
        'status',
    ];
}
