<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => ['en' => 'Electronics', 'ar' => 'الإلكترونيات'],
                'description' => ['en' => 'Discover the latest gadgets and electronic devices', 'ar' => 'اكتشف أحدث الأجهزة والأدوات الإلكترونية'],
                'icon' => "fa fa-solid fa-tv",
                'products' => 20,
                'productNames' => [
                    ['en' => 'Smartphone Pro Max', 'ar' => 'هاتف ذكي برو ماكس'],
                    ['en' => 'Wireless Earbuds', 'ar' => 'سماعات أذن لاسلكية'],
                    ['en' => 'Laptop Computer', 'ar' => 'حاسوب محمول'],
                    ['en' => 'Smart Watch', 'ar' => 'ساعة ذكية'],
                    ['en' => 'USB-C Cable', 'ar' => 'كابل يو إس بي'],
                    ['en' => 'Power Bank', 'ar' => 'بنك الطاقة'],
                    ['en' => 'Portable Speaker', 'ar' => 'مكبر صوت محمول'],
                    ['en' => '4K Webcam', 'ar' => 'كاميرا ويب 4K'],
                    ['en' => 'Mechanical Keyboard', 'ar' => 'لوحة مفاتيح ميكانيكية'],
                    ['en' => 'Gaming Mouse', 'ar' => 'فأرة ألعاب'],
                ]
            ],
            [
                'name' => ['en' => 'Fashion & Apparel', 'ar' => 'الموضة والملابس'],
                'description' => ['en' => 'Trendy clothing and accessories for every style', 'ar' => 'ملابس وإكسسوارات عصرية لكل أسلوب'],
                'icon' => "fa fa-solid fa-tshirt",
                'products' => 25,
                'productNames' => [
                    ['en' => 'Designer T-Shirt', 'ar' => 'قميص مصمم'],
                    ['en' => 'Denim Jeans', 'ar' => 'بنطال جينز'],
                    ['en' => 'Casual Sneakers', 'ar' => 'أحذية رياضية عادية'],
                    ['en' => 'Leather Jacket', 'ar' => 'سترة جلدية'],
                    ['en' => 'Summer Dress', 'ar' => 'فستان صيفي'],
                    ['en' => 'Winter Coat', 'ar' => 'معطف شتوي'],
                    ['en' => 'Sports Cap', 'ar' => 'قبعة رياضية'],
                    ['en' => 'Silk Scarf', 'ar' => 'وشاح حريري'],
                ]
            ],
            [
                'name' => ['en' => 'Home & Kitchen', 'ar' => 'المنزل والمطبخ'],
                'description' => ['en' => 'Everything you need to make your home beautiful', 'ar' => 'كل ما تحتاجه لجعل منزلك جميل'],
                'icon' => "fa fa-solid fa-home",
                'products' => 22,
                'productNames' => [
                    ['en' => 'Coffee Maker', 'ar' => 'آلة القهوة'],
                    ['en' => 'Blender', 'ar' => 'خلاط'],
                    ['en' => 'Cookware Set', 'ar' => 'مجموعة أواني الطهي'],
                    ['en' => 'Dining Table', 'ar' => 'طاولة الطعام'],
                    ['en' => 'Kitchen Knives', 'ar' => 'سكاكين المطبخ'],
                    ['en' => 'Microwave Oven', 'ar' => 'فرن ميكروويف'],
                    ['en' => 'Cutting Board', 'ar' => 'لوح التقطيع'],
                ]
            ],
            [
                'name' => ['en' => 'Sports & Outdoors', 'ar' => 'الرياضة والأنشطة الخارجية'],
                'description' => ['en' => 'High-quality sports equipment for active lifestyle', 'ar' => 'معدات رياضية عالية الجودة لنمط حياة نشط'],
                'icon' => "fa fa-solid fa-futbol",
                'products' => 20,
                'productNames' => [
                    ['en' => 'Running Shoes', 'ar' => 'أحذية جري'],
                    ['en' => 'Yoga Mat', 'ar' => 'حصيرة اليوغا'],
                    ['en' => 'Dumbbell Set', 'ar' => 'مجموعة الأثقال'],
                    ['en' => 'Football', 'ar' => 'كرة القدم'],
                    ['en' => 'Tent', 'ar' => 'خيمة'],
                    ['en' => 'Bicycle', 'ar' => 'دراجة'],
                    ['en' => 'Swimming Goggles', 'ar' => 'نظارات السباحة'],
                ]
            ],
            [
                'name' => ['en' => 'Books & Media', 'ar' => 'الكتب والوسائط'],
                'description' => ['en' => 'Expand your knowledge with our collection of books', 'ar' => 'وسع معرفتك من خلال مجموعة الكتب لدينا'],
                'icon' => "fa fa-solid fa-book",
                'products' => 18,
                'productNames' => [
                    ['en' => 'Fiction Novel', 'ar' => 'رواية خيالية'],
                    ['en' => 'Self-Help Book', 'ar' => 'كتاب المساعدة الذاتية'],
                    ['en' => 'Business Guide', 'ar' => 'دليل الأعمال'],
                    ['en' => 'Cookbook', 'ar' => 'كتاب الطبخ'],
                    ['en' => 'History Book', 'ar' => 'كتاب التاريخ'],
                ]
            ],
            [
                'name' => ['en' => 'Beauty & Personal Care', 'ar' => 'الجمال والعناية الشخصية'],
                'description' => ['en' => 'Premium beauty products for self-care', 'ar' => 'منتجات جمال متميزة للعناية الذاتية'],
                'icon' => "fa fa-solid fa-spa",
                'products' => 24,
                'productNames' => [
                    ['en' => 'Face Moisturizer', 'ar' => 'مرطب الوجه'],
                    ['en' => 'Shampoo & Conditioner', 'ar' => 'شامبو وبلسم'],
                    ['en' => 'Face Mask', 'ar' => 'قناع الوجه'],
                    ['en' => 'Perfume', 'ar' => 'عطر'],
                    ['en' => 'Makeup Brush Set', 'ar' => 'مجموعة فرش المكياج'],
                    ['en' => 'Lip Balm', 'ar' => 'مرطب الشفاه'],
                ]
            ],
            [
                'name' => ['en' => 'Toys & Games', 'ar' => 'الألعاب والأنشطة'],
                'description' => ['en' => 'Fun and educational toys for all ages', 'ar' => 'ألعاب ممتعة وتعليمية لجميع الأعمار'],
                'icon' => "fa fa-solid fa-gamepad",
                'products' => 20,
                'productNames' => [
                    ['en' => 'Building Blocks', 'ar' => 'كتل البناء'],
                    ['en' => 'Board Game', 'ar' => 'لعبة الطاولة'],
                    ['en' => 'Action Figure', 'ar' => 'شخصية حركة'],
                    ['en' => 'Puzzle Game', 'ar' => 'لعبة الألغاز'],
                    ['en' => 'RC Car', 'ar' => 'سيارة تحكم عن بعد'],
                ]
            ],
            [
                'name' => ['en' => 'Food & Beverages', 'ar' => 'الغذاء والمشروبات'],
                'description' => ['en' => 'Quality snacks and beverages delivered to you', 'ar' => 'وجبات خفيفة ومشروبات عالية الجودة'],
                'icon' => "fa fa-solid fa-utensils",
                'products' => 22,
                'productNames' => [
                    ['en' => 'Organic Coffee Beans', 'ar' => 'حبوب القهوة العضوية'],
                    ['en' => 'Green Tea', 'ar' => 'الشاي الأخضر'],
                    ['en' => 'Nuts Mix', 'ar' => 'خليط المكسرات'],
                    ['en' => 'Dark Chocolate', 'ar' => 'الشوكولاتة الداكنة'],
                    ['en' => 'Granola Bars', 'ar' => 'أشرطة الجرانولا'],
                    ['en' => 'Honey', 'ar' => 'العسل'],
                ]
            ],
            [
                'name' => ['en' => 'Furniture', 'ar' => 'الأثاث'],
                'description' => ['en' => 'Modern furniture for contemporary homes', 'ar' => 'أثاث حديث للمنازل المعاصرة'],
                'icon' => "fa fa-solid fa-couch",
                'products' => 18,
                'productNames' => [
                    ['en' => 'Office Chair', 'ar' => 'كرسي المكتب'],
                    ['en' => 'Bookshelf', 'ar' => 'رف الكتب'],
                    ['en' => 'Coffee Table', 'ar' => 'طاولة القهوة'],
                    ['en' => 'Sofa', 'ar' => 'أريكة'],
                    ['en' => 'Bed Frame', 'ar' => 'إطار السرير'],
                ]
            ],
        ];

        foreach ($categories as $catData) {
            $category = Category::create([
                'name' => $catData['name'],
                'description' => $catData['description'],
                'slug' => Str::slug($catData['name']['en']) . '-' . Str::random(6),
                'is_active' => true,
                'icon' => $catData['icon'],
            ]);

            // Create products with real data
            $productCount = $catData['products'];
            $productNames = $catData['productNames'];
            
            for ($i = 0; $i < $productCount; $i++) {
                $productData = $productNames[$i % count($productNames)];
                
                // Add some variation to product names
                if ($i >= count($productNames)) {
                    $productData['en'] .= ' v' . intval($i / count($productNames));
                    $productData['ar'] .= ' الإصدار ' . intval($i / count($productNames));
                }
                
                $product = Product::create([
                    'category_id' => $category->id,
                    'name' => [
                        'en' => $productData['en'],
                        'ar' => $productData['ar'],
                    ],
                    'description' => [
                        'en' => 'High quality ' . strtolower($productData['en']) . ' with excellent features',
                        'ar' => 'منتج عالي الجودة مع ميزات ممتازة',
                    ],
                    'slug' => Str::slug($productData['en']) . '-' . Str::random(6),
                    'price' => mt_rand(10, 300),
                    'stock' => mt_rand(5, 500),
                    'is_active' => true,
                    'is_featured' => mt_rand(0, 1),
                ]);

                // Add some random images to products
                $product->addMediaFromUrl('https://placehold.co/400x400.png?text=' . urlencode($productData['en']))
                    ->toMediaCollection('gallery');
            }
        }
    }
}