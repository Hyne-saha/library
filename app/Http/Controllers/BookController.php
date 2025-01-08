<?php

namespace App\Http\Controllers;
use App\Models\Book;
use App\Models\Transactions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class BookController extends Controller
{
    //

    public function books(Request $request){
        $userlist = Session::get('users');
        if($userlist){
            return view('user.books', compact('userlist'));
        }
        else{
            return redirect()->route('auth.login')->with('error', 'Please log in to continue.');
        }
    }

    public function getBooks(Request $request){
        $userId = $request->input('userId');
        // $books = Book::with('transactions')
        // ->whereHas('transactions', function($query) use ($userId) {
        //     $query->where('user_id', $userId);
        // });

        // dd($books->toSql());
        // $books = Book::select('books.*')->addSelect([
        //     'borrowed_at' => Transactions::select('borrwed_at')
        //     ->whereColumn('transactions.book_id', 'books.id')
        //     ->latest()
        //     ->limit(1)
        // ])->get();

        $books = Book::with(['transactions' => function ($query) {
            // Get only the latest transaction for each book
            $query->latest()->limit(1);
        }])->get();
        // $books = Book::with(['transactions' => function ($query) use ($userId) {
        //     $query->where('user_id', $userId)
        //           ->orderBy('id', 'desc') // Fetch latest transactions
        //           ->limit(1); // Limit to the most recent transaction
        // }])->whereHas('transactions', function ($query) use ($userId) {
        //     $query->where('user_id', $userId);
        // })->get();

        // $books = Book::all();
    

        return response()->json([
            'status' => 'success',
            'data' => $books
        ]);
    }

    public function borrowBook(Request $request){
        $book_id = $request->input('book_id');
        $user_id = $request->input('user_id');
        $borrowed_at = date('Y-m-d');
        $due_date = date('Y-m-d' , strtotime('+7 days'));

        $transaction = Transactions::create([
            'book_id' => $book_id,
            'user_id' => $user_id,
            'borrwed_at' => $borrowed_at,
            'due_date' => $due_date,
            'status' => 'borrowed'



        ]);

        if($transaction){
            return response()->json([
                'status' => 'success',
                'message' => 'Book borrowed successfully'
            ]);
        }
    }

    public function returnBook(Request $request){
        $book_id = $request->input('book_id');
        $user_id = $request->input('user_id');
        $returned_at = $request->input('return_date');
        $fine = $request->input('fine');
        $transaction_id = $request->input('transaction_id');
        $transaction = Transactions::find($transaction_id);
        if($fine > 0){
            $fine_status = 'unpaid';
        }
        else{
            $fine_status = 'paid';
        }
        if($transaction){
            $transaction->fine = $fine;
            $transaction->returned_at = $returned_at;
            $transaction->status = 'returned';
            $transaction->fine_status = $fine_status;
            $transaction->save();
        }
        else{
            return response()->json([
                'status' => 'error',
                'message' => 'Transaction not found'
            ]);
        }
    }

}
