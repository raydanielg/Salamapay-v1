import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';
import '../theme/app_theme.dart';

class CustomTextField extends StatefulWidget {
  final String label;
  final String? hint;
  final TextEditingController? controller;
  final bool obscure;
  final TextInputType keyboardType;
  final IconData? prefixIcon;
  final String? Function(String?)? validator;
  final TextInputAction textInputAction;
  final VoidCallback? onEditingComplete;
  final bool enabled;
  final int maxLines;

  const CustomTextField({
    super.key,
    required this.label,
    this.hint,
    this.controller,
    this.obscure = false,
    this.keyboardType = TextInputType.text,
    this.prefixIcon,
    this.validator,
    this.textInputAction = TextInputAction.next,
    this.onEditingComplete,
    this.enabled = true,
    this.maxLines = 1,
  });

  @override
  State<CustomTextField> createState() => _CustomTextFieldState();
}

class _CustomTextFieldState extends State<CustomTextField> {
  bool _obscure = true;
  bool _focused = false;

  @override
  void initState() {
    super.initState();
    _obscure = widget.obscure;
  }

  @override
  Widget build(BuildContext context) {
    return Focus(
      onFocusChange: (v) => setState(() => _focused = v),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Text(
            widget.label,
            style: GoogleFonts.nunito(
              fontSize: 12,
              fontWeight: FontWeight.w700,
              color: _focused ? AppColors.emeraldPrimary : AppColors.grey700,
              letterSpacing: 0.3,
            ),
          ),
          const SizedBox(height: 6),
          TextFormField(
            controller: widget.controller,
            obscureText: widget.obscure ? _obscure : false,
            keyboardType: widget.keyboardType,
            validator: widget.validator,
            textInputAction: widget.textInputAction,
            onEditingComplete: widget.onEditingComplete,
            enabled: widget.enabled,
            maxLines: widget.obscure ? 1 : widget.maxLines,
            style: GoogleFonts.nunito(
              fontSize: 14,
              fontWeight: FontWeight.w600,
              color: AppColors.emeraldDark,
            ),
            decoration: InputDecoration(
              hintText: widget.hint,
              hintStyle: GoogleFonts.nunito(
                fontSize: 13,
                color: AppColors.grey400,
                fontWeight: FontWeight.w500,
              ),
              prefixIcon: widget.prefixIcon != null
                  ? Icon(widget.prefixIcon,
                      size: 18,
                      color: _focused
                          ? AppColors.emeraldPrimary
                          : AppColors.grey400)
                  : null,
              suffixIcon: widget.obscure
                  ? IconButton(
                      icon: Icon(
                        _obscure
                            ? Icons.visibility_off_outlined
                            : Icons.visibility_outlined,
                        size: 18,
                        color: AppColors.grey400,
                      ),
                      onPressed: () => setState(() => _obscure = !_obscure),
                    )
                  : null,
              filled: true,
              fillColor: _focused
                  ? AppColors.emeraldPrimary.withOpacity(0.03)
                  : AppColors.grey100,
              contentPadding:
                  const EdgeInsets.symmetric(horizontal: 16, vertical: 14),
              border: OutlineInputBorder(
                borderRadius: BorderRadius.circular(14),
                borderSide: BorderSide.none,
              ),
              enabledBorder: OutlineInputBorder(
                borderRadius: BorderRadius.circular(14),
                borderSide: BorderSide(
                    color: AppColors.grey400.withOpacity(0.2), width: 1),
              ),
              focusedBorder: OutlineInputBorder(
                borderRadius: BorderRadius.circular(14),
                borderSide:
                    const BorderSide(color: AppColors.emeraldPrimary, width: 1.5),
              ),
              errorBorder: OutlineInputBorder(
                borderRadius: BorderRadius.circular(14),
                borderSide: const BorderSide(color: Colors.red, width: 1),
              ),
              focusedErrorBorder: OutlineInputBorder(
                borderRadius: BorderRadius.circular(14),
                borderSide: const BorderSide(color: Colors.red, width: 1.5),
              ),
            ),
          ),
        ],
      ),
    );
  }
}
