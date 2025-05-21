
-- --------------------------------------------------------

--
-- Table structure for table `bin_companion_class_common`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `bin_companion_class_common` (
  `classId` int(6) NOT NULL DEFAULT 0,
  `class` varchar(100) DEFAULT NULL,
  `category` enum('DOG_FIGHT(5)','WILD(4)','PET(3)','DEVINE_BEAST(2)','FIERCE_ANIMAL(1)') NOT NULL DEFAULT 'FIERCE_ANIMAL(1)',
  `element` enum('LIGHT(5)','EARTH(4)','AIR(3)','WATER(2)','FIRE(1)','NONE(0)') NOT NULL DEFAULT 'NONE(0)',
  `skill` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `bin_companion_class_common`:
--
