
-- --------------------------------------------------------

--
-- Table structure for table `war_time`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `war_time` (
  `castleId` int(2) NOT NULL,
  `castleName` varchar(255) DEFAULT NULL,
  `day` enum('SUN','MON','TUE','WED','THU','FRI','SAT') NOT NULL DEFAULT 'SUN',
  `hour` enum('23','22','21','20','19','18','17','16','15','14','13','12','11','10','9','8','7','6','5','4','3','2','1','0') NOT NULL DEFAULT '0',
  `minute` enum('50','40','30','20','10','0') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `war_time`:
--
