<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Services\KlaviyoClient;

class KlaviyoEventController extends Controller
{
    public function track(KlaviyoClient $klaviyo)
    {
        $klaviyo->trackEvent(Auth::user()->email);

        return redirect()->route('dashboard');
    }
}
