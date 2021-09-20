<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Workspace extends JsonResource
{
    public function toArray($request)
    {
        return [
            'label'      =>$this->label,
            'url'        =>$this->url,
            'description'=>$this->description,
            'is_active'  =>$this->is_active
        ];
    }

    public function withResponse($request, $response)
    {
        $response->header('Status', 'True');
    }
}
