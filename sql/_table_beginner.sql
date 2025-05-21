
-- --------------------------------------------------------

--
-- Table structure for table `beginner`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `beginner` (
  `id` int(10) NOT NULL,
  `item_id` int(6) NOT NULL DEFAULT 0,
  `count` int(10) NOT NULL DEFAULT 0,
  `charge_count` int(10) NOT NULL DEFAULT 0,
  `enchantlvl` int(6) NOT NULL DEFAULT 0,
  `item_name` varchar(50) NOT NULL DEFAULT '',
  `desc_kr` varchar(50) NOT NULL,
  `activate` enum('A','P','K','E','W','D','T','B','J','F','L') NOT NULL DEFAULT 'A'
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `beginner`:
--
