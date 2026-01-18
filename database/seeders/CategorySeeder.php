<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Umum',
                'description' => 'Diskusi bebas mengenai topik apa saja yang tidak masuk ke kategori khusus lainnya.',
            ],
            [
                'name' => 'Akademik',
                'description' => 'Tanya jawab mata kuliah, diskusi seputar materi, tugas, dan persiapan ujian.',
            ],
            [
                'name' => 'Sosial',
                'description' => 'Event kampus, workshop, dan aktivitas sosial mahasiswa.',
            ],
            [
                'name' => 'Karir',
                'description' => 'Lowongan & magang, tips karir, portofolio, dan peluang kerja.',
            ],
            [
                'name' => 'Santai',
                'description' => 'Hiburan kampus: meme, cerita, rekomendasi tempat nongkrong, jual-beli.',
            ],
            [
                'name' => 'Teknologi & Pemrograman',
                'description' => 'Diskusi coding, development, tools, problem solving, dan sharing project IT.',
            ],
            [
                'name' => 'Riset & Akademik Lanjutan',
                'description' => 'Ruang diskusi metodologi penelitian, publikasi jurnal, dan skripsi/thesis.',
            ],
            [
                'name' => 'Kewirausahaan & Startup',
                'description' => 'Sharing ide bisnis, mentoring kewirausahaan, dan perkembangan startup kampus.',
            ],
            [
                'name' => 'Beasiswa & Pendanaan',
                'description' => 'Info beasiswa, peluang pendanaan, tips aplikasi, dan pengalaman penerima beasiswa.',
            ],
            [
                'name' => 'Kesehatan Mental & Karir',
                'description' => 'Dukungan kesehatan mental, manajemen stres, dan keseimbangan studi/kerja.',
            ],
            [
                'name' => 'Pertukaran Pelajar',
                'description' => 'Diskusi program exchange, pengalaman internasional, dan tips studi di luar negeri.',
            ],
            [
                'name' => 'Project & Kolaborasi',
                'description' => 'Cari tim untuk project kampus, ajak kolaborasi riset, atau kompetisi bersama.',
            ],
            [
                'name' => 'Review Dosen & Mata Kuliah',
                'description' => 'Berbagi pengalaman tentang dosen, review mata kuliah, dan tips sukses di kelas.',
            ],
            [
                'name' => 'Competitive Programming & Olimpiade',
                'description' => 'Diskusi soal competitive programming, latihan, dan persiapan olimpiade.',
            ],
            [
                'name' => 'Design & Kreatif',
                'description' => 'Ruang untuk desain grafis, UI/UX, multimedia, dan project kreatif.',
            ],
            [
                'name' => 'Bahasa & Budaya Asing',
                'description' => 'Pertukaran bahasa, tips belajar bahasa asing, dan diskusi budaya internasional.',
            ],
            [
                'name' => 'Open Source & Komunitas',
                'description' => 'Kolaborasi open source, diskusi komunitas developer, kontribusi proyek.',
            ],
            [
                'name' => 'Hardware & Elektronika',
                'description' => 'Diskusi hardware, IoT, robotics, dan project elektronika.',
            ],
            [
                'name' => 'Data Science & AI',
                'description' => 'Diskusi machine learning, data analysis, dan project data science.',
            ],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(
                ['name' => $cat['name']],
                ['description' => $cat['description']]
            );
        }
    }
}
