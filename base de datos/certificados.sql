-- --------------------------------------------------------
-- Host:                         localhost
-- Versión del servidor:         10.4.19-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para certificados
CREATE DATABASE IF NOT EXISTS `certificados` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `certificados`;

-- Volcando estructura para tabla certificados.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` char(200) DEFAULT NULL,
  `lastname` char(200) DEFAULT NULL,
  `quiz` char(200) DEFAULT NULL,
  `userid` char(200) DEFAULT NULL,
  `grade` char(200) DEFAULT NULL,
  `name` char(200) DEFAULT NULL,
  `auth` char(200) DEFAULT NULL,
  `timemodified` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla certificados.usuarios: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` (`id`, `firstname`, `lastname`, `quiz`, `userid`, `grade`, `name`, `auth`, `timemodified`) VALUES
	(1, 'NOMBRE', 'APELLIDO', '10', 'USUARIO', '2', 'NOMBRE', 'db', '2021-08-29 13:04:18');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
