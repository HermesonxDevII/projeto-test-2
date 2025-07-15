<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class ChatsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): View
    {       
        $users = Auth()->user();

        $chatUrl = match (app()->environment()) {
            'local' => 'http://localhost:81/chats',
            'homolog' => 'https://chat-homolog.academy-meliseducation.com/chats',
            default => 'https://chat.academy-meliseducation.com/chats',
        };

        return view('chats.index', compact('users', 'chatUrl'));
    }

    public function show(Request $request, int $id): View
    {
        $users = Auth()->user();
        
        $chatUrl = match (app()->environment()) {
            'local' => "http://localhost:81/chats/{$id}",
            'homolog' => "https://chat-homolog.academy-meliseducation.com/chats/{$id}",
            default => "https://chat.academy-meliseducation.com/chats/{$id}",
        };

        return view('chats.index', compact('users', 'chatUrl'));
    }
}
