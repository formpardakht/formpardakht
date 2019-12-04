<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Factor extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'fp_factors';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'amount',
        'tax',
        'items',
        'paid',
        'transaction_id',
        'status',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'items' => 'array',
    ];

    /**
     * @var array
     */
    public static $status = [
        'active' => 1,
        'deleted' => 2,
    ];
}
