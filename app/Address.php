<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'address';

    protected $fillable = [
        'user_id',
		'provinsi',
		'kabupaten',
		'kecamatan',
		'kelurahan',
		'name',
		'email',
		'phone',
		'address',
		'location'
    ];
}