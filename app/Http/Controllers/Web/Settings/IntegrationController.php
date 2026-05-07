<?php

namespace App\Http\Controllers\Web\Settings;

use App\Http\Controllers\Web\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class IntegrationController extends Controller
{
    public function index(): View
    {
        abort_if(!Auth::user()->can('manage_settings'), 403);
        return view('settings.integrations');
    }
}
