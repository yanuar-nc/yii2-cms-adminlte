-- phpMyAdmin SQL Dump
-- version 4.5.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 19, 2017 at 12:18 PM
-- Server version: 5.7.11
-- PHP Version: 5.6.19

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
(1, 'dashboard', 'Dashboard', 'fa fa-dashboard', 'site/index', NULL, 0, 1, NULL, 1485598482, 16, 1487476953),
(2, 'menu', 'Menu Configuration', 'fa fa-navicon ', 'menu/index', NULL, 3, 1, NULL, 1485598482, 16, 1487476953),
(3, 'role', 'User Access', 'fa fa-user', 'roles/index', NULL, 4, 1, NULL, 1485598482, 16, 1487476954),
(4, 'pages', 'Pages', 'fa fa-tv', 'page/index', NULL, 2, 1, NULL, 1485998482, 16, 1487476953),
(5, 'menu-allowed', 'Menu Allowed', 'fa fa-circle-o', 'role-menu/index', 3, 7, 1, NULL, 1486195532, 16, 1487476954),
(6, 'role', 'Role', 'fa fa-circle-o', 'role/index', 3, 6, 1, 16, 1486195562, 16, 1487476954),
(7, 'user', 'User', 'fa fa-user', 'user/index', NULL, 3, 1, 16, 1486904705, 16, 1487476954),
(8, 'action', 'Action', 'fa fa-circle-o', 'action/index', 3, 5, 1, 16, 1487350806, 16, 1487476954),
(9, 'tag', 'Tag', 'fa fa-tag', 'tag/index', NULL, 1, 1, 16, 1487476504, 16, 1487477730),
(10, 'page-tag', 'Page Tag', 'fa fa-circle-o', 'page-tag/index', 4, 2, -1, 16, 1487477652, NULL, 1487477762);

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
  `user_id` int(11) NOT NULL,
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

INSERT INTO `page` (`id`, `title`, `slug`, `subcontent`, `content`, `user_id`, `image`, `row_status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(27, 'Title ', 'title', 'Hello, although I\'m a static Zero. I\'m fighting all your wars.', '<p>Well, hello there, you\'re the local superhero?<br>Your stronghold\'s but a paper bag,<br>We suffer for your promised land<br>Excuse is really thin,<br>Hide your revealed Achilles\' heel...<br>Before a new brave morning...<br><br>All you little superheroes,<br>Fall short without all them zeroes<br>A pie in the sky is your brave new world,<br><br>And so powerless are thy miracles...<br><br>Ones, they walk before the rows of O\'s,<br>And soon it dawns on them, how to make billions...<br><br>Dream up a world, oh how powerless are thy miracles...<br>...I\'m so tired to fight you<br>The Sun is, oh, so desperate to set tonight,<br>Ashamed to light a lie...<br><br></p>', 16, '', 1, 1486195387, NULL, 1486477129, 16),
(28, 'asd', '', 'asd', '<p>asd<br></p>', 16, '', -1, 1486477023, 16, 1486477044, NULL),
(29, 'asd', '', 'asd', '<p>asd<br></p>', 16, '', -1, 1486477032, 16, 1486477047, NULL),
(30, 'as', 'asd', '\\xE2\\x80\\x83', 'as', 16, '', -1, 1, NULL, 1487384621, NULL),
(31, 'A Little Piece Of Heaven', 'a-little-piece-of-heaven', 'Before the story begins, is it such a sin', '<p> Our love had been so strong for far too long,<br>I was weak with fear that<br>something would go wrong,<br>before the possibilities came true,<br>I took all possibility from you<br>Almost laughed myself to tears,(hahaha)<br>conjuring her deepest fears<br>(come here you fucking bitch)<br><br>Must have stabbed her fifty fucking times,<br>I can\'t believe it,<br>Ripped her heart out right before her eyes,<br>Eyes over easy, eat it eat it eat it<br><br>She was never this good in bed<br>even when she was sleepin\'<br>now she\'s just so perfect I\'ve<br>never been quite so fucking deep in<br>it goes on and on and on,<br>I can keep you lookin\' young and preserved forever,<br>with a fountain to spray on your youth whenever<br><br></p>', 16, '1557447_758552424155550_1875268442982376174_n.jpg', 1, 1487384598, 16, 1487384598, 16),
(32, 'theres no one left to tell', 'theres-no-one-left-to-tell', 'It\'s all your life , all your life!', '<p>There\'s a place where nothing seems to be a simple night of easy life<br>It\'s all your mind , all your mind<br>Something little shouldn\'t feel this way<br>We got a million thoughts we can\'t complain<br>It\'s all your life , all your life!<br></p>', 16, 'bharhxwiiaejcth.png', 1, NULL, 16, NULL, 16);

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
(6, 31, 1, 1, NULL, NULL, NULL, NULL),
(17, 27, 3, 1, NULL, NULL, NULL, NULL),
(18, 27, 1, 1, NULL, NULL, NULL, NULL),
(22, 32, 3, 1, NULL, NULL, NULL, NULL),
(23, 32, 2, 1, NULL, NULL, NULL, NULL),
(24, 32, 1, 1, NULL, NULL, NULL, NULL);

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
(16, 'Yanuar Nurcahyo', 'Full Stack Developer', '13770337_1129441573761196_6776768291511800245_n.jpg', 'yanuarxnurcahyo@gmail.com', 'yanuar', '$2y$13$Kxb8zL.6P2Sp0wkEt4LQ6uG2WGdcoBErmjVTkrPRmLekGpHmeLupS', NULL, 'ocfgp-H-l3galq10q8GKfu1XbPF5hGqS', 30, 1, 1486195330, NULL, 1487351139, 16),
(17, 'Januck', 'jancuk', NULL, 'yan@cmasd.com', 'hahaha', 'gr33nc**r3.', NULL, NULL, 20, -1, 1486896538, 16, 1487386455, NULL),
(18, 'Fullname', 'position', NULL, 'mail@position.com', 'fullname', '$2y$13$q6AuepRLVj0Qcrx.ytWZX.YmAVMzDb5.i1Bys0i.6F62K.H/moIt6', NULL, 'HesQ08gr51lFuwzafhHCH2-dXYkYfsQB', 30, -1, 1486896887, NULL, 1486904992, NULL),
(19, 'Gaga', 'jaja', NULL, 'mail@position.coms', 'jaja', '$2y$13$6GtitpIeYNCmS1TwiHSOn.BKhMU1beims98mhZ6p.Tdmj88dUcM5i', NULL, 'JijdvUSFSXGVM7wSOwDuIV56PrODIQ3O', 30, -1, 1486898397, NULL, 1486904990, NULL),
(20, 'askdfj', 'lkj', NULL, 'lkj@sdad.com', 'jeger', '$2y$13$s773tfWiq/4E86zFFNPQUu92wsKN6cli.n1avFlZZMdM35oM3mrgm', NULL, 'e7HIIgn4gwByuxg0zmkZbMj4rjxGb9RV', 30, -1, 1486898727, NULL, 1486904985, NULL),
(22, 'Muke gille', 'Full Stack Developer', NULL, 'mail@position.com', 'fullname', '$2y$13$hsGwzSyuTtnepJF0ClVxouVC0Z1LRi5Y5Q9f.EYqTYzSl3fJiGtyu', NULL, 'pp-TEwNlfPLyRzrVE3MELONxYUPa2Hvu', 10, 1, 1486906655, NULL, 1486906836, 16),
(23, 'Jinja', 'HRD', NULL, 'jinja@mail.com', 'jinja', '$2y$13$EEdDIU0FjPDsrl6v1x7E4.wHPK/MLmG5nzHvLov3A6lJavzqIDljW', NULL, '0AOlvZoO6RD54wETPAt5ZR7IR8aCP1qD', 20, 1, 1487351698, NULL, 1487386466, 16);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `action`
--
ALTER TABLE `action`
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
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

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
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `page`
--
ALTER TABLE `page`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `page_tag`
--
ALTER TABLE `page_tag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `page`
--
ALTER TABLE `page`
  ADD CONSTRAINT `page_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

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
