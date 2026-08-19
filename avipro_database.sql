-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 05, 2025 at 11:36 AM
-- Server version: 8.0.42
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `avipro_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `password`, `full_name`) VALUES
(1, 'demo_admin', 'insert_your_hashed_password_here', 'Demo User');

-- --------------------------------------------------------

--
-- Table structure for table `enquiries`
--

CREATE TABLE `enquiries` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `destination` varchar(100) DEFAULT NULL,
  `travel_date` date DEFAULT NULL,
  `num_persons` int DEFAULT NULL,
  `message` text,
  `enquiry_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(50) DEFAULT 'New'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `destination` varchar(100) DEFAULT NULL,
  `duration` varchar(50) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text,
  `highlights` text,
  `inclusion` text,
  `exclusion` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `title`, `destination`, `duration`, `price`, `description`, `highlights`, `inclusion`, `exclusion`, `created_at`) VALUES
(1, 'Bali Serenity Beach Escape', 'Bali, Indonesia', '7 Days / 6 Nights', 1250.00, 'Experience the magic of Bali, from the spiritual heart of Ubud to the stunning beaches of Seminyak. This package includes temple visits, rice terrace trekking, and plenty of time for relaxation and sunset viewing.', 'Visit Tanah Lot Temple at sunset\nWhite water rafting on Ayung River\nUbud Monkey Forest tour', 'Accommodation in 4-star hotels\nDaily breakfast and dinner\nAirport transfers and all local transport\nExperienced local English-speaking guide', 'International flights\nLunch meals\nPersonal expenses and tips\nTravel insurance', '2025-12-04 23:47:04'),
(2, 'Majestic Manali & Rohtang Pass Adventure', 'Manali, India', '5 Days / 4 Nights', 899.00, 'Explore the beautiful valleys and towering peaks of Manali. This adventure package is perfect for nature lovers, including a trip to the famous Rohtang Pass (subject to weather) and visits to local villages.', 'Day trip to Rohtang Pass (or Solang Valley)\nHadimba Devi Temple visit\nBeas River bank camping experience', 'Accommodation in comfortable resort/camp\nAll meals (Breakfast, Lunch, Dinner)\nTransportation via private AC vehicle\nCampfire and musical evening', 'Entry fees to monuments\nSkiing or paragliding charges\nTravel during extreme winter conditions\nAny meals outside the fixed itinerary', '2025-12-04 23:47:22'),
(3, 'Dubai Oasis Escape 3 Nights', 'Dubai,UAE', '3 Days/3 Nights', 1182.00, 'Experience the dazzling blend of futuristic architecture and traditional Arabian charm with our signature 3-day Dubai package. This itinerary is crafted for those who want to see the city\'s iconic landmarks, indulge in world-class shopping, and enjoy a taste of the desert, all within a compact, luxurious trip. Perfect for a long weekend getaway or a short stopover.', '', 'Cost of United Arab Emirates (UAE) Visa.Cost of United Arab Emirates (UAE) Insurance.Arrival transfers from Airport to Hotel on a Private Basis.3 Night\'s accommodation with Breakfast in Fortune Karama Hotel or similar accommodation.Global Village (Global Village: Day Entry Ticket) on a Private Basis.Desert Safari With Bbq Dinner (Standard Desert Safari) on a Private Basis.Dubai City Tour (Dubai City Tour) on a Private Basis.Burj Khalifa (Burj Khalifa 124th + 125th Floor (Non Prime Hours)) with no transfer.Private Transfer from Fortune Karama Hotel to Dubai International Airport Terminal 1.', '', '2025-12-05 15:47:44');

-- --------------------------------------------------------

--
-- Table structure for table `package_images`
--

CREATE TABLE `package_images` (
  `id` int NOT NULL,
  `package_id` int NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `is_primary` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `package_images`
--

INSERT INTO `package_images` (`id`, `package_id`, `image_path`, `is_primary`) VALUES
(1, 1, 'uploads/packages/amazing.jpg', 1),
(2, 1, 'uploads/packages/bali_temple.jpg', 0),
(3, 2, 'uploads/packages/manali_valley.jpg', 1),
(4, 2, 'uploads/packages/manali_pass.jpg', 0),
(5, 3, 'uploads/packages/pkg_6932b148282511.06929281.jpeg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES
('about_us_content', 'Avipro Travels is dedicated to crafting unforgettable journeys. We specialize in personalized, immersive travel experiences, focusing on hidden gems and cultural authenticity. Founded in 2024, our mission is to make dream vacations a reality, handled entirely through our seamless online platform and expert local guides. We pride ourselves on transparent pricing and 24/7 client support.'),
('banner_title', 'Your Adventure Starts Here: Explore the World with Avipro'),
('contact_email', 'contact@aviprotravels.com'),
('contact_phone', '+91 XXXXXXXXXX');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `enquiries`
--
ALTER TABLE `enquiries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `package_images`
--
ALTER TABLE `package_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `package_id` (`package_id`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`setting_key`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `enquiries`
--
ALTER TABLE `enquiries`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `package_images`
--
ALTER TABLE `package_images`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `package_images`
--
ALTER TABLE `package_images`
  ADD CONSTRAINT `package_images_ibfk_1` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
