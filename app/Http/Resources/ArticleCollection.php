<?php

namespace App\Http\Resources;

use App\Http\Resources\ArticleResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ArticleCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public $collects = ArticleResource::class;

    public function toArray($request)
    {
        return [
            'data' => $this->collection,
            'links' => [
                'self' => url('/articles'),
            ],
        ];
    }
}
