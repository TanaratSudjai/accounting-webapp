<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\transactions;
class categories extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type' // ถ้ามีชื่อ category
        // สามารถเพิ่มคอลัมน์อื่น ๆ ได้ที่นี่
    ];

    // ความสัมพันธ์กับ transactions
    public function transactions()
    {
        return $this->hasMany(transactions::class); // โมเดล Transaction
    }


}
