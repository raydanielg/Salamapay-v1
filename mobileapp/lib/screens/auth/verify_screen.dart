import 'dart:async';
import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:google_fonts/google_fonts.dart';
import '../../theme/app_theme.dart';
import 'login_screen.dart';

class VerifyScreen extends StatefulWidget {
  final String email;
  const VerifyScreen({super.key, required this.email});

  @override
  State<VerifyScreen> createState() => _VerifyScreenState();
}

class _VerifyScreenState extends State<VerifyScreen> {
  final List<TextEditingController> _ctrls =
      List.generate(6, (_) => TextEditingController());
  final List<FocusNode> _nodes = List.generate(6, (_) => FocusNode());

  bool _loading = false;
  bool _verified = false;
  String? _error;
  int _resendSeconds = 60;
  Timer? _timer;

  @override
  void initState() {
    super.initState();
    _startResendTimer();
    WidgetsBinding.instance.addPostFrameCallback((_) {
      _nodes[0].requestFocus();
    });
  }

  void _startResendTimer() {
    _timer = Timer.periodic(const Duration(seconds: 1), (t) {
      if (!mounted) { t.cancel(); return; }
      if (_resendSeconds == 0) { t.cancel(); return; }
      setState(() => _resendSeconds--);
    });
  }

  @override
  void dispose() {
    for (final c in _ctrls) c.dispose();
    for (final n in _nodes) n.dispose();
    _timer?.cancel();
    super.dispose();
  }

  String get _code => _ctrls.map((c) => c.text).join();

  Future<void> _verify() async {
    if (_code.length < 6) {
      setState(() => _error = 'Enter all 6 digits');
      return;
    }
    setState(() { _loading = true; _error = null; });
    await Future.delayed(const Duration(seconds: 1));
    if (!mounted) return;
    setState(() { _loading = false; _verified = true; });
    await Future.delayed(const Duration(milliseconds: 600));
    if (!mounted) return;
    Navigator.of(context).pushAndRemoveUntil(
      MaterialPageRoute(builder: (_) => const LoginScreen()),
      (r) => false,
    );
  }

  void _onDigit(String val, int index) {
    if (val.length == 1 && index < 5) {
      _nodes[index + 1].requestFocus();
    }
    setState(() {});
  }

  void _onBackspace(int index) {
    if (_ctrls[index].text.isEmpty && index > 0) {
      _nodes[index - 1].requestFocus();
      _ctrls[index - 1].clear();
    }
    setState(() {});
  }

  @override
  Widget build(BuildContext context) {
    final masked = widget.email.replaceAllMapped(
      RegExp(r'(.{2}).+(@.+)'),
      (m) => '${m[1]}****${m[2]}',
    );

    return Scaffold(
      backgroundColor: Colors.white,
      appBar: AppBar(
        backgroundColor: Colors.white,
        elevation: 0,
        leading: GestureDetector(
          onTap: () => Navigator.pop(context),
          child: const Icon(Icons.arrow_back_ios_new_rounded,
              color: AppColors.grey900, size: 18),
        ),
      ),
      body: SafeArea(
        child: SingleChildScrollView(
          padding: const EdgeInsets.symmetric(horizontal: 24),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              const SizedBox(height: 16),

              // Icon
              Container(
                width: 52,
                height: 52,
                decoration: BoxDecoration(
                  color: const Color(0xFFEFF6FF),
                  borderRadius: BorderRadius.circular(14),
                ),
                child: const Icon(Icons.mark_email_read_outlined,
                    color: Color(0xFF1D4ED8), size: 26),
              ),

              const SizedBox(height: 24),

              Text('Check your email',
                  style: GoogleFonts.nunito(
                      fontSize: 24,
                      fontWeight: FontWeight.w900,
                      color: AppColors.grey900)),
              const SizedBox(height: 6),
              RichText(
                text: TextSpan(
                  style: GoogleFonts.nunito(
                      fontSize: 14,
                      color: AppColors.grey400,
                      height: 1.5,
                      fontWeight: FontWeight.w500),
                  children: [
                    const TextSpan(text: 'We sent a 6-digit code to '),
                    TextSpan(
                      text: masked,
                      style: GoogleFonts.nunito(
                          color: AppColors.grey900,
                          fontWeight: FontWeight.w700,
                          fontSize: 14),
                    ),
                  ],
                ),
              ),

              const SizedBox(height: 36),

              // OTP boxes
              Row(
                mainAxisAlignment: MainAxisAlignment.spaceBetween,
                children: List.generate(6, (i) => _OtpBox(
                  ctrl: _ctrls[i],
                  node: _nodes[i],
                  hasValue: _ctrls[i].text.isNotEmpty,
                  onChanged: (v) => _onDigit(v, i),
                  onBackspace: () => _onBackspace(i),
                )),
              ),

              if (_error != null) ...[
                const SizedBox(height: 12),
                Text(_error!,
                    style: GoogleFonts.nunito(
                        fontSize: 12,
                        color: AppColors.error,
                        fontWeight: FontWeight.w600)),
              ],

              const SizedBox(height: 28),

              // Verify button
              GestureDetector(
                onTap: _loading ? null : _verify,
                child: AnimatedContainer(
                  duration: const Duration(milliseconds: 150),
                  width: double.infinity,
                  height: 52,
                  decoration: BoxDecoration(
                    color: _verified
                        ? AppColors.success
                        : AppColors.emeraldPrimary,
                    borderRadius: BorderRadius.circular(12),
                    boxShadow: [
                      BoxShadow(
                        color: AppColors.emeraldPrimary.withOpacity(0.2),
                        blurRadius: 10,
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
                                strokeWidth: 2.5, color: Colors.white),
                          )
                        : Text(
                            _verified ? 'Verified!' : 'Verify Code',
                            style: GoogleFonts.nunito(
                                color: Colors.white,
                                fontSize: 15,
                                fontWeight: FontWeight.w800),
                          ),
                  ),
                ),
              ),

              const SizedBox(height: 24),

              // Resend
              Center(
                child: _resendSeconds > 0
                    ? Text(
                        'Resend code in ${_resendSeconds}s',
                        style: GoogleFonts.nunito(
                            fontSize: 13,
                            color: AppColors.grey400,
                            fontWeight: FontWeight.w500),
                      )
                    : GestureDetector(
                        onTap: () {
                          setState(() => _resendSeconds = 60);
                          _startResendTimer();
                        },
                        child: Text('Resend code',
                            style: GoogleFonts.nunito(
                                fontSize: 13,
                                color: AppColors.emeraldPrimary,
                                fontWeight: FontWeight.w700)),
                      ),
              ),
            ],
          ),
        ),
      ),
    );
  }
}

class _OtpBox extends StatelessWidget {
  final TextEditingController ctrl;
  final FocusNode node;
  final bool hasValue;
  final ValueChanged<String> onChanged;
  final VoidCallback onBackspace;

  const _OtpBox({
    required this.ctrl,
    required this.node,
    required this.hasValue,
    required this.onChanged,
    required this.onBackspace,
  });

  @override
  Widget build(BuildContext context) {
    return AnimatedContainer(
      duration: const Duration(milliseconds: 150),
      width: 46,
      height: 54,
      decoration: BoxDecoration(
        color: hasValue ? AppColors.emeraldLight : const Color(0xFFFAFAFA),
        borderRadius: BorderRadius.circular(12),
        border: Border.all(
          color: hasValue
              ? AppColors.emeraldPrimary
              : const Color(0xFFE5E7EB),
          width: hasValue ? 1.5 : 1,
        ),
      ),
      child: KeyboardListener(
        focusNode: FocusNode(),
        onKeyEvent: (e) {
          if (e is KeyDownEvent &&
              e.logicalKey == LogicalKeyboardKey.backspace) {
            onBackspace();
          }
        },
        child: TextField(
          controller: ctrl,
          focusNode: node,
          maxLength: 1,
          textAlign: TextAlign.center,
          keyboardType: TextInputType.number,
          inputFormatters: [FilteringTextInputFormatter.digitsOnly],
          onChanged: onChanged,
          style: GoogleFonts.nunito(
              fontSize: 20,
              fontWeight: FontWeight.w900,
              color: AppColors.emeraldDark),
          decoration: const InputDecoration(
            counterText: '',
            border: InputBorder.none,
            contentPadding: EdgeInsets.zero,
          ),
        ),
      ),
    );
  }
}
