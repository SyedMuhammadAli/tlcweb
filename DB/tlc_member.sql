CREATE TABLE `tlc_member` (
  `tlc_member_id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `dept_id` int(11) NOT NULL,
  PRIMARY KEY (`tlc_member_id`),
  KEY `member_id` (`member_id`),
  KEY `dept_id` (`dept_id`),
  CONSTRAINT `tlc_member_ibfk_2` FOREIGN KEY (`dept_id`) REFERENCES `departments` (`id`),
  CONSTRAINT `tlc_member_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
