<?php

namespace App;

use Beebmx\Panel\Administrable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model
{
    use SoftDeletes, Administrable;

    protected $blueprint = 'profiles';
    
    protected $hidden = [
        'deleted_at'
    ];
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $casts = [
        'is_admin' => 'boolean',
        'has_panel' => 'boolean'
    ];
}
