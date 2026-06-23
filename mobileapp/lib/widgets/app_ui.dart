import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';
import '../theme/app_theme.dart';

// ─── Global Snackbar Helpers ──────────────────────────────────────────────────

class AppSnack {
  static void success(BuildContext context, String message) =>
      _show(context, message, AppColors.success, Icons.check_circle_rounded);

  static void error(BuildContext context, String message) =>
      _show(context, message, AppColors.error, Icons.error_outline_rounded);

  static void warning(BuildContext context, String message) =>
      _show(context, message, AppColors.warning, Icons.warning_amber_rounded);

  static void info(BuildContext context, String message) =>
      _show(context, message, AppColors.emeraldPrimary, Icons.info_outline_rounded);

  static void _show(
      BuildContext context, String message, Color color, IconData icon) {
    ScaffoldMessenger.of(context)
      ..clearSnackBars()
      ..showSnackBar(
        SnackBar(
          behavior: SnackBarBehavior.floating,
          margin: const EdgeInsets.fromLTRB(16, 0, 16, 16),
          padding: EdgeInsets.zero,
          backgroundColor: Colors.transparent,
          elevation: 0,
          duration: const Duration(seconds: 3),
          content: Container(
            padding: const EdgeInsets.symmetric(horizontal: 14, vertical: 12),
            decoration: BoxDecoration(
              color: color,
              borderRadius: BorderRadius.circular(14),
              boxShadow: [
                BoxShadow(
                  color: color.withOpacity(0.3),
                  blurRadius: 12,
                  offset: const Offset(0, 4),
                ),
              ],
            ),
            child: Row(
              children: [
                Icon(icon, color: Colors.white, size: 20),
                const SizedBox(width: 10),
                Expanded(
                  child: Text(
                    message,
                    style: GoogleFonts.nunito(
                      color: Colors.white,
                      fontSize: 13,
                      fontWeight: FontWeight.w700,
                    ),
                  ),
                ),
              ],
            ),
          ),
        ),
      );
  }
}

// ─── Global Dialog Helpers ───────────────────────────────────────────────────

class AppDialog {
  /// Confirmation dialog — returns true if confirmed
  static Future<bool> confirm(
    BuildContext context, {
    required String title,
    required String message,
    String confirmLabel = 'Thibitisha',
    String cancelLabel = 'Ghairi',
    Color confirmColor = AppColors.emeraldPrimary,
    bool destructive = false,
  }) async {
    final result = await showDialog<bool>(
      context: context,
      barrierColor: Colors.black.withOpacity(0.4),
      builder: (_) => _AppDialog(
        title: title,
        message: message,
        confirmLabel: confirmLabel,
        cancelLabel: cancelLabel,
        confirmColor: destructive ? AppColors.error : confirmColor,
        icon: destructive
            ? Icons.delete_outline_rounded
            : Icons.check_circle_outline_rounded,
        iconColor: destructive ? AppColors.error : confirmColor,
      ),
    );
    return result ?? false;
  }

  /// Simple info/alert dialog
  static Future<void> alert(
    BuildContext context, {
    required String title,
    required String message,
    String label = 'Sawa',
  }) async {
    await showDialog<void>(
      context: context,
      barrierColor: Colors.black.withOpacity(0.4),
      builder: (_) => AlertDialog(
        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(20)),
        backgroundColor: AppColors.white,
        title: Text(title,
            style: GoogleFonts.nunito(
                fontWeight: FontWeight.w900, fontSize: 16, color: AppColors.grey900)),
        content: Text(message,
            style: GoogleFonts.nunito(fontSize: 13, color: AppColors.grey700)),
        actions: [
          ElevatedButton(
            onPressed: () => Navigator.pop(context),
            style: ElevatedButton.styleFrom(
              backgroundColor: AppColors.emeraldPrimary,
              shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10)),
            ),
            child: Text(label,
                style: GoogleFonts.nunito(
                    color: Colors.white, fontWeight: FontWeight.w800)),
          ),
        ],
      ),
    );
  }
}

class _AppDialog extends StatelessWidget {
  final String title;
  final String message;
  final String confirmLabel;
  final String cancelLabel;
  final Color confirmColor;
  final IconData icon;
  final Color iconColor;

  const _AppDialog({
    required this.title,
    required this.message,
    required this.confirmLabel,
    required this.cancelLabel,
    required this.confirmColor,
    required this.icon,
    required this.iconColor,
  });

  @override
  Widget build(BuildContext context) {
    return Dialog(
      backgroundColor: AppColors.white,
      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(24)),
      child: Padding(
        padding: const EdgeInsets.all(24),
        child: Column(
          mainAxisSize: MainAxisSize.min,
          children: [
            Container(
              width: 56,
              height: 56,
              decoration: BoxDecoration(
                color: iconColor.withOpacity(0.1),
                shape: BoxShape.circle,
              ),
              child: Icon(icon, color: iconColor, size: 28),
            ),
            const SizedBox(height: 16),
            Text(
              title,
              style: GoogleFonts.nunito(
                fontSize: 17,
                fontWeight: FontWeight.w900,
                color: AppColors.grey900,
              ),
              textAlign: TextAlign.center,
            ),
            const SizedBox(height: 8),
            Text(
              message,
              style: GoogleFonts.nunito(
                fontSize: 13,
                color: AppColors.grey700,
                fontWeight: FontWeight.w500,
              ),
              textAlign: TextAlign.center,
            ),
            const SizedBox(height: 24),
            Row(
              children: [
                Expanded(
                  child: OutlinedButton(
                    onPressed: () => Navigator.pop(context, false),
                    style: OutlinedButton.styleFrom(
                      foregroundColor: AppColors.grey700,
                      side: const BorderSide(color: AppColors.grey200),
                      shape: RoundedRectangleBorder(
                          borderRadius: BorderRadius.circular(12)),
                      padding: const EdgeInsets.symmetric(vertical: 13),
                    ),
                    child: Text(cancelLabel,
                        style: GoogleFonts.nunito(
                            fontWeight: FontWeight.w700, fontSize: 13)),
                  ),
                ),
                const SizedBox(width: 12),
                Expanded(
                  child: ElevatedButton(
                    onPressed: () => Navigator.pop(context, true),
                    style: ElevatedButton.styleFrom(
                      backgroundColor: confirmColor,
                      shape: RoundedRectangleBorder(
                          borderRadius: BorderRadius.circular(12)),
                      elevation: 0,
                      padding: const EdgeInsets.symmetric(vertical: 13),
                    ),
                    child: Text(confirmLabel,
                        style: GoogleFonts.nunito(
                            color: Colors.white,
                            fontWeight: FontWeight.w800,
                            fontSize: 13)),
                  ),
                ),
              ],
            ),
          ],
        ),
      ),
    );
  }
}

// ─── Gold Action Button (matches web's gold CTA) ─────────────────────────────

class GoldButton extends StatelessWidget {
  final String label;
  final VoidCallback? onPressed;
  final bool isLoading;
  final IconData? icon;
  final double height;

  const GoldButton({
    super.key,
    required this.label,
    this.onPressed,
    this.isLoading = false,
    this.icon,
    this.height = 50,
  });

  @override
  Widget build(BuildContext context) {
    return GestureDetector(
      onTap: isLoading ? null : onPressed,
      child: AnimatedContainer(
        duration: const Duration(milliseconds: 150),
        width: double.infinity,
        height: height,
        decoration: BoxDecoration(
          gradient: const LinearGradient(
            colors: [AppColors.gold, AppColors.goldDark],
          ),
          borderRadius: BorderRadius.circular(12),
          boxShadow: onPressed != null
              ? [
                  BoxShadow(
                    color: AppColors.goldDark.withOpacity(0.35),
                    blurRadius: 12,
                    offset: const Offset(0, 4),
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
                    strokeWidth: 2.5,
                    color: AppColors.emeraldDark,
                  ),
                )
              : Row(
                  mainAxisAlignment: MainAxisAlignment.center,
                  children: [
                    if (icon != null) ...[
                      Icon(icon, color: AppColors.emeraldDark, size: 18),
                      const SizedBox(width: 8),
                    ],
                    Text(
                      label,
                      style: GoogleFonts.nunito(
                        color: AppColors.emeraldDark,
                        fontSize: 15,
                        fontWeight: FontWeight.w900,
                      ),
                    ),
                  ],
                ),
        ),
      ),
    );
  }
}

// ─── Emerald Button ───────────────────────────────────────────────────────────

class EmeraldButton extends StatelessWidget {
  final String label;
  final VoidCallback? onPressed;
  final bool isLoading;
  final IconData? icon;
  final double height;

  const EmeraldButton({
    super.key,
    required this.label,
    this.onPressed,
    this.isLoading = false,
    this.icon,
    this.height = 50,
  });

  @override
  Widget build(BuildContext context) {
    return GestureDetector(
      onTap: isLoading ? null : onPressed,
      child: Container(
        width: double.infinity,
        height: height,
        decoration: BoxDecoration(
          gradient: const LinearGradient(
            begin: Alignment.topLeft,
            end: Alignment.bottomRight,
            colors: [AppColors.emeraldPrimary, AppColors.emeraldDark],
          ),
          borderRadius: BorderRadius.circular(12),
          boxShadow: [
            BoxShadow(
              color: AppColors.emeraldPrimary.withOpacity(0.3),
              blurRadius: 12,
              offset: const Offset(0, 4),
            )
          ],
        ),
        child: Center(
          child: isLoading
              ? const SizedBox(
                  width: 22,
                  height: 22,
                  child: CircularProgressIndicator(
                    strokeWidth: 2.5,
                    color: Colors.white,
                  ),
                )
              : Row(
                  mainAxisAlignment: MainAxisAlignment.center,
                  children: [
                    if (icon != null) ...[
                      Icon(icon, color: Colors.white, size: 18),
                      const SizedBox(width: 8),
                    ],
                    Text(
                      label,
                      style: GoogleFonts.nunito(
                        color: Colors.white,
                        fontSize: 15,
                        fontWeight: FontWeight.w900,
                      ),
                    ),
                  ],
                ),
        ),
      ),
    );
  }
}
