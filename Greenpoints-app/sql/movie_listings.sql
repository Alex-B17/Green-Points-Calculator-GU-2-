

CREATE TABLE IF NOT EXISTS `movie_listings` (
  `movie_id` int(20) NOT NULL,
  `movie_title` varchar(30) NOT NULL,
  `genre` varchar(30) NOT NULL,
  `age_rating` varchar(30) NOT NULL,
  `show1` varchar(6) NOT NULL,
  `show2` varchar(6) NOT NULL,
  `show3` varchar(6) NOT NULL,
  `theatre` varchar(20) NOT NULL,
  `further_info` varchar(500) NOT NULL,
  `release` varchar(30) NOT NULL,
  `img` varchar(30) NOT NULL,
  `preview` varchar(300) NOT NULL,
  `mov_price` decimal(4,2) NOT NULL
) 