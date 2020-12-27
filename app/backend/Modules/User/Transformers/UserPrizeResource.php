<?php

namespace Modules\User\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class UserPrizeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $code = $this->types->code;
        $items = $this->items;

        return [
            'id' => $this->id,
            'name' => $code === 'item' ? $items->prizeName : null,
            'type' => $code,
            'amount' => $this->amount,
        ];
    }
}
