<?php

use App\Models\Feature;
use App\Models\Items;
use App\Models\ItemsCategory;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Models\VendorProfiles;
use Illuminate\Database\Seeder;

class DemoDocsSeeder extends Seeder
{
    public function run(): void
    {
        $v = User::firstOrCreate(
            ['email' => 'demo@vendor.id'],
            ['name' => 'Lensamania', 'password' => 'password', 'role' => 'vendor', 'slug' => 'lensamania', 'phone' => '08123456789']
        );

        $p = VendorProfiles::firstOrCreate(
            ['user_id' => $v->id],
            ['owner_name' => 'Budi', 'address' => 'Jl Merdeka 1 Jakarta', 'status' => 'active']
        );

        $feats = [];
        $defs = [
            ['booking_system', 'Sistem Booking', 'Kelola pesanan sewa'],
            ['asset_management', 'Manajemen Aset', 'Kelola barang'],
            ['category_management', 'Manajemen Kategori', 'Kelola kategori'],
        ];
        foreach ($defs as $d) {
            $feats[] = Feature::firstOrCreate(['key' => $d[0]], ['name' => $d[1], 'description' => $d[2]]);
        }

        $plan = SubscriptionPlan::firstOrCreate(
            ['slug' => 'pro'],
            ['name' => 'Pro', 'price' => 99000, 'billing_cycle' => 'monthly', 'max_assets' => 100, 'is_active' => true, 'button_text' => 'Pilih Pro']
        );
        $plan->featuresList()->sync(collect($feats)->pluck('id')->all());

        Subscription::firstOrCreate(
            ['vendor_profile_id' => $p->id, 'subscription_plan_id' => $plan->id],
            ['status' => 'active', 'start_date' => now()->subDay()->toDateString(), 'end_date' => now()->addMonth()->toDateString()]
        );

        $cat = ItemsCategory::firstOrCreate(['vendor_id' => $v->id, 'name' => 'Kamera']);

        Items::firstOrCreate(
            ['vendor_id' => $v->id, 'name' => 'Sony A7 IV'],
            ['items_category_id' => $cat->id, 'description' => 'Full-frame 33MP 4K60p', 'price_per_day' => 350000, 'status' => 'available']
        );
        Items::firstOrCreate(
            ['vendor_id' => $v->id, 'name' => 'Canon R5'],
            ['items_category_id' => $cat->id, 'description' => '45MP 8K RAW', 'price_per_day' => 500000, 'status' => 'available']
        );
    }
}
