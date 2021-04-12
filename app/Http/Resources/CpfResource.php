<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;


class CpfResource extends JsonResource
{
    /**
     * @var string
     */
    public static $wrap = 'Content';

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'cpf' => $this->cpf,
            'createdAt' => Carbon::instance($this->createdAt)->toIso8601ZuluString('m'),
            $this->mergeWhen( Auth::user()->can('user-list') && $request->has('showUser') && $request->boolean('showUser'), [
                'user' => [
                    'Content' => new UserResource($this->user)
                ]
            ]),
        ];
    }
}
