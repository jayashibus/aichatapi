<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
       // return parent::toArray($request);
       return [
             'customer_id' => $this->customer_id,
            'total_spent' => $this->total_spent,
            'total_saving' => $this->total_saving,
            'transaction_at' => $this->transaction_at, 
       ];
    }
}
