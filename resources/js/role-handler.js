document.addEventListener('DOMContentLoaded', function () {
    const roleDropdown = document.getElementById('role');
    const prodiGroup = document.getElementById('prodi-group');

    function toggleProdi() {
        if (roleDropdown.value === 'mahasiswa') {
            prodiGroup.style.display = 'block'; // Tampilkan Prodi
        } else {
            prodiGroup.style.display = 'none'; // Sembunyikan Prodi
        }
    }

    // Jalankan fungsi saat halaman dimuat
    toggleProdi();

    // Tambahkan event listener untuk perubahan dropdown role
    roleDropdown.addEventListener('change', toggleProdi);
});