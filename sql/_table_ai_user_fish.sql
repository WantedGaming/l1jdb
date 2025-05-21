
-- --------------------------------------------------------

--
-- Table structure for table `ai_user_fish`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `ai_user_fish` (
  `loc_x` int(5) NOT NULL DEFAULT 0,
  `loc_y` int(5) NOT NULL DEFAULT 0,
  `heading` int(1) NOT NULL DEFAULT 0,
  `fish_x` int(5) NOT NULL DEFAULT 0,
  `fish_y` int(5) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `ai_user_fish`:
--
