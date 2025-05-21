
-- --------------------------------------------------------

--
-- Table structure for table `getback`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `getback` (
  `area_x1` int(10) NOT NULL DEFAULT 0,
  `area_y1` int(10) NOT NULL DEFAULT 0,
  `area_x2` int(10) NOT NULL DEFAULT 0,
  `area_y2` int(10) NOT NULL DEFAULT 0,
  `area_mapid` int(10) NOT NULL DEFAULT 0,
  `getback_x1` int(10) NOT NULL DEFAULT 0,
  `getback_y1` int(10) NOT NULL DEFAULT 0,
  `getback_x2` int(10) NOT NULL DEFAULT 0,
  `getback_y2` int(10) NOT NULL DEFAULT 0,
  `getback_x3` int(10) NOT NULL DEFAULT 0,
  `getback_y3` int(10) NOT NULL DEFAULT 0,
  `getback_mapid` int(10) NOT NULL DEFAULT 0,
  `getback_townid` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `getback_townid_elf` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `getback_townid_darkelf` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `scrollescape` int(10) NOT NULL DEFAULT 1,
  `note` varchar(50) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `getback`:
--
