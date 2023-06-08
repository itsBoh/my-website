<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class formMessage extends Controller
{
    public function formMessage(Request $request)
    {
        $data = $request->only(['email', 'msg']);
        $email = $data['email'];
        $message = $data['msg'];
        DB::insert('INSERT INTO SARAN (EMAIL, PESAN) VALUES (?, ?)', [$email, $message]);

        return view('contact')->with('success', 'Pesan berhasil dikirim');
    }
}
