<?php

namespace App\Http\Controllers;

class LegalController extends Controller
{
    public function privacyPolicy()
    {
        $data = [
            'title' => 'Privacy Policy',
            'lastUpdated' => now()->format('F j, Y'),
            'content' => [
                [
                    'section' => '1. Introduction',
                    'content' => 'Kami berkomitmen untuk melindungi privasi dan data pribadi Anda. Kebijakan Privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, dan melindungi informasi yang Anda berikan saat menggunakan layanan kami.'
                ],
                [
                    'section' => '2. Informasi yang Kami Kumpulkan',
                    'subsections' => [
                        [
                            'title' => '2.1 Informasi Pribadi',
                            'content' => 'Informasi yang Anda berikan secara langsung seperti nama, alamat email, dan data profil saat mendaftar atau menggunakan layanan kami.'
                        ],
                        [
                            'title' => '2.2 Data Penggunaan',
                            'content' => 'Informasi yang dikumpulkan secara otomatis termasuk alamat IP, jenis browser, halaman yang dikunjungi, dan waktu akses.'
                        ]
                    ]
                ],
                [
                    'section' => '3. Penggunaan Informasi',
                    'content' => 'Kami menggunakan informasi yang dikumpulkan untuk: menyediakan dan meningkatkan layanan, mengirim notifikasi penting, personalisasi pengalaman pengguna, dan analisis data untuk pengembangan produk.'
                ],
                [
                    'section' => '4. Perlindungan Data',
                    'content' => 'Kami menerapkan langkah-langkah keamanan teknis dan organisasi yang wajar untuk melindungi data pribadi Anda dari akses, penggunaan, atau pengungkapan yang tidak sah.'
                ]
            ],
            'footer' => [
                'version' => '1.0',
                'lastUpdated' => now()->format('F j, Y'),
                'authors' => 'Tim Pengembang INNOFORUM',
                'institution' => 'INNOFORUM Platform'
            ]
        ];

        return view('legal.privacy-policy', ['data' => $data]);
    }

    public function termsAndConditions()
    {
        $data = [
            'title' => 'Terms & Conditions',
            'lastUpdated' => now()->format('F j, Y'),
            'content' => [
                [
                    'section' => '1. Persetujuan Penggunaan',
                    'content' => 'Dengan mengakses dan menggunakan INNOFORUM, Anda setuju untuk terikat oleh syarat dan ketentuan yang diatur dalam dokumen ini.'
                ],
                [
                    'section' => '2. Akun Pengguna',
                    'subsections' => [
                        [
                            'title' => '2.1 Pendaftaran Akun',
                            'content' => 'Anda harus mendaftar dengan informasi yang akurat dan lengkap. Setiap akun bersifat pribadi dan tidak boleh digunakan oleh orang lain.'
                        ],
                        [
                            'title' => '2.2 Keamanan Akun',
                            'content' => 'Anda bertanggung jawab untuk menjaga kerahasiaan kata sandi dan semua aktivitas yang terjadi dalam akun Anda.'
                        ]
                    ]
                ],
                [
                    'section' => '3. Konten Pengguna',
                    'content' => 'Anda mempertahankan hak atas konten yang Anda posting, namun memberikan kami lisensi untuk menampilkan dan mendistribusikan konten tersebut dalam platform.'
                ],
                [
                    'section' => '4. Perilaku yang Dilarang',
                    'content' => 'Dilarang melakukan aktivitas ilegal, spam, hacking, penyebaran konten berbahaya, atau pelanggaran hak kekayaan intelektual di platform ini.'
                ]
            ],
            'footer' => [
                'version' => '1.0',
                'lastUpdated' => now()->format('F j, Y'),
                'authors' => 'Tim Pengembang INNOFORUM',
                'institution' => 'INNOFORUM Platform'
            ]
        ];

        return view('legal.terms-conditions', ['data' => $data]);
    }

    public function adminPrivacyPolicy()
    {
        $data = [
            'title' => 'Privacy Policy',
            'lastUpdated' => now()->format('F j, Y'),
            'content' => [
                [
                    'section' => '1. Introduction',
                    'content' => 'Kami berkomitmen untuk melindungi privasi dan data pribadi Anda. Kebijakan Privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, dan melindungi informasi yang Anda berikan saat menggunakan layanan kami.'
                ],
                [
                    'section' => '2. Informasi yang Kami Kumpulkan',
                    'subsections' => [
                        [
                            'title' => '2.1 Informasi Pribadi',
                            'content' => 'Informasi yang Anda berikan secara langsung seperti nama, alamat email, dan data profil saat mendaftar atau menggunakan layanan kami.'
                        ],
                        [
                            'title' => '2.2 Data Penggunaan',
                            'content' => 'Informasi yang dikumpulkan secara otomatis termasuk alamat IP, jenis browser, halaman yang dikunjungi, dan waktu akses.'
                        ]
                    ]
                ],
                [
                    'section' => '3. Penggunaan Informasi',
                    'content' => 'Kami menggunakan informasi yang dikumpulkan untuk: menyediakan dan meningkatkan layanan, mengirim notifikasi penting, personalisasi pengalaman pengguna, dan analisis data untuk pengembangan produk.'
                ],
                [
                    'section' => '4. Perlindungan Data',
                    'content' => 'Kami menerapkan langkah-langkah keamanan teknis dan organisasi yang wajar untuk melindungi data pribadi Anda dari akses, penggunaan, atau pengungkapan yang tidak sah.'
                ]
            ],
            'footer' => [
                'version' => '1.0',
                'lastUpdated' => now()->format('F j, Y'),
                'authors' => 'Tim Pengembang INNOFORUM',
                'institution' => 'INNOFORUM Platform'
            ]
        ];

        return view('legal.admin-privacy-policy', ['data' => $data]);
    }

    public function adminTermsAndConditions()
    {
        $data = [
            'title' => 'Terms & Conditions',
            'lastUpdated' => now()->format('F j, Y'),
            'content' => [
                [
                    'section' => '1. Persetujuan Penggunaan',
                    'content' => 'Dengan mengakses dan menggunakan INNOFORUM, Anda setuju untuk terikat oleh syarat dan ketentuan yang diatur dalam dokumen ini.'
                ],
                [
                    'section' => '2. Akun Pengguna',
                    'subsections' => [
                        [
                            'title' => '2.1 Pendaftaran Akun',
                            'content' => 'Anda harus mendaftar dengan informasi yang akurat dan lengkap. Setiap akun bersifat pribadi dan tidak boleh digunakan oleh orang lain.'
                        ],
                        [
                            'title' => '2.2 Keamanan Akun',
                            'content' => 'Anda bertanggung jawab untuk menjaga kerahasiaan kata sandi dan semua aktivitas yang terjadi dalam akun Anda.'
                        ]
                    ]
                ],
                [
                    'section' => '3. Konten Pengguna',
                    'content' => 'Anda mempertahankan hak atas konten yang Anda posting, namun memberikan kami lisensi untuk menampilkan dan mendistribusikan konten tersebut dalam platform.'
                ],
                [
                    'section' => '4. Perilaku yang Dilarang',
                    'content' => 'Dilarang melakukan aktivitas ilegal, spam, hacking, penyebaran konten berbahaya, atau pelanggaran hak kekayaan intelektual di platform ini.'
                ]
            ],
            'footer' => [
                'version' => '1.0',
                'lastUpdated' => now()->format('F j, Y'),
                'authors' => 'Tim Pengembang INNOFORUM',
                'institution' => 'INNOFORUM Platform'
            ]
        ];

        return view('legal.admin-terms-conditions', ['data' => $data]);
    }
}
