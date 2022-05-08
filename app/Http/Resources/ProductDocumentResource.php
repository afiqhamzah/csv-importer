<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductDocumentResource extends JsonResource
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
		    'file_name' => $this->file_name,
		    'status_code' => $this->status,
		    'status_name' => $this->statusLabel(),
	    ];
    }
}
