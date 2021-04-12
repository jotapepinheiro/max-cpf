<?php

namespace App\Models;

use App\Traits\ToIso8601;
use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{
    use ToIso8601;

    protected $dateFormat = 'Y-m-d\TH:i:s.u';

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    /**
     * @var string[]
     */
    protected $dates = [
        'createdAt',
        'updatedAt',
    ];

    protected $hidden = ['pivot'];

    protected $fillable = [
        'id', 'name', 'display_name', 'description'
    ];

}
