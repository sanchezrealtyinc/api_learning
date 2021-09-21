<?php

namespace App\Http\Resources;

use App\Models\Customer;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'order_date' => $this->order_date,
            'order_status' => $this->order_status,
            'promotion_code' => $this->promotion_code,
            'customer' => new CustomerResource(Customer::find($this->customer_id)),
            'order_items' => OrderItemResource::collection($this->whenLoaded('orderItems'))
        ];
    }
}
