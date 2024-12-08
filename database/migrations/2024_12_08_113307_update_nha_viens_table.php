<?php

use App\Models\PhongBan;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('nhan_viens', function (Blueprint $table) {
            $table->foreignIdFor(PhongBan::class)->after('ma_nhan_vien')->unique()->constrained();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nhan_viens', function (Blueprint $table) {
            $table->dropForeignIdFor(PhongBan::class);
            $table->dropColumn('phong_ban_id');
            $table->softDeletes();
        });
    }
};
