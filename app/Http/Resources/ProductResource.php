<?php

namespace App\Http\Resources;

use App\Models\Category;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'weight_class' => $this->weight_class,
            'minimun_price' => $this->minimun_price,
            'price_currency' => $this->price_currency,
            'category' => new CategoryResource(Category::find($this->category_id))
        ];
    }

    public function with($request)
    {
        return [
            'ok' => true
        ];
    }
}
