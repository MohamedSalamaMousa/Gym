<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PricesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $governorates = [
            'القاهرة', 'الجيزة', 'الإسكندرية', 'البحيرة', 'القليوبية',
            'الغربية', 'المنوفية', 'دمياط', 'الدقهلية', 'كفر الشيخ',
            'مطروح', 'الإسماعيلية', 'السويس', 'بورسعيد', 'الشرقية',
            'الفيوم', 'بني سويف', 'المنيا', 'أسيوط', 'سوهاج',
            'قنا', 'أسوان', 'الأقصر', 'البحر الأحمر', 'الوادي الجديد',
            'شمال سيناء', 'جنوب سيناء', 'شرم الشيخ', 'الغردقة'
        ];


// السعر الافتراضي
        $defaultPrice = 77.00;

// قائمة البيانات
        $data = [];

// إنشاء البيانات لكل محافظة
        foreach ($governorates as $governorate) {
            // تكرار العملية لتكون governorate_sent_by هي قيمة
            for ($i = 0; $i < count($governorates); $i++) {
                $data[] = [
                    'governorate_sent_by' => $governorate,
                    'governorate_sent_to' => $governorates[$i],
                    'price' => $governorate === $governorates[$i] ? $defaultPrice : ($governorate === 'الوادي الجديد' ? 90.00 : 65.00)
                ];
            }
        }

        foreach ($data as $row) {
            DB::table('prices')->insert($row);
        }
    }
}
