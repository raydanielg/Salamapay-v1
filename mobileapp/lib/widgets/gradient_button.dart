import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';
import '../theme/app_theme.dart';

class GradientButton extends StatelessWidget {
  final String label;
  final VoidCallback? onPressed;
  final bool isLoading;
  final List<Color>? colors;
  final double height;
  final Widget? icon;

  const GradientButton({
    super.key,
    required this.label,
    this.onPressed,
    this.isLoading = false,
    this.colors,
    this.height = 54,
    this.icon,
  });

  @override
  Widget build(BuildContext context) {
    final gradColors = colors ?? [AppColors.emeraldMedium, AppColors.emeraldDark];

    return GestureDetector(
      onTap: isLoading ? null : onPressed,
      child: AnimatedContainer(
        duration: const Duration(milliseconds: 150),
        height: height,
        decoration: BoxDecoration(
          gradient: LinearGradient(colors: gradColors),
          borderRadius: BorderRadius.circular(16),
          boxShadow: onPressed != null
              ? [
                  BoxShadow(
                    color: gradColors.last.withOpacity(0.35),
                    blurRadius: 16,
                    offset: const Offset(0, 6),
                  )
                ]
              : [],
        ),
        child: Center(
          child: isLoading
              ? const SizedBox(
                  width: 22,
                  height: 22,
                  child: CircularProgressIndicator(
                      color: Colors.white, strokeWidth: 2.5),
                )
              : Row(
                  mainAxisAlignment: MainAxisAlignment.center,
                  children: [
                    if (icon != null) ...[icon!, const SizedBox(width: 8)],
                    Text(
                      label,
                      style: GoogleFonts.nunito(
                        color: Colors.white,
                        fontSize: 15,
                        fontWeight: FontWeight.w800,
                        letterSpacing: 0.3,
                      ),
                    ),
                  ],
                ),
        ),
      ),
    );
  }
}

class GoldButton extends StatelessWidget {
  final String label;
  final VoidCallback? onPressed;
  final bool isLoading;

  const GoldButton({
    super.key,
    required this.label,
    this.onPressed,
    this.isLoading = false,
  });

  @override
  Widget build(BuildContext context) {
    return GradientButton(
      label: label,
      onPressed: onPressed,
      isLoading: isLoading,
      colors: [AppColors.gold, const Color(0xFFE09800)],
    );
  }
}
