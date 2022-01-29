-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 02, 2021 at 04:24 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rest`
--
CREATE DATABASE IF NOT EXISTS `rest` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `rest`;

-- --------------------------------------------------------

--
-- Table structure for table `restaurant`
--

CREATE TABLE `restaurant` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `location_real` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `location_imag` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `photos` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `menu` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `restaurant`
--

INSERT INTO `restaurant` (`id`, `admin_id`, `name`, `description`, `location_real`, `location_imag`, `photos`, `menu`) VALUES
(1, 1, 'تشيز كيك فاكتوري', 'American chain restaurant offering sizable portions from a vast menu including signature cheesecake', '24.7562758', '46.6308297', '1.jpg||2.jpg||3.jpg||||', 'Cheese Cake 5$\r\nCake without cheese 1$\r\nCheese without cake 3$\r\nwater 10$'),
(2, 3, 'برجر بوتيك', 'B+F Burger Boutique', '24.7029453', '46.6786327', '4.jpg||5.jpg||6.jpg||7.jpg||', 'Burger 15$\r\nChicken Burger 20$\r\nFish burger 30$\r\nDouble Cheese Burger 20$'),
(3, 4, 'Buffalo Wild Wings', 'Buffalo Wild Wings is an American casual dining restaurant and sports bar franchise in the United States, Canada, India, Mexico, Oman, Panama, Philippines, Saudi Arabia, United Arab Emirates, and Vietnam which specializes in Buffalo wings and', '24.7895684', '46.6312075', '8.jpg||9.jpg||||||', 'Burgers 12$\r\nWings 6$'),
(4, 5, 'Shake Shack', 'شيك شاك (بالإنجليزية: Shake Shack)‏ هي سلسلة مطاعم تأسست في 2004. تقدم الهامبرغر، شطائر النقانق، البطاطس المقلية، الميلك شيك والأطعمة المماثلة. يوجد حاليا أحد عشر مطعما ضمن السلسلة، ستة في مدينة نيويورك.', '24.7526319', '46.6234422', '10.jpg||11.jpg||||||', 'Burger 8$\r\nDouble Burger 14$'),
(5, 6, 'Five Guys', 'Five Guys Enterprises LLC is an American fast casual restaurant chain focused on hamburgers, hot dogs, and French fries, and headquartered in Lorton, Virginia, an unincorporated part of Fairfax County.', '24.8083598', '46.7345212', '12.jpg||13.jpg||14.jpg||15.jpg||', 'Chicken 17$\r\nFried Chicken 12$\r\nBurgers 9$');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `restaurant_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `review` text COLLATE utf8_unicode_ci NOT NULL,
  `star` int(11) NOT NULL DEFAULT 5
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `restaurant_id`, `user_id`, `review`, `star`) VALUES
(1, 1, 2, 'I did not like it', 1),
(2, 1, 2, 'I was wrong...', 5);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `type`) VALUES
(1, 'Mohamed', 'cheese@gmail.com', '17ba0791499db908433b80f37c5fbc89b870084b', 'admin'),
(2, 'Ahmed', 'ahmed@yaho.com', '17ba0791499db908433b80f37c5fbc89b870084b', 'user'),
(3, 'Burger admin', 'burger@gmail.com', '17ba0791499db908433b80f37c5fbc89b870084b', 'admin'),
(4, 'manager', 'manager@yahoo.com', '17ba0791499db908433b80f37c5fbc89b870084b', 'admin'),
(5, 'admin', 'super_user@gmail.com', '17ba0791499db908433b80f37c5fbc89b870084b', 'admin'),
(6, '5th guy', 'thatguy@gmail.com', '17ba0791499db908433b80f37c5fbc89b870084b', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `restaurant`
--
ALTER TABLE `restaurant`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `restaurant`
--
ALTER TABLE `restaurant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
