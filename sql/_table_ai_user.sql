
-- --------------------------------------------------------

--
-- Table structure for table `ai_user`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `ai_user` (
  `name` varchar(50) NOT NULL,
  `ai_type` enum('AI_BATTLE','COLOSEUM','HUNT','FISHING','TOWN_MOVE','SCARECROW_ATTACK') NOT NULL DEFAULT 'AI_BATTLE',
  `level` int(3) NOT NULL DEFAULT 0,
  `class` enum('lancer','fencer','warrior','illusionist','dragonknight','darkelf','wizard','elf','knight','crown') DEFAULT 'crown',
  `gender` enum('MALE(0)','FEMALE(1)') NOT NULL DEFAULT 'MALE(0)',
  `str` int(3) NOT NULL DEFAULT 0,
  `con` int(3) NOT NULL DEFAULT 0,
  `dex` int(3) NOT NULL DEFAULT 0,
  `inti` int(3) NOT NULL DEFAULT 0,
  `wis` int(3) NOT NULL DEFAULT 0,
  `cha` int(3) NOT NULL DEFAULT 0,
  `alignment` int(6) NOT NULL DEFAULT 0,
  `hit` int(3) NOT NULL DEFAULT 0,
  `bow_hit` int(3) NOT NULL DEFAULT 0,
  `dmg` int(3) NOT NULL DEFAULT 0,
  `bow_dmg` int(3) NOT NULL DEFAULT 0,
  `reduction` int(3) NOT NULL DEFAULT 0,
  `skill_hit` int(3) NOT NULL DEFAULT 0,
  `spirit_hit` int(3) NOT NULL DEFAULT 0,
  `dragon_hit` int(3) NOT NULL DEFAULT 0,
  `magic_hit` int(3) NOT NULL DEFAULT 0,
  `fear_hit` int(3) NOT NULL DEFAULT 0,
  `skill_regist` int(3) NOT NULL DEFAULT 0,
  `spirit_regist` int(3) NOT NULL DEFAULT 0,
  `dragon_regist` int(3) NOT NULL DEFAULT 0,
  `fear_regist` int(3) NOT NULL DEFAULT 0,
  `dg` int(3) NOT NULL DEFAULT 0,
  `er` int(3) NOT NULL DEFAULT 0,
  `me` int(3) NOT NULL DEFAULT 0,
  `mr` int(3) NOT NULL DEFAULT 0,
  `hp` int(4) NOT NULL DEFAULT 0,
  `mp` int(4) NOT NULL DEFAULT 0,
  `hpr` int(3) NOT NULL DEFAULT 0,
  `mpr` int(3) NOT NULL DEFAULT 0,
  `title` varchar(50) DEFAULT NULL,
  `clanId` int(2) NOT NULL DEFAULT 0,
  `clanname` varchar(50) DEFAULT NULL,
  `elfAttr` int(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `ai_user`:
--
