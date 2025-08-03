<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\NetworkDevice
 *
 * @property int $id
 * @property string $name
 * @property string $type
 * @property float $latitude
 * @property float $longitude
 * @property string|null $address
 * @property string $status
 * @property int|null $port_count
 * @property int $ports_used
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|NetworkDevice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NetworkDevice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NetworkDevice query()
 * @method static \Illuminate\Database\Eloquent\Builder|NetworkDevice whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NetworkDevice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NetworkDevice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NetworkDevice whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NetworkDevice whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NetworkDevice whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NetworkDevice whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NetworkDevice wherePortCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NetworkDevice wherePortsUsed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NetworkDevice whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NetworkDevice whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NetworkDevice whereUpdatedAt($value)
 * @method static \Database\Factories\NetworkDeviceFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class NetworkDevice extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'type',
        'latitude',
        'longitude',
        'address',
        'status',
        'port_count',
        'ports_used',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'port_count' => 'integer',
        'ports_used' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}