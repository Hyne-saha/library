<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transactions extends Model
{
    //
    use HasFactory;

    protected $table = 'transactions';

    protected $fillable = [
        'book_id',
        'user_id',
        'borrwed_at',
        'due_date',
        'returned_at',
        'created_at',
        'updated_at',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id');
    }
}
