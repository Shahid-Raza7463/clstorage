<?php

namespace App\Models\Portfolio;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ResumeSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'portfolio_profile_id',
        'name',
        'column',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function profile(): BelongsTo
    {
        return $this->belongsTo(PortfolioProfile::class, 'portfolio_profile_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(ResumeItem::class)->orderBy('sort_order');
    }
}
