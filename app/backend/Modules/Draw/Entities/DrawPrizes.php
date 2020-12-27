<?php

namespace Modules\Draw\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DrawPrizes extends Model
{
    protected $fillable = [
        'id',
        'draw_id',
        'prize_type',
        'amount',
        'item_id',
    ];
}
