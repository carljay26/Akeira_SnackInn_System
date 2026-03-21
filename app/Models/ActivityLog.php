<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    public const ACTION_PRODUCT_CREATED = 'product_created';

    public const ACTION_PRODUCT_UPDATED = 'product_updated';

    public const ACTION_PRODUCT_DELETED = 'product_deleted';

    protected $fillable = [
        'user_id',
        'action',
        'subject_label',
        'details',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
