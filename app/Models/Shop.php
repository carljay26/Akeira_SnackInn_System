<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Shop extends Model
{
    /** @use HasFactory<\Database\Factories\ShopFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'invite_code',
    ];

    protected static function booted(): void
    {
        static::creating(function (Shop $shop) {
            if (empty($shop->invite_code)) {
                $shop->invite_code = strtoupper(Str::random(10));
            } else {
                $shop->invite_code = strtoupper($shop->invite_code);
            }
        });
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public static function findByTeamCode(?string $code): ?self
    {
        if ($code === null || trim($code) === '') {
            return null;
        }

        $normalized = strtoupper(trim($code));

        return static::query()->where('invite_code', $normalized)->first();
    }

    /**
     * Decide which shop a newly registered user belongs to.
     *
     * 1) Optional team code → join that shop.
     * 2) SNACK_INN_DEFAULT_SHOP_ID in env → join that shop (same Snack Inn, multiple logins).
     * 3) Otherwise create a new isolated shop for this account.
     */
    public static function assignForNewRegistration(?string $teamCode, string $ownerDisplayName): self
    {
        $fromCode = self::findByTeamCode($teamCode);
        if ($fromCode !== null) {
            return $fromCode;
        }

        $defaultId = config('snack_inn.default_shop_id');
        if ($defaultId !== null && $defaultId !== '' && ($shop = self::query()->find((int) $defaultId))) {
            return $shop;
        }

        return self::query()->create([
            'name' => "{$ownerDisplayName}'s Snack Inn",
        ]);
    }
}
