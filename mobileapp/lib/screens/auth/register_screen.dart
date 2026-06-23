import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:google_fonts/google_fonts.dart';
import '../../services/auth_service.dart';
import '../../services/api_service.dart';
import '../../theme/app_theme.dart';
import '../main_screen.dart';

class RegisterScreen extends StatefulWidget {
  const RegisterScreen({super.key});

  @override
  State<RegisterScreen> createState() => _RegisterScreenState();
}

class _RegisterScreenState extends State<RegisterScreen> {
  final _formKey = GlobalKey<FormState>();
  final _firstNameCtrl = TextEditingController();
  final _lastNameCtrl = TextEditingController();
  final _businessCtrl = TextEditingController();
  final _emailCtrl = TextEditingController();
  final _phoneCtrl = TextEditingController();
  final _passwordCtrl = TextEditingController();
  final _confirmCtrl = TextEditingController();

  bool _loading = false;
  bool _acceptTerms = false;
  String? _error;

  @override
  void initState() {
    super.initState();
    SystemChrome.setSystemUIOverlayStyle(const SystemUiOverlayStyle(
      statusBarColor: Colors.transparent,
      statusBarIconBrightness: Brightness.light,
    ));
  }

  @override
  void dispose() {
    _firstNameCtrl.dispose();
    _lastNameCtrl.dispose();
    _businessCtrl.dispose();
    _emailCtrl.dispose();
    _phoneCtrl.dispose();
    _passwordCtrl.dispose();
    _confirmCtrl.dispose();
    super.dispose();
  }

  Future<void> _register() async {
    if (!_formKey.currentState!.validate()) return;
    if (!_acceptTerms) {
      setState(() => _error = 'Tafadhali kubali masharti ya matumizi');
      return;
    }
    setState(() {
      _loading = true;
      _error = null;
    });
    try {
      await AuthService.register(
        firstName: _firstNameCtrl.text.trim(),
        lastName: _lastNameCtrl.text.trim(),
        email: _emailCtrl.text.trim(),
        phone: _phoneCtrl.text.trim(),
        password: _passwordCtrl.text,
        passwordConfirmation: _confirmCtrl.text,
        businessName: _businessCtrl.text.trim().isNotEmpty
            ? _businessCtrl.text.trim()
            : null,
      );
      if (!mounted) return;
      Navigator.of(context).pushAndRemoveUntil(
        PageRouteBuilder(
          pageBuilder: (_, __, ___) => const MainScreen(),
          transitionDuration: const Duration(milliseconds: 500),
          transitionsBuilder: (_, anim, __, child) =>
              FadeTransition(opacity: anim, child: child),
        ),
        (route) => false,
      );
    } on ApiException catch (e) {
      setState(() {
        _error = e.message;
        _loading = false;
      });
    }
  }

  bool _obscurePw = true;
  bool _obscureConfirm = true;

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFFF3F4F6),
      body: SafeArea(
        bottom: false,
        child: SingleChildScrollView(
          child: Column(
            children: [
              // ── Emerald Header ──
              Container(
                width: double.infinity,
                padding: const EdgeInsets.fromLTRB(20, 20, 20, 24),
                decoration: const BoxDecoration(
                  gradient: LinearGradient(
                    begin: Alignment.topLeft,
                    end: Alignment.bottomRight,
                    colors: [Color(0xFF059669), Color(0xFF065F46)],
                  ),
                ),
                child: Column(
                  children: [
                    // Back + logo row
                    Row(
                      children: [
                        GestureDetector(
                          onTap: () => Navigator.pop(context),
                          child: Container(
                            width: 36,
                            height: 36,
                            decoration: BoxDecoration(
                              color: Colors.white.withOpacity(0.15),
                              borderRadius: BorderRadius.circular(10),
                            ),
                            child: const Icon(Icons.arrow_back_ios_new_rounded,
                                color: Colors.white, size: 16),
                          ),
                        ),
                        const Spacer(),
                        Container(
                          width: 52,
                          height: 52,
                          decoration: BoxDecoration(
                            color: Colors.white.withOpacity(0.12),
                            borderRadius: BorderRadius.circular(14),
                          ),
                          child: ClipRRect(
                            borderRadius: BorderRadius.circular(11),
                            child: Image.asset(
                              'assets/images/salamapaylogo.png',
                              fit: BoxFit.contain,
                            ),
                          ),
                        ),
                        const Spacer(),
                        const SizedBox(width: 36),
                      ],
                    ),
                    const SizedBox(height: 16),
                    Text(
                      'Create Account',
                      style: GoogleFonts.nunito(
                        color: Colors.white,
                        fontSize: 22,
                        fontWeight: FontWeight.w900,
                      ),
                    ),
                    const SizedBox(height: 4),
                    Text(
                      'Register your SalamaPay business account',
                      style: GoogleFonts.nunito(
                        color: const Color(0xFFD1FAE5),
                        fontSize: 12,
                        fontWeight: FontWeight.w600,
                      ),
                    ),
                  ],
                ),
              ),

              // ── White Card ──
              Container(
                margin: const EdgeInsets.all(16),
                decoration: BoxDecoration(
                  color: Colors.white,
                  borderRadius: BorderRadius.circular(20),
                  boxShadow: [
                    BoxShadow(
                      color: Colors.black.withOpacity(0.08),
                      blurRadius: 20,
                      offset: const Offset(0, 4),
                    )
                  ],
                  border: Border.all(color: const Color(0xFFF3F4F6)),
                ),
                padding: const EdgeInsets.all(24),
                child: Form(
                  key: _formKey,
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      // Error banner
                      if (_error != null) ...[
                        Container(
                          margin: const EdgeInsets.only(bottom: 16),
                          padding: const EdgeInsets.symmetric(
                              horizontal: 12, vertical: 10),
                          decoration: BoxDecoration(
                            color: const Color(0xFFFEF2F2),
                            borderRadius: BorderRadius.circular(10),
                            border: Border.all(color: const Color(0xFFFCA5A5)),
                          ),
                          child: Row(
                            children: [
                              const Icon(Icons.error_outline_rounded,
                                  color: Color(0xFFDC2626), size: 16),
                              const SizedBox(width: 8),
                              Expanded(
                                child: Text(
                                  _error!,
                                  style: GoogleFonts.nunito(
                                    color: const Color(0xFFB91C1C),
                                    fontSize: 12,
                                    fontWeight: FontWeight.w600,
                                  ),
                                ),
                              ),
                            ],
                          ),
                        ),
                      ],

                      // Business Name
                      _RegLabel('Business Name'),
                      const SizedBox(height: 6),
                      _RegField(
                        ctrl: _businessCtrl,
                        hint: 'Mama Pima Shop',
                        icon: Icons.store_outlined,
                      ),
                      const SizedBox(height: 16),

                      // First + Last name row
                      Row(
                        children: [
                          Expanded(
                            child: Column(
                              crossAxisAlignment: CrossAxisAlignment.start,
                              children: [
                                _RegLabel('First Name'),
                                const SizedBox(height: 6),
                                _RegField(
                                  ctrl: _firstNameCtrl,
                                  hint: 'John',
                                  icon: Icons.person_outline_rounded,
                                  validator: (v) => v == null || v.isEmpty
                                      ? 'Required'
                                      : null,
                                ),
                              ],
                            ),
                          ),
                          const SizedBox(width: 12),
                          Expanded(
                            child: Column(
                              crossAxisAlignment: CrossAxisAlignment.start,
                              children: [
                                _RegLabel('Last Name'),
                                const SizedBox(height: 6),
                                _RegField(
                                  ctrl: _lastNameCtrl,
                                  hint: 'Doe',
                                  icon: Icons.person_outline_rounded,
                                  validator: (v) => v == null || v.isEmpty
                                      ? 'Required'
                                      : null,
                                ),
                              ],
                            ),
                          ),
                        ],
                      ),
                      const SizedBox(height: 16),

                      _RegLabel('Email Address'),
                      const SizedBox(height: 6),
                      _RegField(
                        ctrl: _emailCtrl,
                        hint: 'you@example.com',
                        icon: Icons.alternate_email_rounded,
                        keyboard: TextInputType.emailAddress,
                        validator: (v) => v == null || !v.contains('@')
                            ? 'Enter a valid email'
                            : null,
                      ),
                      const SizedBox(height: 16),

                      _RegLabel('Phone Number'),
                      const SizedBox(height: 6),
                      _RegField(
                        ctrl: _phoneCtrl,
                        hint: '+255 7XX XXX XXX',
                        icon: Icons.phone_outlined,
                        keyboard: TextInputType.phone,
                        validator: (v) =>
                            v == null || v.length < 9 ? 'Enter valid phone' : null,
                      ),
                      const SizedBox(height: 16),

                      _RegLabel('Password'),
                      const SizedBox(height: 6),
                      _RegField(
                        ctrl: _passwordCtrl,
                        hint: 'Min 6 characters',
                        icon: Icons.lock_outline_rounded,
                        obscure: _obscurePw,
                        suffixIcon: GestureDetector(
                          onTap: () => setState(() => _obscurePw = !_obscurePw),
                          child: Icon(
                            _obscurePw
                                ? Icons.visibility_off_outlined
                                : Icons.visibility_outlined,
                            color: const Color(0xFF9CA3AF),
                            size: 18,
                          ),
                        ),
                        validator: (v) => v == null || v.length < 6
                            ? 'Min 6 characters'
                            : null,
                      ),
                      const SizedBox(height: 16),

                      _RegLabel('Confirm Password'),
                      const SizedBox(height: 6),
                      _RegField(
                        ctrl: _confirmCtrl,
                        hint: 'Repeat password',
                        icon: Icons.lock_outline_rounded,
                        obscure: _obscureConfirm,
                        suffixIcon: GestureDetector(
                          onTap: () =>
                              setState(() => _obscureConfirm = !_obscureConfirm),
                          child: Icon(
                            _obscureConfirm
                                ? Icons.visibility_off_outlined
                                : Icons.visibility_outlined,
                            color: const Color(0xFF9CA3AF),
                            size: 18,
                          ),
                        ),
                        validator: (v) => v != _passwordCtrl.text
                            ? 'Passwords do not match'
                            : null,
                      ),
                      const SizedBox(height: 20),

                      // Terms checkbox
                      GestureDetector(
                        onTap: () =>
                            setState(() => _acceptTerms = !_acceptTerms),
                        child: Row(
                          crossAxisAlignment: CrossAxisAlignment.start,
                          children: [
                            SizedBox(
                              width: 20,
                              height: 20,
                              child: Checkbox(
                                value: _acceptTerms,
                                onChanged: (v) =>
                                    setState(() => _acceptTerms = v ?? false),
                                activeColor: AppColors.emeraldPrimary,
                                shape: RoundedRectangleBorder(
                                    borderRadius: BorderRadius.circular(4)),
                                side: const BorderSide(
                                    color: Color(0xFFD1D5DB)),
                              ),
                            ),
                            const SizedBox(width: 10),
                            Expanded(
                              child: Text.rich(
                                TextSpan(
                                  text: 'I agree to the ',
                                  style: GoogleFonts.nunito(
                                      fontSize: 12,
                                      color: const Color(0xFF6B7280),
                                      fontWeight: FontWeight.w600),
                                  children: [
                                    TextSpan(
                                      text: 'Terms of Service',
                                      style: GoogleFonts.nunito(
                                          fontSize: 12,
                                          color: AppColors.emeraldPrimary,
                                          fontWeight: FontWeight.w800),
                                    ),
                                    TextSpan(
                                      text: ' and ',
                                      style: GoogleFonts.nunito(
                                          fontSize: 12,
                                          color: const Color(0xFF6B7280)),
                                    ),
                                    TextSpan(
                                      text: 'Privacy Policy',
                                      style: GoogleFonts.nunito(
                                          fontSize: 12,
                                          color: AppColors.emeraldPrimary,
                                          fontWeight: FontWeight.w800),
                                    ),
                                  ],
                                ),
                              ),
                            ),
                          ],
                        ),
                      ),
                      const SizedBox(height: 24),

                      // ── Gold Create Account Button ──
                      GestureDetector(
                        onTap: _loading ? null : _register,
                        child: Container(
                          width: double.infinity,
                          height: 50,
                          decoration: BoxDecoration(
                            gradient: const LinearGradient(
                              colors: [Color(0xFFFFCC33), Color(0xFFE5AC00)],
                            ),
                            borderRadius: BorderRadius.circular(12),
                            boxShadow: [
                              BoxShadow(
                                color:
                                    const Color(0xFFE5AC00).withOpacity(0.4),
                                blurRadius: 12,
                                offset: const Offset(0, 4),
                              )
                            ],
                          ),
                          child: Center(
                            child: _loading
                                ? const SizedBox(
                                    width: 22,
                                    height: 22,
                                    child: CircularProgressIndicator(
                                        strokeWidth: 2.5,
                                        color: Color(0xFF1C4532)),
                                  )
                                : Row(
                                    mainAxisAlignment: MainAxisAlignment.center,
                                    children: [
                                      const Icon(Icons.person_add_rounded,
                                          color: Color(0xFF1C4532), size: 18),
                                      const SizedBox(width: 8),
                                      Text(
                                        'Create Account',
                                        style: GoogleFonts.nunito(
                                          color: const Color(0xFF1C4532),
                                          fontSize: 15,
                                          fontWeight: FontWeight.w900,
                                        ),
                                      ),
                                    ],
                                  ),
                          ),
                        ),
                      ),
                      const SizedBox(height: 20),

                      // Sign in link
                      Center(
                        child: RichText(
                          text: TextSpan(
                            style: GoogleFonts.nunito(
                                fontSize: 13, color: const Color(0xFF6B7280)),
                            children: [
                              const TextSpan(text: 'Already have an account? '),
                              WidgetSpan(
                                child: GestureDetector(
                                  onTap: () => Navigator.pop(context),
                                  child: Text(
                                    'Sign in',
                                    style: GoogleFonts.nunito(
                                      color: AppColors.emeraldPrimary,
                                      fontSize: 13,
                                      fontWeight: FontWeight.w800,
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
              ),

              Padding(
                padding: const EdgeInsets.only(bottom: 32),
                child: Text(
                  '© ${DateTime.now().year} SalamaPay. All rights reserved.',
                  style: GoogleFonts.nunito(
                      fontSize: 11, color: const Color(0xFF9CA3AF)),
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }
}

// ── Helpers ──

class _RegLabel extends StatelessWidget {
  final String text;
  const _RegLabel(this.text);

  @override
  Widget build(BuildContext context) => Text(
        text,
        style: GoogleFonts.nunito(
          fontSize: 13,
          fontWeight: FontWeight.w700,
          color: const Color(0xFF374151),
        ),
      );
}

class _RegField extends StatelessWidget {
  final TextEditingController ctrl;
  final String hint;
  final IconData icon;
  final bool obscure;
  final TextInputType keyboard;
  final Widget? suffixIcon;
  final String? Function(String?)? validator;

  const _RegField({
    required this.ctrl,
    required this.hint,
    required this.icon,
    this.obscure = false,
    this.keyboard = TextInputType.text,
    this.suffixIcon,
    this.validator,
  });

  @override
  Widget build(BuildContext context) {
    return TextFormField(
      controller: ctrl,
      obscureText: obscure,
      keyboardType: keyboard,
      validator: validator,
      style: GoogleFonts.nunito(
          fontSize: 13,
          fontWeight: FontWeight.w600,
          color: const Color(0xFF111827)),
      decoration: InputDecoration(
        hintText: hint,
        hintStyle:
            GoogleFonts.nunito(color: const Color(0xFF9CA3AF), fontSize: 13),
        prefixIcon: Icon(icon, size: 18, color: const Color(0xFF9CA3AF)),
        suffixIcon: suffixIcon,
        filled: true,
        fillColor: Colors.white,
        contentPadding:
            const EdgeInsets.symmetric(horizontal: 14, vertical: 12),
        enabledBorder: OutlineInputBorder(
          borderRadius: BorderRadius.circular(10),
          borderSide: const BorderSide(color: Color(0xFFE5E7EB), width: 1),
        ),
        focusedBorder: OutlineInputBorder(
          borderRadius: BorderRadius.circular(10),
          borderSide: const BorderSide(color: Color(0xFF059669), width: 1.5),
        ),
        errorBorder: OutlineInputBorder(
          borderRadius: BorderRadius.circular(10),
          borderSide: const BorderSide(color: Color(0xFFFCA5A5), width: 1),
        ),
        focusedErrorBorder: OutlineInputBorder(
          borderRadius: BorderRadius.circular(10),
          borderSide: const BorderSide(color: Color(0xFFDC2626), width: 1.5),
        ),
      ),
    );
  }
}
