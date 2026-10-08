<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CodRefundDetail extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cod_refund_details';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'order_id',
        'account_holder_name',
        'bank_name',
        'account_number',
        'ifsc_code',
        'status', 
        'bene_id', 
        'transfer_id', 
        'utr_number',
        'payment_mode', 
        'refund_amount', 
        'cashfree_response',
        'failure_reason', 
        'processed_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'account_number',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'account_number' => 'encrypted',
        'created_at'     => 'datetime',
        'updated_at'     => 'datetime',
        'deleted_at'     => 'datetime',
    ];

    /**
     * The attributes that should be appended to the model's array/JSON form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'account_last4',
        'masked_account_number',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * The user this refund detail belongs to.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The order this refund detail belongs to.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    /**
     * Last 4 digits of the account number (safe to display).
     */
    public function getAccountLast4Attribute(): ?string
    {
        $account = $this->account_number;

        return $account ? substr($account, -4) : null;
    }

    /**
     * Masked account number e.g. XXXXXXXX1234.
     */
    public function getMaskedAccountNumberAttribute(): ?string
    {
        $account = $this->account_number;

        if (!$account) {
            return null;
        }

        $length = strlen($account);

        if ($length <= 4) {
            return str_repeat('X', $length);
        }

        return str_repeat('X', $length - 4) . substr($account, -4);
    }

    /*
    |--------------------------------------------------------------------------
    | Mutators
    |--------------------------------------------------------------------------
    */

    /**
     * Normalize IFSC to uppercase before saving.
     */
    public function setIfscCodeAttribute(?string $value): void
    {
        $this->attributes['ifsc_code'] = $value
            ? strtoupper(trim($value))
            : null;
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    /**
     * Scope to filter by user.
     */
    public function scopeForUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope to filter by order.
     */
    public function scopeForOrder($query, int $orderId)
    {
        return $query->where('order_id', $orderId);
    }
}