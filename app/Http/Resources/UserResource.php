<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class UserResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'days_left'=>$this->days_left,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'profile_photo_path' => Storage::url($this->profile_photo_path),
            'roles'=>$this->getRoleNames(),
        ];
    }
}
