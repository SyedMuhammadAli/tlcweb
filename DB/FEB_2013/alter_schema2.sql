ALTER TABLE `members` CHANGE `pswd` `pswd` VARCHAR( 64 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `members` ADD `salt` VARCHAR( 14 ) NOT NULL COMMENT 'Encrption Salt';
