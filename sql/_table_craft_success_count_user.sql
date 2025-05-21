
-- --------------------------------------------------------

--
-- Table structure for table `craft_success_count_user`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `craft_success_count_user` (
  `accountName` varchar(50) NOT NULL,
  `charId` int(10) NOT NULL DEFAULT 0,
  `craftId` int(6) NOT NULL DEFAULT 0,
  `success_count_type` enum('World','Account','Character','AllServers') NOT NULL DEFAULT 'World',
  `currentCount` int(3) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `craft_success_count_user`:
--
