<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\BillingRecord
 *
 * @property int $id
 * @property int $customer_id
 * @property float $amount
 * @property string $period_month
 * @property float|null $usage_mb
 * @property string $status
 * @property \Illuminate\Support\Carbon $due_date
 * @property \Illuminate\Support\Carbon|null $paid_at
 * @property array|null $mikrotik_data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Customer $customer
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|BillingRecord newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BillingRecord newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BillingRecord query()
 * @method static \Illuminate\Database\Eloquent\Builder|BillingRecord whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillingRecord whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillingRecord whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillingRecord whereDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillingRecord whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillingRecord whereMikrotikData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillingRecord wherePaidAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillingRecord wherePeriodMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillingRecord whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillingRecord whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillingRecord whereUsageMb($value)
 * @method static \Database\Factories\BillingRecordFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class BillingRecord extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'customer_id',
        'amount',
        'period_month',
        'usage_mb',
        'status',
        'due_date',
        'paid_at',
        'mikrotik_data',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'amount' => 'decimal:2',
        'usage_mb' => 'decimal:2',
        'due_date' => 'datetime',
        'paid_at' => 'datetime',
        'mikrotik_data' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the customer that owns the billing record.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}