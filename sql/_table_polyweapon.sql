
-- --------------------------------------------------------

--
-- Table structure for table `polyweapon`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `polyweapon` (
  `polyId` int(5) NOT NULL DEFAULT 0,
  `weapon` enum('bow','spear','both') NOT NULL DEFAULT 'both'
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `polyweapon`:
--
