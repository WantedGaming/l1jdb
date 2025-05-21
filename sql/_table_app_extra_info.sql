
-- --------------------------------------------------------

--
-- Table structure for table `app_extra_info`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `app_extra_info` (
  `extra_info_id` int(11) NOT NULL,
  `extra_info_type` enum('ITEM','NPC','SKILL','MAP') NOT NULL,
  `name` varchar(100) NOT NULL,
  `extra_info` text NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `app_extra_info`:
--
