import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:google_fonts/google_fonts.dart';
import '../../services/auth_service.dart';
import '../../theme/app_theme.dart';
import '../auth/login_screen.dart';
import '../onboarding_screen.dart';
import 'package:shared_preferences/shared_preferences.dart';

class ProfileScreen extends StatelessWidget {
  const ProfileScreen({super.key});

  Future<void> _logout(BuildContext context) async {
    final confirm = await showDialog<bool>(
      context: context,
      builder: (_) => AlertDialog(
        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(20)),
        title: Text('Toka', style: GoogleFonts.nunito(fontWeight: FontWeight.w900)),
        content: Text('Una uhakika wa kutoka kwenye akaunti yako?',
            style: GoogleFonts.nunito(fontSize: 13)),
        actions: [
          TextButton(
            onPressed: () => Navigator.pop(context, false),
            child: Text('Hapana', style: GoogleFonts.nunito(color: AppColors.grey400)),
          ),
          ElevatedButton(
            onPressed: () => Navigator.pop(context, true),
            style: ElevatedButton.styleFrom(backgroundColor: Colors.red),
            child: Text('Toka', style: GoogleFonts.nunito(color: Colors.white, fontWeight: FontWeight.w800)),
          ),
        ],
      ),
    );
    if (confirm != true) return;
    await AuthService.logout();
    if (!context.mounted) return;
    Navigator.of(context).pushAndRemoveUntil(
      PageRouteBuilder(
        pageBuilder: (_, __, ___) => const LoginScreen(),
        transitionDuration: const Duration(milliseconds: 400),
        transitionsBuilder: (_, anim, __, child) =>
            FadeTransition(opacity: anim, child: child),
      ),
      (route) => false,
    );
  }

  Future<void> _resetOnboarding(BuildContext context) async {
    final prefs = await SharedPreferences.getInstance();
    await prefs.remove('onboarding_done');
    if (!context.mounted) return;
    Navigator.of(context).push(MaterialPageRoute(builder: (_) => const OnboardingScreen()));
  }

  @override
  Widget build(BuildContext context) {
    final user = AuthService.currentUser;

    return Scaffold(
      backgroundColor: AppColors.grey100,
      body: CustomScrollView(
        slivers: [
          // Header
          SliverToBoxAdapter(
            child: Container(
              decoration: const BoxDecoration(
                gradient: LinearGradient(
                  begin: Alignment.topLeft,
                  end: Alignment.bottomRight,
                  colors: [Color(0xFF4a148c), Color(0xFF6a1b9a)],
                ),
              ),
              child: Stack(
                children: [
                  Positioned(
                    top: -50, right: -30,
                    child: Container(
                      width: 160, height: 160,
                      decoration: BoxDecoration(
                        shape: BoxShape.circle,
                        color: Colors.white.withOpacity(0.05),
                      ),
                    ),
                  ),
                  SafeArea(
                    bottom: false,
                    child: Padding(
                      padding: const EdgeInsets.fromLTRB(20, 20, 20, 32),
                      child: Column(
                        children: [
                          // Avatar
                          Container(
                            width: 80, height: 80,
                            decoration: BoxDecoration(
                              gradient: const LinearGradient(colors: [AppColors.gold, Color(0xFFE09800)]),
                              shape: BoxShape.circle,
                              boxShadow: [BoxShadow(color: AppColors.gold.withOpacity(0.4), blurRadius: 16, offset: const Offset(0, 6))],
                            ),
                            child: Center(
                              child: Text(
                                user?.initials ?? 'SP',
                                style: GoogleFonts.nunito(color: AppColors.emeraldDark, fontWeight: FontWeight.w900, fontSize: 28),
                              ),
                            ),
                          ),
                          const SizedBox(height: 14),
                          Text(
                            user?.businessName ?? user?.fullName ?? 'SalamaPay User',
                            style: GoogleFonts.nunito(color: Colors.white, fontSize: 20, fontWeight: FontWeight.w900),
                          ),
                          const SizedBox(height: 4),
                          Text(
                            user?.email ?? '',
                            style: GoogleFonts.nunito(color: Colors.white.withOpacity(0.7), fontSize: 13, fontWeight: FontWeight.w600),
                          ),
                          const SizedBox(height: 16),
                          // Role badge
                          Container(
                            padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 6),
                            decoration: BoxDecoration(
                              color: AppColors.gold.withOpacity(0.2),
                              borderRadius: BorderRadius.circular(20),
                              border: Border.all(color: AppColors.gold.withOpacity(0.4)),
                            ),
                            child: Row(
                              mainAxisSize: MainAxisSize.min,
                              children: [
                                const Icon(Icons.verified_rounded, color: AppColors.gold, size: 14),
                                const SizedBox(width: 6),
                                Text('Akaunti ya Mfanyabiashara',
                                    style: GoogleFonts.nunito(color: AppColors.gold, fontSize: 12, fontWeight: FontWeight.w800)),
                              ],
                            ),
                          ),
                        ],
                      ),
                    ),
                  ),
                ],
              ),
            ),
          ),

          // Body sections
          SliverToBoxAdapter(
            child: Padding(
              padding: const EdgeInsets.all(16),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  // User info card
                  _ProfileCard(
                    items: [
                      _ProfileItem(icon: Icons.person_outline_rounded, label: 'Jina Kamili', value: user?.fullName ?? '—'),
                      _ProfileItem(icon: Icons.store_outlined, label: 'Biashara', value: user?.businessName ?? '—'),
                      _ProfileItem(icon: Icons.phone_outlined, label: 'Simu', value: user?.phone ?? '—'),
                      _ProfileItem(icon: Icons.email_outlined, label: 'Barua Pepe', value: user?.email ?? '—'),
                    ],
                  ),
                  const SizedBox(height: 16),

                  _SectionLabel(label: 'Mipangilio'),
                  const SizedBox(height: 10),
                  _ProfileCard(
                    items: [
                      _ProfileItem(icon: Icons.notifications_outlined, label: 'Arifa', value: 'Zimewashwa', trailing: const Icon(Icons.chevron_right_rounded, color: AppColors.grey400)),
                      _ProfileItem(icon: Icons.security_rounded, label: 'Usalama', value: '', trailing: const Icon(Icons.chevron_right_rounded, color: AppColors.grey400)),
                      _ProfileItem(icon: Icons.language_rounded, label: 'Lugha', value: 'Kiswahili', trailing: const Icon(Icons.chevron_right_rounded, color: AppColors.grey400)),
                    ],
                  ),
                  const SizedBox(height: 16),

                  _SectionLabel(label: 'Biashara'),
                  const SizedBox(height: 10),
                  _ProfileCard(
                    items: [
                      _ProfileItem(icon: Icons.receipt_long_outlined, label: 'Ankara Zangu', value: '', trailing: const Icon(Icons.chevron_right_rounded, color: AppColors.grey400)),
                      _ProfileItem(icon: Icons.bar_chart_rounded, label: 'Ripoti', value: '', trailing: const Icon(Icons.chevron_right_rounded, color: AppColors.grey400)),
                      _ProfileItem(icon: Icons.qr_code_rounded, label: 'QR Code yangu', value: '', trailing: const Icon(Icons.chevron_right_rounded, color: AppColors.grey400)),
                      _ProfileItem(icon: Icons.link_rounded, label: 'Viungo vya Malipo', value: '', trailing: const Icon(Icons.chevron_right_rounded, color: AppColors.grey400)),
                    ],
                  ),
                  const SizedBox(height: 16),

                  _SectionLabel(label: 'Msaada'),
                  const SizedBox(height: 10),
                  _ProfileCard(
                    items: [
                      _ProfileItem(icon: Icons.help_outline_rounded, label: 'Msaada & Maswali', value: '', trailing: const Icon(Icons.chevron_right_rounded, color: AppColors.grey400)),
                      _ProfileItem(icon: Icons.info_outline_rounded, label: 'Kuhusu SalamaPay', value: 'v1.0.0', trailing: const Icon(Icons.chevron_right_rounded, color: AppColors.grey400)),
                      _ProfileItem(
                        icon: Icons.replay_rounded,
                        label: 'Tazama Onboarding',
                        value: '',
                        trailing: const Icon(Icons.chevron_right_rounded, color: AppColors.grey400),
                        onTap: () => _resetOnboarding(context),
                      ),
                    ],
                  ),
                  const SizedBox(height: 20),

                  // Logout button
                  GestureDetector(
                    onTap: () => _logout(context),
                    child: Container(
                      width: double.infinity,
                      height: 52,
                      decoration: BoxDecoration(
                        color: Colors.red.shade50,
                        borderRadius: BorderRadius.circular(16),
                        border: Border.all(color: Colors.red.shade200),
                      ),
                      child: Row(
                        mainAxisAlignment: MainAxisAlignment.center,
                        children: [
                          Icon(Icons.logout_rounded, color: Colors.red.shade600, size: 20),
                          const SizedBox(width: 10),
                          Text(
                            'Toka Akaunti',
                            style: GoogleFonts.nunito(
                              color: Colors.red.shade600,
                              fontSize: 14,
                              fontWeight: FontWeight.w800,
                            ),
                          ),
                        ],
                      ),
                    ),
                  ),
                  const SizedBox(height: 32),

                  // Footer
                  Center(
                    child: Text(
                      '© 2026 SalamaPay — Lipa kwa Urahisi',
                      style: GoogleFonts.nunito(color: AppColors.grey400, fontSize: 11, fontWeight: FontWeight.w600),
                    ),
                  ),
                  const SizedBox(height: 8),
                ],
              ),
            ),
          ),
        ],
      ),
    );
  }
}

class _SectionLabel extends StatelessWidget {
  final String label;
  const _SectionLabel({required this.label});

  @override
  Widget build(BuildContext context) => Text(
        label,
        style: GoogleFonts.nunito(fontSize: 11, fontWeight: FontWeight.w800, color: AppColors.grey400, letterSpacing: 0.8),
      );
}

class _ProfileCard extends StatelessWidget {
  final List<_ProfileItem> items;
  const _ProfileCard({required this.items});

  @override
  Widget build(BuildContext context) {
    return Container(
      decoration: BoxDecoration(
        color: AppColors.white,
        borderRadius: BorderRadius.circular(16),
        boxShadow: [BoxShadow(color: Colors.black.withOpacity(0.04), blurRadius: 8, offset: const Offset(0, 2))],
      ),
      child: Column(
        children: items.asMap().entries.map((entry) {
          final i = entry.key;
          final item = entry.value;
          return Column(
            children: [
              InkWell(
                onTap: item.onTap,
                borderRadius: BorderRadius.circular(16),
                child: Padding(
                  padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 13),
                  child: Row(
                    children: [
                      Container(
                        width: 34, height: 34,
                        decoration: BoxDecoration(
                          color: AppColors.emeraldPrimary.withOpacity(0.07),
                          borderRadius: BorderRadius.circular(10),
                        ),
                        child: Icon(item.icon, color: AppColors.emeraldPrimary, size: 17),
                      ),
                      const SizedBox(width: 12),
                      Expanded(
                        child: Text(item.label, style: GoogleFonts.nunito(fontSize: 13, fontWeight: FontWeight.w700, color: AppColors.emeraldDark)),
                      ),
                      if (item.value.isNotEmpty)
                        Text(item.value, style: GoogleFonts.nunito(fontSize: 12, color: AppColors.grey400, fontWeight: FontWeight.w600)),
                      if (item.trailing != null) ...[const SizedBox(width: 4), item.trailing!],
                    ],
                  ),
                ),
              ),
              if (i < items.length - 1)
                Divider(height: 1, indent: 62, color: AppColors.grey400.withOpacity(0.15)),
            ],
          );
        }).toList(),
      ),
    );
  }
}

class _ProfileItem {
  final IconData icon;
  final String label;
  final String value;
  final Widget? trailing;
  final VoidCallback? onTap;

  const _ProfileItem({
    required this.icon,
    required this.label,
    required this.value,
    this.trailing,
    this.onTap,
  });
}
