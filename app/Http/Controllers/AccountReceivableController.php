<?php

namespace App\Http\Controllers;

use App\Models\AccountReceivable;
use Illuminate\Http\Request;

class AccountReceivableController extends Controller
{
    // Fungsi untuk membuat hutang (Create Hutang)
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'receivable_id' => 'required',
            'transaction_id' => 'required',
            'total_amount' => 'required|numeric',
            'total_outstanding_amount' => 'required|numeric',
            'status' => 'required|string',
            'repayment_due_date' => 'required|date',
            'created_by' => 'required|string',
        ]);

        // Simpan data baru ke dalam tabel account_receivables
        $accountReceivable = AccountReceivable::create([
            'receivable_id' => $validated['receivable_id'],
            'transaction_id' => $validated['transaction_id'],
            'total_amount' => $validated['total_amount'],
            'total_outstanding_amount' => $validated['total_outstanding_amount'],
            'status' => $validated['status'],
            'repayment_due_date' => $validated['repayment_due_date'],
            'created_by' => $validated['created_by'],
            'updated_by' => $validated['created_by'], // Misalnya, yang mengupdate pertama kali adalah orang yang sama dengan yang membuat
        ]);

        // Format response sesuai dengan format yang diminta
        return response()->json([
            'status' => 201,
            'message' => 'Hutang berhasil dibuat',
            'data' => $accountReceivable,
        ], 201);
    }

    // Fungsi untuk memperbarui hutang (Update Hutang)
    public function update(Request $request, $id)
    {
        // Validasi input
        $validated = $request->validate([
            'total_amount' => 'required|numeric',
            'total_outstanding_amount' => 'required|numeric',
            'status' => 'required|string',
            'repayment_due_date' => 'required|date',
            'updated_by' => 'required|string',
        ]);

        // Cari record hutang berdasarkan ID
        $accountReceivable = AccountReceivable::find($id);

        if (!$accountReceivable) {
            return response()->json([
                'status' => 404,
                'message' => 'Hutang tidak ditemukan'
            ], 404);
        }

        // Update data hutang
        $accountReceivable->update([
            'total_amount' => $validated['total_amount'],
            'total_outstanding_amount' => $validated['total_outstanding_amount'],
            'status' => $validated['status'],
            'repayment_due_date' => $validated['repayment_due_date'],
            'updated_by' => $validated['updated_by'],
        ]);

        // Format response sesuai dengan format yang diminta
        return response()->json([
            'status' => 200,
            'message' => 'Hutang berhasil diperbarui',
            'data' => $accountReceivable,
        ], 200);
    }


    // Fungsi untuk mendapatkan daftar hutang dengan filter dan paginasi
    public function getAccountReceivable(Request $request)
    {
        $query = AccountReceivable::query();

        // Filter berdasarkan transactionIds (dipisah dengan koma)
        if ($request->has('transactionIds')) {
            $transactionIds = explode(',', $request->query('transactionIds'));
            $query->whereIn('transaction_id', $transactionIds);
        }

        // Filter berdasarkan status
        if ($request->has('status')) {
            $query->where('status', $request->query('status'));
        }

        // Ambil nilai page dan pageSize
        $pageSize = $request->query('pageSize', 10); // Default 10 jika tidak ada
        $receivables = $query->paginate($pageSize);

        return response()->json([
            'status' => 200,
            'message' => 'success',
            'data' => [
                'receivables' => $receivables->map(function ($item) {
                    return [
                        'receivable_id' => $item->receivable_id,
                        'transactionId' => $item->transaction_id,
                        'totalAmount' => $item->total_amount,
                        'totalOutstandingAmount' => $item->total_outstanding_amount,
                        'status' => $item->status,
                        'repaymentDueDate' => $item->repayment_due_date,
                        'createdAt' => $item->created_at,
                        'updatedAt' => $item->updated_at,
                        'createdBy' => $item->created_by,
                        'updatedBy' => $item->updated_by,
                    ];
                }),
                'page' => $receivables->currentPage(),
                'pageSize' => $receivables->perPage(),
            ],
        ]);
    }
}
