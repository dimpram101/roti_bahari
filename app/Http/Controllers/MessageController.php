<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller {
    public function index(Request $request) {
        $messages = Message::with('sender')
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('is_done');

        return view('dashboard.message.index', [
            'messages' => $messages,
        ]);
    }

    public function create(Request $request) {
        return view('message')->with([
            'title' => 'Message'
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'phone_number' => [
                'required',
                'string',
                'min:10',
                'regex:/^(62|08)/'
            ],
            'message' => 'required|string',
            'buyer_name' => 'required|string',
        ], [
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Email tidak valid.',
            'phone_number.required' => 'Phone number is required.',
            'phone_number.regex' => 'Nomor telepon harus diawali dengan 62 atau 08.',
            'message.required' => 'Pesanan harus diisi.',
            'buyer_name.required' => 'Nama pembeli harus diisi.',
        ]);

        Message::create([
            'sender_id' => $request->user()->id,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'message' => $request->message,
            'buyer_name' => $request->buyer_name,
        ]);

        return redirect()->route('user.message.create')->with('success', 'Pemesanan berhasil dibuat.');
    }

    public function toggleStatus(Request $request, Message $message) {
        $request->validate([
            'is_done' => 'nullable|boolean',
            'query' => 'nullable|string|max:255',
        ]);

        $message->is_done =  $request->input('is_done', !$message->is_done);
        $message->save();

        return redirect()->route('messages.index', [
            'tab' => $request->input('query')
        ])->with('success', 'Status pesanan berhasil diubah.');
    }

    public function destroy(Request $request, Message $message) {
        $message->delete();
        return redirect()->route('messages.index', [
            'tab' => $request->input('query')
        ])->with('success', 'Pesanan berhasil dihapus.');
    }
}
