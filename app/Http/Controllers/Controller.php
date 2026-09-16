<?php

namespace App\Http\Controllers;
// use App\Models\Config;

abstract class Controller
{
    public function __construct()
    {
        // $configs = Config::latest()->get();
        // $config = [];
        // foreach($configs as $val) {
        //     $config[$val->key] = $val->value;
        // }
        // return view()->share('config', $config);
    }
}
