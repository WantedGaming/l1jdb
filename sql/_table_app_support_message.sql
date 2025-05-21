
-- --------------------------------------------------------

--
-- Table structure for table `app_support_message`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `app_support_message` (
  `type` enum('AGREE','PROGRESS','REWARD') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'AGREE',
  `index_id` int(2) NOT NULL DEFAULT 1,
  `content` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `app_support_message`:
--
