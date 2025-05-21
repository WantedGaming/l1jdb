
-- --------------------------------------------------------

--
-- Table structure for table `clan_joinning`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `clan_joinning` (
  `pledge_uid` int(10) NOT NULL DEFAULT 0,
  `pledge_name` varchar(50) DEFAULT NULL,
  `user_uid` int(10) NOT NULL DEFAULT 0,
  `user_name` varchar(50) NOT NULL,
  `join_message` varchar(100) DEFAULT NULL,
  `class_type` int(2) NOT NULL DEFAULT 0,
  `join_date` int(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `clan_joinning`:
--
