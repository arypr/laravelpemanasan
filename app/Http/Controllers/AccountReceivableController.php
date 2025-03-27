<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AccountReceivable;
use Illuminate\Http\JsonResponse;

class AccountReceivableController extends Controller
{
    /**
     * Get list of receivables with pagination.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $page = $request->query('page', 1);
        $pageSize = $request->query('pageSize', 10);

        // Mengambil data dengan paginasi
        $receivables = AccountReceivable::paginate($pageSize, ['*'], 'page', $page);

        // Mengubah data ke format yang sesuai
        $data = $receivables->map(function ($receivable) {
            return [
                'serial' => $receivable->receivable_id, // sesuai dengan kolom receivable_id
                'transactionId' => $receivable->transaction_id,
                'totalAmount' => $receivable->total_amount,
                'totalOutstandingAmount' => $receivable->total_outstanding_amount,
                'status' => $receivable->status,
                'repaymentDueDate' => $receivable->repayment_due_date->toIso8601String(),
                'createdAt' => $receivable->created_at->toIso8601String(),
                'updatedAt' => $receivable->updated_at->toIso8601String(),
                'createdBy' => $receivable->created_by,
                'updatedBy' => $receivable->updated_by,
            ];
        });

        return response()->json([
            'data' => [
                'receivables' => $data,
            ],
            'page' => $receivables->currentPage(),
            'pageSize' => $receivables->perPage(),
            'status' => 200,
            'message' => 'success'
        ]);
    }

    /**
     * Store a new receivable record.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'serial' => 'required|string|unique:account_receivables,serial',
            'transactionId' => 'required|string',
            'totalAmount' => 'required|numeric',
            'totalOutstandingAmount' => 'required|numeric',
            'status' => 'required|string',
            'repaymentDueDate' => 'required|date',
            'createdBy' => 'required|string',
        ]);

        $receivable = AccountReceivable::create(array_merge($validated, [
            'updatedBy' => $validated['createdBy'],  // Menambahkan updatedBy yang diambil dari createdBy
        ]));

        return response()->json([
            'data' => $receivable,
            'status' => 201,
            'message' => 'Receivable created successfully'
        ], 201);
    }

    /**
     * Update an existing receivable.
     *
     * @param  Request  $request
     * @param  AccountReceivable  $accountReceivable
     * @return JsonResponse
     */
    public function update(Request $request, AccountReceivable $accountReceivable): JsonResponse
    {
        $validated = $request->validate([
            'totalOutstandingAmount' => 'sometimes|numeric',
            'status' => 'sometimes|string',
            'updatedBy' => 'required|string',
        ]);

        // Mengupdate data account receivable
        $accountReceivable->update($validated);

        return response()->json([
            'data' => $accountReceivable,
            'status' => 200,
            'message' => 'Receivable updated successfully'
        ]);
    }
}
