<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('invite_code', 32)->unique();
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('shop_id')->nullable()->after('id')->constrained()->restrictOnDelete();
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('shop_id')->nullable()->after('id')->constrained()->restrictOnDelete();
        });

        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('shop_id')->nullable()->after('id')->constrained()->restrictOnDelete();
        });

        $inviteCode = strtoupper(Str::random(10));
        $now = now();

        $shopId = DB::table('shops')->insertGetId([
            'name' => "Akeira's Snack Inn",
            'invite_code' => $inviteCode,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('users')->whereNull('shop_id')->update(['shop_id' => $shopId]);

        // MySQL, MariaDB, SQLite: correlate orders to the placing user's shop
        DB::statement('UPDATE orders SET shop_id = (SELECT shop_id FROM users WHERE users.id = orders.user_id)');

        DB::table('products')->whereNull('shop_id')->update(['shop_id' => $shopId]);
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['shop_id']);
            $table->dropColumn('shop_id');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['shop_id']);
            $table->dropColumn('shop_id');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['shop_id']);
            $table->dropColumn('shop_id');
        });

        Schema::dropIfExists('shops');
    }
};
