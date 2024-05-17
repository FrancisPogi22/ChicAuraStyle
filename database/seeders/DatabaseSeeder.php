<?php

namespace Database\Seeders;

use App\Models\Categories;
use App\Models\Orders;
use App\Models\Products;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'username' => 'Test User',
            'email' => 'a@example.com',
            'password' => Hash::make('a'),
            'type' => 1,
            'address' => 'a',
        ]);

        User::create([
            'username' => 'Test User',
            'email' => 'b@example.com',
            'password' => Hash::make('b'),
            'type'=> 2,
            'address' => 'b',
        ]);

        $categories = [
            ['categoryName' => 'dresses'],
            ['categoryName' => 'shoes'],
            ['categoryName' => 'bags'],
        ];

        Categories::insert($categories);

        // $products = [
        //     [
        //         'name' => 'Floral Sundress',
        //         'description' => 'A delightful floral sundress perfect for a summer picnic or a day at the beach.',
        //         'price' => 65.00,
        //         'categoryID' => 1,
        //     ],
        //     [
        //         'name' => 'Elegant Evening Gown',
        //         'description' => 'An elegant evening gown, ideal for formal occasions and glamorous events.',
        //         'price' => 150.00,
        //         'categoryID' => 1,
        //     ],
        //     [
        //         'name' => 'Bohemian Maxi Dress',
        //         'description' => 'A flowy, bohemian-style maxi dress, perfect for free spirits and festival-goers.',
        //         'price' => 80.00,
        //         'categoryID' => 1,
        //     ],
        //     [
        //         'name' => 'Vintage Tea Dress',
        //         'description' => 'A charming vintage-inspired tea dress, reminiscent of the 1950s fashion era.',
        //         'price' => 55.00,
        //         'categoryID' => 1,
        //     ],
        //     [
        //         'name' => 'Classic Little Black Dress',
        //         'description' => 'A timeless classic, the little black dress is a wardrobe essential for any occasion.',
        //         'price' => 70.00,
        //         'categoryID' => 1,
        //     ],
        //     [
        //         'name' => 'Boho Chic Midi Dress',
        //         'description' => 'A trendy boho chic midi dress, perfect for casual outings and weekend brunches.',
        //         'price' => 45.00,
        //         'categoryID' => 1,
        //     ],
        //     [
        //         'name' => 'Ruffled Party Dress',
        //         'description' => 'A playful ruffled party dress, guaranteed to make a statement at any celebration.',
        //         'price' => 75.00,
        //         'categoryID' => 1,
        //     ],
        //     [
        //         'name' => 'Embroidered Summer Dress',
        //         'description' => 'An embroidered summer dress, featuring intricate detailing and lightweight fabric.',
        //         'price' => 60.00,
        //         'categoryID' => 1,
        //     ],
        //     [
        //         'name' => 'Leather Tote Bag',
        //         'description' => 'Crafted from luxurious leather, this tote bag combines style and functionality for everyday use.',
        //         'price' => 120.00,
        //         'categoryID' => 3,
        //     ],
        //     [
        //         'name' => 'Crossbody Saddle Bag',
        //         'description' => 'A chic crossbody saddle bag, perfect for hands-free convenience while on the go.',
        //         'price' => 85.00,
        //         'categoryID' => 3,
        //     ],
        //     [
        //         'name' => 'Quilted Chain Shoulder Bag',
        //         'description' => 'Elevate your look with this quilted chain shoulder bag, exuding sophistication and elegance.',
        //         'price' => 150.00,
        //         'categoryID' => 3,
        //     ],
        //     [
        //         'name' => 'Canvas Beach Tote',
        //         'description' => 'Get ready for a day by the seaside with this spacious and durable canvas beach tote.',
        //         'price' => 55.00,
        //         'categoryID' => 3,
        //     ],
        //     [
        //         'name' => 'Mini Backpack',
        //         'description' => 'Stay on-trend with this mini backpack, perfect for carrying your essentials in style.',
        //         'price' => 70.00,
        //         'categoryID' => 3,
        //     ],
        //     [
        //         'name' => 'Structured Top Handle Bag',
        //         'description' => 'Make a statement with this structured top handle bag, featuring sleek lines and modern design.',
        //         'price' => 110.00,
        //         'categoryID' => 3,
        //     ],
        //     [
        //         'name' => 'Embellished Clutch',
        //         'description' => 'Add a touch of glamour to your evening ensemble with this embellished clutch, adorned with sparkling accents.',
        //         'price' => 80.00,
        //         'categoryID' => 3,
        //     ],
        //     [
        //         'name' => 'Nylon Crossbody Pouch',
        //         'description' => 'Effortlessly stylish and practical, this nylon crossbody pouch is perfect for busy days on the move.',
        //         'price' => 40.00,
        //         'categoryID' => 3,
        //     ],
        //     [
        //         'name' => 'Classic Leather Sneakers',
        //         'description' => 'Step out in style with these classic leather sneakers, offering both comfort and versatility.',
        //         'price' => 80.00,
        //         'categoryID' => 2,
        //     ],
        //     [
        //         'name' => 'Athletic Running Shoes',
        //         'description' => 'Designed for performance, these athletic running shoes provide support and cushioning for your workouts.',
        //         'price' => 120.00,
        //         'categoryID' => 2,
        //     ],
        //     [
        //         'name' => 'Ankle Strap Heels',
        //         'description' => 'Elevate your look with these chic ankle strap heels, perfect for adding a touch of glamour to any outfit.',
        //         'price' => 90.00,
        //         'categoryID' => 2,
        //     ],
        //     [
        //         'name' => 'Hiking Boots',
        //         'description' => 'Conquer the trails with these durable and supportive hiking boots, built to withstand rugged terrain.',
        //         'price' => 150.00,
        //         'categoryID' => 2,
        //     ],
        //     [
        //         'name' => 'Canvas Slip-On Shoes',
        //         'description' => 'Stay casual and comfortable with these canvas slip-on shoes, ideal for everyday wear.',
        //         'price' => 50.00,
        //         'categoryID' => 2,
        //     ],
        //     [
        //         'name' => 'Platform Sandals',
        //         'description' => 'Make a statement with these platform sandals, featuring a bold design and elevated height.',
        //         'price' => 70.00,
        //         'categoryID' => 2,
        //     ],
        //     [
        //         'name' => 'Leather Chelsea Boots',
        //         'description' => 'Add a touch of sophistication to your wardrobe with these leather Chelsea boots, perfect for both casual and formal occasions.',
        //         'price' => 110.00,
        //         'categoryID' => 2,
        //     ],
        //     [
        //         'name' => 'Espadrille Flats',
        //         'description' => 'Channel effortless summer style with these espadrille flats, featuring a woven sole and comfortable fit.',
        //         'price' => 60.00,
        //         'categoryID' => 2,
        //     ],
        // ];

        // Products::insert($products);

        // $orders = [
        //     [
        //         'userId' => 1,
        //         'productID' => 1,
        //         'quantity' => 2,
        //         'totalPrice' => 50.00,
        //         'orderDate' => now(),
        //         'status' => 'Pending',
        //     ],
        //     [
        //         'userId' => 2,
        //         'productID' => 2,
        //         'quantity' => 1,
        //         'totalPrice' => 1000.00,
        //         'orderDate' => now(),
        //         'status' => 'Completed',
        //     ],
        // ];

        // Orders::insert($orders);
    }
}
