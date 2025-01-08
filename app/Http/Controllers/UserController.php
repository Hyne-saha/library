<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    //
    public function register_user(Request $request){
        $validate = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',  // Fixed unique rule
            'password' => 'required|min:8',  // Fixed validation syntax
        ]);
    
        // Hash the password
        $hashpassword = Hash::make($validate['password']);
    
        // Create the user and insert into the database
        $user = User::create([
            'name' => $validate['name'],
            'email' => $validate['email'],
            'password' => $hashpassword,
        ]);
    
    
    
        // Return a JSON response with the created user
        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user
        ], 200);
    }


    public function login_user(Request $request){
        $login_validate = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8'
        ]);
        // print_r($login_validate); exit;

        if($login_validate->fails()){   
            return response()->json([
                'message' => 'Invalid login details',
                'errors' => $login_validate->errors()
            ], 401);
        }

        $user = User::where('email', $request->email)->where('role', 'user')->first();
        if(!$user){
            return response()->json([
                'message' => 'Email not found',
            ], 401);
        }
        $password_check = Hash::check($request->password, $user->password);
        
        if(!$password_check){
            return response()->json([
                'message' => 'In-correct password',
            ], 401);
        }


        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $request->session()->regenerate();
            // $user = Auth::user();
            $request->session()->put('users', $user);
            // print_r()
            // $user = Session::get('users');

            // var_dump($user); exit;
            $csrfToken = csrf_token();
            return response()->json([
                'message' => 'Login successful',
                'user' => $user,
                'csrfToken' => $csrfToken
            ], 200);
        }
        else{
            return response()->json([
                'message' => 'Invalid login details',
            ], 401);
        }
    }
}
