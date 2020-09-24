-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 24, 2020 at 11:30 AM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.3.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `base`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_login` (IN `in_user_email` VARCHAR(50))  BEGIN
	SELECT
		*
	FROM atb_user a
	INNER JOIN atb_user_type b ON a.user_type = b.user_type
	INNER JOIN atb_user_access c ON a.user_id = c.user_id
	WHERE a.user_email = in_user_email OR a.user_name = in_user_email;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_users_list_add` (IN `in_user_email` VARCHAR(100), IN `in_password_count` INT, IN `in_user_password` VARCHAR(255), IN `in_user_type` INT)  validate : BEGIN
	
	DECLARE min_password INT;
	DECLARE max_password INT;
    DECLARE id INT;
    
    SELECT 	setup_min_password,	setup_max_password
	INTO 	min_password,		max_password
    FROM atb_setup LIMIT 1;
    
	IF NOT EXISTS(SELECT * FROM atb_user_type WHERE user_type = in_user_type LIMIT 1) THEN
		SELECT 'Add User Failed' h, 'User type does not eixst!' m, 'warning' s;
		LEAVE validate;
    END IF;
    
    IF in_password_count < min_password OR in_password_count > max_password THEN
		SELECT 'Add User Failed' h, CONCAT('Password requires minimum of ',min_password,' and maximum of ',max_password,' characters') m, 'warning' s;
        LEAVE validate;
    END IF;
    
    IF EXISTS(SELECT * FROM atb_user WHERE user_email = in_user_email  LIMIT 1) THEN
		SELECT 'Add User Failed' h, 'User already exists' m, 'warning' s;
        LEAVE validate;
    END IF;
    
    INSERT INTO atb_user (user_name,user_email,user_password,user_type)
		SELECT in_user_email,in_user_email,in_user_password,in_user_type;
	
    SELECT user_id INTO id FROM atb_user WHERE user_email = in_user_email;
    
	INSERT INTO atb_user_access
		SELECT id,access_dashboard,access_master_list,access_users,access_settings FROM atb_user_type WHERE user_type = in_user_type;
        
	SELECT 'Add User Success' h, 'You have successfully added new user!' m, 'success' s;
        
        
     
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_users_list_data` (IN `in_user_type` INT, IN `in_user_logged_id` INT)  BEGIN	
	SELECT
		a.user_id,
		a.user_name,
		a.user_email,
		a.user_locked,
		a.user_date_registered,
		a.user_change_password,
		a.user_img,
        CASE  
			WHEN in_user_logged_id = a.user_id or a.user_id = 1 THEN 1
            ELSE '0' END user_logged,
		b.*,
		c.*
	FROM atb_user a
	INNER JOIN atb_user_type b ON a.user_type = b.user_type
	INNER JOIN atb_user_access c ON a.user_id = c.user_id
	WHERE
		a.user_deleted = 0 AND
		CASE in_user_type
			WHEN 0 THEN 1=1
			ELSE b.user_type = in_user_type
		END;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_users_list_delete` (IN `in_user_id` INT)  validate : BEGIN

	IF EXISTS (SELECT user_id from atb_user WHERE user_id = in_user_id AND user_locked = 0) THEN
		SELECT 'User Reset' h, "Please lock the users before removing it" m, 'warning' s;
		LEAVE validate;
    END IF;

	UPDATE atb_user SET user_deleted = 1 WHERE user_id = in_user_id;
	SELECT 'User Reset' h, "You have successfully removed the user" m, 'success' s;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_users_list_edit` (IN `in_user_id` INT, IN `in_user_type` INT)  validate : BEGIN
	
    
    UPDATE atb_user SET user_type = in_user_type WHERE user_id = in_user_id;
	SELECT 'Edit User Success' h, 'You have successfully modified the User' m, 'success' s;
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_users_list_lock` (IN `in_user_id` INT)  BEGIN
	UPDATE atb_user SET user_locked = 1 WHERE user_id = in_user_id;
	SELECT 'User Locked' h, 'You have successfully locked the user' m, 'success' s;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_users_list_reset` (IN `in_user_id` INT, IN `in_new_password` VARCHAR(255))  BEGIN
	UPDATE atb_user SET user_password = in_new_password, user_change_password = NOW()  WHERE user_id = in_user_id;
	SELECT 'User Reset' h, "You have successfully reset the user's password" m, 'success' s;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_users_list_unlock` (IN `in_user_id` INT)  BEGIN
	UPDATE atb_user SET user_locked = 0 WHERE user_id = in_user_id;
	SELECT 'User Unlocked' h, 'You have successfully unlocked the user' m, 'success' s;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_users_type_add` (IN `in_user_type_name` VARCHAR(100))  validate : BEGIN
	
    IF EXISTS(SELECT * FROM atb_user_type WHERE user_type_name = in_user_type_name LIMIT 1) THEN
		SELECT 'Add User Type Failed' h, 'User type already exists' m, 'warning' s;
        LEAVE validate;
	END IF;
    
    INSERT INTO atb_user_type(user_type_name) 
		SELECT in_user_type_name;
	SELECT 'Good Job!' h, 'You have successfully added new user type!' m, 'success' s;
        
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_users_type_data` ()  BEGIN
	 SELECT
		a.*,
		COUNT(b.user_id) user_type_count
	FROM atb_user_type a
	LEFT JOIN atb_user b ON a.user_type = b.user_type AND b.user_deleted = 0
	GROUP BY a.user_type,a.user_type_name;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_users_type_delete` (IN `in_user_type` INT)  validate : BEGIN
	
    IF EXISTS (SELECT * FROM atb_user WHERE user_type = in_user_type AND user_deleted = 0 LIMIT 1) THEN
		SELECT 'Delete User Type Failed' h, 'User type is currently in use and cannot be removed' m, 'warning' s;
        LEAVE validate;
    END IF;
    
    DELETE FROM atb_user WHERE user_type = in_user_type;
    DELETE FROM atb_user_type WHERE user_type = in_user_type;
	SELECT 'Delete User Type Success' h, 'You have successfully removed User Type' m, 'success' s;
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_users_type_edit` (IN `in_user_type` INT, IN `in_user_type_name` VARCHAR(100))  validate : BEGIN
	
    IF EXISTS (SELECT user_type FROM  atb_user_type WHERE user_type != in_user_type AND user_type_name = in_user_type_name LIMIT 1) THEN
		SELECT 'Modify User Type Failed' h, 'User type already exist or currently in use and cannot be modified' m, 'warning' s;
		LEAVE validate;
    END IF;
    
    UPDATE atb_user_type SET user_type_name = in_user_type_name WHERE user_type = in_user_type;
	SELECT 'Edit User Type Success' h, 'You have successfully modified the User Type' m, 'success' s;
    
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `atb_master`
--

CREATE TABLE `atb_master` (
  `master_id` int(11) NOT NULL,
  `master_name` varchar(120) DEFAULT NULL,
  `master_type` int(11) DEFAULT NULL,
  `master_type_name` varchar(120) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `atb_master_type`
--

CREATE TABLE `atb_master_type` (
  `master_type` int(11) NOT NULL,
  `master_type_name` varchar(120) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `atb_setup`
--

CREATE TABLE `atb_setup` (
  `setup_id` int(11) NOT NULL,
  `setup_min_password` int(11) DEFAULT 6,
  `setup_max_password` int(11) DEFAULT 24,
  `setup_max_wrong_password` int(11) DEFAULT 5,
  `setup_default_password` varchar(120) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `atb_setup`
--

INSERT INTO `atb_setup` (`setup_id`, `setup_min_password`, `setup_max_password`, `setup_max_wrong_password`, `setup_default_password`) VALUES
(1, 6, 24, 5, 'Welcome1');

-- --------------------------------------------------------

--
-- Table structure for table `atb_user`
--

CREATE TABLE `atb_user` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(100) DEFAULT NULL,
  `user_email` varchar(100) DEFAULT NULL,
  `user_password` varchar(255) DEFAULT NULL,
  `user_type` int(11) DEFAULT NULL,
  `user_locked` varchar(1) DEFAULT '0',
  `user_date_registered` datetime DEFAULT current_timestamp(),
  `user_change_password` datetime DEFAULT NULL,
  `user_img` varchar(255) DEFAULT NULL,
  `user_deleted` varchar(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `atb_user`
--

INSERT INTO `atb_user` (`user_id`, `user_name`, `user_email`, `user_password`, `user_type`, `user_locked`, `user_date_registered`, `user_change_password`, `user_img`, `user_deleted`) VALUES
(1, NULL, 'admin@base.com', '$2y$10$PZREKbjIpE8LYXzdusHKzOVeG6Z.BlG.r//Jk3x71jZorhmM/wSy6', 1, '0', '2020-09-21 06:11:37', NULL, NULL, '0'),
(2, NULL, 'user@base.com', '$2y$10$JJoQoPwXvLVlhXmfl7voxud1RAmEtjVzQslBjGxS9UbgSBVYwaLpi', 1, '1', '2020-09-21 06:11:54', NULL, NULL, '0'),
(13, 'admin1@base.com', 'admin1@base.com', '$2y$10$71u6xOLTrYlsbwxIu7dJ5u.eqPxef8EXQH3cmkw8wTpO9TjIvu37a', 2, '0', '2020-09-23 08:35:42', '2020-09-24 04:23:50', NULL, '0');

-- --------------------------------------------------------

--
-- Table structure for table `atb_user_access`
--

CREATE TABLE `atb_user_access` (
  `user_id` int(11) NOT NULL,
  `access_dashboard` varchar(1) DEFAULT '0',
  `access_master_list` varchar(1) DEFAULT '0',
  `access_users` varchar(1) DEFAULT '0',
  `access_settings` varchar(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `atb_user_access`
--

INSERT INTO `atb_user_access` (`user_id`, `access_dashboard`, `access_master_list`, `access_users`, `access_settings`) VALUES
(1, '1', '1', '1', '1'),
(2, '1', '0', '0', '0'),
(13, '1', '1', '1', '1'),
(14, '1', '0', '0', '0'),
(15, '1', '0', '0', '0');

-- --------------------------------------------------------

--
-- Table structure for table `atb_user_type`
--

CREATE TABLE `atb_user_type` (
  `user_type` int(11) NOT NULL,
  `user_type_name` varchar(100) DEFAULT NULL,
  `access_dashboard` varchar(1) DEFAULT '0',
  `access_master_list` varchar(1) DEFAULT '0',
  `access_users` varchar(1) DEFAULT '0',
  `access_settings` varchar(1) DEFAULT '0',
  `user_access` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `atb_user_type`
--

INSERT INTO `atb_user_type` (`user_type`, `user_type_name`, `access_dashboard`, `access_master_list`, `access_users`, `access_settings`, `user_access`) VALUES
(1, 'Admin', '1', '1', '1', '1', NULL),
(2, 'User', '1', '0', '0', '0', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2020_09_20_101035_create_sessions_table', 1),
(5, '2020_09_20_101050_create_cache_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('J91TxACkr7Tn3GApT0GoWunjTwI3UsutFaD9UUbY', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.102 Safari/537.36 Edg/85.0.564.51', 'ZXlKcGRpSTZJbTFuVlZoNmFtYzVPRFl5UVM4d2VHeDNRM0pNU1VFOVBTSXNJblpoYkhWbElqb2lZMHh3ZVRkUlVubFlSbEZXZDJObk9DdFBkMGx5VGxONlptUlZWbFYwUzA4eU0xTnRNakIyS3pFclFrMHpjbGRtVm5NdlVrNVZVV2hhWTBzM2FHTnBNRlJZTVUxVlVGVTJTMDlIUVV4clZHUlplakJpZVdGRFJXVlFXbVV6Y0U5T1RGbDZaV0pXTURoamEyUlVOMU0zTVRjM2FrOTBRbGR0YldJdlkyWk5ZVkpyTUhoeE1GRm1aRUpvZDBwUU0zZDFhREJqVldSWGVqUkNhbXg0THpJclpURnRTek53U1ZWeE1IZEJkVWs0TlVOdWNYZFFOemtyZWxwUlVrbzRSV05LZFV0WWNFWndhemxMYlVrNE5rMUxWSFZRVGpSTVZscDJOQzlVVkRkcFkyWnJjMVJMYzJneVZWWmlkMjgzYUdNelJqUkJNazl4U1ZVdlZuTldaakpqY0dkc1ltdHZUWGhyVm5SVFkxSnJialV5VjFGQlIxUlpOVzF5V21Fek9YQnNjWFEzY1hsdk5WUkRRM1k1WXpoUmRISnVTbVFyTlRVNFZtOW5lV0ZaZVZGbE1EWnlUMjF0WjBKRldUSTRhMlUwZUZGSlQzZE9aMHRIVW1sMFlVWm9jM014VW1weWNWazFORkFyTlc5UlUyOHhibGh3ZG5VeFdYbDVUSHBSWWxSd2JVTnRUUzh4VlhSVU0zVm9kM2hpUzFSTmNGWnNSSFJWWVVJMVYzbDFjRVZVTjJOMFJraExlVUYxZWtSRWVuVm1hRTQ1ZEZBeFFqSkhXbko0TTJGS2FFRkZaVlJJWnpScFZFMDRhMXAzZHpSRVVsTTBUWFZoZDJRcmVtSmFNMmxTYzAxSmJHbE1aMkpxYWxKSWJsbEdTamQ1YVZCMGRDOTJSbkJUZHpKT1IxUjRLMGQyVDNObVpVZDZZbk16ZUdKTVVXeExWMlZ6YlVwcFRubHFNVUprY25oSWRXaDBSRmsxVFV0eWRrNW9PRTlNTWl0aGFUSjNlVmg0VnpFNGVHNVZNRlJzWldRMmIxWmtjblk1TDJWd09FUldVMFZyVld4M1NucERWRGh0VWtoUWIxaGlZMjlOT0ZBNWRGUndTMko0VEVvM1EzVnZSVXRTVHk5d1NWZDBjams0UzJ4bWNWcFhaRXRHUzJOcFZqVXlaRXhHZVZGcmQxcG1PVVZKVDBKaGREUm9UMk5NTldWeVRHeGhiMk4xUVM4eWVXMU5laTkwVTAwM05qSXpVVWQ0Tmt0ak1HaEZTM00zSzBKNldsVmpjekZzVkRSUFNFc3piVkZKVFZkM01uWlFXR2xSTTI1R0wwTmliek5uWldaMVYyWXhSRlZRY0RkNEwzUldhVXN2VWxVdlEyTnhVWGQ0ZERsaFZXMUJhakY1Y1hsYWRHOXVhV3MxZGtacmJYSjRUVXBQY0cxYWVqUlhXVnA1YmxSeU9WQnRhMHR3YkVGWk5ubEdhelUyVHpWVlRrTk9URTE1TkRCS1VVWkJhV3RSUkhGbFpFa3dhMlpYY0ZoTVFtd3lTR1JtUlZaR1ZVMWhhRXRJVVRaellVOTVSMjR2ZURJNVJ6RnlWVW92V21OME5UUXZiM0pTV2xoUFVtNXBPWGxKS3paNlN6ZElOR056ZWpkWU1HWk5aVWhGVkRSMGVHWklaRE5vTVdkWGJXaFpjR2xtTm5scmNqRnFMMGhDYVVoa2NGTjBOMWswSzB0clEyUkpUVk5qVEVkTFJreFJRbXByVjB4eGJsUnBUMDVIWjNSRU9HTmxNRE4wVlQwaUxDSnRZV01pT2lJMU5USmxZekkzTlRsaU5USTVZemhsWmpnMFkyTTJZelV6WmpabE1tTTBZekl4TkdNMU1HTXlZV05qTW1FeU9EQTVPRGxoWVdJNFlUWm1aVFZpWkdReUluMD0=', 1600898365),
('pBpZbqhAs4CCSOrYBevGTbJNTc7ECZMRrNeX8t04', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.102 Safari/537.36 Edg/85.0.564.51', 'ZXlKcGRpSTZJakZ4UTJOVlRsTXJSak5wWjBwYVlXeElNbVUyWVdjOVBTSXNJblpoYkhWbElqb2lRMFZ4U205eloyWndjbkZRT0ZRM2EyUkhVMFpPV1ZkMmVtcFBla3BZTlc5YU1YbzVWU3RCVVdWSGRWVjBRVE5FYnpSeVdYaFhOV0paYkhKdWMzUnZXRTR6YlZwRlduZFZPVVZNU1VKdFZreFdlbUZqYjFWcWFFMXRWRGxxYVZSWGMydDZZazFMTm5jNE9URnBRbGszUVZOMlZrUTFRMFozVkVneldEZG1VMU5OZFZSVVdHMU5iRlZNVlZCUVFYcGlTVXRsV1dnNWNXcDVOekZEUkZOaVRFcFZaV1ZCTUZoV05tbDNRVkpFYW5Wd2R6SnhkMFJGZEdaNVJ6VkJOMkpZVkhoWlFrcFNVRFJ6YzFWdWJUWmhOM1ZxZEhCdFpsTXhVMmN6ZW1nM1EyTkhkazV2WTFkUkwycHZkbkYwVW1KRFdrZ3lUR2x6VTJoWGFISm9RMnRIT1V4Rk5XbzBObmxNTVVoMWNuUXlla1JSVldrdlRYZExiSGQ0Um10TGVWZExWekZKWkhkU1VIQTNORWxST0d0ek9VdEJhR2wyWTJwWWEyUnhiVkZDWXpoSFNFMVNaRE5JV1ZGV1pFZGFNVk00TVUxSFZrOTNlV1kxYlZWeFdXNXFRelZ5Y205WWVuZ3dXVVptZGxobGQyZHNORzlhZVRkWVRsZzFUVEZQZW1SNmQxUk1UbGhJUlZSa2FGaDZjMDVZWjIxb05rUmtlSEF4VkhSeWJWQnFNbUZtVUhSNWNUWnpUbFF4VEVsVVRGUjVXVkJWTm5OMVdEQXhlSHBMUlVWRFdYVnZLMVpOWVhoYWVXOU5NbVoxTVVsMVYxWndkMk5hWVVkSWFqZHFNWFkyVldzeVRYWm1hMEZZVVU1alp6Rk1iR3RFYjA4elpVVmFjazlUU21oTVR6aDZXa3BPWmxoM1UxQTJiRlYzVkZRelpVZEphRVp6WVVWNmJ6bDRRMEZyUWtkVmFDdG1TVGRFVkRCWVVsb3pSbkZSV21GM01rWnVWVWhHU2lzdlJIcHVWMmR2WXpOSWIxRnlVamN3UkVveFoxTk5OV3BCVDNsUE4yNVBjSFVyYm1STFRrUTBkMFkxTjBNd2RtMUlRVlVyWVUwMWFGbHdhR3cwT0UxUWJEVkdiSFJuT1hwcFpuTjBSSFZPVUVoUWMzSjFSMDF6VUdGbE5tNVVTMWhpVDFrNEwxTnVTblJCYm1Sd1JtcGFUR2M0VVVGSFFYRkxObEJhZUcxak1WcGFTbTl4V0hwMlZUTkNXVlZHYlZkSFF6SXdiVXQyY0UxRk1UWnlibnBEWlROWWMxbExlaXRrYTA1RWFXOUxiMko2Ums0emRXVlBkbkpGV25GdFQxSm5aWEo0YzFodmVqUlZhbFZCYjB0T1VrcDVkMlZ5UlM5S1lUUkVjVzVOSzBnNFpuWlNRa3QyV0hZMVUwWjVabFIzUTNGMGFHWlRRM1JqVTJsUWIwTlhVM0pGY205WkswOTVUV0ZPWkVkSmFFMUtNbVJoTlVaRVIxcExkbXByY25kNlJEVTNNa1kyVFd0cFRIa3ZObVpEWWtKS1dXc3hiREZyV1hwbldGZE5OMFJ1TUZKS2FsUkJhQzlDZW13M056VnVlR3hKVGtsRk9HSm9kRU5KT1U5MFpYUXdWVVZEUldOWVdXYzVjR054TjJkU1UxTjNNRmhvVlhwb0wxRnFVbmc0ZWpaRUlpd2liV0ZqSWpvaU5ESXdaRGsyT0RRMk1XVXhNMkpoTmpFeVpXRmpaVFppTTJGalkyVXdPRFk1WlRNM05UazVaVGN6TVRNek1qaG1PV1ppWVRsbU1tUTRZbUk0TkdNeVpTSjk=', 1600896227);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `atb_master`
--
ALTER TABLE `atb_master`
  ADD PRIMARY KEY (`master_id`);

--
-- Indexes for table `atb_master_type`
--
ALTER TABLE `atb_master_type`
  ADD PRIMARY KEY (`master_type`);

--
-- Indexes for table `atb_setup`
--
ALTER TABLE `atb_setup`
  ADD PRIMARY KEY (`setup_id`);

--
-- Indexes for table `atb_user`
--
ALTER TABLE `atb_user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `atb_user_access`
--
ALTER TABLE `atb_user_access`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `atb_user_type`
--
ALTER TABLE `atb_user_type`
  ADD PRIMARY KEY (`user_type`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD UNIQUE KEY `cache_key_unique` (`key`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `atb_master`
--
ALTER TABLE `atb_master`
  MODIFY `master_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `atb_master_type`
--
ALTER TABLE `atb_master_type`
  MODIFY `master_type` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `atb_setup`
--
ALTER TABLE `atb_setup`
  MODIFY `setup_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `atb_user`
--
ALTER TABLE `atb_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `atb_user_type`
--
ALTER TABLE `atb_user_type`
  MODIFY `user_type` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
