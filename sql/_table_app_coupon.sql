
-- --------------------------------------------------------

--
-- Table structure for table `app_coupon`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `app_coupon` (
  `number` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `type` enum('VOUCHER','NCOIN','NPOINT') NOT NULL DEFAULT 'NCOIN',
  `price` int(11) NOT NULL DEFAULT 0,
  `status` enum('false','true') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'false',
  `useAccount` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `createTime` datetime NOT NULL,
  `useTime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `app_coupon`:
--
