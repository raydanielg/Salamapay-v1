import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';
import '../theme/app_theme.dart';

class SalamaPayLogo extends StatelessWidget {
  final double size;
  final bool dark;

  const SalamaPayLogo({super.key, this.size = 1.0, this.dark = false});

  @override
  Widget build(BuildContext context) {
    final Color primary = dark ? AppColors.white : AppColors.emeraldPrimary;
    final Color accent = AppColors.gold;

    return Column(
      mainAxisSize: MainAxisSize.min,
      children: [
        Row(
          mainAxisSize: MainAxisSize.min,
          crossAxisAlignment: CrossAxisAlignment.center,
          children: [
            // "7" swoosh icon
            CustomPaint(
              size: Size(52 * size, 52 * size),
              painter: _SevenSwooshPainter(
                primary: primary,
                accent: accent,
              ),
            ),
            SizedBox(width: 6 * size),
            Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              mainAxisSize: MainAxisSize.min,
              children: [
                // "Pay" superscript
                Transform.translate(
                  offset: Offset(0, -2 * size),
                  child: Text(
                    'Pay',
                    style: GoogleFonts.nunito(
                      fontSize: 13 * size,
                      fontWeight: FontWeight.w700,
                      color: accent,
                      height: 1,
                    ),
                  ),
                ),
                // "Salama" main text
                Text(
                  'Salama',
                  style: GoogleFonts.nunito(
                    fontSize: 34 * size,
                    fontWeight: FontWeight.w900,
                    color: primary,
                    height: 0.85,
                    letterSpacing: -0.5,
                  ),
                ),
              ],
            ),
          ],
        ),
        // Underline swoosh
        SizedBox(height: 4 * size),
        CustomPaint(
          size: Size(140 * size, 8 * size),
          painter: _UnderlineSwooshPainter(color: primary),
        ),
      ],
    );
  }
}

class _SevenSwooshPainter extends CustomPainter {
  final Color primary;
  final Color accent;

  _SevenSwooshPainter({required this.primary, required this.accent});

  @override
  void paint(Canvas canvas, Size size) {
    final paintPrimary = Paint()
      ..color = primary
      ..style = PaintingStyle.stroke
      ..strokeWidth = size.width * 0.1
      ..strokeCap = StrokeCap.round;

    final paintAccent = Paint()
      ..color = accent
      ..style = PaintingStyle.stroke
      ..strokeWidth = size.width * 0.07
      ..strokeCap = StrokeCap.round;

    // Outer arc (green)
    final path1 = Path();
    path1.moveTo(size.width * 0.1, size.height * 0.1);
    path1.cubicTo(
      size.width * 0.5, -size.height * 0.05,
      size.width * 1.1, size.height * 0.3,
      size.width * 0.9, size.height * 0.85,
    );
    canvas.drawPath(path1, paintPrimary);

    // Inner slash (gold)
    final path2 = Path();
    path2.moveTo(size.width * 0.35, size.height * 0.2);
    path2.cubicTo(
      size.width * 0.55, size.height * 0.15,
      size.width * 0.8, size.height * 0.35,
      size.width * 0.65, size.height * 0.8,
    );
    canvas.drawPath(path2, paintAccent);
  }

  @override
  bool shouldRepaint(covariant CustomPainter oldDelegate) => false;
}

class _UnderlineSwooshPainter extends CustomPainter {
  final Color color;

  _UnderlineSwooshPainter({required this.color});

  @override
  void paint(Canvas canvas, Size size) {
    final paint = Paint()
      ..color = color.withOpacity(0.3)
      ..style = PaintingStyle.stroke
      ..strokeWidth = size.height * 0.5
      ..strokeCap = StrokeCap.round;

    final path = Path();
    path.moveTo(0, size.height * 0.5);
    path.cubicTo(
      size.width * 0.25, 0,
      size.width * 0.75, size.height,
      size.width, size.height * 0.3,
    );
    canvas.drawPath(path, paint);
  }

  @override
  bool shouldRepaint(covariant CustomPainter oldDelegate) => false;
}
