<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hashtag;
use Illuminate\Support\Str;

class HashtagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            // === MATA KULIAH UMUM ===
            'pemrograman-dasar',
            'struktur-data',
            'algoritma',
            'basis-data',
            'jaringan-komputer',
            'sistem-operasi',
            'rekayasa-perangkat-lunak',
            'web-programming',
            'mobile-programming',
            'oop', // Object Oriented Programming

            // === TEKNOLOGI WEB ===
            'laravel',
            'php',
            'javascript',
            'html',
            'css',
            'tailwind',
            'bootstrap',
            'react',
            'vue',
            'nodejs',
            'api',
            'rest-api',
            'ajax',
            'json',

            // === DATABASE ===
            'mysql',
            'postgresql',
            'mongodb',
            'sql',
            'database-design',
            'normalisasi',
            'query-optimization',

            // === MOBILE DEVELOPMENT ===
            'android',
            'flutter',
            'kotlin',
            'react-native',
            'ios',
            'swift',

            // === DATA SCIENCE & AI ===
            'machine-learning',
            'deep-learning',
            'data-science',
            'python',
            'ai',
            'tensorflow',
            'pytorch',
            'data-analysis',
            'nlp', // Natural Language Processing
            'computer-vision',

            // === SECURITY ===
            'cybersecurity',
            'keamanan-web',
            'enkripsi',
            'authentication',
            'authorization',
            'owasp',

            // === TOOLS & VERSION CONTROL ===
            'git',
            'github',
            'docker',
            'vscode',
            'postman',
            'composer',
            'npm',

            // === SOFT SKILLS & KARIR ===
            'beasiswa',
            'magang',
            'internship',
            'lomba',
            'hackathon',
            'kewirausahaan',
            'startup',
            'freelance',
            'career',
            'tips-belajar',

            // === UMUM AKADEMIK ===
            'tugas-akhir',
            'skripsi',
            'proposal',
            'ujian',
            'uts',
            'uas',
            'presentasi',
            'laporan',

            // === TROUBLESHOOTING ===
            'error',
            'debugging',
            'help',
            'solved',
            'tutorial',
            'tips',
            'best-practice',

            // === TOPIK TRENDING ===
            'cloud-computing',
            'aws',
            'azure',
            'devops',
            'microservices',
            'blockchain',
            'iot', // Internet of Things
            'big-data',
            'ui-ux',
            'figma',
            'design',
        ];

        foreach ($tags as $name) {
            Hashtag::updateOrCreate(
                ['name' => $name],
                []
            );
        }
    }
}
