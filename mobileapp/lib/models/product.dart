class ProductModel {
  final int id;
  final String name;
  final String? description;
  final double price;
  final int? stock;
  final String? sku;
  final String? image;
  final bool isActive;
  final String type;

  ProductModel({
    required this.id,
    required this.name,
    this.description,
    required this.price,
    this.stock,
    this.sku,
    this.image,
    this.isActive = true,
    this.type = 'product',
  });

  bool get isLowStock => stock != null && stock! > 0 && stock! <= 5;
  bool get isOutOfStock => stock != null && stock! <= 0;
  bool get isService => type == 'service';

  factory ProductModel.fromJson(Map<String, dynamic> json) {
    return ProductModel(
      id: json['id'] ?? 0,
      name: json['name'] ?? '',
      description: json['description'],
      price: double.tryParse(json['price']?.toString() ?? '0') ?? 0,
      stock: json['stock'] != null ? int.tryParse(json['stock'].toString()) : null,
      sku: json['sku'],
      image: json['image'],
      isActive: json['is_active'] == true || json['is_active'] == 1,
      type: json['type'] ?? 'product',
    );
  }
}
