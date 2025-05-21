
-- --------------------------------------------------------

--
-- Table structure for table `character_buff`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `character_buff` (
  `char_obj_id` int(10) NOT NULL DEFAULT 0,
  `skill_id` int(10) NOT NULL DEFAULT -1,
  `remaining_time` int(10) NOT NULL DEFAULT 0,
  `poly_id` int(10) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `character_buff`:
--
