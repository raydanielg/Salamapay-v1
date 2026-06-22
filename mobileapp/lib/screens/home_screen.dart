import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:google_fonts/google_fonts.dart';
import '../theme/app_theme.dart';
import '../widgets/salamapay_logo.dart';

class HomeScreen extends StatelessWidget {
  const HomeScreen({super.key});

  @override
  Widget build(BuildContext context) {
    SystemChrome.setSystemUIOverlayStyle(const SystemUiOverlayStyle(
      statusBarColor: Colors.transparent,
      statusBarIconBrightness: Brightness.light,
    ));

    return Scaffold(
      backgroundColor: AppColors.grey100,
      body: Column(
        children: [
          // Header
          Container(
            decoration: const BoxDecoration(
              gradient: LinearGradient(
                begin: Alignment.topLeft,
                end: Alignment.bottomRight,
                colors: [AppColors.emeraldPrimary, AppColors.emeraldDark],
              ),
            ),
            padding: EdgeInsets.fromLTRB(
              20,
              MediaQuery.of(context).padding.top + 16,
              20,
              28,
            ),
            child: Column(
              children: [
                Row(
                  mainAxisAlignment: MainAxisAlignment.spaceBetween,
                  children: [
                    const SalamaPayLogo(size: 0.7, dark: true),
                    CircleAvatar(
                      radius: 20,
                      backgroundColor: Colors.white.withOpacity(0.2),
                      child: const Icon(Icons.person_rounded,
                          color: Colors.white, size: 22),
                    ),
                  ],
                ),
                const SizedBox(height: 24),
                Container(
                  padding: const EdgeInsets.all(20),
                  decoration: BoxDecoration(
                    color: Colors.white.withOpacity(0.1),
                    borderRadius: BorderRadius.circular(20),
                    border: Border.all(
                        color: Colors.white.withOpacity(0.15), width: 1),
                  ),
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Text(
                        'Jumla ya Mauzo',
                        style: GoogleFonts.nunito(
                          color: Colors.white.withOpacity(0.75),
                          fontSize: 13,
                          fontWeight: FontWeight.w600,
                        ),
                      ),
                      const SizedBox(height: 4),
                      Text(
                        'TSh 0.00',
                        style: GoogleFonts.nunito(
                          color: Colors.white,
                          fontSize: 32,
                          fontWeight: FontWeight.w900,
                        ),
                      ),
                      const SizedBox(height: 16),
                      Row(
                        children: [
                          _QuickAction(
                              icon: Icons.arrow_upward_rounded,
                              label: 'Tuma',
                              color: AppColors.gold),
                          const SizedBox(width: 12),
                          _QuickAction(
                              icon: Icons.arrow_downward_rounded,
                              label: 'Pokea',
                              color: Colors.white),
                          const SizedBox(width: 12),
                          _QuickAction(
                              icon: Icons.qr_code_rounded,
                              label: 'QR Code',
                              color: Colors.white),
                        ],
                      ),
                    ],
                  ),
                ),
              ],
            ),
          ),

          // Body
          Expanded(
            child: Center(
              child: Column(
                mainAxisAlignment: MainAxisAlignment.center,
                children: [
                  Icon(Icons.rocket_launch_rounded,
                      size: 64, color: AppColors.emeraldPrimary.withOpacity(0.3)),
                  const SizedBox(height: 16),
                  Text(
                    'Karibu SalamaPay!',
                    style: GoogleFonts.nunito(
                      fontSize: 22,
                      fontWeight: FontWeight.w900,
                      color: AppColors.emeraldPrimary,
                    ),
                  ),
                  const SizedBox(height: 8),
                  Text(
                    'Dashboard inakuja hivi punde...',
                    style: GoogleFonts.nunito(
                      fontSize: 14,
                      color: AppColors.grey400,
                      fontWeight: FontWeight.w600,
                    ),
                  ),
                ],
              ),
            ),
          ),
        ],
      ),
    );
  }
}

class _QuickAction extends StatelessWidget {
  final IconData icon;
  final String label;
  final Color color;

  const _QuickAction(
      {required this.icon, required this.label, required this.color});

  @override
  Widget build(BuildContext context) {
    return Column(
      children: [
        Container(
          width: 44,
          height: 44,
          decoration: BoxDecoration(
            color: Colors.white.withOpacity(0.15),
            borderRadius: BorderRadius.circular(14),
          ),
          child: Icon(icon, color: color, size: 22),
        ),
        const SizedBox(height: 6),
        Text(
          label,
          style: GoogleFonts.nunito(
            color: Colors.white.withOpacity(0.85),
            fontSize: 11,
            fontWeight: FontWeight.w700,
          ),
        ),
      ],
    );
  }
}
