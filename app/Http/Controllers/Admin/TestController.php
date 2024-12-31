<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;

class TestController extends Controller
{
    public function index()
    {
        abort(403);
    }

    public function clearConfig(): string
    {
        Artisan::call('optimize:clear');

        dd('Clear config done!');
    }

    public function optimizeConfig(): string
    {
        Artisan::call('optimize');

        dd('Optimize config done!');
    }
}
