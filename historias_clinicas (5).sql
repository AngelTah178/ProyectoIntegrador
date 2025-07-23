-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-07-2025 a las 00:54:39
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
-- Estructura de tabla para la tabla `doctor`
--

CREATE TABLE `doctor` (
  `id_doctor` int(2) NOT NULL,
  `cedula_doctor` int(7) NOT NULL,
  `nombre_doctor` varchar(80) NOT NULL,
  `apellido_p` varchar(50) NOT NULL,
  `apellido_m` varchar(50) NOT NULL,
  `especialidad` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `doctor`
--

INSERT INTO `doctor` (`id_doctor`, `cedula_doctor`, `nombre_doctor`, `apellido_p`, `apellido_m`, `especialidad`) VALUES
(1, 3206077, 'Blanca Esther', 'Briceño', 'Silva', 'Dermatología'),
(2, 3199486, 'Heriberto Neptali', 'Alva', 'Trujillo', 'Ginecología');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historias`
--

CREATE TABLE `historias` (
  `id_historia` int(6) NOT NULL,
  `fecha` text NOT NULL,
  `motivo_consulta` varchar(1000) NOT NULL,
  `peso` float DEFAULT NULL,
  `altura` float DEFAULT NULL,
  `imc` float DEFAULT NULL,
  `igc` float DEFAULT NULL,
  `tratamiento` varchar(1000) NOT NULL,
  `observaciones` text DEFAULT NULL,
  `id_paciente` int(6) NOT NULL,
  `id_doctor` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `historias`
--

INSERT INTO `historias` (`id_historia`, `fecha`, `motivo_consulta`, `peso`, `altura`, `imc`, `igc`, `tratamiento`, `observaciones`, `id_paciente`, `id_doctor`) VALUES
(1, '2025-07-21\n2025-07-24\n2025-07-24', 'no tengo cola', 3, 3, 3, 3, 'luz pulsada\ntener luz\ndfdfdf', 'no tiene colad', 1, 2),
(2, '2025-07-21', 'no tengo cola', 3, 3, 3, 3, 'luz pulsada', 'no tiene cola', 2, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pacientes`
--

CREATE TABLE `pacientes` (
  `id_paciente` int(6) NOT NULL,
  `nombre_paciente` varchar(50) NOT NULL,
  `apellido_p` varchar(40) NOT NULL,
  `apellido_m` varchar(40) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `sexo` char(1) NOT NULL,
  `telefono` varchar(10) NOT NULL,
  `ocupacion` varchar(400) DEFAULT NULL,
  `estado_civil` varchar(400) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pacientes`
--

INSERT INTO `pacientes` (`id_paciente`, `nombre_paciente`, `apellido_p`, `apellido_m`, `fecha_nacimiento`, `sexo`, `telefono`, `ocupacion`, `estado_civil`) VALUES
(1, 'Luis', 'Tah', 'Och', '2006-03-11', 'H', '9811777647', 'Estudiante', '            '),
(2, 'LuisANGEL', 'Tah', 'OchA', '2006-03-11', 'H', '9811777647', 'dfdf', '             sdsd   \r\n            ');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `doctor`
--
ALTER TABLE `doctor`
  ADD PRIMARY KEY (`id_doctor`);

--
-- Indices de la tabla `historias`
--
ALTER TABLE `historias`
  ADD PRIMARY KEY (`id_historia`),
  ADD KEY `id_paciente_fk` (`id_paciente`),
  ADD KEY `id_doctor` (`id_doctor`);

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
  MODIFY `id_historia` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  MODIFY `id_paciente` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `historias`
--
ALTER TABLE `historias`
  ADD CONSTRAINT `historias_ibfk_1` FOREIGN KEY (`id_paciente`) REFERENCES `pacientes` (`id_paciente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `id_doctor` FOREIGN KEY (`id_doctor`) REFERENCES `doctor` (`id_doctor`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
