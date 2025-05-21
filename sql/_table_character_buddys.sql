
-- --------------------------------------------------------

--
-- Table structure for table `character_buddys`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `character_buddys` (
  `id` int(10) UNSIGNED NOT NULL,
  `char_id` int(10) NOT NULL DEFAULT 0,
  `buddy_name` varchar(45) NOT NULL,
  `buddy_memo` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `character_buddys`:
--
