-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 15, 2024 at 12:50 PM
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
-- Database: `pichive`
--

-- --------------------------------------------------------

--
-- Table structure for table `block`
--

CREATE TABLE `block` (
  `my_id` binary(16) NOT NULL,
  `their_id` binary(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE `chat` (
  `id` int(11) NOT NULL,
  `sender_id` binary(16) NOT NULL,
  `receiver_id` binary(16) NOT NULL,
  `message` varchar(1000) NOT NULL,
  `date_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `c_reply`
--

CREATE TABLE `c_reply` (
  `id` int(11) NOT NULL,
  `comment_id` int(11) NOT NULL,
  `replier_id` binary(16) NOT NULL,
  `reply` varchar(300) NOT NULL,
  `date_time` datetime NOT NULL,
  `likes` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `follow`
--

CREATE TABLE `follow` (
  `my_id` binary(16) NOT NULL,
  `their_id` binary(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `follow`
--

INSERT INTO `follow` (`my_id`, `their_id`) VALUES
(0x381653bebada11efa424107c6104232a, 0xed8973adbad811efa424107c6104232a);

-- --------------------------------------------------------

--
-- Table structure for table `otp`
--

CREATE TABLE `otp` (
  `otp_code` int(11) NOT NULL,
  `user_id` binary(16) NOT NULL,
  `record_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `img_url` varchar(255) NOT NULL,
  `description` varchar(300) DEFAULT NULL,
  `poster_id` binary(16) NOT NULL,
  `date_time` datetime NOT NULL,
  `likes` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`id`, `title`, `img_url`, `description`, `poster_id`, `date_time`, `likes`) VALUES
(3, 'Christmas feels', 'https://i.ibb.co/KFNdDZb/c454796d5d36.jpg', 'A cozy winter night scene shows snow-covered houses, glowing with warm lights. A giant Christmas tree, adorned with golden ornaments, stands tall amid snowy paths and festive gift boxes. ❄️❄️❄️\r\n\r\n\r\n\r\n\r\n\r\n', 0xed8973adbad811efa424107c6104232a, '2024-12-15 12:40:30', 1),
(4, 'Red Dead Redemption 2', 'https://i.ibb.co/F4ry1q7/3de37c7ac08c.png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris diam lacus, ullamcorper id dapibus nec, auctor et leo. Phasellus non turpis vel nunc imperdiet rutrum tempor eget leo. Phasellus bibendum mattis efficitur. Nulla vitae vehicula massa. Fusce a lectus at erat iaculis feugiat in eget nibh.', 0x381653bebada11efa424107c6104232a, '2024-12-15 12:47:34', 0);

-- --------------------------------------------------------

--
-- Table structure for table `p_comment`
--

CREATE TABLE `p_comment` (
  `id` int(11) NOT NULL,
  `commenter_id` binary(16) NOT NULL,
  `post_id` int(11) NOT NULL,
  `cmment` varchar(1000) NOT NULL,
  `date_time` datetime NOT NULL,
  `likes` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `p_comment`
--

INSERT INTO `p_comment` (`id`, `commenter_id`, `post_id`, `cmment`, `date_time`, `likes`) VALUES
(5, 0xed8973adbad811efa424107c6104232a, 3, 'Wow! Amazing...', '2024-12-15 12:41:06', 0);

-- --------------------------------------------------------

--
-- Table structure for table `p_like`
--

CREATE TABLE `p_like` (
  `user_id` binary(16) NOT NULL,
  `post_id` int(11) NOT NULL,
  `date_time` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `p_like`
--

INSERT INTO `p_like` (`user_id`, `post_id`, `date_time`) VALUES
(0x381653bebada11efa424107c6104232a, 3, '2024-12-15 19:49:05');

-- --------------------------------------------------------

--
-- Table structure for table `report`
--

CREATE TABLE `report` (
  `user_id` binary(16) NOT NULL,
  `post_id` int(11) NOT NULL,
  `description` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` binary(16) NOT NULL,
  `username` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(128) NOT NULL,
  `profile_url` varchar(255) DEFAULT NULL,
  `bio` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`, `profile_url`, `bio`) VALUES
(0x381653bebada11efa424107c6104232a, 'Sample_user2', 'sample321@gmail.com', '$2y$10$pe1EywIqt/5by3liJP7M6eQAwYzFh6810a0k6cLIXljq51nLTcPcy', 'https://i.ibb.co/Tqb50Gx/d163e104fbd7.png', NULL),
(0xed8973adbad811efa424107c6104232a, 'Sample1234', 'sample123@gmail.com', '$2y$10$fVHdbicwEaf7d5XcKYYDf.PJSBqyci1i0BxZmYg8jlBJKxMnDVYRi', 'https://i.ibb.co/ngRk5C5/56d946f613cb.png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean vitae luctus ex. Etiam dictum orci ac tincidunt posuere. Phasellus pulvinar sapien efficitur faucibus sollicitudin. Suspendisse luctus velit sed odio malesuada finibus. Pellentesque sem nulla, ullamcorper varius egestas sit amet;');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `block`
--
ALTER TABLE `block`
  ADD PRIMARY KEY (`my_id`,`their_id`),
  ADD KEY `their_id` (`their_id`);

--
-- Indexes for table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sender_id` (`sender_id`,`receiver_id`),
  ADD KEY `receiver_id` (`receiver_id`);

--
-- Indexes for table `c_reply`
--
ALTER TABLE `c_reply`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comment_id` (`comment_id`),
  ADD KEY `replier_id` (`replier_id`);

--
-- Indexes for table `follow`
--
ALTER TABLE `follow`
  ADD PRIMARY KEY (`my_id`,`their_id`),
  ADD KEY `their_id` (`their_id`);

--
-- Indexes for table `otp`
--
ALTER TABLE `otp`
  ADD PRIMARY KEY (`otp_code`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `poster_id` (`poster_id`);
ALTER TABLE `post` ADD FULLTEXT KEY `search_term` (`title`,`description`);

--
-- Indexes for table `p_comment`
--
ALTER TABLE `p_comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `commenter_id` (`commenter_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `p_like`
--
ALTER TABLE `p_like`
  ADD PRIMARY KEY (`user_id`,`post_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`user_id`,`post_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);
ALTER TABLE `user` ADD FULLTEXT KEY `search_term` (`username`,`bio`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chat`
--
ALTER TABLE `chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `c_reply`
--
ALTER TABLE `c_reply`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `p_comment`
--
ALTER TABLE `p_comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `block`
--
ALTER TABLE `block`
  ADD CONSTRAINT `block_ibfk_1` FOREIGN KEY (`my_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `block_ibfk_2` FOREIGN KEY (`their_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `chat`
--
ALTER TABLE `chat`
  ADD CONSTRAINT `chat_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `chat_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `c_reply`
--
ALTER TABLE `c_reply`
  ADD CONSTRAINT `c_reply_ibfk_1` FOREIGN KEY (`comment_id`) REFERENCES `p_comment` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `c_reply_ibfk_2` FOREIGN KEY (`replier_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `follow`
--
ALTER TABLE `follow`
  ADD CONSTRAINT `follow_ibfk_1` FOREIGN KEY (`my_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `follow_ibfk_2` FOREIGN KEY (`their_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `otp`
--
ALTER TABLE `otp`
  ADD CONSTRAINT `otp_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`poster_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `p_comment`
--
ALTER TABLE `p_comment`
  ADD CONSTRAINT `p_comment_ibfk_1` FOREIGN KEY (`commenter_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `p_comment_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `p_like`
--
ALTER TABLE `p_like`
  ADD CONSTRAINT `p_like_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `p_like_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `report`
--
ALTER TABLE `report`
  ADD CONSTRAINT `report_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `report_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `delete_expired_otps` ON SCHEDULE EVERY 5 MINUTE STARTS '2024-12-15 19:35:00' ON COMPLETION NOT PRESERVE ENABLE DO DELETE FROM otp WHERE record_time < NOW()$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
