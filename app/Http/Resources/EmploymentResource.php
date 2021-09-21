<?php

namespace App\Http\Resources;

use App\Models\Person;
use Illuminate\Http\Resources\Json\JsonResource;

class EmploymentResource extends JsonResource
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
            'work_position' => $this->work_position,
            'job_title' => $this->job_title,
            'salary' => $this->salary,
            'personal_info' => new PersonResource(Person::find($this->person_id))
        ];
    }

    public function with($request)
    {
        return [
            'ok' => true
        ];
    }
}
