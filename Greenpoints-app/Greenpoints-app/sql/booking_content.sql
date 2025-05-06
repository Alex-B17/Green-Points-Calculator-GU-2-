
CREATE TABLE IF NOT EXISTS `booking_content` (
  `content_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `booking_id` int(10) unsigned NOT NULL,
  `movie_id` int(10) unsigned NOT NULL,
  `quantity` int(10) unsigned NOT NULL DEFAULT '1',
  `price` decimal(4,2) NOT NULL,
  PRIMARY KEY (`content_id`)
) ;

