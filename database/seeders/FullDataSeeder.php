<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;
use App\Models\Comment;
use App\Models\Report;
use App\Models\Message;
use App\Models\MessageReply;
use App\Models\Announcement;
use App\Models\AcademicEvent;
use App\Models\Category;

class FullDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ========== GET ALL CATEGORIES ==========
        $categories = Category::all();

        // ========== QUESTION & COMMENT PER CATEGORY ==========

        $userCounter = 1;
        $commentUserCounter = 2;

        foreach ($categories as $category) {
            // Buat pertanyaan untuk setiap kategori
            $question = Question::create([
                'user_id' => $userCounter,
                'title' => 'Pertanyaan umum tentang ' . $category->name,
                'content' => 'Saya ingin bertanya tentang topik ' . $category->name . '. Apakah ada yang bisa membantu saya memahami lebih lanjut mengenai hal ini?',
                'category_id' => $category->id,
                'images' => null,
            ]);

            // Minimal 1 komentar per pertanyaan
            $comment = Comment::create([
                'user_id' => $commentUserCounter,
                'question_id' => $question->id,
                'content' => 'Aku juga punya pengalaman yang sama. Coba cek dokumentasi resmi atau tanya ke dosen pembimbing untuk penjelasan lebih detail.',
            ]);

            // Increment user counter (cycling)
            $userCounter = $userCounter < 5 ? $userCounter + 1 : 1;
            $commentUserCounter = $commentUserCounter < 5 ? $commentUserCounter + 1 : 1;
        }

        // ========== ADDITIONAL SAMPLE DATA (Optional) ==========

        // Pertanyaan umum tambahan (jika ingin lebih dari 1 per kategori)
        $question2 = Question::create([
            'user_id' => 1,
            'title' => 'Bagaimana cara mengoptimalkan jadwal perkuliahan untuk mahasiswa?',
            'content' => 'Saya sedang menghadapi kendala dalam mengatur jadwal perkuliahan yang efisien. Dengan banyaknya mata kuliah dan dosen yang berbeda, sulit untuk membuat jadwal yang tidak bentrok. Apakah ada tips atau strategi yang bisa membantu?',
            'category_id' => 1,
            'images' => null,
        ]);

        // Multiple comments
        Comment::create([
            'user_id' => 2,
            'question_id' => $question2->id,
            'content' => 'Saya punya saran! Coba gunakan aplikasi pendamping akademik yang bisa membantu track jadwal. Atau bisa juga datang ke bagian akademik kampus untuk konsultasi langsung.',
        ]);

        Comment::create([
            'user_id' => 3,
            'question_id' => $question2->id,
            'content' => 'Dari pengalaman saya, yang paling membantu adalah membuat prioritas dulu. Kelompokkan mata kuliah berdasarkan tingkat kesulitan dan waktu kerja.',
        ]);

        Comment::create([
            'user_id' => 4,
            'question_id' => $question2->id,
            'content' => 'Ada juga baiknya join dengan mahasiswa angkatan lo untuk sharing schedule. Sering kali kita bisa regrouping jadwal berdasarkan preferensi bersama.',
        ]);

        Comment::create([
            'user_id' => 5,
            'question_id' => $question2->id,
            'content' => 'Saya setuju dengan jawaban-jawaban sebelumnya. Komunikasi dengan dosen juga penting. Ada beberapa dosen yang fleksibel dengan jadwal.',
        ]);

        // ========== REPORT (Pertanyaan & Komentar Dilaporkan) ==========

        $allComments = Comment::all();
        if ($allComments->count() > 0) {
            Report::create([
                'reporter_id' => 2,
                'question_id' => null,
                'comment_id' => $allComments->first()->id,
                'reason' => 'Tidak sesuai dengan topik diskusi',
                'description' => 'Komentar ini tidak relevan dengan pertanyaan akademik',
                'status' => 'pending',
            ]);
        }

        $allQuestions = Question::all();
        if ($allQuestions->count() > 1) {
            Report::create([
                'reporter_id' => 3,
                'question_id' => $allQuestions->skip(1)->first()->id,
                'comment_id' => null,
                'reason' => 'Mengandung spam',
                'description' => 'Pertanyaan ini terlihat seperti spam untuk forum akademik',
                'status' => 'pending',
            ]);
        }

        // ========== CONTACT US MESSAGES ==========

        $message1 = Message::create([
            'user_id' => 4,
            'name' => 'Budi Santoso',
            'email' => 'budi.santoso@email.com',
            'title' => 'Pertanyaan tentang fitur leaderboard',
            'body' => 'Halo admin, saya ingin bertanya tentang bagaimana cara sistem leaderboard INNOFORUM bekerja? Apakah poin dihitung otomatis atau manual?',
            'is_read' => false,
            'status' => 'open',
        ]);

        $message2 = Message::create([
            'user_id' => 5,
            'name' => 'Siti Rahma',
            'email' => 'siti.rahma@email.com',
            'title' => 'Bug di fitur notifikasi real-time',
            'body' => 'Saya menemukan bug di fitur notifikasi. Notifikasi tidak muncul secara real-time ketika ada komentar baru. Mohon segera diperbaiki.',
            'is_read' => false,
            'status' => 'open',
        ]);

        // ========== ADMIN REPLY TO CONTACT MESSAGES ==========

        MessageReply::create([
            'message_id' => $message1->id,
            'user_id' => 1,
            'body' => 'Terima kasih atas pertanyaan Anda! Sistem leaderboard INNOFORUM menghitung poin secara otomatis berdasarkan aktivitas user seperti membuat pertanyaan, memberikan komentar, dan mendapat like.',
            'via_email' => true,
        ]);

        MessageReply::create([
            'message_id' => $message2->id,
            'user_id' => 1,
            'body' => 'Terima kasih telah melaporkan bug tersebut! Tim development sudah kami catat dan akan segera memperbaiki fitur notifikasi real-time dalam 2-3 hari ke depan.',
            'via_email' => true,
        ]);

        // ========== ANNOUNCEMENTS ==========

        Announcement::create([
            'title' => '🎉 Update Fitur Baru: Real-time Chat',
            'content' => 'Kami dengan senang hati mengumumkan bahwa fitur Real-time Chat sudah tersedia di INNOFORUM! Sekarang Anda bisa berkomunikasi dengan teman sekampus secara instant. Fitur ini akan meningkatkan interaksi akademik dan sosial di platform kami. Terima kasih atas dukungan Anda!',
        ]);

        Announcement::create([
            'title' => '🔧 Penjadwalan Pemeliharaan Server',
            'content' => 'Mohon perhatian! Server INNOFORUM akan dilakukan pemeliharaan rutin pada hari Minggu, 9 Juni 2026 dari pukul 22:00 hingga 02:00. Selama periode ini, platform tidak akan dapat diakses. Kami mohon maaf atas ketidaknyamanan ini dan terima kasih atas kesabaran Anda.',
        ]);

        Announcement::create([
            'title' => '📚 Kompetisi Akademik Tingkat Universitas',
            'content' => 'Dibuka pendaftaran untuk Kompetisi Akademik Tingkat Universitas 2026! Kompetisi ini terbuka untuk semua mahasiswa aktif dengan kategori: Programming, Mathematics, dan Case Study. Hadiah menarik menanti Anda! Pendaftaran ditutup pada tanggal 20 Juni 2026.',
        ]);

        // ========== ACADEMIC CALENDAR EVENTS ==========

        AcademicEvent::create([
            'title' => 'Persiapan Ujian Tengah Semester (UTS)',
            'description' => 'Periode persiapan Ujian Tengah Semester untuk semua mahasiswa. Manfaatkan waktu ini untuk belajar dan berkonsultasi dengan dosen.',
            'start_date' => now()->addDays(10)->format('Y-m-d'),
            'end_date' => now()->addDays(17)->format('Y-m-d'),
            'color' => 'red',
            'created_by' => 1,
            'is_published' => true,
        ]);

        AcademicEvent::create([
            'title' => 'Ujian Tengah Semester (UTS)',
            'description' => 'Pelaksanaan Ujian Tengah Semester. Jadwal lengkap bisa dilihat di portal akademik.',
            'start_date' => now()->addDays(18)->format('Y-m-d'),
            'end_date' => now()->addDays(31)->format('Y-m-d'),
            'color' => 'orange',
            'created_by' => 1,
            'is_published' => true,
        ]);

        AcademicEvent::create([
            'title' => '📄 Deadline Pengumpulan Draft Skripsi',
            'description' => 'Batas akhir pengumpulan draft skripsi untuk angkatan 2023. Pengumpulan melalui portal akademik atau langsung ke bagian akademik.',
            'start_date' => now()->addDays(35)->format('Y-m-d'),
            'end_date' => now()->addDays(35)->format('Y-m-d'),
            'color' => 'purple',
            'created_by' => 1,
            'is_published' => true,
        ]);

        AcademicEvent::create([
            'title' => '✍️ Pembukaan Pendaftaran Mata Kuliah (Rencana Studi)',
            'description' => 'Periode pembukaan untuk memilih dan mendaftarkan mata kuliah yang akan diambil di semester depan. Jangan lewatkan deadline ini!',
            'start_date' => now()->addDays(40)->format('Y-m-d'),
            'end_date' => now()->addDays(50)->format('Y-m-d'),
            'color' => 'blue',
            'created_by' => 1,
            'is_published' => true,
        ]);

        AcademicEvent::create([
            'title' => '🎓 Libur Semester',
            'description' => 'Periode libur semester untuk istirahat dan menyiapkan diri untuk semester berikutnya.',
            'start_date' => now()->addDays(60)->format('Y-m-d'),
            'end_date' => now()->addDays(75)->format('Y-m-d'),
            'color' => 'green',
            'created_by' => 1,
            'is_published' => true,
        ]);
    }
}
