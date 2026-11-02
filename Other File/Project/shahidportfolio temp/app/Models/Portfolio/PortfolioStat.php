<?php

namespace App\Models\Portfolio;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PortfolioStat extends Model
{
    use HasFactory;

    protected $fillable = [
        'portfolio_profile_id',
        'label',
        'description',
        'icon_class',
        'value',
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
}
