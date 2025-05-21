
-- --------------------------------------------------------

--
-- Table structure for table `ai_user_ment`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `ai_user_ment` (
  `id` int(3) NOT NULL,
  `ment` varchar(100) DEFAULT NULL,
  `type` enum('login','logout','kill','death') DEFAULT 'login'
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `ai_user_ment`:
--
