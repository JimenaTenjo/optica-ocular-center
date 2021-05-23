-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 11-05-2021 a las 03:45:45
-- Versión del servidor: 5.7.24
-- Versión de PHP: 7.3.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `optica`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas`
--

CREATE TABLE `citas` (
  `idCita` int(10) UNSIGNED NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `estado` enum('Activo','Inactivo') NOT NULL,
  `motivo_consulta_id` int(10) UNSIGNED NOT NULL,
  `paciente_cita_id` int(10) UNSIGNED NOT NULL,
  `medico_cita_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `citas`
--

INSERT INTO `citas` (`idCita`, `fecha`, `hora`, `estado`, `motivo_consulta_id`, `paciente_cita_id`, `medico_cita_id`) VALUES
(1, '2021-04-06', '08:00:00', 'Activo', 1, 1, 1),
(2, '2021-05-01', '10:00:00', 'Activo', 1, 1, 1),
(3, '2021-05-01', '09:00:00', 'Inactivo', 1, 1, 1),
(4, '2021-05-01', '11:00:00', 'Activo', 1, 1, 1),
(5, '2021-05-01', '08:30:00', 'Inactivo', 1, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `examenes`
--

CREATE TABLE `examenes` (
  `idExamenes` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(120) NOT NULL,
  `descripcion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `examenes`
--

INSERT INTO `examenes` (`idExamenes`, `nombre`, `descripcion`) VALUES
(1, 'agudeza visual', 'agudeza visual '),
(2, 'examen externo', 'examen externo'),
(3, 'fondo de ojo', 'fondo de ojo'),
(4, 'motilidad ocular', 'motilidad ocular'),
(5, 'queratometria', 'queratometria'),
(6, 'refraccion', 'refraccion'),
(7, 'subjetivo', 'subjetivo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `examenes_historial`
--

CREATE TABLE `examenes_historial` (
  `IdExamenHistorial` int(10) UNSIGNED NOT NULL,
  `examen_id` int(10) UNSIGNED NOT NULL,
  `id_cita_examen` int(10) UNSIGNED NOT NULL,
  `valores` json NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `examenes_historial`
--

INSERT INTO `examenes_historial` (`IdExamenHistorial`, `examen_id`, `id_cita_examen`, `valores`) VALUES
(6, 1, 1, '[{\"name\": \"OD\", \"value\": \"sdasd\"}, {\"name\": \"OI\", \"value\": \"asd\"}, {\"name\": \"observaciones\", \"value\": \"sdadasd\"}]'),
(21, 2, 1, '[{\"name\": \"OD\", \"value\": \"asd\"}, {\"name\": \"OI\", \"value\": \"asd\"}]'),
(28, 1, 1, '[{\"name\": \"OD\", \"value\": \"AAA\"}, {\"name\": \"OI\", \"value\": \"AA\"}, {\"name\": \"observaciones\", \"value\": \"AAA\"}]'),
(38, 2, 5, '[{\"name\": \"OD\", \"value\": \"asd\"}, {\"name\": \"OI\", \"value\": \"sd\"}]');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formula_medica`
--

CREATE TABLE `formula_medica` (
  `idFormulamedica` int(10) UNSIGNED NOT NULL,
  `fecha` date NOT NULL,
  `descripcion` text NOT NULL,
  `prescripcion_formula_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial`
--

CREATE TABLE `historial` (
  `idHistorial` int(10) UNSIGNED NOT NULL,
  `codg_rips` varchar(200) NOT NULL,
  `conducta` varchar(200) NOT NULL,
  `control` varchar(200) NOT NULL,
  `citas_historial_id` int(10) UNSIGNED NOT NULL,
  `diagnostico` text NOT NULL,
  `anamnesis` enum('Alergias','Historial Familiar','Control Medico','Medicaciones','Ninguno') NOT NULL,
  `antecedentes` enum('Familiares','Miopia','Astigmatismo','Ninguno') NOT NULL,
  `prescripcion_historial_id` int(10) UNSIGNED DEFAULT NULL,
  `nombre_acudiente` varchar(45) DEFAULT NULL,
  `telefono_acudiente` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `historial`
--

INSERT INTO `historial` (`idHistorial`, `codg_rips`, `conducta`, `control`, `citas_historial_id`, `diagnostico`, `anamnesis`, `antecedentes`, `prescripcion_historial_id`, `nombre_acudiente`, `telefono_acudiente`) VALUES
(1, 'asd', 'asdasd', 'asdasd', 1, 'asdasd', 'Ninguno', 'Ninguno', NULL, 'jj', '320'),
(2, 'codigo rips', 'n/a', 'n/a', 5, 'n/a', 'Ninguno', 'Ninguno', NULL, 'jj', 'sad'),
(3, 'sdasd', 'asdasd', 'asdasd', 3, 'asd', 'Alergias', 'Familiares', NULL, 'asdasd', 'asdasd'),
(4, 'sdasd', 'asdasd', 'asdasd', 3, 'asd', 'Alergias', 'Familiares', NULL, 'asdasd', 'asdasd'),
(5, 'sdasd', 'asdasd', 'asdasd', 3, 'asd', 'Alergias', 'Familiares', NULL, 'asdasd', 'asdasd'),
(6, 'sdasd', 'asdasd', 'asdasd', 3, 'asd', 'Alergias', 'Familiares', NULL, 'asdasd', 'asdasd');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medico`
--

CREATE TABLE `medico` (
  `idMedico` int(11) NOT NULL,
  `especializacion` varchar(120) NOT NULL,
  `licencia` varchar(120) NOT NULL,
  `persona_medico` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `medico`
--

INSERT INTO `medico` (`idMedico`, `especializacion`, `licencia`, `persona_medico`) VALUES
(1, 'gastro', '10254c', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `motivos_consulta`
--

CREATE TABLE `motivos_consulta` (
  `idMotivoConsulta` int(10) UNSIGNED NOT NULL,
  `descripcion` text NOT NULL,
  `estado` enum('Activo','Inactivo') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `motivos_consulta`
--

INSERT INTO `motivos_consulta` (`idMotivoConsulta`, `descripcion`, `estado`) VALUES
(1, 'dolor fuerte', 'Activo'),
(2, '  Otro motivo', 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paciente`
--

CREATE TABLE `paciente` (
  `idPaciente` int(10) UNSIGNED NOT NULL,
  `ocupacion` varchar(80) NOT NULL,
  `estado_civil` enum('Soltero','Casado','Divorciado','Viudo') DEFAULT NULL,
  `tipo_afiliacion` enum('Contributivo','Beneficiario') NOT NULL,
  `tipo_vinculacion` varchar(80) NOT NULL,
  `fecha_ultima_cita` date DEFAULT NULL,
  `id_persona_paciente` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `paciente`
--

INSERT INTO `paciente` (`idPaciente`, `ocupacion`, `estado_civil`, `tipo_afiliacion`, `tipo_vinculacion`, `fecha_ultima_cita`, `id_persona_paciente`) VALUES
(1, 'programador', 'Soltero', 'Beneficiario', 'na', NULL, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE `persona` (
  `idPersona` int(10) UNSIGNED NOT NULL,
  `nombres` varchar(120) NOT NULL,
  `apellidos` varchar(120) NOT NULL,
  `numero_documento` varchar(15) NOT NULL,
  `tipo_documento` enum('TARJETA DE IDENTIDAD','CEDULA DE CIUDADANIA') NOT NULL,
  `ciudad` varchar(80) NOT NULL,
  `genero` varchar(45) NOT NULL,
  `email` varchar(120) DEFAULT NULL,
  `telefono` varchar(15) NOT NULL,
  `estado` enum('Activo','Inactivo') NOT NULL,
  `rol` enum('MEDICO','SECRETARIA','PACIENTE','ADMINISTRADOR') NOT NULL,
  `direccion` varchar(80) DEFAULT NULL,
  `fecha_nacimiento` date NOT NULL,
  `contrasena` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`idPersona`, `nombres`, `apellidos`, `numero_documento`, `tipo_documento`, `ciudad`, `genero`, `email`, `telefono`, `estado`, `rol`, `direccion`, `fecha_nacimiento`, `contrasena`) VALUES
(1, 'medico', 'uno', '1010', 'CEDULA DE CIUDADANIA', 'sog', 'MASCULINO', 'medico@gmail.com', '111111', 'Activo', 'MEDICO', 'direccion medico', '2021-04-06', '0000'),
(2, 'paciente', 'uno', '1111', 'CEDULA DE CIUDADANIA', 'sog', 'MASCULINO', 'paciente@gmail.com', '22222', 'Activo', 'PACIENTE', 'direccion paciente', '2021-04-06', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prescripcion_final`
--

CREATE TABLE `prescripcion_final` (
  `idPrescripcion_Final` int(10) UNSIGNED NOT NULL,
  `OI` varchar(45) NOT NULL,
  `OD` varchar(45) NOT NULL,
  `ADD_OD` varchar(45) DEFAULT NULL,
  `ADD_OI` varchar(45) DEFAULT NULL,
  `AV_VL_OD` varchar(45) DEFAULT NULL,
  `AV_VL_OI` varchar(45) DEFAULT NULL,
  `AV_VP_OD` varchar(45) DEFAULT NULL,
  `AV_VP_OI` varchar(45) DEFAULT NULL,
  `DNP_OD` varchar(45) DEFAULT NULL,
  `DNP_OI` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `citas`
--
ALTER TABLE `citas`
  ADD PRIMARY KEY (`idCita`),
  ADD UNIQUE KEY `idCitas_UNIQUE` (`idCita`),
  ADD KEY `fk_Citas_motivos_consulta1_idx` (`motivo_consulta_id`),
  ADD KEY `fk_Citas_paciente1_idx` (`paciente_cita_id`),
  ADD KEY `fk_Citas_Medico1_idx` (`medico_cita_id`);

--
-- Indices de la tabla `examenes`
--
ALTER TABLE `examenes`
  ADD PRIMARY KEY (`idExamenes`),
  ADD UNIQUE KEY `idExamenes_UNIQUE` (`idExamenes`);

--
-- Indices de la tabla `examenes_historial`
--
ALTER TABLE `examenes_historial`
  ADD PRIMARY KEY (`IdExamenHistorial`),
  ADD UNIQUE KEY `IdExamenhistorial_UNIQUE` (`IdExamenHistorial`),
  ADD KEY `fk_Examenes_Historial_Examenes1_idx` (`examen_id`),
  ADD KEY `fk_Examenes_Hitorial_Citas1_idx` (`id_cita_examen`) USING BTREE;

--
-- Indices de la tabla `formula_medica`
--
ALTER TABLE `formula_medica`
  ADD PRIMARY KEY (`idFormulamedica`),
  ADD UNIQUE KEY `idFormulamedica_UNIQUE` (`idFormulamedica`),
  ADD KEY `fk_formula_medica_Prescripcion1_idx` (`prescripcion_formula_id`);

--
-- Indices de la tabla `historial`
--
ALTER TABLE `historial`
  ADD PRIMARY KEY (`idHistorial`),
  ADD UNIQUE KEY `idHistorial_UNIQUE` (`idHistorial`),
  ADD KEY `fk_historial_Citas1_idx` (`citas_historial_id`),
  ADD KEY `fk_historial_Prescripcion1_idx` (`prescripcion_historial_id`);

--
-- Indices de la tabla `medico`
--
ALTER TABLE `medico`
  ADD PRIMARY KEY (`idMedico`),
  ADD UNIQUE KEY `idMedico_UNIQUE` (`idMedico`),
  ADD KEY `fk_Medico_persona1_idx` (`persona_medico`);

--
-- Indices de la tabla `motivos_consulta`
--
ALTER TABLE `motivos_consulta`
  ADD PRIMARY KEY (`idMotivoConsulta`),
  ADD UNIQUE KEY `idmotivos_consulta_UNIQUE` (`idMotivoConsulta`);

--
-- Indices de la tabla `paciente`
--
ALTER TABLE `paciente`
  ADD PRIMARY KEY (`idPaciente`),
  ADD UNIQUE KEY `idPaciente_UNIQUE` (`idPaciente`),
  ADD KEY `fk_paciente_persona1_idx` (`id_persona_paciente`);

--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`idPersona`),
  ADD UNIQUE KEY `numero_documento_UNIQUE` (`numero_documento`);

--
-- Indices de la tabla `prescripcion_final`
--
ALTER TABLE `prescripcion_final`
  ADD PRIMARY KEY (`idPrescripcion_Final`),
  ADD UNIQUE KEY `idPrescripcion_Final_UNIQUE` (`idPrescripcion_Final`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `citas`
--
ALTER TABLE `citas`
  MODIFY `idCita` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `examenes`
--
ALTER TABLE `examenes`
  MODIFY `idExamenes` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `examenes_historial`
--
ALTER TABLE `examenes_historial`
  MODIFY `IdExamenHistorial` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `formula_medica`
--
ALTER TABLE `formula_medica`
  MODIFY `idFormulamedica` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `historial`
--
ALTER TABLE `historial`
  MODIFY `idHistorial` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `medico`
--
ALTER TABLE `medico`
  MODIFY `idMedico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `motivos_consulta`
--
ALTER TABLE `motivos_consulta`
  MODIFY `idMotivoConsulta` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `paciente`
--
ALTER TABLE `paciente`
  MODIFY `idPaciente` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
  MODIFY `idPersona` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `prescripcion_final`
--
ALTER TABLE `prescripcion_final`
  MODIFY `idPrescripcion_Final` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `citas`
--
ALTER TABLE `citas`
  ADD CONSTRAINT `fk_Citas_Medico1` FOREIGN KEY (`medico_cita_id`) REFERENCES `medico` (`idMedico`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Citas_motivos_consulta1` FOREIGN KEY (`motivo_consulta_id`) REFERENCES `motivos_consulta` (`idMotivoConsulta`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Citas_paciente1` FOREIGN KEY (`paciente_cita_id`) REFERENCES `paciente` (`idPaciente`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `examenes_historial`
--
ALTER TABLE `examenes_historial`
  ADD CONSTRAINT `fk_Examenes_Historial_Examenes1` FOREIGN KEY (`examen_id`) REFERENCES `examenes` (`idExamenes`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Examenes_Hitorial_Citas1` FOREIGN KEY (`id_cita_examen`) REFERENCES `citas` (`idCita`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `formula_medica`
--
ALTER TABLE `formula_medica`
  ADD CONSTRAINT `fk_formula_medica_Prescripcion1` FOREIGN KEY (`prescripcion_formula_id`) REFERENCES `prescripcion_final` (`idPrescripcion_Final`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `historial`
--
ALTER TABLE `historial`
  ADD CONSTRAINT `fk_historial_Citas1` FOREIGN KEY (`citas_historial_id`) REFERENCES `citas` (`idCita`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_historial_Prescripcion1` FOREIGN KEY (`prescripcion_historial_id`) REFERENCES `prescripcion_final` (`idPrescripcion_Final`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `medico`
--
ALTER TABLE `medico`
  ADD CONSTRAINT `fk_Medico_persona1` FOREIGN KEY (`persona_medico`) REFERENCES `persona` (`idPersona`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `paciente`
--
ALTER TABLE `paciente`
  ADD CONSTRAINT `fk_paciente_persona1` FOREIGN KEY (`id_persona_paciente`) REFERENCES `persona` (`idPersona`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
