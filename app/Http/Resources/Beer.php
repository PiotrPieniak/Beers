<?php

namespace App\Http\Resources;

use App\Models\Country;
use App\Models\Brewer;
use Illuminate\Http\Resources\Json\JsonResource;

class Beer extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'brewer' => Brewer::find($this->brewer_id),
            'type' => $this->type,
            'size' => $this->size,
            'price' => $this->price,
            'image_url' => $this->image_url,
            'country' => Country::find($this->country_id),
            'price_per_litre' => $this->price_per_litre
        ];
    }
}
