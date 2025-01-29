<?php

namespace App\Http\Controllers\User;

use App\Models\UserVerify;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class ForgotController extends Controller
{
    public function iforgor(){
        
        return view('user.forgor');
    }

    public function sendReset(Request $request){
        $request->validate([
            'email' => 'required|email|exists:users'
        ], [
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.exists' => 'Email tidak terdaftar',
        ]);

        $token = Str::uuid();
        UserVerify::where('email', $request->input('email'))->delete();
        $data = [
            'email' => $request->input('email'),
            'token' => $token
        ];

        UserVerify::create($data);
        Mail::send('user.email-reset', ['token' => $token], function($message) use ($request){
            $message->to($request->input('email'));
            $message->subject('Reset Password');        
        });

        return redirect()->route('forgor')->with('success', 'Email reset password sudah dikirimkan')->withInput();

    }

    public function resetPassword($token){
        
        return view('user.reset-pass', compact('token'));
    }

    public function doReset(Request $request){
        $request->validate([
            'password' => 'required|string|min:2',
            'passwordC' =>  'required_with:password|same:password',
         ], [
             'password.required'=>'Password wajib diisi',
             'password.string'=>'Hanya string yang bisa diperbolehkan',
             'password.min'=>'Minimum karakter untuk password adalah 2',
             'passwordC.required_with'=>'Konfirmasi password wajib diisi',
             'passwordC.same'=>'Password konfirmasi tidak sama dengan yang dimasukkan',
             ]        
         );

        $dataUser = UserVerify::where('token', $request->input('token'))->first();

        if(!$dataUser){
            return redirect()->back()->withInput()->withErrors('Token tidak valid');
        }

        $email = $dataUser->email;

        $data = [
          'password' => bcrypt($request->input('password')),
          'email_verified_at' => Carbon::now()
        ];

        User::where('email', $email)->update($data);
        UserVerify::where('email', $email)->delete();

        return redirect()->route('login')->with('success', 'Password sudah diganti');
    }
}