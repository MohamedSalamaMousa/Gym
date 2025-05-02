<?php

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
        Schema::create('gym_supplies', function (Blueprint $table) {
            $table->id();
            $table->string('item_name');  // اسم الأداة أو المستلزم
            $table->integer('quantity');  // الكمية المشتراة
            $table->decimal('unit_price', 10, 2);  // سعر الوحدة
            $table->decimal('total_price', 10, 2)->virtualAs('quantity * unit_price');  // إجمالي السعر (يتم حسابه تلقائيًا)
            $table->timestamp('purchase_date')->useCurrent();  // تاريخ الشراء
            $table->foreignId('created_by')->constrained('admins')->onDelete('cascade');  // معرف المدير الذي قام بإنشاء السجل

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gym_supplies');
    }
};
