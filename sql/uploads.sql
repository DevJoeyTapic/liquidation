
CREATE TABLE `upload` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) DEFAULT NULL,
  `file_description` varchar(200) DEFAULT NULL,
  `file_name` varchar(200) DEFAULT NULL,
  `file_type` varchar(10) DEFAULT NULL,
  `file_size` float DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
