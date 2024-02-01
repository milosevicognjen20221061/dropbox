<?php

namespace App\Http\Resources\Folder;

use Illuminate\Http\Resources\Json\JsonResource;

class FolderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public static $wrap = 'folder';

    public function toArray($request)
    {
        return [
            'name' => $this->resource->name,
            'description' => $this->resource->description,
        ];
    }
}
