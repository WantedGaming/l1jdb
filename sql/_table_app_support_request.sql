
-- --------------------------------------------------------

--
-- Table structure for table `app_support_request`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `app_support_request` (
  `id` int(10) NOT NULL DEFAULT 0,
  `account_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `character_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `request_date` datetime NOT NULL,
  `response` text CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `response_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `app_support_request`:
--
