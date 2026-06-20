<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Service;
use App\Models\Transaction;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = Invoice::forUser(auth()->id())->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $query->search($request->search);
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $invoices = $query->paginate(15)->withQueryString();

        $userId = auth()->id();
        $stats = [
            'total' => Invoice::forUser($userId)->count(),
            'paid' => Invoice::forUser($userId)->where('status', 'paid')->count(),
            'pending' => Invoice::forUser($userId)->whereIn('status', ['draft', 'sent'])->count(),
            'overdue' => Invoice::forUser($userId)->where('status', 'overdue')->count(),
            'totalAmount' => Invoice::forUser($userId)->where('status', 'paid')->sum('total'),
            'pendingAmount' => Invoice::forUser($userId)->whereIn('status', ['draft', 'sent', 'overdue'])->sum('total'),
        ];

        $products = Product::forUser(auth()->id())->where('status', 'active')->orderBy('name')->get();
        $services = Service::forUser(auth()->id())->where('status', 'active')->orderBy('name')->get();

        if ($request->ajax()) {
            return view('user.invoices._table', compact('invoices'))->render();
        }

        return view('user.invoices.index', compact('invoices', 'stats', 'products', 'services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'nullable|email|max:255',
            'customer_phone' => 'nullable|string|max:50',
            'issue_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:issue_date',
            'items' => 'required|array|min:1',
            'items.*.type' => 'required|in:product,service',
            'items.*.id' => 'required|integer',
            'items.*.name' => 'required|string',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.qty' => 'required|numeric|min:1',
            'subtotal' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
            'status' => 'required|in:draft,sent',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['invoice_number'] = 'INV-' . strtoupper(uniqid());
        $validated['items'] = $request->input('items');

        Invoice::create($validated);

        return redirect()->route('user.invoices')->with('success', 'Invoice created successfully.');
    }

    public function update(Request $request, Invoice $invoice)
    {
        if ($invoice->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'nullable|email|max:255',
            'customer_phone' => 'nullable|string|max:50',
            'issue_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:issue_date',
            'items' => 'required|array|min:1',
            'items.*.type' => 'required|in:product,service',
            'items.*.id' => 'required|integer',
            'items.*.name' => 'required|string',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.qty' => 'required|numeric|min:1',
            'subtotal' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
            'status' => 'required|in:draft,sent,paid,overdue,cancelled',
        ]);

        $validated['items'] = $request->input('items');
        $invoice->update($validated);

        return redirect()->route('user.invoices')->with('success', 'Invoice updated successfully.');
    }

    public function destroy(Invoice $invoice)
    {
        if ($invoice->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }
        $invoice->delete();
        return redirect()->route('user.invoices')->with('success', 'Invoice deleted successfully.');
    }

    public function pay(Request $request, Invoice $invoice)
    {
        if ($invoice->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        if ($invoice->status === 'paid') {
            return redirect()->route('user.invoices')->with('error', 'Invoice is already paid.');
        }

        $user = auth()->user();

        // Create a transaction/sale record
        $transaction = Transaction::create([
            'user_id' => $user->id,
            'tx_id' => $invoice->invoice_number,
            'customer_name' => $invoice->customer_name,
            'customer_email' => $invoice->customer_email,
            'customer_phone' => $invoice->customer_phone,
            'amount' => $invoice->total,
            'discount' => $invoice->discount,
            'tax' => $invoice->tax,
            'currency' => $user->currency ?? 'TZS',
            'method' => strtoupper($request->input('method', 'CASH')),
            'status' => 'success',
            'processed_at' => now(),
            'source_type' => 'other',
            'items' => $invoice->items,
        ]);

        // Update invoice
        $invoice->update([
            'status' => 'paid',
            'payment_method' => $request->input('method', 'cash'),
            'paid_at' => now(),
            'transaction_id' => $transaction->id,
        ]);

        // Reduce stock for product items
        foreach ($invoice->items ?? [] as $item) {
            if (($item['type'] ?? '') === 'product') {
                $product = Product::where('id', $item['id'])->where('user_id', $user->id)->first();
                if ($product) {
                    $product->stock = max(0, $product->stock - ($item['qty'] ?? 1));
                    $product->save();
                }
            }
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Invoice paid successfully.', 'tx_id' => $transaction->tx_id]);
        }

        return redirect()->route('user.invoices')->with('success', 'Invoice paid successfully and recorded in sales.');
    }
}
