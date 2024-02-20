<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function rack()
    {
        return $this->belongsTo(Rack::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function loan()
    {
        return $this->hasMany(Loan::class);
    }

    public function cart()
    {
        return $this->hasMany(Cart::class);
    }

    public function loans()
    {
        return $this->belongsToMany(Loan::class, 'book_loan');
    }
}
