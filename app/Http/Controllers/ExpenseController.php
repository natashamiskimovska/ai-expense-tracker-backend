<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\AIService;

class ExpenseController extends Controller
{
    public function index(): JsonResponse
    {
        $expenses = Auth::user()->expenses()->with('category')->get();

        return response()->json([
            'status' => 'success',
            'data' => $expenses
        ], 200);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'notes' => 'nullable|string',
        ]);

        $expense = Auth::user()->expenses()->create($request->only('title', 'amount', 'category_id', 'notes'));

        return response()->json([
            'status' => 'success',
            'message' => 'Expense created successfully',
            'data' => $expense
        ], 201);
    }

    public function show(Expense $expense): JsonResponse
    {
        $this->authorize('view', $expense);

        return response()->json([
            'status' => 'success',
            'data' => $expense->load('category')
        ], 200);
    }

    public function update(Request $request, Expense $expense): JsonResponse
    {
        $this->authorize('update', $expense);

        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'category_id' => 'nullable|exists:categories,id',
            'notes' => 'nullable|string',
        ]);

        $expense->update($request->only(['title', 'amount', 'category_id', 'notes']));

        return response()->json([
            'status' => 'success',
            'message' => 'Expense updated successfully',
            'data' => $expense
        ], 200);
    }

    public function destroy(Expense $expense)
    {
        $this->authorize('delete', $expense);
        $expense->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Expense deleted successfully'
        ], 200);
    }

    public function analyzeExpenses(AIService $aiService): JsonResponse
    {
        $expenses = Auth::user()->expenses()->with('category')->get()->toArray();

        $analysis = $aiService->analyzeExpenses($expenses);

        return response()->json([
            'status' => 'success',
            'data' => $analysis
        ], 200, [], JSON_PRETTY_PRINT);
    }
}
