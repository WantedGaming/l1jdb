
-- --------------------------------------------------------

--
-- Table structure for table `app_powerbook_guide`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `app_powerbook_guide` (
  `group_type` enum('1. Beginner''s Guide','2. Classes','3. Items','4. Magic','5. Magic Dolls','6. Monsters & Dungeons','7. Party Content','8. World Content','9. Combat System','10. Community','11. Main Systems','12. Service') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '1. Beginner''s Guide',
  `id` int(2) NOT NULL DEFAULT 0,
  `title` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `uri` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `is_new` enum('true','false') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'false'
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `app_powerbook_guide`:
--
