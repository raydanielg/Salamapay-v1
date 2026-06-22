class ApiConfig {
  static const String baseUrl = 'https://miet.ac.tz';
  static const String apiUrl = '$baseUrl/api';

  // Auth
  static const String login = '$apiUrl/login';
  static const String register = '$apiUrl/register';
  static const String logout = '$apiUrl/logout';
  static const String user = '$apiUrl/user';

  // Dashboard
  static const String dashboard = '$apiUrl/user/dashboard';

  // Sales / Transactions
  static const String sales = '$apiUrl/user/sales';
  static String saleDelete(int id) => '$apiUrl/user/sales/$id';

  // Invoices
  static const String invoices = '$apiUrl/user/invoices';
  static String invoiceShow(int id) => '$apiUrl/user/invoices/$id';
  static String invoiceUpdate(int id) => '$apiUrl/user/invoices/$id';
  static String invoiceDelete(int id) => '$apiUrl/user/invoices/$id';
  static String invoicePay(int id) => '$apiUrl/user/invoices/$id/pay';

  // Products
  static const String products = '$apiUrl/user/products';
  static String productUpdate(int id) => '$apiUrl/user/products/$id';
  static String productDelete(int id) => '$apiUrl/user/products/$id';

  // Reports
  static const String reports = '$apiUrl/user/reports';

  // Payment Links
  static const String paymentLinks = '$apiUrl/user/payment-links';
}
