
-- --------------------------------------------------------

--
-- Table structure for table `app_page_info`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `app_page_info` (
  `uri` varchar(100) NOT NULL,
  `path` varchar(100) DEFAULT NULL,
  `className` varchar(100) NOT NULL,
  `cnbType` int(2) NOT NULL DEFAULT 0,
  `cnbSubType` int(2) NOT NULL DEFAULT 0,
  `needIngame` enum('true','false') NOT NULL DEFAULT 'false',
  `needLauncher` enum('true','false') NOT NULL DEFAULT 'false',
  `needLogin` enum('true','false') NOT NULL DEFAULT 'false',
  `needGm` enum('true','false') NOT NULL DEFAULT 'false',
  `Json` enum('true','false') NOT NULL DEFAULT 'false',
  `fileUpload` enum('true','false') NOT NULL DEFAULT 'false'
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `app_page_info`:
--
