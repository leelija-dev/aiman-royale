<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Refund extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'order_id',
        'refund_id',
        'cf_refund_id',
        'cf_payment_id',
        'amount',
        'status',
        'reason',
        'refund_data',
        'processed_at'
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'amount' => 'decimal:2',
        'refund_data' => 'array',
        'processed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Status constants
     */
    const STATUS_PENDING = 'pending';
    const STATUS_PROCESSING = 'processing';
    const STATUS_SUCCESS = 'success';
    const STATUS_FAILED = 'failed';
    const STATUS_CANCELLED = 'cancelled';

    /**
     * Get the order that owns the refund.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    /**
     * Check if refund is completed successfully.
     */
    public function isCompleted(): bool
    {
        return $this->status === self::STATUS_SUCCESS;
    }

    /**
     * Check if refund is pending.
     */
    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    /**
     * Check if refund is processing.
     */
    public function isProcessing(): bool
    {
        return $this->status === self::STATUS_PROCESSING;
    }

    /**
     * Check if refund failed.
     */
    public function isFailed(): bool
    {
        return $this->status === self::STATUS_FAILED;
    }

    /**
     * Check if refund is cancelled.
     */
    public function isCancelled(): bool
    {
        return $this->status === self::STATUS_CANCELLED;
    }

    /**
     * Mark refund as processing.
     */
    public function markAsProcessing(): self
    {
        $this->update([
            'status' => self::STATUS_PROCESSING,
        ]);

        return $this;
    }

    /**
     * Mark refund as successful.
     */
    public function markAsSuccess(): self
    {
        $this->update([
            'status' => self::STATUS_SUCCESS,
            'processed_at' => now(),
        ]);

        return $this;
    }

    /**
     * Mark refund as failed.
     */
    public function markAsFailed(string $reason = null): self
    {
        $this->update([
            'status' => self::STATUS_FAILED,
            'reason' => $reason ?? $this->reason,
        ]);

        return $this;
    }

    /**
     * Mark refund as cancelled.
     */
    public function markAsCancelled(string $reason = null): self
    {
        $this->update([
            'status' => self::STATUS_CANCELLED,
            'reason' => $reason ?? $this->reason,
        ]);

        return $this;
    }

    /**
     * Get readable status label.
     */
    public function getStatusLabelAttribute(): string
    {
        return [
            self::STATUS_PENDING => 'Pending',
            self::STATUS_PROCESSING => 'Processing',
            self::STATUS_SUCCESS => 'Completed',
            self::STATUS_FAILED => 'Failed',
            self::STATUS_CANCELLED => 'Cancelled',
        ][$this->status] ?? ucfirst($this->status);
    }

    /**
     * Get status badge color.
     */
    public function getStatusColorAttribute(): string
    {
        return [
            self::STATUS_PENDING => 'warning',
            self::STATUS_PROCESSING => 'info',
            self::STATUS_SUCCESS => 'success',
            self::STATUS_FAILED => 'danger',
            self::STATUS_CANCELLED => 'secondary',
        ][$this->status] ?? 'secondary';
    }

    /**
     * Scope a query to only include pending refunds.
     */
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    /**
     * Scope a query to only include successful refunds.
     */
    public function scopeSuccessful($query)
    {
        return $query->where('status', self::STATUS_SUCCESS);
    }

    /**
     * Scope a query to only include failed refunds.
     */
    public function scopeFailed($query)
    {
        return $query->where('status', self::STATUS_FAILED);
    }

    /**
     * Scope a query to only include processing refunds.
     */
    public function scopeProcessing($query)
    {
        return $query->where('status', self::STATUS_PROCESSING);
    }

    /**
     * Get formatted amount.
     */
    public function getFormattedAmountAttribute(): string
    {
        return '₹' . number_format($this->amount, 2);
    }
     public function refunds(): HasMany
    {
        return $this->hasMany(Refund::class);
    }

    /**
     * Get the latest refund for the order.
     */
    public function latestRefund(): HasOne
    {
        return $this->hasOne(Refund::class)->latest();
    }

    /**
     * Get the successful refund for the order.
     */
    public function successfulRefund(): HasOne
    {
        return $this->hasOne(Refund::class)
            ->where('status', Refund::STATUS_SUCCESS)
            ->latest();
    }

    /**
     * Check if order has any refund.
     */
    public function hasRefund(): bool
    {
        return $this->refunds()->exists();
    }

    /**
     * Check if order is fully refunded.
     */
    public function isFullyRefunded(): bool
    {
        $totalRefunded = $this->refunds()
            ->where('status', Refund::STATUS_SUCCESS)
            ->sum('amount');
            
        return $totalRefunded >= $this->total_amount;
    }

    /**
     * Get total refunded amount.
     */
    public function getTotalRefundedAttribute(): float
    {
        return (float) $this->refunds()
            ->where('status', Refund::STATUS_SUCCESS)
            ->sum('amount');
    }

     public function reverseOrder(): BelongsTo
    {
        return $this->belongsTo(ReverseOrder::class, 'reverse_order_id');
    }
}