<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceApiController extends Controller
{
    private function format(Invoice $inv): array
    {
        return [
            'id'             => $inv->id,
            'invoice_number' => $inv->invoice_number,
            'customer_name'  => $inv->customer_name,
            'customer_email' => $inv->customer_email,
            'amount'         => $inv->amount,
            'status'         => $inv->status,
            'due_date'       => $inv->due_date?->toDateString(),
            'created_at'     => $inv->created_at?->toIso8601String(),
            'items'          => $inv->items ?? [],
        ];
    }

    public function index(Request $request)
    {
        $invoices = Invoice::where('user_id', $request->user()->id)
            ->latest()
            ->get()
            ->map(fn($i) => $this->format($i));

        return response()->json(['data' => $invoices]);
    }

    public function show(Request $request, Invoice $invoice)
    {
        if ($invoice->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Hauna ruhusa.'], 403);
        }

        return response()->json(['data' => $this->format($invoice)]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name'  => 'required|string|max:255',
            'customer_email' => 'nullable|email',
            'amount'         => 'required|numeric|min:0',
            'notes'          => 'nullable|string',
            'due_date'       => 'nullable|date',
        ]);

        $invoice = Invoice::create([
            'user_id'        => $request->user()->id,
            'customer_name'  => $validated['customer_name'],
            'customer_email' => $validated['customer_email'] ?? null,
            'amount'         => $validated['amount'],
            'notes'          => $validated['notes'] ?? null,
            'due_date'       => $validated['due_date'] ?? null,
            'status'         => 'unpaid',
            'invoice_number' => 'INV-' . strtoupper(uniqid()),
        ]);

        return response()->json(['data' => $this->format($invoice)], 201);
    }

    public function update(Request $request, Invoice $invoice)
    {
        if ($invoice->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Hauna ruhusa.'], 403);
        }

        $validated = $request->validate([
            'customer_name'  => 'sometimes|string|max:255',
            'customer_email' => 'nullable|email',
            'amount'         => 'sometimes|numeric|min:0',
            'due_date'       => 'nullable|date',
        ]);

        $invoice->update($validated);

        return response()->json(['data' => $this->format($invoice)]);
    }

    public function pay(Request $request, Invoice $invoice)
    {
        if ($invoice->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Hauna ruhusa.'], 403);
        }

        if ($invoice->status === 'paid') {
            return response()->json(['message' => 'Ankara hii imelipwa tayari.'], 422);
        }

        $invoice->update(['status' => 'paid', 'paid_at' => now()]);

        return response()->json(['data' => $this->format($invoice)]);
    }

    public function destroy(Request $request, Invoice $invoice)
    {
        if ($invoice->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Hauna ruhusa.'], 403);
        }

        $invoice->delete();

        return response()->json(['message' => 'Ankara imefutwa.']);
    }
}
