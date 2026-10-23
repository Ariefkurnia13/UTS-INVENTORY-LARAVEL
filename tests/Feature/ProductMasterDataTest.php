<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ProductMasterDataTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_filter_query_is_preserved_in_pagination(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $category = Category::create([
            'name' => 'Alat Tulis',
            'description' => null,
        ]);

        Product::create([
            'category_id' => $category->id,
            'name' => 'Buku Tulis',
            'sku' => 'ATK-001',
            'quantity' => 20,
            'minimum_stock' => 5,
            'purchase_price' => 30000,
            'selling_price' => 40000,
            'price' => 40000,
            'description' => null,
        ]);

        $response = $this->actingAs($admin)->get(
            route('products.index', [
                'search' => 'Buku',
                'category_id' => $category->id,
                'page' => 2,
            ])
        );

        $response->assertOk();

        $response->assertViewHas('products', function ($products) use ($category) {
            return str_contains($products->url(2), 'search=Buku')
                && str_contains(
                    $products->url(2),
                    'category_id=' . $category->id
                );
        });
    }

    public function test_purchase_rolls_back_all_changes_when_second_item_fails(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $category = Category::create([
            'name' => 'ATK',
            'description' => null,
        ]);

        $supplier = Supplier::create([
            'name' => 'Supplier Tes',
        ]);

        $product1 = Product::create([
            'category_id' => $category->id,
            'name' => 'Produk Pertama',
            'sku' => 'TEST-001',
            'quantity' => 10,
            'minimum_stock' => 2,
            'purchase_price' => 10000,
            'selling_price' => 15000,
            'price' => 15000,
            'description' => null,
        ]);

        $product2 = Product::create([
            'category_id' => $category->id,
            'name' => 'Produk Kedua',
            'sku' => 'TEST-002',
            'quantity' => 20,
            'minimum_stock' => 2,
            'purchase_price' => 20000,
            'selling_price' => 25000,
            'price' => 25000,
            'description' => null,
        ]);

        // Simulasikan kegagalan saat stok produk kedua diperbarui.
        DB::unprepared("
            CREATE TRIGGER fail_second_product_stock_update
            BEFORE UPDATE OF quantity ON products
            WHEN OLD.id = {$product2->id}
            BEGIN
                SELECT RAISE(ABORT, 'simulated item failure');
            END;
        ");

        $this->withoutExceptionHandling();

        try {
            $this->actingAs($admin)->post(route('purchases.store'), [
                'supplier_id' => $supplier->id,
                'items' => [
                    [
                        'product_id' => $product1->id,
                        'quantity' => 3,
                        'unit_cost' => 10000,
                    ],
                    [
                        'product_id' => $product2->id,
                        'quantity' => 2,
                        'unit_cost' => 20000,
                    ],
                ],
            ]);

            $this->fail('Pembelian seharusnya gagal pada item kedua.');
        } catch (\Illuminate\Database\QueryException $e) {
            $this->assertStringContainsString(
                'simulated item failure',
                $e->getMessage()
            );
        }

        $this->assertDatabaseCount('purchases', 0);
        $this->assertDatabaseCount('purchase_items', 0);

        $this->assertSame(10, $product1->fresh()->quantity);
        $this->assertSame(20, $product2->fresh()->quantity);
    }
}
