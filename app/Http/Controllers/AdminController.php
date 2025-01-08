<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Book;
// use App\Models\Dashboard;
use App\Models\Transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    //
    public function admin_login(Request $request){
        $login_validate = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8'
        ]);

        if($login_validate->fails()){   
            return response()->json([
                'message' => 'Invalid login details',
                'errors' => $login_validate->errors()
            ], 401);
        }

        $user = User::where('email', $request->email)->where('role', 'admin')->first();
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
            $request->session()->put('adminusers', $user);
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


    public function addbooks(Request $request){
        $adminUser = Session::get('adminusers');
        // print_r($adminUser); exit;
        if($adminUser){
            return view('admin.addbooks', compact('adminUser'));
        }
        else{
            return redirect()->route('admin.adminlogin')->with('error', 'Please log in to continue.');
        }
    }


    public function getAllBooks(){
        $books = Book::all();
        return response()->json([
            'status' => 'success',
            'data' => $books
        ]);
    }

    public function addBook(Request $request){
        $name = $request->input('name');
        $title = $request->input('title');
        $created_at = date('Y-m-d');
        $status = 'available';
        $user_id = $request->input('user_id');

        $book = Book::create([
            'title' => $title,
            'author' => $name,
            'created_at' => $created_at,
            'status' => 'available',
            'user_id' => $user_id

        ]);

        if($book){
            return response()->json([
                'status' => 'success',
                'message' => 'Book created successfully'
            ]);
        }
    }

    public function deleteBook(Request $request){
        $book_id = $request->input('book_id');
        $book = Book::find($book_id);
        if($book){
            $book->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Book deleted successfully'
            ]);
        }
        else{
            return response()->json([
                'status' => 'error',
                'message' => 'Book not found'
            ]);
        }
    }

    public function users(){
        $userlist = Session::get('adminusers');
        if($userlist){
            return view('admin.users', compact('userlist'));
        }
        else{
            return redirect()->route('admin.adminlogin')->with('error', 'Please log in to continue.');
        }
    }

    public function getAllUsers(){
        $user = User::where('role', 'user')->get();
        return response()->json([
            'status' => 'success',
            'data' => $user
        ]);
    }

    public function deleteUser(Request $request){
        $user_id = $request->input('user_id');
        $user = User::find($user_id);
        if($user){
            $user->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'User deleted successfully'
            ]);
        }
        else{
            return response()->json([
                'status' => 'error',
                'message' => 'User not found'
            ]);
        }
    }

    public function bookDetails(){
        $userlist = Session::get('adminusers');
        if($userlist){
            return view('admin.bookDetails', compact('userlist'));
        }
        else{
            return redirect()->route('admin.adminlogin')->with('error', 'Please log in to continue.');
        }
    }

    
    public function book_details(){
        $transactions = Transactions::with([
            'book:id,title,author',
            'user:id,name'
        ])->get();
        return response()->json([
            'status' => 'success',
            'data' => $transactions
        ]);
    }
}
