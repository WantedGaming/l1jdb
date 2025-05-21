
-- --------------------------------------------------------

--
-- Table structure for table `admin_activity`
--
-- Creation: May 21, 2025 at 07:09 AM
-- Last update: May 21, 2025 at 07:09 AM
--

CREATE TABLE `admin_activity` (
  `id` int(11) NOT NULL,
  `admin_username` varchar(50) NOT NULL,
  `activity_type` varchar(20) NOT NULL,
  `description` text NOT NULL,
  `entity_type` varchar(50) DEFAULT NULL,
  `entity_id` int(11) DEFAULT NULL,
  `ip_address` varchar(45) NOT NULL,
  `user_agent` text NOT NULL,
  `timestamp` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `admin_activity`:
--
