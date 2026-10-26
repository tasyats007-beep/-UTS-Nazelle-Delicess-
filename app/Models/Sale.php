<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'sale_number',
        'customer_name',
        'total',
        'status',
        'payment_method',
        'payment_status',
        'paid_at',
        'payment_ref',
        'sold_at',
        'notes',
    ];

    protected $casts = [
        'total' => 'decimal:2',
        'sold_at' => 'datetime',
        'paid_at' => 'datetime',
    ];

    public function getPaymentMethodLabelAttribute(): string
    {
        return match ($this->payment_method) {
            'qris' => 'QRIS',
            'bank_transfer' => 'Transfer Bank',
            'cashier' => 'Bayar di Kasir',
            default => 'Bayar di Kasir',
        };
    }

    public function getPaymentStatusLabelAttribute(): string
    {
        return match ($this->payment_status) {
            'paid' => 'Pembayaran Berhasil',
            'unpaid' => 'Belum Lunas (Bayar di Kasir)',
            'unconfigured_qris' => 'Belum Lunas (QRIS Belum Dikonfigurasi - Bayar di Kasir)',
            'unconfigured_bank' => 'Belum Lunas (Rekening Belum Dikonfigurasi - Bayar di Kasir)',
            default => 'Belum Lunas',
        };
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(SaleItem::class);
    }

    public function saleItems(): HasMany
    {
        return $this->hasMany(SaleItem::class);
    }
}
