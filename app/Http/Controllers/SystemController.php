<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SystemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return [
            'meta' => [
                'type' => 'config',
            ],
            'data' => [
                'attributes' => [
                    'name' => config('app.name'),
                    'logo' => json_encode([
                        'url' => config('app.logo'),
                        'path' => basename(config('app.logo')),
                    ]),
                ]
            ]
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->json('data');
        $logo = json_decode($data['attributes']['logo'], true);
        $this->saveEnv('APP_NAME', $data['attributes']['name']);
        $this->saveEnv('APP_LOGO', $logo['url']);
    }

    /**
     * Change .env configuration
     *
     * @param string $key
     * @param string $value
     * @return void
     */
    public function saveEnv($key, $value)
    {
        $config = file_get_contents(base_path('.env'));
        $regexp = '/' . preg_quote($key, '/') . '\s*=\s*.+/';
        if (preg_match($regexp, $config)) {
            $config = preg_replace($regexp, $key . '="' . addslashes($value) . '"', $config);
        } else {
            $config .= "\n" . $key . '="' . addslashes($value) . '"' . "\n";
        }
        file_put_contents(base_path('.env'), $config);
    }
}
