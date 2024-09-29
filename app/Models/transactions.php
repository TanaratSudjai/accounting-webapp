<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\categories;
class transactions extends Model
{
    use HasFactory;

    protected $table = 'transactions';

    protected $fillable = [
        'user_id',
        'category_id',
        'amount',
        'description',
        'transaction_date',
    ];

    public function category()
    {
        return $this->belongsTo(categories::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
