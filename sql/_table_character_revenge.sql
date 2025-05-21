
-- --------------------------------------------------------

--
-- Table structure for table `character_revenge`
--
-- Creation: May 21, 2025 at 07:09 AM
-- Last update: May 21, 2025 at 07:09 AM
-- Last check: May 21, 2025 at 07:09 AM
--

CREATE TABLE `character_revenge` (
  `number` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `char_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `result` int(2) UNSIGNED NOT NULL DEFAULT 0,
  `starttime` datetime DEFAULT NULL,
  `endtime` datetime DEFAULT NULL,
  `chasestarttime` datetime DEFAULT NULL,
  `chaseendtime` datetime DEFAULT NULL,
  `usecount` int(2) UNSIGNED NOT NULL DEFAULT 0,
  `amount` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `targetobjid` int(10) NOT NULL DEFAULT 0,
  `targetclass` int(2) UNSIGNED NOT NULL DEFAULT 0,
  `targetname` varchar(45) NOT NULL DEFAULT '',
  `targetclanid` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `targetclanname` varchar(45) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `character_revenge`:
--
