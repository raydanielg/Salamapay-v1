class TransactionModel {
  final int id;
  final String txId;
  final String customerName;
  final double amount;
  final String method;
  final String status;
  final String? sourceType;
  final String? sourceName;
  final DateTime? processedAt;

  TransactionModel({
    required this.id,
    required this.txId,
    required this.customerName,
    required this.amount,
    required this.method,
    required this.status,
    this.sourceType,
    this.sourceName,
    this.processedAt,
  });

  bool get isSuccess => status == 'success';
  bool get isPending => status == 'pending';
  bool get isFailed => status == 'failed';

  factory TransactionModel.fromJson(Map<String, dynamic> json) {
    return TransactionModel(
      id: json['id'] ?? 0,
      txId: json['tx_id'] ?? '#${json['id']}',
      customerName: json['customer_name'] ?? 'Unknown',
      amount: double.tryParse(json['amount']?.toString() ?? '0') ?? 0,
      method: json['payment_method'] ?? json['method'] ?? 'cash',
      status: json['status'] ?? 'pending',
      sourceType: json['source_type'],
      sourceName: json['source_name'],
      processedAt: json['processed_at'] != null
          ? DateTime.tryParse(json['processed_at'])
          : null,
    );
  }
}
