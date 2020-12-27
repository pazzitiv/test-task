<?php

namespace Modules\Prize\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PrizeTypes extends Model
{
    use HasFactory;

    protected $table = 'prize_types';

    protected $fillable = [
        'id',
        'code'
    ];
}
