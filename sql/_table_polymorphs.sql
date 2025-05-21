
-- --------------------------------------------------------

--
-- Table structure for table `polymorphs`
--
-- Creation: May 21, 2025 at 07:09 AM
-- Last update: May 21, 2025 at 07:09 AM
--

CREATE TABLE `polymorphs` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `polyid` int(11) NOT NULL,
  `minlevel` int(11) NOT NULL,
  `weaponequip` int(11) DEFAULT NULL,
  `armorequip` int(11) DEFAULT NULL,
  `isSkillUse` int(11) NOT NULL,
  `cause` int(11) DEFAULT NULL,
  `bonusPVP` enum('true','false') NOT NULL DEFAULT 'false',
  `formLongEnable` enum('true','false') NOT NULL DEFAULT 'false'
) ENGINE=MyISAM DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci COMMENT='MyISAM free: 10240 kB';

--
-- RELATIONSHIPS FOR TABLE `polymorphs`:
--
