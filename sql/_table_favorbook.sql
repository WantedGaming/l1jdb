
-- --------------------------------------------------------

--
-- Table structure for table `favorbook`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `favorbook` (
  `listId` int(2) NOT NULL DEFAULT 0,
  `category` int(3) NOT NULL DEFAULT 0,
  `slotId` int(1) NOT NULL,
  `itemIds` text DEFAULT NULL,
  `note` varchar(100) DEFAULT '',
  `desc_kr` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `favorbook`:
--
