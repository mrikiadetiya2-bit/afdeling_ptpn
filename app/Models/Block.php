<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['afdeling_id', 'code', 'name', 'area_hectares', 'total_trees', 'planting_year'])]
class Block extends Model
{
    /** @use HasFactory<\Database\Factories\BlockFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'area_hectares' => 'decimal:2',
            'total_trees' => 'integer',
        ];
    }

    /**
     * @return BelongsTo<Afdeling, $this>
     */
    public function afdeling(): BelongsTo
    {
        return $this->belongsTo(Afdeling::class);
    }
}
