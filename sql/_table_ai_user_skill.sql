
-- --------------------------------------------------------

--
-- Table structure for table `ai_user_skill`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `ai_user_skill` (
  `class` enum('lancer','fencer','warrior','illusionist','dragonknight','darkelf','wizard','elf','knight','crown') NOT NULL DEFAULT 'crown',
  `active` text DEFAULT NULL,
  `passive` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `ai_user_skill`:
--
