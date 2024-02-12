<?php


namespace App\Services;

use Illuminate\Support\Facades\Http;

class CurrencyConverter {

    private $api_key;
    public $base_url = "https://free.currconv.com/api/v7";
    public function __construct($api_key)
    {
        $this->api_key = $api_key;
    }

    public function convert(string  $from, string $to, float $amount = 1): float
    {
        $response = Http::baseUrl($this->base_url)
        ->get('/convert', [
            'q' => "{$from}_{$to}",
            'compact' => 'y',
            'apiKey' => $this->api_key,
        ]);

        $result =  $response->json();
        return $result["{$from}_{$to}"]['val'] * $amount;
    }
}
