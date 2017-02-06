-- /*******************************************************
-- *
-- * civicrm_avtale_banking
-- *
-- *******************************************************/
CREATE TABLE IF NOT EXISTS `civicrm_avtale_banking` (
  `ba_id` INT UNSIGNED NOT NULL,
  `maximum_amount` INT UNSIGNED NULL,
  `notification_to_bank` INT(1) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY ( `ba_id` ),
  CONSTRAINT FK_civicrm_avtale_banking_ba_id FOREIGN KEY (`ba_id`) REFERENCES `civicrm_bank_account`(`id`) ON DELETE CASCADE
)  ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci  ;