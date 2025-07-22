-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 15 Jul 2025 pada 12.52
-- Versi server: 10.11.10-MariaDB-log
-- Versi PHP: 8.3.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `simpegll_arsip`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `arsip`
--

CREATE TABLE `arsip` (
  `nomor_dokumen` bigint(20) UNSIGNED NOT NULL,
  `kode_dokumen` varchar(255) NOT NULL,
  `nama_dokumen` varchar(255) NOT NULL,
  `tanggal_arsip` date NOT NULL,
  `deskripsi_arsip` varchar(255) NOT NULL,
  `dasar_hukum` bigint(20) UNSIGNED NOT NULL,
  `klasifikasi` bigint(20) UNSIGNED NOT NULL,
  `jadwal_retensi_arsip_aktif` int(11) NOT NULL,
  `jadwal_retensi_arsip_inaktif` int(11) NOT NULL,
  `penyusutan_akhir` varchar(255) NOT NULL,
  `keterangan_penyusutan` varchar(255) NOT NULL,
  `keamanan_arsip` varchar(255) NOT NULL,
  `lokasi_penyimpanan` varchar(255) NOT NULL,
  `filling_cabinet` varchar(255) NOT NULL,
  `laci` varchar(255) NOT NULL,
  `folder` varchar(255) NOT NULL,
  `kata_kunci` varchar(255) NOT NULL,
  `verifikasi_arsip` enum('Verifikasi','Direvisi','Disetujui') NOT NULL DEFAULT 'Verifikasi',
  `catatan_revisi` text DEFAULT NULL,
  `status_dokumen` varchar(255) NOT NULL,
  `dibuat_oleh` bigint(20) UNSIGNED NOT NULL,
  `disetujui_oleh` bigint(20) UNSIGNED DEFAULT NULL,
  `batas_status_retensi_aktif` date NOT NULL,
  `batas_status_retensi_inaktif` date NOT NULL,
  `vital` varchar(255) NOT NULL,
  `terjaga` varchar(255) NOT NULL,
  `memori_kolektif_bangsa` varchar(255) NOT NULL,
  `arsip_dokumen` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `surat_berita_path` varchar(255) DEFAULT NULL,
  `tanggal_musnahkan` date DEFAULT NULL COMMENT 'Tanggal arsip dimusnahkan'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `arsip`
--

INSERT INTO `arsip` (`nomor_dokumen`, `kode_dokumen`, `nama_dokumen`, `tanggal_arsip`, `deskripsi_arsip`, `dasar_hukum`, `klasifikasi`, `jadwal_retensi_arsip_aktif`, `jadwal_retensi_arsip_inaktif`, `penyusutan_akhir`, `keterangan_penyusutan`, `keamanan_arsip`, `lokasi_penyimpanan`, `filling_cabinet`, `laci`, `folder`, `kata_kunci`, `verifikasi_arsip`, `catatan_revisi`, `status_dokumen`, `dibuat_oleh`, `disetujui_oleh`, `batas_status_retensi_aktif`, `batas_status_retensi_inaktif`, `vital`, `terjaga`, `memori_kolektif_bangsa`, `arsip_dokumen`, `created_at`, `updated_at`, `surat_berita_path`, `tanggal_musnahkan`) VALUES
(1, 'SK.01.00/2022/001', 'Laporan Media Sosial 2022', '2022-01-10', 'Laporan kegiatan promosi', 8, 4, 2, 3, '2027', 'Musnah', 'Biasa', 'Rak A1', 'FC-01', '1', '1', '[\"media\",\"humas\"]', 'Disetujui', NULL, 'Inaktif', 4, 1, '2024-12-31', '2025-12-31', 'Tidak', 'Ya', 'Tidak', '[\"1748923777_683e7581705ee_Notes Gmeet 15 Mei_250515_204102 (1).pdf\",\"1748923777_683e75817a30c_gmeet pa hedi 23 mei_250523_194455.pdf\",\"1748923777_683e75817afd7_Notes Gmeet 15 Mei_250515_204102.pdf\"]', '2025-06-03 04:09:37', '2025-06-14 21:26:04', NULL, NULL),
(29, 'DV.01.02/2018/001', 'MoU Instansi', '2018-01-20', 'MoU dengan instansi lain', 8, 2, 3, 2, 'Permanen', 'Musnah', 'Biasa', 'Rak A2', 'FC-01', '3', 'D', '[\"mou\",\"kerjasama\"]', 'Disetujui', NULL, 'Musnah', 4, 1, '2021-12-31', '2020-12-31', 'Ya', 'Ya', 'Ya', '[\"1748924984_683e7a381f74a_Notes Gmeet 15 Mei_250515_204102 (1).pdf\",\"1748924984_683e7a3824e62_gmeet pa hedi 23 mei_250523_194455.pdf\",\"1748924984_683e7a3825473_1579-3773-1-PB.pdf\",\"1748924984_683e7a38257b2_Notes Gmeet 15 Mei_250515_204102.pdf\"]', '2025-06-03 04:29:44', '2025-06-16 12:23:08', 'surat_berita/1750051388_gmeet pa hedi 23 mei_250523_194455.pdf', '2025-06-16'),
(30, 'SK.01.02/2023/001', 'Surat Edaran Humas', '2023-04-25', 'Edaran ke publik', 8, 6, 2, 3, 'Musnah', 'Musnah', 'Biasa', 'Rak H1', 'FC-07', '1', 'G', '[\"edaran\",\"informasi\"]', 'Disetujui', NULL, 'Aktif', 4, 1, '2025-12-31', '2026-12-31', 'Tidak', 'Ya', 'Tidak', '[\"1748925164_683e7aec579e3_Notes Gmeet 15 Mei_250515_204102 (1).pdf\"]', '2025-06-03 04:32:44', '2025-06-03 06:35:06', NULL, NULL),
(31, 'SK.02.02/2023/002', 'Publikasi Website', '2023-03-10', 'Rilis berita', 8, 9, 2, 3, 'Musnah', 'Musnah', 'Biasa', 'Rak F4', 'FC-05', '3', 'S', '[\"berita\",\"publikasi\"]', 'Disetujui', NULL, 'Aktif', 4, 1, '2025-12-31', '2026-12-31', 'Tidak', 'Ya', 'Ya', '[\"1748925336_683e7b987740f_Notes Gmeet 15 Mei_250515_204102 (1).pdf\",\"1748925336_683e7b987bbd8_gmeet pa hedi 23 mei_250523_194455.pdf\",\"1748925336_683e7b987c5fe_1579-3773-1-PB.pdf\",\"1748925336_683e7b987ccde_Notes Gmeet 15 Mei_250515_204102.pdf\"]', '2025-06-03 04:35:36', '2025-06-03 06:34:12', NULL, NULL),
(32, 'SK.01.00/2024/001', 'Undangan Diskusi', '2024-12-01', 'Undangan ke mitra kerja', 8, 4, 2, 3, 'Musnah', 'Musnah', 'Biasa', 'Rak C3', 'FC-02', '1', 'C', '[\"undangan\",\"mitra\"]', 'Disetujui', NULL, 'Aktif', 4, 1, '2026-12-31', '2027-12-31', 'Tidak', 'Tidak', 'Tidak', '[\"1748925450_683e7c0a58ead_Notes Gmeet 15 Mei_250515_204102.pdf\"]', '2025-06-03 04:37:30', '2025-06-03 06:31:07', NULL, NULL),
(33, 'SK.01.01/2023/003', 'Notulen Rapat', '2023-09-30', 'Rapat internal TU', 8, 5, 2, 3, 'Musnah', 'Musnah', 'Biasa', 'Rak D1', 'FC-04', '2', 'E', '[\"notulen\",\"rapat\"]', 'Disetujui', NULL, 'Aktif', 4, 1, '2025-12-31', '2026-12-31', 'Tidak', 'Tidak', 'Tidak', '[\"1748925582_683e7c8e8bebf_Notes Gmeet 15 Mei_250515_204102 (1).pdf\"]', '2025-06-03 04:39:42', '2025-06-03 06:32:45', NULL, NULL),
(34, 'SK.01.01/2023/004', 'Surat Masuk TU', '2023-06-15', 'Surat dari Biro Umum', 8, 5, 2, 3, 'Musnah', 'Musnah', 'Biasa', 'Rak A1', 'FC-01', '1', 'A', '[\"surat masuk\",\"biro umum\"]', 'Direvisi', 'Tolong di revisi tanggalnya', 'Aktif', 4, NULL, '2025-12-31', '2026-12-31', 'Tidak', 'Ya', 'Tidak', '[\"1748925740_683e7d2c53efc_Notes Gmeet 15 Mei_250515_204102.pdf\"]', '2025-06-03 04:42:20', '2025-06-05 06:22:54', NULL, NULL),
(35, 'SK.01.02/2022/002', 'SK Tugas Luar', '2022-05-10', 'Penugasan luar kota', 8, 6, 2, 3, 'Musnah', 'Musnah', 'Biasa', 'Rak B4', 'FC-03', '4', 'F', '[\"tugas\",\"luar kota\"]', 'Disetujui', NULL, 'Inaktif', 4, 1, '2024-12-31', '2025-12-31', 'Tidak', 'Ya', 'Tidak', '[\"1748925873_683e7db107695_Notes Gmeet 15 Mei_250515_204102 (1).pdf\"]', '2025-06-03 04:44:33', '2025-06-03 07:42:01', NULL, NULL),
(36, 'SK.01.02/2022/003', 'Laporan Kinerja', '2022-06-01', 'Laporan tahunan', 8, 6, 2, 3, 'Permanen', 'Musnah', 'Biasa', 'Rak F1', 'FC-05', '2', 'H', '[\"laporan kinerja\"]', 'Direvisi', 'Revisi isi laporan di bagian Tim Kerja Kelembagaan', 'Inaktif', 4, NULL, '2024-12-31', '2025-12-31', 'Ya', 'Tidak', 'Ya', '[\"1748926036_683e7e5479f90_gmeet pa hedi 23 mei_250523_194455.pdf\"]', '2025-06-03 04:47:16', '2025-06-14 21:26:04', NULL, NULL),
(37, 'SK.00.01/2025/001', 'SOP Baru', '2025-05-20', 'Prosedur kerja baru', 8, 3, 2, 3, 'Musnah', 'Permanen', 'Biasa', 'Rak A5', 'FC-01', '1', 'K', '[\"SOP\",\"prosedur kerja\"]', 'Disetujui', NULL, 'Aktif', 4, 1, '2027-12-31', '2028-12-31', 'Tidak', 'Tidak', 'Tidak', '[\"1748926203_683e7efb97ad5_Panduan Penggunaan SINDE bagi Admin Unit dan Operator.pdf\"]', '2025-06-03 04:50:03', '2025-06-03 06:30:55', NULL, NULL),
(38, 'SK.03.00/2023/005', 'Nota Dinas', '2023-02-05', 'Permintaan ATK', 8, 10, 2, 3, 'Musnah', 'Musnah', 'Biasa', 'Rak C5', 'FC-04', '3', 'L', '[\"nota dinas\",\"ATK\"]', 'Direvisi', 'Berikan juga bukti nota, tolong di fotokan dan sertakan dalam laporannya', 'Aktif', 4, NULL, '2025-12-31', '2026-12-31', 'Tidak', 'Tidak', 'Tidak', '[\"1748926303_683e7f5f2fba4_gmeet pa hedi 23 mei_250523_194455.pdf\"]', '2025-06-03 04:51:43', '2025-06-03 06:34:52', NULL, NULL),
(39, 'DV.01.02/2021/001', 'Hasil Monitoring', '2021-09-20', 'Monitoring ke lapangan', 8, 2, 3, 2, 'Musnah', 'Musnah', 'Biasa', 'Rak D4', 'FC-03', '1', 'M', '[\"monitoring\",\"laporan\"]', 'Disetujui', NULL, 'Musnah', 4, 1, '2024-12-31', '2023-12-31', 'Tidak', 'Ya', 'Tidak', '[\"1748926447_683e7fefd13fa_Notes Gmeet 15 Mei_250515_204102 (1).pdf\",\"1748926447_683e7fefd8aab_gmeet pa hedi 23 mei_250523_194455.pdf\",\"1748926447_683e7fefd9637_1579-3773-1-PB.pdf\",\"1748926447_683e7fefd9d39_Notes Gmeet 15 Mei_250515_204102.pdf\"]', '2025-06-03 04:54:07', '2025-06-18 20:19:03', 'surat_berita/1750252743_162021041_Tugas3_Correlation Matrix.pdf', '2025-06-18'),
(40, 'SK.03.01/2023/006', 'Pemberitahuan Kegiatan', '2023-07-08', 'Info kegiatan publik', 8, 11, 2, 3, 'Musnah', 'Musnah', 'Biasa', 'Rak B1', 'FC-02', '4', 'O', '[\"surat balasan\"]', 'Disetujui', NULL, 'Aktif', 4, 1, '2025-12-31', '2026-12-31', 'Tidak', 'Tidak', 'Tidak', '[\"1748926555_683e805bbede7_Notes Gmeet 15 Mei_250515_204102 (1).pdf\"]', '2025-06-03 04:55:55', '2025-06-03 06:33:01', NULL, NULL),
(41, 'SK.02.02/2024/002', 'Peraturan Internal', '2024-01-06', 'Peraturan kerja sama', 8, 9, 2, 3, 'Permanen', 'Musnah', 'Biasa', 'Rak B5', 'FC-04', '4', 'T', '[\"peraturan\",\"internal\"]', 'Disetujui', NULL, 'Aktif', 4, 1, '2026-12-31', '2027-12-31', 'Ya', 'Ya', 'Ya', '[\"1748926675_683e80d30ecaf_Notes Gmeet 15 Mei_250515_204102.pdf\"]', '2025-06-03 04:57:55', '2025-06-03 06:32:34', NULL, NULL),
(42, 'SK.01.00/2024/003', 'Formulir Cuti', '2024-11-25', 'Permohonan cuti tahunan', 8, 4, 2, 3, 'Musnah', 'Musnah', 'Biasa', 'Rak A4', 'FC-01', '3', 'R', '[\"cuti\",\"tahunan\"]', 'Disetujui', NULL, 'Aktif', 5, 1, '2026-12-31', '2027-12-31', 'Tidak', 'Tidak', 'Tidak', '[\"1748926863_683e818ff0b13_gmeet pa hedi 23 mei_250523_194455.pdf\"]', '2025-06-03 05:01:04', '2025-06-03 06:32:23', NULL, NULL),
(43, 'SK.03.01/2019/001', 'Hasil Sidang Disiplin', '2019-01-12', 'Pelanggaran disiplin ASN', 8, 11, 2, 3, 'Permanen', 'Musnah', 'Biasa', 'Rak E1', 'FC-03', '2', 'Q', '[\"disiplin\",\"pegawai\"]', 'Disetujui', NULL, 'Musnah', 5, 1, '2021-12-31', '2022-12-31', 'Ya', 'Ya', 'Ya', '[\"1748926964_683e81f4d1e56_Notes Gmeet 15 Mei_250515_204102.pdf\"]', '2025-06-03 05:02:44', '2025-06-16 12:31:16', 'surat_berita/1750051876_Berita_Acara_Pemusnahan_Arsip.pdf', '2025-06-16'),
(44, 'SK.01.02/2020/001', 'Resume Kasus', '2020-03-30', 'Kasus internal pegawai', 8, 6, 2, 3, 'Permanen', 'Musnah', 'Biasa', 'Rak H5', 'FC-07', '2', 'N', '[\"kasus\",\"hukum\"]', 'Disetujui', NULL, 'Musnah', 5, 1, '2022-12-31', '2023-12-31', 'Ya', 'Ya', 'Ya', '[\"1748929652_683e8c74bf7d0_Notes Gmeet 15 Mei_250515_204102.pdf\"]', '2025-06-03 05:47:32', '2025-06-03 08:05:35', 'surat_berita/1748937935_gmeet pa hedi 23 mei_250523_194455.pdf', NULL),
(45, 'SK.03.01/2019/002', 'Perjanjian Kerja', '2019-04-11', 'Pegawai kontrak', 8, 11, 2, 3, 'Musnah', 'Musnah', 'Biasa', 'Rak E3', 'FC-02', '4', 'J', '[\"perjanjian\",\"pegawai\"]', 'Disetujui', NULL, 'Musnah', 5, 1, '2021-12-31', '2022-12-31', 'Tidak', 'Tidak', 'Tidak', '[\"1748929776_683e8cf0af93c_Notes Gmeet 15 Mei_250515_204102.pdf\"]', '2025-06-03 05:49:36', '2025-06-04 11:45:06', 'surat_berita/1749037506_gmeet pa hedi 23 mei_250523_194455.pdf', NULL),
(46, 'SK.02.00/2021/002', 'SK Pemberhentian', '2021-06-10', 'SK untuk pegawai purna tugas', 8, 7, 2, 3, 'Permanen', 'Musnah', 'Biasa', 'Rak B2', 'FC-03', '2', 'B', '[\"SK\",\"pegawai\"]', 'Disetujui', NULL, 'Inaktif', 5, 1, '2023-12-31', '2024-12-31', 'Ya', 'Ya', 'Ya', '[\"1748929867_683e8d4b7ada6_Notes Gmeet 15 Mei_250515_204102 (1).pdf\"]', '2025-06-03 05:51:07', '2025-06-14 21:26:04', NULL, NULL),
(47, 'SK.02.01/2020/002', 'Laporan Kegiatan Tim Kerja TU, Humas, dan Kerjasama', '2020-06-11', 'Laporan kegiatan tahunan Tim Kerja TU, Humas, dan Kerjasama Tahun 2023', 8, 8, 2, 3, '-', 'Musnah', 'Biasa', 'Rak A1', 'FC-01', '3', 'A', '[\"TU\",\"Humas\",\"kerjasama\",\"laporan\"]', 'Disetujui', NULL, 'Musnah', 4, 1, '2022-12-31', '2023-12-31', 'Tidak', 'Tidak', 'Tidak', '[\"1749647874_684982022a0e9_Surat Keterangan Aktif Kuliah.pdf\"]', '2025-06-11 13:17:54', '2025-06-18 20:19:03', 'surat_berita/1750252743_162021041_Tugas3_Correlation Matrix.pdf', '2025-06-18'),
(48, 'SK.01.02/2011/001', 'Dokumen Kepegawaian', '2011-06-08', 'abc', 8, 6, 2, 3, '-', 'Musnah', 'Biasa', 'Laci', 'A23', 'Laci 12', 'A24', '[\"dokumen\"]', 'Disetujui', NULL, 'Musnah', 12, 1, '2013-06-08', '2016-06-08', 'ya', 'ya', 'tidak', '[\"1749649550_6849888e87d48_Surat Keterangan Aktif Kuliah.pdf\"]', '2025-06-11 13:45:50', '2025-06-11 13:47:28', NULL, NULL),
(49, 'SK.01.00/2025/002', 'Dokumen Akdemik 1', '2025-06-14', 'file akademik', 8, 4, 2, 3, '-', 'Musnah', 'Biasa', 'Laci Perpus', '2', '3', 'lldikti', '[\"akademik\"]', 'Disetujui', NULL, 'Aktif', 13, 1, '2027-12-31', '2028-12-31', 'Tidak', 'Tidak', 'Tidak', '[\"1749912100_684d8a247375f_SENTIMENT ANALYSIS USING SUPPORT VECTOR MACHINED BASED ON FEATURE SELECTION AND SEMANTIC ANALYSIS.pdf\"]', '2025-06-14 21:41:40', '2025-06-14 21:42:06', NULL, NULL),
(50, 'DV.01.02/2025/004', 'Dokumen Pemberitahuan Pengawas', '2025-06-12', 'File ini berisikan pemberitahuan kepengawasan instansi', 8, 2, 3, 2, '-', 'Musnah', 'Biasa', 'Laci Perpus', '2', '3', 'lldikti', '[\"pengawas\",\"tahura\",\"instansi\",\"pemerintah\",\"pemberitahuan\"]', 'Direvisi', 'Terdapat kesalahan dalam penulisan nama dokumen', 'Aktif', 4, NULL, '2028-06-12', '2030-06-12', 'tidak', 'tidak', 'tidak', '\"[\\\"1749998996_Report Mingguan E-Arsip.pdf\\\"]\"', '2025-06-15 21:26:50', '2025-06-18 20:05:31', NULL, NULL),
(51, 'SK.01.00/2025/004', 'Laporan Media Sosial 2023', '2025-06-24', 'Laporan terkait media sosial 2023', 8, 4, 2, 3, '-', 'Musnah', 'Biasa', 'Rak A5', 'FC-03', '2', 'K', '[\"sosial\",\"media\"]', 'Disetujui', NULL, 'Aktif', 4, 1, '2027-12-31', '2028-12-31', 'Ya', 'Ya', 'Ya', '[\"1750644711_6858b7e7af6d0_3125-8186-1-PB.pdf\"]', '2025-06-23 09:11:51', '2025-06-23 11:25:21', NULL, NULL),
(52, 'SK.00.01/2025/005', 'Evaluasi Program Pelatihan Guru 2024', '2025-06-24', 'Dokumen hasil evaluasi pelaksanaan pelatihan guru tahun 2024 yang diselenggarakan oleh Dinas Pendidikan.', 8, 3, 2, 3, '-', 'Permanen', 'Biasa', 'Rak D4', 'FC-03', '2', 'M', '[\"pelatihan\",\"guru\"]', 'Verifikasi', NULL, 'Aktif', 4, NULL, '2027-12-31', '2028-12-31', 'Ya', 'Ya', 'Ya', '[\"1750644796_6858b83c62f2c_13750-Article Text-18205-1-10-20240710 (1).pdf\"]', '2025-06-23 09:13:16', '2025-06-23 09:13:16', NULL, NULL),
(53, 'SK.01.01/2025/006', 'Notulen Rapat Koordinasi Bulanan April 2025', '2025-06-23', 'Notulen rapat koordinasi bulanan yang membahas evaluasi kinerja dan perencanaan program Mei 2025.', 8, 5, 2, 3, '-', 'Musnah', 'Biasa', 'Rak A1', 'FC-01', '3', 'L', '[\"rapat\",\"koordinasi\",\"mei\",\"2025\"]', 'Verifikasi', NULL, 'Aktif', 13, NULL, '2027-12-31', '2028-12-31', 'Ya', 'Ya', 'Ya', '[\"1750644900_6858b8a40e804_3125-8186-1-PB.pdf\"]', '2025-06-23 09:15:00', '2025-06-23 09:15:00', NULL, NULL),
(54, 'SK.01.01/2025/007', 'Daftar Hadir Kegiatan Sosialisasi Kurikulum Merdeka', '2025-06-23', 'Dokumen daftar hadir peserta kegiatan sosialisasi Kurikulum Merdeka di wilayah Jawa Barat.', 8, 5, 2, 3, '-', 'Musnah', 'Biasa', 'Rak H1', 'FC-04', '4', 'M', '[\"daftar\",\"hadir\",\"kurikulum\",\"merdeka\"]', 'Disetujui', NULL, 'Aktif', 13, 1, '2027-12-31', '2028-12-31', 'Ya', 'Ya', 'Tidak', '[\"1750644995_6858b90379383_13750-Article Text-18205-1-10-20240710 (1).pdf\"]', '2025-06-23 09:16:35', '2025-06-23 11:00:59', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `dasar_hukum`
--

CREATE TABLE `dasar_hukum` (
  `id_dasar_hukum` bigint(20) UNSIGNED NOT NULL,
  `nama_dasar_hukum` varchar(255) NOT NULL,
  `dokumen_dasar_hukum` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `dasar_hukum`
--

INSERT INTO `dasar_hukum` (`id_dasar_hukum`, `nama_dasar_hukum`, `dokumen_dasar_hukum`, `created_at`, `updated_at`) VALUES
(8, 'Permendikbudristek No 20 Tahun 2025.', '1750228556_SALINAN_Permendikbudristek_No_20_2022_Penyelenggraan_Kearsipan_(1).pdf', '2025-05-07 08:58:46', '2025-06-18 20:23:11');

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis`
--

CREATE TABLE `jenis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `jenis`
--

INSERT INTO `jenis` (`id`, `nama`, `created_at`, `updated_at`) VALUES
(1, 'Oraganisasi', '2025-03-03 09:45:00', '2025-03-10 07:27:38'),
(2, 'PMM', '2025-03-10 07:27:49', '2025-03-10 07:27:49');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `klasifikasi`
--

CREATE TABLE `klasifikasi` (
  `id_klasifikasi` bigint(20) UNSIGNED NOT NULL,
  `kode_klasifikasi` varchar(255) NOT NULL,
  `jenis_dokumen` varchar(255) NOT NULL,
  `klasifikasi_keamanan` varchar(255) NOT NULL,
  `hak_akses` varchar(255) NOT NULL,
  `akses_publik` varchar(255) NOT NULL,
  `retensi_aktif` int(10) NOT NULL,
  `retensi_inaktif` int(10) NOT NULL,
  `retensi_keterangan` varchar(255) NOT NULL,
  `unit_pengolah` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `klasifikasi`
--

INSERT INTO `klasifikasi` (`id_klasifikasi`, `kode_klasifikasi`, `jenis_dokumen`, `klasifikasi_keamanan`, `hak_akses`, `akses_publik`, `retensi_aktif`, `retensi_inaktif`, `retensi_keterangan`, `unit_pengolah`, `created_at`, `updated_at`) VALUES
(2, 'DV.01.02', 'Revitalisasi Prodi Vokasi dan Profesi', 'Biasa', 'Pengawas', 'Terbuka', 2, 3, 'Musnah', 'Kelembagaan', '2025-04-25 08:34:16', '2025-06-18 13:41:29'),
(3, 'SK.00.01', 'Kurikulum dan asesmen pendidikan', 'Biasa', 'Pengawas', 'Terbuka', 2, 3, 'Permanen', 'P3K', '2025-05-07 08:27:34', '2025-05-07 08:27:34'),
(4, 'SK.01.00', 'Standar Pendidikan', 'Biasa', 'Pengawas', 'Terbuka', 2, 3, 'Musnah', 'P3K', '2025-05-07 08:27:34', '2025-05-07 08:27:34'),
(5, 'SK.01.01', 'Kurikulum dan asesmen pendidikan', 'Biasa', 'Pengawas', 'Terbuka', 2, 3, 'Musnah', 'P3K', '2025-05-07 08:27:34', '2025-05-07 08:27:34'),
(6, 'SK.01.02', 'Pengembangan dan pembinaan sistem perbukuan', 'Biasa', 'Pengawas', 'Terbuka', 2, 3, 'Musnah', 'P3K', '2025-05-07 08:27:34', '2025-05-07 08:27:34'),
(7, 'SK.02.00', 'Standar dan Kebijakan Pendidikan', 'Biasa', 'Pengawas', 'Terbuka', 2, 3, 'Musnah', 'P3K', '2025-05-07 08:27:34', '2025-05-07 08:27:34'),
(8, 'SK.02.01', 'Kurikulum dan pengembangan pembelajaran', 'Biasa', 'Pengawas', 'Terbuka', 2, 3, 'Musnah', 'P3K', '2025-05-07 08:27:34', '2025-05-07 08:27:34'),
(9, 'SK.02.02', 'Asesmen pendidikan', 'Biasa', 'Pengawas', 'Terbuka', 2, 3, 'Musnah', 'P3K', '2025-05-07 08:27:34', '2025-05-07 08:27:34'),
(10, 'SK.03.00', 'Standar dan Kebijakan Pendidikan', 'Biasa', 'Pengawas', 'Terbuka', 2, 3, 'Musnah', 'P3K', '2025-05-07 08:27:34', '2025-05-07 08:27:34'),
(11, 'SK.03.01', 'Kurikulum dan pengembangan pembelajaran', 'Biasa', 'Pengawas', 'Terbuka', 2, 3, 'Musnah', 'P3K', '2025-05-07 08:27:34', '2025-05-07 08:27:34'),
(12, 'KL.03', 'Sistem Informasi', 'Biasa', 'Pengawas', 'Terbuka', 2, 3, 'Musnah', 'DIPP', '2025-06-05 02:59:17', '2025-06-05 02:59:17'),
(13, 'AL.01', 'Kurikulum PTS', 'Biasa', 'Pengawas', 'Terbuka', 2, 3, 'Musnah', 'P3K', '2025-06-15 21:59:54', '2025-06-15 22:02:08'),
(14, 'LP.01.04', 'Beasiswa Pendidikan Indonesia (BPI)', 'Biasa', 'Pengawas', 'Terbuka', 2, 3, 'Musnah', 'HKT', '2025-06-15 22:03:22', '2025-06-15 22:03:22'),
(15, 'IK.01.00.01', 'Pengabdian Kepada Masyarakat', 'Biasa', 'Pengawas', 'Terbuka', 3, 2, 'Musnah', 'Kelembagaan', '2025-06-18 13:47:04', '2025-06-18 13:47:04'),
(16, 'PK 00', 'Penyiapan kebijakan teknis di bidang penguatan karakter', 'Biasa', 'Pengawas', 'Terbuka', 2, 3, 'Musnah', 'HKT', '2025-06-18 13:59:54', '2025-06-18 13:59:54'),
(17, 'PK.01', 'Pelaksanaan penguatan karakter', 'Biasa', 'Pengawas', 'Terbuka', 2, 3, 'Musnah', 'HKT', '2025-06-18 13:59:54', '2025-06-18 13:59:54'),
(18, 'PK.02', 'Koordinasi dan Fasilitasi', 'Biasa', 'Pengawas', 'Terbuka', 2, 3, 'Musnah', 'HKT', '2025-06-18 13:59:54', '2025-06-18 13:59:54'),
(19, 'PK.03', 'Pemantauan, evaluasi, dan pelaporan', 'Biasa', 'Pengawas', 'Terbuka', 2, 3, 'Musnah', 'DIPP', '2025-06-18 13:59:54', '2025-06-18 13:59:54'),
(20, '002', 'Publikasi Universitas', 'Ya', 'Ya', 'Ya', 3, 2, '-', '-', '2025-06-18 20:48:09', '2025-06-18 20:49:07');

-- --------------------------------------------------------

--
-- Struktur dari tabel `log_aktivitas`
--

CREATE TABLE `log_aktivitas` (
  `id_log_aktivitas` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `aktivitas` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `log_aktivitas`
--

INSERT INTO `log_aktivitas` (`id_log_aktivitas`, `user_id`, `aktivitas`, `created_at`, `updated_at`) VALUES
(39, 4, 'Mengunggah arsip: Laporan Media Sosial 2022', '2025-06-03 04:09:37', '2025-06-03 04:09:37'),
(40, 1, 'Menyetujui arsip \'Laporan Media Sosial 2022\' (Kode Arsip: SK.01.00/2022/001).', '2025-06-03 04:13:20', '2025-06-03 04:13:20'),
(41, 4, 'Mengunggah arsip: MoU Instansi', '2025-06-03 04:29:44', '2025-06-03 04:29:44'),
(42, 4, 'Mengunggah arsip: Surat Edaran Humas', '2025-06-03 04:32:44', '2025-06-03 04:32:44'),
(43, 4, 'Mengunggah arsip: Publikasi Website', '2025-06-03 04:35:36', '2025-06-03 04:35:36'),
(44, 4, 'Mengunggah arsip: Undangan Diskusi', '2025-06-03 04:37:30', '2025-06-03 04:37:30'),
(45, 4, 'Mengunggah arsip: Notulen Rapat', '2025-06-03 04:39:42', '2025-06-03 04:39:42'),
(46, 4, 'Mengunggah arsip: Surat Masuk TU', '2025-06-03 04:42:20', '2025-06-03 04:42:20'),
(47, 4, 'Mengunggah arsip: SK Tugas Luar', '2025-06-03 04:44:33', '2025-06-03 04:44:33'),
(48, 4, 'Mengunggah arsip: Laporan Kinerja', '2025-06-03 04:47:16', '2025-06-03 04:47:16'),
(49, 4, 'Mengunggah arsip: SOP Baru', '2025-06-03 04:50:03', '2025-06-03 04:50:03'),
(50, 4, 'Mengunggah arsip: Nota Dinas', '2025-06-03 04:51:43', '2025-06-03 04:51:43'),
(51, 4, 'Mengunggah arsip: Hasil Monitoring', '2025-06-03 04:54:07', '2025-06-03 04:54:07'),
(52, 4, 'Mengunggah arsip: Pemberitahuan Kegiatan', '2025-06-03 04:55:55', '2025-06-03 04:55:55'),
(53, 4, 'Mengunggah arsip: Peraturan Internal', '2025-06-03 04:57:55', '2025-06-03 04:57:55'),
(54, 5, 'Mengunggah arsip: Formulir Cuti', '2025-06-03 05:01:04', '2025-06-03 05:01:04'),
(55, 5, 'Mengunggah arsip: Hasil Sidang Disiplin', '2025-06-03 05:02:44', '2025-06-03 05:02:44'),
(56, 5, 'Mengunggah arsip: Resume Kasus', '2025-06-03 05:47:32', '2025-06-03 05:47:32'),
(57, 5, 'Mengunggah arsip: Perjanjian Kerja', '2025-06-03 05:49:36', '2025-06-03 05:49:36'),
(58, 5, 'Mengunggah arsip: SK Pemberhentian', '2025-06-03 05:51:07', '2025-06-03 05:51:07'),
(59, 1, 'Menyetujui arsip \'SK Pemberhentian\' (Kode Arsip: SK.02.00/2021/002).', '2025-06-03 06:30:39', '2025-06-03 06:30:39'),
(60, 1, 'Menyetujui arsip \'SOP Baru\' (Kode Arsip: SK.00.01/2025/001).', '2025-06-03 06:30:55', '2025-06-03 06:30:55'),
(61, 1, 'Menyetujui arsip \'Undangan Diskusi\' (Kode Arsip: SK.01.00/2024/001).', '2025-06-03 06:31:07', '2025-06-03 06:31:07'),
(62, 1, 'Menyetujui arsip \'Formulir Cuti\' (Kode Arsip: SK.01.00/2024/003).', '2025-06-03 06:32:23', '2025-06-03 06:32:23'),
(63, 1, 'Menyetujui arsip \'Peraturan Internal\' (Kode Arsip: SK.02.02/2024/002).', '2025-06-03 06:32:34', '2025-06-03 06:32:34'),
(64, 1, 'Menyetujui arsip \'Notulen Rapat\' (Kode Arsip: SK.01.01/2023/003).', '2025-06-03 06:32:45', '2025-06-03 06:32:45'),
(65, 1, 'Menyetujui arsip \'Pemberitahuan Kegiatan\' (Kode Arsip: SK.03.01/2023/006).', '2025-06-03 06:33:01', '2025-06-03 06:33:01'),
(66, 1, 'Memberikan revisi pada arsip \'Laporan Kinerja\' (No: 36). Catatan: Revisi isi laporan di bagian Tim Kerja Kelembagaan', '2025-06-03 06:33:52', '2025-06-03 06:33:52'),
(67, 1, 'Menyetujui arsip \'Publikasi Website\' (Kode Arsip: SK.02.02/2023/002).', '2025-06-03 06:34:12', '2025-06-03 06:34:12'),
(68, 1, 'Memberikan revisi pada arsip \'Nota Dinas\' (No: 38). Catatan: Berikan juga bukti nota, tolong di fotokan dan sertakan dalam laporannya', '2025-06-03 06:34:52', '2025-06-03 06:34:52'),
(69, 1, 'Menyetujui arsip \'Surat Edaran Humas\' (Kode Arsip: SK.01.02/2023/001).', '2025-06-03 06:35:06', '2025-06-03 06:35:06'),
(70, 1, 'Menyetujui arsip \'MoU Instansi\' (Kode Arsip: DV.01.02/2018/001).', '2025-06-03 07:40:12', '2025-06-03 07:40:12'),
(71, 1, 'Menyetujui arsip \'Hasil Sidang Disiplin\' (Kode Arsip: SK.03.01/2019/001).', '2025-06-03 07:40:35', '2025-06-03 07:40:35'),
(72, 1, 'Menyetujui arsip \'Perjanjian Kerja\' (Kode Arsip: SK.03.01/2019/002).', '2025-06-03 07:40:58', '2025-06-03 07:40:58'),
(73, 1, 'Menyetujui arsip \'Resume Kasus\' (Kode Arsip: SK.01.02/2020/001).', '2025-06-03 07:41:15', '2025-06-03 07:41:15'),
(74, 1, 'Menyetujui arsip \'Hasil Monitoring\' (Kode Arsip: DV.01.02/2021/001).', '2025-06-03 07:41:31', '2025-06-03 07:41:31'),
(75, 1, 'Menyetujui arsip \'SK Tugas Luar\' (Kode Arsip: SK.01.02/2022/002).', '2025-06-03 07:42:01', '2025-06-03 07:42:01'),
(76, 1, 'Memberikan revisi pada arsip \'Surat Masuk TU\' (No: 34). Catatan: Tolong di revisi tanggalnya', '2025-06-05 06:22:54', '2025-06-05 06:22:54'),
(77, 4, 'Mengunggah arsip: Laporan Kegiatan Tim Kerja TU, Humas, dan Kerjasama', '2025-06-11 13:17:54', '2025-06-11 13:17:54'),
(78, 1, 'Menyetujui arsip \'Laporan Kegiatan Tim Kerja TU, Humas, dan Kerjasama\' (Kode Arsip: SK.02.01/2020/002).', '2025-06-11 13:21:29', '2025-06-11 13:21:29'),
(79, 12, 'Mengunggah arsip: Dokumen Kepegawaian', '2025-06-11 13:45:50', '2025-06-11 13:45:50'),
(80, 1, 'Menyetujui arsip \'Dokumen Kepegawaian\' (Kode Arsip: SK.01.02/2011/001).', '2025-06-11 13:47:28', '2025-06-11 13:47:28'),
(81, 13, 'Mengunggah arsip: Dokumen Akdemik 1', '2025-06-14 21:41:40', '2025-06-14 21:41:40'),
(82, 1, 'Menyetujui arsip \'Dokumen Akdemik 1\' (Kode Arsip: SK.01.00/2025/002).', '2025-06-14 21:42:06', '2025-06-14 21:42:06'),
(83, 4, 'Mengunggah arsip: Dokumen Pemberitahuan Pengawas', '2025-06-15 21:26:50', '2025-06-15 21:26:50'),
(84, 1, 'Menyetujui arsip \'Dokumen Pemberitahuan Pengawas\' (Kode Arsip: SK.02.02/2025/004).', '2025-06-16 11:34:37', '2025-06-16 11:34:37'),
(85, 1, 'Menyetujui arsip \'Dokumen Pemberitahuan Pengawas\' (Kode Arsip: SK.02.02/2025/004).', '2025-06-16 11:58:16', '2025-06-16 11:58:16'),
(86, 1, 'Memberikan revisi pada arsip \'Dokumen Pemberitahuan Pengawas\' (No: 50). Catatan: Terdapat kesalahan dalam penulisan nama dokumen', '2025-06-18 20:05:31', '2025-06-18 20:05:31'),
(87, 4, 'Mengunggah arsip: Laporan Media Sosial 2023', '2025-06-23 09:11:51', '2025-06-23 09:11:51'),
(88, 4, 'Mengunggah arsip: Evaluasi Program Pelatihan Guru 2024', '2025-06-23 09:13:16', '2025-06-23 09:13:16'),
(89, 13, 'Mengunggah arsip: Notulen Rapat Koordinasi Bulanan April 2025', '2025-06-23 09:15:00', '2025-06-23 09:15:00'),
(90, 13, 'Mengunggah arsip: Daftar Hadir Kegiatan Sosialisasi Kurikulum Merdeka', '2025-06-23 09:16:35', '2025-06-23 09:16:35'),
(91, 1, 'Menyetujui arsip \'Daftar Hadir Kegiatan Sosialisasi Kurikulum Merdeka\' (Kode Arsip: SK.01.01/2025/007).', '2025-06-23 11:00:59', '2025-06-23 11:00:59'),
(92, 1, 'Menyetujui arsip \'Laporan Media Sosial 2023\' (Kode Arsip: SK.01.00/2025/004).', '2025-06-23 11:25:21', '2025-06-23 11:25:21');

-- --------------------------------------------------------

--
-- Struktur dari tabel `log_status_dokumen`
--

CREATE TABLE `log_status_dokumen` (
  `id_log_status_dokumen` bigint(20) UNSIGNED NOT NULL,
  `nomor_dokumen` bigint(20) UNSIGNED NOT NULL,
  `verifikasi_arsip` enum('Verifikasi','Disetujui','Direvisi') NOT NULL,
  `catatan` text DEFAULT NULL,
  `diproses_oleh` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `log_status_dokumen`
--

INSERT INTO `log_status_dokumen` (`id_log_status_dokumen`, `nomor_dokumen`, `verifikasi_arsip`, `catatan`, `diproses_oleh`, `created_at`, `updated_at`) VALUES
(5, 1, 'Disetujui', NULL, 1, '2025-06-03 04:13:20', '2025-06-03 04:13:20'),
(6, 46, 'Disetujui', NULL, 1, '2025-06-03 06:30:39', '2025-06-03 06:30:39'),
(7, 37, 'Disetujui', NULL, 1, '2025-06-03 06:30:55', '2025-06-03 06:30:55'),
(8, 32, 'Disetujui', NULL, 1, '2025-06-03 06:31:07', '2025-06-03 06:31:07'),
(9, 42, 'Disetujui', NULL, 1, '2025-06-03 06:32:23', '2025-06-03 06:32:23'),
(10, 41, 'Disetujui', NULL, 1, '2025-06-03 06:32:34', '2025-06-03 06:32:34'),
(11, 33, 'Disetujui', NULL, 1, '2025-06-03 06:32:45', '2025-06-03 06:32:45'),
(12, 40, 'Disetujui', NULL, 1, '2025-06-03 06:33:01', '2025-06-03 06:33:01'),
(13, 36, 'Direvisi', 'Revisi isi laporan di bagian Tim Kerja Kelembagaan', 1, '2025-06-03 06:33:52', '2025-06-03 06:33:52'),
(14, 31, 'Disetujui', NULL, 1, '2025-06-03 06:34:12', '2025-06-03 06:34:12'),
(15, 38, 'Direvisi', 'Berikan juga bukti nota, tolong di fotokan dan sertakan dalam laporannya', 1, '2025-06-03 06:34:52', '2025-06-03 06:34:52'),
(16, 30, 'Disetujui', NULL, 1, '2025-06-03 06:35:06', '2025-06-03 06:35:06'),
(17, 29, 'Disetujui', NULL, 1, '2025-06-03 07:40:12', '2025-06-03 07:40:12'),
(18, 43, 'Disetujui', NULL, 1, '2025-06-03 07:40:35', '2025-06-03 07:40:35'),
(19, 45, 'Disetujui', NULL, 1, '2025-06-03 07:40:58', '2025-06-03 07:40:58'),
(20, 44, 'Disetujui', NULL, 1, '2025-06-03 07:41:15', '2025-06-03 07:41:15'),
(21, 39, 'Disetujui', NULL, 1, '2025-06-03 07:41:31', '2025-06-03 07:41:31'),
(22, 35, 'Disetujui', NULL, 1, '2025-06-03 07:42:01', '2025-06-03 07:42:01'),
(23, 34, 'Direvisi', 'Tolong di revisi tanggalnya', 1, '2025-06-05 06:22:54', '2025-06-05 06:22:54'),
(24, 47, 'Disetujui', NULL, 1, '2025-06-11 13:21:29', '2025-06-11 13:21:29'),
(25, 48, 'Disetujui', NULL, 1, '2025-06-11 13:47:28', '2025-06-11 13:47:28'),
(26, 49, 'Disetujui', NULL, 1, '2025-06-14 21:42:06', '2025-06-14 21:42:06'),
(27, 50, 'Disetujui', NULL, 1, '2025-06-16 11:34:37', '2025-06-16 11:34:37'),
(28, 50, 'Disetujui', NULL, 1, '2025-06-16 11:58:16', '2025-06-16 11:58:16'),
(29, 50, 'Direvisi', 'Terdapat kesalahan dalam penulisan nama dokumen', 1, '2025-06-18 20:05:31', '2025-06-18 20:05:31'),
(30, 54, 'Disetujui', NULL, 1, '2025-06-23 11:00:59', '2025-06-23 11:00:59'),
(31, 51, 'Disetujui', NULL, 1, '2025-06-23 11:25:21', '2025-06-23 11:25:21');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_08_08_094526_create_profil_table', 1),
(5, '2024_08_08_094550_create_jenis_table', 1),
(6, '2024_08_08_094601_create_arsip_table', 1),
(7, '2025_03_19_194006_add_baru_to_arsip', 2),
(8, '2025_03_19_194601_add_baru_to_jenis', 3),
(9, '2025_03_19_194810_create_persetujuan_table', 4),
(10, '2025_04_14_155519_create_roles_table', 5),
(11, '2025_04_14_160438_create_role_table', 6),
(12, '2025_04_14_162707_create_role_table', 7),
(13, '2025_04_14_174530_create_user_table', 8),
(14, '2025_04_15_142210_update_role_column_in_users_table', 9),
(15, '2025_04_24_140129_create_klasifikasi_table', 10),
(16, '2025_05_01_091012_create_dasar_hukum_table', 11),
(17, '2025_04_29_192621_create_panduan_penggunaan_table', 12),
(18, '2025_05_07_164335_create_arsip_table', 13),
(19, '2025_05_07_165222_create_arsip_table', 14),
(20, '2025_05_07_173852_create_arsip_table', 15),
(21, '2025_05_08_141009_update_arsip_table', 16),
(22, '2025_05_08_142926_create_log_status_arsip', 17),
(23, '2025_05_08_194319_create_log_status_arsip', 18),
(24, '2025_05_16_131436_create_log_aktivitas__table', 19),
(25, '2025_05_16_132503_create_log_aktivitas_table', 20),
(26, '2025_05_30_051500_add_surat_berita_path_to_arsip_table', 21),
(27, '2025_05_31_171843_add_foto_to_users_table', 22),
(28, '2025_05_31_172052_add_foto_to_users_table', 23),
(29, '2025_05_31_201511_create_log_status_dokumen_table', 24),
(30, '2025_06_02_065506_create_profil_table', 25),
(31, '2025_06_04_200849_add_tanggal_musnahkan_to_arsip_table', 26);

-- --------------------------------------------------------

--
-- Struktur dari tabel `panduan_penggunaan`
--

CREATE TABLE `panduan_penggunaan` (
  `id_panduan` bigint(20) UNSIGNED NOT NULL,
  `nama_dokumen` varchar(255) NOT NULL,
  `dokumen_panduan` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `panduan_penggunaan`
--

INSERT INTO `panduan_penggunaan` (`id_panduan`, `nama_dokumen`, `dokumen_panduan`, `created_at`, `updated_at`) VALUES
(3, 'Buku Sinde 2023', '\"[\\\"1748266853_gmeet pa hedi 23 mei_250523_194455.pdf\\\",\\\"1747895234_usul-biro-luar (1).pdf\\\"]\"', '2025-05-22 06:27:14', '2025-05-26 13:41:01'),
(4, 'Peraturan Baru 1', '[\"1750254997_162021041_Tugas7.pdf\"]', '2025-06-18 20:56:37', '2025-06-18 20:57:30');

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `profil`
--

CREATE TABLE `profil` (
  `id_profil` int(10) UNSIGNED NOT NULL,
  `nama_aplikasi` varchar(255) NOT NULL,
  `kepanjangan_aplikasi` varchar(255) NOT NULL,
  `nama_copyright` varchar(255) NOT NULL,
  `logo_kerjasama` varchar(255) NOT NULL,
  `logo_instansi` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `profil`
--

INSERT INTO `profil` (`id_profil`, `nama_aplikasi`, `kepanjangan_aplikasi`, `nama_copyright`, `logo_kerjasama`, `logo_instansi`, `created_at`, `updated_at`) VALUES
(1, 'SIPADI', 'Sistem Informasi Pengelolaan Arsip Digital', 'IT Support By', 'w9Z6jn894S925E0vl0frThM8nP9OT3XW9cor9Zlk.jpg', '8btbhK4JhMaWoeoW9PNzOdLbWijD1ZEJugJM18VK.png', '0000-00-00 00:00:00', '2025-06-14 22:45:57');

-- --------------------------------------------------------

--
-- Struktur dari tabel `role`
--

CREATE TABLE `role` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `role`
--

INSERT INTO `role` (`id`, `nama`, `created_at`, `updated_at`) VALUES
(1, 'Arsiparis', '2025-04-14 09:50:11', '2025-06-18 14:09:22'),
(2, 'Kepala Bagian Umum', '2025-04-14 09:51:10', '2025-04-14 09:51:10'),
(3, 'Kepala LLDIKTI IV', '2025-04-14 09:51:28', '2025-04-14 09:51:28'),
(4, 'Operator', '2025-04-14 09:51:56', '2025-04-14 09:51:56');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('1atBXGWgUC4vWvuPCPcJqIOmYebr0AFQ9yzaaL3z', NULL, '192.168.0.32', 'WhatsApp/2.2527.2 W', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSlRyc3oxVExjUTBkQUNHUHdZVXJEVVZNSjNaWFc1SDhNRkU2c1lnYyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9hcnNpcC5sbGRpa3RpNC5pZC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1752545044),
('45Ahxut3ffnK6SO5bsQDvTJZPa7ok0KTIb1Td8Sf', NULL, '192.168.0.32', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVmdqZmxDU040bkdsRXBrV0R5WnRaWDhwYjZvUWlaQWhqNENHS2pNZSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9hcnNpcC5sbGRpa3RpNC5pZC9sb2dpbiI7fX0=', 1752551055),
('5OPzRB3iCqQ5Lw7MFWsWEPlYl9oXrS0P63r1FjZd', 4, '192.168.0.32', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTFhWb3ZDWUJRc0tlbDZTWXJmQ3pOUk83Z2Qxa2ozT21FQXY1U0lUNiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9hcnNpcC5sbGRpa3RpNC5pZC9hcnNpcCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjQ7fQ==', 1752544037),
('arfydSSr07AUZ4pAI81YQvIkrV5cvXSg2V8RokOJ', 4, '192.168.0.32', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiakhqV3hLN3MwT3pYeml4RmY1WXhvckJKaFpnZFBJckZkZkRYdHFFRCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly9hcnNpcC5sbGRpa3RpNC5pZC9hcnNpcC90YW1iYWgiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo0O30=', 1752549034),
('JBOW6Xgg8YT78OMRVnLqoIEDbjmnzhzbzzoRh7rB', NULL, '192.168.0.32', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVHdxd3VOMVNBOUJPeWJTb3FKN1l6ckg4R2xwNmt6dVlGWlljOXBhciI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9hcnNpcC5sbGRpa3RpNC5pZC9sb2dpbiI7fX0=', 1752546241),
('ndQfRJtlKH8oPceW9KLbUmfs5qUbOjdbVnJVnbHb', 2, '192.168.0.32', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUUJVR3ZvRkhNNkNNUzVZN1o4SHhKbWxPQTFXRGFYZG1hRzA4SDhQRCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjk6Imh0dHA6Ly9hcnNpcC5sbGRpa3RpNC5pZC91c2VyIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjt9', 1752551385),
('WrNu7HVTWI1AOokyhbOoR2ZRx59sVdELO0d06xGb', 1, '192.168.0.32', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36 Edg/138.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiWjJnVXFuYTNnZ3lYU2lqbG5Yclp1bno1czdaaUdncWJIUldsUUJEUSI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjM1OiJodHRwOi8vYXJzaXAubGxkaWt0aTQuaWQva2FkYWx1YXJzYSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1752546362),
('wY6oSkp5xjcx0O0mG4GXoTalEQi6ujbtONeJbZvj', 2, '192.168.0.32', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUGF3REZMMnlwWEhtNmg5VlZJODVMYUFEeEVSRElObTBlS1E1TVZXeSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly9hcnNpcC5sbGRpa3RpNC5pZC91c2VyL3RhbWJhaCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1752550364);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_user` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` bigint(20) UNSIGNED NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `nama_user`, `username`, `password`, `role`, `foto`, `created_at`, `updated_at`) VALUES
(1, 'Arsiparis', 'arsiparis', '$2y$12$BgiiH0NQWG63amfgLE2TEeJTwsAYXXnZMKp5m/EjU5hp0TDbFSeNW', 1, 'foto_user/iqiCzv7lr5hTuG6q3xbuN23OftjPoTr2R9VMLzhh.jpg', '2025-05-22 07:12:43', '2025-05-31 11:44:40'),
(2, 'Kepala Bagian Umum', 'kabag', '$2y$12$iBCatjNk0wDjp7tihgCxT.MtZTcW0VhyQhUolG/1JtBwpk4RDAl4e', 2, 'foto_user/lHBZREUYTFEdf4b9zmbbwzooV4Fd22p015M9LRmv.jpg', '2025-04-14 17:00:00', '2025-06-14 22:48:39'),
(3, 'Kepala LLDIKTI IV', 'kepalal4', '$2y$12$7WkQIYyoFLmhvZNqlr5NnuE1ZUkRV9J3jEOxwt7fg2skVqQR9nVg.', 3, 'foto_user/JUa5s6N6c6VRkfYBnBJ8vsmoPc7hjxdOEMBWBvs0.jpg', '2025-03-03 09:41:30', '2025-06-17 20:30:08'),
(4, 'Tahura', 'tahura', '$2y$12$BgiiH0NQWG63amfgLE2TEeJTwsAYXXnZMKp5m/EjU5hp0TDbFSeNW', 4, 'foto_user/sQ9oGyjn5xQsF57BVxLhyoLY54XtWVHEIeRD8S8M.jpg', '2025-03-03 09:41:30', '2025-05-31 11:45:12'),
(5, 'HKT', 'hkt', '$2y$12$Z9fWWnspbUlD/unb6LBDKeMmV2aFC/yajNgwzAxyaa9enZmaAl/ca', 4, 'foto_user/DSZjcduCZznJt7lI6glKi7ftQO6mq9B7iXZbOrcN.jpg', '2025-05-22 06:00:41', '2025-07-15 10:27:10'),
(12, 'Humas', 'humas', '$2y$12$BgiiH0NQWG63amfgLE2TEeJTwsAYXXnZMKp5m/EjU5hp0TDbFSeNW', 4, NULL, '2025-06-05 06:34:39', '2025-06-05 06:34:39'),
(13, 'Pkbmn', 'pkbmn', '$2y$12$b27fH6bEQQDnHrED0Ru2wOsXqqqakMaQ6mHaIfKnntvIbm61srqdm', 4, 'foto_user/N6cP5DkG2Dr5MsxA4oxfMNUIhXqZctoARRrBq20t.jpg', '2025-06-11 14:11:12', '2025-07-15 10:28:38'),
(17, 'P3K', 'P3K', '$2y$12$kK.1gCWnbpjl6lXCm7dh9OgM7j6NKYySN.lBL2WW14dxMkvnfKs/C', 4, NULL, '2025-07-15 10:29:25', '2025-07-15 10:29:25'),
(18, 'Pemutu', 'Pemutu', '$2y$12$3d263itQHgZxHq.NT1eNGOpaeul/gajr49uKS7AVUgl.ewyRRtRxe', 4, NULL, '2025-07-15 10:30:10', '2025-07-15 10:30:10'),
(19, 'KLSP', 'klsp', '$2y$12$plMNgs3N5QBXyfGtCiYxFuX2MxanNTxYPkx8180RCbRTDVqJaf83G', 4, NULL, '2025-07-15 10:32:01', '2025-07-15 10:32:01'),
(20, 'DIPP', 'dipp', '$2y$12$nRlEvwQxSNIXurgd4cCk1OqfJaArn/H4Sb1MW57gSxbUvfJlWmDEu', 4, NULL, '2025-07-15 10:32:40', '2025-07-15 10:32:40'),
(21, 'Sumber Daya', 'sumberdaya', '$2y$12$dvOO0pcm4r5nLsYlZrzDjOWEA07g43Z5RTeUXzGT8GhRatSKdHvoW', 4, NULL, '2025-07-15 10:33:24', '2025-07-15 10:33:24');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `arsip`
--
ALTER TABLE `arsip`
  ADD UNIQUE KEY `arsip_nomor_dokumen_unique` (`nomor_dokumen`),
  ADD UNIQUE KEY `arsip_kode_dokumen_unique` (`kode_dokumen`),
  ADD KEY `arsip_dasar_hukum_foreign` (`dasar_hukum`),
  ADD KEY `arsip_klasifikasi_foreign` (`klasifikasi`),
  ADD KEY `arsip_dibuat_oleh_foreign` (`dibuat_oleh`),
  ADD KEY `arsip_disetujui_oleh_foreign` (`disetujui_oleh`);

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `dasar_hukum`
--
ALTER TABLE `dasar_hukum`
  ADD PRIMARY KEY (`id_dasar_hukum`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `jenis`
--
ALTER TABLE `jenis`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `klasifikasi`
--
ALTER TABLE `klasifikasi`
  ADD PRIMARY KEY (`id_klasifikasi`);

--
-- Indeks untuk tabel `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  ADD PRIMARY KEY (`id_log_aktivitas`),
  ADD KEY `log_aktivitas_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `log_status_dokumen`
--
ALTER TABLE `log_status_dokumen`
  ADD PRIMARY KEY (`id_log_status_dokumen`),
  ADD KEY `log_status_dokumen_diproses_oleh_foreign` (`diproses_oleh`),
  ADD KEY `log_status_dokumen_nomor_dokumen_foreign` (`nomor_dokumen`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `panduan_penggunaan`
--
ALTER TABLE `panduan_penggunaan`
  ADD PRIMARY KEY (`id_panduan`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD KEY `users_role_foreign` (`role`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `arsip`
--
ALTER TABLE `arsip`
  MODIFY `nomor_dokumen` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT untuk tabel `dasar_hukum`
--
ALTER TABLE `dasar_hukum`
  MODIFY `id_dasar_hukum` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jenis`
--
ALTER TABLE `jenis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `klasifikasi`
--
ALTER TABLE `klasifikasi`
  MODIFY `id_klasifikasi` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  MODIFY `id_log_aktivitas` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT untuk tabel `log_status_dokumen`
--
ALTER TABLE `log_status_dokumen`
  MODIFY `id_log_status_dokumen` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT untuk tabel `panduan_penggunaan`
--
ALTER TABLE `panduan_penggunaan`
  MODIFY `id_panduan` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `role`
--
ALTER TABLE `role`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `arsip`
--
ALTER TABLE `arsip`
  ADD CONSTRAINT `arsip_dasar_hukum_foreign` FOREIGN KEY (`dasar_hukum`) REFERENCES `dasar_hukum` (`id_dasar_hukum`),
  ADD CONSTRAINT `arsip_dibuat_oleh_foreign` FOREIGN KEY (`dibuat_oleh`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `arsip_disetujui_oleh_foreign` FOREIGN KEY (`disetujui_oleh`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `arsip_klasifikasi_foreign` FOREIGN KEY (`klasifikasi`) REFERENCES `klasifikasi` (`id_klasifikasi`);

--
-- Ketidakleluasaan untuk tabel `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  ADD CONSTRAINT `log_aktivitas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `log_status_dokumen`
--
ALTER TABLE `log_status_dokumen`
  ADD CONSTRAINT `log_status_dokumen_diproses_oleh_foreign` FOREIGN KEY (`diproses_oleh`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `log_status_dokumen_nomor_dokumen_foreign` FOREIGN KEY (`nomor_dokumen`) REFERENCES `arsip` (`nomor_dokumen`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_foreign` FOREIGN KEY (`role`) REFERENCES `role` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
