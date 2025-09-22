/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

DROP TABLE IF EXISTS `blood_request_history`;
CREATE TABLE `blood_request_history` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `blood_request_id` bigint(20) unsigned NOT NULL,
  `previous_status` varchar(50) NOT NULL,
  `new_status` varchar(50) NOT NULL,
  `changed_by` bigint(20) unsigned NOT NULL,
  `change_reason` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `blood_request_history_changed_by_foreign` (`changed_by`),
  KEY `blood_request_history_blood_request_id_created_at_index` (`blood_request_id`,`created_at`),
  CONSTRAINT `blood_request_history_blood_request_id_foreign` FOREIGN KEY (`blood_request_id`) REFERENCES `blood_requests` (`id`) ON DELETE CASCADE,
  CONSTRAINT `blood_request_history_changed_by_foreign` FOREIGN KEY (`changed_by`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `blood_requests`;
CREATE TABLE `blood_requests` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `veterinarian_id` bigint(20) unsigned NOT NULL,
  `patient_name` varchar(255) NOT NULL,
  `patient_species` varchar(50) DEFAULT NULL,
  `patient_age` varchar(20) DEFAULT NULL,
  `patient_breed` varchar(255) NOT NULL,
  `patient_weight` decimal(5,2) NOT NULL,
  `blood_type` varchar(20) DEFAULT NULL,
  `quantity_needed` varchar(100) DEFAULT NULL,
  `blood_type_needed` enum('DEA 1.1+','DEA 1.1-','Universal') NOT NULL,
  `urgency_level` enum('baja','media','alta','critica') NOT NULL,
  `medical_reason` text NOT NULL,
  `additional_notes` text DEFAULT NULL,
  `clinic_contact` varchar(255) NOT NULL,
  `needed_by_date` datetime NOT NULL,
  `status` varchar(50) NOT NULL,
  `admin_notes` text DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by_admin` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `blood_requests_veterinarian_id_foreign` (`veterinarian_id`),
  KEY `blood_requests_updated_by_admin_foreign` (`updated_by_admin`),
  CONSTRAINT `blood_requests_updated_by_admin_foreign` FOREIGN KEY (`updated_by_admin`) REFERENCES `users` (`id`),
  CONSTRAINT `blood_requests_veterinarian_id_foreign` FOREIGN KEY (`veterinarian_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

DROP TABLE IF EXISTS `email_logs`;
CREATE TABLE `email_logs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `to_email` varchar(255) NOT NULL,
  `to_name` varchar(255) DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `mailable_class` varchar(255) NOT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`data`)),
  `status` enum('sent','failed') NOT NULL,
  `error_message` text DEFAULT NULL,
  `sent_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=120 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `pets`;
CREATE TABLE `pets` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tutor_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `breed` varchar(255) NOT NULL,
  `species` enum('perro','gato') NOT NULL,
  `age_years` int(11) NOT NULL,
  `age` int(11) DEFAULT NULL,
  `weight_kg` decimal(5,2) NOT NULL,
  `blood_type` varchar(50) DEFAULT NULL,
  `weight` decimal(8,2) DEFAULT NULL,
  `health_status` enum('excelente','bueno','regular','malo') NOT NULL,
  `vaccines_up_to_date` tinyint(1) NOT NULL,
  `vaccination_status` tinyint(1) DEFAULT NULL,
  `has_donated_before` tinyint(1) NOT NULL DEFAULT 0,
  `photo_path` varchar(255) NOT NULL,
  `donor_status` enum('pending','approved','rejected','inactive') NOT NULL DEFAULT 'pending',
  `status` varchar(50) DEFAULT NULL,
  `rejection_reason` text DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pets_tutor_id_foreign` (`tutor_id`),
  CONSTRAINT `pets_tutor_id_foreign` FOREIGN KEY (`tutor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `password` varchar(255) DEFAULT NULL,
  `can_login` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Indica si el usuario puede iniciar sesión o solo es un contacto',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `approved_by` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_document_id_unique` (`document_id`),
  KEY `users_approved_by_foreign` (`approved_by`),
  CONSTRAINT `users_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `veterinarians`;
CREATE TABLE `veterinarians` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `professional_card` varchar(255) NOT NULL,
  `professional_card_photo` varchar(255) DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `blood_request_history` (`id`, `blood_request_id`, `previous_status`, `new_status`, `changed_by`, `change_reason`, `created_at`, `updated_at`) VALUES
(9, 17, 'active', 'expired', 1, 'Cambio desde panel administrativo', '2025-09-22 04:44:57', '2025-09-22 04:44:57');
INSERT INTO `blood_requests` (`id`, `veterinarian_id`, `patient_name`, `patient_species`, `patient_age`, `patient_breed`, `patient_weight`, `blood_type`, `quantity_needed`, `blood_type_needed`, `urgency_level`, `medical_reason`, `additional_notes`, `clinic_contact`, `needed_by_date`, `status`, `admin_notes`, `completed_at`, `created_at`, `updated_at`, `updated_by_admin`) VALUES
(13, 32, 'Prueba No 1', NULL, NULL, 'Prueba No 1', '2.00', NULL, NULL, 'DEA 1.1-', 'baja', 'Prueba No 1', NULL, 'Prueba No 1', '2025-09-29 04:36:00', 'active', NULL, NULL, '2025-09-22 04:36:32', '2025-09-22 04:36:32', NULL),
(14, 32, 'Prueba No 2', NULL, NULL, 'Prueba No 1', '221.00', NULL, NULL, 'DEA 1.1+', 'baja', 'Prueba No 1', NULL, 'Prueba No 1', '2025-09-29 04:36:00', 'active', NULL, NULL, '2025-09-22 04:36:55', '2025-09-22 04:36:55', NULL),
(15, 32, 'Prueba No 3', NULL, NULL, 'Prueba No 3', '4.00', NULL, NULL, 'DEA 1.1-', 'media', 'Prueba No 3', NULL, 'Prueba No 3', '2025-09-25 04:37:00', 'active', NULL, NULL, '2025-09-22 04:37:28', '2025-09-22 04:37:28', NULL),
(16, 32, 'Prueba No 4', NULL, NULL, 'Prueba No 4', '4.00', NULL, NULL, 'Universal', 'media', 'Prueba No 4', NULL, 'Prueba No 4', '2025-09-25 04:37:00', 'active', NULL, NULL, '2025-09-22 04:37:41', '2025-09-22 04:37:41', NULL),
(17, 32, 'Prueba No 5', NULL, NULL, 'Prueba No 5', '5.00', NULL, NULL, 'DEA 1.1-', 'media', 'Prueba No 5', NULL, 'Prueba No 5', '2025-09-25 04:37:00', 'expired', NULL, NULL, '2025-09-22 04:37:53', '2025-09-22 04:44:57', 1),
(18, 32, 'Prueba No 6', NULL, NULL, 'Prueba No 6', '5.00', NULL, NULL, 'DEA 1.1-', 'media', 'Prueba No 6', NULL, 'Prueba No 6', '2025-09-25 04:42:00', 'cancelled', NULL, NULL, '2025-09-22 04:42:06', '2025-09-22 04:44:48', NULL),
(19, 32, 'Animal No 4', NULL, NULL, 'Animal No 4', '4.00', NULL, NULL, 'DEA 1.1+', 'baja', 'Animal No 4', NULL, 'Animal No 4', '2025-09-29 04:55:00', 'active', NULL, NULL, '2025-09-22 04:55:46', '2025-09-22 04:55:46', NULL);



INSERT INTO `email_logs` (`id`, `to_email`, `to_name`, `subject`, `mailable_class`, `data`, `status`, `error_message`, `sent_at`, `created_at`, `updated_at`) VALUES
(1, 'maria@gmail.com', 'María García', 'Solicitud Urgente de Donación de Sangre para ian', 'BloodDonationRequestMail', '{\"blood_request_id\":2,\"pet_id\":1,\"tutor_id\":4}', 'sent', NULL, '2025-09-21 19:38:38', '2025-09-21 19:38:38', '2025-09-21 19:38:38'),
(2, 'juan@hotmail.com', 'Juan Pérez', 'Solicitud Urgente de Donación de Sangre para ian', 'BloodDonationRequestMail', '{\"blood_request_id\":2,\"pet_id\":2,\"tutor_id\":5}', 'sent', NULL, '2025-09-21 19:38:39', '2025-09-21 19:38:39', '2025-09-21 19:38:39'),
(3, 'sofia@yahoo.com', 'Sofia Martínez', 'Solicitud Urgente de Donación de Sangre para ian', 'BloodDonationRequestMail', '{\"blood_request_id\":2,\"pet_id\":3,\"tutor_id\":6}', 'sent', NULL, '2025-09-21 19:38:40', '2025-09-21 19:38:40', '2025-09-21 19:38:40'),
(4, 'duver20000@gmail.com', 'adfasfdasrewrewrewrew', '¡Bienvenido! asdfas ya es un héroe donante', 'PetApprovedWelcomeMail', '{\"pet_id\":6,\"tutor_id\":12}', 'sent', NULL, '2025-09-21 19:49:32', '2025-09-21 19:49:32', '2025-09-21 19:49:32'),
(5, 'maria@gmail.com', 'María García', 'Solicitud Urgente de Donación de Sangre para tesata', 'BloodDonationRequestMail', '{\"blood_request_id\":3,\"pet_id\":1,\"tutor_id\":4}', 'sent', NULL, '2025-09-21 19:59:08', '2025-09-21 19:59:08', '2025-09-21 19:59:08'),
(6, 'juan@hotmail.com', 'Juan Pérez', 'Solicitud Urgente de Donación de Sangre para tesata', 'BloodDonationRequestMail', '{\"blood_request_id\":3,\"pet_id\":2,\"tutor_id\":5}', 'sent', NULL, '2025-09-21 19:59:09', '2025-09-21 19:59:09', '2025-09-21 19:59:09'),
(7, 'sofia@yahoo.com', 'Sofia Martínez', 'Solicitud Urgente de Donación de Sangre para tesata', 'BloodDonationRequestMail', '{\"blood_request_id\":3,\"pet_id\":3,\"tutor_id\":6}', 'sent', NULL, '2025-09-21 19:59:10', '2025-09-21 19:59:10', '2025-09-21 19:59:10'),
(8, 'duver20000@gmail.com', 'adfasfdasrewrewrewrew', 'Solicitud Urgente de Donación de Sangre para tesata', 'BloodDonationRequestMail', '{\"blood_request_id\":3,\"pet_id\":6,\"tutor_id\":12}', 'sent', NULL, '2025-09-21 19:59:10', '2025-09-21 19:59:10', '2025-09-21 19:59:10'),
(9, 'duver20000@gmail.com', 'DubenreyHernandezCorzo', '¡Bienvenido! pedreo ya es un héroe donante', 'PetApprovedWelcomeMail', '{\"pet_id\":7,\"tutor_id\":13}', 'sent', NULL, '2025-09-21 20:07:29', '2025-09-21 20:07:29', '2025-09-21 20:07:29'),
(10, 'maria@gmail.com', 'María García', 'Solicitud Urgente de Donación de Sangre para Primer Paciendte', 'BloodDonationRequestMail', '{\"blood_request_id\":4,\"pet_id\":1,\"tutor_id\":4}', 'sent', NULL, '2025-09-21 20:57:43', '2025-09-21 20:57:43', '2025-09-21 20:57:43'),
(11, 'juan@hotmail.com', 'Juan Pérez', 'Solicitud Urgente de Donación de Sangre para Primer Paciendte', 'BloodDonationRequestMail', '{\"blood_request_id\":4,\"pet_id\":2,\"tutor_id\":5}', 'sent', NULL, '2025-09-21 20:57:43', '2025-09-21 20:57:43', '2025-09-21 20:57:43'),
(12, 'sofia@yahoo.com', 'Sofia Martínez', 'Solicitud Urgente de Donación de Sangre para Primer Paciendte', 'BloodDonationRequestMail', '{\"blood_request_id\":4,\"pet_id\":3,\"tutor_id\":6}', 'sent', NULL, '2025-09-21 20:57:44', '2025-09-21 20:57:44', '2025-09-21 20:57:44'),
(13, 'duver2000@gmail.com', 'ADF', '¡Bienvenido! adsf ya es un héroe donante', 'PetApprovedWelcomeMail', '{\"pet_id\":8,\"tutor_id\":15}', 'sent', NULL, '2025-09-21 21:04:09', '2025-09-21 21:04:09', '2025-09-21 21:04:09'),
(14, 'duver20000@gmail.com', 'duberneuyPostulandte', '¡Bienvenido! Ian v2 ya es un héroe donante', 'PetApprovedWelcomeMail', '{\"pet_id\":9,\"tutor_id\":16}', 'sent', NULL, '2025-09-21 21:06:19', '2025-09-21 21:06:19', '2025-09-21 21:06:19'),
(15, 'maria@gmail.com', 'María García', 'Solicitud Urgente de Donación de Sangre para Prueba No 1', 'BloodDonationRequestMail', '{\"blood_request_id\":5,\"pet_id\":1,\"tutor_id\":4}', 'sent', NULL, '2025-09-21 21:09:56', '2025-09-21 21:09:56', '2025-09-21 21:09:56'),
(16, 'juan@hotmail.com', 'Juan Pérez', 'Solicitud Urgente de Donación de Sangre para Prueba No 1', 'BloodDonationRequestMail', '{\"blood_request_id\":5,\"pet_id\":2,\"tutor_id\":5}', 'sent', NULL, '2025-09-21 21:09:56', '2025-09-21 21:09:56', '2025-09-21 21:09:56'),
(17, 'sofia@yahoo.com', 'Sofia Martínez', 'Solicitud Urgente de Donación de Sangre para Prueba No 1', 'BloodDonationRequestMail', '{\"blood_request_id\":5,\"pet_id\":3,\"tutor_id\":6}', 'sent', NULL, '2025-09-21 21:09:57', '2025-09-21 21:09:57', '2025-09-21 21:09:57'),
(18, 'duver2000@gmail.com', 'ADF', 'Solicitud Urgente de Donación de Sangre para Prueba No 1', 'BloodDonationRequestMail', '{\"blood_request_id\":5,\"pet_id\":8,\"tutor_id\":15}', 'sent', NULL, '2025-09-21 21:09:57', '2025-09-21 21:09:57', '2025-09-21 21:09:57'),
(19, 'duver20000@gmail.com', 'duberneuyPostulandte', 'Solicitud Urgente de Donación de Sangre para Prueba No 1', 'BloodDonationRequestMail', '{\"blood_request_id\":5,\"pet_id\":9,\"tutor_id\":16}', 'sent', NULL, '2025-09-21 21:09:58', '2025-09-21 21:09:58', '2025-09-21 21:09:58'),
(20, 'maria@gmail.com', 'María García', 'Solicitud Urgente de Donación de Sangre para Purba No 2', 'BloodDonationRequestMail', '{\"blood_request_id\":6,\"pet_id\":1,\"tutor_id\":4}', 'sent', NULL, '2025-09-21 21:10:47', '2025-09-21 21:10:47', '2025-09-21 21:10:47'),
(21, 'juan@hotmail.com', 'Juan Pérez', 'Solicitud Urgente de Donación de Sangre para Purba No 2', 'BloodDonationRequestMail', '{\"blood_request_id\":6,\"pet_id\":2,\"tutor_id\":5}', 'sent', NULL, '2025-09-21 21:10:48', '2025-09-21 21:10:48', '2025-09-21 21:10:48'),
(22, 'sofia@yahoo.com', 'Sofia Martínez', 'Solicitud Urgente de Donación de Sangre para Purba No 2', 'BloodDonationRequestMail', '{\"blood_request_id\":6,\"pet_id\":3,\"tutor_id\":6}', 'sent', NULL, '2025-09-21 21:10:49', '2025-09-21 21:10:49', '2025-09-21 21:10:49'),
(23, 'duver2000@gmail.com', 'ADF', 'Solicitud Urgente de Donación de Sangre para Purba No 2', 'BloodDonationRequestMail', '{\"blood_request_id\":6,\"pet_id\":8,\"tutor_id\":15}', 'sent', NULL, '2025-09-21 21:10:49', '2025-09-21 21:10:49', '2025-09-21 21:10:49'),
(24, 'duver20000@gmail.com', 'duberneuyPostulandte', 'Solicitud Urgente de Donación de Sangre para Purba No 2', 'BloodDonationRequestMail', '{\"blood_request_id\":6,\"pet_id\":9,\"tutor_id\":16}', 'sent', NULL, '2025-09-21 21:10:50', '2025-09-21 21:10:50', '2025-09-21 21:10:50'),
(25, 'duver20000@gmail.cokm', 'SDJASDFJASJ', '¡Bienvenido! fadsfasd ya es un héroe donante', 'PetApprovedWelcomeMail', '{\"pet_id\":10,\"tutor_id\":17}', 'sent', NULL, '2025-09-21 21:12:03', '2025-09-21 21:12:03', '2025-09-21 21:12:03'),
(26, 'duver20000@gmail.com', 'afdas', '¡Bienvenido! ee ya es un héroe donante', 'PetApprovedWelcomeMail', '{\"pet_id\":11,\"tutor_id\":20}', 'sent', NULL, '2025-09-21 21:26:31', '2025-09-21 21:26:31', '2025-09-21 21:26:31'),
(27, 'duver20000@gmail.com', 'Dubnmen', '¡Bienvenido! dfdas ya es un héroe donante', 'PetApprovedWelcomeMail', '{\"pet_id\":12,\"tutor_id\":21}', 'sent', NULL, '2025-09-21 21:27:51', '2025-09-21 21:27:51', '2025-09-21 21:27:51'),
(28, 'duver200000@gmail.com', 'dubetuto', '¡Bienvenido! petfe ya es un héroe donante', 'PetApprovedWelcomeMail', '{\"pet_id\":13,\"tutor_id\":22}', 'sent', NULL, '2025-09-21 22:09:31', '2025-09-21 22:09:31', '2025-09-21 22:09:31'),
(29, 'duver20000@gmail.com', 'asdfja|', '¡Bienvenido! sdafas ya es un héroe donante', 'PetApprovedWelcomeMail', '{\"pet_id\":14,\"tutor_id\":21}', 'sent', NULL, '2025-09-22 00:34:22', '2025-09-22 00:34:22', '2025-09-22 00:34:22'),
(30, 'duver20000@gmail.com', 'Duuuvasdfvasj', '¡Bienvenido! dsfa ya es un héroe donante', 'PetApprovedWelcomeMail', '{\"pet_id\":15,\"tutor_id\":21}', 'sent', NULL, '2025-09-22 00:35:43', '2025-09-22 00:35:43', '2025-09-22 00:35:43'),
(31, 'duver20000@gmail.com', 'asdfasd', '¡Bienvenido! 223432 ya es un héroe donante', 'PetApprovedWelcomeMail', '{\"pet_id\":16,\"tutor_id\":21}', 'sent', NULL, '2025-09-22 00:42:42', '2025-09-22 00:42:42', '2025-09-22 00:42:42'),
(32, 'duver220200a@gmail.com', 'fasdfads', '¡Bienvenido! asdf ya es un héroe donante', 'PetApprovedWelcomeMail', '{\"pet_id\":20,\"tutor_id\":28,\"is_new_user\":true}', 'sent', NULL, '2025-09-22 00:54:33', '2025-09-22 00:54:33', '2025-09-22 00:54:33'),
(33, 'duver20000@gmail.com', 'asdfas', '¡Bienvenido! asdfas ya es un héroe donante', 'PetApprovedWelcomeMail', '{\"pet_id\":22,\"tutor_id\":29,\"is_new_user\":true}', 'sent', NULL, '2025-09-22 01:03:48', '2025-09-22 01:03:48', '2025-09-22 01:03:48'),
(34, 'duver20000@gmail.com', 'asdfas', 'Nueva mascota registrada: apasdfjas', 'NewPetRegisteredMail', '{\"pet_id\":23,\"tutor_id\":29,\"is_new_user\":false}', 'sent', NULL, '2025-09-22 01:06:07', '2025-09-22 01:06:07', '2025-09-22 01:06:07'),
(35, 'maria@gmail.com', 'María García', 'Solicitud Urgente de Donación de Sangre para test', 'BloodDonationRequestMail', '{\"blood_request_id\":7,\"pet_id\":1,\"tutor_id\":4}', 'sent', NULL, '2025-09-22 01:06:56', '2025-09-22 01:06:56', '2025-09-22 01:06:56'),
(36, 'juan@hotmail.com', 'Juan Pérez', 'Solicitud Urgente de Donación de Sangre para test', 'BloodDonationRequestMail', '{\"blood_request_id\":7,\"pet_id\":2,\"tutor_id\":5}', 'sent', NULL, '2025-09-22 01:06:56', '2025-09-22 01:06:56', '2025-09-22 01:06:56'),
(37, 'sofia@yahoo.com', 'Sofia Martínez', 'Solicitud Urgente de Donación de Sangre para test', 'BloodDonationRequestMail', '{\"blood_request_id\":7,\"pet_id\":3,\"tutor_id\":6}', 'sent', NULL, '2025-09-22 01:06:57', '2025-09-22 01:06:57', '2025-09-22 01:06:57'),
(38, 'duver20222000@gmail.com', 'asdfasd', 'Solicitud Urgente de Donación de Sangre para test', 'BloodDonationRequestMail', '{\"blood_request_id\":7,\"pet_id\":12,\"tutor_id\":21}', 'sent', NULL, '2025-09-22 01:06:58', '2025-09-22 01:06:58', '2025-09-22 01:06:58'),
(39, 'duver200eeee000@gmail.com', 'dubetuto', 'Solicitud Urgente de Donación de Sangre para test', 'BloodDonationRequestMail', '{\"blood_request_id\":7,\"pet_id\":13,\"tutor_id\":22}', 'sent', NULL, '2025-09-22 01:06:58', '2025-09-22 01:06:58', '2025-09-22 01:06:58'),
(40, 'duver20222000@gmail.com', 'asdfasd', 'Solicitud Urgente de Donación de Sangre para test', 'BloodDonationRequestMail', '{\"blood_request_id\":7,\"pet_id\":14,\"tutor_id\":21}', 'sent', NULL, '2025-09-22 01:06:59', '2025-09-22 01:06:59', '2025-09-22 01:06:59'),
(41, 'duver20222000@gmail.com', 'asdfasd', 'Solicitud Urgente de Donación de Sangre para test', 'BloodDonationRequestMail', '{\"blood_request_id\":7,\"pet_id\":15,\"tutor_id\":21}', 'sent', NULL, '2025-09-22 01:06:59', '2025-09-22 01:06:59', '2025-09-22 01:06:59'),
(42, 'duver20222000@gmail.com', 'asdfasd', 'Solicitud Urgente de Donación de Sangre para test', 'BloodDonationRequestMail', '{\"blood_request_id\":7,\"pet_id\":16,\"tutor_id\":21}', 'sent', NULL, '2025-09-22 01:07:00', '2025-09-22 01:07:00', '2025-09-22 01:07:00'),
(43, 'duver20222000@gmail.com', 'asdfasd', 'Solicitud Urgente de Donación de Sangre para test', 'BloodDonationRequestMail', '{\"blood_request_id\":7,\"pet_id\":17,\"tutor_id\":21}', 'sent', NULL, '2025-09-22 01:07:01', '2025-09-22 01:07:01', '2025-09-22 01:07:01'),
(44, 'duver20222000@gmail.com', 'asdfasd', 'Solicitud Urgente de Donación de Sangre para test', 'BloodDonationRequestMail', '{\"blood_request_id\":7,\"pet_id\":18,\"tutor_id\":21}', 'sent', NULL, '2025-09-22 01:07:01', '2025-09-22 01:07:01', '2025-09-22 01:07:01'),
(45, 'duver20222000@gmail.com', 'asdfasd', 'Solicitud Urgente de Donación de Sangre para test', 'BloodDonationRequestMail', '{\"blood_request_id\":7,\"pet_id\":19,\"tutor_id\":21}', 'sent', NULL, '2025-09-22 01:07:02', '2025-09-22 01:07:02', '2025-09-22 01:07:02'),
(46, 'duver220200a@gmail.com', 'fasdfads', 'Solicitud Urgente de Donación de Sangre para test', 'BloodDonationRequestMail', '{\"blood_request_id\":7,\"pet_id\":20,\"tutor_id\":28}', 'sent', NULL, '2025-09-22 01:07:03', '2025-09-22 01:07:03', '2025-09-22 01:07:03'),
(47, 'duver20222000@gmail.com', 'asdfasd', 'Solicitud Urgente de Donación de Sangre para test', 'BloodDonationRequestMail', '{\"blood_request_id\":7,\"pet_id\":21,\"tutor_id\":21}', 'sent', NULL, '2025-09-22 01:07:03', '2025-09-22 01:07:03', '2025-09-22 01:07:03'),
(48, 'duver20000@gmail.com', 'asdfas', 'Solicitud Urgente de Donación de Sangre para test', 'BloodDonationRequestMail', '{\"blood_request_id\":7,\"pet_id\":22,\"tutor_id\":29}', 'sent', NULL, '2025-09-22 01:07:04', '2025-09-22 01:07:04', '2025-09-22 01:07:04'),
(49, 'duver20000@gmail.com', 'asdfas', 'Solicitud Urgente de Donación de Sangre para test', 'BloodDonationRequestMail', '{\"blood_request_id\":7,\"pet_id\":23,\"tutor_id\":29}', 'sent', NULL, '2025-09-22 01:07:05', '2025-09-22 01:07:05', '2025-09-22 01:07:05'),
(50, 'maria@gmail.com', 'María García', 'Solicitud Urgente de Donación de Sangre para IAN', 'BloodDonationRequestMail', '{\"blood_request_id\":8,\"pet_id\":1,\"tutor_id\":4}', 'failed', 'Attempt to read property \"name\" on null (View: C:\\Users\\duver\\Desktop\\Proyecto\\DognarNew\\banco-sangre-canina\\resources\\views\\emails\\blood-donation-request.blade.php)', '2025-09-22 02:18:35', '2025-09-22 02:18:35', '2025-09-22 02:18:35'),
(51, 'juan@hotmail.com', 'Juan Pérez', 'Solicitud Urgente de Donación de Sangre para IAN', 'BloodDonationRequestMail', '{\"blood_request_id\":8,\"pet_id\":2,\"tutor_id\":5}', 'failed', 'Attempt to read property \"name\" on null (View: C:\\Users\\duver\\Desktop\\Proyecto\\DognarNew\\banco-sangre-canina\\resources\\views\\emails\\blood-donation-request.blade.php)', '2025-09-22 02:18:35', '2025-09-22 02:18:35', '2025-09-22 02:18:35'),
(52, 'sofia@yahoo.com', 'Sofia Martínez', 'Solicitud Urgente de Donación de Sangre para IAN', 'BloodDonationRequestMail', '{\"blood_request_id\":8,\"pet_id\":3,\"tutor_id\":6}', 'failed', 'Attempt to read property \"name\" on null (View: C:\\Users\\duver\\Desktop\\Proyecto\\DognarNew\\banco-sangre-canina\\resources\\views\\emails\\blood-donation-request.blade.php)', '2025-09-22 02:18:35', '2025-09-22 02:18:35', '2025-09-22 02:18:35'),
(53, 'duver20222000@gmail.com', 'asdfasd', 'Solicitud Urgente de Donación de Sangre para IAN', 'BloodDonationRequestMail', '{\"blood_request_id\":8,\"pet_id\":12,\"tutor_id\":21}', 'failed', 'Attempt to read property \"name\" on null (View: C:\\Users\\duver\\Desktop\\Proyecto\\DognarNew\\banco-sangre-canina\\resources\\views\\emails\\blood-donation-request.blade.php)', '2025-09-22 02:18:35', '2025-09-22 02:18:35', '2025-09-22 02:18:35'),
(54, 'duver200eeee000@gmail.com', 'dubetuto', 'Solicitud Urgente de Donación de Sangre para IAN', 'BloodDonationRequestMail', '{\"blood_request_id\":8,\"pet_id\":13,\"tutor_id\":22}', 'failed', 'Attempt to read property \"name\" on null (View: C:\\Users\\duver\\Desktop\\Proyecto\\DognarNew\\banco-sangre-canina\\resources\\views\\emails\\blood-donation-request.blade.php)', '2025-09-22 02:18:35', '2025-09-22 02:18:35', '2025-09-22 02:18:35'),
(55, 'duver20222000@gmail.com', 'asdfasd', 'Solicitud Urgente de Donación de Sangre para IAN', 'BloodDonationRequestMail', '{\"blood_request_id\":8,\"pet_id\":14,\"tutor_id\":21}', 'failed', 'Attempt to read property \"name\" on null (View: C:\\Users\\duver\\Desktop\\Proyecto\\DognarNew\\banco-sangre-canina\\resources\\views\\emails\\blood-donation-request.blade.php)', '2025-09-22 02:18:35', '2025-09-22 02:18:35', '2025-09-22 02:18:35'),
(56, 'duver20222000@gmail.com', 'asdfasd', 'Solicitud Urgente de Donación de Sangre para IAN', 'BloodDonationRequestMail', '{\"blood_request_id\":8,\"pet_id\":15,\"tutor_id\":21}', 'failed', 'Attempt to read property \"name\" on null (View: C:\\Users\\duver\\Desktop\\Proyecto\\DognarNew\\banco-sangre-canina\\resources\\views\\emails\\blood-donation-request.blade.php)', '2025-09-22 02:18:35', '2025-09-22 02:18:35', '2025-09-22 02:18:35'),
(57, 'duver20222000@gmail.com', 'asdfasd', 'Solicitud Urgente de Donación de Sangre para IAN', 'BloodDonationRequestMail', '{\"blood_request_id\":8,\"pet_id\":16,\"tutor_id\":21}', 'failed', 'Attempt to read property \"name\" on null (View: C:\\Users\\duver\\Desktop\\Proyecto\\DognarNew\\banco-sangre-canina\\resources\\views\\emails\\blood-donation-request.blade.php)', '2025-09-22 02:18:35', '2025-09-22 02:18:35', '2025-09-22 02:18:35'),
(58, 'duver20222000@gmail.com', 'asdfasd', 'Solicitud Urgente de Donación de Sangre para IAN', 'BloodDonationRequestMail', '{\"blood_request_id\":8,\"pet_id\":17,\"tutor_id\":21}', 'failed', 'Attempt to read property \"name\" on null (View: C:\\Users\\duver\\Desktop\\Proyecto\\DognarNew\\banco-sangre-canina\\resources\\views\\emails\\blood-donation-request.blade.php)', '2025-09-22 02:18:35', '2025-09-22 02:18:35', '2025-09-22 02:18:35'),
(59, 'duver20222000@gmail.com', 'asdfasd', 'Solicitud Urgente de Donación de Sangre para IAN', 'BloodDonationRequestMail', '{\"blood_request_id\":8,\"pet_id\":18,\"tutor_id\":21}', 'failed', 'Attempt to read property \"name\" on null (View: C:\\Users\\duver\\Desktop\\Proyecto\\DognarNew\\banco-sangre-canina\\resources\\views\\emails\\blood-donation-request.blade.php)', '2025-09-22 02:18:35', '2025-09-22 02:18:35', '2025-09-22 02:18:35'),
(60, 'duver20222000@gmail.com', 'asdfasd', 'Solicitud Urgente de Donación de Sangre para IAN', 'BloodDonationRequestMail', '{\"blood_request_id\":8,\"pet_id\":19,\"tutor_id\":21}', 'failed', 'Attempt to read property \"name\" on null (View: C:\\Users\\duver\\Desktop\\Proyecto\\DognarNew\\banco-sangre-canina\\resources\\views\\emails\\blood-donation-request.blade.php)', '2025-09-22 02:18:35', '2025-09-22 02:18:35', '2025-09-22 02:18:35'),
(61, 'duver220200a@gmail.com', 'fasdfads', 'Solicitud Urgente de Donación de Sangre para IAN', 'BloodDonationRequestMail', '{\"blood_request_id\":8,\"pet_id\":20,\"tutor_id\":28}', 'failed', 'Attempt to read property \"name\" on null (View: C:\\Users\\duver\\Desktop\\Proyecto\\DognarNew\\banco-sangre-canina\\resources\\views\\emails\\blood-donation-request.blade.php)', '2025-09-22 02:18:35', '2025-09-22 02:18:35', '2025-09-22 02:18:35'),
(62, 'duver20222000@gmail.com', 'asdfasd', 'Solicitud Urgente de Donación de Sangre para IAN', 'BloodDonationRequestMail', '{\"blood_request_id\":8,\"pet_id\":21,\"tutor_id\":21}', 'failed', 'Attempt to read property \"name\" on null (View: C:\\Users\\duver\\Desktop\\Proyecto\\DognarNew\\banco-sangre-canina\\resources\\views\\emails\\blood-donation-request.blade.php)', '2025-09-22 02:18:35', '2025-09-22 02:18:35', '2025-09-22 02:18:35'),
(63, 'maria@gmail.com', 'María García', 'Solicitud Urgente de Donación de Sangre para Solicitud 2', 'BloodDonationRequestMail', '{\"blood_request_id\":9,\"pet_id\":1,\"tutor_id\":4}', 'failed', 'Attempt to read property \"name\" on null (View: C:\\Users\\duver\\Desktop\\Proyecto\\DognarNew\\banco-sangre-canina\\resources\\views\\emails\\blood-donation-request.blade.php)', '2025-09-22 02:20:15', '2025-09-22 02:20:15', '2025-09-22 02:20:15'),
(64, 'juan@hotmail.com', 'Juan Pérez', 'Solicitud Urgente de Donación de Sangre para Solicitud 2', 'BloodDonationRequestMail', '{\"blood_request_id\":9,\"pet_id\":2,\"tutor_id\":5}', 'failed', 'Attempt to read property \"name\" on null (View: C:\\Users\\duver\\Desktop\\Proyecto\\DognarNew\\banco-sangre-canina\\resources\\views\\emails\\blood-donation-request.blade.php)', '2025-09-22 02:20:15', '2025-09-22 02:20:15', '2025-09-22 02:20:15'),
(65, 'sofia@yahoo.com', 'Sofia Martínez', 'Solicitud Urgente de Donación de Sangre para Solicitud 2', 'BloodDonationRequestMail', '{\"blood_request_id\":9,\"pet_id\":3,\"tutor_id\":6}', 'failed', 'Attempt to read property \"name\" on null (View: C:\\Users\\duver\\Desktop\\Proyecto\\DognarNew\\banco-sangre-canina\\resources\\views\\emails\\blood-donation-request.blade.php)', '2025-09-22 02:20:15', '2025-09-22 02:20:15', '2025-09-22 02:20:15'),
(66, 'duver20222000@gmail.com', 'asdfasd', 'Solicitud Urgente de Donación de Sangre para Solicitud 2', 'BloodDonationRequestMail', '{\"blood_request_id\":9,\"pet_id\":12,\"tutor_id\":21}', 'failed', 'Attempt to read property \"name\" on null (View: C:\\Users\\duver\\Desktop\\Proyecto\\DognarNew\\banco-sangre-canina\\resources\\views\\emails\\blood-donation-request.blade.php)', '2025-09-22 02:20:15', '2025-09-22 02:20:15', '2025-09-22 02:20:15'),
(67, 'duver200eeee000@gmail.com', 'dubetuto', 'Solicitud Urgente de Donación de Sangre para Solicitud 2', 'BloodDonationRequestMail', '{\"blood_request_id\":9,\"pet_id\":13,\"tutor_id\":22}', 'failed', 'Attempt to read property \"name\" on null (View: C:\\Users\\duver\\Desktop\\Proyecto\\DognarNew\\banco-sangre-canina\\resources\\views\\emails\\blood-donation-request.blade.php)', '2025-09-22 02:20:15', '2025-09-22 02:20:15', '2025-09-22 02:20:15'),
(68, 'duver20222000@gmail.com', 'asdfasd', 'Solicitud Urgente de Donación de Sangre para Solicitud 2', 'BloodDonationRequestMail', '{\"blood_request_id\":9,\"pet_id\":14,\"tutor_id\":21}', 'failed', 'Attempt to read property \"name\" on null (View: C:\\Users\\duver\\Desktop\\Proyecto\\DognarNew\\banco-sangre-canina\\resources\\views\\emails\\blood-donation-request.blade.php)', '2025-09-22 02:20:15', '2025-09-22 02:20:15', '2025-09-22 02:20:15'),
(69, 'duver20222000@gmail.com', 'asdfasd', 'Solicitud Urgente de Donación de Sangre para Solicitud 2', 'BloodDonationRequestMail', '{\"blood_request_id\":9,\"pet_id\":15,\"tutor_id\":21}', 'failed', 'Attempt to read property \"name\" on null (View: C:\\Users\\duver\\Desktop\\Proyecto\\DognarNew\\banco-sangre-canina\\resources\\views\\emails\\blood-donation-request.blade.php)', '2025-09-22 02:20:15', '2025-09-22 02:20:15', '2025-09-22 02:20:15'),
(70, 'duver20222000@gmail.com', 'asdfasd', 'Solicitud Urgente de Donación de Sangre para Solicitud 2', 'BloodDonationRequestMail', '{\"blood_request_id\":9,\"pet_id\":16,\"tutor_id\":21}', 'failed', 'Attempt to read property \"name\" on null (View: C:\\Users\\duver\\Desktop\\Proyecto\\DognarNew\\banco-sangre-canina\\resources\\views\\emails\\blood-donation-request.blade.php)', '2025-09-22 02:20:15', '2025-09-22 02:20:15', '2025-09-22 02:20:15'),
(71, 'duver20222000@gmail.com', 'asdfasd', 'Solicitud Urgente de Donación de Sangre para Solicitud 2', 'BloodDonationRequestMail', '{\"blood_request_id\":9,\"pet_id\":17,\"tutor_id\":21}', 'failed', 'Attempt to read property \"name\" on null (View: C:\\Users\\duver\\Desktop\\Proyecto\\DognarNew\\banco-sangre-canina\\resources\\views\\emails\\blood-donation-request.blade.php)', '2025-09-22 02:20:15', '2025-09-22 02:20:15', '2025-09-22 02:20:15'),
(72, 'duver20222000@gmail.com', 'asdfasd', 'Solicitud Urgente de Donación de Sangre para Solicitud 2', 'BloodDonationRequestMail', '{\"blood_request_id\":9,\"pet_id\":18,\"tutor_id\":21}', 'failed', 'Attempt to read property \"name\" on null (View: C:\\Users\\duver\\Desktop\\Proyecto\\DognarNew\\banco-sangre-canina\\resources\\views\\emails\\blood-donation-request.blade.php)', '2025-09-22 02:20:15', '2025-09-22 02:20:15', '2025-09-22 02:20:15'),
(73, 'duver20222000@gmail.com', 'asdfasd', 'Solicitud Urgente de Donación de Sangre para Solicitud 2', 'BloodDonationRequestMail', '{\"blood_request_id\":9,\"pet_id\":19,\"tutor_id\":21}', 'failed', 'Attempt to read property \"name\" on null (View: C:\\Users\\duver\\Desktop\\Proyecto\\DognarNew\\banco-sangre-canina\\resources\\views\\emails\\blood-donation-request.blade.php)', '2025-09-22 02:20:15', '2025-09-22 02:20:15', '2025-09-22 02:20:15'),
(74, 'duver220200a@gmail.com', 'fasdfads', 'Solicitud Urgente de Donación de Sangre para Solicitud 2', 'BloodDonationRequestMail', '{\"blood_request_id\":9,\"pet_id\":20,\"tutor_id\":28}', 'failed', 'Attempt to read property \"name\" on null (View: C:\\Users\\duver\\Desktop\\Proyecto\\DognarNew\\banco-sangre-canina\\resources\\views\\emails\\blood-donation-request.blade.php)', '2025-09-22 02:20:15', '2025-09-22 02:20:15', '2025-09-22 02:20:15'),
(75, 'duver20222000@gmail.com', 'asdfasd', 'Solicitud Urgente de Donación de Sangre para Solicitud 2', 'BloodDonationRequestMail', '{\"blood_request_id\":9,\"pet_id\":21,\"tutor_id\":21}', 'failed', 'Attempt to read property \"name\" on null (View: C:\\Users\\duver\\Desktop\\Proyecto\\DognarNew\\banco-sangre-canina\\resources\\views\\emails\\blood-donation-request.blade.php)', '2025-09-22 02:20:15', '2025-09-22 02:20:15', '2025-09-22 02:20:15'),
(76, 'maria@gmail.com', 'María García', 'Solicitud Urgente de Donación de Sangre para Solicitud 3', 'BloodDonationRequestMail', '{\"blood_request_id\":10,\"pet_id\":1,\"tutor_id\":4}', 'failed', 'Attempt to read property \"name\" on null (View: C:\\Users\\duver\\Desktop\\Proyecto\\DognarNew\\banco-sangre-canina\\resources\\views\\emails\\blood-donation-request.blade.php)', '2025-09-22 02:20:26', '2025-09-22 02:20:26', '2025-09-22 02:20:26'),
(77, 'juan@hotmail.com', 'Juan Pérez', 'Solicitud Urgente de Donación de Sangre para Solicitud 3', 'BloodDonationRequestMail', '{\"blood_request_id\":10,\"pet_id\":2,\"tutor_id\":5}', 'failed', 'Attempt to read property \"name\" on null (View: C:\\Users\\duver\\Desktop\\Proyecto\\DognarNew\\banco-sangre-canina\\resources\\views\\emails\\blood-donation-request.blade.php)', '2025-09-22 02:20:26', '2025-09-22 02:20:26', '2025-09-22 02:20:26'),
(78, 'sofia@yahoo.com', 'Sofia Martínez', 'Solicitud Urgente de Donación de Sangre para Solicitud 3', 'BloodDonationRequestMail', '{\"blood_request_id\":10,\"pet_id\":3,\"tutor_id\":6}', 'failed', 'Attempt to read property \"name\" on null (View: C:\\Users\\duver\\Desktop\\Proyecto\\DognarNew\\banco-sangre-canina\\resources\\views\\emails\\blood-donation-request.blade.php)', '2025-09-22 02:20:26', '2025-09-22 02:20:26', '2025-09-22 02:20:26'),
(79, 'duver20222000@gmail.com', 'asdfasd', 'Solicitud Urgente de Donación de Sangre para Solicitud 3', 'BloodDonationRequestMail', '{\"blood_request_id\":10,\"pet_id\":12,\"tutor_id\":21}', 'failed', 'Attempt to read property \"name\" on null (View: C:\\Users\\duver\\Desktop\\Proyecto\\DognarNew\\banco-sangre-canina\\resources\\views\\emails\\blood-donation-request.blade.php)', '2025-09-22 02:20:26', '2025-09-22 02:20:26', '2025-09-22 02:20:26'),
(80, 'duver200eeee000@gmail.com', 'dubetuto', 'Solicitud Urgente de Donación de Sangre para Solicitud 3', 'BloodDonationRequestMail', '{\"blood_request_id\":10,\"pet_id\":13,\"tutor_id\":22}', 'failed', 'Attempt to read property \"name\" on null (View: C:\\Users\\duver\\Desktop\\Proyecto\\DognarNew\\banco-sangre-canina\\resources\\views\\emails\\blood-donation-request.blade.php)', '2025-09-22 02:20:26', '2025-09-22 02:20:26', '2025-09-22 02:20:26'),
(81, 'duver20222000@gmail.com', 'asdfasd', 'Solicitud Urgente de Donación de Sangre para Solicitud 3', 'BloodDonationRequestMail', '{\"blood_request_id\":10,\"pet_id\":14,\"tutor_id\":21}', 'failed', 'Attempt to read property \"name\" on null (View: C:\\Users\\duver\\Desktop\\Proyecto\\DognarNew\\banco-sangre-canina\\resources\\views\\emails\\blood-donation-request.blade.php)', '2025-09-22 02:20:26', '2025-09-22 02:20:26', '2025-09-22 02:20:26'),
(82, 'duver20222000@gmail.com', 'asdfasd', 'Solicitud Urgente de Donación de Sangre para Solicitud 3', 'BloodDonationRequestMail', '{\"blood_request_id\":10,\"pet_id\":15,\"tutor_id\":21}', 'failed', 'Attempt to read property \"name\" on null (View: C:\\Users\\duver\\Desktop\\Proyecto\\DognarNew\\banco-sangre-canina\\resources\\views\\emails\\blood-donation-request.blade.php)', '2025-09-22 02:20:26', '2025-09-22 02:20:26', '2025-09-22 02:20:26'),
(83, 'duver20222000@gmail.com', 'asdfasd', 'Solicitud Urgente de Donación de Sangre para Solicitud 3', 'BloodDonationRequestMail', '{\"blood_request_id\":10,\"pet_id\":16,\"tutor_id\":21}', 'failed', 'Attempt to read property \"name\" on null (View: C:\\Users\\duver\\Desktop\\Proyecto\\DognarNew\\banco-sangre-canina\\resources\\views\\emails\\blood-donation-request.blade.php)', '2025-09-22 02:20:26', '2025-09-22 02:20:26', '2025-09-22 02:20:26'),
(84, 'duver20222000@gmail.com', 'asdfasd', 'Solicitud Urgente de Donación de Sangre para Solicitud 3', 'BloodDonationRequestMail', '{\"blood_request_id\":10,\"pet_id\":17,\"tutor_id\":21}', 'failed', 'Attempt to read property \"name\" on null (View: C:\\Users\\duver\\Desktop\\Proyecto\\DognarNew\\banco-sangre-canina\\resources\\views\\emails\\blood-donation-request.blade.php)', '2025-09-22 02:20:26', '2025-09-22 02:20:26', '2025-09-22 02:20:26'),
(85, 'duver20222000@gmail.com', 'asdfasd', 'Solicitud Urgente de Donación de Sangre para Solicitud 3', 'BloodDonationRequestMail', '{\"blood_request_id\":10,\"pet_id\":18,\"tutor_id\":21}', 'failed', 'Attempt to read property \"name\" on null (View: C:\\Users\\duver\\Desktop\\Proyecto\\DognarNew\\banco-sangre-canina\\resources\\views\\emails\\blood-donation-request.blade.php)', '2025-09-22 02:20:26', '2025-09-22 02:20:26', '2025-09-22 02:20:26'),
(86, 'duver20222000@gmail.com', 'asdfasd', 'Solicitud Urgente de Donación de Sangre para Solicitud 3', 'BloodDonationRequestMail', '{\"blood_request_id\":10,\"pet_id\":19,\"tutor_id\":21}', 'failed', 'Attempt to read property \"name\" on null (View: C:\\Users\\duver\\Desktop\\Proyecto\\DognarNew\\banco-sangre-canina\\resources\\views\\emails\\blood-donation-request.blade.php)', '2025-09-22 02:20:26', '2025-09-22 02:20:26', '2025-09-22 02:20:26'),
(87, 'duver220200a@gmail.com', 'fasdfads', 'Solicitud Urgente de Donación de Sangre para Solicitud 3', 'BloodDonationRequestMail', '{\"blood_request_id\":10,\"pet_id\":20,\"tutor_id\":28}', 'failed', 'Attempt to read property \"name\" on null (View: C:\\Users\\duver\\Desktop\\Proyecto\\DognarNew\\banco-sangre-canina\\resources\\views\\emails\\blood-donation-request.blade.php)', '2025-09-22 02:20:26', '2025-09-22 02:20:26', '2025-09-22 02:20:26'),
(88, 'duver20222000@gmail.com', 'asdfasd', 'Solicitud Urgente de Donación de Sangre para Solicitud 3', 'BloodDonationRequestMail', '{\"blood_request_id\":10,\"pet_id\":21,\"tutor_id\":21}', 'failed', 'Attempt to read property \"name\" on null (View: C:\\Users\\duver\\Desktop\\Proyecto\\DognarNew\\banco-sangre-canina\\resources\\views\\emails\\blood-donation-request.blade.php)', '2025-09-22 02:20:26', '2025-09-22 02:20:26', '2025-09-22 02:20:26'),
(89, 'maria@gmail.com', 'María García', 'Solicitud Urgente de Donación de Sangre para Solicitud 4', 'BloodDonationRequestMail', '{\"blood_request_id\":11,\"pet_id\":1,\"tutor_id\":4}', 'failed', 'Attempt to read property \"name\" on null (View: C:\\Users\\duver\\Desktop\\Proyecto\\DognarNew\\banco-sangre-canina\\resources\\views\\emails\\blood-donation-request.blade.php)', '2025-09-22 02:20:37', '2025-09-22 02:20:37', '2025-09-22 02:20:37'),
(90, 'juan@hotmail.com', 'Juan Pérez', 'Solicitud Urgente de Donación de Sangre para Solicitud 4', 'BloodDonationRequestMail', '{\"blood_request_id\":11,\"pet_id\":2,\"tutor_id\":5}', 'failed', 'Attempt to read property \"name\" on null (View: C:\\Users\\duver\\Desktop\\Proyecto\\DognarNew\\banco-sangre-canina\\resources\\views\\emails\\blood-donation-request.blade.php)', '2025-09-22 02:20:37', '2025-09-22 02:20:37', '2025-09-22 02:20:37'),
(91, 'sofia@yahoo.com', 'Sofia Martínez', 'Solicitud Urgente de Donación de Sangre para Solicitud 4', 'BloodDonationRequestMail', '{\"blood_request_id\":11,\"pet_id\":3,\"tutor_id\":6}', 'failed', 'Attempt to read property \"name\" on null (View: C:\\Users\\duver\\Desktop\\Proyecto\\DognarNew\\banco-sangre-canina\\resources\\views\\emails\\blood-donation-request.blade.php)', '2025-09-22 02:20:37', '2025-09-22 02:20:37', '2025-09-22 02:20:37'),
(92, 'duver20222000@gmail.com', 'asdfasd', 'Solicitud Urgente de Donación de Sangre para Solicitud 4', 'BloodDonationRequestMail', '{\"blood_request_id\":11,\"pet_id\":12,\"tutor_id\":21}', 'failed', 'Attempt to read property \"name\" on null (View: C:\\Users\\duver\\Desktop\\Proyecto\\DognarNew\\banco-sangre-canina\\resources\\views\\emails\\blood-donation-request.blade.php)', '2025-09-22 02:20:37', '2025-09-22 02:20:37', '2025-09-22 02:20:37'),
(93, 'duver200eeee000@gmail.com', 'dubetuto', 'Solicitud Urgente de Donación de Sangre para Solicitud 4', 'BloodDonationRequestMail', '{\"blood_request_id\":11,\"pet_id\":13,\"tutor_id\":22}', 'failed', 'Attempt to read property \"name\" on null (View: C:\\Users\\duver\\Desktop\\Proyecto\\DognarNew\\banco-sangre-canina\\resources\\views\\emails\\blood-donation-request.blade.php)', '2025-09-22 02:20:37', '2025-09-22 02:20:37', '2025-09-22 02:20:37'),
(94, 'duver20222000@gmail.com', 'asdfasd', 'Solicitud Urgente de Donación de Sangre para Solicitud 4', 'BloodDonationRequestMail', '{\"blood_request_id\":11,\"pet_id\":14,\"tutor_id\":21}', 'failed', 'Attempt to read property \"name\" on null (View: C:\\Users\\duver\\Desktop\\Proyecto\\DognarNew\\banco-sangre-canina\\resources\\views\\emails\\blood-donation-request.blade.php)', '2025-09-22 02:20:37', '2025-09-22 02:20:37', '2025-09-22 02:20:37'),
(95, 'duver20222000@gmail.com', 'asdfasd', 'Solicitud Urgente de Donación de Sangre para Solicitud 4', 'BloodDonationRequestMail', '{\"blood_request_id\":11,\"pet_id\":15,\"tutor_id\":21}', 'failed', 'Attempt to read property \"name\" on null (View: C:\\Users\\duver\\Desktop\\Proyecto\\DognarNew\\banco-sangre-canina\\resources\\views\\emails\\blood-donation-request.blade.php)', '2025-09-22 02:20:37', '2025-09-22 02:20:37', '2025-09-22 02:20:37'),
(96, 'duver20222000@gmail.com', 'asdfasd', 'Solicitud Urgente de Donación de Sangre para Solicitud 4', 'BloodDonationRequestMail', '{\"blood_request_id\":11,\"pet_id\":16,\"tutor_id\":21}', 'failed', 'Attempt to read property \"name\" on null (View: C:\\Users\\duver\\Desktop\\Proyecto\\DognarNew\\banco-sangre-canina\\resources\\views\\emails\\blood-donation-request.blade.php)', '2025-09-22 02:20:37', '2025-09-22 02:20:37', '2025-09-22 02:20:37'),
(97, 'duver20222000@gmail.com', 'asdfasd', 'Solicitud Urgente de Donación de Sangre para Solicitud 4', 'BloodDonationRequestMail', '{\"blood_request_id\":11,\"pet_id\":17,\"tutor_id\":21}', 'failed', 'Attempt to read property \"name\" on null (View: C:\\Users\\duver\\Desktop\\Proyecto\\DognarNew\\banco-sangre-canina\\resources\\views\\emails\\blood-donation-request.blade.php)', '2025-09-22 02:20:37', '2025-09-22 02:20:37', '2025-09-22 02:20:37'),
(98, 'duver20222000@gmail.com', 'asdfasd', 'Solicitud Urgente de Donación de Sangre para Solicitud 4', 'BloodDonationRequestMail', '{\"blood_request_id\":11,\"pet_id\":18,\"tutor_id\":21}', 'failed', 'Attempt to read property \"name\" on null (View: C:\\Users\\duver\\Desktop\\Proyecto\\DognarNew\\banco-sangre-canina\\resources\\views\\emails\\blood-donation-request.blade.php)', '2025-09-22 02:20:37', '2025-09-22 02:20:37', '2025-09-22 02:20:37'),
(99, 'duver20222000@gmail.com', 'asdfasd', 'Solicitud Urgente de Donación de Sangre para Solicitud 4', 'BloodDonationRequestMail', '{\"blood_request_id\":11,\"pet_id\":19,\"tutor_id\":21}', 'failed', 'Attempt to read property \"name\" on null (View: C:\\Users\\duver\\Desktop\\Proyecto\\DognarNew\\banco-sangre-canina\\resources\\views\\emails\\blood-donation-request.blade.php)', '2025-09-22 02:20:37', '2025-09-22 02:20:37', '2025-09-22 02:20:37'),
(100, 'duver220200a@gmail.com', 'fasdfads', 'Solicitud Urgente de Donación de Sangre para Solicitud 4', 'BloodDonationRequestMail', '{\"blood_request_id\":11,\"pet_id\":20,\"tutor_id\":28}', 'failed', 'Attempt to read property \"name\" on null (View: C:\\Users\\duver\\Desktop\\Proyecto\\DognarNew\\banco-sangre-canina\\resources\\views\\emails\\blood-donation-request.blade.php)', '2025-09-22 02:20:37', '2025-09-22 02:20:37', '2025-09-22 02:20:37'),
(101, 'duver20222000@gmail.com', 'asdfasd', 'Solicitud Urgente de Donación de Sangre para Solicitud 4', 'BloodDonationRequestMail', '{\"blood_request_id\":11,\"pet_id\":21,\"tutor_id\":21}', 'failed', 'Attempt to read property \"name\" on null (View: C:\\Users\\duver\\Desktop\\Proyecto\\DognarNew\\banco-sangre-canina\\resources\\views\\emails\\blood-donation-request.blade.php)', '2025-09-22 02:20:37', '2025-09-22 02:20:37', '2025-09-22 02:20:37'),
(102, 'maria@gmail.com', 'María García', 'Solicitud Urgente de Donación de Sangre para Solicitud 5', 'BloodDonationRequestMail', '{\"blood_request_id\":12,\"pet_id\":1,\"tutor_id\":4}', 'failed', 'Attempt to read property \"name\" on null (View: C:\\Users\\duver\\Desktop\\Proyecto\\DognarNew\\banco-sangre-canina\\resources\\views\\emails\\blood-donation-request.blade.php)', '2025-09-22 02:20:51', '2025-09-22 02:20:51', '2025-09-22 02:20:51'),
(103, 'juan@hotmail.com', 'Juan Pérez', 'Solicitud Urgente de Donación de Sangre para Solicitud 5', 'BloodDonationRequestMail', '{\"blood_request_id\":12,\"pet_id\":2,\"tutor_id\":5}', 'failed', 'Attempt to read property \"name\" on null (View: C:\\Users\\duver\\Desktop\\Proyecto\\DognarNew\\banco-sangre-canina\\resources\\views\\emails\\blood-donation-request.blade.php)', '2025-09-22 02:20:51', '2025-09-22 02:20:51', '2025-09-22 02:20:51'),
(104, 'sofia@yahoo.com', 'Sofia Martínez', 'Solicitud Urgente de Donación de Sangre para Solicitud 5', 'BloodDonationRequestMail', '{\"blood_request_id\":12,\"pet_id\":3,\"tutor_id\":6}', 'failed', 'Attempt to read property \"name\" on null (View: C:\\Users\\duver\\Desktop\\Proyecto\\DognarNew\\banco-sangre-canina\\resources\\views\\emails\\blood-donation-request.blade.php)', '2025-09-22 02:20:51', '2025-09-22 02:20:51', '2025-09-22 02:20:51'),
(105, 'duver20222000@gmail.com', 'asdfasd', 'Solicitud Urgente de Donación de Sangre para Solicitud 5', 'BloodDonationRequestMail', '{\"blood_request_id\":12,\"pet_id\":12,\"tutor_id\":21}', 'failed', 'Attempt to read property \"name\" on null (View: C:\\Users\\duver\\Desktop\\Proyecto\\DognarNew\\banco-sangre-canina\\resources\\views\\emails\\blood-donation-request.blade.php)', '2025-09-22 02:20:51', '2025-09-22 02:20:51', '2025-09-22 02:20:51'),
(106, 'duver200eeee000@gmail.com', 'dubetuto', 'Solicitud Urgente de Donación de Sangre para Solicitud 5', 'BloodDonationRequestMail', '{\"blood_request_id\":12,\"pet_id\":13,\"tutor_id\":22}', 'failed', 'Attempt to read property \"name\" on null (View: C:\\Users\\duver\\Desktop\\Proyecto\\DognarNew\\banco-sangre-canina\\resources\\views\\emails\\blood-donation-request.blade.php)', '2025-09-22 02:20:51', '2025-09-22 02:20:51', '2025-09-22 02:20:51'),
(107, 'duver20222000@gmail.com', 'asdfasd', 'Solicitud Urgente de Donación de Sangre para Solicitud 5', 'BloodDonationRequestMail', '{\"blood_request_id\":12,\"pet_id\":14,\"tutor_id\":21}', 'failed', 'Attempt to read property \"name\" on null (View: C:\\Users\\duver\\Desktop\\Proyecto\\DognarNew\\banco-sangre-canina\\resources\\views\\emails\\blood-donation-request.blade.php)', '2025-09-22 02:20:51', '2025-09-22 02:20:51', '2025-09-22 02:20:51'),
(108, 'duver20222000@gmail.com', 'asdfasd', 'Solicitud Urgente de Donación de Sangre para Solicitud 5', 'BloodDonationRequestMail', '{\"blood_request_id\":12,\"pet_id\":15,\"tutor_id\":21}', 'failed', 'Attempt to read property \"name\" on null (View: C:\\Users\\duver\\Desktop\\Proyecto\\DognarNew\\banco-sangre-canina\\resources\\views\\emails\\blood-donation-request.blade.php)', '2025-09-22 02:20:51', '2025-09-22 02:20:51', '2025-09-22 02:20:51'),
(109, 'duver20222000@gmail.com', 'asdfasd', 'Solicitud Urgente de Donación de Sangre para Solicitud 5', 'BloodDonationRequestMail', '{\"blood_request_id\":12,\"pet_id\":16,\"tutor_id\":21}', 'failed', 'Attempt to read property \"name\" on null (View: C:\\Users\\duver\\Desktop\\Proyecto\\DognarNew\\banco-sangre-canina\\resources\\views\\emails\\blood-donation-request.blade.php)', '2025-09-22 02:20:51', '2025-09-22 02:20:51', '2025-09-22 02:20:51'),
(110, 'duver20222000@gmail.com', 'asdfasd', 'Solicitud Urgente de Donación de Sangre para Solicitud 5', 'BloodDonationRequestMail', '{\"blood_request_id\":12,\"pet_id\":17,\"tutor_id\":21}', 'failed', 'Attempt to read property \"name\" on null (View: C:\\Users\\duver\\Desktop\\Proyecto\\DognarNew\\banco-sangre-canina\\resources\\views\\emails\\blood-donation-request.blade.php)', '2025-09-22 02:20:51', '2025-09-22 02:20:51', '2025-09-22 02:20:51'),
(111, 'duver20222000@gmail.com', 'asdfasd', 'Solicitud Urgente de Donación de Sangre para Solicitud 5', 'BloodDonationRequestMail', '{\"blood_request_id\":12,\"pet_id\":18,\"tutor_id\":21}', 'failed', 'Attempt to read property \"name\" on null (View: C:\\Users\\duver\\Desktop\\Proyecto\\DognarNew\\banco-sangre-canina\\resources\\views\\emails\\blood-donation-request.blade.php)', '2025-09-22 02:20:51', '2025-09-22 02:20:51', '2025-09-22 02:20:51'),
(112, 'duver20222000@gmail.com', 'asdfasd', 'Solicitud Urgente de Donación de Sangre para Solicitud 5', 'BloodDonationRequestMail', '{\"blood_request_id\":12,\"pet_id\":19,\"tutor_id\":21}', 'failed', 'Attempt to read property \"name\" on null (View: C:\\Users\\duver\\Desktop\\Proyecto\\DognarNew\\banco-sangre-canina\\resources\\views\\emails\\blood-donation-request.blade.php)', '2025-09-22 02:20:51', '2025-09-22 02:20:51', '2025-09-22 02:20:51'),
(113, 'duver220200a@gmail.com', 'fasdfads', 'Solicitud Urgente de Donación de Sangre para Solicitud 5', 'BloodDonationRequestMail', '{\"blood_request_id\":12,\"pet_id\":20,\"tutor_id\":28}', 'failed', 'Attempt to read property \"name\" on null (View: C:\\Users\\duver\\Desktop\\Proyecto\\DognarNew\\banco-sangre-canina\\resources\\views\\emails\\blood-donation-request.blade.php)', '2025-09-22 02:20:51', '2025-09-22 02:20:51', '2025-09-22 02:20:51'),
(114, 'duver20222000@gmail.com', 'asdfasd', 'Solicitud Urgente de Donación de Sangre para Solicitud 5', 'BloodDonationRequestMail', '{\"blood_request_id\":12,\"pet_id\":21,\"tutor_id\":21}', 'failed', 'Attempt to read property \"name\" on null (View: C:\\Users\\duver\\Desktop\\Proyecto\\DognarNew\\banco-sangre-canina\\resources\\views\\emails\\blood-donation-request.blade.php)', '2025-09-22 02:20:51', '2025-09-22 02:20:51', '2025-09-22 02:20:51'),
(115, 'duver20ac@gmail.com', 'Duberney Hernandez', 'Nueva mascota registrada: asdf', 'NewPetRegisteredMail', '{\"pet_id\":24,\"tutor_id\":30,\"is_new_user\":false}', 'sent', NULL, '2025-09-22 04:14:20', '2025-09-22 04:14:20', '2025-09-22 04:14:20'),
(116, 'duver20000@gmail.com', 'DuberneyTutort', '¡Bienvenido! Animal No 1 ya es un héroe donante', 'PetApprovedWelcomeMail', '{\"pet_id\":25,\"tutor_id\":33,\"is_new_user\":true}', 'sent', NULL, '2025-09-22 04:40:42', '2025-09-22 04:40:42', '2025-09-22 04:40:42'),
(117, 'duver20000@gmail.com', 'DuberneyTutort', 'Solicitud Urgente de Donación de Sangre para Prueba No 6', 'BloodDonationRequestMail', '{\"blood_request_id\":18,\"pet_id\":25,\"tutor_id\":33}', 'sent', NULL, '2025-09-22 04:42:09', '2025-09-22 04:42:09', '2025-09-22 04:42:09'),
(118, 'duver20000@gmail.com', 'DuberneyTutort', 'Nueva mascota registrada: Animal No 2', 'NewPetRegisteredMail', '{\"pet_id\":26,\"tutor_id\":33,\"is_new_user\":false}', 'sent', NULL, '2025-09-22 04:43:40', '2025-09-22 04:43:40', '2025-09-22 04:43:40'),
(119, 'duver20000@gmail.com', 'Duberney Hernandez Corzo', '¡Bienvenido! Canino No 1 ya es un héroe donante', 'PetApprovedWelcomeMail', '{\"pet_id\":27,\"tutor_id\":34,\"is_new_user\":true}', 'sent', NULL, '2025-09-22 04:57:06', '2025-09-22 04:57:06', '2025-09-22 04:57:06');



INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_08_10_203737_create_pets_table', 1),
(5, '2025_08_11_203735_modify_users_table', 1),
(6, '2025_08_11_203736_create_veterinarians_table', 1),
(7, '2025_08_11_203737_create_pet_health_conditions_table', 1),
(8, '2025_08_11_203738_create_blood_requests_table', 1),
(9, '2025_08_11_203738_create_donation_responses_table', 1),
(10, '2025_09_21_184412_add_professional_card_photo_to_veterinarians_table', 2),
(11, '2025_09_21_193414_create_email_logs_table', 3),
(12, '2025_09_21_220651_update_users_for_contacts', 4),
(13, '2025_09_22_011401_create_blood_request_history_table', 5),
(14, '2025_09_22_013158_add_admin_fields_to_blood_requests_table', 6),
(15, '2025_09_22_013451_modify_status_column_in_blood_requests_table', 7),
(16, '2025_09_22_013850_add_compatibility_fields_to_pets_table', 8),
(17, '2025_09_22_014215_add_blood_type_to_pets_table', 9);

INSERT INTO `pet_health_conditions` (`id`, `pet_id`, `has_diagnosed_disease`, `under_medical_treatment`, `recent_surgery`, `diseases`, `created_at`, `updated_at`) VALUES
(26, 27, 0, 0, 0, '[]', '2025-09-22 04:57:03', '2025-09-22 04:57:03');
INSERT INTO `pets` (`id`, `tutor_id`, `name`, `breed`, `species`, `age_years`, `age`, `weight_kg`, `blood_type`, `weight`, `health_status`, `vaccines_up_to_date`, `vaccination_status`, `has_donated_before`, `photo_path`, `donor_status`, `status`, `rejection_reason`, `approved_at`, `created_at`, `updated_at`) VALUES
(27, 34, 'Canino No 1', 'Canino No 1', 'perro', 3, NULL, '35.00', 'No determinado', NULL, 'bueno', 1, NULL, 0, 'pet_photos/aQ7GFwbTRVIUaFKDIbFQAqzRP53cPyYO11bCETK4.jpg', 'approved', NULL, NULL, '2025-09-22 04:57:03', '2025-09-22 04:57:03', '2025-09-22 04:57:03');
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('907BzS10BOmmZB9j8V27l6uluuXBcbJV0uzEaD4M', NULL, '127.0.0.1', 'curl/8.14.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZTJWYlc5RzZFVFlEbzdLZnU2ejJ0aXBJNGh0c1l1ZmJ6bDlndlowNCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wb3N0dWxhci1tYXNjb3RhIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1758517351),
('ADFuOFPV2dVkDqETfPzkTBRnSm3Bc4LCf34ofvoJ', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOG51bzg5dVM0c25FNzFVUlRBaDk4alRXVldXNEo4cVQybTF3Ym92SCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wb3N0dWxhci1tYXNjb3RhIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1758517317),
('DENpTu7uTVPKb2idesm3CrMcU8ldggojSG4rWyLo', NULL, '127.0.0.1', 'curl/8.14.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidWZyN0hFOHI2T21SdUFhVFFvem9XcVZOUXpkaTJQWVp2T0Y1THZrcSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1758516947),
('fSZCzt3zq6LOP5zKm91SrnKhoHDuVDDDYR7zXF5m', 32, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQXVHcTRZSVFIdGpjblZQYnRJOVE0QUgxeFBtMmxUckJDYmxsYVo0OCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zb2xpY2l0dWRlcy1hY3RpdmFzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MzI7fQ==', 1758519142),
('gf5Fwq1h45zAR921p6wnxQdOkoBWEoSsJjSPyMMF', 30, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiOE8xNDNDT1BDV1JNQWh0TGwwSHdUMzBsNm82aWxTbU9aZXhjb0VQRCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjMwO3M6MzoidXJsIjthOjE6e3M6ODoiaW50ZW5kZWQiO3M6NDM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC92ZXRlcmluYXJpby9kYXNoYm9hcmQiO319', 1758515745),
('iVazmhbix4vt2MkhwnLHuohKWV59efYHAwnkoYmS', NULL, '127.0.0.1', 'curl/8.14.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiU2xUdENPMUJPQXBiS1k1OHBTN2Jnc1pwZUlLbVFoSzRjOWFIYUpCTyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zb2xpY2l0dWRlcy1hY3RpdmFzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1758516887),
('jAm4ivwZ2Q1KYgGtdHromLLtXwxstgI8zrKgr9Ww', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiZmJxY3dEUlRtVmpCMzQ5M0tZQjNKTG9TM2Nib0R3S1VHbG5EdjlOcSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozNzoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluL2Rhc2hib2FyZCI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjM5OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYWRtaW4vc29saWNpdHVkZXMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1758520826),
('kbVRjuf3vuwCpDC57ogjq4YbQAA6wDrp5aaYd4oi', NULL, '127.0.0.1', 'curl/8.14.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQ1F5UndsVXdpOU5wZXNEbzE2RUQ2U2NTMDZadTJOVnE5c1V4Z3ZPWSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zb2xpY2l0dWRlcy1hY3RpdmFzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1758517342),
('lUBCk0XYJLELvqduTl9ar4k9tOisnHjelmGA6qi0', NULL, '127.0.0.1', 'curl/8.14.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSUJJREtYYU9wZk1TZFBDNkRmanZBTnJ5QUpnVTVVaGp6eEt0YlRuaSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zb2xpY2l0dWRlcy1hY3RpdmFzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1758516954),
('lwDGRZN2eapkZoItsTePQMhYNR3dh0eSX5rc7GdE', NULL, '127.0.0.1', 'curl/8.14.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicTVoVng0T0JmQTl5clBmUjVmbUl0YWlDMDJjY1k1T2tmTHNxVlY4MyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zb2xpY2l0dWRlcy1hY3RpdmFzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1758517905),
('PQ4aAkKgUFcCOgdUWN5LKenJuJm8hUH1TNnaWrzd', NULL, '127.0.0.1', 'curl/8.14.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTWIxUm1tek44S0ZQdzU4N3pNWDFCd1RkQ2lGVVBFUkRLMkZLaGhtZiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wb3N0dWxhci1tYXNjb3RhIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1758517912),
('vfZOiHNBGN0eZWADpS0t6nCbyXgt5SNlnhBJxxQL', NULL, '127.0.0.1', 'curl/8.14.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOTR6dUJmS2tDbE9CZUxJb21wTXR2TE9oUEZzOElDYm9jWVhwb2FOeCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1758517876);
INSERT INTO `users` (`id`, `name`, `email`, `phone`, `document_id`, `role`, `status`, `approved_at`, `email_verified_at`, `password`, `can_login`, `remember_token`, `created_at`, `updated_at`, `approved_by`) VALUES
(1, 'Super Administrador', 'admin@bancocanino.com', '+57 300 123 4567', '12345678', 'super_admin', 'approved', '2025-08-11 20:50:30', '2025-08-11 20:50:30', '$2y$12$HzFUT6RH4zAv7AWP/tH6xuzLhOow0Qdb9P2kACroB33HGIeNwzJ2a', 0, NULL, '2025-08-11 20:50:30', '2025-09-21 18:04:27', NULL),
(31, 'duverOuuuuu', 'duver20ac@outlook.com', '323232', '329038232', 'tutor', 'approved', NULL, '2025-09-22 02:28:20', '$2y$12$o7QIRaVckcF1YM68F92bPuBqgX4u8X8SKNvWU0nXR1odZYCH5iMxq', 0, NULL, '2025-09-22 02:27:14', '2025-09-22 02:28:20', NULL),
(32, 'Veterinario Dr Duberney', 'duver20ac@gmail.com', '30087093993', '1005157381', 'veterinarian', 'approved', '2025-09-22 04:30:49', NULL, '$2y$12$vX5u/LyIvVWwH7YlXdFnR.b7CAQ8Lf9nbjqDMrK3NaCrQBABLpkNC', 0, NULL, '2025-09-22 04:25:02', '2025-09-22 04:30:49', 1),
(34, 'Duberney Hernandez Corzo', 'duver20000@gmail.com', '3007689242', '1005154734', 'tutor', 'approved', NULL, NULL, '$2y$12$OltVybBTrZgrr.zWdJj9OOr9M2eK1NEJZxsxZ3cu0n2Eo12ug8nQ.', 0, NULL, '2025-09-22 04:57:03', '2025-09-22 04:57:03', NULL);
INSERT INTO `veterinarians` (`id`, `user_id`, `professional_card`, `professional_card_photo`, `specialty`, `clinic_name`, `clinic_address`, `city`, `rejection_reason`, `approved_at`, `approved_by`, `created_at`, `updated_at`) VALUES
(8, 32, 'VET-30032', 'professional_cards/W3ryMVKuxZg483r0WiGFZ3yFrS795jUoFR8BmrPS.jpg', 'Cirugía', 'PetFrenly', 'Carrera 31', 'Bucaramanga', NULL, '2025-09-22 04:30:49', 1, '2025-09-22 04:25:02', '2025-09-22 05:31:52');


/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;