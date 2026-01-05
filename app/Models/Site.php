<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
//    protected $connection = 'mysql_center';

    protected $table = 'sites';

    protected $fillable = [
        'name', 'domain', 'gtag'
    ];
}
