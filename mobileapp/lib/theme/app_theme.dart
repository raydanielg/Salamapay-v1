import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:google_fonts/google_fonts.dart';

class AppColors {
  // Emerald palette — matches web exactly
  static const Color emeraldDark    = Color(0xFF065F46); // emerald-800
  static const Color emeraldPrimary = Color(0xFF059669); // emerald-600
  static const Color emeraldMedium  = Color(0xFF10B981); // emerald-500
  static const Color emeraldLight   = Color(0xFFD1FAE5); // emerald-100

  // Gold palette — matches web gold
  static const Color gold      = Color(0xFFFFCC33); // gold-300
  static const Color goldDark  = Color(0xFFE5AC00); // gold-400
  static const Color goldLight = Color(0xFFFFF8E1);

  // Neutrals
  static const Color white    = Color(0xFFFFFFFF);
  static const Color cream    = Color(0xFFFFF8E8);
  static const Color grey50   = Color(0xFFF9FAFB);
  static const Color grey100  = Color(0xFFF3F4F6);
  static const Color grey200  = Color(0xFFE5E7EB);
  static const Color grey400  = Color(0xFF9CA3AF);
  static const Color grey700  = Color(0xFF374151);
  static const Color grey900  = Color(0xFF111827);

  // Semantic
  static const Color error   = Color(0xFFDC2626);
  static const Color errorBg = Color(0xFFFEF2F2);
  static const Color success = Color(0xFF059669);
  static const Color successBg = Color(0xFFECFDF5);
  static const Color warning = Color(0xFFD97706);
  static const Color warningBg = Color(0xFFFFFBEB);
}

class AppTheme {
  static ThemeData get theme {
    final base = ThemeData(useMaterial3: true);

    return ThemeData(
      useMaterial3: true,
      fontFamily: GoogleFonts.nunito().fontFamily,

      colorScheme: ColorScheme.fromSeed(
        seedColor: AppColors.emeraldPrimary,
        primary: AppColors.emeraldPrimary,
        secondary: AppColors.gold,
        error: AppColors.error,
        surface: AppColors.white,
        onPrimary: Colors.white,
        onSecondary: AppColors.emeraldDark,
      ),

      scaffoldBackgroundColor: AppColors.grey100,

      // ── AppBar ────────────────────────────────────────────────
      appBarTheme: AppBarTheme(
        backgroundColor: AppColors.emeraldPrimary,
        foregroundColor: Colors.white,
        elevation: 0,
        centerTitle: true,
        systemOverlayStyle: const SystemUiOverlayStyle(
          statusBarColor: Colors.transparent,
          statusBarIconBrightness: Brightness.light,
        ),
        titleTextStyle: GoogleFonts.nunito(
          color: Colors.white,
          fontSize: 18,
          fontWeight: FontWeight.w800,
        ),
      ),

      // ── Input Decoration (global) ─────────────────────────────
      inputDecorationTheme: InputDecorationTheme(
        filled: true,
        fillColor: AppColors.white,
        hintStyle: GoogleFonts.nunito(
          color: AppColors.grey400,
          fontSize: 13,
          fontWeight: FontWeight.w500,
        ),
        labelStyle: GoogleFonts.nunito(
          color: AppColors.grey700,
          fontSize: 13,
          fontWeight: FontWeight.w600,
        ),
        floatingLabelStyle: GoogleFonts.nunito(
          color: AppColors.emeraldPrimary,
          fontSize: 13,
          fontWeight: FontWeight.w700,
        ),
        contentPadding: const EdgeInsets.symmetric(horizontal: 14, vertical: 13),
        enabledBorder: OutlineInputBorder(
          borderRadius: BorderRadius.circular(10),
          borderSide: const BorderSide(color: AppColors.grey200, width: 1),
        ),
        focusedBorder: OutlineInputBorder(
          borderRadius: BorderRadius.circular(10),
          borderSide: const BorderSide(color: AppColors.emeraldPrimary, width: 1.5),
        ),
        errorBorder: OutlineInputBorder(
          borderRadius: BorderRadius.circular(10),
          borderSide: const BorderSide(color: Color(0xFFFCA5A5), width: 1),
        ),
        focusedErrorBorder: OutlineInputBorder(
          borderRadius: BorderRadius.circular(10),
          borderSide: const BorderSide(color: AppColors.error, width: 1.5),
        ),
        errorStyle: GoogleFonts.nunito(
          color: AppColors.error,
          fontSize: 11,
          fontWeight: FontWeight.w600,
        ),
        prefixIconColor: AppColors.grey400,
        suffixIconColor: AppColors.grey400,
      ),

      // ── Elevated Button ───────────────────────────────────────
      elevatedButtonTheme: ElevatedButtonThemeData(
        style: ElevatedButton.styleFrom(
          backgroundColor: AppColors.emeraldPrimary,
          foregroundColor: Colors.white,
          elevation: 0,
          shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
          padding: const EdgeInsets.symmetric(horizontal: 20, vertical: 14),
          textStyle: GoogleFonts.nunito(
            fontSize: 14,
            fontWeight: FontWeight.w800,
          ),
        ),
      ),

      // ── Text Button ───────────────────────────────────────────
      textButtonTheme: TextButtonThemeData(
        style: TextButton.styleFrom(
          foregroundColor: AppColors.emeraldPrimary,
          textStyle: GoogleFonts.nunito(
            fontSize: 13,
            fontWeight: FontWeight.w700,
          ),
        ),
      ),

      // ── Dialog ───────────────────────────────────────────────
      dialogTheme: DialogThemeData(
        backgroundColor: AppColors.white,
        elevation: 0,
        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(20)),
        titleTextStyle: GoogleFonts.nunito(
          color: AppColors.grey900,
          fontSize: 17,
          fontWeight: FontWeight.w900,
        ),
        contentTextStyle: GoogleFonts.nunito(
          color: AppColors.grey700,
          fontSize: 13,
          fontWeight: FontWeight.w500,
        ),
      ),

      // ── SnackBar ──────────────────────────────────────────────
      snackBarTheme: SnackBarThemeData(
        behavior: SnackBarBehavior.floating,
        backgroundColor: AppColors.grey900,
        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
        contentTextStyle: GoogleFonts.nunito(
          color: Colors.white,
          fontSize: 13,
          fontWeight: FontWeight.w600,
        ),
        elevation: 4,
      ),

      // ── Card ─────────────────────────────────────────────────
      cardTheme: CardThemeData(
        color: AppColors.white,
        elevation: 0,
        shape: RoundedRectangleBorder(
          borderRadius: BorderRadius.circular(16),
          side: const BorderSide(color: AppColors.grey200, width: 0.5),
        ),
        margin: EdgeInsets.zero,
      ),

      // ── Chip ─────────────────────────────────────────────────
      chipTheme: ChipThemeData(
        backgroundColor: AppColors.grey100,
        selectedColor: AppColors.emeraldLight,
        labelStyle: GoogleFonts.nunito(fontSize: 12, fontWeight: FontWeight.w700),
        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(20)),
        side: BorderSide.none,
      ),

      // ── Divider ───────────────────────────────────────────────
      dividerTheme: const DividerThemeData(
        color: AppColors.grey200,
        thickness: 1,
        space: 1,
      ),

      // ── Text Theme ────────────────────────────────────────────
      textTheme: GoogleFonts.nunitoTextTheme(base.textTheme).apply(
        bodyColor: AppColors.grey900,
        displayColor: AppColors.grey900,
      ),

      // ── Bottom Nav Bar ────────────────────────────────────────
      bottomNavigationBarTheme: const BottomNavigationBarThemeData(
        backgroundColor: AppColors.white,
        selectedItemColor: AppColors.emeraldPrimary,
        unselectedItemColor: AppColors.grey400,
        elevation: 0,
        type: BottomNavigationBarType.fixed,
      ),
    );
  }
}
