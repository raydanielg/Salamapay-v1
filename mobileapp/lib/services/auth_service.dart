import '../config/api_config.dart';
import '../models/user.dart';
import 'api_service.dart';

class AuthService {
  static UserModel? _currentUser;

  static UserModel? get currentUser => _currentUser;

  static Future<UserModel> login(String email, String password) async {
    final data = await ApiService.post(
      ApiConfig.login,
      {'email': email, 'password': password},
      auth: false,
    );
    final token = data['access_token'] ?? data['token'];
    if (token == null) throw ApiException('No token received');
    await ApiService.saveToken(token.toString());
    _currentUser = UserModel.fromJson(data['user'] ?? data);
    return _currentUser!;
  }

  static Future<UserModel> register({
    required String firstName,
    required String lastName,
    required String email,
    required String phone,
    required String password,
    required String passwordConfirmation,
    String? businessName,
  }) async {
    final data = await ApiService.post(
      ApiConfig.register,
      {
        'first_name': firstName,
        'last_name': lastName,
        'email': email,
        'phone': phone,
        'password': password,
        'password_confirmation': passwordConfirmation,
        if (businessName != null) 'business_name': businessName,
      },
      auth: false,
    );
    final token = data['access_token'] ?? data['token'];
    if (token == null) throw ApiException('No token received');
    await ApiService.saveToken(token.toString());
    _currentUser = UserModel.fromJson(data['user'] ?? data);
    return _currentUser!;
  }

  static Future<void> logout() async {
    try {
      await ApiService.post(ApiConfig.logout, {});
    } catch (_) {}
    await ApiService.clearToken();
    _currentUser = null;
  }

  static Future<UserModel?> fetchCurrentUser() async {
    try {
      final data = await ApiService.get(ApiConfig.user);
      _currentUser = UserModel.fromJson(data['data'] ?? data);
      return _currentUser;
    } catch (_) {
      return null;
    }
  }
}
