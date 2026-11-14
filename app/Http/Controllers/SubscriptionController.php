<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'service_id' => ['required', 'exists:services,id'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $request->user()->subscriptions()->create([
            ...$data,
            'status' => 'pending',
        ]);

        return redirect()->route('home')->with('status', 'Permintaan berlangganan terkirim. Tim kami akan segera menghubungi Anda.');
    }
}