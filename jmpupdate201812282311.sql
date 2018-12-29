-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Generation Time: Dec 29, 2018 at 09:10 PM
-- Server version: 5.5.42
-- PHP Version: 5.6.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jmp`
--

-- --------------------------------------------------------

--
-- Table structure for table `jmp_approval`
--

DROP TABLE IF EXISTS `jmp_approval`;
CREATE TABLE `jmp_approval` (
  `ap_tr_id` int(10) NOT NULL,
  `ap_usr_email` int(10) NOT NULL,
  `ap_sent_time` datetime DEFAULT NULL,
  `ap_status` varchar(15) NOT NULL,
  `ap_insert_time` datetime NOT NULL,
  `ap_approval_time` datetime DEFAULT NULL,
  `ap_comments` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jmp_approval`
--

INSERT INTO `jmp_approval` (`ap_tr_id`, `ap_usr_email`, `ap_sent_time`, `ap_status`, `ap_insert_time`, `ap_approval_time`, `ap_comments`) VALUES
(1, 0, '2018-11-16 20:33:48', 'APPROVED', '2018-11-16 20:33:48', '2018-11-16 20:36:09', 'APPROVED\nProceed\n<b>vgiron</b> - vgiron@gmail.com\n2018-11-16 20:36:09\n'),
(2, 0, '2018-11-18 15:07:59', 'APPROVED', '2018-11-18 08:03:07', '2018-11-18 15:29:06', 'APPROVED\n<b>mjoel</b> - mjoel@vodacom.co.tz\n2018-11-18 15:29:06\n'),
(3, 0, '2018-11-18 16:41:30', 'APPROVED', '2018-11-18 16:41:30', '2018-11-18 16:56:49', 'APPROVED\nProceed\n<b>mjoel</b> - mjoel@vodacom.co.tz\n2018-11-18 16:56:49\n'),
(4, 0, '2018-11-18 20:11:39', 'APPROVED', '2018-11-18 20:11:39', '2018-11-18 20:12:44', 'APPROVED\nTest\n<b>mjoel</b> - mjoel@vodacom.co.tz\n2018-11-18 20:12:44\n'),
(5, 0, '2018-11-30 14:11:04', 'PENDING', '2018-11-30 14:11:04', NULL, NULL),
(7, 0, '2018-12-08 18:22:29', 'PENDING', '2018-12-08 18:22:29', NULL, NULL),
(8, 0, '2018-12-13 18:39:57', 'PENDING', '2018-12-13 18:39:57', NULL, NULL),
(9, 0, '2018-12-14 19:38:53', 'PENDING', '2018-12-14 19:38:53', NULL, NULL),
(10, 0, '2018-12-26 18:48:57', 'DISAPPROVED', '2018-12-26 18:48:57', '2018-12-26 21:54:03', 'DISAPPROVED\nNo\n<b> Charles Desmarquest</b> - desmarquestc@vodacom.co.tz\n2018-12-26 21:54:03\n'),
(11, 0, '2018-12-26 21:57:18', 'PENDING', '2018-12-26 21:57:18', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jmp_attachment`
--

DROP TABLE IF EXISTS `jmp_attachment`;
CREATE TABLE `jmp_attachment` (
  `att_id` int(10) NOT NULL,
  `att_type` varchar(20) NOT NULL,
  `att_name` varchar(255) NOT NULL,
  `att_ref` varchar(255) DEFAULT NULL,
  `att_timestamp` datetime NOT NULL,
  `att_status` tinyint(1) NOT NULL DEFAULT '0',
  `att_og_name` varchar(255) NOT NULL,
  `att_usr_id` int(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jmp_attachment`
--

INSERT INTO `jmp_attachment` (`att_id`, `att_type`, `att_name`, `att_ref`, `att_timestamp`, `att_status`, `att_og_name`, `att_usr_id`) VALUES
(1, 'DRIVER_LICENSE', 'a21a2d4a22e0e566520d8116a77a5ec1.jpeg', '64', '2018-12-28 11:11:15', 1, 'test', 64),
(2, 'TRIP_REQUEST', 'db6c91f78884d3b6b3612e9a819fc3ef.jpeg', '1', '2018-12-28 14:07:33', 1, 'test', 64),
(3, 'DRIVER_LICENSE', '198b06efc5c9af5dd363df3727ee97b3.png', '8', '2018-12-28 17:45:22', 1, 'test', 8),
(4, 'TRIP_REQUEST', 'a08a55409165dceb17ab3a7e359a62a7.png', '0', '2018-12-29 20:11:59', 1, 'test', 64),
(9, 'TRIP_REQUEST', '0964abd79efd0eea49d57fe1e90fad0f.png', '0', '2018-12-29 21:05:59', 1, 'test', 64),
(10, 'TRIP_REQUEST', '0d10bc360083796348facbe204712a9c.png', '2', '2018-12-29 21:07:53', 1, 'test', 64);

-- --------------------------------------------------------

--
-- Table structure for table `jmp_authoriser`
--

DROP TABLE IF EXISTS `jmp_authoriser`;
CREATE TABLE `jmp_authoriser` (
  `auth_tr_id` varchar(10) NOT NULL,
  `auth_usr_email` varchar(45) NOT NULL,
  `auth_comment` text,
  `auth_status` varchar(50) DEFAULT NULL,
  `auth_approved_date` datetime DEFAULT NULL,
  `auth_sent_date` datetime DEFAULT NULL,
  `auth_insert_date` datetime NOT NULL,
  `auth_proc_st` varchar(150) DEFAULT NULL,
  `auth_email_notification_sent` tinyint(1) NOT NULL DEFAULT '0',
  `auth_usr_title` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jmp_authoriser`
--

INSERT INTO `jmp_authoriser` (`auth_tr_id`, `auth_usr_email`, `auth_comment`, `auth_status`, `auth_approved_date`, `auth_sent_date`, `auth_insert_date`, `auth_proc_st`, `auth_email_notification_sent`, `auth_usr_title`) VALUES
('1', 'fedriani@vodacom.co.tz', 'APPROVED\n<b>Fedriani Luis</b> - fedriani@vodacom.co.tz - 2018-12-28 21:59:20\n', 'APPROVED', '2018-12-28 21:59:20', NULL, '2018-12-28 00:00:00', NULL, 1, 'Director: IT&Billing');

-- --------------------------------------------------------

--
-- Table structure for table `jmp_department`
--

DROP TABLE IF EXISTS `jmp_department`;
CREATE TABLE `jmp_department` (
  `dept_id` int(11) NOT NULL,
  `dept_name` varchar(100) NOT NULL,
  `dept_hod_ad_name` varchar(100) DEFAULT NULL,
  `dept_hod_full_name` varchar(100) DEFAULT NULL,
  `dept_hod_phone` varchar(15) DEFAULT NULL,
  `dept_hod_email` varchar(100) DEFAULT NULL,
  `dept_status` varchar(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jmp_department`
--

INSERT INTO `jmp_department` (`dept_id`, `dept_name`, `dept_hod_ad_name`, `dept_hod_full_name`, `dept_hod_phone`, `dept_hod_email`, `dept_status`) VALUES
(1, 'IT & BILLING', 'itbillhod', 'Itand Bill', '255700000001', 'it@hod.tz', 'ACTIVE'),
(2, 'NETWORK', 'networkhod', 'Network Hod', '255700000002', 'net@hod.tz', 'ACTIVE'),
(3, 'CBU', 'cbuhod', 'Cbu Hod', '255700000003', 'cbu@hod.tz', 'ACTIVE'),
(4, 'CORPORATE AFFAIRS', 'corporatehod', 'Corborate Affairs', '255700000004', 'corp@hod.tz', 'ACTIVE'),
(5, 'FINANCE', 'financehod', 'Finance Hod', '255700000005', 'fin@hod.tz', 'ACTIVE'),
(6, 'HUMAN RESOURCES', 'humanhod', 'Human Resources', '255700000006', 'hr@hod.tz', 'ACTIVE'),
(7, 'MD EXECUTIVE', 'mdhod', 'Md Executive', '255700000007', 'md@hod.tz', 'ACTIVE'),
(8, 'CUSTOMER SERVICE', 'customersv', 'Customer Service', '255700000033', 'cs@hod.tz', 'ACTIVE');

-- --------------------------------------------------------

--
-- Table structure for table `jmp_drivers_profile`
--

DROP TABLE IF EXISTS `jmp_drivers_profile`;
CREATE TABLE `jmp_drivers_profile` (
  `dp_full_name` varchar(100) NOT NULL,
  `dp_phone_number` varchar(15) NOT NULL,
  `dp_email` varchar(100) NOT NULL,
  `dp_dept_id` int(10) NOT NULL,
  `dp_section_id` int(10) NOT NULL,
  `dp_license_number` varchar(255) NOT NULL,
  `dp_license_expiry` date NOT NULL,
  `dp_created_time` datetime NOT NULL,
  `dp_updated_time` datetime NOT NULL,
  `dp_status` varchar(15) NOT NULL,
  `dp_medical_by_osha` varchar(5) NOT NULL,
  `dp_medical_date` date DEFAULT NULL,
  `dp_ao_title` varchar(255) NOT NULL,
  `dp_usr_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jmp_drivers_profile`
--

INSERT INTO `jmp_drivers_profile` (`dp_full_name`, `dp_phone_number`, `dp_email`, `dp_dept_id`, `dp_section_id`, `dp_license_number`, `dp_license_expiry`, `dp_created_time`, `dp_updated_time`, `dp_status`, `dp_medical_by_osha`, `dp_medical_date`, `dp_ao_title`, `dp_usr_id`) VALUES
('Fedriani Luis', '255754711644', 'fedriani@vodacom.co.tz', 1, 14, '400012344', '2019-02-28', '2018-12-28 17:45:28', '2018-12-28 17:45:28', 'PENDING', '', NULL, 'HOD: Corporate Security', 8),
('Mike Sanga', '255764192010', 'michel.sanga@noxyt.com', 1, 14, '1400012344', '2019-04-30', '2018-12-28 11:41:28', '2018-12-28 11:44:28', 'APPROVED', '', NULL, 'Director: IT&Billing', 64);

-- --------------------------------------------------------

--
-- Table structure for table `jmp_email`
--

DROP TABLE IF EXISTS `jmp_email`;
CREATE TABLE `jmp_email` (
  `id` int(11) NOT NULL,
  `_to` text NOT NULL,
  `cc` text,
  `_from` text NOT NULL,
  `subject` text NOT NULL,
  `email` text NOT NULL,
  `attachments` text,
  `_status` varchar(50) NOT NULL DEFAULT 'RECORDED',
  `record_date` datetime NOT NULL,
  `type` varchar(150) NOT NULL DEFAULT 'NOTIFICATION',
  `jo_id` varchar(150) DEFAULT NULL,
  `sent_date` datetime DEFAULT NULL,
  `last_update_date` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `proc_st` varchar(150) DEFAULT NULL,
  `proc_status_nt` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `jmp_firebase_tokens`
--

DROP TABLE IF EXISTS `jmp_firebase_tokens`;
CREATE TABLE `jmp_firebase_tokens` (
  `ft_id` int(20) NOT NULL,
  `ft_user_id` varchar(255) NOT NULL,
  `ft_token` text NOT NULL,
  `ft_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jmp_firebase_tokens`
--

INSERT INTO `jmp_firebase_tokens` (`ft_id`, `ft_user_id`, `ft_token`, `ft_timestamp`) VALUES
(13, 'vgiron', 'cYFdi09p5Uk:APA91bFQ_f3iVhaZ8am6QSXEA3cMWzkcQouMElcwAlZ9OrrxTr7QaM7zSv0b_RK8TxXJVWsmNL56NxZ1hxNgxfz6n2zA0MxWIk9qHKace-e2jTqTq1W6y9FQAZWDKbrP2jX9fHdDMjFI', '2018-11-16 11:48:12'),
(20, 'mjoel', 'drOuey5QwYY:APA91bGLtDMMUf-GgTNBSNHRta-RuBYFVtXoR15P-IyaIkuh0wyYkDHqnjsQcy9xTUu58ivYuOPXa3rqWo8G_DaG5yCPB4dRyK_m-6kEMTZpN4xltSWnOraU5md5RDU0mOq18lskoNt8', '2018-11-18 13:56:01'),
(21, 'cayo', 'fELYZIs8YN0:APA91bFM23wULYTSVkmNmWNpdBWBVIPWzsuqE5khgKCtpGhcF-zi3VQFwr1RAxM08qKuwxUnuR58S6A2WCEsxMQL27tQ98YFatW43EKIqOlJi-9CmBIyC0LlX9GS4y-kwl82lJM50Bu7', '2018-11-18 16:52:55'),
(22, 'mjoel', 'dvWn2F8PZ3s:APA91bGYB74ak3CKOs-lOiNhkAVEWQva3NRrjALX3AZ-cbhY5b9o8rQ_r7CMt8z70Ek9L0bcDEESgr2wcVtJjcnWjSV3haJtwbxbl9uoSOkWsftcvc1_9xvIuOtx0NuQByb0s7U47yVu', '2018-11-18 17:08:59'),
(23, 'mjoel', 'e4ioLZ6-KXk:APA91bEGWOt9QfqoU2s8NjYXfUiLv4_Rc-viUux2U5EDJvAwPhCRY1OqbXz_m_PxFHDzHb1ReE4U8IWhdZQLVD3c4BxqQAyU9Cs-4z3etka71DDmxk1Rg-gt1YqKoO01oChELhDe-BP2', '2018-11-19 08:24:37'),
(24, 'mawalai@vodacom.co.tz', 'cW9XPTsfNUw:APA91bF9K3bRTZMMplnUP96qM4djxQdVWqET_ltssuWJQeS4pxljNzDSR3hcwhWLkIFKKgsAk3bFkQkIq54s03--FiYwkNZSdYCmlTLYZS_0_q2AfUu5A17H5-HqfyK51OAK-Y7KsErT', '2018-11-22 13:29:37'),
(25, 'marab', 'efD7psfUv38:APA91bHuJGLa2HnUlcuj31X88IO9pRw50iqhl8ByM0so_S65Cc703rNm71lbK-xbO_ZAJKWzPfEHHAzFM4qoP1iHRIqlkFcfV8OtcGv0BywJPIvs1a58yKDsexMYRCUtfVec--hNiMdA', '2018-11-22 13:31:37'),
(26, 'jikate@vodacom.co.tz', 'dEhFwp_On0k:APA91bGy34Y1lYx7-hPSUbodogVbLU3EvOmUeahg-kFX9KDTQVQUtxsGNsp6eoMsfAY-fGun_-67k82z8SnJrDL7H-uiswkjmd61Agshtp_poqC__VAY5hVZOuhlxN7ee6zh4KdVUWTd', '2018-11-22 13:33:11'),
(27, 'esagenge@vodacom.co.tz', 'fenapZdKNF4:APA91bFB9KQkcD-ihM8CsG6NEvMNtKFr7SylhcR8K5JPuUP5wE84Fj0yKNRhsP9caPJAHjMzunf37WoZT5l6od7Z-uvggV04lxcB2FNRsw4l37oRfzLJhHdzfe-l_q52wVJdAIaW97P9', '2018-11-22 13:35:31'),
(29, 'amris', 'cJp3YxumfiE:APA91bGCe72335gHCStPLmUfudUmKM94LP0dQo9FTD0nZQQaRQuiFYcV5o0p4QCgy05SdSStdl-B0itSkYJuNy_7TyTXKjJGAqEf725KDQEO6sn8NeeKGrn2THqIVZA4rxnxNnj8CtvZ', '2018-11-22 14:28:53'),
(30, 'kilumangao', 'egooxd6hO0I:APA91bEu6niFrKjHOSPc3Mz6LOpXiwsMWd-3B8AwpzEFEreeuMNQbhduQ9GlhV_Q1pcV3skkC8TXZJRFrMNZzAV-r__Ppjpfr7xD_HfMpvlwJ66TH8wfyx-cJ1c_uZUQnkXXdKZckqRz', '2018-11-22 14:49:43'),
(31, 'amariki', 'defYC45Ihuc:APA91bG3cCKH6NhFLMY-cfcavyBpupGntBjxLSOUTaotkd-a35tM9Ju52TNARbNhyL2ENCupYMclYFGcbQWbYxXKVYcn5VpLDa6tHOAqAWO7eBpWh3iptTYSu7gaQYwtKvpHNLS7Sr_S', '2018-11-22 15:14:14'),
(33, 'mmurugwa', 'd-V_WxOS2s8:APA91bG736pJewpRRwXhvn9kJQad1htffnskWynUtHnMfOTMpAE2RlrCiboaJclmFHxZV2vHfkrBlNAh9Rz81KgTa9C4Z6GHb_btGAwpRux-_eNR7yXvFHat0kIjfwfS3-Ga75ssp1tB', '2018-11-22 15:25:30'),
(34, 'bmusabila', 'c8e8kK2Wy3Q:APA91bHAM_7TamAZbZyYtWRAVCCtp7Mo8fPOkULlu6r5qsBrId87-shHTBbWWFBjl32hlZbfa6ttC0ZC-KZyJqulIYs8jl1jBeo6L2kZ4YRHNwPiOg49HOEbsqQ-017SxFWLgk8vi-AT', '2018-11-22 15:31:33'),
(35, 'kalufyaa@vodacom.co.tz', 'fN6xjCrhyf4:APA91bFrZNAbX639g8yhmuH5LA8Fv3Xt1KkpteHO5VZOWpW84Ra3pauGDx5ioWrZAceSfqccgdkaQEwpAqPwyWnoGJdr1eRahc8oYsb5e9CAmggOonhR6HR35rj9HWsHQ1XWDW4CsXWM', '2018-11-22 18:26:29'),
(36, 'amwenisongole', 'd2Z1pUYrjAU:APA91bHAiw1htiPEBJPOz00yIUYWTzP88IsPDMf_yV2GYIi84ycPYLqyehwuv36mNQGawJnRuqnNG8Sr5N37IIn6fcEBmTUZKZPBos6nRU4-N7H3GDJ2MNjZOQmUUz5n_OMC5NRuClBl', '2018-11-22 18:40:19'),
(37, 'nyandag01', 'eRrVzlpYOuE:APA91bF6B_YZGoiEoNmoYim3XoWPFdrw3JMNJJpKmk3Fqw7Zh1A6w5vG36Vpiy4ONCbvk1DV8fQPJ8SQct5M5SyfA_05-xxK3g0HVamTXFEBl-Gt9890jPlnb3opKyrgpOGke2uVxgJF', '2018-11-22 19:18:16'),
(39, 'urassao', 'coX_3d_fcB0:APA91bFhJr0pS3n1EIuwzRnP-rTvZDOBI-RizE5A3qTgtlJfWrURUmsTZRpE8K0ypqz0zIC6Gjfz1JKKrP40lzwTVnNogTGY3juDuYoythQOSH9w0v17oWpphOecSxFyG_HqbJH7CJ_P', '2018-11-23 04:56:03'),
(40, 'lugatag@vodacom.co.tz', 'fHY1Sv_aS0s:APA91bH_wx5mEI4xiDk48A9UHpLO9JIZbcQejlU-6SmzgPTdTKIBl0H5-DnKQ-xz2jfxQMU4mIDjHUCcu9ZJK80cpTJPEQeJtrh5W9x8Ol6brDVvwQl9hteUJzwG0KBFSQvowfb3C4Rl', '2018-11-23 06:32:28'),
(41, 'ymngagi', 'eagK_enon_g:APA91bGHwR76ZZWJXmEBHS8KEV3ZO1mtX9Hn2YwT0c7-FsvciDESM8q3WbX3WnrPi6odqOHA2Z0BNz9yC-iQJv6DnkVywTlhHhsDct9L4PRMY1-yjoqLePgHVDX65eaencNhJph6TdiY', '2018-11-23 08:16:48'),
(42, 'cminungu', 'cjnE4-_eASQ:APA91bFmWu1wQ3LGaJXArz-ud9x-rVDL5eoR9lRq03KJpp3vAdtOERZLVTJXZPPUsaldp-5MfM66fMz2yv4OUgozSV_8flLuiXRLKH3lhfbnIqSLOvk-Eea37iPyyFpDSOUH82T_-JhW', '2018-11-23 08:53:55'),
(43, 'mjoel', 'cUT0giIirh4:APA91bH7Twem7ABuhitgNIQpXYTdOpoJb0AQlzZ4yEQ5-ZikDw2lCdxY3jAodxL8McSzr6RHTjOpxD-WaF9oFFc4pGMJodPSZiqU57kfjPNBJ5pkhGtlHOWBBbkxc3I1AeYQ7w_NTryz', '2018-11-23 09:14:09'),
(45, 'gmtesha', 'ercFuce_Z3s:APA91bF66gmDnTSzQbV6iSXPPbg_W5SmLOoAYbqVugIbHmM84dpZJ37rW6j4trkF65BAz8UD6e61asK5WJIeCdokUaFehif4z6DKa1fRvSzfekT37urDW1QAhXqu_bYUOJQlWQIgugNd', '2018-11-23 16:48:46'),
(46, 'kombeb', 'eN9HEO8xOzI:APA91bETcqf8DaSh3Yl6XIUxZM5-mU5BKp5g-OJB29dhXOidEcbWe5caU5HUTMeBt87GyL8mDv70Pyn9ktjC9tJu3LlQgDa7urLNIWoTZh5Q1rrlwD9tBf6se8Z4l0ezVareXd3oYkAR', '2018-11-23 22:10:08'),
(47, 'lkatamba', 'c-iwZSneLng:APA91bGBKf7bx1dXlvhOP_WIQGW3X3O4b4HkmBla38XMjY--fIE2JINIyDMP-tJCniMA0dOVCWArHX1jmMKX3cOj1co_aDotrXLj-BqqzGuFV_FhEnxQPMwtfB9jAL0j86fE8mSFuPsY', '2018-11-24 12:31:45'),
(48, 'cayo', 'eJfVcQtr0gg:APA91bFvNLTpP_dGsYZSzdh_BiS6nzCmG-y9iVZbvl4bogaVh67f-N25oa4W1dpEfj_fUdlaHZqLo34ROYw5mZHqMDzChCyrIXU-kS22Let2lAZeg46RcN01oAcYEqfiKp00ecB97L5A', '2018-11-24 15:12:43'),
(50, 'fkamazima', 'e8EKVR3kMdo:APA91bErulxJGwujCOtuSRqEggOtXDlNZKAyWuPh5GV7L4t9V0xC9Batvjq0N0OLbHOEDkKKJ08s88kPfjbM6gsBflKT0KcloBaRPGZtaVmMVI6zLa_vB8qh8FoAJjErgKQKr_cbyoNn', '2018-11-27 16:58:50'),
(51, 'mchanila', 'c5lS9UvXcFs:APA91bHBF9pwtJVIO_YuUrLSPnZ8quD3BxYAOKGfYkyJ1elh1T2TBaUMvPEW6WxBc6XEV-HyHGVmCq1V1epVM6-zKY_GE1tiHLFHpgPuAFYr2EVTjaRqIx-cOl-SezjUJ1Oh6xiziCi9', '2018-11-28 04:35:21'),
(52, 'rmbogoma@vodacom.co.tz', 'f0oPYjbKOx0:APA91bHVo9Ply6-AbD1Vny2b0kDJ1vzSisX8QHC2EMDOtZBDm-R850GYa8RQ2sjUMNPE-SALNDmFXBT5hUuN9dhFKIZunWRxtl7Ol_W3eVoAwP5vhCMK8nfkLF1YruVPb9WN-xil56oz', '2018-11-28 13:11:36'),
(53, 'abillae', 'ePvmglircsQ:APA91bGjbpqQnk0LinN40VVcRZuhVaBdxK8M1k5r4XhjHawgBk4Vq2WbL553yAx4xZ1eUuPyBmw2vlGIKq_TMnMy4ywKpP8u90R69uyXdngxyB71TrdHFwPT47kHYCMvJLr2EhzqLxtR', '2018-11-29 08:12:55'),
(54, 'theonast', 'd6DnMVjv6lI:APA91bFXO477-9ALqP1mcVDGPLvUV5kx7W-pL547gzxIXgNShm4yUWHx3BOA04SdGZScibVxDLY5eHVzo3YsKWVSQSp0p07Fun1hlYCLT0a3Zfu6x6nDuY5x-44ny6VKxZdC2VZBgreI', '2018-11-29 18:53:53'),
(55, 'kajerib@vodacom.co.tz', 'd_w47rotvfo:APA91bGjQiRMZKl7vNZaqZoUVHXOFE16q1L9-hKybzq8PopIoD4yUfqRXBSVc-7eQPNAmJ2sIBDHXDF_JUgT4M5P-k1SfClvzQ3m4kmqPDRnpuKbMEgLqdlRtuJ4n5uM5-r5c6Tg9wqQ', '2018-12-03 11:34:34'),
(56, 'bstephen', 'fHTqzRSLbc8:APA91bEuI_PGaLxu-HnE5dZYSoxcn9IfPb36zzk9_3jRCWClqTLLQerrC4PdzhXZ2LiS9lhXc-RD1MXb8-JAjd3fbuUnRhSxt3UvVcis6m-iG7omGjiH3DpEaKzGjW8QDbRb0pFB8g--', '2018-12-04 04:55:11'),
(57, 'smchau', 'efA9fDgA4Mk:APA91bHMLNcv2F3aWICIc7ddhp-6kT0a2D0H6Ofx9PBOmbNSGt3v_I2nvWfUTwlWQtk2p0ZT0CNG-coGdADblGex0iL_uDSGiM3P0FvbIIqudkeBlYpAzckhzuQk0-coLJl_3v601uzJ', '2018-12-04 09:19:13'),
(60, 'nungwie', 'fY0h6wX_NXM:APA91bEpfCxNAwtEgeKtRkZ-3sKyx8lP6iAvXRvkA-PC3tWUpPfzGOLlDl6VLgvVeOzQmZXDyaqNw1QFrdgnFH67A_vwu3NBeA9EOm1B55DxeN_rVLcDQru6FiQkHfX0DW28tma-jL4l', '2018-12-06 11:10:42'),
(61, 'mwinyihatibum@vodacom.co.tz', 'df3b3cq0bI4:APA91bEDiv-yUc5TX6fKes-2XCUV42RuyQZxNKQ2aLWLDhAOjL8VSEfDU06jg0Ch3bW39b86j7_NVVnpwyCicths-N3DZhLbsekUcD3QnnwyS763zZuj0woCAmhv-bHGCaFelwVwSEwZ', '2018-12-06 11:34:41'),
(62, 'esagenge', 'c8FRMASDbHg:APA91bFRp6wCzrH9frcapqvKUpAulvLgCuQO7J_0ndjIjhgJnf-R_KHNVZQ48U_qOl0U4Hbn9tyNjDSV0FPVU1f2V2xZzuhIJABmyFufC8YZtHlOHtj7Q98UFEJbP8P0JeTbNjIAzkWt', '2018-12-09 06:11:07'),
(63, 'urassao', 'ceLpaHc-NNQ:APA91bH7ICBOGiwSI5DqR-mDnvuTc54rG4A6s-mW6pkF4E1Gyjy7se2vqTVFJX50Y_J5i1oYkgTaZBWvjo0dp6dXyezeWcVRHfau-gfjoIQ3iDqo5o-H1gKIKYRKY80pU0D4GzF1T6ss', '2018-12-10 16:44:32'),
(64, 'atemu@vodacom.co.tz', 'fO1vhxU2Sx8:APA91bFn3joIgPuKkjCSCS8n0vKMFaSCq5A1fUCAOjuRVrLE3QTBhYWszoNuVxpYO3ziLqFWQbkD8FpjYBK_4HQe1ghxVK9EcI-NEkkbSq19FAYsCYAYVazVCOn1th6x6dQnQNXAEWS_', '2018-12-11 08:09:21'),
(66, 'amris', 'eYwHLO8Iin8:APA91bF3wSySTP59c8RS7B9gbsibN3kVFd2x70phHPPo31RqKbG7FgXnD72cNqD87sUmkA6LGFFpNLfgimPJDbW5Tqfw5xM_EWjMX3gNTUO3IwjqpbO9R_uHFw7OtsQPMRU-CSJhzXJo', '2018-12-13 16:41:00'),
(67, 'sademba', 'd9oRp9UxfoM:APA91bEqEK4RsYyeHgDIc-TWVxUs-8wF4CrYGMvWj-JQJ9DHZEe8hvFDwADefcWwbBkbxqwBiCi3HAVAG7ZrjWqtbCTrZ_I58PRxKqt-2U5YhH7_W5QGHmw5fea1U50JIsPrZhI_PC8p', '2018-12-14 06:45:56'),
(68, 'pchinyama', 'eyzqnnkkyEc:APA91bHTHW3dbVw3pwlEsLYH_CYVuiSE6-zRZSQgc2UBCXrgKa8WQXN3Ada4lppuy84CPqaUOcoVFheS8FBISaDZPNRWkBPwHzKb_mh-ESh38vgE5Efx_IPHPIQ41MH4l_7h2YgnxefV', '2018-12-16 14:13:21'),
(69, 'lingaf', 'czZKZ45WvGg:APA91bHp20NheeJ5yJlQ5vVpiC7oBzvePY45346jlxUrItuIOrqonJQw9WZ4LC8CvXjjR_GeAbOT2CZkIqOH0aIJoQ2mTnY2FSVvANjj_ETnlz9W_YeXewxIzROXc19WaBz4X6a2Soei', '2018-12-17 17:03:25');

-- --------------------------------------------------------

--
-- Table structure for table `jmp_medical_assessment`
--

DROP TABLE IF EXISTS `jmp_medical_assessment`;
CREATE TABLE `jmp_medical_assessment` (
  `ma_emp_email` varchar(255) NOT NULL,
  `ma_date` date NOT NULL,
  `ma_upload_id` int(10) NOT NULL,
  `ma_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ma_emp_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `jmp_options`
--

DROP TABLE IF EXISTS `jmp_options`;
CREATE TABLE `jmp_options` (
  `option_id` int(10) NOT NULL,
  `option_tag_name` varchar(255) NOT NULL,
  `option_name` varchar(255) NOT NULL,
  `option_last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `option_sequence` int(10) NOT NULL,
  `option_value` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jmp_options`
--

INSERT INTO `jmp_options` (`option_id`, `option_tag_name`, `option_name`, `option_last_modified`, `option_sequence`, `option_value`) VALUES
(1, 'USER_ROLE', 'ADMIN', '2018-05-24 11:58:06', 1, 0),
(4, 'USER_ROLE', 'DRIVER', '2018-12-25 09:41:45', 2, 0),
(29, 'USER_ROLE', 'MANAGER', '2018-10-11 19:27:11', 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `jmp_route`
--

DROP TABLE IF EXISTS `jmp_route`;
CREATE TABLE `jmp_route` (
  `r_tr_id` int(10) NOT NULL,
  `r_sequence` int(10) NOT NULL,
  `r_notification_status` tinyint(1) NOT NULL,
  `r_insert_date` datetime NOT NULL,
  `r_last_update` datetime NOT NULL,
  `r_type` tinyint(1) NOT NULL,
  `r_usr_title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jmp_route`
--

INSERT INTO `jmp_route` (`r_tr_id`, `r_sequence`, `r_notification_status`, `r_insert_date`, `r_last_update`, `r_type`, `r_usr_title`) VALUES
(1, 1, 1, '2018-12-28 15:54:56', '2018-12-28 15:54:56', 0, 'Director: IT&Billing'),
(1, 2, 0, '2018-12-28 15:54:56', '2018-12-28 15:54:56', 0, 'ALL');

-- --------------------------------------------------------

--
-- Table structure for table `jmp_section`
--

DROP TABLE IF EXISTS `jmp_section`;
CREATE TABLE `jmp_section` (
  `sec_id` int(10) NOT NULL,
  `sec_name` varchar(100) NOT NULL,
  `sec_dept_id` int(10) NOT NULL,
  `sec_tl_full_name` varchar(100) DEFAULT NULL,
  `sec_tl_ad_name` varchar(100) DEFAULT NULL,
  `sec_tl_phone_number` varchar(15) DEFAULT NULL,
  `sec_tl_email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jmp_section`
--

INSERT INTO `jmp_section` (`sec_id`, `sec_name`, `sec_dept_id`, `sec_tl_full_name`, `sec_tl_ad_name`, `sec_tl_phone_number`, `sec_tl_email`) VALUES
(1, 'MD EXECUTIVE', 7, 'Md Executive', 'manmd', '255700000010', 'manmd@man.tz'),
(2, 'BUDGET OPERATIONS', 3, 'Budget Operations', 'budgetop', '255700000011', 'manbo@man.tz'),
(3, 'CENTRAL ZONE', 3, 'Central Zone', 'centralzn', '255700000012', 'mancz@man.tz'),
(4, 'SOUTHERN ZONE', 3, 'Southern Zone', 'southernzn', '255700000013', 'mansz@man.tz'),
(5, 'COASTAL ZONE', 3, 'Central Zone', 'centralzn', '2557000014', 'mancz@man.tz'),
(6, 'NORTHERN ZONE', 3, 'Nothern Zone', 'nothernzn', '255700000015', 'mannz@man.tz'),
(7, 'CORPORATE AFFAIRS', 4, 'Corporate Affairs', 'corporatea', '255700000016', 'manca@man.tz'),
(8, 'CORPORATE SECURITY', 5, 'Corporate Security', 'corporates', '2557000017', 'mancs@man.tz'),
(9, 'SCM', 5, 'Scm', 'scm', '255700000018', 'mansc@man.tz'),
(10, 'FINANCE', 5, 'Finance', 'finance', '255700000019', 'manfn@man.tz'),
(11, 'HUMAN RESOURCES', 6, 'Human Resources', 'humanr', '255700000020', 'manhr@man.tz'),
(12, 'HSE', 6, 'Hse', 'hse', '255700000021', 'manhs@man.tz'),
(13, 'FLEET & FACILITIES', 6, 'Fleet Facilities', 'fleetf', '255700000022', 'manff@man.tz'),
(14, 'IT & BILLING', 1, 'IT Billing', 'itb', '255700000023', 'manib@man.tz'),
(15, 'NETWORK', 2, 'Network', 'network', '255700000025', 'mannt@man.tz'),
(16, 'NETWORK ENGINEERING', 2, 'Network Engineering', 'neteng', '255700000026', 'manne@man.tz'),
(17, 'TRANSPORT LAYER', 2, 'Transport Layer', 'transportl', '255700000027', 'mantl@man.tz'),
(18, 'RADIO PLANNING', 2, 'Radio Planning', 'radionpl', '255700000028', 'manrp@man.tz'),
(19, 'NETWORK PERFORMANCE', 2, 'Network Performance', 'netpf', '255700000029', 'mannp@man.tz'),
(20, 'CSOC', 2, 'Csoc', 'csoc', '255700000030', 'mancs@man.tz'),
(21, 'IP/PACO', 2, 'Ip Paco', 'ippaco', '255700000031', 'manip@man.tz'),
(22, 'CUSTOMER SERVICE', 8, 'Customer Service', 'customers', '255700000034', 'mancs@man.tz');

-- --------------------------------------------------------

--
-- Table structure for table `jmp_settings`
--

DROP TABLE IF EXISTS `jmp_settings`;
CREATE TABLE `jmp_settings` (
  `st_id` int(11) NOT NULL,
  `st_name` varchar(120) NOT NULL,
  `st_value` text NOT NULL,
  `st_label` varchar(150) NOT NULL,
  `st_comment` text NOT NULL,
  `st_type` tinyint(1) NOT NULL,
  `st_validation` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jmp_settings`
--

INSERT INTO `jmp_settings` (`st_id`, `st_name`, `st_value`, `st_label`, `st_comment`, `st_type`, `st_validation`) VALUES
(1, 'SHARE_VALUE', '700', 'Share Value Per Each', 'The value of each share in Tsh', 1, NULL),
(2, 'MIN_PERCENTAGE', '0', 'Minimum Quorum Percentage', 'Minimum Quorum Percentage To Allow Voting To Be Started', 1, NULL),
(3, 'SMS_SENDER', '15300', 'AGM SMS SENDER', 'AGM SMS SENDER', 0, NULL),
(4, 'APP_SERVER_URL', 'http://localhost/', 'Application Server URL', 'Application Server URL', 1, NULL),
(5, 'MAX_PTWPROC_THREADS', '5', 'MAX_PTWPROC_THREADS', 'MAX_PTWPROC_THREADS', 0, NULL),
(6, 'SYSTEM_USER', 'ptw@vodacom.co.tz', 'SYSTEM_USER', 'SYSTEM_USER', 0, NULL),
(7, 'SMPP_SOURCEADDRESS', '123', 'SMPP_SOURCEADDRESS', 'SMPP_SOURCEADDRESS', 0, NULL),
(8, 'EMAIL_TO', 'torgenes@gmail.com', 'EMAIL TO', 'EMAIL TO', 1, NULL),
(9, 'EMAIL_CC', 'michel.sanga@noxyt.com', 'EMAIL_CC', 'EMAIL CC', 1, NULL),
(10, 'EXTENSION_APPROVER_TITLE', 'HSE SPECIALIST', 'EXTENSION APPROVER TITLE', 'The title of approver that will be approving extended request', 1, 'trim|required|callback_validateUserTitle'),
(11, 'MAX_PWD_VALIDITY_DAYS', '90', 'Password validity maximum days', 'Maximum number of days in which password  will be valid', 1, NULL),
(12, 'CURRENT_APP_VERSION_ANDROID', '0.0.1', 'Published App Version', 'The version of the app that is published in mobile stores (Android)', 1, NULL),
(13, 'CURRENT_APP_VERSION_IOS', '0.0.1', 'Published App Version', 'The version of the app that is published in mobile stores (Android)', 1, NULL),
(14, 'MIN_EXECUTION_TIME', '30', 'Minimum Execution time (Minutes)', 'Minimum execution time in minutes. Every work applied should be executed not less than minutes that are set in this field', 1, 'trim|required|numeric');

-- --------------------------------------------------------

--
-- Table structure for table `jmp_sms`
--

DROP TABLE IF EXISTS `jmp_sms`;
CREATE TABLE `jmp_sms` (
  `sms_id` int(11) NOT NULL,
  `sms_msisdn` varchar(15) NOT NULL,
  `sms_from` varchar(15) NOT NULL,
  `sms_text` text NOT NULL,
  `sms_status` varchar(40) NOT NULL DEFAULT 'RECORDED',
  `sms_rec_date` datetime NOT NULL,
  `sms_sent_time` datetime DEFAULT NULL,
  `sms_proc_key` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jmp_sms`
--

INSERT INTO `jmp_sms` (`sms_id`, `sms_msisdn`, `sms_from`, `sms_text`, `sms_status`, `sms_rec_date`, `sms_sent_time`, `sms_proc_key`) VALUES
(1, '+255764192010', '15300', 'Your OTP for  JMP App  is 1794', 'RECORDED', '2018-12-29 19:45:38', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jmp_smscontent`
--

DROP TABLE IF EXISTS `jmp_smscontent`;
CREATE TABLE `jmp_smscontent` (
  `ws_id` int(10) NOT NULL,
  `ws_format` text NOT NULL,
  `ws_variables` varchar(350) NOT NULL,
  `ws_lastupdate` datetime NOT NULL,
  `ws_key` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jmp_smscontent`
--

INSERT INTO `jmp_smscontent` (`ws_id`, `ws_format`, `ws_variables`, `ws_lastupdate`, `ws_key`) VALUES
(1, 'Your OTP for  JMP App  is %s', 'string', '2018-10-31 00:00:00', 'PTW_OTP'),
(2, 'Use the below password to reset your JMP App  acoount password \\n\\n%s', 'string', '2018-11-10 00:00:00', 'PTW_RESET_ACC_MSG'),
(3, 'An account to access JMP App has been created for you.\\nUsername: %s\\nPassword: %s', 'string,string', '2018-11-10 00:00:00', 'SMS_ACC_CREATED'),
(4, 'An account to access JMP App has been created for you.\\nUsername: %s', 'string,', '2018-11-10 00:00:00', 'SMS_ACC_CREATED_WITH_AD'),
(5, 'Your JMP App user account has been reset. Use the below password to access you account \\nUsername: %s', 'string', '2018-11-10 00:00:00', 'SMS_ACC_RESET'),
(6, 'Changes to your JMP App account has been made. Use the below credential to access you account \\n\\nUsername: %s \\nPassword: %s', 'string', '2018-11-10 00:00:00', 'SMS_ACC_CHANGED');

-- --------------------------------------------------------

--
-- Table structure for table `jmp_trip_request`
--

DROP TABLE IF EXISTS `jmp_trip_request`;
CREATE TABLE `jmp_trip_request` (
  `tr_id` int(10) NOT NULL,
  `tr_usr_id` int(10) NOT NULL,
  `tr_journey_purpose` text NOT NULL,
  `tr_vehicle_reg_no` varchar(50) NOT NULL,
  `tr_medical_by_osha` enum('YES','NO') NOT NULL,
  `tr_reason_finish_after_17` text,
  `tr_work_finish_time` enum('YES','NO') NOT NULL,
  `tr_vehicle_type` varchar(50) NOT NULL,
  `tr_difense_driver_training` enum('YES','NO') NOT NULL,
  `tr_for_by_for_training` enum('YES','NO') NOT NULL,
  `tr_suitable_license` enum('YES','NO') NOT NULL,
  `tr_fit_for_use` enum('YES','NO') NOT NULL,
  `tr_dispatch_time` datetime NOT NULL,
  `tr_arraival_time` datetime NOT NULL,
  `tr_departure_location` varchar(255) NOT NULL,
  `tr_destination_location` varchar(255) NOT NULL,
  `tr_stop_locations` text NOT NULL,
  `tr_distance` int(10) NOT NULL,
  `tr_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tr_status` enum('NEW','PENDING','INPROGRESS','APPROVED','DISAPPROVED','PAUSED') NOT NULL,
  `tr_proc_key` varchar(255) DEFAULT NULL,
  `tr_route_state` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jmp_trip_request`
--

INSERT INTO `jmp_trip_request` (`tr_id`, `tr_usr_id`, `tr_journey_purpose`, `tr_vehicle_reg_no`, `tr_medical_by_osha`, `tr_reason_finish_after_17`, `tr_work_finish_time`, `tr_vehicle_type`, `tr_difense_driver_training`, `tr_for_by_for_training`, `tr_suitable_license`, `tr_fit_for_use`, `tr_dispatch_time`, `tr_arraival_time`, `tr_departure_location`, `tr_destination_location`, `tr_stop_locations`, `tr_distance`, `tr_timestamp`, `tr_status`, `tr_proc_key`, `tr_route_state`) VALUES
(1, 64, 'Testing stuff', '123TZA', 'NO', '', 'NO', 'FORTUNER', 'YES', 'YES', 'YES', 'YES', '2018-12-29 06:59:00', '2018-12-28 13:59:00', 'Dsm', 'Dom', '', 250, '2018-12-28 11:58:41', 'INPROGRESS', NULL, 0),
(2, 64, 'Meeting', '40TZA', 'NO', '', 'NO', 'FORTUNER', 'YES', 'YES', 'YES', 'YES', '2018-12-30 08:10:00', '2018-12-29 20:10:00', 'DSM', 'Moro', '', 200, '2018-12-29 18:07:55', 'PAUSED', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `jmp_users`
--

DROP TABLE IF EXISTS `jmp_users`;
CREATE TABLE `jmp_users` (
  `usr_id` int(10) NOT NULL,
  `usr_role` enum('MANAGER','ADMIN','DRIVER') NOT NULL,
  `usr_email` varchar(100) NOT NULL,
  `usr_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `usr_fullname` varchar(255) NOT NULL,
  `usr_ad_name` varchar(255) DEFAULT NULL,
  `usr_phone` varchar(20) NOT NULL,
  `usr_status` varchar(20) NOT NULL,
  `usr_pwd` varchar(40) NOT NULL,
  `usr_last_selected_year` int(10) DEFAULT NULL,
  `usr_2fa_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `usr_last_login` datetime DEFAULT NULL,
  `usr_otp` varchar(40) DEFAULT NULL,
  `usr_last_activity_time` datetime DEFAULT NULL,
  `usr_logged_in` tinyint(1) DEFAULT NULL,
  `usr_user_agent` varchar(40) DEFAULT NULL,
  `usr_contractor` varchar(255) DEFAULT NULL,
  `usr_title` varchar(255) DEFAULT NULL,
  `usr_original_role` varchar(100) DEFAULT NULL,
  `usr_wrong_pass_count` int(10) NOT NULL DEFAULT '0',
  `usr_change_pass` tinyint(1) NOT NULL DEFAULT '0',
  `usr_change_pass_date` datetime DEFAULT NULL,
  `usr_pwd_expiry` datetime DEFAULT NULL,
  `usr_old_lock_role` varchar(50) DEFAULT NULL,
  `usr_lock_datetime` datetime DEFAULT NULL,
  `usr_wrong_pass_datetime` datetime DEFAULT NULL,
  `usr_last_logon` datetime DEFAULT NULL,
  `usr_delegator` varchar(250) DEFAULT NULL,
  `usr_mobile_last_activity` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=96 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jmp_users`
--

INSERT INTO `jmp_users` (`usr_id`, `usr_role`, `usr_email`, `usr_timestamp`, `usr_fullname`, `usr_ad_name`, `usr_phone`, `usr_status`, `usr_pwd`, `usr_last_selected_year`, `usr_2fa_enabled`, `usr_last_login`, `usr_otp`, `usr_last_activity_time`, `usr_logged_in`, `usr_user_agent`, `usr_contractor`, `usr_title`, `usr_original_role`, `usr_wrong_pass_count`, `usr_change_pass`, `usr_change_pass_date`, `usr_pwd_expiry`, `usr_old_lock_role`, `usr_lock_datetime`, `usr_wrong_pass_datetime`, `usr_last_logon`, `usr_delegator`, `usr_mobile_last_activity`) VALUES
(1, 'MANAGER', 'akbaralia@vodacom.co.tz', '2018-12-25 07:50:14', 'Ahmed Akabarali', 'akbaralia', '0754710194', 'ACTIVE', '356a192b7913b04c54574d18c28d46e6395428ab', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 'Acting HOD: Lake Zone', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'MANAGER', 'alupembe@vodacom.co.tz', '2018-12-25 07:50:14', ' Andrew Lupembe', 'alupembe', '0754711144', 'ACTIVE', '356a192b7913b04c54574d18c28d46e6395428ab', NULL, 1, '2018-12-25 10:19:39', 'c8ce71505704925121cacbfe29680d09d5a6b2f6', '2018-12-25 10:19:39', 0, '996501c9916a7e51cc786cdd31cdd68632dffe79', NULL, 'HOD: Network Operations', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-12-25 10:20:20'),
(3, 'MANAGER', 'amulonga@vodacom.co.tz', '2018-12-25 07:50:14', ' Alec Mulonga', 'amulonga', '754711655', 'ACTIVE', '356a192b7913b04c54574d18c28d46e6395428ab', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 'Director: Network', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'MANAGER', 'bstephen@vodacom.co.tz', '2018-12-25 07:50:14', ' Brigita Stephen', 'bstephen', '0754711163', 'ACTIVE', '356a192b7913b04c54574d18c28d46e6395428ab', NULL, 1, '2018-12-25 10:40:54', 'a488aa5caffcff48695e0f400495fd717136ed1e', '2018-12-25 10:40:54', 0, '996501c9916a7e51cc786cdd31cdd68632dffe79', NULL, 'EHOD:Northern Zone', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-12-25 12:12:34'),
(5, 'MANAGER', 'chambuag@vodacom.co.tz', '2018-12-25 07:50:14', ' Grace Chambua', 'chambuag', '0754711469', 'ACTIVE', '356a192b7913b04c54574d18c28d46e6395428ab', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 'EHOD: Central Zone', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'MANAGER', 'desmarquestc@vodacom.co.tz', '2018-12-25 07:50:14', ' Charles Desmarquest', 'desmarquestc', '754711402', 'ACTIVE', '356a192b7913b04c54574d18c28d46e6395428ab', NULL, 1, '2018-12-26 21:57:51', '08ab94787936e21703ba8abb75a6b57237e83ff4', '2018-12-26 21:57:51', 1, '996501c9916a7e51cc786cdd31cdd68632dffe79', NULL, 'HOD: SCM', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-12-26 21:58:17'),
(7, 'MANAGER', 'dmkama@vodacom.co.tz', '2018-12-25 07:50:14', 'Domician Mkama', 'dmkama', '0754710058', 'ACTIVE', '356a192b7913b04c54574d18c28d46e6395428ab', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 'EHOD: Lake Zone', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 'MANAGER', 'fedriani@vodacom.co.tz', '2018-12-25 07:50:14', 'Fedriani Luis', 'fedriani', '754711644', 'ACTIVE', '356a192b7913b04c54574d18c28d46e6395428ab', NULL, 1, '2018-12-28 17:44:48', '76a5f3914d7a97030e372aedab04789907698ea6', '2018-12-28 17:44:48', 0, '996501c9916a7e51cc786cdd31cdd68632dffe79', NULL, 'Director: IT&Billing', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-12-28 22:06:19'),
(9, 'MANAGER', 'gmagonyozi@vodacom.co.tz', '2018-12-25 07:50:14', ' George Magonyozi', 'gmagonyozi', '754710104', 'ACTIVE', '356a192b7913b04c54574d18c28d46e6395428ab', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 'HOD: Network Engineering', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 'MANAGER', 'gvenanty@vodacom.co.tz', '2018-12-25 07:50:14', 'George Venanty', 'gvenanty', '0754711233', 'ACTIVE', '356a192b7913b04c54574d18c28d46e6395428ab', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 'HOD: Coastal Zone', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 'MANAGER', 'hisham.hendi@vodacom.co.tz', '2018-12-25 07:50:14', 'Hisham Hendi', 'hisham.hendi', '0754711092', 'ACTIVE', '356a192b7913b04c54574d18c28d46e6395428ab', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 'Managing Director', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(12, 'MANAGER', 'hkisiwani@vodacom.co.tz', '2018-12-25 07:50:14', 'Heladius Kisiwani ', 'hkisiwani', '0754711192', 'ACTIVE', '356a192b7913b04c54574d18c28d46e6395428ab', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 'HOD: Central Zzone', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(13, 'MANAGER', 'hlwakatare@vodacom.co.tz', '2018-12-25 07:50:14', 'Harriet Lwakatare ', 'hlwakatare', '754711252', 'ACTIVE', '356a192b7913b04c54574d18c28d46e6395428ab', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 'Director: Customer Service', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, 'MANAGER', 'jacques.marais@vodacom.co.tz', '2018-12-25 07:50:14', ' Jacques Marais', 'jacques.marais', '746712266', 'ACTIVE', '356a192b7913b04c54574d18c28d46e6395428ab', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 'Finance Director', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(15, 'MANAGER', 'kalufyaa@vodacom.co.tz', '2018-12-25 07:50:14', 'Ayubu Kalufya', 'kalufyaa', '0754712388', 'ACTIVE', '356a192b7913b04c54574d18c28d46e6395428ab', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 'HOD: Lake Zone', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(16, 'MANAGER', 'karen.lwakatare@vodacom.co.tz', '2018-12-25 07:50:14', ' Karen Lwakatare', 'karen.lwakatare', '754710151', 'ACTIVE', '356a192b7913b04c54574d18c28d46e6395428ab', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 'HOD: HSE', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(17, 'MANAGER', 'lkanijo@vodacom.co.tz', '2018-12-25 07:50:14', 'Louis Kanijo', 'lkanijo', '754711061', 'ACTIVE', '356a192b7913b04c54574d18c28d46e6395428ab', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 'HOD: Corporate Security', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(18, 'MANAGER', 'lugatag@vodacom.co.tz', '2018-12-25 07:50:14', 'George Lugata', 'lugatag', '0754710050', 'ACTIVE', '356a192b7913b04c54574d18c28d46e6395428ab', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 'HOD: Coastal Zone', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(19, 'MANAGER', 'macfadyne.minja@vodacom.co.tz', '2018-12-25 07:50:14', ' Macfadyne Minja', 'macfadyne.minja', '0754711174', 'ACTIVE', '356a192b7913b04c54574d18c28d46e6395428ab', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 'EHOD: Southern Zone', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(20, 'MANAGER', 'mbujaga@vodacom.co.tz', '2018-12-25 07:50:14', 'Michael Bujaga', 'mbujaga', '754710352', 'ACTIVE', '356a192b7913b04c54574d18c28d46e6395428ab', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 'Manager: Transport Layer', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(21, 'MANAGER', 'mjoel@vodacom.co.tz', '2018-12-25 07:50:14', ' Matiko Joel', 'mjoel', '754710761', 'ACTIVE', '356a192b7913b04c54574d18c28d46e6395428ab', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 'Manager: Fleet&Facilities', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(22, 'MANAGER', 'mworia@vodacom.co.tz', '2018-12-25 07:50:14', ' Rosalynn Mworia', 'mworia', '754710661', 'ACTIVE', '356a192b7913b04c54574d18c28d46e6395428ab', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 'Director: Corporate Affairs', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(23, 'MANAGER', 'nkamando@vodacom.co.tz', '2018-12-25 07:50:14', ' Nguvu Kamando', 'nkamando', '754710297', 'ACTIVE', '356a192b7913b04c54574d18c28d46e6395428ab', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 'HOD: Netowrk Performance', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(24, 'MANAGER', 'nungwie@vodacom.co.tz', '2018-12-25 07:50:14', 'Ezekiel Nungwi', 'nungwie', '0754711213', 'ACTIVE', '356a192b7913b04c54574d18c28d46e6395428ab', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 'HOD: Southern Zone', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(25, 'MANAGER', 'pedigandon@vodacom.co.tz', '2018-12-25 07:50:14', 'Nathaneal Pedigando', 'pedigandon', '0754710918', 'ACTIVE', '356a192b7913b04c54574d18c28d46e6395428ab', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 'Senior Sales Manager: NZ', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(26, 'MANAGER', 'riwal@vodacom.co.tz', '2018-12-25 07:50:14', 'Linda Riwa', 'riwal', '0754711367', 'ACTIVE', '356a192b7913b04c54574d18c28d46e6395428ab', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 'Acting CBU Director', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(27, 'MANAGER', 'rmwangesi@vodacom.co.tz', '2018-12-25 07:50:14', ' Richard Mwangesi', 'rmwangesi', '754711587', 'ACTIVE', '356a192b7913b04c54574d18c28d46e6395428ab', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 'Manager: IP/PaCo', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(28, 'MANAGER', 'skajembe@vodacom.co.tz', '2018-12-25 07:50:14', 'Kajembe Safia A.', 'skajembe', '0754711003', 'ACTIVE', '356a192b7913b04c54574d18c28d46e6395428ab', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 'HOD: CBU Budget Operations', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(29, 'MANAGER', 'slugendo@vodacom.co.tz', '2018-12-25 07:50:14', 'Simon Lugendo ', 'slugendo', '754710257', 'ACTIVE', '356a192b7913b04c54574d18c28d46e6395428ab', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 'Manager: Radio Planning', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(30, 'MANAGER', 'smchau@vodacom.co.tz', '2018-12-25 07:50:14', ' Straton Mchau', 'smchau', '0754710517', 'ACTIVE', '356a192b7913b04c54574d18c28d46e6395428ab', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 'Senior Sales Manager: NZ', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(31, 'MANAGER', 'vivienne.penessis@vodacom.co.tz', '2018-12-25 07:50:14', 'Vivienne Penessis', 'vivienne.penessis', '754711276', 'ACTIVE', '356a192b7913b04c54574d18c28d46e6395428ab', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 'Human Resources Director', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(32, 'MANAGER', 'vmhina@vodacom.co.tz', '2018-12-25 07:50:14', ' Victor Mhina', 'vmhina', '754710044', 'ACTIVE', '356a192b7913b04c54574d18c28d46e6395428ab', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 'Manager: CSOC', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(64, 'ADMIN', 'michel.sanga@noxyt.com', '2018-12-25 09:06:04', 'Mike Sanga', 'sangam', '255764192010', 'ACTIVE', '356a192b7913b04c54574d18c28d46e6395428ab', NULL, 1, '2018-12-29 19:45:59', '9bb8e0950f90ad2c86d71227775862a63bb50c03', '2018-12-29 19:45:59', 1, '996501c9916a7e51cc786cdd31cdd68632dffe79', NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-12-29 21:09:38'),
(65, 'DRIVER', 'bmusabila@vodacom.co.tz', '2018-12-27 12:04:56', 'Baraka Kusaya Musabila', 'bmusabila', '255754711065', 'ACTIVE', '', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(66, 'DRIVER', 'torgenes@gmail.com', '2018-12-27 12:04:56', 'Cayo T', 'cayo', '255754710929', 'ACTIVE', '', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(67, 'DRIVER', 'cminungu@vodacom.co.tz', '2018-12-27 12:04:56', 'Charles selestine minungu', 'cminungu', '255754711212', 'ACTIVE', '', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(68, 'DRIVER', 'esagenge@vodacom.co.tz', '2018-12-27 12:04:56', 'Emanuel Sagenge', 'esagenge', '255754711606', 'ACTIVE', '', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(69, 'DRIVER', 'evody@noxyt.com', '2018-12-27 12:04:56', 'Evody Kibiki', 'evody', '255576531482', 'ACTIVE', '', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(70, 'DRIVER', 'Gerald@noxyt.com', '2018-12-27 12:04:56', 'Gerald Sanga', 'Gerald', '255764112233', 'ACTIVE', '', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(71, 'DRIVER', 'sanga@g.com', '2018-12-27 12:04:56', 'Gerald sanga', 'gerry', '255075543217', 'ACTIVE', '', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(72, 'DRIVER', 'issa@noxyt.com', '2018-12-27 12:04:56', 'Izzo Bussiness', 'issa', '255755100205', 'ACTIVE', '', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(73, 'DRIVER', 'james@noxyt.com', '2018-12-27 12:04:56', 'James Tupatupazz', 'james', '255755406677', 'ACTIVE', '', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(74, 'DRIVER', 'john@vodacom.co.tz', '2018-12-27 12:04:56', 'John doe', 'John', '255764125451', 'ACTIVE', '', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(75, 'DRIVER', 'kombeb@vodacom.co.tz', '2018-12-27 12:04:56', 'Bernard Kombe', 'kombeb', '255754710491', 'ACTIVE', '', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(76, 'DRIVER', 'lingaf@vodacom.co.tz', '2018-12-27 12:04:56', 'Fadhil Linga', 'lingaf', '255754711285', 'ACTIVE', '', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(77, 'DRIVER', 'marab@vodacom.co.tz', '2018-12-27 12:04:56', 'Benedict Ng''adi Mara', 'marab', '255754710130', 'ACTIVE', '', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(78, 'DRIVER', 'mchanila@vodacom.co.tz', '2018-12-27 12:04:56', 'MOHAMED CHANILA', 'mchanila', '255754711188', 'ACTIVE', '', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(79, 'DRIVER', 'michel.sanga@noxyt.com', '2018-12-27 12:04:56', 'Mike Sanga', 'mike', '255764192010', 'ACTIVE', '', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(80, 'DRIVER', 'nyandag01@vodacom.co.tz', '2018-12-27 12:04:56', 'George Malimi Nyanda', 'nyandag01', '255754710500', 'ACTIVE', '', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(81, 'DRIVER', 'michel.sanga@noxyt.com', '2018-12-27 12:04:56', 'Michel Sanga', 'sanga', '255764192010', 'ACTIVE', '', NULL, 1, '2018-12-27 13:16:01', '157209a34bfa8af974ed9438dba4f602a591b89f', '2018-12-27 13:16:01', 0, '996501c9916a7e51cc786cdd31cdd68632dffe79', NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-12-27 13:21:20'),
(82, 'DRIVER', 'urassao@vodacom.co.tz', '2018-12-27 12:04:56', 'Ombeni urassa', 'urassao', '255754711293', 'ACTIVE', '', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(83, 'DRIVER', 'vgiron@vodacom.co.tz', '2018-12-27 12:04:56', 'Val Giron', 'vgiron', '255764102010', 'ACTIVE', '', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jmp_user_sessions`
--

DROP TABLE IF EXISTS `jmp_user_sessions`;
CREATE TABLE `jmp_user_sessions` (
  `us_ad_name` varchar(50) NOT NULL,
  `us_token` varchar(40) NOT NULL,
  `us_timestamp` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jmp_approval`
--
ALTER TABLE `jmp_approval`
  ADD PRIMARY KEY (`ap_tr_id`,`ap_usr_email`);

--
-- Indexes for table `jmp_attachment`
--
ALTER TABLE `jmp_attachment`
  ADD PRIMARY KEY (`att_id`);

--
-- Indexes for table `jmp_authoriser`
--
ALTER TABLE `jmp_authoriser`
  ADD PRIMARY KEY (`auth_tr_id`,`auth_usr_email`),
  ADD KEY `joAuthoriserEmail` (`auth_usr_email`);

--
-- Indexes for table `jmp_department`
--
ALTER TABLE `jmp_department`
  ADD PRIMARY KEY (`dept_id`);

--
-- Indexes for table `jmp_drivers_profile`
--
ALTER TABLE `jmp_drivers_profile`
  ADD PRIMARY KEY (`dp_usr_id`);

--
-- Indexes for table `jmp_email`
--
ALTER TABLE `jmp_email`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jmp_firebase_tokens`
--
ALTER TABLE `jmp_firebase_tokens`
  ADD PRIMARY KEY (`ft_id`);

--
-- Indexes for table `jmp_medical_assessment`
--
ALTER TABLE `jmp_medical_assessment`
  ADD PRIMARY KEY (`ma_emp_email`,`ma_date`);

--
-- Indexes for table `jmp_options`
--
ALTER TABLE `jmp_options`
  ADD PRIMARY KEY (`option_id`);

--
-- Indexes for table `jmp_route`
--
ALTER TABLE `jmp_route`
  ADD PRIMARY KEY (`r_tr_id`,`r_sequence`) USING BTREE;

--
-- Indexes for table `jmp_section`
--
ALTER TABLE `jmp_section`
  ADD PRIMARY KEY (`sec_id`);

--
-- Indexes for table `jmp_settings`
--
ALTER TABLE `jmp_settings`
  ADD PRIMARY KEY (`st_id`),
  ADD UNIQUE KEY `st_name` (`st_name`);

--
-- Indexes for table `jmp_sms`
--
ALTER TABLE `jmp_sms`
  ADD PRIMARY KEY (`sms_id`);

--
-- Indexes for table `jmp_smscontent`
--
ALTER TABLE `jmp_smscontent`
  ADD PRIMARY KEY (`ws_id`);

--
-- Indexes for table `jmp_trip_request`
--
ALTER TABLE `jmp_trip_request`
  ADD PRIMARY KEY (`tr_id`);

--
-- Indexes for table `jmp_users`
--
ALTER TABLE `jmp_users`
  ADD PRIMARY KEY (`usr_id`);

--
-- Indexes for table `jmp_user_sessions`
--
ALTER TABLE `jmp_user_sessions`
  ADD PRIMARY KEY (`us_ad_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jmp_attachment`
--
ALTER TABLE `jmp_attachment`
  MODIFY `att_id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `jmp_department`
--
ALTER TABLE `jmp_department`
  MODIFY `dept_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `jmp_email`
--
ALTER TABLE `jmp_email`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `jmp_firebase_tokens`
--
ALTER TABLE `jmp_firebase_tokens`
  MODIFY `ft_id` int(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=70;
--
-- AUTO_INCREMENT for table `jmp_options`
--
ALTER TABLE `jmp_options`
  MODIFY `option_id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `jmp_section`
--
ALTER TABLE `jmp_section`
  MODIFY `sec_id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `jmp_settings`
--
ALTER TABLE `jmp_settings`
  MODIFY `st_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `jmp_sms`
--
ALTER TABLE `jmp_sms`
  MODIFY `sms_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `jmp_smscontent`
--
ALTER TABLE `jmp_smscontent`
  MODIFY `ws_id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `jmp_trip_request`
--
ALTER TABLE `jmp_trip_request`
  MODIFY `tr_id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `jmp_users`
--
ALTER TABLE `jmp_users`
  MODIFY `usr_id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=96;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
