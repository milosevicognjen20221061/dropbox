<?php

namespace App\Http\Resources\Folder;

use Illuminate\Http\Resources\Json\ResourceCollection;

class FolderCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public static $wrap = 'folders';

    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
