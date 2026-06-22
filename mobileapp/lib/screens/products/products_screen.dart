import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:intl/intl.dart';
import '../../config/api_config.dart';
import '../../models/product.dart';
import '../../services/api_service.dart';
import '../../theme/app_theme.dart';

class ProductsScreen extends StatefulWidget {
  const ProductsScreen({super.key});

  @override
  State<ProductsScreen> createState() => _ProductsScreenState();
}

class _ProductsScreenState extends State<ProductsScreen>
    with SingleTickerProviderStateMixin {
  bool _loading = true;
  List<ProductModel> _products = [];
  String? _error;
  String _search = '';
  bool _gridView = true;
  late TabController _tabCtrl;
  final _searchCtrl = TextEditingController();

  @override
  void initState() {
    super.initState();
    _tabCtrl = TabController(length: 2, vsync: this);
    _tabCtrl.addListener(() => setState(() {}));
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
      final data = await ApiService.get(ApiConfig.products);
      final list = (data['data'] ?? data as List? ?? []) as List;
      setState(() {
        _products = list
            .map((e) => ProductModel.fromJson(e as Map<String, dynamic>))
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

  List<ProductModel> get _filtered {
    final isService = _tabCtrl.index == 1;
    return _products.where((p) {
      if (p.isService != isService) return false;
      if (_search.isNotEmpty &&
          !p.name.toLowerCase().contains(_search.toLowerCase())) {
        return false;
      }
      return true;
    }).toList();
  }

  Future<void> _deleteProduct(ProductModel p) async {
    final confirm = await showDialog<bool>(
      context: context,
      builder: (_) => AlertDialog(
        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(20)),
        title: Text('Futa Bidhaa', style: GoogleFonts.nunito(fontWeight: FontWeight.w900)),
        content: Text('Una uhakika wa kufuta "${p.name}"?', style: GoogleFonts.nunito(fontSize: 13)),
        actions: [
          TextButton(onPressed: () => Navigator.pop(context, false), child: Text('Hapana', style: GoogleFonts.nunito(color: AppColors.grey400))),
          ElevatedButton(
            onPressed: () => Navigator.pop(context, true),
            style: ElevatedButton.styleFrom(backgroundColor: Colors.red),
            child: Text('Futa', style: GoogleFonts.nunito(color: Colors.white)),
          ),
        ],
      ),
    );
    if (confirm != true) return;
    try {
      await ApiService.delete(ApiConfig.productDelete(p.id));
      setState(() => _products.removeWhere((x) => x.id == p.id));
      if (mounted) {
        ScaffoldMessenger.of(context).showSnackBar(SnackBar(
          content: Text('Bidhaa imefutwa', style: GoogleFonts.nunito(fontWeight: FontWeight.w700)),
          backgroundColor: AppColors.emeraldPrimary,
          behavior: SnackBarBehavior.floating,
          shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10)),
        ));
      }
    } on ApiException catch (e) {
      if (mounted) {
        ScaffoldMessenger.of(context).showSnackBar(SnackBar(content: Text(e.message), backgroundColor: Colors.red, behavior: SnackBarBehavior.floating));
      }
    }
  }

  void _showAddSheet({ProductModel? existing}) {
    final nameCtrl = TextEditingController(text: existing?.name);
    final priceCtrl = TextEditingController(text: existing?.price.toString());
    final stockCtrl = TextEditingController(text: existing?.stock?.toString());
    final descCtrl = TextEditingController(text: existing?.description);
    bool loading = false;
    bool isService = existing?.isService ?? (_tabCtrl.index == 1);

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
          padding: EdgeInsets.fromLTRB(24, 20, 24, MediaQuery.of(ctx).viewInsets.bottom + 24),
          child: SingleChildScrollView(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              mainAxisSize: MainAxisSize.min,
              children: [
                Center(
                  child: Container(
                    width: 40, height: 4,
                    decoration: BoxDecoration(color: AppColors.grey400.withOpacity(0.3), borderRadius: BorderRadius.circular(2)),
                  ),
                ),
                const SizedBox(height: 20),
                Text(existing == null ? 'Ongeza Bidhaa' : 'Hariri Bidhaa',
                    style: GoogleFonts.nunito(fontSize: 18, fontWeight: FontWeight.w900, color: AppColors.emeraldDark)),
                const SizedBox(height: 16),
                // Type toggle
                Container(
                  padding: const EdgeInsets.all(4),
                  decoration: BoxDecoration(color: AppColors.grey100, borderRadius: BorderRadius.circular(12)),
                  child: Row(
                    children: [
                      Expanded(
                        child: GestureDetector(
                          onTap: () => setS(() => isService = false),
                          child: Container(
                            padding: const EdgeInsets.symmetric(vertical: 10),
                            decoration: BoxDecoration(
                              color: !isService ? AppColors.emeraldPrimary : Colors.transparent,
                              borderRadius: BorderRadius.circular(10),
                            ),
                            child: Row(
                              mainAxisAlignment: MainAxisAlignment.center,
                              children: [
                                Icon(Icons.inventory_2_rounded, size: 16, color: !isService ? Colors.white : AppColors.grey400),
                                const SizedBox(width: 6),
                                Text('Bidhaa', style: GoogleFonts.nunito(color: !isService ? Colors.white : AppColors.grey400, fontWeight: FontWeight.w700, fontSize: 13)),
                              ],
                            ),
                          ),
                        ),
                      ),
                      Expanded(
                        child: GestureDetector(
                          onTap: () => setS(() => isService = true),
                          child: Container(
                            padding: const EdgeInsets.symmetric(vertical: 10),
                            decoration: BoxDecoration(
                              color: isService ? AppColors.emeraldPrimary : Colors.transparent,
                              borderRadius: BorderRadius.circular(10),
                            ),
                            child: Row(
                              mainAxisAlignment: MainAxisAlignment.center,
                              children: [
                                Icon(Icons.design_services_rounded, size: 16, color: isService ? Colors.white : AppColors.grey400),
                                const SizedBox(width: 6),
                                Text('Huduma', style: GoogleFonts.nunito(color: isService ? Colors.white : AppColors.grey400, fontWeight: FontWeight.w700, fontSize: 13)),
                              ],
                            ),
                          ),
                        ),
                      ),
                    ],
                  ),
                ),
                const SizedBox(height: 16),
                _SheetInput(ctrl: nameCtrl, label: 'Jina', hint: isService ? 'Usafi wa Ofisi' : 'Simu za Samsung', icon: Icons.label_outline),
                const SizedBox(height: 12),
                _SheetInput(ctrl: descCtrl, label: 'Maelezo', hint: 'Maelezo mafupi...', icon: Icons.notes_rounded, maxLines: 2),
                const SizedBox(height: 12),
                Row(
                  children: [
                    Expanded(child: _SheetInput(ctrl: priceCtrl, label: 'Bei (TSh)', hint: '25000', icon: Icons.payments_outlined, keyboard: TextInputType.number)),
                    if (!isService) ...[
                      const SizedBox(width: 12),
                      Expanded(child: _SheetInput(ctrl: stockCtrl, label: 'Stoku', hint: '100', icon: Icons.inventory_outlined, keyboard: TextInputType.number)),
                    ],
                  ],
                ),
                const SizedBox(height: 24),
                SizedBox(
                  width: double.infinity,
                  height: 52,
                  child: ElevatedButton(
                    onPressed: loading ? null : () async {
                      if (nameCtrl.text.isEmpty || priceCtrl.text.isEmpty) return;
                      setS(() => loading = true);
                      try {
                        final body = {
                          'name': nameCtrl.text.trim(),
                          'description': descCtrl.text.trim(),
                          'price': priceCtrl.text.trim(),
                          'type': isService ? 'service' : 'product',
                          if (!isService && stockCtrl.text.isNotEmpty) 'stock': stockCtrl.text.trim(),
                        };
                        if (existing != null) {
                          await ApiService.put(ApiConfig.productUpdate(existing.id), body);
                        } else {
                          await ApiService.post(ApiConfig.products, body);
                        }
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
                        : Text(existing == null ? 'Ongeza Bidhaa' : 'Hifadhi Mabadiliko',
                            style: GoogleFonts.nunito(color: Colors.white, fontWeight: FontWeight.w800, fontSize: 14)),
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
    final lowStock = _products.where((p) => p.isLowStock).length;
    final outOfStock = _products.where((p) => p.isOutOfStock).length;

    return Scaffold(
      backgroundColor: AppColors.grey100,
      body: NestedScrollView(
        headerSliverBuilder: (_, __) => [
          SliverAppBar(
            expandedHeight: 150,
            pinned: true,
            backgroundColor: const Color(0xFFE65100),
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
                    colors: [Color(0xFFF57C00), Color(0xFFE65100)],
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
                            Text('Bidhaa & Huduma', style: GoogleFonts.nunito(color: Colors.white, fontSize: 20, fontWeight: FontWeight.w900)),
                            const Spacer(),
                            GestureDetector(
                              onTap: () => setState(() => _gridView = !_gridView),
                              child: Container(
                                padding: const EdgeInsets.all(8),
                                decoration: BoxDecoration(color: Colors.white.withOpacity(0.15), borderRadius: BorderRadius.circular(10)),
                                child: Icon(_gridView ? Icons.list_rounded : Icons.grid_view_rounded, color: Colors.white, size: 18),
                              ),
                            ),
                          ],
                        ),
                        const SizedBox(height: 8),
                        Row(
                          children: [
                            _HeaderPill(label: '${_products.length} Bidhaa', icon: Icons.inventory_2_outlined),
                            const SizedBox(width: 8),
                            if (lowStock > 0 || outOfStock > 0)
                              _HeaderPill(
                                label: '${lowStock + outOfStock} Tatizo',
                                icon: Icons.warning_amber_rounded,
                                color: const Color(0xFFFFD54F),
                              ),
                          ],
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
                color: const Color(0xFFE65100),
                child: TabBar(
                  controller: _tabCtrl,
                  indicatorColor: const Color(0xFFFFD54F),
                  indicatorWeight: 3,
                  labelColor: Colors.white,
                  unselectedLabelColor: Colors.white.withOpacity(0.5),
                  labelStyle: GoogleFonts.nunito(fontSize: 13, fontWeight: FontWeight.w800),
                  unselectedLabelStyle: GoogleFonts.nunito(fontSize: 13, fontWeight: FontWeight.w600),
                  tabs: const [Tab(text: 'Bidhaa'), Tab(text: 'Huduma')],
                ),
              ),
            ),
          ),
        ],
        body: Column(
          children: [
            Container(
              color: AppColors.white,
              padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 10),
              child: TextField(
                controller: _searchCtrl,
                onChanged: (v) => setState(() => _search = v),
                style: GoogleFonts.nunito(fontSize: 13),
                decoration: InputDecoration(
                  hintText: 'Tafuta bidhaa...',
                  hintStyle: GoogleFonts.nunito(color: AppColors.grey400, fontSize: 13),
                  prefixIcon: const Icon(Icons.search_rounded, color: AppColors.grey400, size: 18),
                  filled: true,
                  fillColor: AppColors.grey100,
                  contentPadding: const EdgeInsets.symmetric(vertical: 10),
                  border: OutlineInputBorder(borderRadius: BorderRadius.circular(12), borderSide: BorderSide.none),
                ),
              ),
            ),
            Expanded(
              child: _loading
                  ? const Center(child: CircularProgressIndicator(color: Color(0xFFF57C00)))
                  : _error != null
                      ? Center(child: Text(_error!, style: GoogleFonts.nunito(color: AppColors.grey400)))
                      : _filtered.isEmpty
                          ? Center(
                              child: Column(
                                mainAxisAlignment: MainAxisAlignment.center,
                                children: [
                                  Icon(Icons.inventory_2_outlined, size: 56, color: AppColors.grey400.withOpacity(0.5)),
                                  const SizedBox(height: 12),
                                  Text('Hakuna bidhaa', style: GoogleFonts.nunito(color: AppColors.grey400, fontWeight: FontWeight.w700)),
                                ],
                              ),
                            )
                          : RefreshIndicator(
                              color: const Color(0xFFF57C00),
                              onRefresh: _load,
                              child: _gridView
                                  ? GridView.builder(
                                      padding: const EdgeInsets.all(16),
                                      gridDelegate: const SliverGridDelegateWithFixedCrossAxisCount(
                                        crossAxisCount: 2,
                                        mainAxisSpacing: 12,
                                        crossAxisSpacing: 12,
                                        childAspectRatio: 0.82,
                                      ),
                                      itemCount: _filtered.length,
                                      itemBuilder: (_, i) => _ProductCard(
                                        product: _filtered[i],
                                        onEdit: () => _showAddSheet(existing: _filtered[i]),
                                        onDelete: () => _deleteProduct(_filtered[i]),
                                      ),
                                    )
                                  : ListView.builder(
                                      padding: const EdgeInsets.all(16),
                                      itemCount: _filtered.length,
                                      itemBuilder: (_, i) => _ProductListTile(
                                        product: _filtered[i],
                                        onEdit: () => _showAddSheet(existing: _filtered[i]),
                                        onDelete: () => _deleteProduct(_filtered[i]),
                                      ),
                                    ),
                            ),
            ),
          ],
        ),
      ),
      floatingActionButton: FloatingActionButton.extended(
        onPressed: _showAddSheet,
        backgroundColor: const Color(0xFFF57C00),
        icon: const Icon(Icons.add_rounded, color: Colors.white),
        label: Text('Ongeza', style: GoogleFonts.nunito(color: Colors.white, fontWeight: FontWeight.w800)),
      ),
    );
  }
}

class _HeaderPill extends StatelessWidget {
  final String label;
  final IconData icon;
  final Color color;

  const _HeaderPill({required this.label, required this.icon, this.color = Colors.white});

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 5),
      decoration: BoxDecoration(
        color: color.withOpacity(0.2),
        borderRadius: BorderRadius.circular(20),
        border: Border.all(color: color.withOpacity(0.3)),
      ),
      child: Row(
        mainAxisSize: MainAxisSize.min,
        children: [
          Icon(icon, color: color, size: 12),
          const SizedBox(width: 4),
          Text(label, style: GoogleFonts.nunito(color: color, fontSize: 11, fontWeight: FontWeight.w700)),
        ],
      ),
    );
  }
}

class _ProductCard extends StatelessWidget {
  final ProductModel product;
  final VoidCallback onEdit;
  final VoidCallback onDelete;

  const _ProductCard({required this.product, required this.onEdit, required this.onDelete});

  @override
  Widget build(BuildContext context) {
    Color stockColor = product.isOutOfStock
        ? Colors.red
        : product.isLowStock
            ? AppColors.gold
            : AppColors.emeraldPrimary;

    return Container(
      decoration: BoxDecoration(
        color: AppColors.white,
        borderRadius: BorderRadius.circular(16),
        boxShadow: [BoxShadow(color: Colors.black.withOpacity(0.04), blurRadius: 8, offset: const Offset(0, 2))],
      ),
      child: Padding(
        padding: const EdgeInsets.all(14),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Row(
              children: [
                Container(
                  width: 40, height: 40,
                  decoration: BoxDecoration(
                    color: product.isService ? const Color(0xFFEEF2FF) : const Color(0xFFFFF3E0),
                    borderRadius: BorderRadius.circular(12),
                  ),
                  child: Icon(
                    product.isService ? Icons.design_services_rounded : Icons.inventory_2_rounded,
                    color: product.isService ? const Color(0xFF4F46E5) : const Color(0xFFF57C00),
                    size: 20,
                  ),
                ),
                const Spacer(),
                PopupMenuButton<String>(
                  icon: const Icon(Icons.more_vert_rounded, size: 16, color: AppColors.grey400),
                  onSelected: (v) {
                    if (v == 'edit') onEdit();
                    if (v == 'delete') onDelete();
                  },
                  itemBuilder: (_) => [
                    PopupMenuItem(value: 'edit', child: Row(children: [const Icon(Icons.edit_outlined, size: 16), const SizedBox(width: 8), Text('Hariri', style: GoogleFonts.nunito(fontWeight: FontWeight.w700))])),
                    PopupMenuItem(value: 'delete', child: Row(children: [const Icon(Icons.delete_outline_rounded, size: 16, color: Colors.red), const SizedBox(width: 8), Text('Futa', style: GoogleFonts.nunito(fontWeight: FontWeight.w700, color: Colors.red))])),
                  ],
                ),
              ],
            ),
            const SizedBox(height: 10),
            Text(product.name,
                style: GoogleFonts.nunito(fontSize: 13, fontWeight: FontWeight.w800, color: AppColors.emeraldDark),
                maxLines: 2,
                overflow: TextOverflow.ellipsis),
            const SizedBox(height: 4),
            Text('TSh ${NumberFormat('#,##0').format(product.price)}',
                style: GoogleFonts.nunito(fontSize: 14, fontWeight: FontWeight.w900, color: AppColors.emeraldPrimary)),
            const Spacer(),
            if (!product.isService && product.stock != null)
              Row(
                children: [
                  Container(
                    width: 6, height: 6,
                    decoration: BoxDecoration(color: stockColor, shape: BoxShape.circle),
                  ),
                  const SizedBox(width: 5),
                  Text(
                    product.isOutOfStock ? 'Imeisha' : product.isLowStock ? 'Inakwisha (${product.stock})' : 'Stoku: ${product.stock}',
                    style: GoogleFonts.nunito(fontSize: 10, color: stockColor, fontWeight: FontWeight.w700),
                  ),
                ],
              ),
          ],
        ),
      ),
    );
  }
}

class _ProductListTile extends StatelessWidget {
  final ProductModel product;
  final VoidCallback onEdit;
  final VoidCallback onDelete;

  const _ProductListTile({required this.product, required this.onEdit, required this.onDelete});

  @override
  Widget build(BuildContext context) {
    return Container(
      margin: const EdgeInsets.only(bottom: 10),
      padding: const EdgeInsets.all(14),
      decoration: BoxDecoration(
        color: AppColors.white,
        borderRadius: BorderRadius.circular(14),
        boxShadow: [BoxShadow(color: Colors.black.withOpacity(0.04), blurRadius: 8, offset: const Offset(0, 2))],
      ),
      child: Row(
        children: [
          Container(
            width: 44, height: 44,
            decoration: BoxDecoration(
              color: product.isService ? const Color(0xFFEEF2FF) : const Color(0xFFFFF3E0),
              borderRadius: BorderRadius.circular(12),
            ),
            child: Icon(
              product.isService ? Icons.design_services_rounded : Icons.inventory_2_rounded,
              color: product.isService ? const Color(0xFF4F46E5) : const Color(0xFFF57C00),
              size: 20,
            ),
          ),
          const SizedBox(width: 12),
          Expanded(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(product.name, style: GoogleFonts.nunito(fontSize: 13, fontWeight: FontWeight.w800, color: AppColors.emeraldDark)),
                Text('TSh ${NumberFormat('#,##0').format(product.price)}',
                    style: GoogleFonts.nunito(fontSize: 12, fontWeight: FontWeight.w700, color: AppColors.emeraldPrimary)),
              ],
            ),
          ),
          Row(
            children: [
              IconButton(icon: const Icon(Icons.edit_outlined, size: 18, color: AppColors.grey400), onPressed: onEdit),
              IconButton(icon: const Icon(Icons.delete_outline_rounded, size: 18, color: Colors.red), onPressed: onDelete),
            ],
          ),
        ],
      ),
    );
  }
}

class _SheetInput extends StatelessWidget {
  final TextEditingController ctrl;
  final String label;
  final String hint;
  final IconData icon;
  final TextInputType keyboard;
  final int maxLines;

  const _SheetInput({
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
        Text(label, style: GoogleFonts.nunito(fontSize: 12, fontWeight: FontWeight.w700, color: AppColors.grey700)),
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
            focusedBorder: OutlineInputBorder(borderRadius: BorderRadius.circular(12), borderSide: const BorderSide(color: AppColors.emeraldPrimary, width: 1.5)),
          ),
        ),
      ],
    );
  }
}
