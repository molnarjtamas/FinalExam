<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;


class HolidayResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
//        dd($this);
        return [
            'id' => $this->id,
            'user' => User::find($this->user_id),
            'type' => $this->type,
            'start_date' => $this->start_date,
            'end_date'=> $this->end_date,
            'approved' => $this->approved,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

        ];
    }
}
