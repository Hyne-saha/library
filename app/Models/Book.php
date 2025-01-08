<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    //

    use HasFactory;

    protected $table = 'books';

    protected $fillable = [
        'title',
        'author',
        'status',
        'created_at',
        'updated_at',
        'user_id'
    ];

    public function transactions()
    {
        return $this->hasMany(Transactions::class, 'book_id');
        
    }

    public function latestTransactions(){
        return $this->hasOne(Transactions::class, 'book_id')->latest('id');
    }

}
