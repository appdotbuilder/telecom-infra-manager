<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Region
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string|null $description
 * @property array|null $boundaries
 * @property array|null $design_data
 * @property array|null $rab_data
 * @property array|null $permits_data
 * @property string $stage
 * @property bool $data_completed
 * @property bool $design_completed
 * @property bool $rab_completed
 * @property bool $permits_completed
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Region newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Region newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Region query()
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereBoundaries($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereDataCompleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereDesignCompleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereDesignData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region wherePermitsCompleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region wherePermitsData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereRabCompleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereRabData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereStage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereUpdatedAt($value)
 * @method static \Database\Factories\RegionFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class Region extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'code',
        'description',
        'boundaries',
        'design_data',
        'rab_data',
        'permits_data',
        'stage',
        'data_completed',
        'design_completed',
        'rab_completed',
        'permits_completed',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'boundaries' => 'array',
        'design_data' => 'array',
        'rab_data' => 'array',
        'permits_data' => 'array',
        'data_completed' => 'boolean',
        'design_completed' => 'boolean',
        'rab_completed' => 'boolean',
        'permits_completed' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}