<?php

namespace App\Models\Portfolio;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResumeItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'resume_section_id',
        'title',
        'period',
        'subtitle',
        'link_url',
        'description',
        'bullets',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'bullets' => 'array',
        'is_active' => 'boolean',
    ];

    public function section(): BelongsTo
    {
        return $this->belongsTo(ResumeSection::class, 'resume_section_id');
    }
}
