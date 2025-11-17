/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

DROP TABLE IF EXISTS `blood_requests`;
CREATE TABLE `blood_requests` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `veterinarian_id` bigint(20) unsigned NOT NULL,
  `patient_name` varchar(255) NOT NULL,
  `patient_breed` varchar(255) NOT NULL,
  `patient_weight` decimal(5,2) NOT NULL,
  `blood_type_needed` enum('DEA 1.1+','DEA 1.1-','Universal') NOT NULL,
  `urgency_level` enum('baja','media','alta','critica') NOT NULL,
  `medical_reason` text NOT NULL,
  `clinic_contact` varchar(255) NOT NULL,
  `needed_by_date` datetime NOT NULL,
  `status` enum('active','fulfilled','expired','cancelled') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `blood_requests_veterinarian_id_foreign` (`veterinarian_id`),
  CONSTRAINT `blood_requests_veterinarian_id_foreign` FOREIGN KEY (`veterinarian_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `donation_responses`;
CREATE TABLE `donation_responses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `blood_request_id` bigint(20) unsigned NOT NULL,
  `pet_id` bigint(20) unsigned NOT NULL,
  `tutor_id` bigint(20) unsigned NOT NULL,
  `response` enum('interested','not_available','completed') NOT NULL,
  `notes` text DEFAULT NULL,
  `responded_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `donation_responses_blood_request_id_foreign` (`blood_request_id`),
  KEY `donation_responses_pet_id_foreign` (`pet_id`),
  KEY `donation_responses_tutor_id_foreign` (`tutor_id`),
  CONSTRAINT `donation_responses_blood_request_id_foreign` FOREIGN KEY (`blood_request_id`) REFERENCES `blood_requests` (`id`) ON DELETE CASCADE,
  CONSTRAINT `donation_responses_pet_id_foreign` FOREIGN KEY (`pet_id`) REFERENCES `pets` (`id`),
  CONSTRAINT `donation_responses_tutor_id_foreign` FOREIGN KEY (`tutor_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `job_batches`;
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
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `pet_health_conditions`;
CREATE TABLE `pet_health_conditions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pet_id` bigint(20) unsigned NOT NULL,
  `has_diagnosed_disease` tinyint(1) NOT NULL DEFAULT 0,
  `under_medical_treatment` tinyint(1) NOT NULL DEFAULT 0,
  `recent_surgery` tinyint(1) NOT NULL DEFAULT 0,
  `diseases` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`diseases`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pet_health_conditions_pet_id_foreign` (`pet_id`),
  CONSTRAINT `pet_health_conditions_pet_id_foreign` FOREIGN KEY (`pet_id`) REFERENCES `pets` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `pets`;
CREATE TABLE `pets` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tutor_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `breed` varchar(255) NOT NULL,
  `species` enum('perro','gato') NOT NULL,
  `age_years` int(11) NOT NULL,
  `weight_kg` decimal(5,2) NOT NULL,
  `health_status` enum('excelente','bueno','regular','malo') NOT NULL,
  `vaccines_up_to_date` tinyint(1) NOT NULL,
  `has_donated_before` tinyint(1) NOT NULL DEFAULT 0,
  `photo_path` varchar(255) NOT NULL,
  `donor_status` enum('pending','approved','rejected','inactive') NOT NULL DEFAULT 'pending',
  `rejection_reason` text DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pets_tutor_id_foreign` (`tutor_id`),
  CONSTRAINT `pets_tutor_id_foreign` FOREIGN KEY (`tutor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `document_id` varchar(255) NOT NULL,
  `role` enum('super_admin','veterinarian','tutor') NOT NULL,
  `status` enum('pending','approved','rejected','suspended') NOT NULL DEFAULT 'pending',
  `approved_at` timestamp NULL DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `approved_by` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_document_id_unique` (`document_id`),
  KEY `users_approved_by_foreign` (`approved_by`),
  CONSTRAINT `users_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `veterinarians`;
CREATE TABLE `veterinarians` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `professional_card` varchar(255) NOT NULL,
  `specialty` varchar(255) DEFAULT NULL,
  `clinic_name` varchar(255) NOT NULL,
  `clinic_address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `rejection_reason` text DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `approved_by` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `veterinarians_professional_card_unique` (`professional_card`),
  KEY `veterinarians_user_id_foreign` (`user_id`),
  KEY `veterinarians_approved_by_foreign` (`approved_by`),
  CONSTRAINT `veterinarians_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`),
  CONSTRAINT `veterinarians_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;








INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_08_10_203737_create_pets_table', 1),
(5, '2025_08_11_203735_modify_users_table', 1),
(6, '2025_08_11_203736_create_veterinarians_table', 1),
(7, '2025_08_11_203737_create_pet_health_conditions_table', 1),
(8, '2025_08_11_203738_create_blood_requests_table', 1),
(9, '2025_08_11_203738_create_donation_responses_table', 1);

INSERT INTO `pet_health_conditions` (`id`, `pet_id`, `has_diagnosed_disease`, `under_medical_treatment`, `recent_surgery`, `diseases`, `created_at`, `updated_at`) VALUES
(1, 1, 0, 0, 0, NULL, '2025-08-11 20:50:31', '2025-08-11 20:50:31'),
(2, 2, 0, 0, 0, NULL, '2025-08-11 20:50:31', '2025-08-11 20:50:31'),
(3, 3, 0, 0, 0, NULL, '2025-08-11 20:50:31', '2025-08-11 20:50:31');
INSERT INTO `pets` (`id`, `tutor_id`, `name`, `breed`, `species`, `age_years`, `weight_kg`, `health_status`, `vaccines_up_to_date`, `has_donated_before`, `photo_path`, `donor_status`, `rejection_reason`, `approved_at`, `created_at`, `updated_at`) VALUES
(1, 4, 'Max', 'Golden Retriever', 'perro', 3, '30.50', 'excelente', 1, 0, 'pet_photos/default.jpg', 'approved', NULL, '2025-08-11 20:50:31', '2025-08-11 20:50:31', '2025-08-11 20:50:31'),
(2, 5, 'Luna', 'Labrador', 'perro', 2, '28.00', 'excelente', 1, 1, 'pet_photos/default.jpg', 'approved', NULL, '2025-08-11 20:50:31', '2025-08-11 20:50:31', '2025-08-11 20:50:31'),
(3, 6, 'Rocky', 'Pastor Alemán', 'perro', 4, '35.00', 'bueno', 1, 0, 'pet_photos/default.jpg', 'approved', NULL, '2025-08-11 20:50:31', '2025-08-11 20:50:31', '2025-08-11 20:50:31');
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('KSrb6IkLGseWlOls0vEKo8CwgLcMsJL0OX3kYO13', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36 Edg/139.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZ1lTNHB6cEE5OG9udHFHRFkwOTdaZEk4Z1VMTjlOTmY5bUlpTGZPaCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9kYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1754947811),
('YVtKbcoJJYp5D3OWWFX6cFVVwOWgzZBAYWC6z8CB', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36 Edg/139.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRU1xcHFTWnlQTHVjWjRCd2dyVm04eWtUS01LaEtQRktTbHdqcHE3YiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9kYXNoYm9hcmQiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1754947968);
INSERT INTO `users` (`id`, `name`, `email`, `phone`, `document_id`, `role`, `status`, `approved_at`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `approved_by`) VALUES
(1, 'Super Administrador', 'admin@bancocanino.com', '+57 300 123 4567', '12345678', 'super_admin', 'approved', '2025-08-11 20:50:30', '2025-08-11 20:50:30', '$2y$12$6SRfZl6NzuTOtP4xZTly1evMHI3gKQonHnTCmf/gq7IHm7tN0yNMi', NULL, '2025-08-11 20:50:30', '2025-08-11 20:50:30', NULL),
(2, 'Dr. Carlos Veterinario', 'carlos@veterinaria.com', '+57 301 123 4567', '87654321', 'veterinarian', 'approved', '2025-08-11 20:50:31', '2025-08-11 20:50:31', '$2y$12$AlzV3OPQ1/oZardc4qhc6.61.y524tLwy6Q2OCRXjFNHeKsxK88rO', NULL, '2025-08-11 20:50:31', '2025-08-11 20:50:31', 1),
(3, 'Dra. Ana Rodríguez', 'ana@clinicapet.com', '+57 302 123 4567', '11223344', 'veterinarian', 'approved', '2025-08-11 21:24:16', '2025-08-11 20:50:31', '$2y$12$3Z.EHAf..xBSfkDFt3lZFOgCLjGjdF.kpw2ZQllYhdbC2ycfwZ0I6', NULL, '2025-08-11 20:50:31', '2025-08-11 21:24:16', 1),
(4, 'María García', 'maria@gmail.com', '+57 310 123 4567', '55667788', 'tutor', 'approved', NULL, '2025-08-11 20:50:31', '$2y$12$ATbS0fS20LFWF3X9I5ncEeevD9sJxcark2Xy11gzDDCzm3lCgq2PC', NULL, '2025-08-11 20:50:31', '2025-08-11 20:50:31', NULL),
(5, 'Juan Pérez', 'juan@hotmail.com', '+57 311 123 4567', '99887766', 'tutor', 'approved', NULL, '2025-08-11 20:50:31', '$2y$12$iCH4KnuQYmL3TnFTBZ.uLOcjYeNtb/P/8EzbMZ96xAkJ6b5O2YQ5K', NULL, '2025-08-11 20:50:31', '2025-08-11 20:50:31', NULL),
(6, 'Sofia Martínez', 'sofia@yahoo.com', '+57 312 123 4567', '44556677', 'tutor', 'approved', NULL, '2025-08-11 20:50:31', '$2y$12$yQLMjLPOfWMW7XJX3fEyduTIdsq7yBgdHpmtwJfvDJyOlqOmSIvpO', NULL, '2025-08-11 20:50:31', '2025-08-11 20:50:31', NULL),
(7, 'Duberney', 'duver20ac@gmail.com', '3007689242', '1005154734', 'veterinarian', 'approved', '2025-08-11 21:25:38', NULL, '$2y$12$XiVW6KqmioTRfgVr/Fh1PumET4ydbmKsEnAcD.khPG3sL3ymAdxxC', NULL, '2025-08-11 21:25:20', '2025-08-11 21:25:38', 1);
INSERT INTO `veterinarians` (`id`, `user_id`, `professional_card`, `specialty`, `clinic_name`, `clinic_address`, `city`, `rejection_reason`, `approved_at`, `approved_by`, `created_at`, `updated_at`) VALUES
(1, 2, 'VET-001-2024', 'Medicina Interna', 'Clínica Veterinaria San José', 'Calle 100 #15-30', 'Bogotá', NULL, '2025-08-11 20:50:31', 1, '2025-08-11 20:50:31', '2025-08-11 20:50:31'),
(2, 3, 'VET-002-2024', 'Cirugía', 'Clínica Pet Care', 'Carrera 50 #25-80', 'Medellín', NULL, '2025-08-11 21:24:16', 1, '2025-08-11 20:50:31', '2025-08-11 21:24:16'),
(3, 7, '3999994', 'Medico', 'Pet Friendli', 'Cr 18', 'Bucaramanga', NULL, '2025-08-11 21:25:38', 1, '2025-08-11 21:25:20', '2025-08-11 21:25:38');


/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;