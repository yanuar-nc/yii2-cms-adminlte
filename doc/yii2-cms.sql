-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 22, 2017 at 11:00 AM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `yii2-cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `action`
--

CREATE TABLE `action` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `row_status` int(11) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `action`
--

INSERT INTO `action` (`id`, `name`, `row_status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'insert', -1, NULL, NULL, 1487386682, NULL),
(2, 'insert', -1, NULL, NULL, 1487386685, NULL),
(3, 'update', 1, NULL, NULL, NULL, NULL),
(4, 'delete', 1, NULL, NULL, NULL, NULL),
(5, 'list-of-data', 1, NULL, NULL, NULL, NULL),
(6, 'create', 1, NULL, NULL, NULL, NULL),
(7, 'index', 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `media_file`
--

CREATE TABLE `media_file` (
  `id` int(11) NOT NULL,
  `media_folder_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `file_type` varchar(30) NOT NULL,
  `size` int(11) NOT NULL,
  `row_status` int(11) DEFAULT '1',
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `media_file`
--

INSERT INTO `media_file` (`id`, `media_folder_id`, `name`, `file_type`, `size`, `row_status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 20, 'index.jpg', 'image/jpeg', 236092, NULL, 1487733177, 24, 1487733177, NULL),
(2, 19, 'opeth_wallpaper_by_proggirl.jpg', 'image/jpeg', 614379, -1, 1487733535, 24, 1487757981, NULL),
(3, 19, 'fleshgod_apocalypse_technical_death_metal_heavy_dark_evil_fantasy_1920x1080.jpg', 'image/jpeg', 112141, 1, 1487736509, 24, 1487736510, NULL),
(4, 20, 'c3lajwoxuae0z9x.jpg', 'image/jpeg', 169659, 1, 1487758334, 24, 1487758335, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `media_folder`
--

CREATE TABLE `media_folder` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `directory` varchar(50) NOT NULL,
  `row_status` int(11) DEFAULT '1',
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `media_folder`
--

INSERT INTO `media_folder` (`id`, `name`, `directory`, `row_status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(19, 'Picture', 'media/uploader/picture/', 1, 1487675592, 24, 1487675592, NULL),
(20, 'Article', 'media/uploader/articles/', 1, 1487678469, 24, 1487678469, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `name` varchar(80) NOT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `link` varchar(100) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `position` int(11) NOT NULL DEFAULT '0',
  `row_status` int(11) NOT NULL DEFAULT '1' COMMENT '1 = Active; 0 = Disactive',
  `created_by` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `code`, `name`, `icon`, `link`, `parent_id`, `position`, `row_status`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 'dashboard', 'Dashboard', 'fa fa-dashboard', 'site/index', NULL, 0, 1, NULL, 1485598482, 24, 1487675847),
(2, 'menu', 'Menu Configuration', 'fa fa-navicon ', 'menu/index', NULL, 3, 1, NULL, 1485598482, 24, 1487675847),
(3, 'role', 'User Access', 'fa fa-user', 'roles/index', NULL, 5, 1, NULL, 1485598482, 24, 1487675847),
(4, 'pages', 'Pages', 'fa fa-tv', 'page/index', NULL, 2, 1, NULL, 1485998482, 24, 1487675847),
(5, 'menu-allowed', 'Menu Allowed', 'fa fa-circle-o', 'role-menu/index', 3, 7, 1, NULL, 1486195532, 24, 1487675847),
(6, 'role', 'Role', 'fa fa-circle-o', 'role/index', 3, 6, 1, 16, 1486195562, 24, 1487675847),
(7, 'user', 'User', 'fa fa-group', 'user/index', NULL, 4, 1, 16, 1486904705, 24, 1487675847),
(8, 'action', 'Action', 'fa fa-circle-o', 'action/index', 3, 5, 1, 16, 1487350806, 24, 1487675847),
(9, 'tag', 'Tag', 'fa fa-tag', 'tag/index', NULL, 1, 1, 16, 1487476504, 24, 1487675847),
(10, 'page-tag', 'Page Tag', 'fa fa-circle-o', 'page-tag/index', 4, 2, -1, 16, 1487477652, NULL, 1487477762),
(11, 'media-uploader', 'Media Uploader', 'fa fa-file-photo-o', 'media-uploader/index', NULL, 3, 1, 24, 1487651520, 24, 1487675847);

-- --------------------------------------------------------

--
-- Table structure for table `page`
--

CREATE TABLE `page` (
  `id` int(11) NOT NULL,
  `title` varchar(200) CHARACTER SET latin1 NOT NULL,
  `slug` varchar(150) COLLATE utf8mb4_bin NOT NULL,
  `subcontent` text CHARACTER SET latin1 NOT NULL,
  `content` text COLLATE utf8mb4_bin NOT NULL,
  `image` varchar(200) CHARACTER SET latin1 NOT NULL,
  `row_status` int(11) NOT NULL DEFAULT '1' COMMENT '1 = Active; 0 = Disactive',
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `page`
--

INSERT INTO `page` (`id`, `title`, `slug`, `subcontent`, `content`, `image`, `row_status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(27, 'Title ', 'title', 'Hello, although I\'m a static Zero. I\'m fighting all your wars.', '<p>Well, hello there, you\'re the local superhero?<br>Your stronghold\'s but a paper bag,<br>We suffer for your promised land<br>Excuse is really thin,<br>Hide your revealed Achilles\' heel...<br>Before a new brave morning...<br><br>All you little superheroes,<br>Fall short without all them zeroes<br>A pie in the sky is your brave new world,<br><br>And so powerless are thy miracles...<br><br>Ones, they walk before the rows of O\'s,<br>And soon it dawns on them, how to make billions...<br><br>Dream up a world, oh how powerless are thy miracles...<br>...I\'m so tired to fight you<br>The Sun is, oh, so desperate to set tonight,<br>Ashamed to light a lie...<br><br></p>', 'index.jpg', 1, 1486195387, 24, 1486477129, 24),
(28, 'asd', '', 'asd', '<p>asd<br></p>', '', -1, 1486477023, 16, 1486477044, NULL),
(29, 'asd', '', 'asd', '<p>asd<br></p>', '', -1, 1486477032, 16, 1486477047, NULL),
(30, 'as', 'asd', '\\xE2\\x80\\x83', 'as', '', -1, 1, NULL, 1487384621, NULL),
(31, 'A Little Piece Of Heaven', 'a-little-piece-of-heaven', 'Before the story begins, is it such a sin', '<p> Our love had been so strong for far too long,<br>I was weak with fear that<br>something would go wrong,<br>before the possibilities came true,<br>I took all possibility from you<br>Almost laughed myself to tears,(hahaha)<br>conjuring her deepest fears<br>(come here you fucking bitch)<br><br>Must have stabbed her fifty fucking times,<br>I can\'t believe it,<br>Ripped her heart out right before her eyes,<br>Eyes over easy, eat it eat it eat it<br><br>She was never this good in bed<br>even when she was sleepin\'<br>now she\'s just so perfect I\'ve<br>never been quite so fucking deep in<br>it goes on and on and on,<br>I can keep you lookin\' young and preserved forever,<br>with a fountain to spray on your youth whenever<br><br></p>', '55eda963352ab_funny_quotes_for_desktop_1920x1080.jpg', 1, 1487384598, 16, 1487384598, 24),
(32, 'theres no one left to tell', 'theres-no-one-left-to-tell', 'It\'s all your life , all your life!', '<p>There\'s a place where nothing seems to be a simple night of easy life<br>It\'s all your mind , all your mind<br>Something little shouldn\'t feel this way<br>We got a million thoughts we can\'t complain<br>It\'s all your life , all your life!<br></p>', 'bharhxwiiaejcth.png', 1, NULL, 16, NULL, 16);

-- --------------------------------------------------------

--
-- Table structure for table `page_tag`
--

CREATE TABLE `page_tag` (
  `id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  `row_status` int(11) NOT NULL DEFAULT '1',
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `page_tag`
--

INSERT INTO `page_tag` (`id`, `page_id`, `tag_id`, `row_status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(22, 32, 3, 1, NULL, NULL, NULL, NULL),
(23, 32, 2, 1, NULL, NULL, NULL, NULL),
(24, 32, 1, 1, NULL, NULL, NULL, NULL),
(27, 27, 3, 1, NULL, NULL, NULL, NULL),
(28, 27, 1, 1, NULL, NULL, NULL, NULL),
(32, 31, 1, 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `code` varchar(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `row_status` int(11) NOT NULL DEFAULT '1' COMMENT '1 = Active; 0 = Disactive',
  `created_by` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `code`, `name`, `row_status`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, '30', 'Admin', 1, NULL, 1485598482, NULL, 1485598482),
(2, '20', 'Moderator', 1, NULL, 1485598482, NULL, 1485598482),
(3, '10', 'User', 1, NULL, 1485598482, NULL, 1485598482);

-- --------------------------------------------------------

--
-- Table structure for table `role_menu`
--

CREATE TABLE `role_menu` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `action_id` int(11) NOT NULL,
  `row_status` int(11) NOT NULL DEFAULT '1' COMMENT '1 = Active; 0 = Disactive',
  `created_at` int(11) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role_menu`
--

INSERT INTO `role_menu` (`id`, `role_id`, `menu_id`, `action_id`, `row_status`, `created_at`, `created_by`, `updated_by`, `updated_at`) VALUES
(1, 2, 1, 7, 1, 1485598482, NULL, 16, 1487350872),
(2, 1, 1, 0, 1, 1485598482, NULL, NULL, 1485598482),
(3, 3, 1, 7, 1, 1487350921, 16, NULL, 1487350921),
(4, 2, 4, 7, 1, 1487386501, 16, NULL, 1487386501),
(5, 2, 4, 3, 1, 1487386701, 16, NULL, 1487386701),
(6, 2, 4, 6, 1, 1487386733, 16, NULL, 1487386733),
(7, 2, 4, 4, 1, 1487386752, 16, NULL, 1487386752),
(8, 2, 7, 7, 1, 1487389896, 16, NULL, 1487389896);

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

CREATE TABLE `tag` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `row_status` int(11) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tag`
--

INSERT INTO `tag` (`id`, `name`, `row_status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'News', 1, 1487476698, 16, 1487476698, NULL),
(2, 'Music', 1, 1487505792, 16, 1487505792, NULL),
(3, 'Movie', 1, 1487505808, 16, 1487505808, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `position` varchar(150) DEFAULT NULL,
  `image` varchar(150) DEFAULT NULL,
  `email` varchar(150) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `password_reset_token` varchar(200) DEFAULT NULL,
  `auth_key` varchar(200) DEFAULT NULL,
  `role` int(11) NOT NULL,
  `row_status` int(11) NOT NULL DEFAULT '1' COMMENT '1 = Active; 0 = Disactive',
  `created_at` int(11) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `fullname`, `position`, `image`, `email`, `username`, `password`, `password_reset_token`, `auth_key`, `role`, `row_status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(24, 'Yanuar Nurcahyo', 'Web Developer', NULL, 'yanuar@mail.com', 'yanuar', '$2y$13$mHBcW61qIFrde2bRy64QQuSnc7M7N6XWhGFXUOWso5khKlkYHlp5e', NULL, 'puB_5VA-hyHR1Z7Hc8hkAWwwMvlsUSbX', 30, 1, 1487565061, NULL, 1487565061, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `action`
--
ALTER TABLE `action`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `media_file`
--
ALTER TABLE `media_file`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `media_folder_id` (`media_folder_id`);

--
-- Indexes for table `media_folder`
--
ALTER TABLE `media_folder`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `page`
--
ALTER TABLE `page`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `page_tag`
--
ALTER TABLE `page_tag`
  ADD PRIMARY KEY (`id`),
  ADD KEY `page_id` (`page_id`),
  ADD KEY `tag_id` (`tag_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_menu`
--
ALTER TABLE `role_menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`,`menu_id`),
  ADD KEY `menu_id` (`menu_id`),
  ADD KEY `action_id` (`action_id`);

--
-- Indexes for table `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `action`
--
ALTER TABLE `action`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `media_file`
--
ALTER TABLE `media_file`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `media_folder`
--
ALTER TABLE `media_folder`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `page`
--
ALTER TABLE `page`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `page_tag`
--
ALTER TABLE `page_tag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `role_menu`
--
ALTER TABLE `role_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `tag`
--
ALTER TABLE `tag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `media_file`
--
ALTER TABLE `media_file`
  ADD CONSTRAINT `media_file_ibfk_1` FOREIGN KEY (`media_folder_id`) REFERENCES `media_folder` (`id`);

--
-- Constraints for table `page_tag`
--
ALTER TABLE `page_tag`
  ADD CONSTRAINT `page_tag_ibfk_1` FOREIGN KEY (`page_id`) REFERENCES `page` (`id`),
  ADD CONSTRAINT `page_tag_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`);

--
-- Constraints for table `role_menu`
--
ALTER TABLE `role_menu`
  ADD CONSTRAINT `role_menu_ibfk_1` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`),
  ADD CONSTRAINT `role_menu_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
