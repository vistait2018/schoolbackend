<?php

namespace App\Http\Controllers\Api;

use App\Mail\MailInfo;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use function PHPUnit\Framework\isEmpty;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    use ApiResponser;

    public function register(Request $request)
    {
        $attr = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed'
        ]);

        $user = User::create([
            'name' => $attr['name'],
            'password' => bcrypt($attr['password']),
            'email' => $attr['email']
        ]);

        $info = new MailInfo('User Registration', '');
        Mail::to($user['email'])->send(new WelcomeMail($user, $info));
        return $this->success([
            'token' => $user->createToken('API Token')->plainTextToken
        ]);
    }

    public function login(Request $request)
    {
        $attr = $request->validate([
            'email' => 'required|string|email|',
            'password' => 'required|string|min:6'
        ]);

        if (!Auth::attempt($attr,$request->remember)) {
            return $this->error('Credentials not match', 401);
        }

        return $this->success([
            'token' => auth()->user()->createToken('API Token')->plainTextToken
        ],200);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return $this->success(null,'Tokens Revoked| You have been successfully logged out',200 );

    }



    public function confirmEmail(Request $request){
        if($this->checkIfEmailExists($request->email)){

        }
    }

    public function confirmPassword(){


    }

    public function checkIfEmailExists($email){
        $user = User::where('email', $email);
        if(isset($user->email) && !isEmpty($user->email )){
            return true;
        }

        return false ;
    }

}