<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class InventoryAndSalesTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $staff;
    protected Category $category;
    protected Supplier $supplier;
    protected Product $product;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::create([
            'name' => 'Admin Test',
            'email' => 'admin@test.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $this->staff = User::create([
            'name' => 'Staff Test',
            'email' => 'staff@test.com',
            'password' => Hash::make('password'),
            'role' => 'staff',
        ]);

        $this->category = Category::create([
            'name' => 'Elektronik',
            'description' => 'Kategori elektronik',
        ]);

        $this->supplier = Supplier::create([
            'name' => 'PT Supplier Utama',
            'phone' => '08123456789',
            'email' => 'supplier@test.com',
            'address' => 'Jl. Industri',
        ]);

        $this->product = Product::create([
            'category_id' => $this->category->id,
            'sku' => 'TEST-001',
            'name' => 'Barang Uji 1',
            'purchase_price' => 50000,
            'selling_price' => 80000,
            'stock' => 10,
            'minimum_stock' => 3,
        ]);
    }

    /** 1. Auth Test: Guest cannot access dashboard */
    public function test_guest_cannot_access_dashboard_and_is_redirected_to_login(): void
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect('/login');
    }

    /** 2. Auth Test: Invalid credentials rejected */
    public function test_user_cannot_login_with_invalid_credentials(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@test.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors(['email' => 'Email atau kata sandi salah']);
        $this->assertGuest();
    }

    /** Demo bypass route is removed and returns 404 */
    public function test_demo_bypass_route_is_removed(): void
    {
        $response = $this->get('/demo-login/admin');
        $response->assertStatus(404);
    }

    /** 3. Auth Test: Valid credentials successful */
    public function test_user_can_login_with_valid_credentials(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@test.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($this->admin);
    }

    /** 4. Master Data: Duplicate SKU & negative price rejected */
    public function test_product_creation_rejects_duplicate_sku_and_negative_price(): void
    {
        $this->actingAs($this->admin);

        // Attempt duplicate SKU
        $response = $this->post('/products', [
            'sku' => 'TEST-001', // already exists
            'name' => 'Produk Duplikat',
            'category_id' => $this->category->id,
            'purchase_price' => 10000,
            'selling_price' => 20000,
            'stock' => 5,
            'minimum_stock' => 2,
        ]);
        $response->assertSessionHasErrors('sku');

        // Attempt negative price
        $response2 = $this->post('/products', [
            'sku' => 'TEST-002',
            'name' => 'Produk Negatif',
            'category_id' => $this->category->id,
            'purchase_price' => -5000,
            'selling_price' => 20000,
            'stock' => 5,
            'minimum_stock' => 2,
        ]);
        $response2->assertSessionHasErrors('purchase_price');
    }

    /** 5. Purchase Workflow: Stock increments accurately */
    public function test_purchase_transaction_successfully_increments_stock(): void
    {
        $this->actingAs($this->staff);

        $initialStock = $this->product->stock; // 10
        $qtyToBuy = 15;

        $response = $this->post('/purchases', [
            'supplier_id' => $this->supplier->id,
            'purchased_at' => now()->toDateTimeString(),
            'notes' => 'Pembelian test',
            'items' => [
                [
                    'product_id' => $this->product->id,
                    'quantity' => $qtyToBuy,
                    'unit_cost' => 55000,
                ],
            ],
        ]);

        $response->assertSessionHasNoErrors();
        $this->product->refresh();

        $this->assertEquals($initialStock + $qtyToBuy, $this->product->stock);
        $this->assertDatabaseHas('purchases', [
            'supplier_id' => $this->supplier->id,
            'status' => 'completed',
            'total' => 15 * 55000,
        ]);
    }

    /** 6. Sales Workflow: Stock decrements & server calculates total accurately */
    public function test_sale_transaction_successfully_decrements_stock_and_calculates_server_total(): void
    {
        $this->actingAs($this->staff);

        $initialStock = $this->product->stock; // 10
        $qtyToSell = 4;

        $response = $this->post('/sales', [
            'customer_name' => 'Customer Test',
            'sold_at' => now()->toDateTimeString(),
            'notes' => 'Penjualan valid',
            'items' => [
                [
                    'product_id' => $this->product->id,
                    'quantity' => $qtyToSell,
                ],
            ],
        ]);

        $response->assertSessionHasNoErrors();
        $this->product->refresh();

        $this->assertEquals($initialStock - $qtyToSell, $this->product->stock); // 10 - 4 = 6
        $expectedTotal = $qtyToSell * $this->product->selling_price; // 4 * 80000 = 320000

        $this->assertDatabaseHas('sales', [
            'customer_name' => 'Customer Test',
            'total' => $expectedTotal,
            'status' => 'completed',
        ]);
    }

    /** 7. Insufficient Stock: Sale transaction rejected without altering stock */
    public function test_sale_transaction_fails_when_stock_is_insufficient_and_rolls_back_data(): void
    {
        $this->actingAs($this->staff);

        $initialStock = $this->product->stock; // 10
        $excessiveQty = 15; // exceeds stock!

        $response = $this->post('/sales', [
            'customer_name' => 'Pelanggan Rakus',
            'sold_at' => now()->toDateTimeString(),
            'items' => [
                [
                    'product_id' => $this->product->id,
                    'quantity' => $excessiveQty,
                ],
            ],
        ]);

        $response->assertSessionHasErrors('items');
        $this->product->refresh();

        // Stock must remain unchanged
        $this->assertEquals($initialStock, $this->product->stock);
        // No sale created
        $this->assertEquals(0, Sale::count());
    }

    /** 8. Atomicity: Multi-item sale where one item fails completely rolls back */
    public function test_atomicity_transaction_rollback_when_one_item_fails(): void
    {
        $this->actingAs($this->staff);

        $prod2 = Product::create([
            'category_id' => $this->category->id,
            'sku' => 'TEST-002',
            'name' => 'Barang Uji 2',
            'purchase_price' => 10000,
            'selling_price' => 20000,
            'stock' => 2, // only 2 in stock
            'minimum_stock' => 1,
        ]);

        $initialStock1 = $this->product->stock; // 10
        $initialStock2 = $prod2->stock; // 2

        // Item 1 has sufficient stock (5 <= 10), but Item 2 exceeds stock (5 > 2)
        $response = $this->post('/sales', [
            'customer_name' => 'Customer Multi',
            'sold_at' => now()->toDateTimeString(),
            'items' => [
                [
                    'product_id' => $this->product->id,
                    'quantity' => 5,
                ],
                [
                    'product_id' => $prod2->id,
                    'quantity' => 5, // FAIL!
                ],
            ],
        ]);

        $response->assertSessionHasErrors('items');

        $this->product->refresh();
        $prod2->refresh();

        // NEITHER product stock should be decremented due to atomic DB::transaction!
        $this->assertEquals($initialStock1, $this->product->stock);
        $this->assertEquals($initialStock2, $prod2->stock);
        $this->assertEquals(0, Sale::count());
    }

    /** 9. Authorization: Staff cannot access admin features */
    public function test_staff_cannot_access_admin_user_management_routes(): void
    {
        $this->actingAs($this->staff);

        $response = $this->get('/users');
        $response->assertStatus(403);

        $responsePost = $this->post('/users', [
            'name' => 'New User',
            'email' => 'new@test.com',
            'password' => 'secret123',
            'role' => 'staff',
        ]);
        $responsePost->assertStatus(403);
    }

    /** 10. Cancellation: Admin cancelling sale restores stock */
    public function test_admin_can_cancel_sale_and_restore_stock(): void
    {
        $this->actingAs($this->admin);

        // First make a sale of 3 units
        $this->post('/sales', [
            'customer_name' => 'Batal Test',
            'sold_at' => now()->toDateTimeString(),
            'items' => [
                ['product_id' => $this->product->id, 'quantity' => 3],
            ],
        ]);

        $this->product->refresh();
        $this->assertEquals(7, $this->product->stock); // 10 - 3 = 7

        $sale = Sale::latest()->first();

        // Cancel the sale
        $cancelResponse = $this->post("/sales/{$sale->id}/cancel");
        $cancelResponse->assertRedirect();

        $sale->refresh();
        $this->product->refresh();

        $this->assertEquals('cancelled', $sale->status);
        $this->assertEquals(10, $this->product->stock); // Restored back to 10!
    }

    /** 11. Delete Guard: Product with transaction history cannot be hard deleted */
    public function test_product_cannot_be_deleted_if_used_in_transactions(): void
    {
        $this->actingAs($this->admin);

        // Make a sale with this product
        $this->post('/sales', [
            'customer_name' => 'Customer Delete Test',
            'sold_at' => now()->toDateTimeString(),
            'items' => [
                ['product_id' => $this->product->id, 'quantity' => 1],
            ],
        ]);

        // Attempt deleting product
        $deleteResponse = $this->delete("/products/{$this->product->id}");
        $deleteResponse->assertSessionHas('error');

        // Product still exists in database
        $this->assertDatabaseHas('products', ['id' => $this->product->id]);
    }

    /** 12. Customer Role: Can view catalog but blocked from staff/admin operations */
    public function test_customer_can_login_and_access_catalog_but_cannot_access_admin_or_purchases(): void
    {
        $customer = User::create([
            'name' => 'Customer Budi',
            'email' => 'pelanggan@test.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);

        $this->actingAs($customer);

        // Can access dashboard and products catalog
        $this->get('/dashboard')->assertStatus(200);
        $this->get('/products')->assertStatus(200);

        // Blocked from supplier purchase restock (403)
        $this->get('/purchases/create')->assertStatus(403);

        // Blocked from admin user management (403)
        $this->get('/users')->assertStatus(403);
    }

    /** 13. Customer Checkout: Pastry storefront cart order decrements stock */
    public function test_customer_can_checkout_from_storefront_cart_and_atomically_decrement_stock(): void
    {
        $customer = User::create([
            'name' => 'Clara Aurelia',
            'email' => 'clara@test.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);

        $this->actingAs($customer);

        // Initial stock is 10
        $this->assertEquals(10, $this->product->stock);

        $response = $this->post('/checkout', [
            'customer_name' => 'Clara Aurelia',
            'customer_phone' => '081299998888',
            'notes' => 'Tolong dihangatkan',
            'items' => [
                ['product_id' => $this->product->id, 'quantity' => 3],
            ],
        ]);

        $response->assertRedirect();

        // Product stock decremented from 10 to 7
        $this->product->refresh();
        $this->assertEquals(7, $this->product->stock);

        // Sale record verified
        $this->assertDatabaseHas('sales', [
            'customer_name' => 'Clara Aurelia',
            'total' => 240000, // 3 * 80000
            'status' => 'completed',
        ]);
    }

    /** 14. Customer Checkout: Rejects when requested quantity exceeds available stock */
    public function test_customer_checkout_fails_if_pastry_stock_is_insufficient(): void
    {
        $customer = User::create([
            'name' => 'Customer Greedy',
            'email' => 'greedy@test.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);

        $this->actingAs($customer);

        // Try ordering 99 pcs when only 10 available
        $response = $this->post('/checkout', [
            'customer_name' => 'Customer Greedy',
            'items' => [
                ['product_id' => $this->product->id, 'quantity' => 99],
            ],
        ]);

        $response->assertSessionHasErrors('items');

        // Stock remains untouched
        $this->product->refresh();
        $this->assertEquals(10, $this->product->stock);
    }

    /** 15. Customer Registration: Guest can register as a new customer */
    public function test_guest_can_register_as_customer(): void
    {
        $response = $this->post('/register', [
            'name' => 'New Customer',
            'email' => 'newcustomer@test.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
        ]);

        $response->assertRedirect(route('storefront.index'));
        $this->assertDatabaseHas('users', [
            'email' => 'newcustomer@test.com',
            'role' => 'customer',
        ]);
        $this->assertAuthenticated();
    }

    /** 16. Simplified Checkout: supports payment method selection and displays order number and status */
    public function test_customer_can_checkout_without_phone_and_with_payment_method(): void
    {
        $customer = User::create([
            'name' => 'Sophie Martin',
            'email' => 'sophie@test.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);

        $this->actingAs($customer);

        $response = $this->post('/checkout', [
            'customer_name' => 'Sophie Martin',
            'notes' => 'Tolong dibungkus rapi',
            'payment_method' => 'cashier',
            'items' => [
                ['product_id' => $this->product->id, 'quantity' => 2],
            ],
        ]);

        $response->assertRedirect();
        
        $sale = Sale::latest('id')->first();
        $this->assertNotNull($sale);
        $this->assertEquals('Sophie Martin', $sale->customer_name);
        $this->assertEquals('cashier', $sale->payment_method);
        $this->assertEquals('unpaid', $sale->payment_status);
        $this->assertEquals('Bayar di Kasir', $sale->payment_method_label);
        $this->assertEquals(160000, $sale->total);

        // Verify invoice shows order number and payment info
        $invoiceResponse = $this->get(route('sales.invoice', $sale));
        $invoiceResponse->assertStatus(200);
        $invoiceResponse->assertSee($sale->sale_number);
        $invoiceResponse->assertSee('Bayar di Kasir');
        $invoiceResponse->assertSee('Belum Lunas');
    }

    /** 17. Guest can checkout and view invoice without authentication */
    public function test_guest_can_checkout_and_view_invoice_without_login(): void
    {
        $response = $this->post('/checkout', [
            'customer_name' => 'Tamu Istimewa',
            'notes' => 'Catatan tamu',
            'payment_method' => 'qris',
            'items' => [
                ['product_id' => $this->product->id, 'quantity' => 1],
            ],
        ]);

        $sale = Sale::latest('id')->first();
        $this->assertNotNull($sale);
        $this->assertEquals('Tamu Istimewa', $sale->customer_name);
        $this->assertEquals('qris', $sale->payment_method);
        $this->assertEquals('unconfigured_qris', $sale->payment_status);

        $response->assertRedirect(route('sales.invoice', $sale));

        // Guest accesses invoice directly without login redirect
        $invoiceResponse = $this->get(route('sales.invoice', $sale));
        $invoiceResponse->assertStatus(200);
        $invoiceResponse->assertSee($sale->sale_number);
        $invoiceResponse->assertSee('QRIS');
        $invoiceResponse->assertSee('Metode QRIS Toko Belum Dikonfigurasi');
    }

    /** 18. Payment simulation via invoice updates database to paid and displays verified receipt */
    public function test_payment_simulation_via_invoice_updates_database_and_displays_receipt(): void
    {
        $sale = Sale::create([
            'user_id' => 1,
            'sale_number' => 'INV-TEST-SIM-01',
            'customer_name' => 'Sophie Martin',
            'total' => 24000,
            'status' => 'completed',
            'payment_method' => 'qris',
            'payment_status' => 'unconfigured_qris',
            'sold_at' => now(),
        ]);

        $response = $this->post(route('sales.simulate-payment', $sale));
        $response->assertRedirect(route('sales.invoice', $sale));

        $sale->refresh();
        $this->assertEquals('paid', $sale->payment_status);
        $this->assertEquals('Pembayaran Berhasil', $sale->payment_status_label);
        $this->assertNotNull($sale->paid_at);
        $this->assertNotNull($sale->payment_ref);

        $invoiceResponse = $this->get(route('sales.invoice', $sale));
        $invoiceResponse->assertStatus(200);
        $invoiceResponse->assertSee('Pembayaran Berhasil');
        $invoiceResponse->assertSee('Bukti Pembayaran Terverifikasi');
        $invoiceResponse->assertSee('Simulasi Pembayaran');
        $invoiceResponse->assertSee($sale->payment_ref);
    }

    /** 19. Checkout with instant simulation creates paid transaction immediately */
    public function test_checkout_with_instant_simulation_creates_paid_transaction_immediately(): void
    {
        $response = $this->post('/checkout', [
            'customer_name' => 'Mahasiswa Penguji',
            'notes' => 'Uji coba penilaian kuliah',
            'payment_method' => 'qris',
            'simulate_payment' => 1,
            'items' => [
                ['product_id' => $this->product->id, 'quantity' => 1],
            ],
        ]);

        $sale = Sale::latest('id')->first();
        $this->assertNotNull($sale);
        $this->assertEquals('paid', $sale->payment_status);
        $this->assertEquals('Pembayaran Berhasil', $sale->payment_status_label);
        $this->assertNotNull($sale->paid_at);
        $this->assertNotNull($sale->payment_ref);

        $response->assertRedirect(route('sales.invoice', $sale));

        $invoiceResponse = $this->get(route('sales.invoice', $sale));
        $invoiceResponse->assertStatus(200);
        $invoiceResponse->assertSee('Pembayaran Berhasil');
        $invoiceResponse->assertSee('Bukti Pembayaran Terverifikasi');
        $invoiceResponse->assertSee('Simulasi Pembayaran');
    }

    /** 20. Landing Page: Publicly accessible as the first page and shows brand, tagline, and auth links */
    public function test_landing_page_is_accessible_to_guests_and_displays_brand_and_tagline(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Nazelle Délices');
        $response->assertSee('A Little Taste of Elegance');
        $response->assertSee(route('login'));
        $response->assertSee(route('register'));
        $response->assertSee(route('storefront.index'));
        $response->assertSee($this->product->name);
        $response->assertDontSee('Pesan di Menu');
    }

    /** 21. Landing Page: Displays Masuk and Daftar links unconditionally even when user is authenticated */
    public function test_landing_page_displays_masuk_and_daftar_even_when_logged_in(): void
    {
        $user = User::factory()->create(['role' => 'admin']);
        $response = $this->actingAs($user)->get('/');

        $response->assertStatus(200);
        $response->assertSee(route('login'));
        $response->assertSee(route('register'));
        $response->assertSee(route('dashboard'));
        $response->assertSee('Masuk');
        $response->assertSee('Daftar');
    }
}
