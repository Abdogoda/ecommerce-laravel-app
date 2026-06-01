# 🛍️ E-Commerce Platform

![App Screenshot — Dashboard](<Screenshots/Screenshot%20(9).png>)

An enterprise-grade e-commerce application that demonstrates the power and versatility of Spatie's ecosystem. This project is a testament to building scalable, maintainable, and feature-complete Laravel applications using battle-tested packages from the industry's most trusted maintainer.

---

## 🎯 Table of Contents

- [About](#about)
- [Core Features](#core-features)
- [Technology Stack](#technology-stack)
- [Spatie Packages Integrated](#spatie-packages-integrated)
- [Project Structure](#project-structure)
- [Installation & Setup](#installation--setup)
- [Usage Guide](#usage-guide)
- [Architecture Highlights](#architecture-highlights)
- [Testing](#testing)
- [Performance](#performance)
- [Screenshots](#screenshots)

---

## 📖 About

This is **not your average e-commerce tutorial project**. This is a production-ready ecommerce platform that integrates **8 comprehensive Spatie packages** to deliver a sophisticated, scalable system capable of handling complex business requirements.

Every feature is intentionally designed. Every package is strategically integrated. This project serves as a reference implementation for developers who want to understand how to leverage Spatie's ecosystem to build professional applications.

### Key Philosophies

- ✅ **No Bloat**: Only use what you need; every package has a clear purpose
- ✅ **Developer Experience**: Thoughtfully organized code, clear relationships, and proper separation of concerns
- ✅ **Scalability**: Built with growth in mind; architecture supports feature expansion without refactoring
- ✅ **Best Practices**: Follows Laravel conventions, SOLID principles, and Spatie's recommendations

---

## 🚀 Core Features

### E-Commerce Capabilities

| Feature                      | Description                                                                          |
| ---------------------------- | ------------------------------------------------------------------------------------ |
| **Product Management**       | Create, update, delete products with rich media galleries and multi-language support |
| **Category System**          | Hierarchical product categorization with activity logging and tagging                |
| **Shopping Cart & Checkout** | Full checkout flow with order processing and status tracking                         |
| **Order Management**         | Complete order lifecycle: pending → processing → shipped → delivered                 |
| **Multi-Language Support**   | Product names, descriptions, and categories in multiple languages                    |
| **Media Management**         | Advanced image handling with automatic processing and responsive delivery            |
| **Inventory Tracking**       | Real-time stock management for products                                              |

### Administrative Features

| Feature                       | Description                                                     |
| ----------------------------- | --------------------------------------------------------------- |
| **Role-Based Access Control** | Granular permission management for administrators and staff     |
| **Activity Logging**          | Comprehensive audit trail of all system changes                 |
| **Admin Dashboard**           | Centralized control panel for business operations               |
| **Settings Management**       | Application-wide configuration management with persistence      |
| **One-Time Passwords**        | Secure authentication with OTP support for sensitive operations |

### Customer Features

| Feature                | Description                                          |
| ---------------------- | ---------------------------------------------------- |
| **User Profiles**      | Complete user account management with preferences    |
| **Order History**      | View and track all past purchases                    |
| **Messaging System**   | Direct communication channel for customer inquiries  |
| **Tag-Based Browsing** | Discover products through intelligent tagging system |
| **Slug-Based Routing** | SEO-friendly URLs for all searchable content         |

---

## 🏗️ Technology Stack

| Layer                 | Technology                        |
| --------------------- | --------------------------------- |
| **Backend Framework** | Laravel 13 (PHP 8.3+)             |
| **Frontend Styling**  | Tailwind CSS 4 with Vite          |
| **Database**          | SQLite (dev) / MySQL (production) |
| **Testing**           | Pest PHP 4.4+ with Laravel plugin |
| **Code Quality**      | Laravel Pint (PHP linting)        |
| **Package Manager**   | Composer 2.0+                     |
| **Node Tooling**      | npm with Vite                     |
| **Data Export**       | Maatwebsite Excel 3.1             |
| **Log Viewer**        | Opcodesio Log Viewer 3.24         |

---

## 📦 Spatie Packages Integrated

This project demonstrates **8 carefully selected Spatie packages**, each addressing a specific domain problem:

### 1. **laravel-activitylog** v5.0

**Purpose**: Track and audit all changes made in your application

**Usage**:

```php
// Automatic logging with LogOptions configuration
use Spatie\Activitylog\Models\Concerns\HasActivity;
use Spatie\Activitylog\Support\LogOptions;

class Category extends Model
{
    use HasActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'description', 'icon', 'is_active'])
            ->logOnlyDirty() // Only log changed attributes
            ->setDescriptionForEvent(fn($event) => "Category has been {$event}");
    }
}
```

**Key Features**:

- Automatic change tracking on specified models
- Detailed audit trails with before/after values
- User attribution (who made the change)
- Temporal querying (when did changes happen)
- Customizable event descriptions

**In This Project**: Used on `Category` and `User` models to maintain complete audit trails of administrative actions.

---

### 2. **laravel-medialibrary** v11.21

**Purpose**: Handle media uploads, processing, and serving with advanced features

**Usage**:

```php
// Register media collections for different use cases
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use InteractsWithMedia;

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('gallery')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);
    }

    // Get product images with type safety
    public function getProductImageUrls(): array
    {
        return $this->getMedia('gallery')->map(fn($m) => $m->getUrl())->toArray();
    }
}

// Upload and attach media
$product->addMediaFromUrl('https://example.com/image.jpg')
    ->toMediaCollection('gallery');
```

**Key Features**:

- Automatic image optimization and responsive variants
- MIME type validation
- Multiple media collections per model
- Flexible media retrieval and manipulation
- SEO-friendly media URLs

**In This Project**: Handles all product image galleries, category icons, and user avatars with automatic optimization.

---

### 3. **laravel-one-time-passwords** v1.1

**Purpose**: Secure user authentication with OTP support

**Usage**:

```php
use Spatie\OneTimePasswords\Models\Concerns\HasOneTimePasswords;

class User extends Authenticatable
{
    use HasOneTimePasswords;

    // OTP secret is automatically generated and stored
}

// In authentication controller
$user->generateOtpSecret(); // Create OTP secret
$otp = $user->getOtpSecret(); // Retrieve for QR code generation
$user->validateOtp($providedCode); // Verify provided code
```

**Key Features**:

- TOTP (Time-based One-Time Password) implementation
- QR code generation for authenticator apps
- Backup codes for account recovery
- Session-based OTP enforcement
- Time-window validation with configurable grace periods

**In This Project**: Provides optional two-factor authentication for admin accounts and sensitive user operations.

---

### 4. **laravel-permission** v7.3

**Purpose**: Role and permission-based access control

**Usage**:

```php
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;
}

// Assign roles and permissions
$user->assignRole('admin');
$user->givePermissionTo('view.dashboard');
$user->can('edit.products');

// Check permissions in controllers or middleware
if ($user->hasPermissionTo(PermissionEnum::VIEW_DASHBOARD->value)) {
    return redirect('admin.dashboard');
}
```

**Key Features**:

- Hierarchical role and permission system
- Permission inheritance through roles
- Wildcard permission checking
- Middleware guards for route protection
- Flexible permission assignment

**In This Project**: Manages admin access, defines which users can perform specific actions (view products, create orders, etc.), and protects sensitive operations.

---

### 5. **laravel-settings** v3.7

**Purpose**: Persistent application and model-level settings management

**Usage**:

```php
// Define settings with type safety
class GeneralSettings extends Settings
{
    public string $app_name = 'My Store';
    public string $app_email = 'hello@mystore.com';
    public int $tax_rate = 10;

    public static function rules(): array
    {
        return [
            'app_name' => ['required', 'string'],
            'tax_rate' => ['required', 'integer', 'between:0,100'],
        ];
    }
}

// Retrieve and update
$settings = GeneralSettings::all();
$settings->app_name = 'Updated Store';
$settings->save();

// In templates
{{ app(GeneralSettings::class)->app_email }}
```

**Key Features**:

- Type-safe setting definitions
- Automatic validation
- Database or file-based storage
- Easy caching
- Real-time updates

**In This Project**: Manages application-wide settings including `GeneralSettings`, `NotificationSettings`, `OrderSettings`, and `SocialSettings`.

---

### 6. **laravel-sluggable** v3.8

**Purpose**: Automatic SEO-friendly URL generation from model attributes

**Usage**:

```php
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Product extends Model
{
    use HasSlug;

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->slugsShouldBeNoLongerThan(50)
            ->doNotGenerateSlugsOnUpdate(); // Preserve URLs
    }

    public function getRouteKeyName(): string
    {
        return 'slug'; // Use slug for route binding
    }
}

// Usage: /products/awesome-wireless-headphones instead of /products/123
```

**Key Features**:

- Automatic slug generation from any attribute
- Customizable slug formatting
- Multi-language slug support
- Duplicate handling with incremental suffixes
- Preserves URLs across updates

**In This Project**: Used for `Product`, `Category`, and `Order` models to create readable, SEO-optimized URLs that improve search rankings and user experience.

---

### 7. **laravel-tags** v4.11

**Purpose**: Flexible tagging system for intelligent content organization

**Usage**:

```php
use Spatie\Tags\HasTags;

class Product extends Model
{
    use HasTags;
}

// Add tags (automatically deduplicated)
$product->attachTags(['electronics', 'wireless', 'premium']);
$product->syncTags(['new-tag', 'featured']);

// Query by tags
Product::withAnyTags(['electronics', 'wireless'])->get();
Product::withAllTags(['premium', 'featured'])->get();

// Tag management API
$tags = Product::pluck('tags'); // Get all unique tags
TagController::search('elec'); // Search tags
```

**Key Features**:

- Polymorphic tagging (works with any model)
- Automatic tag deduplication
- Flexible querying (any, all, not)
- Tag search functionality
- Performance-optimized queries

**In This Project**: Powers product discovery through tags, category tagging, and the `TagController` API for dynamic tag search and creation.

---

### 8. **laravel-translatable** v6.13

**Purpose**: Multi-language support without database duplication

**Usage**:

```php
use Spatie\Translatable\HasTranslations;

class Product extends Model
{
    use HasTranslations;

    public array $translatable = ['name', 'description'];
}

// Store multi-language data
$product->setTranslation('name', 'en', 'Awesome Product');
$product->setTranslation('name', 'es', 'Producto Increíble');
$product->save();

// Retrieve in specific language
echo app()->getLocale() === 'en'
    ? $product->getTranslation('name', 'en')
    : $product->getTranslation('name', 'es');

// In Blade templates
{{ $product->name }} // Uses current locale
```

**Key Features**:

- Single table for all languages (JSON storage)
- Automatic locale detection
- Fallback language support
- Strict and non-strict modes
- Blade helper support

**In This Project**: Enables `Product` and `Category` names and descriptions to be stored in multiple languages, allowing truly global storefronts without maintaining separate records.

---

## 📂 Project Structure

```
ecommerce-spatie-app/
├── app/
│   ├── Casts/                          # Custom attribute casting
│   ├── Enums/
│   │   └── PermissionEnum.php          # Permission definitions
│   ├── Exports/                        # Excel/CSV exporters
│   │   ├── BaseExport.php              # Base export class
│   │   ├── ActivityExport.php          # Activity log exports
│   │   ├── CategoryExport.php          # Category exports
│   │   ├── NotificationExport.php      # Notification exports
│   │   ├── OrderExport.php             # Order exports
│   │   ├── ProductExport.php           # Product exports
│   │   ├── RoleExport.php              # Role exports
│   │   └── UserExport.php              # User exports
│   ├── Helpers/
│   │   └── CurrencyHelper.php          # Currency formatting utilities
│   ├── Http/
│   │   ├── Controllers/                # Application controllers
│   │   │   ├── Admin/                  # Admin-only endpoints
│   │   │   ├── Auth/                   # Authentication logic
│   │   │   └── ...                     # Resource controllers
│   │   └── Requests/                   # Form request validation
│   ├── Mail/
│   │   └── SendResetLinkMail.php       # Email templates
│   ├── Models/                         # Eloquent models
│   │   ├── User.php                    # (HasActivity, HasRoles, HasOneTimePasswords)
│   │   ├── Product.php                 # (HasMedia, HasSlug, HasTags, HasTranslations)
│   │   ├── Category.php                # (HasActivity, HasSlug, HasTags, HasTranslations)
│   │   ├── Order.php                   # Order management
│   │   ├── OrderItem.php               # Order line items
│   │   ├── OrderStatus.php             # Order status tracking
│   │   └── Message.php                 # Customer messages
│   ├── Notifications/                  # Notification classes
│   │   ├── LowStockNotification.php    # Low stock alerts
│   │   ├── NewMessageNotification.php  # New message alerts
│   │   ├── NewOrderNotification.php    # New order alerts
│   │   └── OrderStatusChangedNotification.php # Order status updates
│   ├── Observers/                      # Model event observers
│   │   └── ProductObserver.php         # Product event handling
│   ├── Policies/                       # Authorization policies
│   ├── Providers/
│   │   └── AppServiceProvider.php      # Service registration
│   ├── Services/                       # Application services
│   │   ├── ExportService.php           # Export operations
│   │   └── MediaLibrary/               # Media processing services
│   └── Settings/                       # Application settings classes
│       ├── GeneralSettings.php
│       ├── NotificationSettings.php
│       ├── OrderSettings.php
│       └── SocialSettings.php
├── bootstrap/
│   ├── app.php                         # Application bootstrapper
│   └── providers.php                   # Service provider loader
├── config/
│   ├── activitylog.php                 # Activity logging config
│   ├── media-library.php               # Media library config
│   ├── permission.php                  # Role/permission config
│   ├── settings.php                    # Settings storage config
│   └── ...                             # Other configuration files
├── database/
│   ├── factories/                      # Model factories for testing
│   ├── migrations/                     # Database schema
│   ├── seeders/                        # Database seeders
│   └── settings/                       # Settings fixtures
├── resources/
│   ├── css/                            # Tailwind CSS stylesheets
│   ├── js/                             # Frontend JavaScript
│   └── views/                          # Blade templates
├── routes/
│   ├── auth.php                        # Authentication routes
│   ├── web.php                         # Public/mixed routes
│   ├── user.php                        # User dashboard routes
│   └── admin.php                       # Admin panel routes
├── storage/
│   ├── app/                            # Application storage
│   ├── media-library/                  # Media library files
│   └── logs/                           # Application logs
├── tests/
│   ├── Feature/                        # Feature tests
│   ├── Unit/                           # Unit tests
│   ├── Pest.php                        # Pest configuration
│   └── TestCase.php                    # Base test class
├── composer.json                       # PHP dependencies
├── package.json                        # Node dependencies
├── vite.config.js                      # Vite build configuration
├── phpunit.xml                         # PHPUnit testing config
└── README.md                           # This file
```

---

## 🛠️ Installation & Setup

### Prerequisites

- **PHP**: 8.3 or higher
- **Composer**: 2.0 or higher
- **Node.js**: 18+ with npm
- **Database**: SQLite (development) or MySQL/PostgreSQL (production)

### Quick Start

1. **Clone the Repository**

    ```bash
    git clone <repository-url>
    cd ecommerce-spatie-app
    ```

2. **Install Dependencies**

    ```bash
    composer install
    npm install
    ```

3. **Environment Configuration**

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4. **Database Setup**

    ```bash
    php artisan migrate:fresh --seed
    ```

5. **Build Assets**

    ```bash
    npm run build
    ```

6. **Start Development Server**
    ```bash
    php artisan serve
    npm run dev  # In another terminal
    ```

### Composer Setup Script

Alternatively, use the included setup script:

```bash
composer run setup
```

This will:

- ✅ Install Composer dependencies
- ✅ Generate application key
- ✅ Run migrations
- ✅ Install npm packages
- ✅ Build frontend assets

---

## 📖 Usage Guide

### Working with Products

```php
// Create a product with translations
$product = Product::create([
    'name' => 'Wireless Headphones', // Default locale
    'description' => 'High-quality audio',
    'price' => 199.99,
    'stock' => 50,
    'category_id' => $category->id,
]);

// Add product images
$product->addMediaFromUrl('https://example.com/product.jpg')
    ->toMediaCollection('gallery');

// Add tags for discoverability
$product->attachTags(['electronics', 'audio', 'wireless']);

// Translate to another language
app()->setLocale('es');
$product->setTranslation('name', 'es', 'Auriculares Inalámbricos');
$product->save();

// Query by attributes
$electronicsProducts = Product::withAnyTags(['electronics'])->active()->get();
```

### Managing Orders

```php
// Create an order
$order = Order::create([
    'user_id' => auth()->id(),
    'order_number' => 'ORD-' . now()->format('YmdHis'),
    'status' => 'pending',
    'subtotal' => 199.99,
    'tax' => 20.00,
    'shipping_cost' => 10.00,
    'total' => 229.99,
    // ... shipping details
]);

// Add items to order
$order->items()->create([
    'product_id' => $product->id,
    'quantity' => 1,
    'price' => 199.99,
]);

// Track status changes
$order->statuses()->create([
    'status' => 'processing',
    'notes' => 'Payment verified',
]);

// Query active orders
$activeOrders = Order::whereIn('status', ['pending', 'processing', 'shipped'])->get();
```

### Admin & Permissions

```php
// Create admin role with permissions
$adminRole = Role::create(['name' => 'admin']);
$adminRole->givePermissionTo([
    PermissionEnum::VIEW_DASHBOARD->value,
    PermissionEnum::MANAGE_PRODUCTS->value,
    PermissionEnum::MANAGE_ORDERS->value,
]);

// Assign role to user
$user->assignRole('admin');

// Check permission in controller
if (!auth()->user()->can(PermissionEnum::MANAGE_PRODUCTS->value)) {
    abort(403, 'Unauthorized');
}

// Or use middleware
Route::post('/products', [ProductController::class, 'store'])
    ->middleware('permission:manage.products');
```

### Activity Logging

```php
// All changes to Category are automatically logged
$category = Category::create(['name' => 'Electronics']);
// Activity created automatically

// View activity history
$activities = $category->activities; // All changes to this category
$history = activity()->forModel($category)->get(); // Same using facade

// Track who made changes
$activity->causer_id; // User ID who made the change
$activity->properties['attributes']; // New values
$activity->properties['old']; // Previous values
$activity->created_at; // When it happened
```

### Settings Management

```php
// Get all settings
$settings = GeneralSettings::all();

// Update settings
$settings->app_name = 'My Awesome Store';
$settings->tax_rate = 15;
$settings->save();

// In Blade templates
<h1>{{ app(GeneralSettings::class)->app_name }}</h1>

// Access in controllers
$general = resolve(GeneralSettings::class);
$taxRate = $general->tax_rate;
```

### Multi-Language Support

```php
// Set default language
app()->setLocale('en');

// Store translations
$product->setTranslation('name', 'en', 'Product Name');
$product->setTranslation('name', 'es', 'Nombre del Producto');
$product->setTranslation('name', 'fr', 'Nom du Produit');
$product->save();

// Retrieve translations
echo $product->getTranslation('name', 'es'); // Nombre del Producto
echo $product->name; // Uses current app locale

// In Blade
@foreach(config('app.supported_locales') as $locale)
    {{ $product->getTranslation('name', $locale) }}
@endforeach
```

### Messaging System

```php
use App\Models\Message;

// Send a message from customer
$message = Message::create([
    'user_id' => auth()->id(),
    'subject' => 'Question about order',
    'body' => 'When will my order ship?',
]);

// Retrieve messages for a user
$inbox = Message::where('user_id', auth()->id())
    ->latest()
    ->paginate(15);

// Send notification on new message
$user->notify(new NewMessageNotification($message));

// Mark as read
$message->update(['read_at' => now()]);
```

### Notifications

```php
use App\Notifications\NewOrderNotification;
use App\Notifications\OrderStatusChangedNotification;
use App\Notifications\LowStockNotification;

// Notify admin of new order
$admin->notify(new NewOrderNotification($order));

// Notify customer of status change
$customer->notify(new OrderStatusChangedNotification($order));

// Alert on low stock
if ($product->stock < 10) {
    admin()->notify(new LowStockNotification($product));
}

// Check notification settings
$settings = app(NotificationSettings::class);
if ($settings->enable_email_notifications) {
    $user->notifyNow(new NewOrderNotification($order));
}
```

---

## 🏛️ Architecture Highlights

### Model Relationships

```
User (HasRoles, HasActivity, HasOneTimePasswords)
├── HasMany: Orders
├── HasMany: Messages
└── HasMany: Activity Logs

Product (HasMedia, HasSlug, HasTags, HasTranslations)
├── BelongsTo: Category
├── HasMany: OrderItems
├── HasMany: Media (gallery)
└── HasMany: Tags

Category (HasActivity, HasSlug, HasTags, HasTranslations)
├── HasMany: Products
├── HasMany: Activity Logs
└── HasMany: Tags

Order
├── BelongsTo: User
├── HasMany: OrderItems
└── HasMany: OrderStatuses

OrderItem
├── BelongsTo: Order
└── BelongsTo: Product

Message
└── BelongsTo: User
```

### Authorization Flow

```
User Request
    ↓
Middleware (auth, permission)
    ↓
Controller
    ↓
Policy Authorization (authorize())
    ↓
Model Operation
    ↓
Activity Logged Automatically
```

### Settings Architecture

```
GeneralSettings    → App name, contact email, timezone
OrderSettings      → Tax rates, shipping, default statuses
NotificationSettings → Email templates, notification channels
SocialSettings     → Social media links, OAuth config
```

---

## 🧪 Testing

This project uses **Pest PHP** for elegant, expressive testing:

### Running Tests

```bash
# Run all tests
composer test

# Run specific test file
php artisan test tests/Feature/ProductTest.php

# Run with coverage
php artisan test --coverage

# Watch mode (reruns on file changes)
php artisan test --watch
```

### Test Structure

```
tests/
├── Feature/                    # Integration tests
│   ├── AuthTest.php
│   ├── ProductTest.php
│   ├── OrderTest.php
│   └── ...
├── Unit/                       # Unit tests
│   ├── Models/
│   └── Services/
├── Pest.php                    # Pest configuration
└── TestCase.php                # Base test class
```

---

## ⚡ Performance Considerations

### Spatie Package Optimizations

1. **Activity Logging**: Only logs specified attributes with `logOnly()` and `logOnlyDirty()`
2. **Media Library**: Automatic image optimization and responsive variants
3. **Permissions**: Role/permission caching with `artisan permission:cache-reset`
4. **Settings**: File/database caching for rapid access
5. **Tags**: Indexed database queries for efficient filtering
6. **Translations**: Single JSON column with implicit fallbacks

### Database Optimization

- Proper indexing on frequently queried columns (slug, status, tags)
- Soft deletes on appropriate models
- Query eager loading with relationships
- Database query caching for global settings

### Frontend Performance

- Vite for fast builds in development
- Tailwind CSS with JIT compilation
- Responsive image serving via Media Library
- Asset versioning for cache busting

---

## Screenshots

Screenshots of the application are included in the repository's `Screenshots` directory. See the [screenshots table](#screenshots-table) below for direct links to each image.

### Screenshots Table

| Filename            | Link                                                                   |
| ------------------- | ---------------------------------------------------------------------- |
| Screenshot (1).png  | [Screenshots/Screenshot (1).png](<Screenshots/Screenshot%20(1).png>)   |
| Screenshot (2).png  | [Screenshots/Screenshot (2).png](<Screenshots/Screenshot%20(2).png>)   |
| Screenshot (3).png  | [Screenshots/Screenshot (3).png](<Screenshots/Screenshot%20(3).png>)   |
| Screenshot (4).png  | [Screenshots/Screenshot (4).png](<Screenshots/Screenshot%20(4).png>)   |
| Screenshot (5).png  | [Screenshots/Screenshot%20(5).png](<Screenshots/Screenshot%20(5).png>) |
| Screenshot (6).png  | [Screenshots/Screenshot%20(6).png](<Screenshots/Screenshot%20(6).png>) |
| Screenshot (7).png  | [Screenshots/Screenshot%20(7).png](<Screenshots/Screenshot%20(7).png>) |
| Screenshot (8).png  | [Screenshots/Screenshot%20(8).png](<Screenshots/Screenshot%20(8).png>) |
| Screenshot (9).png  | [Screenshots/Screenshot (9).png](<Screenshots/Screenshot%20(9).png>)   |
| Screenshot (10).png | [Screenshots/Screenshot (10).png](<Screenshots/Screenshot%20(10).png>) |
| Screenshot (11).png | [Screenshots/Screenshot (11).png](<Screenshots/Screenshot%20(11).png>) |
| Screenshot (12).png | [Screenshots/Screenshot (12).png](<Screenshots/Screenshot%20(12).png>) |
