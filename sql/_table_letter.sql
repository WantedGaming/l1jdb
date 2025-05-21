
-- --------------------------------------------------------

--
-- Table structure for table `letter`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `letter` (
  `item_object_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `code` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `sender` varchar(16) DEFAULT NULL,
  `receiver` varchar(16) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `template_id` int(5) UNSIGNED NOT NULL DEFAULT 0,
  `subject` varchar(20) DEFAULT NULL,
  `content` varchar(2000) DEFAULT NULL,
  `isCheck` bit(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `letter`:
--
