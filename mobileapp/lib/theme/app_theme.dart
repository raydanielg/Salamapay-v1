import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';

class AppColors {
  static const Color emeraldDark = Color(0xFF013028);
  static const Color emeraldPrimary = Color(0xFF024938);
  static const Color emeraldMedium = Color(0xFF035E48);
  static const Color emeraldLight = Color(0xFF1a9f8e);
  static const Color gold = Color(0xFFF9AC00);
  static const Color goldLight = Color(0xFFFFD166);
  static const Color cream = Color(0xFFFFF8E8);
  static const Color white = Color(0xFFFFFFFF);
  static const Color grey100 = Color(0xFFF5F5F5);
  static const Color grey400 = Color(0xFF9E9E9E);
  static const Color grey700 = Color(0xFF616161);
}

class AppTheme {
  static ThemeData get theme {
    return ThemeData(
      useMaterial3: true,
      colorScheme: ColorScheme.fromSeed(
        seedColor: AppColors.emeraldPrimary,
        primary: AppColors.emeraldPrimary,
        secondary: AppColors.gold,
        surface: AppColors.white,
      ),
      textTheme: GoogleFonts.nunitoTextTheme(),
      scaffoldBackgroundColor: AppColors.white,
    );
  }
}
