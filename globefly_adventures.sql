-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 12, 2026 at 07:16 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `globefly_adventures`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `bookable_type` varchar(255) NOT NULL,
  `bookable_id` bigint(20) UNSIGNED NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `payment_status` varchar(255) NOT NULL DEFAULT 'pending',
  `payment_method` varchar(255) DEFAULT NULL,
  `special_requests` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel_cache_sourikgoswami123@gmail.com|127.0.0.1', 'i:1;', 1783875626),
('laravel_cache_sourikgoswami123@gmail.com|127.0.0.1:timer', 'i:1783875626;', 1783875626);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chat_messages`
--

CREATE TABLE `chat_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `message` text NOT NULL,
  `is_bot` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `destinations`
--

CREATE TABLE `destinations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `location` varchar(255) NOT NULL,
  `coordinates` varchar(255) DEFAULT NULL,
  `weather_info` text DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `destinations`
--

INSERT INTO `destinations` (`id`, `name`, `slug`, `description`, `location`, `coordinates`, `weather_info`, `image_url`, `created_at`, `updated_at`) VALUES
(1, 'Taj Mahal', 'taj-mahal', 'Witness the world-famous white marble architectural masterpiece built by Emperor Shah Jahan in memory of his beloved wife Mumtaz Mahal. A timeless symbol of love.', 'Agra, India', '27.1751, 78.0421', 'Pleasant winters (10°C - 20°C). Summers are hot. Sunset or sunrise visits offer the most breathtaking views.', 'https://images.unsplash.com/photo-1564507592333-c60657eea523?auto=format&fit=crop&w=1200&q=80', '2026-07-12 11:27:37', '2026-07-12 11:27:37'),
(2, 'Kerala Backwaters', 'kerala-backwaters', 'Unwind in \"God\'s Own Country\", featuring serene palm-fringed houseboats, emerald green lagoons, spice plantations, and ancient Ayurvedic wellness sanctuaries.', 'Kerala, India', '10.8505, 76.2711', 'Tropical warm climate (24°C - 32°C). Monsoon season (June to September) is perfect for traditional Ayurvedic treatments.', 'https://images.unsplash.com/photo-1593693397690-362cb9666fc2?auto=format&fit=crop&w=1200&q=80', '2026-07-12 11:27:37', '2026-07-12 11:27:37'),
(3, 'Goa Beaches', 'goa-beaches', 'A sparkling coastal paradise blending historical Portuguese architecture, golden sand beaches, thrilling water sports, and beach shacks serving local seafood.', 'Goa, India', '15.2993, 74.1240', 'Tropical maritime (22°C - 32°C). Best beach climate spans from October to February.', 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1200&q=80', '2026-07-12 11:27:37', '2026-07-12 11:27:37'),
(4, 'Jaipur Pink City', 'jaipur', 'Discover the magnificent royal forts, imperial palaces, and colorful bazaars of Rajasthan\'s capital, characterized by its distinctive pink-painted heritage buildings.', 'Rajasthan, India', '26.9124, 75.7873', 'Dry warm climate. Cool winter evenings (8°C - 20°C) make it perfect for sightseeing.', 'https://images.unsplash.com/photo-1599661046289-e31897846e41?auto=format&fit=crop&w=1200&q=80', '2026-07-12 11:27:37', '2026-07-12 11:27:37'),
(5, 'Ladakh Peaks', 'ladakh', 'A high-altitude paradise featuring dramatic snow-capped passes, pristine deep-blue lakes like Pangong Tso, and century-old Buddhist monasteries.', 'Ladakh, India', '34.1526, 77.5770', 'Cold desert alpine. Bright summer days (15°C - 25°C), while winters drop far below freezing.', 'https://images.unsplash.com/photo-1598091383021-15ddea10925d?auto=format&fit=crop&w=1200&q=80', '2026-07-12 11:27:37', '2026-07-12 11:27:37'),
(6, 'Paris', 'paris', 'The world capital of art, fashion, gastronomy, and culture. Adorned with 19th-century streetscapes, the Eiffel Tower, Louvre Museum, and romantic Seine river cruises.', 'Paris, France', '48.8566, 2.3522', 'Temperate climate (5°C in winter, 25°C in summer). Spring (April-June) and Autumn (Sept-Nov) are highly recommended.', 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?auto=format&fit=crop&w=1200&q=80', '2026-07-12 11:27:37', '2026-07-12 11:27:37'),
(7, 'Kyoto Zen Gardens', 'kyoto', 'Immerse in Japan\'s historic imperial heart, famous for hundreds of classical Zen temples, Shinto shrines, traditional wooden houses, and cherry blossom viewpoints.', 'Kyoto, Japan', '35.0116, 135.7681', 'Humid temperate. Spring cherry blossoms (April) and Autumn maple foliage (November) are visually magnificent.', 'https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?auto=format&fit=crop&w=1200&q=80', '2026-07-12 11:27:37', '2026-07-12 11:27:37'),
(8, 'Bali Tropical Island', 'bali', 'An exotic Indonesian island celebrated for its forested volcanic mountains, iconic terraced rice paddies, sandy beaches, and rich cultural heritage.', 'Bali, Indonesia', '-8.4095, 115.1889', 'Tropical monsoon (26°C - 31°C). Dry season runs from April to October and is perfect for coastal adventures.', 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=1200&q=80', '2026-07-12 11:27:37', '2026-07-12 11:27:37'),
(9, 'Swiss Alps', 'swiss-alps', 'A jaw-dropping alpine wonderland. Travel on cogwheel railways to snow-covered peaks, hike pristine meadows, and stay in cozy Swiss chalets overlooking turquoise lakes.', 'Interlaken, Switzerland', '46.6863, 7.8632', 'Alpine climate. Perfect for summer hiking (June-August) or winter alpine skiing (December-March).', 'https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?auto=format&fit=crop&w=1200&q=80', '2026-07-12 11:27:37', '2026-07-12 11:27:37'),
(10, 'Dubai Modern Oasis', 'dubai', 'A futuristic desert metropolis famous for high-end luxury shopping, ultra-modern architecture like Burj Khalifa, dune-bashing safaris, and lively nightlife.', 'Dubai, UAE', '25.2048, 55.2708', 'Hot desert climate. Best traveled during cooler winter months (November to March, 18°C - 28°C).', 'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?auto=format&fit=crop&w=1200&q=80', '2026-07-12 11:27:37', '2026-07-12 11:27:37'),
(11, 'Manali Valleys', 'manali', 'A popular high-altitude Himalayan resort town known for backpacking, skiing, paragliding, rafting, and the stunning Solang and Rohtang Valleys.', 'Himachal Pradesh, India', '32.2396, 77.1887', 'Cold alpine climate. Snowy winters (-2°C to 10°C) and pleasant summers (10°C to 25°C). Ideal for snow sports.', 'https://images.unsplash.com/photo-1605649487212-47bdab064df7?auto=format&fit=crop&w=1200&q=80', '2026-07-12 11:27:37', '2026-07-12 11:27:37'),
(12, 'Varanasi Ganga Ghats', 'varanasi', 'One of the oldest continuously inhabited cities in the world. Famous for its spiritual river ghats, winding alleyways, and the divine evening Ganga Aarti.', 'Uttar Pradesh, India', '25.3176, 82.9739', 'Humid subtropical. Best visited in cooler winter months (October to March, 10°C to 25°C) to witness daily rituals.', 'https://images.unsplash.com/photo-1561361060-6644fcfc5a45?auto=format&fit=crop&w=1200&q=80', '2026-07-12 11:27:37', '2026-07-12 11:27:37'),
(13, 'New York City', 'new-york', 'The Big Apple. An iconic metropolis featuring towering skyscrapers, Broadway theater, Central Park, and the historic Statue of Liberty.', 'New York, USA', '40.7128, -74.0060', 'Humid continental. Hot summers (18°C to 28°C) and snowy, scenic winters (-3°C to 5°C).', 'https://images.unsplash.com/photo-1496442226666-8d4d0e62e6e9?auto=format&fit=crop&w=1200&q=80', '2026-07-12 11:27:37', '2026-07-12 11:27:37'),
(14, 'Rome Historic Center', 'rome', 'The Eternal City. Imbibed with thousands of years of art, architecture, and history, featuring the Colosseum, Roman Forum, and Vatican City.', 'Rome, Italy', '41.9028, 12.4964', 'Mediterranean climate (7°C in winter, 30°C in summer). Perfect for foot explorations in Spring/Autumn.', 'https://images.unsplash.com/photo-1552832230-c0197dd311b5?auto=format&fit=crop&w=1200&q=80', '2026-07-12 11:27:37', '2026-07-12 11:27:37'),
(15, 'London Capital', 'london', 'A royal historic capital situated on the River Thames. Highlights include Tower Bridge, the London Eye, Buckingham Palace, and world-class museums.', 'London, UK', '51.5074, -0.1278', 'Temperate maritime (4°C to 22°C). Light rain is common; carrying an umbrella is recommended.', 'https://images.unsplash.com/photo-1513635269975-59663e0ca1ad?auto=format&fit=crop&w=1200&q=80', '2026-07-12 11:27:37', '2026-07-12 11:27:37');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `trip_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `category` varchar(255) NOT NULL,
  `expense_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
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
-- Table structure for table `hotels`
--

CREATE TABLE `hotels` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `location` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `star_rating` int(11) NOT NULL DEFAULT 3,
  `hotel_partner_id` bigint(20) UNSIGNED NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hotels`
--

INSERT INTO `hotels` (`id`, `name`, `description`, `location`, `address`, `star_rating`, `hotel_partner_id`, `image_url`, `created_at`, `updated_at`) VALUES
(1, 'The Imperial Agra Palace', 'A heritage palace offering premium suites with private terraces showcasing panoramic views of the Taj Mahal. Experience Michelin-standard Mughlai fine dining.', 'Agra, Uttar Pradesh, India', 'Taj East Gate Road, Agra, 282001', 5, 3, 'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=600&q=80', '2026-07-12 11:27:37', '2026-07-12 11:27:37'),
(2, 'Kumarakom Backwater Sanctuary', 'Waterfront luxury villas positioned on the banks of Lake Vembanad. Offers Ayurvedic wellness retreats, private lake boat tours, and natural herbal gardens.', 'Kumarakom, Kottayam, Kerala, India', 'Vembanad Lake Shore, Kumarakom, 686563', 4, 3, 'https://images.unsplash.com/photo-1544735716-392fe2489ffa?auto=format&fit=crop&w=600&q=80', '2026-07-12 11:27:37', '2026-07-12 11:27:37'),
(3, 'The Palms Shore Resort', 'Direct beachfront access on clean sands. Features beautiful infinity pools overlooking the Arabian Sea, private cabanas, wellness spas, and vibrant beach shacks.', 'Candolim, Goa, India', 'Candolim Beach Road, North Goa, 403515', 5, 3, 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?auto=format&fit=crop&w=600&q=80', '2026-07-12 11:27:37', '2026-07-12 11:27:37'),
(4, 'Le Parisien Luxury Boutique', 'An elegant Parisian palace hotel featuring classical French styling and balconies overlooking the Eiffel Tower. Features Michelin-starred French fine dining.', 'Paris, France', '15 Avenue Montaigne, Paris, 75008', 5, 3, 'https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?auto=format&fit=crop&w=600&q=80', '2026-07-12 11:27:37', '2026-07-12 11:27:37'),
(5, 'Kyoto Ryokan Kura', 'A luxury traditional Japanese inn featuring tatami flooring, sliding shoji screens, cypress wood baths, and private zen garden views.', 'Kyoto, Japan', '45 Gionmachi Minamigawa, Kyoto, 605-0074', 5, 3, 'https://images.unsplash.com/photo-1621293954908-907159247fc8?auto=format&fit=crop&w=600&q=80', '2026-07-12 11:27:37', '2026-07-12 11:27:37'),
(6, 'Ubud Hanging Gardens Resort', 'Nestled in deep tropical rainforest cliffs, this hotel boasts world-renowned split-level infinity pools and luxury open-air eco pavilions.', 'Ubud, Bali, Indonesia', 'Desa Buahan, Payangan, Gianyar, Bali, 80572', 5, 3, 'https://images.unsplash.com/photo-1571896349842-33c89424de2d?auto=format&fit=crop&w=600&q=80', '2026-07-12 11:27:37', '2026-07-12 11:27:37'),
(7, 'Interlaken Alpine Lodge', 'A premier mountain resort showcasing sweeping panoramas of the Eiger and Jungfrau peaks, outdoor thermal pools, and cozy timber fireplace lounges.', 'Interlaken, Switzerland', 'Höheweg 95, Interlaken, 3800', 4, 3, 'https://images.unsplash.com/photo-1502784444187-359ac186c5bb?auto=format&fit=crop&w=600&q=80', '2026-07-12 11:27:37', '2026-07-12 11:27:37'),
(8, 'Burj Al Arab Suite Collection', 'Experience absolute luxury. The iconic sail-shaped hotel offers double-story suites, private butler service, underwater restaurants, and private beach access.', 'Dubai, UAE', 'Jumeirah Beach Road, Dubai, 74107', 5, 3, 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=600&q=80', '2026-07-12 11:27:37', '2026-07-12 11:27:37'),
(9, 'The Raj Heritage Palace & Haveli', 'A restored Rajasthani royal palace featuring grand central courtyards, traditional block-print wall frescoes, traditional puppet shows, and local folk musicians.', 'Jaipur, Rajasthan, India', 'Subhash Chowk, Amer Road, Jaipur, 302002', 5, 3, 'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?auto=format&fit=crop&w=600&q=80', '2026-07-12 11:27:37', '2026-07-12 11:27:37'),
(10, 'Ganges View Heritage Lodge', 'A historic waterfront guest mansion located directly on Varanasi Ghats. Enjoy direct rooftop terrace views of the Ganga river morning rituals.', 'Varanasi, Uttar Pradesh, India', 'Kedar Ghat, Varanasi, 221001', 4, 3, 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=600&q=80', '2026-07-12 11:27:37', '2026-07-12 11:27:37'),
(11, 'Himalayan Wood Cabin Resort', 'A rustic alpine style lodging featuring pinewood structures, warm fireplace lounges, and balconies showcasing breathtaking snow peaks views.', 'Manali, Himachal Pradesh, India', 'Hadimba Temple Road, Manali, 175131', 4, 3, 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?auto=format&fit=crop&w=600&q=80', '2026-07-12 11:27:37', '2026-07-12 11:27:37');

-- --------------------------------------------------------

--
-- Table structure for table `hotel_rooms`
--

CREATE TABLE `hotel_rooms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `hotel_id` bigint(20) UNSIGNED NOT NULL,
  `room_type` varchar(255) NOT NULL,
  `price_per_night` decimal(10,2) NOT NULL,
  `capacity` int(11) NOT NULL,
  `amenities` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`amenities`)),
  `is_available` tinyint(1) NOT NULL DEFAULT 1,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hotel_rooms`
--

INSERT INTO `hotel_rooms` (`id`, `hotel_id`, `room_type`, `price_per_night`, `capacity`, `amenities`, `is_available`, `image_url`, `created_at`, `updated_at`) VALUES
(1, 1, 'Taj Heritage Balcony Suite', 12500.00, 2, '[\"High-speed WiFi\",\"Central Air Conditioning\",\"Smart Flat TV\",\"King Size Bed\",\"Complimentary Minibar\",\"Taj Mahal Balcony View\",\"24\\/7 Butler Service\"]', 1, 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=600&q=80', '2026-07-12 11:27:37', '2026-07-12 11:27:37'),
(2, 1, 'Deluxe Garden Room', 6500.00, 2, '[\"High-speed WiFi\",\"Air Conditioning\",\"Flat TV\",\"Twin Beds\",\"Tea Maker\",\"Palace Garden View\"]', 1, 'https://images.unsplash.com/photo-1566665797739-1674de7a421a?auto=format&fit=crop&w=600&q=80', '2026-07-12 11:27:37', '2026-07-12 11:27:37'),
(3, 2, 'Ayurveda Heritage Cottage', 8900.00, 3, '[\"High-speed WiFi\",\"Yukata & Spa Robes\",\"Traditional Wooden Decor\",\"Ayurveda Herb Set\",\"Lake View Balcony\",\"Wellness Spa Access\"]', 1, 'https://images.unsplash.com/photo-1602002418082-a4443e081dd1?auto=format&fit=crop&w=600&q=80', '2026-07-12 11:27:37', '2026-07-12 11:27:37'),
(4, 3, 'Palms Ocean Villa with Plunge Pool', 18000.00, 4, '[\"High-speed WiFi\",\"Air Conditioning\",\"Private Plunge Pool\",\"Direct White Sand Beach Access\",\"Outdoor Open Bath\",\"Mini Kitchenette\"]', 1, 'https://images.unsplash.com/photo-1582719508461-905c673771fd?auto=format&fit=crop&w=600&q=80', '2026-07-12 11:27:37', '2026-07-12 11:27:37'),
(5, 4, 'Eiffel Tower View Executive Suite', 35000.00, 2, '[\"Eiffel Tower View Balcony\",\"High-speed WiFi\",\"Complimentary Champagne\",\"Nespresso Machine\",\"Luxury Marble Bath\",\"VIP Lounge Access\"]', 1, 'https://images.unsplash.com/photo-1560185007-cde436f6a4d0?auto=format&fit=crop&w=600&q=80', '2026-07-12 11:27:37', '2026-07-12 11:27:37'),
(6, 5, 'Traditional Tatami Deluxe Suite', 22000.00, 3, '[\"Futon Bedding\",\"Private Onsen Bath\",\"Zen Garden View\",\"Japanese Tea Set\",\"Yukata Robes\",\"Breakfast Included\"]', 1, 'https://images.unsplash.com/photo-1621293954908-907159247fc8?auto=format&fit=crop&w=600&q=80', '2026-07-12 11:27:37', '2026-07-12 11:27:37'),
(7, 6, 'Luxury Pool Panoramic Villa', 18000.00, 2, '[\"Private Infinity Pool\",\"Valley Canopy View\",\"Outdoor Daybed\",\"Mini-bar\",\"Open-Air Shower\",\"Spa Credits Included\"]', 1, 'https://images.unsplash.com/photo-1571896349842-33c89424de2d?auto=format&fit=crop&w=600&q=80', '2026-07-12 11:27:37', '2026-07-12 11:27:37'),
(8, 7, 'Eiger Mountain View Suite', 42000.00, 2, '[\"Alpine Balcony View\",\"Timber Fireplace\",\"Ski Room Storage\",\"Complimentary Breakfast buffet\",\"Luxury Linens\",\"Sauna Entry Passes\"]', 1, 'https://images.unsplash.com/photo-1598928506311-c55ded91a200?auto=format&fit=crop&w=600&q=80', '2026-07-12 11:27:37', '2026-07-12 11:27:37'),
(9, 8, 'Deluxe Marina Panoramic Suite', 85000.00, 4, '[\"24\\/7 Private Butler\",\"Full Sea View Balcony\",\"Macallan Whiskey Decanter\",\"Private Jacuzzi\",\"Gold leaf details\",\"Helipad Arrival option\"]', 1, 'https://images.unsplash.com/photo-1591088398332-8a7791972843?auto=format&fit=crop&w=600&q=80', '2026-07-12 11:27:37', '2026-07-12 11:27:37'),
(10, 9, 'Royal Maharaja Courtyard Suite', 9500.00, 2, '[\"King Heritage Bed\",\"Courtyard View Balcony\",\"Traditional Rajasthani Decor\",\"High-speed WiFi\",\"Welcome Fruit Platter\",\"Central Air Conditioning\"]', 1, 'https://images.unsplash.com/photo-1578683010236-d716f9a3f461?auto=format&fit=crop&w=600&q=80', '2026-07-12 11:27:37', '2026-07-12 11:27:37'),
(11, 10, 'Ganga River Ghat Balcony Room', 4500.00, 2, '[\"Ganges View Balcony\",\"Air Conditioning\",\"Free Morning Tea\",\"High-speed WiFi\",\"Historic Stone Interiors\",\"Hot Shower\"]', 1, 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=600&q=80', '2026-07-12 11:27:37', '2026-07-12 11:27:37'),
(12, 11, 'Mountain View Pine Wood Room', 5500.00, 3, '[\"Private Fireplace\",\"Balcony with Peak Views\",\"Pinewood Paneling\",\"Cozy Electric Blankets\",\"Tea\\/Coffee Maker\",\"Complimentary Breakfast\"]', 1, 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?auto=format&fit=crop&w=600&q=80', '2026-07-12 11:27:37', '2026-07-12 11:27:37');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
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
-- Table structure for table `job_batches`
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
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_06_20_200828_create_destinations_table', 1),
(5, '2026_06_20_200828_create_tour_packages_table', 1),
(6, '2026_06_20_200829_create_hotels_table', 1),
(7, '2026_06_20_200829_create_vehicles_table', 1),
(8, '2026_06_20_200830_create_bookings_table', 1),
(9, '2026_06_20_200830_create_trips_table', 1),
(10, '2026_06_20_200831_create_chat_messages_table', 1),
(11, '2026_06_20_200832_create_hotel_rooms_table', 1),
(12, '2026_06_20_200835_create_expenses_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
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
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('k4nRyXz26Ppda9S1Qi53QTm2sDy2nBkY5ndjgwqF', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUkFmMjZ1Mm9peDhmN1dvU2k3QXp6Yzh6dnVvdENUN2M3a3QwdHlSTSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9fQ==', 1783875745);

-- --------------------------------------------------------

--
-- Table structure for table `tour_packages`
--

CREATE TABLE `tour_packages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `duration_days` int(11) NOT NULL,
  `destination_id` bigint(20) UNSIGNED NOT NULL,
  `tour_manager_id` bigint(20) UNSIGNED NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `max_slots` int(11) NOT NULL,
  `available_slots` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tour_packages`
--

INSERT INTO `tour_packages` (`id`, `name`, `description`, `price`, `duration_days`, `destination_id`, `tour_manager_id`, `image_url`, `max_slots`, `available_slots`, `start_date`, `end_date`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Golden Triangle & Taj Mahal Heritage', 'Explore the majestic Taj Mahal in Agra, Agra Red Fort, and Delhi\'s imperial quarters. Package includes fast-track entry tickets, private local guide, luxury hotel stay, and traditional North Indian culinary experiences.', 24999.00, 4, 1, 2, 'https://images.unsplash.com/photo-1548013146-72479768bada?auto=format&fit=crop&w=600&q=80', 15, 15, '2026-07-15', '2026-07-19', 'active', '2026-07-12 11:27:37', '2026-07-12 11:27:37'),
(2, 'Kerala Backwaters & Houseboat Cruise', 'Relax on a private deluxe houseboat winding through Alleppey backwaters. Enjoy freshly prepared Keralite cuisine, tour spice plantations in Munnar, and experience therapeutic Ayurvedic massage sessions.', 32000.00, 6, 2, 2, 'https://images.unsplash.com/photo-1593693397690-362cb9666fc2?auto=format&fit=crop&w=600&q=80', 12, 12, '2026-08-10', '2026-08-16', 'active', '2026-07-12 11:27:37', '2026-07-12 11:27:37'),
(3, 'Sunny Goa Beach Adventure', 'Indulge in an exciting coastal break in Goa. Includes beach parasailing, scuba diving, private heritage tours of Old Goa churches, seafood shack dinner credits, and resort stay near Candolim beach.', 18500.00, 5, 3, 2, 'https://images.unsplash.com/photo-1512343879784-a960bf40e7f2?auto=format&fit=crop&w=600&q=80', 20, 20, '2026-09-01', '2026-09-06', 'active', '2026-07-12 11:27:37', '2026-07-12 11:27:37'),
(4, 'Royal Jaipur & Rajasthani Desert Forts', 'Immerse in the royalty of Rajasthan. Visit Amer Fort, witness heritage puppet shows, stay at a restored heritage palace hotel, and experience a desert camel safari under the stars.', 27500.00, 5, 4, 2, 'https://images.unsplash.com/photo-1599661046289-e31897846e41?auto=format&fit=crop&w=600&q=80', 10, 10, '2026-07-28', '2026-08-02', 'active', '2026-07-12 11:27:37', '2026-07-12 11:27:37'),
(5, 'Ladakh High-Pass Adventure & Pangong Lake', 'Journey across high altitude roads. Tour ancient Buddhist monasteries in Leh, drive through Khardung La (one of the world\'s highest motorable passes), and camp alongside the pristine Pangong Lake.', 38000.00, 7, 5, 2, 'https://images.unsplash.com/photo-1598091383021-15ddea10925d?auto=format&fit=crop&w=600&q=80', 10, 10, '2026-08-20', '2026-08-27', 'active', '2026-07-12 11:27:37', '2026-07-12 11:27:37'),
(6, 'Eiffel Tower Romance & Parisian Art Tour', 'A dream European holiday. Skip-the-line Eiffel Tower summit tour, private Louvre guided art tour, scenic Seine River dining cruise, and high-end boutique hotel accommodations.', 149999.00, 7, 6, 2, 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?auto=format&fit=crop&w=600&q=80', 8, 8, '2026-09-10', '2026-09-17', 'active', '2026-07-12 11:27:37', '2026-07-12 11:27:37'),
(7, 'Kyoto Zen Temples & Heritage Tea Ceremony', 'Experience the rich culture of Japan. Walk the Golden Pavilion, stroll Fushimi Inari Shrine gates, witness an authentic geisha performance, and participate in a Zen tea ceremony.', 185000.00, 6, 7, 2, 'https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?auto=format&fit=crop&w=600&q=80', 10, 10, '2026-10-05', '2026-10-11', 'active', '2026-07-12 11:27:37', '2026-07-12 11:27:37'),
(8, 'Bali Exotic Beaches & Ubud Terraces', 'Unveil the magic of Bali. Relax at private beach clubs in Seminyak, hike the Mount Batur volcano at sunrise, explore Ubud\'s rice terraces, and visit the historic Uluwatu cliff temple.', 75000.00, 6, 8, 2, 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=600&q=80', 15, 15, '2026-09-20', '2026-09-26', 'active', '2026-07-12 11:27:37', '2026-07-12 11:27:37'),
(9, 'Swiss Alps Express & Jungfraujoch Peak', 'Indulge in unmatched alpine beauty. Ride the scenic Glacier Express, travel to \"Top of Europe\" at Jungfraujoch, stay in Interlaken chalets, and cruise Lake Thun.', 299999.00, 8, 9, 2, 'https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?auto=format&fit=crop&w=600&q=80', 6, 6, '2026-08-05', '2026-08-13', 'active', '2026-07-12 11:27:37', '2026-07-12 11:27:37'),
(10, 'Dubai Skyscraper Luxury & Desert Safari', 'Immerse yourself in modern luxury. Access the Burj Khalifa 124th floor, explore Dubai Mall, experience VIP desert dune bashing, and dine in a luxury Bedouin camp under the stars.', 110000.00, 5, 10, 2, 'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?auto=format&fit=crop&w=600&q=80', 12, 12, '2026-11-12', '2026-11-17', 'active', '2026-07-12 11:27:37', '2026-07-12 11:27:37'),
(11, 'Manali Alpine Snow Adventure & Solang Valley Trek', 'Spend a winter wonderland trip in Manali. Enjoy private paragliding in Solang Valley, walk through historical Vashisht temples, and explore Solang snow fields.', 21000.00, 4, 11, 2, 'https://images.unsplash.com/photo-1605649487212-47bdab064df7?auto=format&fit=crop&w=600&q=80', 15, 15, '2026-12-10', '2026-12-14', 'active', '2026-07-12 11:27:37', '2026-07-12 11:27:37'),
(12, 'Varanasi Spiritual Ganges River Ghats & Aarti', 'A unique spiritual retreat. Take a sunrise boat ride on the holy Ganges River, stroll ancient Varanasi lanes, and watch the grand evening Ganga Aarti rituals.', 14500.00, 3, 12, 2, 'https://images.unsplash.com/photo-1561361060-6644fcfc5a45?auto=format&fit=crop&w=600&q=80', 20, 20, '2026-10-15', '2026-10-18', 'active', '2026-07-12 11:27:37', '2026-07-12 11:27:37'),
(13, 'New York Skyscraper Broadway & Central Park Tour', 'Unveil the magic of NYC. Access Top of the Rock observation deck, witness a live Broadway musical, stroll Central Park, and tour the Statue of Liberty.', 185000.00, 6, 13, 2, 'https://images.unsplash.com/photo-1496442226666-8d4d0e62e6e9?auto=format&fit=crop&w=600&q=80', 8, 8, '2026-09-18', '2026-09-24', 'active', '2026-07-12 11:27:37', '2026-07-12 11:27:37'),
(14, 'Rome Ancient Colosseum & Vatican Heritage Journey', 'Immerse in the Roman Empire. Stroll through the Colosseum, walk the Roman Forum, visit Vatican City St. Peter\'s Basilica, and make a wish at Trevi Fountain.', 139999.00, 5, 14, 2, 'https://images.unsplash.com/photo-1552832230-c0197dd311b5?auto=format&fit=crop&w=600&q=80', 10, 10, '2026-10-12', '2026-10-17', 'active', '2026-07-12 11:27:37', '2026-07-12 11:27:37'),
(15, 'London Royal Palaces & Thames Scenic Cruise', 'A royal British holiday. Explore the Tower of London, watch the changing of the guard at Buckingham Palace, and cruise the historic River Thames.', 155000.00, 6, 15, 2, 'https://images.unsplash.com/photo-1513635269975-59663e0ca1ad?auto=format&fit=crop&w=600&q=80', 12, 12, '2026-09-22', '2026-09-28', 'active', '2026-07-12 11:27:37', '2026-07-12 11:27:37');

-- --------------------------------------------------------

--
-- Table structure for table `trips`
--

CREATE TABLE `trips` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `destination` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `budget` decimal(10,2) NOT NULL,
  `preferences` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`preferences`)),
  `itinerary_data` longtext NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'traveler',
  `phone` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `phone`, `avatar`, `bio`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Aarav Sharma (Admin)', 'admin@globefly.com', NULL, '$2y$12$b6ECKAJpxrWJfeYz962kWenoaWqRYL.4hKZ8SEPk/I0rA7lhl0.da', 'admin', '+919876543210', 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=150&q=80', 'System administrator for the GlobeFly Adventures travel portal.', NULL, '2026-07-12 11:27:35', '2026-07-12 11:27:35'),
(2, 'Vikram Malhotra (Tour Manager)', 'manager@globefly.com', NULL, '$2y$12$J1Ha6XSQYPDAVVjMa2O19eqquKfT2Topj2G6RW1Kijl0fXFzwihOa', 'tour_manager', '+919876543211', 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=150&q=80', 'Experienced tour director organizing packages across beautiful Indian sites and cultural hubs.', NULL, '2026-07-12 11:27:36', '2026-07-12 11:27:36'),
(3, 'Priyanka Sen (Hotel Partner)', 'partner@globefly.com', NULL, '$2y$12$f8j/hyZv.jPVqrAMIk4FfOmN1fcS6WwYFf0omvjEPogNPjR.TYmCC', 'hotel_partner', '+919876543212', 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=150&q=80', 'Boutique hotel developer focusing on unique cultural hospitality spaces in India.', NULL, '2026-07-12 11:27:36', '2026-07-12 11:27:36'),
(4, 'Rohan Joshi (Traveler)', 'traveler@globefly.com', NULL, '$2y$12$JTRKKfBulo5i8Sa..wBNyel0zxk8zL0RF0c/JFm26N/5C/qxVe/a.', 'traveler', '+919876543213', 'https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?auto=format&fit=crop&w=150&q=80', 'Explorer seeking historical trails, natural backwaters, beach escapes, and deep cultural immersions.', NULL, '2026-07-12 11:27:37', '2026-07-12 11:27:37'),
(5, 'Sourik Goswami', 'sourikgoswami182@gmail.com', NULL, '$2y$12$Cns7SvksQErpkRsv7kC7bOBWv2nc8JmBuSBln848z2EXOeYWvX9a2', 'traveler', NULL, NULL, NULL, NULL, '2026-07-12 11:31:06', '2026-07-12 11:31:06');

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `price_per_day` decimal(10,2) NOT NULL,
  `capacity` int(11) NOT NULL,
  `provider_name` varchar(255) NOT NULL,
  `is_available` tinyint(1) NOT NULL DEFAULT 1,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`id`, `name`, `type`, `price_per_day`, `capacity`, `provider_name`, `is_available`, `image_url`, `created_at`, `updated_at`) VALUES
(1, 'Mahindra XUV700', 'SUV (Premium)', 3500.00, 7, 'Bharat Wheels Rentals', 1, 'https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?auto=format&fit=crop&w=600&q=80', '2026-07-12 11:27:37', '2026-07-12 11:27:37'),
(2, 'Force Traveller Luxury', 'Minibus', 6000.00, 15, 'Royal Tour Transports', 1, 'https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?auto=format&fit=crop&w=600&q=80', '2026-07-12 11:27:37', '2026-07-12 11:27:37'),
(3, 'Tata Safari Gold', 'SUV (Premium)', 4500.00, 6, 'Elite Auto Drive India', 1, 'https://images.unsplash.com/photo-1606016159991-dfe4f2746ad5?auto=format&fit=crop&w=600&q=80', '2026-07-12 11:27:37', '2026-07-12 11:27:37'),
(4, 'BMW 5 Series', 'Sedan (Luxury)', 12000.00, 4, 'Elite Executive Transports', 1, 'https://images.unsplash.com/photo-1555215695-3004980ad54e?auto=format&fit=crop&w=600&q=80', '2026-07-12 11:27:37', '2026-07-12 11:27:37'),
(5, 'Maruti Suzuki Swift', 'Hatchback (Budget)', 1200.00, 5, 'Bharat Wheels Rentals', 1, 'https://images.unsplash.com/photo-1549399542-7e3f8b79c341?auto=format&fit=crop&w=600&q=80', '2026-07-12 11:27:37', '2026-07-12 11:27:37'),
(6, 'Hyundai i20 Elite', 'Hatchback (Standard)', 1500.00, 5, 'Bharat Wheels Rentals', 1, 'https://images.unsplash.com/photo-1605559424843-9e4c228bf1c2?auto=format&fit=crop&w=600&q=80', '2026-07-12 11:27:37', '2026-07-12 11:27:37'),
(7, 'Honda City ZX', 'Sedan (Standard)', 2200.00, 5, 'Bharat Wheels Rentals', 1, 'https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?auto=format&fit=crop&w=600&q=80', '2026-07-12 11:27:37', '2026-07-12 11:27:37'),
(8, 'Tata Nexon EV', 'SUV (Standard)', 2000.00, 5, 'Bharat Wheels Rentals', 1, 'https://images.unsplash.com/photo-1568605117036-5fe5e7bab0b7?auto=format&fit=crop&w=600&q=80', '2026-07-12 11:27:37', '2026-07-12 11:27:37'),
(9, 'Toyota Innova Crysta', 'MUV (Premium)', 3500.00, 7, 'Bharat Wheels Rentals', 1, 'https://images.unsplash.com/photo-1583121274602-3e2820c69888?auto=format&fit=crop&w=600&q=80', '2026-07-12 11:27:37', '2026-07-12 11:27:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bookings_user_id_foreign` (`user_id`),
  ADD KEY `bookings_bookable_type_bookable_id_index` (`bookable_type`,`bookable_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chat_messages_user_id_foreign` (`user_id`);

--
-- Indexes for table `destinations`
--
ALTER TABLE `destinations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `destinations_slug_unique` (`slug`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expenses_trip_id_foreign` (`trip_id`),
  ADD KEY `expenses_user_id_foreign` (`user_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `hotels`
--
ALTER TABLE `hotels`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hotels_hotel_partner_id_foreign` (`hotel_partner_id`);

--
-- Indexes for table `hotel_rooms`
--
ALTER TABLE `hotel_rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hotel_rooms_hotel_id_foreign` (`hotel_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `tour_packages`
--
ALTER TABLE `tour_packages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tour_packages_destination_id_foreign` (`destination_id`),
  ADD KEY `tour_packages_tour_manager_id_foreign` (`tour_manager_id`);

--
-- Indexes for table `trips`
--
ALTER TABLE `trips`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trips_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `destinations`
--
ALTER TABLE `destinations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hotels`
--
ALTER TABLE `hotels`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `hotel_rooms`
--
ALTER TABLE `hotel_rooms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tour_packages`
--
ALTER TABLE `tour_packages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `trips`
--
ALTER TABLE `trips`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD CONSTRAINT `chat_messages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `expenses_trip_id_foreign` FOREIGN KEY (`trip_id`) REFERENCES `trips` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `expenses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `hotels`
--
ALTER TABLE `hotels`
  ADD CONSTRAINT `hotels_hotel_partner_id_foreign` FOREIGN KEY (`hotel_partner_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `hotel_rooms`
--
ALTER TABLE `hotel_rooms`
  ADD CONSTRAINT `hotel_rooms_hotel_id_foreign` FOREIGN KEY (`hotel_id`) REFERENCES `hotels` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tour_packages`
--
ALTER TABLE `tour_packages`
  ADD CONSTRAINT `tour_packages_destination_id_foreign` FOREIGN KEY (`destination_id`) REFERENCES `destinations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tour_packages_tour_manager_id_foreign` FOREIGN KEY (`tour_manager_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `trips`
--
ALTER TABLE `trips`
  ADD CONSTRAINT `trips_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
