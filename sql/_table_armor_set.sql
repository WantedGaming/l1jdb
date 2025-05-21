
-- --------------------------------------------------------

--
-- Table structure for table `armor_set`
--
-- Creation: May 21, 2025 at 07:09 AM
-- Last update: May 21, 2025 at 07:09 AM
--

CREATE TABLE `armor_set` (
  `id` int(10) NOT NULL,
  `note` varchar(45) DEFAULT NULL,
  `sets` varchar(1000) NOT NULL,
  `polyid` int(6) NOT NULL DEFAULT 0,
  `min_enchant` int(2) NOT NULL DEFAULT 0,
  `ac` int(2) NOT NULL DEFAULT 0,
  `hp` int(5) NOT NULL DEFAULT 0,
  `mp` int(5) NOT NULL DEFAULT 0,
  `hpr` int(5) NOT NULL DEFAULT 0,
  `mpr` int(5) NOT NULL DEFAULT 0,
  `mr` int(5) NOT NULL DEFAULT 0,
  `str` int(2) NOT NULL DEFAULT 0,
  `dex` int(2) NOT NULL DEFAULT 0,
  `con` int(2) NOT NULL DEFAULT 0,
  `wis` int(2) NOT NULL DEFAULT 0,
  `cha` int(2) NOT NULL DEFAULT 0,
  `intl` int(2) NOT NULL DEFAULT 0,
  `shorthitup` int(2) NOT NULL DEFAULT 0,
  `shortdmgup` int(2) NOT NULL DEFAULT 0,
  `shortCritical` int(2) NOT NULL DEFAULT 0,
  `longhitup` int(2) NOT NULL DEFAULT 0,
  `longdmgup` int(2) NOT NULL DEFAULT 0,
  `longCritical` int(2) NOT NULL DEFAULT 0,
  `sp` int(2) NOT NULL DEFAULT 0,
  `magichitup` int(2) NOT NULL DEFAULT 0,
  `magicCritical` int(2) NOT NULL DEFAULT 0,
  `earth` int(10) NOT NULL DEFAULT 0,
  `fire` int(10) NOT NULL DEFAULT 0,
  `wind` int(10) NOT NULL DEFAULT 0,
  `water` int(10) NOT NULL DEFAULT 0,
  `reduction` int(2) NOT NULL DEFAULT 0,
  `reductionEgnor` int(2) NOT NULL DEFAULT 0,
  `magicReduction` int(2) NOT NULL DEFAULT 0,
  `PVPDamage` int(2) NOT NULL DEFAULT 0,
  `PVPDamageReduction` int(2) NOT NULL DEFAULT 0,
  `PVPMagicDamageReduction` int(2) NOT NULL DEFAULT 0,
  `PVPReductionEgnor` int(2) NOT NULL DEFAULT 0,
  `PVPMagicDamageReductionEgnor` int(2) NOT NULL DEFAULT 0,
  `abnormalStatusDamageReduction` int(2) NOT NULL DEFAULT 0,
  `abnormalStatusPVPDamageReduction` int(2) NOT NULL DEFAULT 0,
  `PVPDamagePercent` int(2) NOT NULL DEFAULT 0,
  `expBonus` int(2) NOT NULL DEFAULT 0,
  `rest_exp_reduce_efficiency` int(2) NOT NULL DEFAULT 0,
  `dg` int(2) NOT NULL DEFAULT 0,
  `er` int(2) NOT NULL DEFAULT 0,
  `me` int(2) NOT NULL DEFAULT 0,
  `toleranceSkill` int(2) NOT NULL DEFAULT 0,
  `toleranceSpirit` int(2) NOT NULL DEFAULT 0,
  `toleranceDragon` int(2) NOT NULL DEFAULT 0,
  `toleranceFear` int(2) NOT NULL DEFAULT 0,
  `toleranceAll` int(2) NOT NULL DEFAULT 0,
  `hitupSkill` int(2) NOT NULL DEFAULT 0,
  `hitupSpirit` int(2) NOT NULL DEFAULT 0,
  `hitupDragon` int(2) NOT NULL DEFAULT 0,
  `hitupFear` int(2) NOT NULL DEFAULT 0,
  `hitupAll` int(2) NOT NULL DEFAULT 0,
  `strangeTimeIncrease` int(4) NOT NULL DEFAULT 0,
  `underWater` enum('true','false') NOT NULL DEFAULT 'false'
) ENGINE=MyISAM DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci COMMENT='MyISAM free: 10240 kB';

--
-- RELATIONSHIPS FOR TABLE `armor_set`:
--
