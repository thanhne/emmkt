-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 22, 2018 at 11:28 AM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.1.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `email_marketing`
--

-- --------------------------------------------------------

--
-- Table structure for table `vik_campaigns`
--

CREATE TABLE `vik_campaigns` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `email_id` int(11) NOT NULL,
  `from_mail` varchar(255) NOT NULL,
  `from_name` varchar(255) NOT NULL,
  `custom_reply` varchar(255) DEFAULT NULL,
  `template_id` int(11) DEFAULT NULL,
  `status` int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `vik_campaigns`
--

INSERT INTO `vik_campaigns` (`id`, `name`, `subject`, `email_id`, `from_mail`, `from_name`, `custom_reply`, `template_id`, `status`) VALUES
(1, 'Dành riêng cho bạn, tour Thái Lan giờ chót chỉ từ 4.990.000 đ/khách', 'Private sale: 25% off our new collection', 0, 'thanhnb@bestprice.vn', 'Nguyễn Thành', '', 25, 0);

-- --------------------------------------------------------

--
-- Table structure for table `vik_configuration`
--

CREATE TABLE `vik_configuration` (
  `id` int(11) UNSIGNED NOT NULL,
  `mail_protocol` char(10) DEFAULT NULL,
  `mail_host` varchar(65) DEFAULT NULL,
  `mail_port` int(11) UNSIGNED DEFAULT NULL,
  `mail_user` varchar(255) DEFAULT NULL,
  `mail_password` varchar(255) DEFAULT NULL,
  `mail_from` varchar(255) DEFAULT NULL,
  `api_domains` varchar(255) DEFAULT NULL,
  `api_secret` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `vik_configuration`
--

INSERT INTO `vik_configuration` (`id`, `mail_protocol`, `mail_host`, `mail_port`, `mail_user`, `mail_password`, `mail_from`, `api_domains`, `api_secret`) VALUES
(1, 'smtp', 'ssl://smtp.gmail.com', 465, 'thanhnb@bestprice.vn', 'Congty123!@#', 'thanhnb@bestprice.vn', 'bestprice.vn,bestpricevn.com', 'e71d8545aa1a970b3b3af59dd3d28f0d1fbbacf0f5af628a');

-- --------------------------------------------------------

--
-- Table structure for table `vik_contacts`
--

CREATE TABLE `vik_contacts` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `first_name` varchar(65) DEFAULT NULL,
  `last_name` varchar(65) DEFAULT NULL,
  `phone` varchar(25) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `reason` varchar(255) DEFAULT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `campaign_history` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `vik_contacts`
--

INSERT INTO `vik_contacts` (`id`, `email`, `first_name`, `last_name`, `phone`, `status`, `reason`, `create_date`, `modified_date`, `campaign_history`) VALUES
(35, 'nbthanh93@gmail.com', 'Nguyễn', 'Thành', '985445003', 1, NULL, '2018-11-21 01:18:55', '0000-00-00 00:00:00', NULL),
(36, 'sate18@gmail.com', 'Kiều Anh', 'Cao', '985445003', 1, NULL, '2018-11-21 01:19:14', '0000-00-00 00:00:00', NULL),
(37, 'thanhnb@name.com', 'Nguyễn', 'Thành', '985445003', 1, NULL, '2018-11-21 01:19:29', '0000-00-00 00:00:00', NULL),
(38, 'admin@namenamenamenamename.com', 'Nguyễn', 'Thành', '985445003', 1, NULL, '2018-11-21 01:19:37', '0000-00-00 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vik_groups`
--

CREATE TABLE `vik_groups` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `vik_groups`
--

INSERT INTO `vik_groups` (`id`, `name`, `create_date`, `modified_date`) VALUES
(16, 'Danh sách email du lịch năm 2018', '2018-11-20 09:58:18', '2018-11-20 09:58:18');

-- --------------------------------------------------------

--
-- Table structure for table `vik_relationships`
--

CREATE TABLE `vik_relationships` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `contact_id` int(10) UNSIGNED DEFAULT NULL,
  `group_id` int(10) UNSIGNED NOT NULL,
  `campaign_id` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `vik_relationships`
--

INSERT INTO `vik_relationships` (`id`, `contact_id`, `group_id`, `campaign_id`) VALUES
(35, 35, 16, NULL),
(36, 36, 16, NULL),
(37, 37, 16, NULL),
(38, 38, 16, NULL),
(39, NULL, 16, 1);

-- --------------------------------------------------------

--
-- Table structure for table `vik_templates`
--

CREATE TABLE `vik_templates` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `vik_templates`
--

INSERT INTO `vik_templates` (`id`, `name`, `content`, `status`, `date`) VALUES
(25, 'Du lịch năm 2018', 'Chào Quý khách  {NAME} ,\r\n \r\nMột mùa 20/11 nữa lại đến, ngày nhà giáo Việt Nam tôn vinh những con người làm nghề giáo.\r\nNhân dịp này, BestPrice xin được gửi lời cảm ơn chân thành và lời chúc sức khỏe đến tất cả các thầy cô đã và đang công tác trong ngành giáo dục. Chúc cho Quý khách luôn thành công và tràn đầy nhiệt huyết trong sự nghiệp trồng người, luôn mang đến những bài học hay và bổ ích cho các thế hệ học trò.\r\nNhân dịp 20/11, BestPrice gửi tặng Quý khách món quà nhỏ là mã voucher THAYCO để được giảm giá khi đặt các dịch vụ du lịch tại BestPrice, cụ thể như sau:\r\n- Giảm ngay 100.000đ/ vé máy bay khứ hồi\r\n- Giảm ngay 100.000đ/đơn hàng khi đặt các dịch vụ khách sạn, tour hoặc du thuyền.\r\n\r\nMã giảm giá có hạn sử dụng đến 30/11/2018 và chỉ sử dụng 1 lần. Không áp dụng đồng thời với các khuyến mại khác của BestPrice.\r\n\r\nCảm ơn Quý khách đã quan tâm và tin tưởng đặt dịch vụ tại BestPrice,\r\n\r\nBestPrice team.', 1, '2018-11-21 01:21:01');

-- --------------------------------------------------------

--
-- Table structure for table `vik_transactions`
--

CREATE TABLE `vik_transactions` (
  `id` int(10) UNSIGNED NOT NULL,
  `camp_id` int(10) UNSIGNED NOT NULL,
  `contact_id` int(10) UNSIGNED NOT NULL,
  `st_received` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `st_opened` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `st_clicked` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `st_unsub` int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `vik_users`
--

CREATE TABLE `vik_users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `permission` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `vik_users`
--

INSERT INTO `vik_users` (`id`, `name`, `email`, `password`, `permission`) VALUES
(1, 'Admin', 'thanhnb@bestprice.vn', 'c78d770f19beddae77b72fc12fdb005629b750e63258aebd', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `vik_campaigns`
--
ALTER TABLE `vik_campaigns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vik_configuration`
--
ALTER TABLE `vik_configuration`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vik_contacts`
--
ALTER TABLE `vik_contacts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_2` (`email`),
  ADD KEY `email` (`email`);

--
-- Indexes for table `vik_groups`
--
ALTER TABLE `vik_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`);

--
-- Indexes for table `vik_relationships`
--
ALTER TABLE `vik_relationships`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vik_templates`
--
ALTER TABLE `vik_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vik_transactions`
--
ALTER TABLE `vik_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vik_users`
--
ALTER TABLE `vik_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `vik_campaigns`
--
ALTER TABLE `vik_campaigns`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `vik_contacts`
--
ALTER TABLE `vik_contacts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `vik_groups`
--
ALTER TABLE `vik_groups`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `vik_relationships`
--
ALTER TABLE `vik_relationships`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `vik_templates`
--
ALTER TABLE `vik_templates`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `vik_transactions`
--
ALTER TABLE `vik_transactions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vik_users`
--
ALTER TABLE `vik_users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
