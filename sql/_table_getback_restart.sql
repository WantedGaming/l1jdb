
-- --------------------------------------------------------

--
-- Table structure for table `getback_restart`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `getback_restart` (
  `area` int(10) NOT NULL DEFAULT 0,
  `note` varchar(50) DEFAULT NULL,
  `locx` int(10) NOT NULL DEFAULT 0,
  `locy` int(10) NOT NULL DEFAULT 0,
  `mapid` int(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `getback_restart`:
--
