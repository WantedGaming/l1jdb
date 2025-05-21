
-- --------------------------------------------------------

--
-- Table structure for table `character_einhasadstat`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `character_einhasadstat` (
  `objid` int(11) NOT NULL DEFAULT 0,
  `bless` int(3) NOT NULL DEFAULT 0,
  `lucky` int(3) NOT NULL DEFAULT 0,
  `vital` int(3) NOT NULL DEFAULT 0,
  `itemSpellProb` int(3) NOT NULL DEFAULT 0,
  `absoluteRegen` int(3) NOT NULL DEFAULT 0,
  `potion` int(3) NOT NULL DEFAULT 0,
  `bless_efficiency` int(3) NOT NULL DEFAULT 0,
  `bless_exp` int(3) NOT NULL DEFAULT 0,
  `lucky_item` int(3) NOT NULL DEFAULT 0,
  `lucky_adena` int(3) NOT NULL DEFAULT 0,
  `vital_potion` int(3) NOT NULL DEFAULT 0,
  `vital_heal` int(3) NOT NULL DEFAULT 0,
  `itemSpellProb_armor` int(3) NOT NULL DEFAULT 0,
  `itemSpellProb_weapon` int(3) NOT NULL DEFAULT 0,
  `absoluteRegen_hp` int(3) NOT NULL DEFAULT 0,
  `absoluteRegen_mp` int(3) NOT NULL DEFAULT 0,
  `potion_critical` int(3) NOT NULL DEFAULT 0,
  `potion_delay` int(3) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- RELATIONSHIPS FOR TABLE `character_einhasadstat`:
--
