<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class UserResource extends JsonResource
{
    /**
     * @var string
     */
    public static $wrap = 'Content';

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'createdAt' => Carbon::instance($this->createdAt)->toIso8601ZuluString('m'),
            $this->mergeWhen(Auth::user()->can('role-list') && $request->has('showRole') && $request->boolean('showRole'), [
                'roles' => new RoleCollection($this->roles)
            ]),
        ];
    }
}
