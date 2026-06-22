import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:intl/intl.dart';
import '../../config/api_config.dart';
import '../../models/invoice.dart';
import '../../services/api_service.dart';
import '../../theme/app_theme.dart';

class InvoicesScreen extends StatefulWidget {
  const InvoicesScreen({super.key});

  @override
  State<InvoicesScreen> createState() => _InvoicesScreenState();
}

class _InvoicesScreenState extends State<InvoicesScreen> {
  bool _loading = true;
  List<InvoiceModel> _invoices = [];
  String? _error;
  String _filter = 'all';

  final _fmt = NumberFormat('#,##0', 'en_US');

  @override
  void initState() {
    super.initState();
    _load();
  }

  Future<void> _load() async {
    setState(() {
      _loading = true;
      _error = null;
    });
    try {
      final data = await ApiService.get(ApiConfig.invoices);
      final list = (data['data'] ?? data as List? ?? []) as List;
      setState(() {
        _invoices = list
            .map((e) => InvoiceModel.fromJson(e as Map<String, dynamic>))
            .toList();
        _loading = false;
      });
    } on ApiException catch (e) {
      setState(() {
        _error = e.message;
        _loading = false;
      });
    }
  }

  List<InvoiceModel> get _filtered {
    if (_filter == 'paid') return _invoices.where((i) => i.isPaid).toList();
    if (_filter == 'unpaid') return _invoices.where((i) => !i.isPaid && !i.isOverdue).toList();
    if (_filter == 'overdue') return _invoices.where((i) => i.isOverdue).toList();
    return _invoices;
  }

  double get _totalUnpaid => _invoices
      .where((i) => !i.isPaid)
      .fold(0, (s, i) => s + i.amount);

  Future<void> _payInvoice(InvoiceModel inv) async {
    final confirm = await showDialog<bool>(
      context: context,
      builder: (_) => AlertDialog(
        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(20)),
        title: Text('Lipa Ankara', style: GoogleFonts.nunito(fontWeight: FontWeight.w900)),
        content: Column(
          mainAxisSize: MainAxisSize.min,
          children: [
            Text('${inv.invoiceNumber}', style: GoogleFonts.nunito(fontSize: 12, color: AppColors.grey400)),
            const SizedBox(height: 8),
            Text('TSh ${_fmt.format(inv.amount)}',
                style: GoogleFonts.nunito(fontSize: 24, fontWeight: FontWeight.w900, color: AppColors.emeraldPrimary)),
            const SizedBox(height: 8),
            Text('Lipa kwa ${inv.customerName}?', style: GoogleFonts.nunito(fontSize: 13)),
          ],
        ),
        actions: [
          TextButton(
            onPressed: () => Navigator.pop(context, false),
            child: Text('Ghairi', style: GoogleFonts.nunito(color: AppColors.grey400)),
          ),
          ElevatedButton(
            onPressed: () => Navigator.pop(context, true),
            style: ElevatedButton.styleFrom(backgroundColor: AppColors.emeraldPrimary),
            child: Text('Lipa', style: GoogleFonts.nunito(color: Colors.white, fontWeight: FontWeight.w800)),
          ),
        ],
      ),
    );
    if (confirm != true) return;
    try {
      await ApiService.post(ApiConfig.invoicePay(inv.id), {});
      _load();
      if (mounted) {
        ScaffoldMessenger.of(context).showSnackBar(SnackBar(
          content: Text('Ankara imelipwa!', style: GoogleFonts.nunito(fontWeight: FontWeight.w700)),
          backgroundColor: AppColors.emeraldPrimary,
          behavior: SnackBarBehavior.floating,
          shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10)),
        ));
      }
    } on ApiException catch (e) {
      if (mounted) {
        ScaffoldMessenger.of(context).showSnackBar(SnackBar(
          content: Text(e.message),
          backgroundColor: Colors.red,
          behavior: SnackBarBehavior.floating,
        ));
      }
    }
  }

  void _showCreateSheet() {
    final nameCtrl = TextEditingController();
    final emailCtrl = TextEditingController();
    final amountCtrl = TextEditingController();
    final notesCtrl = TextEditingController();
    bool loading = false;

    showModalBottomSheet(
      context: context,
      isScrollControlled: true,
      backgroundColor: Colors.transparent,
      builder: (_) => StatefulBuilder(
        builder: (ctx, setS) => Container(
          decoration: const BoxDecoration(
            color: AppColors.white,
            borderRadius: BorderRadius.vertical(top: Radius.circular(28)),
          ),
          padding: EdgeInsets.fromLTRB(
              24, 20, 24, MediaQuery.of(ctx).viewInsets.bottom + 24),
          child: SingleChildScrollView(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              mainAxisSize: MainAxisSize.min,
              children: [
                // Handle bar
                Center(
                  child: Container(
                    width: 40,
                    height: 4,
                    decoration: BoxDecoration(
                      color: AppColors.grey400.withOpacity(0.3),
                      borderRadius: BorderRadius.circular(2),
                    ),
                  ),
                ),
                const SizedBox(height: 20),
                Text('Unda Ankara Mpya',
                    style: GoogleFonts.nunito(
                        fontSize: 18, fontWeight: FontWeight.w900, color: AppColors.emeraldDark)),
                const SizedBox(height: 20),
                _SheetField(ctrl: nameCtrl, label: 'Jina la Mteja', hint: 'John Doe', icon: Icons.person_outline),
                const SizedBox(height: 14),
                _SheetField(ctrl: emailCtrl, label: 'Barua Pepe', hint: 'email@mteja.com', icon: Icons.email_outlined, keyboard: TextInputType.emailAddress),
                const SizedBox(height: 14),
                _SheetField(ctrl: amountCtrl, label: 'Kiasi (TSh)', hint: '50000', icon: Icons.payments_outlined, keyboard: TextInputType.number),
                const SizedBox(height: 14),
                _SheetField(ctrl: notesCtrl, label: 'Maelezo', hint: 'Huduma au bidhaa...', icon: Icons.notes_rounded, maxLines: 3),
                const SizedBox(height: 24),
                SizedBox(
                  width: double.infinity,
                  height: 52,
                  child: ElevatedButton(
                    onPressed: loading ? null : () async {
                      if (nameCtrl.text.isEmpty || amountCtrl.text.isEmpty) return;
                      setS(() => loading = true);
                      try {
                        await ApiService.post(ApiConfig.invoices, {
                          'customer_name': nameCtrl.text.trim(),
                          'customer_email': emailCtrl.text.trim(),
                          'amount': amountCtrl.text.trim(),
                          'notes': notesCtrl.text.trim(),
                        });
                        Navigator.pop(ctx);
                        _load();
                      } on ApiException catch (e) {
                        setS(() => loading = false);
                        ScaffoldMessenger.of(ctx).showSnackBar(SnackBar(content: Text(e.message), backgroundColor: Colors.red));
                      }
                    },
                    style: ElevatedButton.styleFrom(
                      backgroundColor: AppColors.emeraldPrimary,
                      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(14)),
                    ),
                    child: loading
                        ? const SizedBox(width: 20, height: 20, child: CircularProgressIndicator(color: Colors.white, strokeWidth: 2))
                        : Text('Tengeneza Ankara', style: GoogleFonts.nunito(color: Colors.white, fontWeight: FontWeight.w800, fontSize: 14)),
                  ),
                ),
              ],
            ),
          ),
        ),
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: AppColors.grey100,
      body: NestedScrollView(
        headerSliverBuilder: (_, __) => [
          SliverAppBar(
            expandedHeight: 140,
            pinned: true,
            backgroundColor: const Color(0xFF1a237e),
            systemOverlayStyle: const SystemUiOverlayStyle(
              statusBarColor: Colors.transparent,
              statusBarIconBrightness: Brightness.light,
            ),
            flexibleSpace: FlexibleSpaceBar(
              background: Container(
                decoration: const BoxDecoration(
                  gradient: LinearGradient(
                    begin: Alignment.topLeft,
                    end: Alignment.bottomRight,
                    colors: [Color(0xFF283593), Color(0xFF1a237e)],
                  ),
                ),
                child: SafeArea(
                  child: Padding(
                    padding: const EdgeInsets.fromLTRB(20, 16, 20, 0),
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Row(
                          children: [
                            Text('Ankara', style: GoogleFonts.nunito(color: Colors.white, fontSize: 22, fontWeight: FontWeight.w900)),
                            const Spacer(),
                            Container(
                              padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 5),
                              decoration: BoxDecoration(color: const Color(0xFFFFD54F), borderRadius: BorderRadius.circular(10)),
                              child: Text('${_invoices.length}', style: GoogleFonts.nunito(color: const Color(0xFF1a237e), fontSize: 12, fontWeight: FontWeight.w900)),
                            ),
                          ],
                        ),
                        const SizedBox(height: 6),
                        Text('TSh ${_fmt.format(_totalUnpaid)}',
                            style: GoogleFonts.nunito(color: Colors.white, fontSize: 22, fontWeight: FontWeight.w900)),
                        Text('Hazijalipwa', style: GoogleFonts.nunito(color: Colors.white.withOpacity(0.65), fontSize: 11, fontWeight: FontWeight.w600)),
                      ],
                    ),
                  ),
                ),
              ),
            ),
            bottom: PreferredSize(
              preferredSize: const Size.fromHeight(50),
              child: Container(
                color: const Color(0xFF1a237e),
                padding: const EdgeInsets.fromLTRB(16, 0, 16, 10),
                child: SingleChildScrollView(
                  scrollDirection: Axis.horizontal,
                  child: Row(
                    children: [
                      _FilterChip(label: 'Zote', value: 'all', current: _filter, onTap: (v) => setState(() => _filter = v)),
                      _FilterChip(label: 'Zimelipwa', value: 'paid', current: _filter, onTap: (v) => setState(() => _filter = v)),
                      _FilterChip(label: 'Hazijalipwa', value: 'unpaid', current: _filter, onTap: (v) => setState(() => _filter = v)),
                      _FilterChip(label: 'Zimechelewa', value: 'overdue', current: _filter, onTap: (v) => setState(() => _filter = v)),
                    ],
                  ),
                ),
              ),
            ),
          ),
        ],
        body: _loading
            ? const Center(child: CircularProgressIndicator(color: Color(0xFF283593)))
            : _error != null
                ? Center(child: Text(_error!, style: GoogleFonts.nunito(color: AppColors.grey400)))
                : _filtered.isEmpty
                    ? Center(
                        child: Column(
                          mainAxisAlignment: MainAxisAlignment.center,
                          children: [
                            Icon(Icons.description_outlined, size: 56, color: AppColors.grey400.withOpacity(0.5)),
                            const SizedBox(height: 12),
                            Text('Hakuna ankara', style: GoogleFonts.nunito(color: AppColors.grey400, fontWeight: FontWeight.w700)),
                          ],
                        ),
                      )
                    : RefreshIndicator(
                        color: const Color(0xFF283593),
                        onRefresh: _load,
                        child: ListView.builder(
                          padding: const EdgeInsets.all(16),
                          itemCount: _filtered.length,
                          itemBuilder: (_, i) => _InvoiceTile(
                            invoice: _filtered[i],
                            onPay: () => _payInvoice(_filtered[i]),
                          ),
                        ),
                      ),
      ),
      floatingActionButton: FloatingActionButton.extended(
        onPressed: _showCreateSheet,
        backgroundColor: const Color(0xFF283593),
        icon: const Icon(Icons.add_rounded, color: Colors.white),
        label: Text('Ankara Mpya', style: GoogleFonts.nunito(color: Colors.white, fontWeight: FontWeight.w800)),
      ),
    );
  }
}

class _FilterChip extends StatelessWidget {
  final String label;
  final String value;
  final String current;
  final ValueChanged<String> onTap;

  const _FilterChip({required this.label, required this.value, required this.current, required this.onTap});

  @override
  Widget build(BuildContext context) {
    final active = value == current;
    return GestureDetector(
      onTap: () => onTap(value),
      child: AnimatedContainer(
        duration: const Duration(milliseconds: 200),
        margin: const EdgeInsets.only(right: 8),
        padding: const EdgeInsets.symmetric(horizontal: 14, vertical: 6),
        decoration: BoxDecoration(
          color: active ? const Color(0xFFFFD54F) : Colors.white.withOpacity(0.15),
          borderRadius: BorderRadius.circular(20),
        ),
        child: Text(
          label,
          style: GoogleFonts.nunito(
            color: active ? const Color(0xFF1a237e) : Colors.white.withOpacity(0.8),
            fontSize: 12,
            fontWeight: FontWeight.w700,
          ),
        ),
      ),
    );
  }
}

class _InvoiceTile extends StatelessWidget {
  final InvoiceModel invoice;
  final VoidCallback onPay;

  const _InvoiceTile({required this.invoice, required this.onPay});

  @override
  Widget build(BuildContext context) {
    Color statusColor;
    Color statusBg;
    String statusLabel;

    if (invoice.isPaid) {
      statusColor = AppColors.emeraldPrimary;
      statusBg = const Color(0xFFE6F5F1);
      statusLabel = 'Imelipwa';
    } else if (invoice.isOverdue) {
      statusColor = Colors.red;
      statusBg = const Color(0xFFFFEBEE);
      statusLabel = 'Imechelewa';
    } else {
      statusColor = AppColors.gold;
      statusBg = const Color(0xFFFFF8E1);
      statusLabel = 'Haijalipi';
    }

    return Container(
      margin: const EdgeInsets.only(bottom: 12),
      decoration: BoxDecoration(
        color: AppColors.white,
        borderRadius: BorderRadius.circular(16),
        boxShadow: [BoxShadow(color: Colors.black.withOpacity(0.04), blurRadius: 8, offset: const Offset(0, 2))],
      ),
      child: Padding(
        padding: const EdgeInsets.all(16),
        child: Column(
          children: [
            Row(
              children: [
                Container(
                  width: 44,
                  height: 44,
                  decoration: BoxDecoration(
                    color: const Color(0xFFEEF2FF),
                    borderRadius: BorderRadius.circular(12),
                  ),
                  child: Center(
                    child: Text(
                      invoice.customerName.isNotEmpty ? invoice.customerName[0].toUpperCase() : '?',
                      style: GoogleFonts.nunito(color: const Color(0xFF4F46E5), fontWeight: FontWeight.w900, fontSize: 18),
                    ),
                  ),
                ),
                const SizedBox(width: 12),
                Expanded(
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Text(invoice.customerName,
                          style: GoogleFonts.nunito(fontSize: 13, fontWeight: FontWeight.w800, color: AppColors.emeraldDark)),
                      Text(invoice.invoiceNumber,
                          style: GoogleFonts.nunito(fontSize: 10, color: AppColors.grey400, fontWeight: FontWeight.w600)),
                    ],
                  ),
                ),
                Column(
                  crossAxisAlignment: CrossAxisAlignment.end,
                  children: [
                    Text(
                      'TSh ${NumberFormat('#,##0').format(invoice.amount)}',
                      style: GoogleFonts.nunito(fontSize: 14, fontWeight: FontWeight.w900, color: AppColors.emeraldDark),
                    ),
                    const SizedBox(height: 4),
                    Container(
                      padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 2),
                      decoration: BoxDecoration(color: statusBg, borderRadius: BorderRadius.circular(6)),
                      child: Text(statusLabel,
                          style: GoogleFonts.nunito(fontSize: 9, fontWeight: FontWeight.w800, color: statusColor)),
                    ),
                  ],
                ),
              ],
            ),
            if (!invoice.isPaid) ...[
              const SizedBox(height: 12),
              Divider(color: AppColors.grey400.withOpacity(0.15), height: 1),
              const SizedBox(height: 10),
              Row(
                children: [
                  if (invoice.dueDate != null)
                    Text(
                      'Muda: ${DateFormat('MMM d, y').format(invoice.dueDate!)}',
                      style: GoogleFonts.nunito(fontSize: 10, color: invoice.isOverdue ? Colors.red : AppColors.grey400, fontWeight: FontWeight.w600),
                    ),
                  const Spacer(),
                  GestureDetector(
                    onTap: onPay,
                    child: Container(
                      padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 7),
                      decoration: BoxDecoration(
                        gradient: const LinearGradient(colors: [AppColors.emeraldMedium, AppColors.emeraldDark]),
                        borderRadius: BorderRadius.circular(10),
                      ),
                      child: Text('Lipa Sasa', style: GoogleFonts.nunito(color: Colors.white, fontSize: 11, fontWeight: FontWeight.w800)),
                    ),
                  ),
                ],
              ),
            ],
          ],
        ),
      ),
    );
  }
}

class _SheetField extends StatelessWidget {
  final TextEditingController ctrl;
  final String label;
  final String hint;
  final IconData icon;
  final TextInputType keyboard;
  final int maxLines;

  const _SheetField({
    required this.ctrl,
    required this.label,
    required this.hint,
    required this.icon,
    this.keyboard = TextInputType.text,
    this.maxLines = 1,
  });

  @override
  Widget build(BuildContext context) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Text(label,
            style: GoogleFonts.nunito(fontSize: 12, fontWeight: FontWeight.w700, color: AppColors.grey700)),
        const SizedBox(height: 6),
        TextField(
          controller: ctrl,
          keyboardType: keyboard,
          maxLines: maxLines,
          style: GoogleFonts.nunito(fontSize: 13, fontWeight: FontWeight.w600),
          decoration: InputDecoration(
            hintText: hint,
            hintStyle: GoogleFonts.nunito(color: AppColors.grey400, fontSize: 13),
            prefixIcon: Icon(icon, size: 18, color: AppColors.grey400),
            filled: true,
            fillColor: AppColors.grey100,
            contentPadding: const EdgeInsets.symmetric(horizontal: 14, vertical: 12),
            border: OutlineInputBorder(borderRadius: BorderRadius.circular(12), borderSide: BorderSide.none),
            focusedBorder: OutlineInputBorder(
              borderRadius: BorderRadius.circular(12),
              borderSide: const BorderSide(color: AppColors.emeraldPrimary, width: 1.5),
            ),
          ),
        ),
      ],
    );
  }
}
