class UserModel {
  final int id;
  final String firstName;
  final String lastName;
  final String email;
  final String? phone;
  final String? businessName;
  final String? avatar;
  final String role;
  final String? balance;

  UserModel({
    required this.id,
    required this.firstName,
    required this.lastName,
    required this.email,
    this.phone,
    this.businessName,
    this.avatar,
    this.role = 'user',
    this.balance,
  });

  String get fullName => '$firstName $lastName';
  String get initials {
    final f = firstName.isNotEmpty ? firstName[0].toUpperCase() : '';
    final l = lastName.isNotEmpty ? lastName[0].toUpperCase() : '';
    return '$f$l';
  }

  factory UserModel.fromJson(Map<String, dynamic> json) {
    return UserModel(
      id: json['id'] ?? 0,
      firstName: json['first_name'] ?? json['name'] ?? '',
      lastName: json['last_name'] ?? '',
      email: json['email'] ?? '',
      phone: json['phone'],
      businessName: json['business_name'],
      avatar: json['avatar'],
      role: json['role'] ?? 'user',
      balance: json['balance']?.toString(),
    );
  }

  Map<String, dynamic> toJson() => {
        'id': id,
        'first_name': firstName,
        'last_name': lastName,
        'email': email,
        'phone': phone,
        'business_name': businessName,
        'role': role,
      };
}
