<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database with aesthetic Bakery & Pastry shop data.
     */
    public function run(): void
    {
        // 1. Users (Admin, Staff, Customer)
        $admin = User::firstOrCreate(
            ['email' => 'admin@nazelle.test'],
            [
                'name' => 'Madame Nazelle (Owner & Head Admin)',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        User::firstOrCreate(
            ['email' => 'admin@bakery.test'],
            [
                'name' => 'Madame Nazelle (Admin Owner)',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // Keep alias for compatibility with tests
        User::firstOrCreate(
            ['email' => 'admin@inventory.test'],
            [
                'name' => 'Admin Owner',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        $staff = User::firstOrCreate(
            ['email' => 'staff@nazelle.test'],
            [
                'name' => 'Chef Pierre (Head Baker & Kasir)',
                'password' => Hash::make('password'),
                'role' => 'staff',
            ]
        );

        User::firstOrCreate(
            ['email' => 'staff@bakery.test'],
            [
                'name' => 'Chef Pierre (Head Baker & Kasir)',
                'password' => Hash::make('password'),
                'role' => 'staff',
            ]
        );

        User::firstOrCreate(
            ['email' => 'staff@inventory.test'],
            [
                'name' => 'Staff Gudang & Kasir',
                'password' => Hash::make('password'),
                'role' => 'staff',
            ]
        );

        $customer = User::firstOrCreate(
            ['email' => 'pelanggan@nazelle.test'],
            [
                'name' => 'Sophie Martin (Pelanggan Setia)',
                'password' => Hash::make('password'),
                'role' => 'customer',
            ]
        );

        User::firstOrCreate(
            ['email' => 'pelanggan@bakery.test'],
            [
                'name' => 'Budi Santoso (Pelanggan Setia)',
                'password' => Hash::make('password'),
                'role' => 'customer',
            ]
        );

        User::firstOrCreate(
            ['email' => 'pelanggan@inventory.test'],
            [
                'name' => 'Budi Pelanggan',
                'password' => Hash::make('password'),
                'role' => 'customer',
            ]
        );

        // 2. Bakery Categories
        $catViennoiserie = Category::firstOrCreate(
            ['name' => 'Viennoiserie & Croissant'],
            ['description' => 'Laminated pastry khas Prancis dengan mentega AOP Normandia, renyah berlapis dan beraroma harum mentega.']
        );

        $catSourdough = Category::firstOrCreate(
            ['name' => 'Artisan Breads & Sourdough'],
            ['description' => 'Roti artisan tradisional fermentasi liar alami 36 jam, bertekstur kerak renyah (crust) dan pori sarang lebah yang kenyal.']
        );

        $catPatisserie = Category::firstOrCreate(
            ['name' => 'French Patisserie & Tarts'],
            ['description' => 'Kue tart buah segar, éclairs krim vanilla Madagaskar, dan mille-feuille renyah khas pastry shop Paris.']
        );

        $catCakes = Category::firstOrCreate(
            ['name' => 'Artisan Cakes & Gateaux'],
            ['description' => 'Koleksi cake lembut premium, Basque burnt cheesecake, dan gateau cokelat Valrhona.']
        );

        $catSavory = Category::firstOrCreate(
            ['name' => 'Savory Bakes & Quiche'],
            ['description' => 'Pilihan pastry gurih lezat, quiche keju Gruyère & daging asap, serta flaky sausage roll.']
        );

        $catBeverages = Category::firstOrCreate(
            ['name' => 'Specialty Coffee & Beverages'],
            ['description' => 'Minuman pendamping pastry: kopi racikan biji Arabika pilihan, latte oat milk, dan teh artisan.']
        );

        // 3. Suppliers (Bahan Baku & Perlengkapan Pastry)
        $supFlour = Supplier::firstOrCreate(
            ['name' => 'PT Bogasari Artisan Flour Mills'],
            [
                'phone' => '0812-3456-7890',
                'email' => 'bogasari.artisan@supplier.test',
                'address' => 'Kawasan Industri Ancol Barat No. 8, Jakarta Utara (Distributor Tepung Terigu T55 & Rye Organik)',
            ]
        );

        $supDairy = Supplier::firstOrCreate(
            ['name' => 'Elle & Vire Dairy Normandy Distribution'],
            [
                'phone' => '0821-4567-8901',
                'email' => 'ellevire.dairy@supplier.test',
                'address' => 'Jl. Boulevard Raya Barat No. 45, Tangerang Selatan (Importir Mentega Prancis 84% & Heavy Cream)',
            ]
        );

        $supChoco = Supplier::firstOrCreate(
            ['name' => 'Valrhona Cacao & Chocolate Indonesia'],
            [
                'phone' => '0831-5678-9012',
                'email' => 'valrhona.id@supplier.test',
                'address' => 'Gedung Kencana Suite Lt. 5, Jl. Gatot Subroto, Jakarta Selatan (Biji Cokelat Cacao & Batang Cokelat Couverture)',
            ]
        );

        $supYeast = Supplier::firstOrCreate(
            ['name' => 'Lesaffre Baking Solutions France'],
            [
                'phone' => '0852-6789-0123',
                'email' => 'lesaffre.baking@supplier.test',
                'address' => 'Jl. Industri Rungkut V No. 12, Surabaya (Ragi Alami, Sourdough Starter & Bread Improver)',
            ]
        );

        // 4. Products (Aesthetic Pastries & Breads)
        $bakeryProducts = [
            [
                'category_id' => $catViennoiserie->id,
                'sku' => 'BAK-VNN-001',
                'name' => 'Croissant au Beurre Pure French Butter',
                'description' => 'Croissant autentik Prancis berlapis 27 lipatan mentega Normandia AOP. Renyah keemasan di luar, lembut sarang lebah di dalam.',
                'image_url' => 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?auto=format&fit=crop&w=600&q=80',
                'purchase_price' => 12000,
                'selling_price' => 24000,
                'stock' => 28,
                'minimum_stock' => 6,
            ],
            [
                'category_id' => $catViennoiserie->id,
                'sku' => 'BAK-VNN-002',
                'name' => 'Pain au Chocolat Valrhona 70%',
                'description' => 'Pastry mentega renyah dengan isian ganda cokelat batangan hitam Valrhona Prancis yang meleleh di mulut.',
                'image_url' => 'https://images.unsplash.com/photo-1608198093002-ad4e005484ec?auto=format&fit=crop&w=600&q=80',
                'purchase_price' => 15000,
                'selling_price' => 28000,
                'stock' => 18,
                'minimum_stock' => 5,
            ],
            [
                'category_id' => $catViennoiserie->id,
                'sku' => 'BAK-VNN-003',
                'name' => 'Almond Frangipane Twice-Baked Croissant',
                'description' => 'Croissant dipanggang dua kali dengan sirup vanilla, pasta krim almond frangipane dan taburan almond panggang renyah.',
                'image_url' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&w=600&q=80',
                'purchase_price' => 18000,
                'selling_price' => 34000,
                'stock' => 14,
                'minimum_stock' => 4,
            ],
            [
                'category_id' => $catViennoiserie->id,
                'sku' => 'BAK-VNN-004',
                'name' => 'Cinnamon Brioche Swirl with Cream Cheese Glaze',
                'description' => 'Roti brioche kaya telur dan mentega, digulung dengan kayu manis Ceylon aromatik dan lelehan cream cheese manis legit.',
                'image_url' => 'https://images.unsplash.com/photo-1509365465985-25d11c17e812?auto=format&fit=crop&w=600&q=80',
                'purchase_price' => 14000,
                'selling_price' => 26000,
                'stock' => 3, // LOW STOCK ALERT!
                'minimum_stock' => 6,
            ],
            [
                'category_id' => $catSourdough->id,
                'sku' => 'BAK-BRD-001',
                'name' => 'Rustic Country Sourdough Boule (750g)',
                'description' => 'Roti sourdough bundar klasik dengan fermentasi ragi alami 36 jam. Tanpa pengawet, ramah pencernaan dan beraroma khas.',
                'image_url' => 'https://images.unsplash.com/photo-1586444248902-2f64eddc13df?auto=format&fit=crop&w=600&q=80',
                'purchase_price' => 22000,
                'selling_price' => 45000,
                'stock' => 15,
                'minimum_stock' => 4,
            ],
            [
                'category_id' => $catSourdough->id,
                'sku' => 'BAK-BRD-002',
                'name' => 'Artisan French Baguette Traditionelle',
                'description' => 'Baguette tradisional Prancis berkerak garing keemasan dengan rongga udara besar dan aroma gandum alami.',
                'image_url' => 'https://images.unsplash.com/photo-1589367920969-ab8e050bbb04?auto=format&fit=crop&w=600&q=80',
                'purchase_price' => 9000,
                'selling_price' => 19000,
                'stock' => 22,
                'minimum_stock' => 5,
            ],
            [
                'category_id' => $catSourdough->id,
                'sku' => 'BAK-BRD-003',
                'name' => 'Cranberry & Roasted Walnut Sourdough',
                'description' => 'Paduan buah cranberry kering yang manis-asam dengan kacang kenari panggang dalam adonan sourdough artisan.',
                'image_url' => 'https://images.unsplash.com/photo-1549931319-a545dcf3bc73?auto=format&fit=crop&w=600&q=80',
                'purchase_price' => 27000,
                'selling_price' => 52000,
                'stock' => 8,
                'minimum_stock' => 3,
            ],
            [
                'category_id' => $catSourdough->id,
                'sku' => 'BAK-BRD-004',
                'name' => 'Japanese Shokupan Milk Bread Loaf',
                'description' => 'Roti tawar Jepang selembut awan yang dibuat dengan metode Yudane dan susu segar murni.',
                'image_url' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&w=600&q=80',
                'purchase_price' => 16000,
                'selling_price' => 32000,
                'stock' => 2, // LOW STOCK ALERT!
                'minimum_stock' => 5,
            ],
            [
                'category_id' => $catPatisserie->id,
                'sku' => 'BAK-PAT-001',
                'name' => 'Fresh Strawberry Charlotte Vanilla Tart',
                'description' => 'Tartlet renyah dengan krim pastry vanilla bourbon Madagaskar dan hiasan stroberi segar organik.',
                'image_url' => 'https://images.unsplash.com/photo-1519869325930-281384150729?auto=format&fit=crop&w=600&q=80',
                'purchase_price' => 20000,
                'selling_price' => 38000,
                'stock' => 12,
                'minimum_stock' => 3,
            ],
            [
                'category_id' => $catPatisserie->id,
                'sku' => 'BAK-PAT-002',
                'name' => 'Madagascar Vanilla Bean Éclair',
                'description' => 'Kue choux Prancis memanjang diisi diplomat cream vanilla dan disiram glasir cokelat mengkilap.',
                'image_url' => 'https://images.unsplash.com/photo-1587314168485-3236d6710814?auto=format&fit=crop&w=600&q=80',
                'purchase_price' => 15000,
                'selling_price' => 28000,
                'stock' => 16,
                'minimum_stock' => 4,
            ],
            [
                'category_id' => $catPatisserie->id,
                'sku' => 'BAK-PAT-003',
                'name' => 'Kyoto Matcha Green Tea Mille-Feuille',
                'description' => 'Tumpukan puff pastry renyah berkaramel dengan lapisan krim teh hijau Kyoto Uji Matcha asli.',
                'image_url' => 'https://images.unsplash.com/photo-1535141192574-5d4897c13136?auto=format&fit=crop&w=600&q=80',
                'purchase_price' => 22000,
                'selling_price' => 42000,
                'stock' => 9,
                'minimum_stock' => 3,
            ],
            [
                'category_id' => $catCakes->id,
                'sku' => 'BAK-CAK-001',
                'name' => 'Basque Burnt Cheesecake Slice',
                'description' => 'Kue keju khas San Sebastian dengan permukaan berkaramel terbakar dan bagian tengah yang lumer lembut.',
                'image_url' => 'https://images.unsplash.com/photo-1533134242443-d4fd215305ad?auto=format&fit=crop&w=600&q=80',
                'purchase_price' => 18000,
                'selling_price' => 36000,
                'stock' => 11,
                'minimum_stock' => 4,
            ],
            [
                'category_id' => $catCakes->id,
                'sku' => 'BAK-CAK-002',
                'name' => 'Classic French Opera Gateau',
                'description' => 'Lapisan kue sponge almond joconde yang direndam sirup kopi, ganache cokelat pekat, dan buttercream kopi Prancis.',
                'image_url' => 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?auto=format&fit=crop&w=600&q=80',
                'purchase_price' => 25000,
                'selling_price' => 46000,
                'stock' => 7,
                'minimum_stock' => 3,
            ],
            [
                'category_id' => $catSavory->id,
                'sku' => 'BAK-SAV-001',
                'name' => 'Classic Smoked Beef & Gruyère Quiche',
                'description' => 'Pai gurih berkerak renyah berisi custard telur, daging sapi asap pilihan, dan keju Gruyère lezat.',
                'image_url' => 'https://images.unsplash.com/photo-1621996346565-e3d5d6281292?auto=format&fit=crop&w=600&q=80',
                'purchase_price' => 20000,
                'selling_price' => 38000,
                'stock' => 10,
                'minimum_stock' => 3,
            ],
            [
                'category_id' => $catBeverages->id,
                'sku' => 'BAK-BEV-001',
                'name' => 'Artisan Oat Milk Latte (Single Origin)',
                'description' => 'Kopi espresso double shot dengan susu oat organik berbusa lembut, aroma kacang hangat yang menenangkan.',
                'image_url' => 'https://images.unsplash.com/photo-1514432324607-a09d9b4aefdd?auto=format&fit=crop&w=600&q=80',
                'purchase_price' => 12000,
                'selling_price' => 30000,
                'stock' => 50,
                'minimum_stock' => 10,
            ],
            [
                'category_id' => $catBeverages->id,
                'sku' => 'BAK-BEV-002',
                'name' => 'Kyoto Uji Iced Matcha Latte',
                'description' => 'Teh hijau matcha ceremonial grade dari Kyoto, diseduh dengan susu segar dingin dan sentuhan manis madu.',
                'image_url' => 'https://images.unsplash.com/photo-1536256263959-770b48d82b0a?auto=format&fit=crop&w=600&q=80',
                'purchase_price' => 14000,
                'selling_price' => 32000,
                'stock' => 45,
                'minimum_stock' => 10,
            ],
        ];

        $createdProducts = [];
        foreach ($bakeryProducts as $item) {
            $createdProducts[$item['sku']] = Product::updateOrCreate(
                ['sku' => $item['sku']],
                $item
            );
        }

        // 5. Initial Demo Purchases (Stock-In from Bakery Suppliers)
        $purchase1 = Purchase::firstOrCreate(
            ['purchase_number' => 'PO-20261020-001'],
            [
                'supplier_id' => $supDairy->id,
                'user_id' => $admin->id,
                'total' => 1260000,
                'status' => 'completed',
                'purchased_at' => now()->subDays(4),
                'notes' => 'Restock bahan mentega Elle & Vire Normandy dan krim untuk produksi croissant mingguan',
            ]
        );

        $purchase1->items()->firstOrCreate(
            ['product_id' => $createdProducts['BAK-VNN-001']->id],
            [
                'quantity' => 50,
                'unit_cost' => 12000,
                'subtotal' => 600000,
            ]
        );
        $purchase1->items()->firstOrCreate(
            ['product_id' => $createdProducts['BAK-VNN-002']->id],
            [
                'quantity' => 30,
                'unit_cost' => 15000,
                'subtotal' => 450000,
            ]
        );
        $purchase1->items()->firstOrCreate(
            ['product_id' => $createdProducts['BAK-PAT-001']->id],
            [
                'quantity' => 10,
                'unit_cost' => 20000,
                'subtotal' => 200000,
            ]
        );

        $purchase2 = Purchase::firstOrCreate(
            ['purchase_number' => 'PO-20261022-002'],
            [
                'supplier_id' => $supFlour->id,
                'user_id' => $staff->id,
                'total' => 660000,
                'status' => 'completed',
                'purchased_at' => now()->subDays(2),
                'notes' => 'Pengadaan gandum khusus artisan untuk sourdough dan French baguette',
            ]
        );

        $purchase2->items()->firstOrCreate(
            ['product_id' => $createdProducts['BAK-BRD-001']->id],
            [
                'quantity' => 20,
                'unit_cost' => 22000,
                'subtotal' => 440000,
            ]
        );
        $purchase2->items()->firstOrCreate(
            ['product_id' => $createdProducts['BAK-BRD-002']->id],
            [
                'quantity' => 20,
                'unit_cost' => 9000,
                'subtotal' => 180000,
            ]
        );

        // 6. Initial Demo Sales (Kasir & Pesanan Pelanggan)
        $sale1 = Sale::firstOrCreate(
            ['sale_number' => 'INV-20261024-001'],
            [
                'user_id' => $staff->id,
                'customer_name' => 'Budi Santoso (Pelanggan Setia)',
                'total' => 104000,
                'status' => 'completed',
                'sold_at' => now()->subDays(1)->setTime(8, 30),
                'notes' => 'Pesanan sarapan pagi: Croissant, Pain au Chocolat, dan Iced Latte',
            ]
        );

        $sale1->items()->firstOrCreate(
            ['product_id' => $createdProducts['BAK-VNN-001']->id],
            [
                'quantity' => 2,
                'unit_price' => 24000,
                'subtotal' => 48000,
            ]
        );
        $sale1->items()->firstOrCreate(
            ['product_id' => $createdProducts['BAK-VNN-002']->id],
            [
                'quantity' => 1,
                'unit_price' => 28000,
                'subtotal' => 28000,
            ]
        );
        $sale1->items()->firstOrCreate(
            ['product_id' => $createdProducts['BAK-BEV-001']->id],
            [
                'quantity' => 1,
                'unit_price' => 30000,
                'subtotal' => 30000,
            ]
        );

        $sale2 = Sale::firstOrCreate(
            ['sale_number' => 'INV-20261025-002'],
            [
                'user_id' => $customer->id,
                'customer_name' => 'Clara Aurelia',
                'total' => 120000,
                'status' => 'completed',
                'sold_at' => now()->subHours(5),
                'notes' => 'Pesan via Online Storefront: Country Sourdough, Strawberry Tart, & Baguette',
            ]
        );

        $sale2->items()->firstOrCreate(
            ['product_id' => $createdProducts['BAK-BRD-001']->id],
            [
                'quantity' => 1,
                'unit_price' => 45000,
                'subtotal' => 45000,
            ]
        );
        $sale2->items()->firstOrCreate(
            ['product_id' => $createdProducts['BAK-PAT-001']->id],
            [
                'quantity' => 1,
                'unit_price' => 38000,
                'subtotal' => 38000,
            ]
        );
        $sale2->items()->firstOrCreate(
            ['product_id' => $createdProducts['BAK-BRD-002']->id],
            [
                'quantity' => 1,
                'unit_price' => 19000,
                'subtotal' => 19000,
            ]
        );

        $sale3 = Sale::firstOrCreate(
            ['sale_number' => 'INV-20261025-003'],
            [
                'user_id' => $staff->id,
                'customer_name' => 'Kafe Senja Kopi',
                'total' => 160000,
                'status' => 'completed',
                'sold_at' => now()->subHours(2),
                'notes' => 'Pesanan B2B batch croissant & cinnamon swirl',
            ]
        );

        $sale3->items()->firstOrCreate(
            ['product_id' => $createdProducts['BAK-VNN-001']->id],
            [
                'quantity' => 4,
                'unit_price' => 24000,
                'subtotal' => 96000,
            ]
        );
        $sale3->items()->firstOrCreate(
            ['product_id' => $createdProducts['BAK-VNN-004']->id],
            [
                'quantity' => 2,
                'unit_price' => 26000,
                'subtotal' => 52000,
            ]
        );
    }
}
