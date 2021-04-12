<?php

namespace App\Models;

use App\Traits\JWT;
use App\Traits\ToIso8601;
use Illuminate\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject
{
    use Authenticatable, HasFactory, JWT, ToIso8601;
    use EntrustUserTrait {
        can as entrustCan;
    }

    protected $table = 'users';

    protected $dateFormat = 'Y-m-d\TH:i:s.u';

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id', 'name', 'email', 'password'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var string[]
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    /**
     * @var string[]
     */
    protected $dates = [
        'email_verified_at',
        'createdAt',
        'updatedAt',
    ];

    /**
     * @return HasOne
     */
    public function cpf(): HasOne
    {
        return $this->hasOne(Cpf::class);
    }

    /**
     * Define all permissions for role Super Admin
     *
     * @param string|array $permission
     * @param bool $requireAll
     * @return bool
     */
    public function can($permission, $requireAll = false): bool
    {
        if (Auth::user()->hasRole('super')) {
            return true;
        }

        return $this->entrustCan($permission, $requireAll);
    }

}
