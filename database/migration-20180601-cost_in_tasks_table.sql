ALTER TABLE `oceania`.`tasks` 
CHANGE COLUMN `updated_at` `updated_at` FLOAT NOT NULL DEFAULT '0000-00-00 00:00:00' ,
ADD COLUMN `expectation` FLOAT NULL AFTER `text`;
