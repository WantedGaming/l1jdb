
-- --------------------------------------------------------

--
-- Table structure for table `bin_portrait_common`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `bin_portrait_common` (
  `asset_id` int(5) NOT NULL DEFAULT 0,
  `desc_id` varchar(100) DEFAULT NULL,
  `desc_kr` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `bin_portrait_common`:
--
