<?php

namespace Modules\Draw\Entities;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\User\Entities\UserPrizes;

class Draw extends Model
{
    use HasFactory, HasTimestamps, SoftDeletes;

    protected $fillable = [
        'id',
        'name',
        'active'
    ];

    protected static function newFactory()
    {
        return \Modules\Draw\Database\factories\DrawFactory::new();
    }

    public function prize()
    {
        return $this->belongsTo(UserPrizes::class, 'id', 'draw_id');
    }
}
