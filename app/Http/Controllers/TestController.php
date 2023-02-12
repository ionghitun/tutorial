<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;

/**
 *
 */
class TestController extends Controller
{
    /**
     * @return void
     */
    public function index()
    {
        Log::emergency('emergency');
        Log::alert('alert');
        Log::critical('critical');
        Log::error('error');
        Log::warning('warning');
        Log::notice('notice');
        Log::info('info');
        Log::debug('debug');

        echo 'Works';
    }
}
