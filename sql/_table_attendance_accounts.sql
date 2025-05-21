
-- --------------------------------------------------------

--
-- Table structure for table `attendance_accounts`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `attendance_accounts` (
  `account` varchar(50) NOT NULL DEFAULT '',
  `dailyCount` int(4) NOT NULL DEFAULT 0,
  `isCompleted` enum('true','false') NOT NULL DEFAULT 'false',
  `resetDate` datetime DEFAULT NULL,
  `groupData` blob DEFAULT NULL,
  `groupOpen` blob DEFAULT NULL,
  `randomItems` text DEFAULT NULL,
  `rewardHistory` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `attendance_accounts`:
--
