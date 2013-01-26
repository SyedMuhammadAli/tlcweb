-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 27, 2013 at 12:46 AM
-- Server version: 5.5.29
-- PHP Version: 5.3.10-1ubuntu3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `tlc_portal_v1`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author_id` int(11) NOT NULL,
  `thread_id` int(11) NOT NULL,
  `text` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_comments_posts` (`thread_id`),
  KEY `fk_comments_members` (`author_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `author_id`, `thread_id`, `text`, `time`) VALUES
(1, 1, 7, 'First comment!', '2012-01-30 06:26:35'),
(2, 1, 7, 'second', '2012-01-30 06:26:54'),
(3, 1, 7, 'new comment', '2012-02-16 03:12:58'),
(4, 1, 6, 'xpr comment', '2012-03-17 23:38:14'),
(5, 1, 7, 'testing comment', '2012-07-11 15:13:44'),
(6, 1, 7, 'new comment 1111', '2012-07-11 15:14:03');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE IF NOT EXISTS `departments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(48) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`) VALUES
(1, 'Event Management'),
(2, 'Creative'),
(3, 'Webmasters'),
(4, 'Executive Committee'),
(5, 'Photography'),
(6, 'Public Relations'),
(7, 'Content'),
(8, 'Debate');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(48) COLLATE utf8_unicode_ci NOT NULL,
  `about` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `rules` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `creator_id` int(11) NOT NULL,
  `event_date` int(11) NOT NULL,
  `registration_allowed` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_events_members` (`creator_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `name`, `about`, `rules`, `creator_id`, `event_date`, `registration_allowed`) VALUES
(1, 'Zauq', 'Write event description here.', 'Write event rules here.', 1, 1329211800, 0),
(2, 'Xpressions', 'Write event description here.', 'Write event rules here.', 1, 1315906200, 0),
(3, 'Declamation Contest', 'Write event description here.', 'Write event rules here.', 1, 1350120600, 0),
(4, 'Tamasha', 'Foo', 'Bar', 1, 1329229800, 0),
(5, 'Asad''s Birthday', 'Yepieee :D', 'Eat the damn cake.', 1, 1332509400, 0),
(6, 'Gareevi Event', 'Best event ever!', 'Recycle everything!', 1, 1327915800, 0),
(7, 'Test Event', 'Test About', 'Test Rules', 1, 1398915800, 1);

-- --------------------------------------------------------

--
-- Table structure for table `event_comments`
--

CREATE TABLE IF NOT EXISTS `event_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `text` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_eventcomm_members` (`author_id`),
  KEY `fk_eventcomm_events` (`event_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `event_comments`
--

INSERT INTO `event_comments` (`id`, `author_id`, `event_id`, `text`, `time`) VALUES
(1, 1, 5, 'new comment', '2012-02-16 03:13:43'),
(2, 1, 5, 'march comment', '2012-03-17 23:38:06');

-- --------------------------------------------------------

--
-- Table structure for table `event_organizers`
--

CREATE TABLE IF NOT EXISTS `event_organizers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_eventorg_members` (`user_id`),
  KEY `fk_eventorg_events` (`event_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `event_organizers`
--

INSERT INTO `event_organizers` (`id`, `user_id`, `event_id`) VALUES
(1, 1, 2),
(2, 1, 2),
(3, 1, 3),
(4, 1, 6),
(5, 1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `institutes`
--

CREATE TABLE IF NOT EXISTS `institutes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=14 ;

--
-- Dumping data for table `institutes`
--

INSERT INTO `institutes` (`id`, `name`) VALUES
(1, 'FAST-NUCES'),
(2, 'NED-UET'),
(3, 'KU'),
(4, 'GIKI'),
(5, 'LUMS'),
(6, 'MAJU'),
(7, 'NUST'),
(8, 'UIT'),
(9, 'IBA'),
(10, 'IoBM'),
(11, 'IBM'),
(12, 'PAK-KIET'),
(13, 'Hamdard');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE IF NOT EXISTS `members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usr` varchar(24) COLLATE utf8_unicode_ci NOT NULL,
  `pswd` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `firstname` varchar(24) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(24) COLLATE utf8_unicode_ci NOT NULL,
  `contact_num` varchar(13) COLLATE utf8_unicode_ci NOT NULL,
  `dept_id` int(11) DEFAULT NULL,
  `inst_id` int(11) NOT NULL,
  `email` varchar(28) COLLATE utf8_unicode_ci NOT NULL,
  `hidden` tinyint(1) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_members_department` (`dept_id`),
  KEY `fk_members_institutes` (`inst_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `usr`, `pswd`, `firstname`, `lastname`, `contact_num`, `dept_id`, `inst_id`, `email`, `hidden`, `active`) VALUES
(1, 'admin', 'cea66c8eab50a938fbf519379153731c', 'Muhammad', 'Ali', '03003213211', 1, 1, 'nobody@tlc.net', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `participant_teams`
--

CREATE TABLE IF NOT EXISTS `participant_teams` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL,
  `inst_id` int(11) NOT NULL,
  `team_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `participants` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `contact` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `alt_contact` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `email_add` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_participant_events` (`event_id`),
  KEY `fk_participant_inst` (`inst_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `participant_teams`
--

INSERT INTO `participant_teams` (`id`, `event_id`, `inst_id`, `team_name`, `participants`, `contact`, `alt_contact`, `email_add`, `active`) VALUES
(1, 7, 1, 'Adept', 'Name, Name2, Name3', '03002561234', '03002563214', 'user@host.com', 0);

-- --------------------------------------------------------

--
-- Table structure for table `permission`
--

CREATE TABLE IF NOT EXISTS `permission` (
  `user_id` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  KEY `fk_permission_member` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `permission`
--

INSERT INTO `permission` (`user_id`, `level`) VALUES
(1, 16);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `post` longtext COLLATE utf8_unicode_ci NOT NULL,
  `author_id` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_posts_members` (`author_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=12 ;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `post`, `author_id`, `time`) VALUES
(1, 'Xpressions ''11', 'The Literary Club FAST-NU proudly presents Xpressions ?11!<br><br>\n\nXpressions is a one of a kind traditional event of its proportions with just ONE purpose- Celebrating Creativity!<br><br>\n\nTeam TLC invites all FAST-ians to come visit us at the Xpressions layer in Seminar-1 on 1<sup>st</sup>February, and take part in a sketching and drawing competition we have arranged, just for you!<br><br>\n\nXpress your creativity, sometimes, words just aren?t enough!<br><br>\n\n<strong style="text-decoration: underline;"><a href="http://www.facebook.com/event.php?eid=122318911173702" target="_blank">follow the event on Facebook</a></strong>', 1, '2012-01-27 15:13:56'),
(2, 'Who We Are', 'Welcome, to the Official page of The Literary Club of NUCES-FAST Karachi Campus!<br><br>\n\nThe Literary Club is a unique stroke of FAST-Karachi, TLC is a junction of the literary, the talented, and the?sophisticated!<br><br>\n\n<strong>What we at the TLC do?</strong>\nTLC is a group of students who have vowed to work together and make the stay at FAST fun, interesting?and also a place to learn extra-curricular things,in a lively and exciting way!\nWe also believe that university is a place to sharpen and polish the in-born talents, and to revoke lost one''s!', 1, '2012-01-27 15:15:11'),
(3, 'Official results of Agha Hasan Abedi Memorial Declamation Contest 2011', '<strong>Urdu Category</strong><br><br>\n\n<strong>1st Prize</strong>:<br><br>\n\nSub lt. Adnan Zahid from Pakistan Navy Engineering College Karachi.<br><br>\n\nSyed Faisal Karim from Karachi University.<br><br>\n\n<strong>2nd Prize:</strong><br><br>\n\nUmer Ali from Sir Syed University of Engineering and Technology Karachi.<br><br>\n\n<strong>3rd Prize:</strong><br><br>\n\nSyed Azmat Abbas Abedi from Jinnah Medical and Dental College Karachi<br><br>\n\n<strong>English Category</strong><br><br>\n\n<strong>1st Prize:</strong><br><br>\n\nSub lt. Hassan Afzal from Pakistan Navy Engineering College Karachi.<br><br>\n\n<strong>2nd Prize:</strong><br><br>\n\nIfrah Sohail from Hamdard University Karachi.<br><br>\n\n<strong>3rd Prize:</strong><br><br>\n\nMuhammad Yaseen Habib from CAMS.<br><br>\n\n<strong>Winning Team</strong><br><br>\n\n<strong>College Category:</strong><br><br>\n\nPECHS College<br><br>\n\n<strong>University Category:</strong><br><br>\n\nPakistan Navy Engineering College.<br><br>\n\nHeartiest congratulations to all the winners. =) Pictures and videos will be uploaded soon.', 1, '2012-01-27 15:17:13'),
(4, 'Agha Hasan Abedi Memorial Declamation Contest', 'Thanking all the participants for their generous participation.<br><br>\n\nIt is to notify all of you that all the participants will get their certificates, we''ll confirm your addresses via email, or if you read this post please send us your postal addresses at <strong>tlc.khi@nu.edu.pk.</strong> We''ll be uploading the Pictures soon.', 1, '2012-01-27 15:18:34'),
(6, 'Xpressions ''11 - A Success', 'Woah, What a day!\r\nTeam TLC has once again pulled of another Mega Event, '' Xpressions ''11 '' !\r\n<br><br>\r\nOnce '' Xpressions ''11 '' officially opened it''s Darbar for it''s audience, hardly a moment passed when there was no one Xpress-ing themselves in our Mughal Themed Seminar-1!<br><br>\r\n\r\nWith bites of ''meetha paan'' in between, and the filling up of ''the wall of Xpressions'' with exciting comments, everyone from the students, to the faculty seemed to enjoy this colorful event!<br><br>\r\n\r\nTo the audience: I really hope you enjoyed this event. If you feel like, please leave your comments below, they will be highly appreciated. :)<br><br>\r\n\r\nTo the Team: I''d like to congratulate each and everyone of you from my side, this event is truly a prime example of a Team event! :)', 1, '2012-01-27 15:21:20'),
(7, 'Xpressions ', 'The shining glory of The Literary Club. Xpressions was brought to life in the year 2005 with a very simple idea behind it ? Unleashing the creativity. On the day of the event, team TLC provides FASTians with papers, pencils, paints, colors, a highly decorated Xpressions Lair, and all the freedom they need to Xpress their creativity. Xpressions Day has always been a colorful one! After monotonous daily routines, the freedom to Xpress one?s self is met with open hands by faculty and students alike. To make things a little more interesting Xpressions is also a competition, with glory awaiting the best sketchers and painters!<br><br>\nSince its beginning in ?05, Xpressions has been successfully glorified each year, including ?08 when Xpressions went national!', 1, '2012-01-27 15:24:38'),
(8, 'New Post', 'Lets see how this goes', 1, '2012-07-13 15:22:35'),
(9, 'Typography Test Title', 'Add Some Text Here...Add Some Text Here...Add Some Text Here...Add Some Text Here...Add Some Text Here...Add Some Text Here...Add Some Text Here...Add Some Text Here...Add Some Text Here...Add Some Text Here...Add Some Text Here...Add Some Text Here...Add Some Text Here...Add Some Text Here...Add Some Text Here...Add Some Text Here...Add Some Text Here...Add Some Text Here...Add Some Text Here...Add Some Text Here...Add Some Text Here...Add Some Text Here...Add Some Text Here...Add Some Text Here...Add Some Text Here...Add Some Text Here...Add Some Text Here...Add Some Text Here...Add Some Text Here...Add Some Text Here...Add Some Text Here...Add Some Text Here...Add Some Text Here...Add Some Text Here...Add Some Text Here...Add Some Text Here...Add Some Text ', 1, '2012-07-14 22:23:02'),
(10, 'Type test 2', 'the quick brown fox jumped over the lazy dog.\nand tripped on its face', 1, '2012-07-14 22:24:01'),
(11, 'Title', 'line one andddddddddddddddd<br />\nline 2 taddaaaaaaaaaaaaaaaaaaa', 1, '2012-07-14 22:26:35');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `fk_comments_members` FOREIGN KEY (`author_id`) REFERENCES `members` (`id`),
  ADD CONSTRAINT `fk_comments_posts` FOREIGN KEY (`thread_id`) REFERENCES `posts` (`id`);

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `fk_events_members` FOREIGN KEY (`creator_id`) REFERENCES `members` (`id`);

--
-- Constraints for table `event_comments`
--
ALTER TABLE `event_comments`
  ADD CONSTRAINT `fk_eventcomm_events` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`),
  ADD CONSTRAINT `fk_eventcomm_members` FOREIGN KEY (`author_id`) REFERENCES `members` (`id`);

--
-- Constraints for table `event_organizers`
--
ALTER TABLE `event_organizers`
  ADD CONSTRAINT `fk_eventorg_events` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`),
  ADD CONSTRAINT `fk_eventorg_members` FOREIGN KEY (`user_id`) REFERENCES `members` (`id`);

--
-- Constraints for table `members`
--
ALTER TABLE `members`
  ADD CONSTRAINT `fk_members_department` FOREIGN KEY (`dept_id`) REFERENCES `departments` (`id`),
  ADD CONSTRAINT `members_ibfk_1` FOREIGN KEY (`inst_id`) REFERENCES `institutes` (`id`);

--
-- Constraints for table `participant_teams`
--
ALTER TABLE `participant_teams`
  ADD CONSTRAINT `fk_participant_events` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`),
  ADD CONSTRAINT `fk_participant_inst` FOREIGN KEY (`inst_id`) REFERENCES `institutes` (`id`);

--
-- Constraints for table `permission`
--
ALTER TABLE `permission`
  ADD CONSTRAINT `fk_permission_member` FOREIGN KEY (`user_id`) REFERENCES `members` (`id`);

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `fk_posts_members` FOREIGN KEY (`author_id`) REFERENCES `members` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
