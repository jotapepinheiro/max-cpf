<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class RoleResource extends JsonResource
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
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'display_name' => $this->display_name,
            'description' => $this->description,
            'createdAt' => Carbon::instance($this->createdAt)->toIso8601ZuluString('m'),
            $this->mergeWhen(Auth::user()->can('permission-list') && $request->has('showPermission') && $request->boolean('showPermission'), [
                'permissions' => new PermissionCollection($this->permissions)
            ]),
        ];
    }
}
