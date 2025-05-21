
-- --------------------------------------------------------

--
-- Table structure for table `dungeon_timer_character`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `dungeon_timer_character` (
  `charId` int(10) NOT NULL DEFAULT 0,
  `timerId` int(10) NOT NULL DEFAULT 0,
  `remainSecond` int(10) NOT NULL DEFAULT 0,
  `chargeCount` int(2) NOT NULL DEFAULT 0,
  `resetTime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `dungeon_timer_character`:
--
