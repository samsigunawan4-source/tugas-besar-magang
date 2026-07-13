# Task List: Modul Penyelesaian Magang (Laporan & Sertifikat)

- `[x]` **Fase 1: Database & Model**
  - `[x]` Buat migration untuk menambahkan kolom `laporan_akhir`, `sertifikat`, `nilai`, dan `tgl_selesai_magang` di tabel `applications`.
  - `[x]` Tambahkan kolom tersebut ke dalam `$fillable` di model `Application`.
- `[x]` **Fase 2: Perombakan Logika Admin**
  - `[x]` Hapus fitur klik manual "Selesai Magang" di `AdminController@verifyApplication`.
  - `[x]` Hapus tombol "Selesai Magang" di tampilan `admin/applications/index.blade.php`.
- `[x]` **Fase 3: Alur Mahasiswa (Upload Laporan Akhir)**
  - `[x]` Tambahkan UI upload laporan akhir di `student/applications/index.blade.php`.
  - `[x]` Buat route dan method di `ApplicationController` (atau controller baru) untuk menangani upload laporan akhir mahasiswa.
- `[x]` **Fase 4: Alur Perusahaan (Upload Sertifikat & Nilai)**
  - `[x]` Tambahkan UI aksi "Selesaikan Magang" di `company/applications/index.blade.php`.
  - `[x]` Buat route dan method di `CompanyController` (atau controller relevan) untuk perusahaan memberikan nilai dan upload sertifikat, lalu mengubah status jadi `completed`.
- `[x]` **Fase 5: Tampilan Akhir Admin (Monitoring Dokumen)**
  - `[x]` Update `admin/students/show.blade.php` untuk menampilkan Laporan Akhir dan Sertifikat jika tersedia.
