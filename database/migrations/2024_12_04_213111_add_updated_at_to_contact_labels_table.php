<?php
// Di dalam file migrasi (nama file akan bervariasi)
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
        Schema::table('contact_labels', function (Blueprint $table) {
            $table->timestamp('updated_at')->nullable()->after('created_at'); // Tambahkan kolom updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contact_labels', function (Blueprint $table) {
            $table->dropColumn('updated_at'); // Hapus kolom updated_at jika rollback
        });
    }
};
