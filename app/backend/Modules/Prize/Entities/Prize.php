<?php

namespace Modules\Prize\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Prize extends Model
{
    use HasFactory;

    protected $table = 'prizes';

    protected $fillable = [
        'id',
        'prizeName',
        'price',
    ];

    protected static function newFactory()
    {
        return \Modules\Prize\Database\factories\PrizeFactory::new();
    }
}
