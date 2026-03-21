<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('snackinn_digest_counters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('digest_type', 64);
            $table->date('bucket_date');
            $table->unsignedInteger('count')->default(0);
            $table->timestamps();

            $table->unique(['user_id', 'digest_type', 'bucket_date']);
        });

        Schema::create('snackinn_notification_throttles', function (Blueprint $table) {
            $table->string('throttle_key', 191)->primary();
            $table->timestamp('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('snackinn_notification_throttles');
        Schema::dropIfExists('snackinn_digest_counters');
    }
};
