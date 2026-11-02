<?php

namespace App\Models\Portfolio;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PortfolioProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'title',
        'typed_items',
        'profile_image',
        'hero_image',
        'about_image',
        'about_summary',
        'about_description',
        'about_extra_description',
        'birthday',
        'website',
        'phone',
        'city',
        'age',
        'degree',
        'email',
        'freelance',
        'skills_intro',
        'resume_intro',
        'portfolio_intro',
        'contact_intro',
        'map_embed_url',
    ];

    protected $casts = [
        'birthday' => 'date',
    ];

    public function socialLinks(): HasMany
    {
        return $this->hasMany(SocialLink::class)->orderBy('sort_order');
    }

    public function skills(): HasMany
    {
        return $this->hasMany(Skill::class)->orderBy('sort_order');
    }

    public function resumeSections(): HasMany
    {
        return $this->hasMany(ResumeSection::class)->orderBy('sort_order');
    }

    public function contactInfos(): HasMany
    {
        return $this->hasMany(ContactInfo::class)->orderBy('sort_order');
    }

    public function stats(): HasMany
    {
        return $this->hasMany(PortfolioStat::class)->orderBy('sort_order');
    }

    public function services(): HasMany
    {
        return $this->hasMany(Service::class)->orderBy('sort_order');
    }

    public function testimonials(): HasMany
    {
        return $this->hasMany(Testimonial::class)->orderBy('sort_order');
    }
}
