
-- --------------------------------------------------------

--
-- Table structure for table `app_trade`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `app_trade` (
  `id` int(11) NOT NULL DEFAULT 0,
  `title` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `content` varchar(1000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `bank` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `bankNumber` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `status` enum('SELL','IN_PROGRESS','COMPLETED','CANCELLED') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'SELL',
  `sellerName` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `sellerCharacter` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `sellerPhone` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `buyerName` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `buyerCharacter` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `buyerPhone` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `writeTime` datetime NOT NULL,
  `send` enum('false','true') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'false',
  `receive` enum('false','true') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'false',
  `completeTime` datetime DEFAULT NULL,
  `sellerCancle` enum('false','true') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'false',
  `buyerCancle` enum('false','true') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'false',
  `top` enum('true','false') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'false'
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `app_trade`:
--
