<?php

namespace App\Models;

use App\Traits\ToIso8601;
use Zizaco\Entrust\EntrustRole;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends EntrustRole
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

    /**
     * @return BelongsToMany
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class);
    }
}
