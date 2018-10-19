<?php

namespace Artistan\ZeroNullDates\Tests\Database;

use Artistan\ZeroNullDates\ZNDTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Class TestUser
 *
 * @mixin \Illuminate\Database\Eloquent\Model
 */
class ZeroNullableUser extends Authenticatable
{
    use Notifiable;
    use DynamicModelMethods;
    use ZNDTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should use date mutator
     *
     * @var array
     */
    protected $dates = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    // **** these are class overrides to allow zero dates

    /**
     * The attributes that are zero-dated
     *
     * @var array
     */
    public static $zero_date = [
        'created_date',
    ];

	/**
	 * The attributes that are zero-datetimed
	 *
	 * @var array
	 */
	public static $zero_datetime = [
		'created_date_time',
		'created_date_time_zoned'
	];

    /**
     * The attributes that are nullable dates
     *
     * @var array
     */
    public static $nullable = [
        'created_date_time_null',
        'created_date_time_zoned_null',
        'created_date_null',
        'created_at',
        'updated_at',
    ];
}
