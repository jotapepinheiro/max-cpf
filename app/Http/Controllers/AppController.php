<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

class AppController extends Controller
{
    /**
     * @return string
     */
    public function index(): string
    {
        $now = Carbon::now()->format('d/m/Y H:i:s');

        return config('app.name') . '<br />Versão: ' . app()->version() . '<br />Data Atual: ' . $now;
    }
}
