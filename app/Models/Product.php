<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'shop_id',
        'name',
        'category',
        'description',
        'price',
        'stock',
        'unit',
        'image_path',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Public URL for a stored product image path, or null if none.
     * Uses the disk from config('snack_inn.product_images_disk') so cloud
     * storage (e.g. S3) works on ephemeral hosts; supports full URLs in DB.
     */
    public static function publicImageUrl(?string $path): ?string
    {
        if ($path === null || trim((string) $path) === '') {
            return null;
        }
        $path = (string) $path;
        if (preg_match('#\Ahttps?://#i', $path)) {
            return $path;
        }

        $disk = config('snack_inn.product_images_disk', 'public');

        return Storage::disk($disk)->url($path);
    }

    public function getImageUrlAttribute(): ?string
    {
        return self::publicImageUrl($this->attributes['image_path'] ?? null);
    }
}
