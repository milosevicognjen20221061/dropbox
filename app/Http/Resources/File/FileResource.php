<?php

namespace App\Http\Resources\File;

use App\Http\Resources\Folder\FolderResource;
use App\Http\Resources\Type\TypeResource;
use Illuminate\Http\Resources\Json\JsonResource;

class FileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public static $wrap = 'file';

    public function toArray($request)
    {
        return [
            'name' => $this->resource->name,
            'folder' => new FolderResource($this->resource->folder),
            'type' => new TypeResource($this->resource->type),
            'size' => $this->resource->size . $this->resource->unit,
        ];
    }
}
