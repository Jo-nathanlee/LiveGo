<?php

namespace App\Http\Controllers;

use App\Bot\Webhook\Entry;
use App\Jobs\BotHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MessengerController extends Controller
{
    public function index(Request $request)
    {
        DriverManager::loadDriver(\BotMan\Drivers\Facebook\FacebookDriver::class);
        $bot=BotManFactory::create($config);
        $bot->reply(ButtonTemplate::create('Do you want to know more about BotMan?')
        ->addButton(ElementButton::create('Tell me more')
            ->type('postback')
            ->payload('tellmemore')
        )
        ->addButton(ElementButton::create('Show me the docs')
            ->url('http://botman.io/')
        )
    );

    }
}
