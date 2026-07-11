<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Setting;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    function getVerse(){
        if(!Setting::first() || Setting::first()->updated_at->isToday() === false) {
            $message = Http::get('https://bible-api.com/data/kjv/random/rom,1co,2co,gal,eph,php,col,1th,2th,1ti,2ti,tit,phm,heb,jas,1pe,2pe,1jn,2jn,3jn')->json();
            $Setting = Setting::first() ?? new Setting();
            $Setting->verse = $message['random_verse']['text'];
            $Setting->verse_reference = "{$message['random_verse']['book']} {$message['random_verse']['chapter']}:{$message['random_verse']['verse']}";
            $Setting->updated_at = now();
            $Setting->save();
        }

        return Setting::first();
    }
}