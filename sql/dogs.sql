


USE demo;
--
-- Table structure for table `dogs`
--
DROP TABLE IF EXISTS `dogs`;

CREATE TABLE `dogs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `DOB` DATE NOT NULL,
  `age` int(2) NOT NULL,
  `img` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `dogs`
--

INSERT INTO `dogs` (`id`, `name`, `DOB`, `age`, `img`) VALUES
(1, 'Chico', date_format(2015-04-11), 7, 'Chico.jpg'),
(2, 'Amber', date_format(2019-03-10), 3, 'Amber.jpg'),
(3, 'Ginger', date_format(2012-02-09), 10, 'Ginger.jpg');