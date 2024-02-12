<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Services\CurrencyConverter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class CurrencyConverterController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'currency_code' => 'required|size:3',
        ]);

        $baseCurrecyCode = config('app.currnecy');
        $currency_code = $request->input('currency_code');

        $casheKey = 'currency_rate_' . $currency_code;
        $rate = Cache::get($casheKey, 0);

        if (!$rate) {
            $converter = new CurrencyConverter(config('services.Currency_Converter.apikey'));
            $rate = $converter->convert($baseCurrecyCode, $currency_code);
            Cache::put($casheKey, $rate, now()->addMinutes(60));
        }
        session::put('currency_code', $currency_code);
        return back();

    }
}
