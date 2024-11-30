<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Client\Request as ClientRequest;

class LoginController extends Controller
{
    public function checkAuth(Request $request)
{
    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
        if (Auth::user()->hasRole('admin')) {
            return redirect()->route('dashboard');
        }
        return redirect()->route('dashboardcust');
    }
    return redirect()->back()->with('error', 'Email atau Password anda salah!');
}


    public function logout(){
        Auth::logout();
        return redirect()->route('login');
    }

        public function sendEmail(Request $request)
    {
        $user = $this->getUserByEmail($request->email);

        if (!$user) {
            return redirect()->back()->with('error', 'Email tidak terdaftar di database kami');
        }

        $this->sendPasswordResetEmail($user);

        return redirect()->route('login')->with('success', 'Password berhasil diganti');
    }

    private function getUserByEmail($email)
    {
        return User::where('email', $email)->first();
    }

    private function sendPasswordResetEmail($user)
    {
        $to_name = $user->first_name . ' ' . $user->last_name;
        $to_email = $user->email;
        $data = ['nama' => $to_name];

        Mail::send('email.forgot-password', $data, function ($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)
                    ->subject(config('mail.subjects.forgot_password', 'Lupa password kan?'));
            $message->from(config('mail.from.address', env('MAIL_FROM_ADDRESS')), config('mail.from.name', 'Pemberitahuan Lupa Password'));
        });
    }
    public function store(Request $request)
    {
        User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ])->assignRole('customer');

        return redirect()->route('login')->with('success', 'Akun berhasil dibuat');
    }

}
