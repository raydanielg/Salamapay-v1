import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:smooth_page_indicator/smooth_page_indicator.dart';
import '../theme/app_theme.dart';
import 'home_screen.dart';

class OnboardingScreen extends StatefulWidget {
  const OnboardingScreen({super.key});

  @override
  State<OnboardingScreen> createState() => _OnboardingScreenState();
}

class _OnboardingScreenState extends State<OnboardingScreen>
    with TickerProviderStateMixin {
  final PageController _pageController = PageController();
  int _currentPage = 0;

  late AnimationController _fadeController;
  late Animation<double> _fadeAnimation;

  final List<_OnboardingPage> _pages = [
    _OnboardingPage(
      title: 'Malipo Salama',
      subtitle: 'Lipa na Upokee kwa Urahisi',
      description:
          'Tuma na pokea malipo yako kwa urahisi na usalama wa hali ya juu. SalamaPay inahifadhi pesa yako kila wakati.',
      gradient: [Color(0xFF024938), Color(0xFF035E48)],
      iconData: Icons.security_rounded,
      accentColor: AppColors.gold,
      decorationColor: Color(0xFF035E48),
      features: ['M-Pesa & Tigo Pesa', 'Malipo ya Haraka', 'Salama 100%'],
    ),
    _OnboardingPage(
      title: 'Biashara Rahisi',
      subtitle: 'Zana za Biashara Yako',
      description:
          'Simamia biashara yako kwa urahisi. Tengeneza ankara, angalia ripoti, na simamia bidhaa zako zote mahali pamoja.',
      gradient: [Color(0xFF1a237e), Color(0xFF283593)],
      iconData: Icons.store_rounded,
      accentColor: Color(0xFFFFD54F),
      decorationColor: Color(0xFF283593),
      features: ['Ankara za Haraka', 'Ripoti za Biashara', 'Simamia Bidhaa'],
    ),
    _OnboardingPage(
      title: 'Haraka & Rahisi',
      subtitle: 'Anza Leo, Bila Msongo',
      description:
          'Jiunge na maelfu ya wafanyabiashara wanaotumia SalamaPay kila siku. Anza bure, kukua pamoja nasi.',
      gradient: [Color(0xFF4a148c), Color(0xFF6a1b9a)],
      iconData: Icons.rocket_launch_rounded,
      accentColor: Color(0xFFFF80AB),
      decorationColor: Color(0xFF6a1b9a),
      features: ['Bure Kujisajili', 'Msaada 24/7', 'Anza Haraka'],
    ),
  ];

  @override
  void initState() {
    super.initState();
    SystemChrome.setSystemUIOverlayStyle(const SystemUiOverlayStyle(
      statusBarColor: Colors.transparent,
      statusBarIconBrightness: Brightness.light,
    ));
    _fadeController = AnimationController(
      vsync: this,
      duration: const Duration(milliseconds: 400),
    );
    _fadeAnimation = Tween<double>(begin: 0.0, end: 1.0).animate(
      CurvedAnimation(parent: _fadeController, curve: Curves.easeIn),
    );
    _fadeController.forward();
  }

  @override
  void dispose() {
    _pageController.dispose();
    _fadeController.dispose();
    super.dispose();
  }

  Future<void> _completeOnboarding() async {
    final prefs = await SharedPreferences.getInstance();
    await prefs.setBool('onboarding_done', true);
    if (!mounted) return;
    Navigator.of(context).pushReplacement(
      PageRouteBuilder(
        pageBuilder: (_, __, ___) => const HomeScreen(),
        transitionDuration: const Duration(milliseconds: 500),
        transitionsBuilder: (_, anim, __, child) => SlideTransition(
          position: Tween<Offset>(
            begin: const Offset(1.0, 0.0),
            end: Offset.zero,
          ).animate(CurvedAnimation(parent: anim, curve: Curves.easeOutCubic)),
          child: child,
        ),
      ),
    );
  }

  void _nextPage() {
    if (_currentPage < _pages.length - 1) {
      _pageController.nextPage(
        duration: const Duration(milliseconds: 500),
        curve: Curves.easeInOutCubic,
      );
    } else {
      _completeOnboarding();
    }
  }

  @override
  Widget build(BuildContext context) {
    return FadeTransition(
      opacity: _fadeAnimation,
      child: Scaffold(
        body: Stack(
          children: [
            // Pages
            PageView.builder(
              controller: _pageController,
              itemCount: _pages.length,
              onPageChanged: (i) => setState(() => _currentPage = i),
              itemBuilder: (_, i) => _OnboardingPageView(page: _pages[i]),
            ),

            // Skip button
            Positioned(
              top: MediaQuery.of(context).padding.top + 16,
              right: 20,
              child: AnimatedOpacity(
                opacity: _currentPage < _pages.length - 1 ? 1.0 : 0.0,
                duration: const Duration(milliseconds: 300),
                child: GestureDetector(
                  onTap: _completeOnboarding,
                  child: Container(
                    padding:
                        const EdgeInsets.symmetric(horizontal: 16, vertical: 8),
                    decoration: BoxDecoration(
                      color: Colors.white.withOpacity(0.2),
                      borderRadius: BorderRadius.circular(20),
                      border: Border.all(
                          color: Colors.white.withOpacity(0.4), width: 1),
                    ),
                    child: Text(
                      'Ruka',
                      style: GoogleFonts.nunito(
                        color: Colors.white,
                        fontSize: 13,
                        fontWeight: FontWeight.w700,
                      ),
                    ),
                  ),
                ),
              ),
            ),

            // Bottom controls
            Positioned(
              bottom: 0,
              left: 0,
              right: 0,
              child: Container(
                padding: EdgeInsets.fromLTRB(
                    28, 20, 28, MediaQuery.of(context).padding.bottom + 28),
                child: Row(
                  mainAxisAlignment: MainAxisAlignment.spaceBetween,
                  children: [
                    // Page indicator dots
                    SmoothPageIndicator(
                      controller: _pageController,
                      count: _pages.length,
                      effect: ExpandingDotsEffect(
                        activeDotColor: AppColors.gold,
                        dotColor: Colors.white.withOpacity(0.4),
                        dotHeight: 8,
                        dotWidth: 8,
                        expansionFactor: 3.5,
                        spacing: 6,
                      ),
                    ),

                    // Next / Get Started button
                    GestureDetector(
                      onTap: _nextPage,
                      child: AnimatedContainer(
                        duration: const Duration(milliseconds: 300),
                        height: 56,
                        width: _currentPage == _pages.length - 1 ? 180 : 56,
                        decoration: BoxDecoration(
                          color: AppColors.gold,
                          borderRadius: BorderRadius.circular(28),
                          boxShadow: [
                            BoxShadow(
                              color: AppColors.gold.withOpacity(0.4),
                              blurRadius: 16,
                              offset: const Offset(0, 6),
                            ),
                          ],
                        ),
                        child: Center(
                          child: _currentPage == _pages.length - 1
                              ? Row(
                                  mainAxisAlignment: MainAxisAlignment.center,
                                  children: [
                                    Text(
                                      'Anza Sasa',
                                      style: GoogleFonts.nunito(
                                        color: AppColors.emeraldDark,
                                        fontWeight: FontWeight.w900,
                                        fontSize: 15,
                                      ),
                                    ),
                                    const SizedBox(width: 8),
                                    const Icon(
                                      Icons.arrow_forward_rounded,
                                      color: AppColors.emeraldDark,
                                      size: 20,
                                    ),
                                  ],
                                )
                              : const Icon(
                                  Icons.arrow_forward_rounded,
                                  color: AppColors.emeraldDark,
                                  size: 24,
                                ),
                        ),
                      ),
                    ),
                  ],
                ),
              ),
            ),
          ],
        ),
      ),
    );
  }
}

class _OnboardingPage {
  final String title;
  final String subtitle;
  final String description;
  final List<Color> gradient;
  final IconData iconData;
  final Color accentColor;
  final Color decorationColor;
  final List<String> features;

  const _OnboardingPage({
    required this.title,
    required this.subtitle,
    required this.description,
    required this.gradient,
    required this.iconData,
    required this.accentColor,
    required this.decorationColor,
    required this.features,
  });
}

class _OnboardingPageView extends StatelessWidget {
  final _OnboardingPage page;

  const _OnboardingPageView({required this.page});

  @override
  Widget build(BuildContext context) {
    final size = MediaQuery.of(context).size;

    return Container(
      decoration: BoxDecoration(
        gradient: LinearGradient(
          begin: Alignment.topLeft,
          end: Alignment.bottomRight,
          colors: page.gradient,
        ),
      ),
      child: Stack(
        children: [
          // Background decorative circles
          Positioned(
            top: -size.width * 0.3,
            right: -size.width * 0.2,
            child: Container(
              width: size.width * 0.75,
              height: size.width * 0.75,
              decoration: BoxDecoration(
                shape: BoxShape.circle,
                color: Colors.white.withOpacity(0.05),
              ),
            ),
          ),
          Positioned(
            bottom: size.height * 0.12,
            left: -size.width * 0.25,
            child: Container(
              width: size.width * 0.6,
              height: size.width * 0.6,
              decoration: BoxDecoration(
                shape: BoxShape.circle,
                color: Colors.white.withOpacity(0.04),
              ),
            ),
          ),

          // Main content
          SafeArea(
            child: Padding(
              padding: const EdgeInsets.symmetric(horizontal: 28),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  SizedBox(height: size.height * 0.06),

                  // Illustration card
                  Center(
                    child: Container(
                      width: size.width * 0.72,
                      height: size.width * 0.72,
                      decoration: BoxDecoration(
                        borderRadius: BorderRadius.circular(36),
                        color: Colors.white.withOpacity(0.1),
                        border: Border.all(
                          color: Colors.white.withOpacity(0.15),
                          width: 1.5,
                        ),
                      ),
                      child: Stack(
                        alignment: Alignment.center,
                        children: [
                          // Inner glow
                          Container(
                            width: size.width * 0.45,
                            height: size.width * 0.45,
                            decoration: BoxDecoration(
                              shape: BoxShape.circle,
                              color: page.accentColor.withOpacity(0.15),
                            ),
                          ),
                          // Icon
                          Icon(
                            page.iconData,
                            size: size.width * 0.25,
                            color: page.accentColor,
                          ),
                          // Floating chips
                          ..._buildFloatingChips(size),
                        ],
                      ),
                    ),
                  ),

                  SizedBox(height: size.height * 0.05),

                  // Title
                  Text(
                    page.title,
                    style: GoogleFonts.nunito(
                      fontSize: 32,
                      fontWeight: FontWeight.w900,
                      color: Colors.white,
                      height: 1.1,
                    ),
                  ),
                  const SizedBox(height: 6),
                  Text(
                    page.subtitle,
                    style: GoogleFonts.nunito(
                      fontSize: 16,
                      fontWeight: FontWeight.w700,
                      color: page.accentColor,
                    ),
                  ),
                  const SizedBox(height: 16),
                  Text(
                    page.description,
                    style: GoogleFonts.nunito(
                      fontSize: 14,
                      fontWeight: FontWeight.w500,
                      color: Colors.white.withOpacity(0.75),
                      height: 1.6,
                    ),
                  ),

                  SizedBox(height: size.height * 0.04),

                  // Feature chips
                  Wrap(
                    spacing: 10,
                    runSpacing: 10,
                    children: page.features
                        .map((f) => _FeatureChip(label: f, color: page.accentColor))
                        .toList(),
                  ),
                ],
              ),
            ),
          ),
        ],
      ),
    );
  }

  List<Widget> _buildFloatingChips(Size size) {
    final positions = [
      Offset(size.width * 0.05, size.width * 0.08),
      Offset(size.width * 0.38, size.width * 0.02),
      Offset(size.width * 0.05, size.width * 0.44),
    ];
    final icons = [Icons.check_circle_outline, Icons.bolt_rounded, Icons.star_rounded];

    return List.generate(3, (i) {
      return Positioned(
        left: positions[i].dx,
        top: positions[i].dy,
        child: Container(
          padding: const EdgeInsets.all(8),
          decoration: BoxDecoration(
            color: Colors.white.withOpacity(0.18),
            borderRadius: BorderRadius.circular(12),
          ),
          child: Icon(icons[i], color: page.accentColor, size: 18),
        ),
      );
    });
  }
}

class _FeatureChip extends StatelessWidget {
  final String label;
  final Color color;

  const _FeatureChip({required this.label, required this.color});

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.symmetric(horizontal: 14, vertical: 8),
      decoration: BoxDecoration(
        color: Colors.white.withOpacity(0.12),
        borderRadius: BorderRadius.circular(20),
        border: Border.all(color: Colors.white.withOpacity(0.2), width: 1),
      ),
      child: Row(
        mainAxisSize: MainAxisSize.min,
        children: [
          Icon(Icons.check_circle_rounded, color: color, size: 14),
          const SizedBox(width: 6),
          Text(
            label,
            style: GoogleFonts.nunito(
              color: Colors.white,
              fontSize: 12,
              fontWeight: FontWeight.w700,
            ),
          ),
        ],
      ),
    );
  }
}
