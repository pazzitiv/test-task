<?php

namespace Modules\Draw\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Prize\Entities\Prize;
use Modules\Prize\Transformers\PrizeResource;
use Modules\User\Transformers\UserPrizeResource;

class DrawResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'active' => $this->active,
            'prize' => UserPrizeResource::make($this->prize),
        ];
    }
}
