import 'dart:async';
import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:cached_network_image/cached_network_image.dart';
import '../theme/app_theme.dart';
import 'auth/login_screen.dart';

// ─── Data Model ───────────────────────────────────────────────────────────────

class _Slide {
  final String imageUrl;
  final String badge;
  final String title;
  final String subtitle;
  final Color circleColor;
  final Color badgeColor;
  final Color badgeBg;
  final List<String> features;

  const _Slide({
    required this.imageUrl,
    required this.badge,
    required this.title,
    required this.subtitle,
    required this.circleColor,
    required this.badgeColor,
    required this.badgeBg,
    required this.features,
  });
}

const List<_Slide> _slides = [
  _Slide(
    imageUrl: 'https://cdn-icons-png.flaticon.com/512/2489/2489756.png',
    badge: 'M-Pesa · Tigo · Airtel',
    title: 'Lipa kwa Urahisi',
    subtitle: 'Tuma na pokea malipo kwa sekunde moja kutoka kwa wateja wako bila msongo.',
    circleColor: Color(0xFFD1FAE5),
    badgeColor: Color(0xFF065F46),
    badgeBg: Color(0xFFECFDF5),
    features: ['M-Pesa & Tigo Pesa', 'Malipo ya Haraka', 'Bila Ada ya Ziada'],
  ),
  _Slide(
    imageUrl: 'https://cdn-icons-png.flaticon.com/512/2784/2784461.png',
    badge: 'Ripoti za Wakati Halisi',
    title: 'Fuatilia Mauzo Yako',
    subtitle: 'Angalia mauzo, mapato, na takwimu za biashara yako wakati wowote unapotaka.',
    circleColor: Color(0xFFFFF8E1),
    badgeColor: Color(0xFF92400E),
    badgeBg: Color(0xFFFFFBEB),
    features: ['Grafu za Mauzo', 'Ripoti za Kila Siku', 'Uchambuzi wa Data'],
  ),
  _Slide(
    imageUrl: 'https://cdn-icons-png.flaticon.com/512/3388/3388834.png',
    badge: 'PDF · WhatsApp · Email',
    title: 'Tuma Ankara Haraka',
    subtitle: 'Tengeneza ankara za kitaalamu kwa dakika moja na zitume moja kwa moja kwa wateja.',
    circleColor: Color(0xFFEFF6FF),
    badgeColor: Color(0xFF1E40AF),
    badgeBg: Color(0xFFDBEAFE),
    features: ['Ankara za PDF', 'Tuma WhatsApp', 'Fuatilia Malipo'],
  ),
  _Slide(
    imageUrl: 'https://cdn-icons-png.flaticon.com/512/2092/2092663.png',
    badge: 'Usalama wa Hali ya Juu',
    title: 'Biashara Salama Daima',
    subtitle: 'Data yako na pesa ya biashara yako vinalindwa kwa teknolojia ya hali ya juu.',
    circleColor: Color(0xFFF5F3FF),
    badgeColor: Color(0xFF5B21B6),
    badgeBg: Color(0xFFEDE9FE),
    features: ['Enkripsheni 256-bit', 'Akaunti Salama', 'Msaada 24/7'],
  ),
];

// ─── Main Screen ──────────────────────────────────────────────────────────────

class OnboardingScreen extends StatefulWidget {
  const OnboardingScreen({super.key});

  @override
  State<OnboardingScreen> createState() => _OnboardingScreenState();
}

class _OnboardingScreenState extends State<OnboardingScreen> {
  final PageController _ctrl = PageController();
  int _current = 0;

  @override
  void initState() {
    super.initState();
    SystemChrome.setSystemUIOverlayStyle(const SystemUiOverlayStyle(
      statusBarColor: Colors.transparent,
      statusBarIconBrightness: Brightness.dark,
    ));
  }

  @override
  void dispose() {
    _ctrl.dispose();
    super.dispose();
  }

  void _next() {
    if (_current < _slides.length - 1) {
      _ctrl.nextPage(
          duration: const Duration(milliseconds: 350),
          curve: Curves.easeInOut);
    } else {
      _showSetupComplete();
    }
  }

  void _skip() {
    showDialog(
      context: context,
      builder: (_) => AlertDialog(
        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(20)),
        backgroundColor: Colors.white,
        title: Text('Ruka Mwongozo?',
            style: GoogleFonts.nunito(
                fontSize: 17,
                fontWeight: FontWeight.w900,
                color: AppColors.grey900)),
        content: Text(
          'Unaweza kuangalia mwongozo tena kutoka kwenye mipangilio. Je, unataka kuruka?',
          style: GoogleFonts.nunito(
              fontSize: 13, color: AppColors.grey700, height: 1.5),
        ),
        actions: [
          TextButton(
            onPressed: () => Navigator.pop(context),
            child: Text('Ghairi',
                style: GoogleFonts.nunito(
                    fontWeight: FontWeight.w700,
                    color: AppColors.grey700)),
          ),
          ElevatedButton(
            onPressed: () {
              Navigator.pop(context);
              _showSetupComplete();
            },
            style: ElevatedButton.styleFrom(
              backgroundColor: AppColors.emeraldPrimary,
              shape: RoundedRectangleBorder(
                  borderRadius: BorderRadius.circular(10)),
              elevation: 0,
            ),
            child: Text('Ruka',
                style: GoogleFonts.nunito(
                    color: Colors.white, fontWeight: FontWeight.w700)),
          ),
        ],
      ),
    );
  }

  void _showSetupComplete() {
    showModalBottomSheet(
      context: context,
      isDismissible: false,
      enableDrag: false,
      backgroundColor: Colors.transparent,
      builder: (_) => _SetupCompleteSheet(
        onDone: _finish,
      ),
    );
  }

  Future<void> _finish() async {
    final prefs = await SharedPreferences.getInstance();
    await prefs.setBool('onboarding_done', true);
    if (!mounted) return;
    Navigator.of(context).pushAndRemoveUntil(
      PageRouteBuilder(
        pageBuilder: (_, __, ___) => const LoginScreen(),
        transitionDuration: const Duration(milliseconds: 500),
        transitionsBuilder: (_, anim, __, child) =>
            FadeTransition(opacity: anim, child: child),
      ),
      (r) => false,
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFFF8F9FA),
      body: SafeArea(
        child: Column(children: [
          // ── Header: logo + skip ──
          Padding(
            padding:
                const EdgeInsets.symmetric(horizontal: 20, vertical: 16),
            child: Row(
              children: [
                ClipRRect(
                  borderRadius: BorderRadius.circular(10),
                  child: Image.asset('assets/images/salamapaylogo.png',
                      width: 44, height: 44, fit: BoxFit.contain),
                ),
                const SizedBox(width: 10),
                Text('SalamaPay',
                    style: GoogleFonts.nunito(
                        fontSize: 17,
                        fontWeight: FontWeight.w900,
                        color: AppColors.emeraldDark)),
                const Spacer(),
                if (_current < _slides.length - 1)
                  GestureDetector(
                    onTap: _skip,
                    child: Text('Ruka',
                        style: GoogleFonts.nunito(
                            fontSize: 14,
                            color: AppColors.grey400,
                            fontWeight: FontWeight.w600)),
                  ),
              ],
            ),
          ),

          // ── Slides ──
          Expanded(
            child: PageView.builder(
              controller: _ctrl,
              itemCount: _slides.length,
              onPageChanged: (i) => setState(() => _current = i),
              itemBuilder: (_, i) => _SlidePage(slide: _slides[i]),
            ),
          ),

          // ── Bottom: dots + buttons ──
          Padding(
            padding: const EdgeInsets.fromLTRB(24, 16, 24, 32),
            child: Column(
              children: [
                // Animated dots (xerin style)
                Row(
                  mainAxisAlignment: MainAxisAlignment.center,
                  children: List.generate(
                    _slides.length,
                    (i) => AnimatedContainer(
                      duration: const Duration(milliseconds: 300),
                      margin: const EdgeInsets.symmetric(horizontal: 4),
                      width: _current == i ? 28 : 8,
                      height: 8,
                      decoration: BoxDecoration(
                        color: _current == i
                            ? AppColors.emeraldPrimary
                            : AppColors.grey200,
                        borderRadius: BorderRadius.circular(4),
                      ),
                    ),
                  ),
                ),
                const SizedBox(height: 24),

                // Skip + Next row (xerin style)
                Row(
                  children: [
                    if (_current < _slides.length - 1)
                      Expanded(
                        child: OutlinedButton(
                          onPressed: _skip,
                          style: OutlinedButton.styleFrom(
                            side: const BorderSide(
                                color: AppColors.grey200),
                            foregroundColor: AppColors.grey700,
                            padding: const EdgeInsets.symmetric(
                                vertical: 15),
                            shape: RoundedRectangleBorder(
                                borderRadius: BorderRadius.circular(14)),
                          ),
                          child: Text('Ruka',
                              style: GoogleFonts.nunito(
                                  fontSize: 15,
                                  fontWeight: FontWeight.w600)),
                        ),
                      ),
                    if (_current < _slides.length - 1)
                      const SizedBox(width: 16),
                    Expanded(
                      flex: _current < _slides.length - 1 ? 2 : 1,
                      child: GestureDetector(
                        onTap: _next,
                        child: Container(
                          padding: const EdgeInsets.symmetric(
                              vertical: 15),
                          decoration: BoxDecoration(
                            gradient: const LinearGradient(colors: [
                              AppColors.gold,
                              AppColors.goldDark,
                            ]),
                            borderRadius: BorderRadius.circular(14),
                            boxShadow: [
                              BoxShadow(
                                color: AppColors.goldDark
                                    .withOpacity(0.35),
                                blurRadius: 12,
                                offset: const Offset(0, 4),
                              )
                            ],
                          ),
                          child: Center(
                            child: Text(
                              _current == _slides.length - 1
                                  ? 'Anza Sasa'
                                  : 'Endelea',
                              style: GoogleFonts.nunito(
                                color: AppColors.emeraldDark,
                                fontSize: 15,
                                fontWeight: FontWeight.w800,
                              ),
                            ),
                          ),
                        ),
                      ),
                    ),
                  ],
                ),
              ],
            ),
          ),
        ]),
      ),
    );
  }
}

// ─── Slide Page ───────────────────────────────────────────────────────────────

class _SlidePage extends StatelessWidget {
  final _Slide slide;
  const _SlidePage({required this.slide});

  @override
  Widget build(BuildContext context) {
    return Padding(
      padding: const EdgeInsets.symmetric(horizontal: 24),
      child: Column(
        children: [
          const SizedBox(height: 16),

          // ── Illustration area ──
          Expanded(
            child: Center(
              child: Container(
                width: 240,
                height: 240,
                decoration: BoxDecoration(
                  color: slide.circleColor,
                  shape: BoxShape.circle,
                ),
                child: Padding(
                  padding: const EdgeInsets.all(40),
                  child: CachedNetworkImage(
                    imageUrl: slide.imageUrl,
                    fit: BoxFit.contain,
                    placeholder: (_, __) => const Center(
                      child: CircularProgressIndicator(
                        strokeWidth: 2,
                        color: AppColors.emeraldPrimary,
                      ),
                    ),
                    errorWidget: (_, __, ___) => Icon(
                      Icons.image_not_supported_outlined,
                      size: 80,
                      color: AppColors.grey400,
                    ),
                  ),
                ),
              ),
            ),
          ),

          const SizedBox(height: 28),

          // ── Badge (like xerin) ──
          Container(
            padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 8),
            decoration: BoxDecoration(
              color: slide.badgeBg,
              borderRadius: BorderRadius.circular(20),
              border: Border.all(color: slide.badgeColor.withOpacity(0.25)),
            ),
            child: Text(
              slide.badge,
              style: GoogleFonts.nunito(
                fontSize: 12,
                fontWeight: FontWeight.w700,
                color: slide.badgeColor,
              ),
            ),
          ),

          const SizedBox(height: 16),

          // ── Title ──
          Text(
            slide.title,
            textAlign: TextAlign.center,
            style: GoogleFonts.nunito(
              fontSize: 26,
              fontWeight: FontWeight.w900,
              color: AppColors.grey900,
              height: 1.2,
            ),
          ),

          const SizedBox(height: 10),

          // ── Subtitle ──
          Text(
            slide.subtitle,
            textAlign: TextAlign.center,
            style: GoogleFonts.nunito(
              fontSize: 14,
              color: AppColors.grey700,
              height: 1.6,
              fontWeight: FontWeight.w500,
            ),
          ),

          const SizedBox(height: 16),

          // ── Feature chips ──
          Wrap(
            alignment: WrapAlignment.center,
            spacing: 8,
            runSpacing: 8,
            children: slide.features
                .map((f) => _FeatureChip(label: f, color: slide.badgeColor, bg: slide.badgeBg))
                .toList(),
          ),

          const SizedBox(height: 8),
        ],
      ),
    );
  }
}

// ─── Feature Chip ─────────────────────────────────────────────────────────────

class _FeatureChip extends StatelessWidget {
  final String label;
  final Color color;
  final Color bg;
  const _FeatureChip(
      {required this.label, required this.color, required this.bg});

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 6),
      decoration: BoxDecoration(
        color: bg,
        borderRadius: BorderRadius.circular(20),
      ),
      child: Row(
        mainAxisSize: MainAxisSize.min,
        children: [
          Icon(Icons.check_circle_rounded, color: color, size: 13),
          const SizedBox(width: 5),
          Text(label,
              style: GoogleFonts.nunito(
                  fontSize: 11,
                  fontWeight: FontWeight.w700,
                  color: color)),
        ],
      ),
    );
  }
}

// ─── Setup Complete Bottom Sheet ──────────────────────────────────────────────

class _SetupCompleteSheet extends StatefulWidget {
  final VoidCallback onDone;
  const _SetupCompleteSheet({required this.onDone});

  @override
  State<_SetupCompleteSheet> createState() => _SetupCompleteSheetState();
}

class _SetupCompleteSheetState extends State<_SetupCompleteSheet> {
  double _progress = 0;
  bool _done = false;
  Timer? _timer;

  @override
  void initState() {
    super.initState();
    _timer = Timer.periodic(const Duration(milliseconds: 60), (t) {
      if (!mounted) { t.cancel(); return; }
      setState(() => _progress += 0.01);
      if (_progress >= 1.0) {
        t.cancel();
        setState(() { _progress = 1.0; _done = true; });
      }
    });
  }

  @override
  void dispose() {
    _timer?.cancel();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    final pct = (_progress * 100).toInt();
    return Container(
      decoration: const BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.vertical(top: Radius.circular(28)),
      ),
      padding: const EdgeInsets.fromLTRB(32, 28, 32, 48),
      child: Column(
        mainAxisSize: MainAxisSize.min,
        children: [
          // Handle
          Container(
            width: 40, height: 4,
            margin: const EdgeInsets.only(bottom: 24),
            decoration: BoxDecoration(
              color: AppColors.grey200,
              borderRadius: BorderRadius.circular(2),
            ),
          ),

          // Logo
          Image.asset('assets/images/salamapaylogo.png',
              width: 80, height: 48, fit: BoxFit.contain),

          const SizedBox(height: 24),

          // Spinning / check icon
          AnimatedSwitcher(
            duration: const Duration(milliseconds: 400),
            child: _done
                ? Container(
                    key: const ValueKey('done'),
                    width: 64,
                    height: 64,
                    decoration: const BoxDecoration(
                      color: AppColors.successBg,
                      shape: BoxShape.circle,
                    ),
                    child: const Icon(Icons.check_rounded,
                        color: AppColors.success, size: 34),
                  )
                : SizedBox(
                    key: const ValueKey('loading'),
                    width: 64,
                    height: 64,
                    child: CircularProgressIndicator(
                      value: _progress,
                      strokeWidth: 5,
                      backgroundColor: AppColors.grey200,
                      valueColor: const AlwaysStoppedAnimation(
                          AppColors.emeraldPrimary),
                    ),
                  ),
          ),

          const SizedBox(height: 20),

          Text(
            _done ? 'Umefanikiwa!' : 'Inaandaa SalamaPay...',
            style: GoogleFonts.nunito(
              fontSize: 22,
              fontWeight: FontWeight.w900,
              color: _done ? AppColors.success : AppColors.grey900,
            ),
          ),

          const SizedBox(height: 6),

          Text(
            '$pct%',
            style: GoogleFonts.nunito(
              fontSize: 42,
              fontWeight: FontWeight.w900,
              color: _done ? AppColors.success : AppColors.emeraldPrimary,
            ),
          ),

          const SizedBox(height: 12),

          ClipRRect(
            borderRadius: BorderRadius.circular(12),
            child: LinearProgressIndicator(
              value: _progress,
              minHeight: 10,
              backgroundColor: AppColors.grey200,
              valueColor: AlwaysStoppedAnimation(
                _done ? AppColors.success : AppColors.emeraldPrimary,
              ),
            ),
          ),

          const SizedBox(height: 12),

          Text(
            _done
                ? 'Umefanikiwa! Twende kwenye akaunti yako.'
                : 'Tunaandaa mazingira yako ya biashara...',
            textAlign: TextAlign.center,
            style: GoogleFonts.nunito(
                fontSize: 13,
                color: AppColors.grey700,
                height: 1.5),
          ),

          const SizedBox(height: 24),

          if (_done)
            GestureDetector(
              onTap: widget.onDone,
              child: Container(
                width: double.infinity,
                padding: const EdgeInsets.symmetric(vertical: 15),
                decoration: BoxDecoration(
                  gradient: const LinearGradient(
                    colors: [AppColors.gold, AppColors.goldDark],
                  ),
                  borderRadius: BorderRadius.circular(14),
                  boxShadow: [
                    BoxShadow(
                      color: AppColors.goldDark.withOpacity(0.3),
                      blurRadius: 12,
                      offset: const Offset(0, 4),
                    )
                  ],
                ),
                child: Center(
                  child: Text(
                    'Anza Sasa →',
                    style: GoogleFonts.nunito(
                      color: AppColors.emeraldDark,
                      fontSize: 16,
                      fontWeight: FontWeight.w900,
                    ),
                  ),
                ),
              ),
            ),
        ],
      ),
    );
  }
}
