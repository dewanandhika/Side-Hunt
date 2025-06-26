-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 26 Jun 2025 pada 21.13
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sh_new`
--

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
(1, '2019_08_19_000000_create_failed_jobs_table', 1),
(2, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(3, '2024_11_01_000001_create_wirechat_conversations_table', 1),
(4, '2024_11_01_000002_create_wirechat_attachments_table', 1),
(5, '2024_11_01_000003_create_wirechat_messages_table', 1),
(6, '2024_11_01_000004_create_wirechat_participants_table', 1),
(7, '2024_11_01_000006_create_wirechat_actions_table', 1),
(8, '2024_11_01_000007_create_wirechat_groups_table', 1),
(9, '2025_05_23_185933_create_users_table', 1),
(10, '2025_05_24_222852_create_pekerjaans_table', 1),
(11, '2025_06_14_152023_create_pelamars_table', 1),
(12, '2025_06_15_030711_create_transaksis_table', 1),
(13, '2025_06_15_031346_create_payments_table', 1);

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
-- Struktur dari tabel `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `checkout_link` varchar(255) NOT NULL,
  `external_id` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `method` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pekerjaans`
--

CREATE TABLE `pekerjaans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `deskripsi` longtext NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `koordinat` varchar(255) NOT NULL,
  `min_gaji` int(11) NOT NULL,
  `max_gaji` int(11) NOT NULL,
  `max_pekerja` int(11) NOT NULL DEFAULT 0,
  `jumlah_pelamar_diterima` int(11) NOT NULL DEFAULT 0,
  `is_active` int(11) NOT NULL DEFAULT 1,
  `kriteria` text NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Open',
  `petunjuk_alamat` varchar(255) NOT NULL,
  `latitude` varchar(255) NOT NULL,
  `longitude` varchar(255) NOT NULL,
  `start_job` datetime NOT NULL,
  `end_job` datetime NOT NULL,
  `deadline_job` datetime DEFAULT NULL,
  `foto_job` varchar(255) DEFAULT NULL,
  `pembuat` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelamars`
--

CREATE TABLE `pelamars` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `job_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('tunda','diterima','ditolak','selesai') NOT NULL DEFAULT 'tunda',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksis`
--

CREATE TABLE `transaksis` (
  `kode` char(36) NOT NULL,
  `pembuat_id` bigint(20) UNSIGNED NOT NULL,
  `pekerja_id` bigint(20) UNSIGNED NOT NULL,
  `jumlah` int(11) NOT NULL,
  `status` enum('tertunda','sukses','gagal') NOT NULL DEFAULT 'tertunda',
  `dibuat` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `role` enum('user','mitra','admin') NOT NULL,
  `telpon` varchar(255) DEFAULT NULL,
  `dompet` int(11) NOT NULL DEFAULT 0,
  `isAdmin` tinyint(1) NOT NULL DEFAULT 0,
  `VerificationCode` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `preferensi_user` longtext DEFAULT NULL,
  `avatar_url` varchar(255) DEFAULT NULL,
  `dark_mode` tinyint(1) NOT NULL DEFAULT 0,
  `messenger_color` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `wire_actions`
--

CREATE TABLE `wire_actions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `actionable_id` bigint(20) UNSIGNED NOT NULL,
  `actionable_type` varchar(255) NOT NULL,
  `actor_id` bigint(20) UNSIGNED NOT NULL,
  `actor_type` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `data` varchar(255) DEFAULT NULL COMMENT 'Some additional information about the action',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `wire_attachments`
--

CREATE TABLE `wire_attachments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `attachable_type` varchar(255) NOT NULL,
  `attachable_id` bigint(20) UNSIGNED NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `original_name` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `mime_type` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `wire_conversations`
--

CREATE TABLE `wire_conversations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL COMMENT 'Private is 1-1 , group or channel',
  `disappearing_started_at` timestamp NULL DEFAULT NULL,
  `disappearing_duration` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `wire_groups`
--

CREATE TABLE `wire_groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `conversation_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `avatar_url` varchar(255) DEFAULT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'private',
  `allow_members_to_send_messages` tinyint(1) NOT NULL DEFAULT 1,
  `allow_members_to_add_others` tinyint(1) NOT NULL DEFAULT 1,
  `allow_members_to_edit_group_info` tinyint(1) NOT NULL DEFAULT 0,
  `admins_must_approve_new_members` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'when turned on, admins must approve anyone who wants to join group',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `wire_messages`
--

CREATE TABLE `wire_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `conversation_id` bigint(20) UNSIGNED NOT NULL,
  `sendable_id` bigint(20) UNSIGNED NOT NULL,
  `sendable_type` varchar(255) NOT NULL,
  `reply_id` bigint(20) UNSIGNED DEFAULT NULL,
  `body` text DEFAULT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'text',
  `kept_at` timestamp NULL DEFAULT NULL COMMENT 'filled when a message is kept from disappearing',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `wire_participants`
--

CREATE TABLE `wire_participants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `conversation_id` bigint(20) UNSIGNED NOT NULL,
  `role` varchar(255) NOT NULL,
  `participantable_id` bigint(20) UNSIGNED NOT NULL,
  `participantable_type` varchar(255) NOT NULL,
  `exited_at` timestamp NULL DEFAULT NULL,
  `last_active_at` timestamp NULL DEFAULT NULL,
  `conversation_cleared_at` timestamp NULL DEFAULT NULL,
  `conversation_deleted_at` timestamp NULL DEFAULT NULL,
  `conversation_read_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_created_at_status_index` (`created_at`,`status`),
  ADD KEY `payments_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `pekerjaans`
--
ALTER TABLE `pekerjaans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pekerjaans_pembuat_foreign` (`pembuat`);

--
-- Indeks untuk tabel `pelamars`
--
ALTER TABLE `pelamars`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pelamars_user_id_foreign` (`user_id`),
  ADD KEY `pelamars_job_id_foreign` (`job_id`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `transaksis`
--
ALTER TABLE `transaksis`
  ADD PRIMARY KEY (`kode`),
  ADD KEY `transaksis_pembuat_id_foreign` (`pembuat_id`),
  ADD KEY `transaksis_pekerja_id_foreign` (`pekerja_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_telpon_unique` (`telpon`);

--
-- Indeks untuk tabel `wire_actions`
--
ALTER TABLE `wire_actions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wire_actions_actionable_id_actionable_type_index` (`actionable_id`,`actionable_type`),
  ADD KEY `wire_actions_actor_id_actor_type_index` (`actor_id`,`actor_type`),
  ADD KEY `wire_actions_type_index` (`type`);

--
-- Indeks untuk tabel `wire_attachments`
--
ALTER TABLE `wire_attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wire_attachments_attachable_type_attachable_id_index` (`attachable_type`,`attachable_id`),
  ADD KEY `wire_attachments_attachable_id_attachable_type_index` (`attachable_id`,`attachable_type`);

--
-- Indeks untuk tabel `wire_conversations`
--
ALTER TABLE `wire_conversations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wire_conversations_type_index` (`type`);

--
-- Indeks untuk tabel `wire_groups`
--
ALTER TABLE `wire_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `wire_messages`
--
ALTER TABLE `wire_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wire_messages_reply_id_foreign` (`reply_id`),
  ADD KEY `wire_messages_conversation_id_index` (`conversation_id`),
  ADD KEY `wire_messages_sendable_id_sendable_type_index` (`sendable_id`,`sendable_type`);

--
-- Indeks untuk tabel `wire_participants`
--
ALTER TABLE `wire_participants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `conv_part_id_type_unique` (`conversation_id`,`participantable_id`,`participantable_type`),
  ADD KEY `wire_participants_role_index` (`role`),
  ADD KEY `wire_participants_exited_at_index` (`exited_at`),
  ADD KEY `wire_participants_conversation_cleared_at_index` (`conversation_cleared_at`),
  ADD KEY `wire_participants_conversation_deleted_at_index` (`conversation_deleted_at`),
  ADD KEY `wire_participants_conversation_read_at_index` (`conversation_read_at`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pekerjaans`
--
ALTER TABLE `pekerjaans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pelamars`
--
ALTER TABLE `pelamars`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `wire_actions`
--
ALTER TABLE `wire_actions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `wire_attachments`
--
ALTER TABLE `wire_attachments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `wire_conversations`
--
ALTER TABLE `wire_conversations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `wire_groups`
--
ALTER TABLE `wire_groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `wire_messages`
--
ALTER TABLE `wire_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `wire_participants`
--
ALTER TABLE `wire_participants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pekerjaans`
--
ALTER TABLE `pekerjaans`
  ADD CONSTRAINT `pekerjaans_pembuat_foreign` FOREIGN KEY (`pembuat`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pelamars`
--
ALTER TABLE `pelamars`
  ADD CONSTRAINT `pelamars_job_id_foreign` FOREIGN KEY (`job_id`) REFERENCES `pekerjaans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pelamars_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `transaksis`
--
ALTER TABLE `transaksis`
  ADD CONSTRAINT `transaksis_pekerja_id_foreign` FOREIGN KEY (`pekerja_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transaksis_pembuat_id_foreign` FOREIGN KEY (`pembuat_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `wire_messages`
--
ALTER TABLE `wire_messages`
  ADD CONSTRAINT `wire_messages_conversation_id_foreign` FOREIGN KEY (`conversation_id`) REFERENCES `wire_conversations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wire_messages_reply_id_foreign` FOREIGN KEY (`reply_id`) REFERENCES `wire_messages` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `wire_participants`
--
ALTER TABLE `wire_participants`
  ADD CONSTRAINT `wire_participants_conversation_id_foreign` FOREIGN KEY (`conversation_id`) REFERENCES `wire_conversations` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
