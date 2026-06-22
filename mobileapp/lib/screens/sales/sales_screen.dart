import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:intl/intl.dart';
import '../../config/api_config.dart';
import '../../models/transaction.dart';
import '../../services/api_service.dart';
import '../../theme/app_theme.dart';
import '../dashboard/dashboard_screen.dart';

class SalesScreen extends StatefulWidget {
  const SalesScreen({super.key});

  @override
  State<SalesScreen> createState() => _SalesScreenState();
}

class _SalesScreenState extends State<SalesScreen>
    with SingleTickerProviderStateMixin {
  bool _loading = true;
  List<TransactionModel> _all = [];
  List<TransactionModel> _filtered = [];
  String? _error;
  String _period = '30';
  String _search = '';
  late TabController _tabCtrl;

  final _fmt = NumberFormat('#,##0', 'en_US');
  final _searchCtrl = TextEditingController();

  final List<_PeriodBtn> _periods = const [
    _PeriodBtn('7', '7 Siku'),
    _PeriodBtn('30', '30 Siku'),
    _PeriodBtn('90', '90 Siku'),
    _PeriodBtn('365', 'Mwaka'),
  ];

  @override
  void initState() {
    super.initState();
    _tabCtrl = TabController(length: 3, vsync: this);
    _tabCtrl.addListener(() => _applyFilter());
    _load();
  }

  @override
  void dispose() {
    _tabCtrl.dispose();
    _searchCtrl.dispose();
    super.dispose();
  }

  Future<void> _load() async {
    setState(() {
      _loading = true;
      _error = null;
    });
    try {
      final data = await ApiService.get(ApiConfig.sales,
          params: {'period': _period});
      final list = (data['data'] ?? data as List? ?? []) as List;
      _all = list
          .map((e) => TransactionModel.fromJson(e as Map<String, dynamic>))
          .toList();
      _applyFilter();
      setState(() => _loading = false);
    } on ApiException catch (e) {
      setState(() {
        _error = e.message;
        _loading = false;
      });
    }
  }

  void _applyFilter() {
    final tab = _tabCtrl.index;
    var list = _all.where((tx) {
      if (_search.isNotEmpty &&
          !tx.customerName.toLowerCase().contains(_search.toLowerCase()) &&
          !tx.txId.toLowerCase().contains(_search.toLowerCase())) {
        return false;
      }
      if (tab == 1) return tx.isSuccess;
      if (tab == 2) return tx.isPending || tx.isFailed;
      return true;
    }).toList();
    setState(() => _filtered = list);
  }

  double get _totalRevenue => _filtered
      .where((t) => t.isSuccess)
      .fold(0, (s, t) => s + t.amount);

  Future<void> _confirmDelete(TransactionModel tx) async {
    final confirm = await showDialog<bool>(
      context: context,
      builder: (_) => AlertDialog(
        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(20)),
        title: Text('Futa Muamala',
            style: GoogleFonts.nunito(fontWeight: FontWeight.w900)),
        content: Text('Una uhakika wa kufuta muamala huu?',
            style: GoogleFonts.nunito(fontSize: 13)),
        actions: [
          TextButton(
            onPressed: () => Navigator.pop(context, false),
            child: Text('Hapana',
                style: GoogleFonts.nunito(color: AppColors.grey400)),
          ),
          ElevatedButton(
            onPressed: () => Navigator.pop(context, true),
            style: ElevatedButton.styleFrom(backgroundColor: Colors.red),
            child: Text('Futa',
                style: GoogleFonts.nunito(color: Colors.white)),
          ),
        ],
      ),
    );
    if (confirm != true) return;
    try {
      await ApiService.delete(ApiConfig.saleDelete(tx.id));
      setState(() {
        _all.removeWhere((t) => t.id == tx.id);
        _applyFilter();
      });
      if (mounted) {
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(
            content: Text('Muamala umefutwa',
                style: GoogleFonts.nunito(fontWeight: FontWeight.w700)),
            backgroundColor: AppColors.emeraldPrimary,
            shape: RoundedRectangleBorder(
                borderRadius: BorderRadius.circular(10)),
            behavior: SnackBarBehavior.floating,
          ),
        );
      }
    } on ApiException catch (e) {
      if (mounted) {
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(
            content: Text(e.message,
                style: GoogleFonts.nunito(fontWeight: FontWeight.w700)),
            backgroundColor: Colors.red,
            behavior: SnackBarBehavior.floating,
          ),
        );
      }
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: AppColors.grey100,
      body: NestedScrollView(
        headerSliverBuilder: (_, __) => [
          SliverAppBar(
            expandedHeight: 160,
            pinned: true,
            backgroundColor: AppColors.emeraldPrimary,
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
                    colors: [AppColors.emeraldMedium, AppColors.emeraldDark],
                  ),
                ),
                child: SafeArea(
                  child: Padding(
                    padding: const EdgeInsets.fromLTRB(20, 12, 20, 0),
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Row(
                          children: [
                            Text(
                              'Mauzo',
                              style: GoogleFonts.nunito(
                                color: Colors.white,
                                fontSize: 22,
                                fontWeight: FontWeight.w900,
                              ),
                            ),
                            const Spacer(),
                            Container(
                              padding: const EdgeInsets.symmetric(
                                  horizontal: 10, vertical: 6),
                              decoration: BoxDecoration(
                                color: AppColors.gold,
                                borderRadius: BorderRadius.circular(10),
                              ),
                              child: Text(
                                '${_filtered.length} Muamala',
                                style: GoogleFonts.nunito(
                                  color: AppColors.emeraldDark,
                                  fontSize: 11,
                                  fontWeight: FontWeight.w800,
                                ),
                              ),
                            ),
                          ],
                        ),
                        const SizedBox(height: 8),
                        Text(
                          'TSh ${_fmt.format(_totalRevenue)}',
                          style: GoogleFonts.nunito(
                            color: Colors.white,
                            fontSize: 24,
                            fontWeight: FontWeight.w900,
                          ),
                        ),
                        Text(
                          'Jumla ya Mauzo Yaliyofanikiwa',
                          style: GoogleFonts.nunito(
                            color: Colors.white.withOpacity(0.65),
                            fontSize: 11,
                            fontWeight: FontWeight.w600,
                          ),
                        ),
                      ],
                    ),
                  ),
                ),
              ),
            ),
            bottom: PreferredSize(
              preferredSize: const Size.fromHeight(48),
              child: Container(
                color: AppColors.emeraldDark,
                child: TabBar(
                  controller: _tabCtrl,
                  indicatorColor: AppColors.gold,
                  indicatorWeight: 3,
                  labelColor: Colors.white,
                  unselectedLabelColor: Colors.white.withOpacity(0.5),
                  labelStyle: GoogleFonts.nunito(
                      fontSize: 12, fontWeight: FontWeight.w800),
                  unselectedLabelStyle: GoogleFonts.nunito(
                      fontSize: 12, fontWeight: FontWeight.w600),
                  tabs: const [
                    Tab(text: 'Zote'),
                    Tab(text: 'Zilizofanikiwa'),
                    Tab(text: 'Nyingine'),
                  ],
                ),
              ),
            ),
          ),
        ],
        body: Column(
          children: [
            // Period filter + search
            Container(
              color: AppColors.white,
              padding:
                  const EdgeInsets.symmetric(horizontal: 16, vertical: 10),
              child: Column(
                children: [
                  // Period buttons
                  SingleChildScrollView(
                    scrollDirection: Axis.horizontal,
                    child: Row(
                      children: _periods.map((p) {
                        final active = _period == p.value;
                        return GestureDetector(
                          onTap: () {
                            setState(() => _period = p.value);
                            _load();
                          },
                          child: AnimatedContainer(
                            duration: const Duration(milliseconds: 200),
                            margin: const EdgeInsets.only(right: 8),
                            padding: const EdgeInsets.symmetric(
                                horizontal: 14, vertical: 6),
                            decoration: BoxDecoration(
                              color: active
                                  ? AppColors.emeraldPrimary
                                  : AppColors.grey100,
                              borderRadius: BorderRadius.circular(20),
                            ),
                            child: Text(
                              p.label,
                              style: GoogleFonts.nunito(
                                color: active
                                    ? Colors.white
                                    : AppColors.grey700,
                                fontSize: 12,
                                fontWeight: FontWeight.w700,
                              ),
                            ),
                          ),
                        );
                      }).toList(),
                    ),
                  ),
                  const SizedBox(height: 10),
                  // Search bar
                  TextField(
                    controller: _searchCtrl,
                    onChanged: (v) {
                      _search = v;
                      _applyFilter();
                    },
                    style: GoogleFonts.nunito(fontSize: 13),
                    decoration: InputDecoration(
                      hintText: 'Tafuta kwa jina au TX ID...',
                      hintStyle: GoogleFonts.nunito(
                          color: AppColors.grey400, fontSize: 13),
                      prefixIcon: const Icon(Icons.search_rounded,
                          color: AppColors.grey400, size: 18),
                      suffixIcon: _search.isNotEmpty
                          ? IconButton(
                              icon: const Icon(Icons.clear_rounded,
                                  size: 16, color: AppColors.grey400),
                              onPressed: () {
                                _searchCtrl.clear();
                                _search = '';
                                _applyFilter();
                              },
                            )
                          : null,
                      filled: true,
                      fillColor: AppColors.grey100,
                      contentPadding:
                          const EdgeInsets.symmetric(vertical: 10),
                      border: OutlineInputBorder(
                        borderRadius: BorderRadius.circular(12),
                        borderSide: BorderSide.none,
                      ),
                    ),
                  ),
                ],
              ),
            ),

            // List
            Expanded(
              child: _loading
                  ? const Center(
                      child: CircularProgressIndicator(
                          color: AppColors.emeraldPrimary))
                  : _error != null
                      ? Center(
                          child: Column(
                            mainAxisAlignment: MainAxisAlignment.center,
                            children: [
                              const Icon(Icons.wifi_off_rounded,
                                  size: 48, color: AppColors.grey400),
                              const SizedBox(height: 12),
                              Text(_error!,
                                  style: GoogleFonts.nunito(
                                      color: AppColors.grey400)),
                              const SizedBox(height: 16),
                              ElevatedButton(
                                onPressed: _load,
                                style: ElevatedButton.styleFrom(
                                    backgroundColor: AppColors.emeraldPrimary),
                                child: Text('Jaribu Tena',
                                    style: GoogleFonts.nunito(
                                        color: Colors.white,
                                        fontWeight: FontWeight.w700)),
                              ),
                            ],
                          ),
                        )
                      : _filtered.isEmpty
                          ? Center(
                              child: Column(
                                mainAxisAlignment: MainAxisAlignment.center,
                                children: [
                                  Icon(Icons.receipt_long_outlined,
                                      size: 56,
                                      color:
                                          AppColors.grey400.withOpacity(0.5)),
                                  const SizedBox(height: 12),
                                  Text('Hakuna miamala',
                                      style: GoogleFonts.nunito(
                                          color: AppColors.grey400,
                                          fontWeight: FontWeight.w700)),
                                ],
                              ),
                            )
                          : RefreshIndicator(
                              color: AppColors.emeraldPrimary,
                              onRefresh: _load,
                              child: ListView.builder(
                                padding: const EdgeInsets.all(16),
                                itemCount: _filtered.length,
                                itemBuilder: (_, i) => _SaleTile(
                                  tx: _filtered[i],
                                  onDelete: () =>
                                      _confirmDelete(_filtered[i]),
                                ),
                              ),
                            ),
            ),
          ],
        ),
      ),
    );
  }
}

class _PeriodBtn {
  final String value;
  final String label;
  const _PeriodBtn(this.value, this.label);
}

class _SaleTile extends StatelessWidget {
  final TransactionModel tx;
  final VoidCallback onDelete;

  const _SaleTile({required this.tx, required this.onDelete});

  @override
  Widget build(BuildContext context) {
    Color statusColor = tx.isSuccess
        ? AppColors.emeraldPrimary
        : tx.isPending
            ? AppColors.gold
            : Colors.red;
    Color statusBg = tx.isSuccess
        ? const Color(0xFFE6F5F1)
        : tx.isPending
            ? const Color(0xFFFFF8E1)
            : const Color(0xFFFFEBEE);

    return Container(
      margin: const EdgeInsets.only(bottom: 10),
      decoration: BoxDecoration(
        color: AppColors.white,
        borderRadius: BorderRadius.circular(14),
        boxShadow: [
          BoxShadow(
              color: Colors.black.withOpacity(0.04),
              blurRadius: 8,
              offset: const Offset(0, 2))
        ],
      ),
      child: InkWell(
        borderRadius: BorderRadius.circular(14),
        onTap: () {},
        child: Padding(
          padding: const EdgeInsets.all(14),
          child: Row(
            children: [
              // Avatar
              Container(
                width: 44,
                height: 44,
                decoration: BoxDecoration(
                  color: AppColors.emeraldPrimary.withOpacity(0.08),
                  borderRadius: BorderRadius.circular(12),
                ),
                child: Center(
                  child: Text(
                    tx.customerName.isNotEmpty
                        ? tx.customerName[0].toUpperCase()
                        : '?',
                    style: GoogleFonts.nunito(
                      color: AppColors.emeraldPrimary,
                      fontWeight: FontWeight.w900,
                      fontSize: 18,
                    ),
                  ),
                ),
              ),
              const SizedBox(width: 12),

              // Info
              Expanded(
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Text(
                      tx.customerName,
                      style: GoogleFonts.nunito(
                        fontSize: 13,
                        fontWeight: FontWeight.w800,
                        color: AppColors.emeraldDark,
                      ),
                    ),
                    const SizedBox(height: 2),
                    Row(
                      children: [
                        Text(
                          tx.txId,
                          style: GoogleFonts.nunito(
                              fontSize: 10,
                              color: AppColors.grey400,
                              fontWeight: FontWeight.w600),
                        ),
                        const SizedBox(width: 6),
                        Text(
                          '• ${tx.method.toUpperCase()}',
                          style: GoogleFonts.nunito(
                              fontSize: 10,
                              color: AppColors.grey400,
                              fontWeight: FontWeight.w600),
                        ),
                      ],
                    ),
                    if (tx.processedAt != null)
                      Text(
                        DateFormat('MMM d, HH:mm').format(tx.processedAt!),
                        style: GoogleFonts.nunito(
                            fontSize: 9,
                            color: AppColors.grey400,
                            fontWeight: FontWeight.w600),
                      ),
                  ],
                ),
              ),

              // Amount + actions
              Column(
                crossAxisAlignment: CrossAxisAlignment.end,
                children: [
                  Text(
                    'TSh ${NumberFormat('#,##0').format(tx.amount)}',
                    style: GoogleFonts.nunito(
                      fontSize: 13,
                      fontWeight: FontWeight.w900,
                      color: AppColors.emeraldDark,
                    ),
                  ),
                  const SizedBox(height: 4),
                  Container(
                    padding: const EdgeInsets.symmetric(
                        horizontal: 8, vertical: 2),
                    decoration: BoxDecoration(
                      color: statusBg,
                      borderRadius: BorderRadius.circular(6),
                    ),
                    child: Text(
                      tx.isSuccess
                          ? 'Imefanikiwa'
                          : tx.isPending
                              ? 'Inasubiri'
                              : 'Imeshindwa',
                      style: GoogleFonts.nunito(
                          fontSize: 9,
                          fontWeight: FontWeight.w800,
                          color: statusColor),
                    ),
                  ),
                  const SizedBox(height: 4),
                  GestureDetector(
                    onTap: onDelete,
                    child: Icon(Icons.delete_outline_rounded,
                        size: 16, color: Colors.red.shade300),
                  ),
                ],
              ),
            ],
          ),
        ),
      ),
    );
  }
}
