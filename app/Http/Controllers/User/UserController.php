<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\UserVerify;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    function login(){
        return view('user.login');
        
    }
    
    function doLogin(Request $request){
        $data = [
          'email'=>$request->input('email'), 
          'password'=>$request->input('password')  
        ];

        if(Auth::attempt($data)){
            if(Auth::user()->email_verified_at == ''){
                Auth::logout();
                return redirect()->route('login')->withErrors('Akun anda belum terverifikasi, cek email.');
            }

            return redirect()->route('todo');
        }else{
            return redirect()->route('login')->withErrors('Username dan password tidak sesuai')->withInput();
        }
    }
    
    function register(){
        return view('user.register');
    }

    function doRegister(Request $request){
        $request->validate([
            // email:rfc,dns untuk cek apakah email valid
            'email' => 'required|email|string|max:100|unique:users,email',
            'name' => 'required|max:20|min:2',
            'password' => 'required|string|min:2',
            'passwordC' =>  'required_with:password|same:password',
         ], [
             'email.required' => 'Email wajib diisi',
             'email.email' => 'Masukkan email yang valid',
             'email.string' => 'Email wajib bersifat string',
             'email.max' => 'Maximum karakter untuk email adalah 100',
             'email.unique' => 'Email sudah terdaftar',
             'name.required'=>'Kolom nama wajib diisi',
             'name.min'=>'Minimum karakter untuk nama adalah 2',
             'name.max'=>'Maximum karakter untuk nama adalah 20',
             'password.required'=>'Password wajib diisi',
             'password.string'=>'Hanya string yang bisa diperbolehkan',
             'password.min'=>'Minimum karakter untuk password adalah 2',
             'passwordC.required_with'=>'Konfirmasi password wajib diisi',
             'passwordC.same'=>'Password konfirmasi tidak sama dengan yang dimasukkan',
             ]        
         );

        $data = [
          'email' => $request->input('email'),  
          'name' => $request->input('name'),  
          'password' => bcrypt($request->input('password')),  
        ];

        User::create($data);

        $cekToken = UserVerify::where('email', $request->input('email'))->first();

        if ($cekToken){
            UserVerify::where('email', $request->input('email'))->delete();
        }

        $token = Str::uuid();
        $data = [
            'email' => $request->input('email'),  
            'token' => $token  
        ];

        UserVerify::create($data);
        
        Mail::send('user.email-verif', ['token' => $token], function($message) use ($request){
            $message->to($request->input('email'));
            $message->subject('Email Verification');        
        });

        return redirect()->route('register')->with('success', 'Berhasil registrasi, cek email.')->withInput();
    }

    function verifAcc($token) {
        $checkUser = UserVerify::where('token', $token)->first();

        if(!is_null($checkUser)){
            $email = $checkUser->email;
            
            $dataUser = User::where('email', $email)->first();
            if($dataUser->email_verified_at){
                $message = 'Akun anda sudah terverifikasi sebelumnya';
            }else{
                $data = [
                  'email_verified_at' => Carbon::now()  
                ];
                User::where('email', $email)->update($data);
                UserVerify::where('email', $email)->delete();
                $message = "Akun anda sudah terverifikasi, silahkan login";
            }

            return redirect()->route('login')->with('success', $message);
        }else{
            return redirect()->route('login')->withErrors('Link token tidak valid');
        }

    }
    
    function updateData(){
        return view('user.update');
    }
    
    function doUpdateData(Request $request){
        // dd($request);

        $request->validate([
           'name' => 'required|max:20|min:2',
           'password' => 'nullable|string|min:2',
           'passwordC' =>  'required_with:password|same:password',
        ], [
            'name.required'=>'Kolom nama wajib diisi',
            'name.min'=>'Minimum karakter untuk nama adalah 2',
            'name.max'=>'Maximum karakter untuk nama adalah 20',
            'password.string'=>'Hanya string yang bisa diperbolehkan',
            'password.min'=>'Minimum karakter untuk password adalah 2',
            'passwordC.required_with'=>'Konfirmasi password wajib diisi',
            'passwordC.same'=>'Password konfirmasi tidak sama dengan yang dimasukkan',
            ]        
        );
        
        $data = [
          'name' => $request->input('name'),
          'password' => $request->input('password') ? bcrypt($request->input('password')) : Auth::user()->password  
        ];

        User::where('id', Auth::user()->id)->update($data);
        
        return redirect()->route('user.update')->with('success', 'Data berhasil update');
        
    }
        
    function logout(){
        Auth::logout();
        return redirect()->route('login');
    }

    


}