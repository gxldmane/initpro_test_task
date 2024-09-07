<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TenderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'tenderNumber' => $this->tender_number,
            'organization' => $this->organization,
            'link' => $this->link,
            'startDate' => $this->start_date->format('Y-m-d H:i:s'),
            'files' => FileResource::collection($this->files)
        ];
    }
}
