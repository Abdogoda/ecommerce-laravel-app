<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMessageRequest;
use App\Models\Message;

class ContactController extends Controller
{
    public function __invoke(StoreMessageRequest $request)
    {
        $validated = $request->validated();

        Message::create($validated);

        return redirect()
            ->route('home')
            ->with('success', 'Thank you for your message! We will get back to you soon.')
            ->withFragment('get-in-touch');
    }
}