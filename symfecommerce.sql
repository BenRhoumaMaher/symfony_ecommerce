-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 15, 2024 at 05:42 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `symfecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `add_product_history`
--

CREATE TABLE `add_product_history` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `qte` int(11) NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `add_product_history`
--

INSERT INTO `add_product_history` (`id`, `product_id`, `qte`, `created_at`) VALUES
(5, 6, 5, '2024-08-14 14:33:17'),
(6, 7, 4, '2024-08-14 14:36:11'),
(7, 8, 7, '2024-08-14 14:38:32'),
(8, 9, 10, '2024-08-14 14:41:05'),
(9, 10, 11, '2024-08-14 14:46:06'),
(10, 11, 15, '2024-08-14 14:48:32'),
(11, 12, 12, '2024-08-14 14:52:25'),
(12, 13, 17, '2024-08-14 14:53:24'),
(13, 14, 10, '2024-08-14 14:56:20'),
(14, 15, 13, '2024-08-14 14:57:25'),
(15, 16, 9, '2024-08-14 14:58:41'),
(16, 17, 18, '2024-08-14 14:59:38'),
(17, 18, 15, '2024-08-14 15:11:01'),
(18, 19, 25, '2024-08-14 15:13:14'),
(19, 20, 11, '2024-08-14 15:15:13'),
(20, 21, 22, '2024-08-14 15:16:16'),
(21, 22, 50, '2024-08-14 15:31:02'),
(22, 23, 60, '2024-08-14 15:32:20'),
(23, 24, 36, '2024-08-14 15:34:13'),
(24, 25, 12, '2024-08-14 15:35:06'),
(25, 26, 80, '2024-08-14 15:39:44'),
(26, 27, 17, '2024-08-14 15:40:48'),
(27, 28, 55, '2024-08-14 15:41:51'),
(28, 29, 70, '2024-08-14 15:43:10'),
(29, 30, 18, '2024-08-14 15:49:50'),
(30, 31, 99, '2024-08-14 15:50:54'),
(31, 32, 88, '2024-08-14 15:52:05'),
(32, 33, 52, '2024-08-14 16:08:59'),
(33, 34, 10, '2024-08-14 16:10:00'),
(34, 35, 50, '2024-08-14 16:10:56'),
(35, 36, 100, '2024-08-14 16:12:38'),
(36, 37, 200, '2024-08-14 16:17:30'),
(37, 38, 200, '2024-08-14 16:18:46'),
(38, 39, 250, '2024-08-14 16:20:15'),
(39, 40, 220, '2024-08-14 16:21:14'),
(40, 41, 300, '2024-08-14 16:25:02'),
(41, 42, 20, '2024-08-14 16:25:49'),
(42, 44, 25, '2024-08-14 16:27:49'),
(43, 45, 50, '2024-08-14 16:28:52'),
(44, 46, 10, '2024-08-14 16:32:03'),
(45, 47, 50, '2024-08-14 16:33:19'),
(46, 48, 30, '2024-08-14 16:34:40'),
(47, 49, 15, '2024-08-14 16:35:52'),
(48, 50, 60, '2024-08-14 16:40:22'),
(49, 51, 70, '2024-08-14 16:41:36'),
(50, 52, 15, '2024-08-14 16:42:59'),
(51, 53, 11, '2024-08-14 16:44:13'),
(52, 54, 70, '2024-08-14 16:51:35'),
(53, 55, 20, '2024-08-14 16:52:42'),
(54, 56, 16, '2024-08-14 16:53:39'),
(55, 57, 69, '2024-08-14 16:54:58'),
(56, 58, 22, '2024-08-14 16:59:02'),
(57, 59, 12, '2024-08-14 16:59:59'),
(58, 60, 40, '2024-08-14 17:01:00'),
(59, 61, 30, '2024-08-14 17:01:42'),
(60, 62, 30, '2024-08-14 17:04:01'),
(61, 63, 19, '2024-08-14 17:04:56'),
(62, 64, 80, '2024-08-14 17:06:38'),
(63, 65, 220, '2024-08-14 17:07:35'),
(64, 66, 10, '2024-08-14 17:09:59'),
(65, 67, 55, '2024-08-14 17:11:12'),
(66, 68, 66, '2024-08-14 17:12:18'),
(67, 69, 69, '2024-08-14 17:13:23');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(13, 'Electronics'),
(8, 'Home & Kitchen'),
(10, 'Jewelry & Accessories'),
(7, 'Men\'s Clothing');

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE `city` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `shipping_cost` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `city`
--

INSERT INTO `city` (`id`, `name`, `shipping_cost`) VALUES
(1, 'paris', 5),
(2, 'NewYork', 10),
(3, 'Tunis', 222);

-- --------------------------------------------------------

--
-- Table structure for table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20240722105306', '2024-07-22 12:53:20', 35),
('DoctrineMigrations\\Version20240722110422', '2024-07-22 13:04:27', 12),
('DoctrineMigrations\\Version20240805084250', '2024-08-05 10:43:00', 18),
('DoctrineMigrations\\Version20240811081937', '2024-08-11 10:19:45', 45),
('DoctrineMigrations\\Version20240811090357', '2024-08-11 11:04:01', 18),
('DoctrineMigrations\\Version20240811090532', '2024-08-11 11:05:36', 159),
('DoctrineMigrations\\Version20240811093223', '2024-08-11 11:32:27', 14),
('DoctrineMigrations\\Version20240811102513', '2024-08-11 12:25:16', 9),
('DoctrineMigrations\\Version20240811104334', '2024-08-11 12:43:38', 82),
('DoctrineMigrations\\Version20240811170744', '2024-08-11 19:07:49', 18),
('DoctrineMigrations\\Version20240811173213', '2024-08-11 19:32:17', 67),
('DoctrineMigrations\\Version20240811195011', '2024-08-11 21:50:16', 18),
('DoctrineMigrations\\Version20240811195850', '2024-08-11 21:58:53', 129),
('DoctrineMigrations\\Version20240812084154', '2024-08-12 10:41:59', 21),
('DoctrineMigrations\\Version20240812110029', '2024-08-12 13:00:36', 12),
('DoctrineMigrations\\Version20240812142457', '2024-08-12 16:25:02', 15),
('DoctrineMigrations\\Version20240812174002', '2024-08-12 19:40:13', 14),
('DoctrineMigrations\\Version20240814201402', '2024-08-14 22:14:18', 143),
('DoctrineMigrations\\Version20240814210021', '2024-08-14 23:00:24', 124),
('DoctrineMigrations\\Version20240814234236', '2024-08-15 01:42:42', 32),
('DoctrineMigrations\\Version20240815000137', '2024-08-15 02:01:41', 99);

-- --------------------------------------------------------

--
-- Table structure for table `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL,
  `body` longtext NOT NULL,
  `headers` longtext NOT NULL,
  `queue_name` varchar(190) NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `city_id` int(11) DEFAULT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `pay_on_delivery` tinyint(1) NOT NULL,
  `total_price` double NOT NULL,
  `is_completed` tinyint(1) DEFAULT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`id`, `city_id`, `first_name`, `last_name`, `phone`, `adresse`, `created_at`, `pay_on_delivery`, `total_price`, `is_completed`, `email`) VALUES
(25, 1, 'maher', 'maher', '896666', 'mm', '2024-08-15 02:01:58', 1, 13, 1, 'maher@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `order_products`
--

CREATE TABLE `order_products` (
  `id` int(11) NOT NULL,
  `_order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `qte` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_products`
--

INSERT INTO `order_products` (`id`, `_order_id`, `product_id`, `qte`) VALUES
(1, 25, 61, 1),
(2, 25, 49, 1);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` longtext DEFAULT NULL,
  `price` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `description`, `price`, `image`, `stock`) VALUES
(6, 'Shirt', 'Manfinity RSRT Men Plants Print Button Up Shirt Without Tee', 11, 'shirt-66bca40d4271c.png', 5),
(7, 'T-Shirt', 'Manfinity Homme Men\'s Summer Letter Print Round Neck Short Sleeve Casual T-Shirt', 12, 'tshirt-66bca4bbe224c.png', 4),
(8, 'Manfinity-Shirt', 'Manfinity Homme Men Letter Graphic Tee', 11, 'man-tshirt-66bca548d9040.png', 7),
(9, 'Gradient T-Shirt', 'Manfinity Homme Men\'s Gradient Short Sleeve T-Shirt For Summer', 11, 'Gradient-T-Shirt-66bca5e1536a9.png', 10),
(10, 'Hypemode', 'Manfinity Hypemode Men Letter Graphic Drawstring Cargo Loose Pants Long Plain Black Going Out', 20, 'Hypemode-66bca70eb484c.png', 11),
(11, 'Shorts', 'Manfinity Hypemode Men Drawstring Waist Letter Patched Shorts', 17, 'Shorts-66bca7a0119c4.png', 15),
(12, 'Elastic Shorts', 'Men Summer New Style Shorts, Trendy, Personality, Simple, Fashionable, Cow Pattern Printed, Elastic Waist With Drawstring, Casual, Sports, Fitness, Running Shorts', 14, 'elastic-shorts-66bca88915a8d.png', 12),
(13, 'Pocket Pants', 'Manfinity Homme Men Slant Pocket Drawstring Waist Pants', 23, 'pocket-pants-66bca8c4dc54a.png', 17),
(14, 'Sweatshirt', 'Manfinity Homme Men\'s Letter Printed Round Neck Sweatshirt', 16, 'sweetshirt-66bca9742bfd4.png', 10),
(15, 'Crown Sweatshirt', 'Manfinity Homme Men Crown & Letter Graphic Colorblock Sweatshirt', 19, 'crown-66bca9b5a0482.png', 13),
(16, 'Manfinity Sweatshirt', 'Manfinity Homme Men\'s Plus Size Digital Printed Drop Shoulder Sweatshirt', 24, 'manifest-66bcaa015f52c.png', 9),
(17, 'Hooded Sweatshirt', 'Plus Size Men\'s Letter Print Drawstring Hooded Sweatshirt, Autumn Winter', 27, 'boosted-66bcaa3aca739.png', 18),
(18, 'Skinny Jeans', 'Manfinity LEGND Men Plus Cotton Ripped Frayed Skinny Jeans Slim Fit Long Jean Cargo Plain Black Work Casual Size', 40, 'jeans-66bcace56c715.png', 15),
(19, 'Hypemode Short', 'Manfinity Hypemode Men\'s Drawstring Waist Loose Denim Shorts Baggy Knee Plain Dark Blue Going Out Basic Couple Matching', 30, 'short-66bcad6adae70.png', 25),
(20, 'Stylish Jeans', 'Men Slim Fit Stretch Patchwork Cotton Embroidered Distressed Print Stylish Jeans', 40, 'styleshit-66bcade16a615.png', 11),
(21, 'Ripped Jeans', 'Manfinity LEGND Men Cotton Ripped Jeans', 32, 'ripped-66bcae20856a9.png', 22),
(22, 'Vegetable Chopper', '12/16pcs Vegetable Chopper Set, Multifunctional Fruit Slicer, Manual Food Grinder, Vegetable Slicer, Containerized Cutter, Onion Chopper With Interchangeable Blades, For Home Use Potato Slicing, Kitchen Utensils, Kitchen Gadgets', 6, 'kit-66bcb19643587.png', 50),
(23, 'Faucet Extender', '1pc Creative 360° Rotatable Faucet Extender With 2 Modes-Longer, Spin, Splash-Proof Nozzle For Upgraded Kitchen Water Saving!', 2, 'faucet-66bcb1e482b63.png', 60),
(24, 'Tableware Drying Rack', 'Tableware Drying Rack, Utensil Rack With Drainage Board, Multifunctional Utensil Drain, Utensil Drying Rack With Cutting Board Rack, Utensil Rack, Cup Holder, Kitchen Accessories, High-End Kitchen Sink Box - Integrated Sponge Support - Multi-Purpose Kitchen Countertop Storage, Space Saving Kitchen Storage Rack, Sink Organizer, Pull-Out Cabinet Rack, Kitchen Bathroom Space Saving, Kitchen Accessories', 7, 'tableware-66bcb255748a6.png', 36),
(25, 'Cookware', '12pcs/Set Non-Stick Cookware Set With Bucket & Silicone Utensils, Kitchen Wooden Handle Tool Set', 4, 'cookware-66bcb28a8ea9a.png', 12),
(26, 'Apron', 'Lovely Waterproof & Oil-Proof Apron With Cactus And Fruit Print, Unisex Kitchen Cooking Coverall', 3, 'apron-66bcb3a023ba4.png', 80),
(27, 'Artificial Plant', '1pc 9/18 Leaves Artificial Plant, 13/22/29 Inches Tall, With Stems, Vivid Palm And Turtle Shell Bamboo Design, Perfect For Jungle, Beach, Hawaiian Party, Home Garden And Office With No Pot', 3, 'plant-66bcb3e0e5188.png', 17),
(28, 'BBQ', '1pc, BBQ Rack Corn Grill Basket, BBQ Corn Rack Grill Basket, Cron Clip Grid Rack For Fish Vegetable Steak Meat Shrimp Rack, Easy To Carry, BBQ Accessories, BBQ Accessories', 12, 'bbq-66bcb41f35f23.png', 55),
(29, 'Lawn Grass', '1pc Artificial Lawn Grass Moss DIY Decoration Material, Simulation Landscape Moss Outdoor Carpet Greenery', 1, 'grass-66bcb46ea42e1.png', 70),
(30, 'Crib Protectors', 'Baby Crib Protectors Hanging Mosquito Net Tent Kids Baby Bedding Dome Canopy Princess Bed Girl Room Decoration Bed Canopy Pest', 35, 'protector-66bcb5fecdd13.png', 18),
(31, 'Pillow', '1pc Long Pillow For Baby Sleeping, Stitching Weave Bedding Guard, Infant Toddler Soothing Side Lying Leg Cushion', 8, 'pillow-66bcb63e8b971.png', 99),
(32, 'Duvet Cover', '3pcs Solid Color Duvet Cover Set, 1pc Duvet Cover And 2pcs Pillow Case, Pillow Insert Not Include, Pink Fabric Bedding Set, For Bedroom', 22, 'cov-66bcb68576ad5.png', 88),
(33, 'LED Digital Clock', '1pc New Multifunctional LED Digital Clock Alarm Clock Battery/Plug-In Dual Power Sound Control Thermometer Hygrometer Countdown Timer', 12, 'clock-66bcba7bb7860.png', 52),
(34, 'Microwave', '1pc Fruit Pattern Microwave Oven Cover, Modern Microwave Oven Dust Cover, For Home For School,Office,Household,Travel', 2, 'microwave-66bcbab8496a6.png', 10),
(35, 'Slippers', '2pcs/Set Embroidered Cute Kitty Comfortable Linen Thick Sole Open Toe House Slippers For Women, Spring Summer', 12, 'sleepers-66bcbaf03ebb6.png', 50),
(36, 'Baby Carriage Windshield', '1pc Thickened Child Stroller Rain Cover, Baby Carriage Windshield, Sun Shade, Transparent Breathable Hand-Pushed Buggy Umbrella Raincoat Accessory For School,Office,Household,Travel', 10, 'cover-66bcbb55efec0.png', 100),
(37, 'Ring', '6pcs/Set Women\'s Emerald Ring, Minimalist Design With High-End And Luxurious Feeling, Adjustable Open Ring', 2, 'ring-66bcbc7a73e03.png', 200),
(38, 'Chain', '9pcs/set Creative Hollow Out Chain & Heart Shaped Ring, Minimalist Gemstone-embellished Ring Set', 2, 'chain-66bcbcc6185db.png', 200),
(39, 'Bracelet', '2pcs Fashionable Classic Black & White Clover Design Bracelet Set', 3, 'bracelet-66bcbd1f8aca8.png', 250),
(40, 'Couple Bracelets', '4pcs/Set Boho Style Multi-Layer Beaded Hollow Heart Charms Wood Bead Couple Bracelets, Handmade Suitable For Daily Wear', 3, 'couplet-brac-66bcbd5a460aa.png', 220),
(41, 'Necklace', '1pc 2mm Fashionable And Simple Stainless Steel Necklace, Unisex DIY Accessory Suitable For Any Occasion', 1, 'necklace-66bcbe3e478c9.png', 300),
(42, 'Watch', '3pcs Watch Matched Rhinestone Embellished Chain Bracelet Necklace Set, Unisex Hip Hop Style Shiny Daily Wear Jewelry', 15, 'watch-66bcbe6dc4a34.png', 20),
(44, 'chain necklace', '1pc Sparking Rhinestone Hip Hop Trendy Chain Necklace For Men And Women Perfect Present For Girl Friend And BoyFriend', 4, 'chain-nacklace-66bcbee599fa5.png', 25),
(45, 'Metal Finger Rings', 'Vintage Metal Finger Rings Set European And American Retro Style Fashionable Minimalist Design Sense Ring Combination', 2, 'finger-ring-66bcbf2477adc.png', 50),
(46, 'Sporty Watch', 'Trendy Men\'s Cyberpunk Futuristic Sporty Watch, Birthday Holiday Gift', 20, 'men-watch-66bcbfe3c76f3.png', 10),
(47, 'Wristwatch', '1pc Fashionable Business Calendar Men\'s Quartz Wristwatch With Stainless Steel Strap As A Gift For Students Returning To School', 5, 'bus-watch-66bcc02f1f167.png', 50),
(48, 'Quartz Wristwatch', '1pc French Fashionable Elegant Ladies\' Pearl Strap 30m Waterproof Oval Quartz Wristwatch For Daily Wear Holiday', 12, 'eleg-watch-66bcc08059783.png', 30),
(49, 'Luxury watch', '2 PCS/Set Ladies Elegant Butterfly Quartz Watch Luxury Fashion Stainless Steel Strap Watch And Bracelet, Suitable For Ladies Daily And Gifts For Women', 5, 'lux-watch-66bcc0c8d9df6.png', 15),
(50, 'Crystals Stones', 'Xiacheng 1/8/10/15/20pcs Random Heart Crystals Stones, Healing Crystal Palm Natural Polished Love Shaped Gemstones, Rose Quartz Amethyst Assorted Set, Bulk Wholesale Reiki Energy Balancing Meditation Gift', 1, 'crys-66bcc1d664c96.png', 60),
(51, 'Natural Stone', 'AA Natural Stone Gem Stone Beads Aquamarine Agate Amethyst Faceted Oval Shape Loose Spacer Beads For Jewerly Making DIY Gift Bracelets Necklace', 7, 'nat-stone-66bcc2202238b.png', 70),
(52, 'Aromatherapy Stones', '5-Piece Himalayan Salt Aromatherapy Stones Set - Perfect For Diffusers & Massage, Bohemian Style Crystal Decor', 5, 'himl-66bcc2739d487.png', 15),
(53, 'Tree Of Life', '7 Chakra Gemstone Tree Of Life - Crystal Tree - 7 Chakra Tree - Positive Energy Crystal Tree - Feng Shui - Energy Gemstone Tree - Money Tree - Home Decor - Thoughtful Gift For Family And Friends', 23, 'tree-66bcc2bda9cca.png', 11),
(54, 'Tablet Protective Case', 'Tablet Protective Case, Soft Anti-Fall Protection, Ultra-Thin/Smart Stand/Auto-Wake Protective Case For Ipad For IPad 9th Gen/IPad 10th Generation', 7, 'tablet-protc-66bcc4779edb1.png', 70),
(55, 'Laptop Stand', '1pc Wooden Laptop Stand, Elevated Gaming Laptop Stand, Elevated Computer Desktop Cooling Base', 10, 'woodern-lp-66bcc4bab1b25.png', 20),
(56, 'Wireless Keyboard', 'Wireless Keyboard, 10-Inch Ultra-Thin, Rechargeable, Silent, Wireless Keyboard For Tablets/Laptops, Mini Keyboard Compatible With IPad', 14, 'wirl-keyb-66bcc4f3ab258.png', 16),
(57, 'Handheld Fan', '1pc Handheld Fan With Strap, Portable, Self-Installed Battery And 1 Speed Settin', 3, 'fan-66bcc54200276.png', 69),
(58, 'Charger', '1-3 Set 20W Fast Charger + 100cm/3.3ft Type-C To Lightning Cable Compatible With IPhone 14/13/12/11/X/XS/XSMAX/8/7/6/SE Charging Adapter Se', 6, 'charg-66bcc636860c5.png', 22),
(59, 'Magnetic Cable', '3pcs Magnetic Cable Organizer Desktop Wire Clip Cord Holder For Mobile Phone Cable Management', 2, 'cable-66bcc66f63512.png', 12),
(60, 'Phone Stand', 'Rotatable Cell Phone Stand,Dual Folding Cell Phone Stand, Fully Adjustable Foldable Desktop Phone Holder Cradle Dock Compatible with iPhone15 iPhone15pro iPhone15promax iPhone14, iPhone13 Mini, iPhone13, iPhone13Pro Max, iPhone 12 Mini, 12, 12 Pro, 12 Pro Max, iPhone 11, 11 Pro, 11 Pro Max, Xs, Xs Max, XR, X, 8, 7 Samsung Galaxy S22 Ultra, S22+, S22, S21, S21+, S20, S20Ultra,S10 /S10+/S9 /S9+,Galaxy NOTE30 Note 20+ 20 10+ 10, M30s, A90, A60, A80,Switch, All Phones', 4, 'stand-66bcc6ace6acc.png', 40),
(61, 'Phone Case', 'Men A Phone Case With Mountain Blue Luminescence Pattern', 3, 'case-66bcc6d64f44c.png', 30),
(62, 'Indoor Camera', 'Reletech 1pc Indoor Security Camera Surveillance Motion Detection Baby/Pet Monitor Work With Alexa & Home', 30, 'int-cam-66bcc760f40e0.png', 30),
(63, 'Solar Camera', 'Reletech Solar Security Camera Wireless Outdoor, Rechargeable Battery Powered WiFi Surveillance Camera', 90, 'sol-cam-66bcc79877554.png', 19),
(64, 'Fire Detector', 'PGST PA-441 1PC Fire Smoke Detector Independent Smoke Alarm For Kitchen Smoke Sensor Fire Aafety Equipment Suitable For House Office Shop Smoke Leak Detector(Battery Not Included)', 8, 'fire-det-66bcc7fe060f3.png', 80),
(65, 'Camera Waterproof', 'Dual Lens 6MP(4MP+4MP) WiFi Bulb Surveillance Camera Waterproof Full Color Night Vision Wireless Security PTZ Camera E27 Interface Lamp CCTV Auto Tracking Two Way Audio Indoor Support TF Card Recording V380 Only Support 2.4G WiFi', 42, 'proof-66bcc837c1c4f.png', 220),
(66, 'Backpack', 'One Black Large Capacity Backpack With Water-Resistant Design For Carrying Basketball And 15.6-16 Inch Laptop Together', 60, 'backpack-66bcc8c747bcd.png', 10),
(67, 'IPad Case Back', '360 Rotating IPad Case Back Cover Shockproof High Anti-Pressure And Scratch Resistant, With Sleep And Wake-Up, Function Compatible With Built-In Pencil Holder And Flexible Viewing Angle-Navy Blue', 10, 'lap-case-66bcc910be023.png', 55),
(68, 'Laptop Sleeves', '1pc Sleeve Bag For Laptop, 12/13/14/15/16 Inch, Laptop Liner Bag, Bag Accessories For Book Air/ Pro//Dell, Laptop Bags, Protable Laptop Sleeves', 6, 'lap-sleev-66bcc952dd628.png', 66),
(69, 'Laptop Briefcase', '1pc Tecool Blue Laptop Bag For 13-16 Inch Notebook, Laptop Bags ForMacBook,IPad,HP Dell Acer Chromebook Surface Notebook,Laptop Briefcases', 16, 'brief-66bcc993ea6b3.png', 69);

-- --------------------------------------------------------

--
-- Table structure for table `product_sub_category`
--

CREATE TABLE `product_sub_category` (
  `product_id` int(11) NOT NULL,
  `sub_category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_sub_category`
--

INSERT INTO `product_sub_category` (`product_id`, `sub_category_id`) VALUES
(6, 4),
(7, 4),
(8, 4),
(9, 4),
(10, 5),
(11, 5),
(12, 5),
(13, 5),
(14, 6),
(15, 6),
(16, 6),
(17, 6),
(18, 8),
(19, 8),
(20, 8),
(21, 8),
(22, 13),
(23, 13),
(24, 13),
(25, 13),
(26, 17),
(27, 17),
(28, 17),
(29, 17),
(30, 19),
(31, 19),
(32, 19),
(33, 24),
(34, 24),
(35, 24),
(36, 24),
(37, 43),
(38, 43),
(39, 43),
(40, 43),
(41, 44),
(42, 44),
(44, 44),
(45, 44),
(46, 46),
(47, 46),
(48, 46),
(49, 46),
(50, 50),
(51, 50),
(52, 50),
(53, 50),
(54, 51),
(55, 51),
(56, 51),
(57, 51),
(58, 53),
(59, 53),
(60, 53),
(61, 53),
(62, 60),
(63, 60),
(64, 60),
(65, 60),
(66, 61),
(67, 61),
(68, 61),
(69, 61);

-- --------------------------------------------------------

--
-- Table structure for table `sub_category`
--

CREATE TABLE `sub_category` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_category`
--

INSERT INTO `sub_category` (`id`, `category_id`, `name`) VALUES
(4, 7, 'Tops'),
(5, 7, 'Pants, Shorts'),
(6, 7, 'Hoodies and Sweatshirts'),
(8, 7, 'Denim'),
(13, 8, 'Kitchen and Dining'),
(17, 8, 'Outdoor and Garden'),
(19, 8, 'Bedding'),
(24, 8, 'Household Products'),
(43, 10, 'Rings and bracelets for women'),
(44, 10, 'Fashion jewelry for men'),
(46, 10, 'Watches'),
(50, 10, 'Crystals and gemstones'),
(51, 13, 'Computer and office'),
(53, 13, 'Portable devices'),
(60, 13, 'Security cameras'),
(61, 13, 'Laptop bags and cases');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(180) NOT NULL,
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL COMMENT '(DC2Type:json)' CHECK (json_valid(`roles`)),
  `password` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `first_name`, `last_name`) VALUES
(1, 'maherbenrhouma@gmail.com', '[\"ROLE_EDITOR\",\"ROLE_USER\"]', '$2y$13$K4g7.Oov1zDHWI41Pj/DM.ssMeMIaLysYnS7Ba5TVSmdENEH6XB5a', 'maher', 'ben rhouma'),
(2, 'tests@gmail.com', '[\"ROLE_ADMIN\",\"ROLE_EDITOR\",\"ROLE_USER\"]', '$2y$13$x7SXLUma/upu6i8W/wTQTeUdYkNQK5BvfoTjp0cMqCDyxseOnEH8C', 'test', 'test'),
(3, 'maherbenrhoumaaa@gmail.com', '[]', '$2y$13$Oe.O.ghvEPy89L/ffs/pjuhIARORloVK5SB0P.CcitOadSy..Ntd.', 'maher', 'maher');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `add_product_history`
--
ALTER TABLE `add_product_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_EDEB7BDE4584665A` (`product_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_64C19C15E237E06` (`name`);

--
-- Indexes for table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  ADD KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_F52993988BAC62AF` (`city_id`);

--
-- Indexes for table `order_products`
--
ALTER TABLE `order_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_5242B8EBA35F2858` (`_order_id`),
  ADD KEY `IDX_5242B8EB4584665A` (`product_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_D34A04AD5E237E06` (`name`);

--
-- Indexes for table `product_sub_category`
--
ALTER TABLE `product_sub_category`
  ADD PRIMARY KEY (`product_id`,`sub_category_id`),
  ADD KEY `IDX_3147D5F34584665A` (`product_id`),
  ADD KEY `IDX_3147D5F3F7BFE87C` (`sub_category_id`);

--
-- Indexes for table `sub_category`
--
ALTER TABLE `sub_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_BCE3F79812469DE2` (`category_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `add_product_history`
--
ALTER TABLE `add_product_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `city`
--
ALTER TABLE `city`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `order_products`
--
ALTER TABLE `order_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `sub_category`
--
ALTER TABLE `sub_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `add_product_history`
--
ALTER TABLE `add_product_history`
  ADD CONSTRAINT `FK_EDEB7BDE4584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `FK_F52993988BAC62AF` FOREIGN KEY (`city_id`) REFERENCES `city` (`id`);

--
-- Constraints for table `order_products`
--
ALTER TABLE `order_products`
  ADD CONSTRAINT `FK_5242B8EB4584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `FK_5242B8EBA35F2858` FOREIGN KEY (`_order_id`) REFERENCES `order` (`id`);

--
-- Constraints for table `product_sub_category`
--
ALTER TABLE `product_sub_category`
  ADD CONSTRAINT `FK_3147D5F34584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_3147D5F3F7BFE87C` FOREIGN KEY (`sub_category_id`) REFERENCES `sub_category` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sub_category`
--
ALTER TABLE `sub_category`
  ADD CONSTRAINT `FK_BCE3F79812469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
