
-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--
-- Creation: May 21, 2025 at 07:09 AM
-- Last update: May 21, 2025 at 07:12 AM
--

CREATE TABLE `accounts` (
  `login` varchar(50) NOT NULL DEFAULT '',
  `password` varchar(50) NOT NULL,
  `lastactive` datetime DEFAULT NULL,
  `lastQuit` datetime DEFAULT NULL,
  `access_level` int(11) NOT NULL DEFAULT 0,
  `ip` varchar(20) NOT NULL DEFAULT '',
  `host` varchar(20) NOT NULL DEFAULT '',
  `banned` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `charslot` int(11) NOT NULL DEFAULT 6,
  `warehouse_password` int(11) NOT NULL DEFAULT 0,
  `notice` varchar(20) DEFAULT '0',
  `quiz` varchar(20) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `hddId` varchar(255) DEFAULT NULL,
  `boardId` varchar(255) DEFAULT NULL,
  `Tam_Point` int(11) NOT NULL DEFAULT 0,
  `Buff_DMG_Time` datetime DEFAULT NULL,
  `Buff_Reduc_Time` datetime DEFAULT NULL,
  `Buff_Magic_Time` datetime DEFAULT NULL,
  `Buff_Stun_Time` datetime DEFAULT NULL,
  `Buff_Hold_Time` datetime DEFAULT NULL,
  `BUFF_PCROOM_Time` datetime DEFAULT NULL,
  `Buff_FireDefence_Time` datetime DEFAULT NULL,
  `Buff_EarthDefence_Time` datetime DEFAULT NULL,
  `Buff_WaterDefence_Time` datetime DEFAULT NULL,
  `Buff_WindDefence_Time` datetime DEFAULT NULL,
  `Buff_SoulDefence_Time` datetime DEFAULT NULL,
  `Buff_Str_Time` datetime DEFAULT NULL,
  `Buff_Dex_Time` datetime DEFAULT NULL,
  `Buff_Wis_Time` datetime DEFAULT NULL,
  `Buff_Int_Time` datetime DEFAULT NULL,
  `Buff_FireAttack_Time` datetime DEFAULT NULL,
  `Buff_EarthAttack_Time` datetime DEFAULT NULL,
  `Buff_WaterAttack_Time` datetime DEFAULT NULL,
  `Buff_WindAttack_Time` datetime DEFAULT NULL,
  `Buff_Hero_Time` datetime DEFAULT NULL,
  `Buff_Life_Time` datetime DEFAULT NULL,
  `second_password` varchar(11) DEFAULT NULL,
  `Ncoin` int(11) NOT NULL DEFAULT 0,
  `Npoint` int(11) NOT NULL DEFAULT 0,
  `Shop_open_count` int(6) NOT NULL DEFAULT 0,
  `DragonRaid_Buff` datetime DEFAULT NULL,
  `Einhasad` int(11) NOT NULL DEFAULT 0,
  `EinDayBonus` int(2) NOT NULL DEFAULT 0,
  `IndunCheckTime` datetime DEFAULT NULL,
  `IndunCount` int(2) NOT NULL DEFAULT 0,
  `app_char` int(10) NOT NULL DEFAULT 0,
  `app_terms_agree` enum('false','true') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'false',
  `PSSTime` int(11) NOT NULL DEFAULT 1800
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `accounts`:
--
