-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE IF NOT EXISTS `log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(25) DEFAULT NULL,
  `from_number` varchar(255) DEFAULT NULL,
  `to_number` varchar(255) DEFAULT NULL,
  `message` text,
  `ip` bigint(20) DEFAULT NULL,
  `api_response` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `scheduled_datetime` datetime DEFAULT NULL,
  `sms_scheduled_time` datetime DEFAULT NULL,
  `scheduled_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `executed_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `finished_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;