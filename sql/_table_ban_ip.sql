
-- --------------------------------------------------------

--
-- Table structure for table `ban_ip`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `ban_ip` (
  `address` varchar(255) NOT NULL DEFAULT '',
  `reason` enum('CONNECTION_OVER','PACKET_ATTACK','BAD_USER','UNSUAL_REQUEST','WEB_URI_LENGTH_OVER','WEB_REQUEST_OVER','SERVER_SLANDER','WELLKNOWN_PORT','BUG_ABOUS','CHEAT','ETC','WEB_ATTACK_REQUEST','WEB_NOT_AUTH_IP') NOT NULL DEFAULT 'ETC',
  `registTime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `ban_ip`:
--
