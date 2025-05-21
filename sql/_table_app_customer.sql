
-- --------------------------------------------------------

--
-- Table structure for table `app_customer`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `app_customer` (
  `id` int(10) NOT NULL DEFAULT 0,
  `login` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `type` int(1) NOT NULL DEFAULT 1,
  `title` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `status` enum('Submitted','Answered') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'Submitted',
  `date` datetime NOT NULL,
  `comment` text CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `commentDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `app_customer`:
--
