<?php

namespace App\Models;

use App\Traits\ToIso8601;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cpf extends Model
{
    use HasFactory, ToIso8601;

    protected $table = 'cpfs';

    protected $dateFormat = 'Y-m-d\TH:i:s.u';

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id', 'cpf'
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
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
