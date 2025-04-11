-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 11, 2025 at 01:02 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `videos1`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `post_id`, `username`, `comment`, `created_at`) VALUES
(17, 18, '', 'LOVE', '2025-04-04 23:13:29'),
(18, 19, '', 'Hello', '2025-04-05 21:21:06'),
(19, 24, '', 'love', '2025-04-09 15:52:40');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `video_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `like_datetime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `video_id`, `user_id`, `like_datetime`) VALUES
(1, 1, 3, '2024-05-04 15:56:55'),
(2, 2, 4, '2024-05-04 15:56:55'),
(3, 3, 1, '2024-05-04 15:56:55'),
(4, 3, 5, '2024-05-04 15:56:55'),
(5, 4, 2, '2024-05-04 15:56:55');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `user_image` varchar(255) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `caption` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `title` varchar(255) DEFAULT NULL,
  `person` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `file_type` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `username`, `user_image`, `file_name`, `caption`, `created_at`, `title`, `person`, `location`, `updated_at`, `file_type`) VALUES
(18, '', 'default-avatar.png', 'Screenshot (2).png', 'Hello', '2025-04-04 11:19:28', NULL, NULL, NULL, '2025-04-04 11:49:18', ''),
(19, 'default', 'default-avatar.png', 'Screenshot (1).png', 'SC1', '2025-04-05 21:17:09', 'My Post', 'Umair', 'London', '2025-04-05 21:17:09', 'image'),
(20, 'default', 'default-avatar.png', 'MP4.mp4', 'Hello', '2025-04-05 21:34:52', 'My Post', 'Umair', 'London', '2025-04-05 21:34:52', 'video'),
(21, 'default', 'default-avatar.png', 'MP4.mp4', 'MP4', '2025-04-05 21:35:26', 'My Post', 'Umair', 'London', '2025-04-05 21:35:26', 'video'),
(22, 'default', 'default-avatar.png', 'MP4.mp4', '1122', '2025-04-05 22:39:50', 'My Post', 'Umair', 'London', '2025-04-05 22:39:50', 'video'),
(23, 'default', 'default-avatar.png', 'MP4.mp4', 'CAP', '2025-04-05 22:56:05', 'My Post', 'Umair', 'London', '2025-04-05 22:56:05', 'video'),
(24, 'default', 'default-avatar.png', 'MP4.mp4', 'Helo', '2025-04-09 15:52:27', 'My video', 'Umair', 'Pakistan', '2025-04-09 15:52:27', 'video'),
(25, 'default', 'default-avatar.png', 'Screenshot (1).png', 'Hello', '2025-04-11 10:19:33', 'My video', 'Umair', 'Pakistan', '2025-04-11 10:19:33', 'image'),
(26, 'default', 'default-avatar.png', 'Screenshot (6).png', 'hello', '2025-04-11 10:40:02', 'Title', 'Umair', 'London', '2025-04-11 10:40:02', 'image');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `FName` varchar(255) NOT NULL,
  `LName` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `ContactNumber` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `FName`, `LName`, `Email`, `ContactNumber`) VALUES
(1, 'ali_khan', 'password123', 'Ali', 'Khan', 'ali@example.com', '1234567890'),
(2, 'fatima_ahmed', 'password456', 'Fatima', 'Ahmed', 'fatima@example.com', '0987654321'),
(3, 'zainab_abbas', 'password789', 'Zainab', 'Abbas', 'zainab@example.com', '9876543210'),
(4, 'saad_khalid', 'password321', 'Saad', 'Khalid', 'saad@example.com', '4567890123'),
(5, 'sana_malik', 'password654', 'Sana', 'Malik', 'sana@example.com', '3210987654'),
(6, 'Nabeel', '1234567', 'Nabeel', 'Aslam', 'n@yahoo.com', '1234567'),
(7, 'Sharjeel', '1234567', 'Sharjeel', 'Aslam', 's@yahoo.com', '123'),
(8, 'muhammadumairaslam81@gmail.com', '112233', 'Muhammad', 'Umair Aslam', 'muhammadumairaslam81@gmail.com', '03055882464'),
(10, '', '$2y$10$RzEwjLRc471JaIjR7MBjb.F0eV92gYzHhFOY9QBMV5uRyxi/TS68W', '', '', '', ''),
(11, '', '$2y$10$Jp39LKlHuQMkB9C7oC80JuVi5RPfPKxA4hvBvLVr7clew7hh0r/76', '', '', '', ''),
(12, '', '', '', '', '', ''),
(13, '', '', '', '', '', ''),
(14, '', '', '', '', '', ''),
(15, '', '$2y$10$hbwDVSH6QhjMX/wHAqJlI.o7wvp6j5pigH92nh6MHYW7z9qitblxG', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

CREATE TABLE `videos` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `filename` varchar(255) NOT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `uploader_id` int(11) DEFAULT NULL,
  `Publisher` varchar(255) DEFAULT NULL,
  `Producer` varchar(255) DEFAULT NULL,
  `Genre` varchar(100) DEFAULT NULL,
  `AgeRating` varchar(10) DEFAULT NULL,
  `upload_datetime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `videos`
--

INSERT INTO `videos` (`id`, `title`, `description`, `filename`, `thumbnail`, `uploader_id`, `Publisher`, `Producer`, `Genre`, `AgeRating`, `upload_datetime`) VALUES
(1, 'Inception', 'A thief who enters the dreams of others to steal their secrets', 'inception.mp4', 'inception_thumbnail.jpg', 1, 'Warner Bros. Pictures', 'Christopher Nolan', 'Thriller', 'PG-13', '2024-05-04 15:56:55'),
(2, 'The Dark Knight', 'Batman must confront the Joker to save Gotham City from destruction', 'dark_knight.mp4', 'dark_knight_thumbnail.jpg', 2, 'Warner Bros. Pictures', 'Christopher Nolan', 'Action', 'PG-13', '2024-05-04 15:56:55'),
(3, 'The Shawshank Redemption', 'Two imprisoned men bond over a number of years, finding solace and eventual redemption through acts of common decency', 'shawshank_redemption.mp4', 'shawshank_thumbnail.jpg', 3, 'Columbia Pictures', 'Frank Darabont', 'Drama', 'R', '2024-05-04 15:56:55'),
(4, 'Forrest Gump', 'The story depicts several decades in the life of Forrest Gump, a slow-witted but kind-hearted man from Alabama who witnesses and unwittingly influences several defining historical events in the 20th century United States', 'forrest_gump.mp4', 'forrest_gump_thumbnail.jpg', 4, 'Paramount Pictures', 'Robert Zemeckis', 'Drama', 'PG-13', '2024-05-04 15:56:55'),
(5, 'The Godfather', 'The aging patriarch of an organized crime dynasty transfers control of his clandestine empire to his reluctant son', 'godfather.mp4', 'godfather_thumbnail.jpg', 5, 'Paramount Pictures', 'Francis Ford Coppola', 'Crime', 'R', '2024-05-04 15:56:55'),
(6, 'Nabeel', 'Test', '101.mp3', '1.png', 6, 'test', 'Test', 'Action', 'PG-13', '2024-05-04 17:07:43'),
(7, 'Sharjeel', 'test', '555.mp3', 'Aysha-passport.JPG', 6, 'test', 'test', 'Mystery', 'PG-13', '2024-05-04 17:28:52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `video_id` (`video_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uploader_id` (`uploader_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `videos`
--
ALTER TABLE `videos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`video_id`) REFERENCES `videos` (`id`),
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `videos`
--
ALTER TABLE `videos`
  ADD CONSTRAINT `videos_ibfk_1` FOREIGN KEY (`uploader_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
