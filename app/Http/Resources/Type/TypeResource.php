<?php

namespace App\Http\Resources\Type;

use Illuminate\Http\Resources\Json\JsonResource;

class TypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public static $wrap = 'type';

    public function toArray($request)
    {
        return [
            'name' => $this->resource->name,
        ];
    }
}
