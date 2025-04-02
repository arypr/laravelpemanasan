<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountReceivable extends Model
{
    use HasFactory;

    // Menentukan nama tabel
    protected $table = 'account_receivables'; 

    // Tentukan kolom yang dapat diisi (fillable)
    protected $fillable = [
        'receivable_id',
        'transaction_id',
        'total_amount',
        'total_outstanding_amount',
        'status',
        'repayment_due_date',
        'created_by',
        'updated_by',
    ];

    // Tentukan kolom yang harus di-cast ke tipe data tertentu, jika diperlukan
    protected $casts = [
        'repayment_due_date' => 'datetime', // Cast ke tipe datetime jika kolom repayment_due_date adalah tanggal
    ];

    // Tentukan timestamp jika tabel menggunakan kolom created_at dan updated_at
    public $timestamps = true; // Tabel ini sepertinya memiliki kolom created_at dan updated_at, biarkan default true
}
