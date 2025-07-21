-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-07-2025 a las 18:39:12
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `historias_clinicas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historias`
--

CREATE TABLE `historias` (
  `id_historia` int(6) NOT NULL,
  `fecha` text DEFAULT NULL,
  `motivo_consulta` varchar(1000) NOT NULL,
  `peso` int(4) NOT NULL,
  `altura` float NOT NULL,
  `imc` int(6) NOT NULL,
  `igc` int(6) NOT NULL,
  `tratamiento` varchar(1000) NOT NULL,
  `observaciones` text NOT NULL,
  `id_paciente` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `historias`
--

INSERT INTO `historias` (`id_historia`, `fecha`, `motivo_consulta`, `peso`, `altura`, `imc`, `igc`, `tratamiento`, `observaciones`, `id_paciente`) VALUES
(23, '2025-07-18\n2025-07-19', 'no mi compa', 23, 23, 23, 23, 'no mi compa\ndfdfd', 'no mi compa', 23),
(24, '2025-07-18\n2025-07-25', 'no mi compa', 23, 23, 23, 23, 'no mi compa\nfgfg', 'no mi compa', 24),
(25, '2025-07-18', 'no mi compa', 23, 23, 23, 23, 'no mi compa', 'no mi compa', 25),
(26, '2025-07-18', 'no mi compa', 23, 45, 23, 23, 'no mi compa', 'no mi compa', 26),
(27, '2025-07-18', 'no mi compa', 23, 45, 23, 23, 'no mi compaNOO', 'no mi compaNOOO', 27);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pacientes`
--

CREATE TABLE `pacientes` (
  `id_paciente` int(6) NOT NULL,
  `nombre_paciente` varchar(50) DEFAULT NULL,
  `apellido_p` varchar(40) DEFAULT NULL,
  `apellido_m` varchar(40) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `sexo` char(1) DEFAULT NULL,
  `telefono` varchar(10) DEFAULT NULL,
  `ocupacion` varchar(400) NOT NULL,
  `estado_civil` varchar(400) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pacientes`
--

INSERT INTO `pacientes` (`id_paciente`, `nombre_paciente`, `apellido_p`, `apellido_m`, `fecha_nacimiento`, `sexo`, `telefono`, `ocupacion`, `estado_civil`) VALUES
(23, 'Angeldfdf', 'Tah', 'Och', '2005-03-08', 'H', '9811777647', 'dfdf', '                \r\n      fdfdfdf      '),
(24, 'Angeldfdf', 'Tah', 'Och', '2005-03-08', 'H', '9811777647', 'dfdf', '                \r\n      fdfdfdf      '),
(25, 'Angeldfdfttttt', 'Tah', 'Och', '2005-03-08', 'H', '9811777647', 'dfdf', '                \r\n      fdfdfdf      '),
(26, 'Angel', 'Tah', 'Och', '2005-03-08', 'H', '9811777647', 'dfdf', '            fgfgfg    \r\n            '),
(27, 'temachjunior', 'juan', 'no mi compa', '2005-03-08', 'H', '9811777647', 'dfdf', '              casado con chakira  \r\n            ');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `historias`
--
ALTER TABLE `historias`
  ADD PRIMARY KEY (`id_historia`),
  ADD KEY `id_paciente_fk` (`id_paciente`);

--
-- Indices de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  ADD PRIMARY KEY (`id_paciente`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `historias`
--
ALTER TABLE `historias`
  MODIFY `id_historia` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  MODIFY `id_paciente` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `historias`
--
ALTER TABLE `historias`
  ADD CONSTRAINT `historias_ibfk_1` FOREIGN KEY (`id_paciente`) REFERENCES `pacientes` (`id_paciente`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
