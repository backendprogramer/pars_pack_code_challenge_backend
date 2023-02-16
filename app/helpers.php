<?php

use App\Models\Status;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;


if (!function_exists('getUrl')) {
    /**
     * Convert string to url
     *
     * @param $string
     * @return string
     */
    function getUrl($string) : string
    {
        $url = str_replace('-', ' ', $string);
        $url = str_replace('/', ' ', $url);
        return preg_replace('/\s+/', '-', $url);
    }
}

if (!function_exists('getExpireDateByStatus')) {
    /**
     * Get expired date by status
     *
     * @param $statusKey
     * @return int
     */
    function getExpireDateByStatus($statusKey): int
    {
        $date = new \DateTime();
        $day = fake()->numberBetween(1, 364);
        switch ($statusKey) {
            case 0: //Active
            case 2: //Pending
                return $date->modify('+' . $day . ' day')->getTimestamp();
            case 1: //Expired
                return $date->modify('-' . $day . ' day')->getTimestamp();
            default:
                return $date->getTimestamp();
        }
    }
}

if (!function_exists('sendRequest')) {
    /**
     * Send Request with guzzle
     *
     * @param $methode
     * @param $url
     * @param $data
     * @return array
     * @throws GuzzleException
     */
    function sendRequest($methode, $url, $data = ''): array
    {
        $client = new Client();
        $res = $client->request($methode, env('APP_URL', 'localhost:8000') . $url, ['json' => $data ]);
        return json_decode($res->getBody(), true);
    }
}
