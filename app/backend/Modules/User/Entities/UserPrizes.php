<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Prize\Entities\Prize;
use Modules\Prize\Entities\PrizeTypes;

class UserPrizes extends Model
{
    use HasFactory;

    protected $table = 'user_prizes';

    protected $fillable = [
        'id',
        'draw_id',
        'user_id',
        'type',
        'amount',
        'prize_id',
        'sended',
    ];

    public function types()
    {
        return $this->belongsTo(PrizeTypes::class, 'type', 'id');
    }

    public function items()
    {
        return $this->belongsTo(Prize::class, 'prize_id', 'id');
    }
}
