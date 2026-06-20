<?php

namespace Database\Seeders;

use App\Models\DocumentationPage;
use Illuminate\Database\Seeder;

class DocumentationSeeder extends Seeder
{
    public function run(): void
    {
        $docs = [
            // Getting Started
            [
                'slug' => 'introduction',
                'title' => 'Introduction',
                'category' => 'getting_started',
                'sort_order' => 1,
                'is_published' => true,
                'content' => <<<'MD'
# Welcome to SalamaPay

SalamaPay is a modern payment gateway built for East African businesses. Accept payments via M-Pesa, Tigo Pesa, Airtel Money, bank cards, and bank transfers — all through a single, unified API.

## What You Can Build

- **E-commerce stores** — Accept payments directly on your website
- **Marketplaces** — Split payments between vendors automatically
- **Subscription services** — Recurring billing with mobile money
- **In-app payments** — SDKs for iOS, Android, and Flutter
- **Payment links** — Shareable payment URLs for invoices and orders

## Base URL

```
Production:  https://api.salamapay.com/v1
Sandbox:     https://sandbox.salamapay.com/v1
```

## Quick Start

1. Sign up at [salamapay.com](/register)
2. Get your API keys from the dashboard
3. Make your first request:

```bash
curl -X GET https://api.salamapay.com/v1/balance \
  -H "Authorization: Bearer spk_live_xxxxxxxx"
```

## Support

- Email: developers@salamapay.com
- Dashboard: /dashboard/api
- Status Page: status.salamapay.com
MD
            ],

            [
                'slug' => 'authentication',
                'title' => 'Authentication',
                'category' => 'getting_started',
                'sort_order' => 2,
                'is_published' => true,
                'content' => <<<'MD'
# Authentication

All API requests require authentication using an API key passed in the `Authorization` header.

## API Keys

API keys are managed from your [Dashboard API Settings](/dashboard/api). Each key has:
- A **public key** (`spk_live_xxx` or `spk_test_xxx`)
- A **secret key** (used for server-to-server requests)
- Scoped **permissions**

## Request Headers

| Header | Required | Description |
|--------|----------|-------------|
| `Authorization` | Yes | `Bearer {your_secret_key}` |
| `Content-Type` | Yes | `application/json` |
| `X-Request-Id` | No | UUID for idempotency |
| `X-Sandbox` | No | `true` to force sandbox mode |

## Example Request

```bash
curl -X GET https://api.salamapay.com/v1/payments \
  -H "Authorization: Bearer spk_live_xxxxxxxxxxxxxxxx" \
  -H "Content-Type: application/json"
```

## Error Response (401)

```json
{
  "error": {
    "code": "UNAUTHORIZED",
    "message": "Invalid or expired API key",
    "status": 401
  }
}
```

## Key Rotation

Rotate keys periodically from the dashboard. Old keys can be revoked instantly without affecting active transactions.
MD
            ],

            // API Reference
            [
                'slug' => 'payments',
                'title' => 'Payments API',
                'category' => 'api_reference',
                'sort_order' => 1,
                'is_published' => true,
                'content' => <<<'MD'
# Payments API

Create, retrieve, and manage payments through the SalamaPay platform.

## Create a Payment

```http
POST /v1/payments
```

### Request Body

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| `amount` | integer | Yes | Amount in smallest currency unit (cents) |
| `currency` | string | Yes | `TZS`, `USD`, `KES`, `UGX` |
| `method` | string | Yes | `mpesa`, `tigo_pesa`, `airtel_money`, `card`, `bank` |
| `customer` | object | Yes | Customer details |
| `metadata` | object | No | Key-value pairs attached to payment |

### Example Request

```bash
curl -X POST https://api.salamapay.com/v1/payments \
  -H "Authorization: Bearer spk_live_xxx" \
  -H "Content-Type: application/json" \
  -d '{
    "amount": 50000,
    "currency": "TZS",
    "method": "mpesa",
    "customer": {
      "name": "John Doe",
      "email": "john@example.com",
      "phone": "+255712345678"
    },
    "metadata": {
      "order_id": "ORD-12345",
      "source": "mobile_app"
    }
  }'
```

### Response

```json
{
  "id": "pay_xxxxxxxx",
  "status": "pending",
  "amount": 50000,
  "currency": "TZS",
  "method": "mpesa",
  "customer": {
    "name": "John Doe",
    "email": "john@example.com",
    "phone": "+255712345678"
  },
  "metadata": {
    "order_id": "ORD-12345"
  },
  "created_at": "2026-06-20T08:30:00Z",
  "expires_at": "2026-06-20T08:35:00Z",
  "checkout_url": "https://pay.salamapay.com/checkout/pay_xxx"
}
```

## Retrieve a Payment

```http
GET /v1/payments/{id}
```

## List All Payments

```http
GET /v1/payments?limit=10&offset=0&status=success
```

### Query Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `limit` | integer | Max results per page (default: 20, max: 100) |
| `offset` | integer | Pagination offset |
| `status` | string | Filter by `pending`, `success`, `failed` |
| `from` | string | Start date (ISO 8601) |
| `to` | string | End date (ISO 8601) |

## Payment Status Lifecycle

```
pending → processing → success
                    → failed
```

| Status | Description |
|--------|-------------|
| `pending` | Awaiting customer confirmation |
| `processing` | Provider is processing |
| `success` | Payment completed |
| `failed` | Payment failed or expired |
MD
            ],

            [
                'slug' => 'payment-links',
                'title' => 'Payment Links API',
                'category' => 'api_reference',
                'sort_order' => 2,
                'is_published' => true,
                'content' => <<<'MD'
# Payment Links API

Create shareable payment URLs without writing code.

## Create a Payment Link

```http
POST /v1/payment-links
```

### Request Body

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| `title` | string | Yes | Display title |
| `description` | string | No | Additional info |
| `amount` | integer | Yes | Fixed amount or `0` for variable |
| `currency` | string | Yes | `TZS` etc. |
| `slug` | string | No | Custom URL slug |
| `expires_at` | string | No | ISO 8601 expiration date |

### Example

```bash
curl -X POST https://api.salamapay.com/v1/payment-links \
  -H "Authorization: Bearer spk_live_xxx" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "Consultation Fee",
    "description": "Legal consultation session",
    "amount": 150000,
    "currency": "TZS",
    "slug": "consult-june"
  }'
```

### Response

```json
{
  "id": "plink_xxx",
  "slug": "consult-june",
  "url": "https://pay.salamapay.com/pay/consult-june",
  "title": "Consultation Fee",
  "amount": 150000,
  "currency": "TZS",
  "is_active": true,
  "usage_count": 0,
  "created_at": "2026-06-20T10:00:00Z"
}
```

## Sharing the Link

Once created, share the `url` with customers:
- SMS
- WhatsApp
- Email
- Embedded in invoices

## Deactivate a Link

```http
PATCH /v1/payment-links/{id}
```

```json
{ "is_active": false }
```
MD
            ],

            [
                'slug' => 'settlements-api',
                'title' => 'Settlements API',
                'category' => 'api_reference',
                'sort_order' => 3,
                'is_published' => true,
                'content' => <<<'MD'
# Settlements API

Transfer your available balance to your bank account or mobile money wallet.

## Request a Settlement

```http
POST /v1/settlements
```

### Request Body

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| `amount` | integer | Yes | Amount to settle |
| `currency` | string | Yes | `TZS` |
| `bank_account_id` | string | Yes | ID of saved bank account |
| `method` | string | Yes | `bank` or `mobile_money` |

### Example

```bash
curl -X POST https://api.salamapay.com/v1/settlements \
  -H "Authorization: Bearer spk_live_xxx" \
  -H "Content-Type: application/json" \
  -d '{
    "amount": 500000,
    "currency": "TZS",
    "bank_account_id": "ba_xxx",
    "method": "bank"
  }'
```

### Response

```json
{
  "id": "stl_xxx",
  "reference": "STL-2026-006",
  "status": "pending",
  "amount": 500000,
  "currency": "TZS",
  "fee": 5000,
  "method": "bank",
  "bank_account": {
    "account_name": "Ezra Daniel",
    "bank_name": "CRDB Bank",
    "account_number": "****7890"
  },
  "estimated_arrival": "2026-06-21T08:00:00Z",
  "created_at": "2026-06-20T14:00:00Z"
}
```

## List Settlements

```http
GET /v1/settlements
```

## Settlement Status

| Status | Description | Timeline |
|--------|-------------|----------|
| `pending` | Awaiting approval | 0-2 hours |
| `processing` | Transfer initiated | Same day |
| `completed` | Funds received | 1-24 hours |
| `failed` | Transfer failed | — |

## Bank Accounts

Manage withdrawal destinations:

```http
GET    /v1/bank-accounts
POST   /v1/bank-accounts
DELETE /v1/bank-accounts/{id}
```

Supported types: `bank`, `mobile_money`
MD
            ],

            // Webhooks
            [
                'slug' => 'webhooks',
                'title' => 'Webhooks',
                'category' => 'webhooks',
                'sort_order' => 1,
                'is_published' => true,
                'content' => <<<'MD'
# Webhooks

Receive real-time event notifications to your server. Webhooks are the most reliable way to track payment state changes.

## Why Webhooks?

Polling the API for status updates is inefficient. Webhooks push events to your server instantly.

## Event Types

| Event | Description |
|-------|-------------|
| `payment.success` | Payment completed successfully |
| `payment.failed` | Payment failed |
| `payment.pending` | Payment awaiting confirmation |
| `settlement.completed` | Settlement processed |
| `settlement.failed` | Settlement failed |
| `refund.processed` | Refund completed |
| `dispute.opened` | Chargeback/dispute filed |

## Webhook Payload

```json
{
  "id": "evt_xxxxxxxx",
  "type": "payment.success",
  "created_at": "2026-06-20T08:30:00Z",
  "data": {
    "id": "pay_xxx",
    "status": "success",
    "amount": 50000,
    "currency": "TZS",
    "method": "mpesa",
    "customer": {
      "name": "John Doe",
      "email": "john@example.com"
    },
    "metadata": {
      "order_id": "ORD-12345"
    }
  }
}
```

## Signature Verification

Verify webhook authenticity using the `X-SalamaPay-Signature` header:

```php
$payload = file_get_contents('php://input');
$signature = $_SERVER['HTTP_X_SALAMAPAY_SIGNATURE'];
$expected = hash_hmac('sha256', $payload, $webhookSecret);

if (!hash_equals($expected, $signature)) {
    http_response_code(401);
    exit('Invalid signature');
}
```

## Retry Policy

If your endpoint returns a non-2xx status, we retry:
- Attempt 1: Immediate
- Attempt 2: After 5 minutes
- Attempt 3: After 30 minutes

After 3 failures, the webhook is automatically disabled.

## Best Practices

1. **Return 200 immediately** — Process events asynchronously
2. **Verify signatures** — Prevent spoofing
3. **Handle duplicates** — Use `id` for idempotency
4. **Log everything** — Debug failures easily
MD
            ],

            // SDKs
            [
                'slug' => 'sdk-php',
                'title' => 'PHP SDK',
                'category' => 'sdks',
                'sort_order' => 1,
                'is_published' => true,
                'content' => <<<'MD'
# PHP SDK

Official PHP SDK for SalamaPay. Requires PHP 8.1+.

## Installation

```bash
composer require salamapay/salamapay-php
```

## Configuration

```php
use SalamaPay\SalamaPay;

$client = new SalamaPay([
    'api_key' => 'spk_live_xxxxxxxx',
    'environment' => 'production', // or 'sandbox'
]);
```

## Create a Payment

```php
$payment = $client->payments->create([
    'amount' => 50000,
    'currency' => 'TZS',
    'method' => 'mpesa',
    'customer' => [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'phone' => '+255712345678'
    ],
    'metadata' => [
        'order_id' => 'ORD-12345'
    ]
]);

echo $payment->checkout_url;
```

## Retrieve a Payment

```php
$payment = $client->payments->find('pay_xxx');
echo $payment->status;
```

## List Payments

```php
$payments = $client->payments->all([
    'limit' => 10,
    'status' => 'success'
]);

foreach ($payments->data as $p) {
    echo $p->id . ' - ' . $p->amount . "\n";
}
```

## Webhook Handler

```php
use SalamaPay\Webhook;

$webhook = new Webhook('whsec_your_secret');
$event = $webhook->constructEvent($payload, $signature);

switch ($event->type) {
    case 'payment.success':
        $orderId = $event->data->metadata->order_id;
        // Fulfill order
        break;
    case 'payment.failed':
        // Notify customer
        break;
}
```

## Error Handling

```php
use SalamaPay\Exceptions\ApiException;

try {
    $payment = $client->payments->create([...]);
} catch (ApiException $e) {
    echo $e->getCode();    // e.g. "INSUFFICIENT_FUNDS"
    echo $e->getMessage(); // Human-readable message
    echo $e->getStatus();  // HTTP status code
}
```

## Laravel Integration

```bash
php artisan vendor:publish --provider="SalamaPay\Laravel\SalamaPayServiceProvider"
```

Configure in `.env`:
```env
SALAMAPAY_API_KEY=spk_live_xxx
SALAMAPAY_WEBHOOK_SECRET=whsec_xxx
SALAMAPAY_ENVIRONMENT=production
```

Use the facade:
```php
use SalamaPay\Facades\SalamaPay;

$payment = SalamaPay::payments()->create([...]);
```
MD
            ],

            [
                'slug' => 'sdk-node',
                'title' => 'Node.js SDK',
                'category' => 'sdks',
                'sort_order' => 2,
                'is_published' => true,
                'content' => <<<'MD'
# Node.js SDK

Official Node.js SDK for SalamaPay. Supports Node 18+.

## Installation

```bash
npm install @salamapay/sdk
```

## Quick Start

```javascript
import { SalamaPay } from '@salamapay/sdk';

const client = new SalamaPay({
  apiKey: 'spk_live_xxxxxxxx',
  environment: 'production',
});

// Create payment
const payment = await client.payments.create({
  amount: 50000,
  currency: 'TZS',
  method: 'mpesa',
  customer: {
    name: 'John Doe',
    email: 'john@example.com',
    phone: '+255712345678',
  },
});

console.log(payment.checkoutUrl);
```

## Express Webhook Handler

```javascript
import { Webhook } from '@salamapay/sdk';

const webhook = new Webhook('whsec_your_secret');

app.post('/webhooks/salamapay', express.raw({type: 'application/json'}), (req, res) => {
  const sig = req.headers['x-salamapay-signature'];

  try {
    const event = webhook.constructEvent(req.body, sig);

    switch (event.type) {
      case 'payment.success':
        await fulfillOrder(event.data.metadata.orderId);
        break;
      case 'payment.failed':
        await notifyCustomer(event.data.customer.email);
        break;
    }

    res.status(200).send('OK');
  } catch (err) {
    res.status(400).send('Invalid signature');
  }
});
```

## TypeScript

Fully typed:

```typescript
import { Payment, Customer } from '@salamapay/sdk';

const customer: Customer = {
  name: 'John Doe',
  email: 'john@example.com',
  phone: '+255712345678',
};
```
MD
            ],

            [
                'slug' => 'sdk-python',
                'title' => 'Python SDK',
                'category' => 'sdks',
                'sort_order' => 3,
                'is_published' => true,
                'content' => <<<'MD'
# Python SDK

Official Python SDK for SalamaPay. Requires Python 3.10+.

## Installation

```bash
pip install salamapay
```

## Quick Start

```python
from salamapay import SalamaPay

client = SalamaPay(
    api_key="spk_live_xxxxxxxx",
    environment="production"
)

# Create payment
payment = client.payments.create({
    "amount": 50000,
    "currency": "TZS",
    "method": "mpesa",
    "customer": {
        "name": "John Doe",
        "email": "john@example.com",
        "phone": "+255712345678"
    }
})

print(payment.checkout_url)
```

## Django Webhook Handler

```python
from django.http import JsonResponse
from salamapay.webhook import Webhook

webhook = Webhook("whsec_your_secret")

def salamapay_webhook(request):
    sig = request.headers.get("X-SalamaPay-Signature")
    payload = request.body

    try:
        event = webhook.construct_event(payload, sig)

        if event.type == "payment.success":
            order_id = event.data["metadata"]["order_id"]
            fulfill_order(order_id)

        return JsonResponse({"status": "ok"})
    except Exception:
        return JsonResponse({"error": "Invalid signature"}, status=400)
```

## Flask Example

```python
from flask import Flask, request
from salamapay import SalamaPay

app = Flask(__name__)
client = SalamaPay(api_key="spk_live_xxx")

@app.route('/pay', methods=['POST'])
def create_payment():
    payment = client.payments.create(request.json)
    return {"url": payment.checkout_url}
```
MD
            ],

            // Business & Resilience
            [
                'slug' => 'business-guide',
                'title' => 'Business & Resilience Guide',
                'category' => 'business',
                'sort_order' => 1,
                'is_published' => true,
                'content' => <<<'MD'
# Business & Resilience Guide

Best practices for building reliable payment flows with SalamaPay.

## Idempotency

Prevent duplicate charges by sending an `Idempotency-Key` header:

```bash
curl -X POST https://api.salamapay.com/v1/payments \
  -H "Idempotency-Key: unique-key-123" \
  -H "Authorization: Bearer spk_live_xxx" \
  -d '{...}'
```

Keys are valid for 24 hours. Retrying with the same key returns the original response.

## Handling Network Failures

```python
import time
from salamapay import SalamaPay

client = SalamaPay(api_key="spk_live_xxx")

def create_payment_with_retry(data, max_retries=3):
    for attempt in range(max_retries):
        try:
            return client.payments.create(data)
        except NetworkError:
            if attempt == max_retries - 1:
                raise
            time.sleep(2 ** attempt)  # Exponential backoff
```

## Reconciling Payments

Daily reconciliation prevents discrepancies:

1. Export transactions from dashboard
2. Match against your order database
3. Investigate unmatched records within 24 hours

## Security Checklist

- [ ] Store API keys in environment variables (never commit to Git)
- [ ] Use HTTPS for all webhook endpoints
- [ ] Verify webhook signatures on every request
- [ ] Implement rate limiting on your endpoints
- [ ] Log all API requests and responses
- [ ] Rotate API keys every 90 days

## Compliance

| Requirement | Details |
|-------------|---------|
| PCI DSS | SalamaPay is PCI DSS Level 1 compliant. You never handle raw card data. |
| KYC | Merchant verification required for settlements above TZS 1,000,000/day |
| AML | Suspicious transactions are automatically flagged for review |

## Disaster Recovery

- **RPO (Recovery Point Objective):** 5 minutes
- **RTO (Recovery Time Objective):** 15 minutes
- Data is replicated across 3 availability zones
- Automated daily backups retained for 30 days

## Rate Limits

| Endpoint | Limit |
|----------|-------|
| Payments (create) | 100/minute |
| Payments (list) | 300/minute |
| Webhooks | 500/minute |

Exceeding limits returns `429 Too Many Requests` with `Retry-After` header.
MD
            ],

            [
                'slug' => 'error-codes',
                'title' => 'Error Codes',
                'category' => 'api_reference',
                'sort_order' => 4,
                'is_published' => true,
                'content' => <<<'MD'
# Error Codes

All API errors follow a consistent format:

```json
{
  "error": {
    "code": "ERROR_CODE",
    "message": "Human readable description",
    "status": 400,
    "request_id": "req_xxx"
  }
}
```

## Common Errors

| Code | Status | Meaning |
|------|--------|---------|
| `UNAUTHORIZED` | 401 | Invalid API key |
| `FORBIDDEN` | 403 | Insufficient permissions |
| `NOT_FOUND` | 404 | Resource does not exist |
| `VALIDATION_ERROR` | 422 | Request validation failed |
| `RATE_LIMITED` | 429 | Too many requests |
| `INSUFFICIENT_FUNDS` | 400 | Payer has insufficient balance |
| `PAYMENT_EXPIRED` | 400 | Payment session timed out |
| `DUPLICATE_TRANSACTION` | 409 | Idempotency key reused with different data |
| `BANK_ERROR` | 502 | Provider-side failure |
| `SERVICE_UNAVAILABLE` | 503 | SalamaPay temporary outage |

## Validation Errors

```json
{
  "error": {
    "code": "VALIDATION_ERROR",
    "message": "Request validation failed",
    "status": 422,
    "details": {
      "amount": ["Amount must be at least 100"],
      "customer.phone": ["Invalid phone number format"]
    }
  }
}
```
MD
            ],
        ];

        foreach ($docs as $doc) {
            DocumentationPage::updateOrCreate(
                ['slug' => $doc['slug']],
                $doc
            );
        }
    }
}
