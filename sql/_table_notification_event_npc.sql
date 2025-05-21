
-- --------------------------------------------------------

--
-- Table structure for table `notification_event_npc`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `notification_event_npc` (
  `notification_id` int(6) NOT NULL DEFAULT 0,
  `is_use` enum('true','false') NOT NULL DEFAULT 'true',
  `order_id` int(2) NOT NULL DEFAULT 0,
  `npc_id` int(10) NOT NULL DEFAULT 0,
  `displaydesc` varchar(50) NOT NULL,
  `displaydesc_en` varchar(50) NOT NULL,
  `displaydesc_kr` varchar(50) DEFAULT NULL,
  `rest_gauge_bonus` int(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `notification_event_npc`:
--
