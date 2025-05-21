
-- --------------------------------------------------------

--
-- Table structure for table `character_arca`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `character_arca` (
  `id` int(1) NOT NULL DEFAULT 0,
  `charId` int(10) NOT NULL DEFAULT 0,
  `day` int(3) NOT NULL DEFAULT 0,
  `useItemId` int(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `character_arca`:
--
