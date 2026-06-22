class InvoiceModel {
  final int id;
  final String invoiceNumber;
  final String customerName;
  final String? customerEmail;
  final double amount;
  final String status;
  final DateTime? dueDate;
  final DateTime? createdAt;
  final List<Map<String, dynamic>> items;

  InvoiceModel({
    required this.id,
    required this.invoiceNumber,
    required this.customerName,
    this.customerEmail,
    required this.amount,
    required this.status,
    this.dueDate,
    this.createdAt,
    this.items = const [],
  });

  bool get isPaid => status == 'paid';
  bool get isOverdue =>
      dueDate != null && dueDate!.isBefore(DateTime.now()) && !isPaid;

  factory InvoiceModel.fromJson(Map<String, dynamic> json) {
    return InvoiceModel(
      id: json['id'] ?? 0,
      invoiceNumber: json['invoice_number'] ?? 'INV-${json['id']}',
      customerName: json['customer_name'] ?? 'Unknown',
      customerEmail: json['customer_email'],
      amount: double.tryParse(json['amount']?.toString() ?? '0') ?? 0,
      status: json['status'] ?? 'unpaid',
      dueDate: json['due_date'] != null
          ? DateTime.tryParse(json['due_date'])
          : null,
      createdAt: json['created_at'] != null
          ? DateTime.tryParse(json['created_at'])
          : null,
      items: json['items'] != null
          ? List<Map<String, dynamic>>.from(json['items'])
          : [],
    );
  }
}
