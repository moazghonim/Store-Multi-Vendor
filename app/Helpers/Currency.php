<?php


namespace App\Helpers;


use NumberFormatter;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;


class Currency
{

    public function __invoke(...$params)
    {
        return static::format(...$params);
    }

    public static function format($amount, $currency = null)
    {
        $base_currency = config('app.currency', 'USD');
        $formater = new NumberFormatter(config('app.locale'), NumberFormatter::CURRENCY);
        
        if ($currency === null) {
            $currency = session::get('currency_code', $base_currency);
        }

        if ($currency != $base_currency) {
            $rate = cache::get('currency_rate_' . $currency);
            $amount = $amount * $rate;
        }
        return $formater->formatCurrency($amount, $currency);
    }
}
