
-- --------------------------------------------------------

--
-- Table structure for table `weapon_skill`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `weapon_skill` (
  `weapon_id` int(11) UNSIGNED NOT NULL,
  `note` varchar(255) DEFAULT NULL,
  `attackType` enum('PVE','PVP','ALL') NOT NULL DEFAULT 'ALL',
  `probability` int(3) UNSIGNED NOT NULL DEFAULT 0,
  `fix_damage` int(6) UNSIGNED NOT NULL DEFAULT 0,
  `random_damage` int(6) UNSIGNED NOT NULL DEFAULT 0,
  `area` int(3) NOT NULL DEFAULT 0,
  `skill_id` int(11) NOT NULL DEFAULT -1,
  `skill_time` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `effect_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `effect_target` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `arrow_type` int(3) UNSIGNED NOT NULL DEFAULT 0,
  `attr` enum('NONE','EARTH','FIRE','WATER','WIND','RAY') NOT NULL DEFAULT 'NONE',
  `enchant_probability` int(3) NOT NULL DEFAULT 0,
  `enchant_damage` int(3) NOT NULL DEFAULT 0,
  `int_damage` int(3) NOT NULL DEFAULT 0,
  `spell_damage` int(3) NOT NULL DEFAULT 0,
  `enchant_limit` int(3) NOT NULL DEFAULT 0,
  `hpStill` enum('true','false') NOT NULL DEFAULT 'false',
  `hpStill_probabliity` int(3) NOT NULL DEFAULT 0,
  `hpStillValue` int(3) NOT NULL DEFAULT 0,
  `mpStill` enum('true','false') NOT NULL DEFAULT 'false',
  `mpStill_probabliity` int(11) NOT NULL DEFAULT 0,
  `mpStillValue` int(3) NOT NULL DEFAULT 0,
  `stillEffectId` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `weapon_skill`:
--
