<?php

namespace App\Traits;

use Carbon\Carbon;
use DateTimeInterface;

trait ToIso8601
{
    /**
     * Prepare a date for array / JSON serialization.
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date): string
    {
        return Carbon::instance($date)->toIso8601ZuluString('m');
    }
}
