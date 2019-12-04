<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'fp_files';

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
        'expire_day',
        'image',
        'fields',
        'file',
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
