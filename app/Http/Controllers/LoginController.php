<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Client\Request as ClientRequest;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function checkAuth(Request $request){
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            return redirect()->route('dashboard');
        }else{
            return redirect()->back()->with('error', 'Email atau Password anda salah!');
        }
    }

    public function sendEmail(Request $request){
        $user = User::where('email', $request->email)->first();
        if($user == null)
            return redirect()->back()->with('error', 'Email tidak terdaftar di database kami');
        
        $to_name = $user->first_name.' '.$user->last_name;
        $to_email = $user->email;
        $data = [
            'nama' => $to_name
        ];
        
        Mail::send('email.forgot-password', $data, function($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)
                    ->subject('Lupa password kan?');
            $message->from(env('MAIL_FROM_ADDRESS'), "Pemberitahuan Lupa Password");
        });
        return redirect()->route('login')->with('success', 'Password berhasil diganti');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => $request->password
        ])->assignRole('customer');

        return redirect()->route('login')->with('success', 'Akun berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}