<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'fp_forms';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'amount',
        'pay_limit',
        'pay_count',
        'fields',
        'image',
        'default',
        'status',
        'form_size'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'fields' => 'array',
    ];

    /**
     * @var array
     */
    public static $status = [
        'active' => 1,
        'deleted' => 2
    ];
}
