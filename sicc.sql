-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 08, 2019 at 06:07 PM
-- Server version: 5.6.15-log
-- PHP Version: 5.4.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sicc`
--

-- --------------------------------------------------------

--
-- Table structure for table `adm_archivos`
--

CREATE TABLE IF NOT EXISTS `adm_archivos` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `idcata` int(3) NOT NULL,
  `idcatb` int(3) NOT NULL,
  `modulo` varchar(150) NOT NULL,
  `tabla` varchar(100) NOT NULL,
  `ruta` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `adm_archivos`
--

INSERT INTO `adm_archivos` (`id`, `idcata`, `idcatb`, `modulo`, `tabla`, `ruta`) VALUES
(15, 0, 0, 'clientes', 'arc_clientes', 'rec/arccliente');

-- --------------------------------------------------------

--
-- Table structure for table `adm_config`
--

CREATE TABLE IF NOT EXISTS `adm_config` (
  `id` tinyint(2) NOT NULL AUTO_INCREMENT,
  `idempresa` int(5) NOT NULL,
  `empresa` varchar(250) NOT NULL,
  `empresacomercial` varchar(250) NOT NULL,
  `rfcempresa` varchar(25) NOT NULL,
  `representantelegal` varchar(250) NOT NULL,
  `escritura` longtext NOT NULL,
  `escdenominacion` longtext NOT NULL,
  `escescritura` varchar(200) NOT NULL,
  `escfecha` varchar(200) NOT NULL,
  `escnotario` varchar(200) NOT NULL,
  `escnotarionum` varchar(200) NOT NULL,
  `escinscripcion` varchar(200) NOT NULL,
  `escinscripcionnum` varchar(200) NOT NULL,
  `escinscripcionfecha` varchar(200) NOT NULL,
  `desccorta` varchar(50) NOT NULL,
  `registropatronal` varchar(150) NOT NULL,
  `regimen` varchar(150) NOT NULL,
  `dirempresa` longtext NOT NULL,
  `calle` varchar(250) NOT NULL,
  `numero` varchar(150) NOT NULL,
  `numeroint` varchar(150) NOT NULL,
  `colonia` varchar(250) NOT NULL,
  `localidad` varchar(200) NOT NULL,
  `municipio` varchar(250) NOT NULL,
  `estado` varchar(50) NOT NULL,
  `cp` varchar(10) NOT NULL,
  `pais` varchar(100) NOT NULL,
  `telefonos` longtext NOT NULL,
  `correos` longtext NOT NULL,
  `imgmain` varchar(250) NOT NULL,
  `imgicono` varchar(250) NOT NULL,
  `vidamax` int(3) NOT NULL DEFAULT '0',
  `tasadefault` int(5) NOT NULL DEFAULT '0',
  `periodicidaddefault` int(5) NOT NULL DEFAULT '0',
  `iva` float NOT NULL DEFAULT '0',
  `numproauto` tinyint(2) NOT NULL,
  `ctaproveedores` int(5) NOT NULL,
  `contratomutuos` varchar(250) NOT NULL,
  `correoadmin` varchar(100) NOT NULL,
  `ultactusu` varchar(25) NOT NULL,
  `ultactfec` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `adm_config`
--

INSERT INTO `adm_config` (`id`, `idempresa`, `empresa`, `empresacomercial`, `rfcempresa`, `representantelegal`, `escritura`, `escdenominacion`, `escescritura`, `escfecha`, `escnotario`, `escnotarionum`, `escinscripcion`, `escinscripcionnum`, `escinscripcionfecha`, `desccorta`, `registropatronal`, `regimen`, `dirempresa`, `calle`, `numero`, `numeroint`, `colonia`, `localidad`, `municipio`, `estado`, `cp`, `pais`, `telefonos`, `correos`, `imgmain`, `imgicono`, `vidamax`, `tasadefault`, `periodicidaddefault`, `iva`, `numproauto`, `ctaproveedores`, `contratomutuos`, `correoadmin`, `ultactusu`, `ultactfec`) VALUES
(1, 2, 'Transcomunicador Mexiquense, SA de CV', 'Transcomunicador Mexiquense SA de CV', 'TME1102179U1', 'Licenciado Rafael Sánchez Osornio', '', 'Sociedad Mexicana', 'Cuatro mil ochocientos', '27 de Enero de 2011', 'Licenciado Jaime Vázquez Castillo', '164', 'Registro Público de Ecatepec Estado de México', '8381-3', '02 de Marzo de 2011', 'Transcomunicador', '', 'Coordinados', ', , , , Estado de Mexico, C.P. 55076', 'Avenida Central, Esquina Calle Veracruz', 'Manzana 1, Lote 1, Sin Numero', '', 'Colonia Las Américas', '', 'Municipio de Ecatepec de Morelos', 'Estado de México', '55076', 'México', '', '', '', 'ea9dcb2d7bfe83d065573f990f68f48d_logo.jpeg', 3600, 1, 1, 16, 1, 72, '../rec/f_contratomutuo01.php', 'info@transcomunciador.com.mx', 'avalle', '2018-09-27 17:47:56');

-- --------------------------------------------------------

--
-- Table structure for table `adm_documentos`
--

CREATE TABLE IF NOT EXISTS `adm_documentos` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `idcata` int(3) NOT NULL,
  `idcatb` int(3) NOT NULL,
  `identificador` varchar(100) NOT NULL DEFAULT '',
  `descripcion` longtext NOT NULL,
  `tipo` int(3) NOT NULL,
  `archivo` longtext NOT NULL,
  `status` tinyint(3) NOT NULL DEFAULT '0',
  `ultactfec` varchar(25) NOT NULL DEFAULT '',
  `ultactusu` varchar(25) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

--
-- Dumping data for table `adm_documentos`
--

INSERT INTO `adm_documentos` (`id`, `idcata`, `idcatb`, `identificador`, `descripcion`, `tipo`, `archivo`, `status`, `ultactfec`, `ultactusu`) VALUES
(1, 1, 4, 'concaratula', 'Impresión de carátula', 0, '../rec9/f_caratula_pdf.php', 1, '2016-02-04 17:27:41', 'avalle'),
(2, 1, 4, 'congeneral', 'Contrato General', 0, '../rec9/f_contratogral_pdf.php', 0, '2014-12-16 12:24:21', 'avalle'),
(3, 1, 4, 'conmutuo', 'Contrato Mutuo', 0, '../rec9/f_contratomutuo_pdf.php', 1, '2015-11-17 12:28:42', 'avalle'),
(4, 1, 4, 'conprenda', 'Entrega de Prenda', 0, '../rec/f_prenda_pdf.php', 0, '2014-12-16 12:26:53', 'avalle'),
(5, 1, 4, 'conpagare', 'Pagaré', 0, '../rec9/f_pagare_pdf.php', 1, '2016-07-18 14:11:45', 'avalle'),
(6, 1, 4, 'clienteformato1', 'Acuse', 1, '../rec/arcformatos/f_acuse01.php', 1, '2014-12-16 12:28:24', 'avalle'),
(7, 1, 4, 'clienteformato2', 'Crédito de línea IV sin garantía', 1, '../rec/arcformatos/f_solicitud01.php', 1, '2016-05-21 12:49:46', 'avalle'),
(8, 55, 56, 'clienteformato3', 'Contrato de Obra (Vitta)', 2, '../rec/arcformatos/f_contratodobravitta01.php', 1, '2016-05-21 12:06:17', 'avalle'),
(9, 55, 56, 'operacontrato6', 'Carta Patronal al IMSS', 2, '../rec9/f_carta_patronal_imss.php', 1, '2016-05-21 11:51:14', 'avalle'),
(10, 55, 56, 'operacontrato7', 'Solicitud de Pago Bancario', 2, '../rec9/f_carta_solicitud_pago_bancario.php', 1, '2016-05-21 12:48:00', 'avalle'),
(11, 55, 56, 'operacontrato4', 'Contrato Indeterminado Operadores', 5, '../rec9/f_contrato_indeterminado_operadorestm.php', 1, '2016-05-21 12:35:10', 'avalle'),
(12, 55, 56, 'operacontrato5', 'Renuncia Contrato Indeterminado', 6, '../rec9/f_terminacion_contrato_indeterminado.php', 1, '2016-05-21 12:42:16', 'avalle'),
(13, 55, 56, 'operacontrato8', 'Carta Sindicato', 3, '../rec9/f_carta_sindicato.php', 1, '2016-05-21 11:58:59', 'avalle'),
(14, 55, 56, 'operacontrato44', 'Contrato Indeterminado Admin Out', 5, '../rec9/f_contrato_indeterminado_administrativo.php', 1, '2016-05-21 12:28:53', 'avalle'),
(15, 55, 56, 'operacontrato45', 'Contrato Indeterminado Diesel', 5, '../rec9/f_contrato_indeterminado_diesel.php', 1, '2016-05-21 12:35:19', 'avalle'),
(16, 55, 56, 'operacontrato46', 'Contrato Indeterminado Seguridad', 5, '../rec9/f_contrato_indeterminado_seguridad.php', 1, '2016-05-21 12:35:27', 'avalle'),
(17, 55, 56, 'operacontrato55', 'Renuncia de No Adeudo', 6, '../rec9/f_renuncia_no_adeudo.php', 1, '2016-05-21 12:44:44', 'avalle'),
(18, 55, 56, 'operacontrato9', 'Contrato Determinado Operador', 1, '../rec9/f_contrato_determinado_operador.php', 1, '2016-05-22 02:45:25', 'avalle'),
(19, 55, 56, 'operacontrato10', 'Contrato Determinado Administrativo', 9, '../rec9/f_contrato_determinado_administrativo.php', 1, '2016-05-31 16:58:10', 'avalle'),
(20, 55, 56, 'operacontrato11', 'Contrato Determinado Seguridad', 9, '../rec9/f_contrato_determinado_seguridad.php', 1, '2016-06-22 09:44:02', 'avalle'),
(21, 55, 56, 'operacontrato12', 'Contrato Determinado Limpieza Autobús', 9, '../rec9/arcformatos/f_contrato_determinado_limpieza.php', 1, '2018-05-14 17:25:46', 'avalle'),
(22, 1, 4, 'conpagareaval', 'Pagaré con Aval', 0, '../rec9/f_pagareaval_pdf.php', 1, '2016-07-18 14:13:34', 'avalle'),
(23, 35, 37, 'plantillacfdi', 'Plantilla de CFDI', 0, '../rec9/arcformatos/f_creapdf33.php', 1, '2018-12-18 13:26:14', 'avalle'),
(24, 1, 2, 'contratoscaratula', 'Impresión de carátula', 0, '../rec9/arcformatos/f_caratula_pdf.php', 1, '2018-03-06 17:36:48', 'avalle'),
(25, 1, 2, 'contratostablaamor', 'Tabla de Amortización', 0, '../rec9/arcformatos/f_conprestamob_pdf.php', 1, '2018-03-06 16:59:05', 'avalle'),
(26, 1, 2, 'contratosgeneral', 'Contrato General', 0, '../rec9/arcformatos/f_contratogral_pdf.php', 1, '2018-03-06 17:50:24', 'avalle'),
(27, 1, 2, 'contratosmutuo', 'Contrato Mutuo', 10, '../rec9/arcformatos/f_contratomutuo_pdf.php', 1, '2018-03-06 17:56:46', 'avalle'),
(28, 1, 2, 'contratosprenda', 'Entrega de Prenda', 0, '../rec9/arcformatos/f_prenda_pdf.php', 1, '2016-11-22 11:42:11', 'avalle'),
(29, 1, 2, 'contratospagare', 'Pagaré', 0, '../rec9/arcformatos/f_pagare_pdf.php', 1, '2016-11-22 11:42:19', 'avalle'),
(30, 1, 2, 'contratospagareaval', 'Pagaré con Aval', 0, '../rec9/arcformatos/f_pagareaval_pdf.php', 1, '2016-11-22 11:42:31', 'avalle'),
(31, 1, 2, 'contratospagareseguro', 'Pagaré Seguro', 0, '../rec9/arcformatos/f_pagare_seguro_pdf.php', 1, '2016-11-22 11:42:42', 'avalle'),
(32, 55, 56, 'operacontrato13', 'Contrato Indeterminado Limpieza Autobús', 9, '../rec9/arcformatos/f_contrato_indeterminado_limpieza.php', 1, '2018-05-14 17:26:10', 'avalle'),
(33, 35, 37, 'plantillapagocfdi', 'Plantilla para complemento de pago CFDI', 0, '../rec9/arcformatos/f_creapdfpago33.php', 1, '2018-12-18 13:26:48', 'avalle');

-- --------------------------------------------------------

--
-- Table structure for table `adm_empresas`
--

CREATE TABLE IF NOT EXISTS `adm_empresas` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `orden` int(3) NOT NULL,
  `base` varchar(100) NOT NULL DEFAULT '',
  `razon` varchar(250) NOT NULL,
  `logo` varchar(100) NOT NULL,
  `vidamax` int(3) NOT NULL,
  `licvigencia` date NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '0',
  `ultactfec` varchar(25) NOT NULL DEFAULT '',
  `ultactusu` varchar(25) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=39 ;

--
-- Dumping data for table `adm_empresas`
--

INSERT INTO `adm_empresas` (`id`, `orden`, `base`, `razon`, `logo`, `vidamax`, `licvigencia`, `status`, `ultactfec`, `ultactusu`) VALUES
(1, 2, 'sicc', 'Centro de Expertos', 'Logo_CEIDE.png', 0, '0000-00-00', 1, '2018-10-05 05:26:23', 'avalle');

-- --------------------------------------------------------

--
-- Table structure for table `adm_modcatego`
--

CREATE TABLE IF NOT EXISTS `adm_modcatego` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `idpadre` int(6) NOT NULL,
  `nivel` tinyint(4) NOT NULL,
  `descripcion` varchar(200) NOT NULL DEFAULT '',
  `status` tinyint(2) NOT NULL DEFAULT '0',
  `ultactfec` varchar(25) NOT NULL DEFAULT '',
  `ultactusu` varchar(25) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=112 ;

--
-- Dumping data for table `adm_modcatego`
--

INSERT INTO `adm_modcatego` (`id`, `idpadre`, `nivel`, `descripcion`, `status`, `ultactfec`, `ultactusu`) VALUES
(1, 0, 1, 'Contratos', 1, '2017-04-01 08:27:25', 'avalle'),
(2, 1, 2, 'General', 1, '2012-12-30 08:33:08', 'avalle'),
(3, 1, 2, 'Bienes Prendarios', 1, '2012-12-30 08:33:34', 'avalle'),
(4, 1, 2, 'Administración', 1, '2012-12-30 08:33:45', 'avalle'),
(5, 0, 1, 'Tesorería', 1, '2012-12-30 08:37:35', 'avalle'),
(6, 5, 2, 'Administración', 1, '2012-12-30 08:34:56', 'avalle'),
(7, 5, 2, 'General', 1, '2012-12-30 08:35:23', 'avalle'),
(8, 5, 2, 'Cobranza', 1, '2012-12-30 08:35:32', 'avalle'),
(9, 5, 2, 'Cerrar Periodos', 1, '2012-12-30 08:35:59', 'avalle'),
(10, 5, 2, 'Estados de Cuenta', 1, '2012-12-30 08:36:11', 'avalle'),
(11, 5, 2, 'Depósitos Extraordinarios', 1, '2012-12-30 08:36:32', 'avalle'),
(12, 5, 2, 'Catálogos', 1, '2012-12-30 08:36:46', 'avalle'),
(13, 5, 2, 'Transacciones', 1, '2012-12-30 08:36:57', 'avalle'),
(14, 5, 2, 'Fechas de Corte', 1, '2012-12-30 08:37:10', 'avalle'),
(15, 0, 1, 'Pólizas Seguro', 1, '2012-12-30 08:39:48', 'avalle'),
(16, 15, 2, 'Catálogos', 1, '2012-12-30 08:38:19', 'avalle'),
(17, 15, 2, 'Vendedores', 1, '2012-12-30 08:38:43', 'avalle'),
(18, 15, 2, 'General', 1, '2012-12-30 08:38:56', 'avalle'),
(19, 15, 2, 'Agentes de Venta', 1, '2012-12-30 08:39:24', 'avalle'),
(20, 0, 1, 'Mutuo', 1, '2012-12-30 08:41:50', 'avalle'),
(21, 20, 2, 'General', 1, '2012-12-30 08:41:02', 'avalle'),
(22, 0, 1, 'Administración', 1, '2012-12-30 08:42:00', 'avalle'),
(23, 22, 2, 'Comportamiento', 1, '2012-12-30 08:42:47', 'avalle'),
(24, 22, 2, 'Usuarios', 1, '2012-12-30 08:42:58', 'avalle'),
(25, 22, 2, 'Módulos', 1, '2012-12-30 08:43:05', 'avalle'),
(26, 0, 1, 'Contabilidad', 1, '2012-12-30 09:04:07', 'avalle'),
(27, 26, 2, 'Tesorería', 1, '2012-12-30 09:04:15', 'avalle'),
(28, 26, 2, 'Administración', 1, '2012-12-30 09:05:00', 'avalle'),
(29, 26, 2, 'Contabilidad Empresa', 1, '2012-12-30 09:05:05', 'avalle'),
(30, 0, 1, 'Catálogo', 1, '2015-01-13 17:30:17', 'avalle'),
(31, 30, 2, 'Clientes', 1, '2012-12-30 09:08:21', 'avalle'),
(32, 30, 2, 'Proveedores', 1, '2012-12-30 09:08:30', 'avalle'),
(33, 30, 2, 'Pólizas Automáticas', 1, '2012-12-30 09:14:07', 'avalle'),
(34, 30, 2, 'Personal Administrativo', 1, '2013-06-25 17:08:50', 'avalle'),
(35, 0, 1, 'Comercial', 1, '2013-12-01 09:28:57', 'avalle'),
(36, 35, 2, 'Catálogos', 1, '2013-12-01 09:29:32', 'avalle'),
(37, 35, 2, 'Facturacion', 1, '2014-01-18 10:01:22', 'avalle'),
(38, 0, 1, 'Contabilidad Personas', 1, '2014-02-17 17:37:35', 'avalle'),
(39, 38, 2, 'General', 1, '2014-02-17 17:37:51', 'avalle'),
(41, 35, 2, 'Archivos', 1, '2014-05-24 11:48:34', 'avalle'),
(42, 26, 2, 'Archivos', 1, '2014-05-24 11:49:04', 'avalle'),
(43, 39, 2, 'Archivos', 1, '2014-05-24 11:49:17', 'avalle'),
(44, 1, 2, 'Archivos', 1, '2014-05-24 11:49:33', 'avalle'),
(45, 15, 2, 'Archivos', 1, '2014-05-24 11:49:47', 'avalle'),
(46, 5, 2, 'Archivos', 1, '2014-05-24 11:50:01', 'avalle'),
(47, 38, 2, 'Acceso Directo', 1, '2014-07-04 15:00:49', 'avalle'),
(48, 38, 2, 'Administración', 1, '2014-07-04 15:00:59', 'avalle'),
(49, 30, 2, 'Contribuyentes', 1, '2014-07-21 09:35:34', 'avalle'),
(50, 35, 2, 'Cotización', 1, '2014-09-16 16:58:48', 'avalle'),
(51, 35, 2, 'Ventas', 1, '2014-12-18 22:15:15', 'avalle'),
(52, 0, 1, 'Unidades', 1, '2015-01-06 16:40:29', 'avalle'),
(53, 52, 2, 'Catálogo Siniestros', 1, '2015-01-27 15:42:46', 'avalle'),
(54, 52, 2, 'Catálogo', 1, '2015-01-06 16:40:42', 'avalle'),
(55, 0, 1, 'Capital Humano', 1, '2015-01-07 12:41:07', 'avalle'),
(56, 55, 2, 'Personal', 1, '2015-01-07 12:41:52', 'avalle'),
(57, 55, 2, 'Catálogo', 1, '2015-01-07 12:41:58', 'avalle'),
(58, 55, 2, 'Administrar', 1, '2015-01-08 17:07:04', 'avalle'),
(59, 30, 2, 'Cursos', 1, '2015-01-13 17:30:25', 'avalle'),
(60, 52, 2, 'Operación', 1, '2015-01-22 12:10:11', 'avalle'),
(61, 52, 2, 'Siniestros', 1, '2015-01-27 15:42:51', 'avalle'),
(62, 52, 2, 'Administración', 1, '2015-02-03 09:51:11', 'avalle'),
(63, 0, 1, 'AppDirect', 1, '2015-02-12 17:15:22', 'avalle'),
(64, 63, 2, 'Bitácora', 1, '2015-02-12 17:15:34', 'avalle'),
(65, 63, 2, 'Aplicaciones', 1, '2015-02-21 14:29:32', 'avalle'),
(66, 52, 2, 'Reportes', 1, '2015-03-07 09:57:46', 'avalle'),
(67, 30, 2, 'Organigrama', 1, '2015-03-10 11:17:24', 'avalle'),
(68, 52, 2, 'Mantenimiento', 1, '2015-05-14 15:35:27', 'avalle'),
(69, 52, 2, 'Unidades', 1, '2015-09-03 13:28:46', 'avalle'),
(70, 0, 1, 'Herramientas', 1, '2015-09-22 11:53:21', 'avalle'),
(71, 70, 2, 'Correspondencia', 1, '2015-09-22 11:53:21', 'avalle'),
(72, 52, 2, 'Neumáticos', 1, '2015-10-10 07:58:36', 'avalle'),
(73, 35, 2, 'Inventario', 1, '2016-03-15 13:02:40', 'avalle'),
(74, 70, 2, 'Asistencias', 1, '2016-03-28 13:59:35', 'avalle'),
(75, 70, 2, 'Alimentos', 1, '2016-03-28 13:59:43', 'avalle'),
(76, 35, 2, 'Reportes', 1, '2016-04-15 17:33:10', 'avalle'),
(77, 35, 2, 'Ordenes', 1, '2016-04-18 11:16:42', 'avalle'),
(78, 70, 2, 'Incapacidades', 1, '2016-05-06 17:50:22', 'avalle'),
(79, 35, 2, 'Entradas', 1, '2016-05-30 22:05:44', 'avalle'),
(80, 52, 2, 'Incidencias', 1, '2016-10-11 18:22:58', 'avalle'),
(81, 52, 2, 'Datos', 1, '2016-12-15 11:58:40', 'avalle'),
(82, 52, 2, 'Archivos', 1, '2016-12-22 01:05:22', 'avalle'),
(83, 30, 2, 'General', 1, '2016-12-29 14:55:48', 'avalle'),
(84, 70, 2, 'Actividades', 1, '2017-01-19 16:00:07', 'avalle'),
(85, 0, 1, 'Tarjeta', 1, '2017-01-23 08:55:58', 'avalle'),
(86, 85, 2, 'Administración', 1, '2017-01-23 08:56:06', 'avalle'),
(87, 85, 2, 'Avisos', 1, '2017-01-23 08:56:21', 'avalle'),
(88, 85, 2, 'General', 1, '2017-01-23 08:56:25', 'avalle'),
(89, 85, 2, 'Solicitudes', 1, '2017-01-23 08:56:29', 'avalle'),
(90, 63, 2, 'Bahías', 1, '2017-02-23 02:03:46', 'avalle'),
(91, 1, 2, 'Solicitudes', 1, '2017-03-23 13:47:35', 'avalle'),
(92, 52, 2, 'Viajes Foraneos', 1, '2017-05-05 10:28:45', 'a.lopez'),
(93, 52, 2, 'Campañas', 1, '2017-06-13 15:59:46', 'a.lopez'),
(94, 35, 2, 'Traspasos', 1, '2017-07-20 11:40:06', 'avalle'),
(95, 70, 2, 'Encuestas', 1, '2017-10-06 11:21:02', 'a.lopez'),
(96, 70, 2, 'Vacaciones', 1, '2017-10-06 13:55:59', 'avalle'),
(97, 30, 2, 'Encuestas', 1, '2017-10-06 13:56:19', 'avalle'),
(99, 63, 2, 'Dev', 1, '2017-10-21 10:58:16', 'avalle'),
(100, 0, 1, 'Control Vehicular', 1, '2018-01-05 16:49:25', 'avalle'),
(101, 100, 2, 'Concesiones', 1, '2018-01-05 16:49:46', 'avalle'),
(102, 100, 2, 'Catalogos', 1, '2018-01-05 17:28:08', 'avalle'),
(103, 100, 2, 'Administración', 1, '2018-01-05 17:28:16', 'avalle'),
(104, 100, 0, 'Socios', 1, '2018-02-01 13:27:10', 'a.lopez'),
(105, 100, 0, 'Arrendatarios', 1, '2018-02-01 13:28:22', 'a.lopez'),
(106, 100, 0, 'Operadores', 1, '2018-02-01 16:22:07', 'a.lopez'),
(107, 100, 2, 'Tenencias', 1, '2018-03-15 09:18:32', 'avalle'),
(108, 100, 2, 'Verificaciones', 1, '2018-03-15 09:18:44', 'avalle'),
(109, 35, 2, 'Ventas Restaurante', 1, '2018-06-12 09:17:15', 'avalle'),
(110, 100, 2, 'Servicio Grua', 1, '2018-08-14 15:54:43', 'avalle'),
(111, 100, 2, 'Operación', 1, '2018-08-24 18:56:01', 'avalle');

-- --------------------------------------------------------

--
-- Table structure for table `adm_modulos`
--

CREATE TABLE IF NOT EXISTS `adm_modulos` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `idcata` int(3) NOT NULL,
  `idcatb` int(3) NOT NULL,
  `orden` int(2) NOT NULL DEFAULT '0',
  `tipo` tinyint(2) NOT NULL DEFAULT '0',
  `grupo` longtext NOT NULL,
  `nombre` varchar(100) NOT NULL DEFAULT '',
  `tabla` varchar(50) NOT NULL DEFAULT '',
  `tablaimg` varchar(50) NOT NULL DEFAULT '',
  `dirimg` varchar(50) NOT NULL DEFAULT '',
  `dirimgtotal` varchar(250) NOT NULL DEFAULT '',
  `fotoimg` tinyint(1) NOT NULL DEFAULT '0',
  `prefijoimg` tinyint(2) NOT NULL DEFAULT '0',
  `modulo` varchar(50) NOT NULL DEFAULT '',
  `extra` varchar(200) NOT NULL DEFAULT '',
  `acceso` varchar(50) NOT NULL DEFAULT '',
  `recurso` varchar(100) NOT NULL DEFAULT '',
  `descripcion` longtext NOT NULL,
  `maxniveles` tinyint(2) NOT NULL DEFAULT '0',
  `niveles` longtext NOT NULL,
  `status` tinyint(3) NOT NULL DEFAULT '0',
  `ultactfec` varchar(25) NOT NULL DEFAULT '',
  `ultactusu` varchar(25) NOT NULL DEFAULT '',
  `scan` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=454 ;

--
-- Dumping data for table `adm_modulos`
--

INSERT INTO `adm_modulos` (`id`, `idcata`, `idcatb`, `orden`, `tipo`, `grupo`, `nombre`, `tabla`, `tablaimg`, `dirimg`, `dirimgtotal`, `fotoimg`, `prefijoimg`, `modulo`, `extra`, `acceso`, `recurso`, `descripcion`, `maxniveles`, `niveles`, `status`, `ultactfec`, `ultactusu`, `scan`) VALUES
(20, 22, 24, 420, 0, 'ADMINISTRACIÓN', 'Administración de Usuarios', '', '', '', '', 0, 0, 'AdminUsuarios', '', '', '', 'Permiso para acceder al portal de Usuarios y realizar cambios', 4, '<p><strong>Nivel 1:</strong> Consulta de usuarios<br />\r\n<strong>Nivel 2:</strong> Modificar Permisos<br />\r\n<strong>Nivel 3:</strong> Crear y Editar Usuarios<br />\r\n<strong>Nivel 4:</strong> Borrar Usuarios&nbsp;</p>', 1, '2013-11-30 09:00:37', 'avalle', 0),
(100, 22, 24, 0, 0, '', 'Cambiar Contraseña Individual', '', '', '', '', 0, 0, 'AdminUsuarioContrasena', '', '', '', 'Permite cambiar la contraseña', 1, '<strong>Nivel 1:</strong> Requerido', 1, '2013-11-30 09:19:04', 'avalle', 0),
(39, 26, 29, 260, 0, 'CONTABILIDAD / Contabilidad Empresa', 'Pólizas de Cheque', '', '', '', '', 0, 0, 'AdminPolizaCont', '', '38ae5e787418ce115e8c2460770c293f', '', 'Permite generar Pólizas de Cheque', 5, '\r\n<strong>Nivel 1: </strong>Acceso y Consulta<br />\r\n<strong>Nivel 2: </strong>Captura y Edición de Pólizas y Archivos<br />\r\n<strong>Nivel 3:</strong> Borrado de Archivos<br />\r\n<strong>Nivel 5: </strong>Permite el borrado de Pólizas y Archivos<br />\r\n', 1, '2015-10-20 09:25:43', 'avalle', 0),
(40, 26, 29, 270, 0, 'CONTABILIDAD / Contabilidad Empresa', 'Personas que Elaboran pólizas', '', '', '', '', 0, 0, 'AdminPolizaContElaboran', '', '38ae5e787418ce115e8c2460770c293f', '', 'Personal con este permiso, aparece en la captura de Pólizas como personal que elabora', 1, '<strong>Nivel 1: </strong>Requerido<br />', 1, '2013-01-12 09:37:32', 'avalle', 0),
(41, 26, 29, 280, 0, 'CONTABILIDAD / Contabilidad Empresa', 'Personas que Revisan pólizas', '', '', '', '', 0, 0, 'AdminPolizaContRevisan', '', '38ae5e787418ce115e8c2460770c293f', '', 'Personal con este permiso, aparece en la captura de Pólizas como personal que revisa polizas', 1, '<strong>Nivel 1: </strong>Requerido<br />', 1, '2013-01-12 09:37:48', 'avalle', 0),
(42, 26, 29, 290, 0, 'CONTABILIDAD / Contabilidad Empresa', 'Personas que Autoriza', '', '', '', '', 0, 0, 'AdminPolizaContAutorizan', '', '38ae5e787418ce115e8c2460770c293f', '', 'Personal con este permiso, aparece en la captura de Pólizas como personal que autorizan polizas', 1, '<strong>Nivel 1: </strong>Requerido<br />', 1, '2013-01-12 09:37:04', 'avalle', 0),
(45, 26, 27, 350, 0, 'CONTABILIDAD / Tesoreria', 'Administración de Bancos', '', '', '', '', 0, 0, 'AdminFinanzasBancos', '', '38ae5e787418ce115e8c2460770c293f', '', 'Personal con este permiso, podrá administrar los bancos, cuentas y formatos de impresión', 5, '<strong>Nivel 1: </strong>Requerido para el acceso<br />\r\n<strong>Nivel 2: </strong>Puede agregar, y editar<br />\r\n<strong>Nivel 5: </strong>Puede Borrar<br />', 1, '2013-01-12 09:28:08', 'avalle', 0),
(58, 26, 29, 1100, 0, 'CONTABILIDAD / Contabilidad Empresa', 'Administrar Subdivision', '', '', '', '', 0, 0, 'AdminFinanzasSubcuenta', '', '38ae5e787418ce115e8c2460770c293f', '', 'Permite editar las Subdivisiones o Categorias de las polizas de egresos.', 1, '<strong>Nivel 1: </strong>Requerido<br />', 1, '2013-01-12 09:30:40', 'avalle', 1),
(61, 26, 28, 1300, 0, 'CONTABILIDAD / Administracion', 'Catalogo Cuentas Contables', '', '', '', '', 0, 0, 'AdminFinanzasCC', '', '38ae5e787418ce115e8c2460770c293f', '', 'Permite Administrar el Catálogo de las Cuentas Contables utilizadas en las pólizas', 1, '\r\n<strong>Nivel 1: </strong>Requerido para ingreso<br />\r\n', 0, '2016-08-11 17:59:57', 'avalle', 1),
(62, 26, 29, 1100, 0, 'CONTABILIDAD / Contabilidad Empresa', 'Reporte Egresos', '', '', '', '', 0, 0, 'AdminPresuReporteEgresos', '', '38ae5e787418ce115e8c2460770c293f', '', 'Permite consultar el reporte de Egresos', 1, '<strong>Nivel 1: </strong>Requerido<br />', 1, '2013-01-12 09:38:35', 'avalle', 1),
(63, 1, 2, 1, 0, 'CRÉDITO / General', 'Consulta y Creación de Créditos', '', '', '', '', 0, 0, 'AdminCreditos', '', '38ae5e787418ce115e8c2460770c293f', '', 'Permite consultar Créditos, Crear, Borra y Cotización Express', 5, '<strong>Nivel 1: </strong>Consulta de Créditos<br />\r\n<strong>Nivel 2: </strong>Crear Nuevos Créditos y Editar los existentes<br />\r\n<strong>Nivel 3: </strong>Impresión de Documentos<br />\r\n<strong>Nivel 4: </strong>Puede Reabrir Créditos Activos<br />\r\n<strong>Nivel 5: </strong>Borrar Créditos<br />', 1, '2013-01-12 09:33:45', 'avalle', 1),
(64, 30, 31, 3, 0, 'CATÁLOGOS / Clientes', 'Consulta Clientes', '', '', '', '', 0, 0, 'AdminClientes', '', '38ae5e787418ce115e8c2460770c293f', '', 'Permite consultar, editar y crear Clientes', 5, '<strong>Nivel 1: </strong>Consulta de Clientes<br />\r\n<strong>Nivel 2: </strong>Editar Clientes<br />\r\n<strong>Nivel 3: </strong>Crear Nuevos<br />\r\n<strong>Nivel 5: </strong>Borrar Clientes<br />', 1, '2013-01-12 09:32:55', 'avalle', 1),
(65, 1, 4, 2, 0, 'CRÉDITO / Administración', 'Tablas de Amortización', '', '', '', '', 0, 0, 'AdminCreditosAdmin', '', '38ae5e787418ce115e8c2460770c293f', '', 'Permite realizar Cambios en las tablas de Amortización', 2, '<strong>Nivel 1: </strong>Permite Editar Tabla de Amortización<br />\r\n<strong>Nivel 2: </strong>Permite Editar Tablas Tipo<br />', 1, '2013-01-12 09:38:51', 'avalle', 1),
(66, 1, 4, 10, 0, 'CRÉDITO / Administración', 'Documentos Contrato', '', '', '', '', 0, 0, 'AdminDocsContratos', '', '38ae5e787418ce115e8c2460770c293f', '', 'Permite realizar Cambios en Contratos', 3, '<strong>Nivel 1: </strong>Consulta<br />\r\n<strong>Nivel 2: </strong>Editar y Crear<br />\r\n<strong>Nivel 3: </strong>Borrado<br />', 1, '2013-01-12 09:34:13', 'avalle', 1),
(67, 1, 4, 11, 0, 'CRÉDITO / Administración', 'Documentos Pagaré', '', '', '', '', 0, 0, 'AdminDocsPagares', '', '38ae5e787418ce115e8c2460770c293f', '', 'Permite realizar Cambios en Pagares', 3, '<strong>Nivel 1: </strong>Consulta<br />\r\n<strong>Nivel 2: </strong>Editar y Crear<br />\r\n<strong>Nivel 3: </strong>Borrado<br />', 1, '2013-01-12 09:34:29', 'avalle', 1),
(68, 1, 4, 12, 0, 'CRÉDITO / Administración', 'Documentos Prendarios', '', '', '', '', 0, 0, 'AdminDocsPrendarios', '', '38ae5e787418ce115e8c2460770c293f', '', 'Permite realizar Cambios en Contratos Prendarios', 3, '<strong>Nivel 1: </strong>Consulta<br />\r\n<strong>Nivel 2: </strong>Editar y Crear<br />\r\n<strong>Nivel 3: </strong>Borrado<br />', 1, '2013-01-12 09:34:48', 'avalle', 1),
(69, 26, 28, 1300, 0, 'CONTABILIDAD / Administracion', 'Árbol Cuentas Contables', '', '', '', '', 0, 0, 'AdminCCArbol', '', '38ae5e787418ce115e8c2460770c293f', '', 'Permite Administrar el Catálogo de las Cuentas Contables', 5, '<strong>Nivel 1: </strong>Consulta<br />\r\n<strong>Nivel 2: </strong>Editar<br />\r\n<strong>Nivel 3: </strong>Mover tipo de Cuenta<br />\r\n<strong>Nivel 5: </strong>Borrar<br />', 1, '2013-01-12 09:31:08', 'avalle', 1),
(70, 30, 32, 3, 0, 'CATÁLOGO / Proveedores', 'Consulta Proveedores', '', '', '', '', 0, 0, 'AdminProveedores', '', '38ae5e787418ce115e8c2460770c293f', '', 'Permite consultar, editar, y borrar Proveedores', 5, '<strong>Nivel 1: </strong>Consulta de Proveedores<br />\r\n<strong>Nivel 2: </strong>Editar Proveedores<br />\r\n<strong>Nivel 3: </strong>Crear Nuevos<br />\r\n<strong>Nivel 5: </strong>Borrar Proveedores<br />', 1, '2013-01-12 09:33:08', 'avalle', 1),
(1, 26, 29, 300, 0, 'CONTABILIDAD / Contabilidad Empresa', 'Auditar Pólizas', '', '', '', '', 0, 0, 'AdminPolizaAudit', '', '38ae5e787418ce115e8c2460770c293f', '', 'Permite Auditar Polizas', 2, '<strong>Nivel 1: </strong>Permite Auditar Pólizas<br />\r\n<strong>Nivel 2: </strong>Permite Reabrir Pólizas Auditadas<br />', 1, '2013-01-12 09:31:32', 'avalle', 0),
(71, 5, 7, 1, 0, 'TESORERÍA / Tesorería', 'Reportes de Ingresos', '', '', '', '', 0, 0, 'AdminTesoreria', '', '38ae5e787418ce115e8c2460770c293f', '', 'Permite consultar diferentes reportes de ingresos', 3, '\r\n<strong>Nivel 1: </strong>Consulta de Ingresos, Movimientos y Bienes Prendarios<br />\r\n<strong>Nivel 2: </strong>Consulta Pagos<br />\r\n<strong>Nivel 3: </strong>Consulta Cobranza General<br />\r\n<br />\r\n\r\n', 1, '2013-12-06 13:15:19', 'avalle', 1),
(104, 30, 83, 0, 0, '', 'Configuración General de Presupuesto', '', '', '', '', 0, 0, 'AdminPresupuestoAdmin', '', '', '', 'Permite editar configuración del módulo de presupuesto', 3, '\r\n<p><strong>Nivel 1:</strong>&nbsp;Lectura<br />\r\n<strong>Nivel 2: </strong>Creación y Edición<br />\r\n<strong>Nivel 3: </strong>Borrado</p>\r\n', 1, '2017-01-30 16:10:47', 'avalle', 0),
(72, 5, 8, 1, 0, 'TESORERÍA / Tesorería Cobranza', 'Acceso a Cargos y aplicar Pagos', '', '', '', '', 0, 0, 'AdminTesoreriaCobranza', '', '38ae5e787418ce115e8c2460770c293f', '', 'Permite consultar Cargos y Aplicar Pagos', 4, '<strong>Nivel 1: </strong>Requerido<br />\r\n<strong>Nivel 2: </strong>Puede modificar folio de depositos<br />\r\n<strong>Nivel 3: </strong>Puede seleccionar Compromisos a Saldar<br />\r\n<strong>Nivel 4: </strong>Puede Eliminar transacciones<br />', 1, '2013-01-11 17:27:01', 'avalle', 1),
(73, 5, 9, 1, 0, 'TESORERÍA / Tesorería Periodo', 'Acceso al proceso que cierra periodo', '', '', '', '', 0, 0, 'AdminTesoreriaPeriodo', '', '38ae5e787418ce115e8c2460770c293f', '', 'Acceso al proceso que cierra periodo y genera recargos si aplica', 1, '<strong>Nivel 1: </strong>Requerido<br />', 1, '2013-01-12 09:27:39', 'avalle', 1),
(74, 5, 6, 1, 0, 'TESORERÍA / Tesorería Admin', 'Acceso a parametros del sistema', '', '', '', '', 0, 0, 'AdminTesoreriaAdmin', '', '38ae5e787418ce115e8c2460770c293f', '', 'Acceso a los parámetros del sistema pertenecientes al area de Tesorería', 1, '<strong>Nivel 1: </strong>Requerido<br />', 1, '2013-01-12 09:26:48', 'avalle', 1),
(75, 20, 21, 1, 0, 'MUTUO / General', 'Consulta y Creación de Mutuos', '', '', '', '', 0, 0, 'AdminMutuos', '', '38ae5e787418ce115e8c2460770c293f', '', 'Permite consultar Mutuos, Crear, Editar y Borrar', 5, '<strong>Nivel 1: </strong>Consulta de Mutuos<br />\r\n<strong>Nivel 2: </strong>Crear Nuevos Mutuos y Editar los existentes<br />\r\n<strong>Nivel 3: </strong>Impresión de Documentos<br />\r\n<strong>Nivel 4: </strong>Puede Reabrir Mutuos Activos<br />\r\n<strong>Nivel 5: </strong>Borrar Mutuos<br />', 1, '2013-01-12 09:33:58', 'avalle', 1),
(76, 30, 31, 3, 0, 'CATÁLOGOS / Clientes', 'Importar Clientes', '', '', '', '', 0, 0, 'AdminClientesImportar', '', '38ae5e787418ce115e8c2460770c293f', '', 'Permite importar Clientes de Premium (descontinuado)', 1, '<strong>Nivel 1: </strong>Requerido<br />', 0, '2013-01-12 09:35:45', 'avalle', 1),
(77, 30, 32, 3, 0, 'CATÁLOGO / Proveedores', 'Importa Proveedores', '', '', '', '', 0, 0, 'AdminProveedoresImportar', '', '38ae5e787418ce115e8c2460770c293f', '', 'Permite Importar Proveedores de Premium (descontinuado)', 1, '<strong>Nivel 1: </strong>Requerido<br />', 0, '2013-01-12 09:35:21', 'avalle', 1),
(78, 30, 33, 3, 0, 'CATÁLOGO / Pólizas Automáticas', 'Pólizas Automáticas', '', '', '', '', 0, 0, 'AdminPolizaAdmin', '', '38ae5e787418ce115e8c2460770c293f', '', 'Permite crear, editar y borrar Pólizas Automáticas', 5, '<strong>Nivel 1: </strong>Consulta de Pólizas automáticas<br />\r\n<strong>Nivel 2: </strong>Crear y editar Pólizas automáticas<br />\r\n<strong>Nivel 5: </strong>Borrar Pólizas automáticas<br />', 1, '2013-01-12 09:38:07', 'avalle', 1),
(79, 5, 10, 1, 0, 'TESORERÍA / Tesorería Estados de Cuenta', 'Acceso al Reporte de Estados de Cuenta', '', '', '', '', 0, 0, 'AdminTesoreriaEdos', '', '38ae5e787418ce115e8c2460770c293f', '', 'Acceso al Reporte de Estados de Cuenta', 2, '<strong>Nivel 1: </strong>Consulta de estados de cuenta.<br />\r\n<strong>Nivel 2: </strong>Puede crear estados de cuenta.', 1, '2013-11-23 21:11:51', 'avalle', 1),
(80, 5, 11, 1, 0, 'TESORERÍA / Depósitos Extraordinarios', 'Acceso al área de Depósitos Extraordinarios', '', '', '', '', 0, 0, 'AdminTesoreriaDepextra', '', '38ae5e787418ce115e8c2460770c293f', '', 'Acceso al área de Depósitos Extraordinarios (Ajustes)', 5, '<strong>Nivel 1: </strong>Acceso y Consulta<br />\r\n<strong>Nivel 2: </strong>Creación y Edición<br />\r\n<strong>Nivel 5: </strong>Borrado de registros<br />', 1, '2013-01-12 09:27:19', 'avalle', 1),
(81, 5, 12, 1, 0, 'TESORERÍA / Catálogos', 'Acceso al área Catalogos de Tesoreria', '', '', '', '', 0, 0, 'AdminTesoreriaCatalogo', '', '38ae5e787418ce115e8c2460770c293f', '', 'Acceso al área Catalogos de Tesoreria', 3, '\r\n<p><strong>Nivel 1: </strong>Requerido<br />\r\n<strong>Nicel 2:</strong> Creación y edición<br />\r\n<strong>Nivel 3:</strong> Borrado</p>\r\n\r\n', 1, '2017-11-13 00:33:37', 'avalle', 0),
(82, 5, 13, 1, 0, 'TESORERÍA / Transacciones', 'Acceso a las transacciones de Tesoreria', '', '', '', '', 0, 0, 'AdminTesoreriaTrans', '', '38ae5e787418ce115e8c2460770c293f', '', 'Acceso a las Transacciones de Tesorería, permiso para ver, reversar y/o administrar', 5, '\r\n<strong>Nivel 1: </strong>Acceso y sólo consulta<br />\r\n<strong>Nivel 2: </strong>Reversar operaciones del mismo dia, despues de la fecha de corte<br />\r\n<strong>Nivel 3: </strong>Reversar operaciones despues de la fecha de corte<br />\r\n<strong>Nivel 4:&nbsp;</strong>Reversar cualquier operación (sin orden secuencial), despues de la fecha de corte<br />\r\n<strong>Nivel 5: </strong>Puede depurar transacciones, despues de la fecha de corte\r\n', 1, '2018-05-28 17:01:55', 'avalle', 0),
(83, 1, 3, 1, 0, 'CRÉDITO / Bienes Prendarios', 'Aplicación e Inventario', '', '', '', '', 0, 0, 'AdminCreditoBien', '', '38ae5e787418ce115e8c2460770c293f', '', 'Aplicación de Bienes prendarios a Créditos', 1, '<strong>Nivel 1: </strong>Requerido<br />', 1, '2013-01-12 09:30:54', 'avalle', 1),
(84, 15, 16, 1, 0, 'PÓLIZAS SEGUROS / Catálogos', 'Acceso a catalogos de polizas de seguro', '', '', '', '', 0, 0, 'AdminPolsegCatalogo', '', '38ae5e787418ce115e8c2460770c293f', '', 'Acceso a catálogos de pólizas de seguro: Tipo de Primas, Concepto de Tipo de Primas', 5, '<strong>Nivel 1: </strong>Requerido<br />\r\n<strong>Nivel 5: </strong>Crear y Borrar registros<br />', 1, '2013-01-11 17:28:14', 'avalle', 1),
(85, 15, 17, 3, 0, 'PÓLIZAS SEGUROS / Vendedores', 'Consulta Vendedores', '', '', '', '', 0, 0, 'AdminPolsegVendedores', '', '38ae5e787418ce115e8c2460770c293f', '', 'Permite consultar, editar y crear Vendedores', 5, '<strong>Nivel 1: </strong>Consulta de vendedores<br />\r\n<strong>Nivel 2: </strong>Editar vendedores<br />\r\n<strong>Nivel 3: </strong>Crear Nuevos<br />\r\n<strong>Nivel 5: </strong>Borrar vendedores<br />', 1, '2013-01-12 09:33:25', 'avalle', 1),
(86, 15, 19, 3, 0, 'PÓLIZAS SEGUROS / Agentes de Venta', 'Consulta Agentes de Venta', '', '', '', '', 0, 0, 'AdminPolsegAgentes', '', '38ae5e787418ce115e8c2460770c293f', '', 'Permite consultar, editar y crear Agentes', 5, '<strong>Nivel 1: </strong>Consulta de agentes<br />\r\n<strong>Nivel 2: </strong>Editar agentes<br />\r\n<strong>Nivel 3: </strong>Crear Nuevos<br />\r\n<strong>Nivel 5: </strong>Borrar agentes<br />', 1, '2013-01-12 09:32:39', 'avalle', 1),
(87, 15, 18, 3, 0, 'PÓLIZAS SEGUROS / Pólizas de seguro', 'Operación de pólizas de seguro', '', '', '', '', 0, 0, 'AdminPolseg', '', '38ae5e787418ce115e8c2460770c293f', '', 'Permite consultar, editar y crear Pólizas de seguro', 5, '<strong>Nivel 1: </strong>Consulta general<br />\r\n<strong>Nivel 2: </strong>Editar polizas<br />\r\n<strong>Nivel 3: </strong>Crear Nuevas<br />\r\n<strong>Nivel 5: </strong>Borrar agentes<br />', 1, '2013-01-12 09:36:14', 'avalle', 1),
(88, 22, 23, 1, 0, 'Administración', 'Configuración Clientes', '', '', '', '', 0, 0, 'AdminClientesAdmin', '', '38ae5e787418ce115e8c2460770c293f', '', 'Permite Modificar comportamiento de Clientes ', 1, '<strong>Nivel 1: </strong>Requerido<br />', 1, '2013-01-12 09:32:09', 'avalle', 1),
(89, 22, 23, 1, 0, 'Administración', 'Configuración Proveedores', '', '', '', '', 0, 0, 'AdminProveedoresAdmin', '', '38ae5e787418ce115e8c2460770c293f', '', 'Permite Modificar comportamiento de Proveedores', 1, '<strong>Nivel 1: </strong>Requerido<br />', 1, '2013-01-12 09:32:19', 'avalle', 1),
(90, 15, 18, 3, 0, 'PÓLIZAS SEGUROS / Pólizas de seguro', 'Pagos de pólizas de seguro', '', '', '', '', 0, 0, 'AdminPolsegpagos', '', '38ae5e787418ce115e8c2460770c293f', '', 'Permite capturar los pagos de Pólizas de seguro', 1, '<strong>Nivel 1: </strong>Requerido<br />', 1, '2013-01-12 09:36:48', 'avalle', 1),
(91, 5, 14, 1, 0, 'TESORERÍA / Fechas de Corte', 'Acceso a Fechas de corte', '', '', '', '', 0, 0, 'AdminTesoreriaFechaCorte', '', '38ae5e787418ce115e8c2460770c293f', '', 'Acceso a generar / borrar fechas de corte', 5, '<strong>Nivel 1: </strong>Sólo consulta<br />\r\n<strong>Nivel 2: </strong>Puede agregar nuevas fechas<br />\r\n<strong>Nivel 3: </strong>Puede habilitar / Deshabilitar<br />\r\n<strong>Nivel 5: </strong>Puede Borrar<br />', 1, '2013-01-12 09:26:13', 'avalle', 1),
(92, 22, 25, 1, 0, '', 'Acceso a Categoria Modulos', '', '', '', '', 0, 0, 'AdminModulos', '', '38ae5e787418ce115e8c2460770c293f', '', 'Acceso a modulos xxx', 1, '<strong>Nivel 1: </strong>Requerido<br />', 1, '2012-12-30 09:01:09', 'avalle', 1),
(93, 22, 23, 0, 0, '', 'Logs', '', '', '', '', 0, 0, 'adminLogs', '', '', '', 'Consulta los logs del sistema', 1, '<strong>Nivel 1</strong>: Requerido', 1, '2013-01-10 21:17:12', 'avalle', 0),
(94, 22, 24, 0, 0, '', 'Acceso general a la aplicación', '', '', '', '', 0, 0, 'AdminAccesoGeneral', '', '', '', 'De no contar con este acceso, el usuario no podrá entrar a esta empresa.', 0, '<strong>Nivel 1:</strong> Requerido', 1, '2013-01-15 17:03:20', 'avalle', 0),
(95, 1, 2, 0, 0, '', 'Estados de Cuenta', '', '', '', '', 0, 0, 'adminEstadoCuenta', '', '', '', 'Permite visualizar y realizar algunas acciones con los estados de Cuenta generados', 0, '\r\nNivel 1: Consulta\r\nNivel 2: Permite Regenerar PDFs\r\nNivel 3: Permite Borrar Estados de Cuenta', 1, '2013-05-15 20:51:49', 'avalle', 0),
(96, 30, 34, 0, 0, '', 'Personal Administrativo', '', '', '', '', 0, 0, 'AdminPadmin', '', '', '', 'Acceso al módulo de personal administrativo', 5, '<p><strong>Nivel 1</strong>: Requerido/Consulta<br />\r\n<strong>Nivel 5</strong>: Borrar Registros</p>', 1, '2013-06-25 17:10:27', 'avalle', 0),
(97, 30, 34, 0, 0, '', 'Permisos', '', '', '', '', 0, 0, 'AdminPadminpermisos', '', '', '', 'Crear y Editar Permisos al Personal Administrativo', 1, '<strong>Nivel 1</strong>: Requerido', 1, '2013-06-25 17:11:22', 'avalle', 0),
(98, 5, 8, 0, 0, '', 'Aplicación de Ingresos a compromisos', '', '', '', '', 0, 0, 'AdminTesoreriaIngresos', '', '', '', 'Permite capturar ingresos y dispersarlos en los compromisos existentes', 3, '<p><strong>Nivel 1:</strong> Puede capturar ingresos y dispersarlos siempre que el ingreso sea igual al(os) compromiso(s).<br />\r\n<strong>Nivel 2:</strong> Puede capturar ingresos y permite generar gastos administrativos si el ingreso es menor al(os) compromiso(s).<br />\r\n<strong>Nivel 3:</strong> Puede capturar ingresos y dispersarlo en un orden diferente al requerido e incluso dejar compromisos sin ingreso.</p>', 1, '2013-07-19 10:47:40', 'avalle', 0),
(99, 15, 18, 0, 0, '', 'Consultar Comisiones en Polizas', '', '', '', '', 0, 0, 'AdminPolComisiones', '', '', '', 'Ver y/o editar las comisiones en los expedientes de las Pólizas de seguro', 2, '<p><strong>Nivel 1:</strong> Solo Consulta<br />\r\n<strong>Nivel 2:</strong> Editar Comisiones</p>', 1, '2013-11-29 16:12:08', 'avalle', 0),
(101, 35, 36, 0, 0, '', 'Catálogo de Productos Indirectos', '', '', '', '', 0, 0, 'AdminIndirectos', '', '', '', 'Acceso al catálogo de Indirectos', 5, '<p><strong>Nivel 1: </strong>Consulta de Indirectos sin mostrar Precios<br />\r\n<strong>Nivel 2:</strong> Consulta de Indirectos con Precios<br />\r\n<strong>Nivel 3:</strong> Editar Indirectos sin Precios<br />\r\n<strong>Nivel 4:</strong> Crear / Editar Indirectos con Precios<br />\r\n<strong>Nivel 5:</strong> Borrar Indirectos</p>', 1, '2013-12-01 09:33:50', 'avalle', 0),
(102, 35, 36, 0, 0, '', 'Precios de Productos Indirectos', '', '', '', '', 0, 0, 'AdminIndirectosPrecios', '', '', '', 'Permiso para Cambiar Precios de Indirectos', 1, '<strong>Nivel 1:</strong> Requerido\r\n\r\n', 1, '2013-12-01 09:35:15', 'avalle', 0),
(103, 35, 36, 0, 0, '', 'Acceso general a los catalogos', '', '', '', '', 0, 0, 'AdminIndirectosCatalogo', '', '', '', 'Modifica los catalogos para el modulo de Comercial', 5, '<p><strong>Nivel 1:</strong> Consulta<br />\r\n<strong>Nivel 2:</strong> Crear y Editar<br />\r\n<strong>Nivel 5:</strong> Borrar</p>\r\n\r\n', 1, '2013-12-01 09:38:17', 'avalle', 0),
(105, 35, 36, 0, 0, '', 'Catálogo de Cuentas Concentradoras', '', '', '', '', 0, 0, 'AdminCuentas', '', '', '', 'Acceso al catálogo de Cuentas Concentradoras', 5, '<p><strong>Nivel 1: </strong>Consulta de Cuentas<br />\r\n<strong>Nivel 2:</strong> Consulta de Cuentas con Limites<br />\r\n<strong>Nivel 3:</strong> Editar Cuentas<br />\r\n<strong>Nivel 4:</strong> Crear / Editar Cuentas<br />\r\n<strong>Nivel 5:</strong> Borrar Cuentas</p>', 1, '2013-12-01 09:33:50', 'avalle', 0),
(106, 35, 36, 0, 0, '', 'Limites de Cuentas Concentradoras', '', '', '', '', 0, 0, 'AdminCuentasLimites', '', '', '', 'Permiso para Cambiar Limites de Cuentas', 1, '<strong>Nivel 1:</strong> Requerido\r\n\r\n', 1, '2013-12-01 09:35:15', 'avalle', 0),
(107, 35, 36, 0, 0, '', 'Catálogo de Líneas de Producto', '', '', '', '', 0, 0, 'AdminLineas', '', '', '', 'Acceso al catálogo de Líneas de Producto', 5, '<p><strong>Nivel 1: </strong>Consulta de Líneas<br />\r\n<strong>Nivel 2:</strong> Consulta de Líneas de Producto<br />\r\n<strong>Nivel 3:</strong> Editar Líneas<br />\r\n<strong>Nivel 4:</strong> Crear / Editar Líneas<br />\r\n<strong>Nivel 5:</strong> Borrar Cuentas</p>', 1, '2013-12-01 09:33:50', 'avalle', 0),
(108, 35, 37, 0, 0, '', 'Facturación', '', '', '', '', 0, 0, 'AdminFactura', '', '', '', 'Acceso al módulo de facturación', 1, '\r\n<strong>Nivel 1:</strong> Requerido\r\n', 1, '2016-11-10 12:17:52', 'blancebp', 0),
(109, 35, 37, 0, 0, '', 'Importar Facturas Timbradas (CFDI)', '', '', '', '', 0, 0, 'AdminFacturaImporta', '', '', '', 'Permite importar Facturas Timbradas (CFDI) al modulo de facturas', 2, '\r\n<strong>Nivel 1:</strong> Permite Subir<br />\r\n<strong>Nivel 2</strong>: Permite Cancelar', 1, '2017-06-21 08:33:46', 'avalle', 0),
(110, 1, 2, 0, 0, '', 'Acceso a cotización Express', '', '', '', '', 0, 0, 'AdminCreditosExpress', '', '', '', 'Acceso a cotización Express', 1, '<strong>Nivel 1:</strong> Requerido', 1, '2014-02-11 14:59:24', 'avalle', 0),
(111, 38, 39, 0, 0, '', 'Contabilidad Personas', '', '', '', '', 0, 0, 'AdminContabilidadPersonas', '', '', '', 'Acceso a los Expedientes de la Contabilidad de las Personas', 5, '\r\n<strong>Nivel 1:</strong> Consulta<br />\r\n<strong>Nivel 2:</strong> Crear nuevos, agregar información de Trámite de Alta, Agregar y editar Archivos al Expediente<br />\r\n<strong>Nivel 3:</strong> Borrar Archivos del Expediente, ver contraseñas del SAT y Regresar Status especiales<br />\r\n<strong>Nivel 4:</strong> Pasar a Histórico, Suspender actividades y reactivar expedientes<br />\r\n<strong>Nivel 5:</strong> Borrar Expedientes\r\n', 1, '2015-11-05 13:52:05', 'avalle', 0),
(189, 52, 72, 0, 0, '', 'Catálogo de Elementos en Neumáticos', '', '', '', '', 0, 0, 'AdminNeumaticosCatalogos', '', '', '', 'Permite cambiar los elementos como Marcas, Diseños, Tipos, etc.', 3, '\r\n<strong>\r\nNivel 1:</strong> Requerido\r\n\r\n<br />\r\n<strong>Nivel 2:</strong> Creación y Edición<br />\r\n<strong>Nivel 3:</strong> Borrado', 1, '2017-03-15 13:25:01', 'avalle', 0),
(190, 52, 72, 0, 0, '', 'Inventario de Neumáticos', '', '', '', '', 0, 0, 'AdminllantasInv', '', '', '', 'Acceso al Inventario de Neumáticos', 4, '<strong>\r\nNivel 1:</strong> Consulta de Inventario<br />\r\n<strong>\r\nNivel 2:</strong> Agregar y editar registros.<br />\r\n<strong>\r\nNivel 3:</strong> Editar Folios delos Neumáticos<br />\r\n<strong>\r\nNivel 4:</strong> Borrar Neumáticos\r\n', 1, '2015-10-13 12:05:38', 'avalle', 0),
(191, 52, 60, 0, 0, '', 'Consulta Accesos Torniquetes', '', '', '', '', 0, 0, 'AdminConsultaATMTor', '', '', '', '', 1, '\r\nNivel 1: Requerido\r\n', 1, '2015-10-22 05:37:17', 'avalle', 0),
(192, 35, 36, 0, 0, '', 'Impresión de productos', '', '', '', '', 0, 0, 'AdminIndirectosPreciosImp', '', '', '', 'Impresión de productos', 2, '\r\n<p><strong>Nivel 1:</strong> Requerido<br />\r\n<strong>\r\nNivel 2:</strong> Impresión con precios</p>\r\n', 1, '2015-11-02 21:46:49', 'avalle', 0),
(112, 38, 39, 0, 0, '', 'Acceso a los Catálogos', '', '', '', '', 0, 0, 'AdminContabilidadCatalogos', '', '', '', 'Acceso a los catálogos de Contabilidad', 3, '<div><strong>Nivel 1:</strong> Consulta\r\n</div>\r\n<div><strong>Nivel 2:</strong> Creación y Edición\r\n</div>\r\n<div><strong>Nivel 3:</strong> Borrado\r\n</div>\r\n\r\n', 1, '2014-02-17 17:39:31', 'avalle', 0),
(113, 38, 39, 0, 0, '', 'Pagos de Contribuyentes', '', '', '', '', 0, 0, 'AdminContabilidadPagos', '', '', '', 'Acceso a los pagos de los contrinuyentes', 4, '<div><strong>Nivel 1:</strong> Consulta de pagos\r\n</div>\r\n<div><strong>Nivel 2</strong>: Agregar y Editar Pagos\r\n</div>\r\n<div><strong>Nivel 3:</strong> Reabrir Tributaciones\r\n</div>\r\n<div><strong>Nivel 4:</strong> Borrado\r\n</div>\r\n\r\n', 1, '2014-02-17 17:40:16', 'avalle', 0),
(114, 38, 39, 0, 0, '', 'Observaciones', '', '', '', '', 0, 0, 'AdminContabilidadObservaciones', '', '', '', 'Observaciones en COntabilidad Personas', 2, '<div><strong>Nivel 1:</strong> Agregar y Editar Observaciones\r\n</div>\r\n<div><strong>Nivel 2:</strong> Borrar\r\n</div>\r\n\r\n', 1, '2014-02-17 17:40:46', 'avalle', 0),
(115, 35, 37, 0, 0, '', 'Sube CFDIs', '', '', '', '', 0, 0, 'AdminFacturaSube', '', '', '', 'Permite subir al CEN CFDIs', 1, '\r\n<strong>Nivel 1:</strong> Requerido\r\n\r\n\r\n', 1, '2016-11-10 12:18:16', 'blancebp', 0),
(117, 38, 48, 0, 0, '', 'Catálogo de Empresas', '', '', '', '', 0, 0, 'AdminEmpresasConta', '', '', '', 'Permite acceder al catálogo de empresa', 3, '\r\n<strong>Nivel 1:</strong>&nbsp;Consulta<br />\r\n<strong>Nivel 2:</strong>&nbsp;Puede generar y editar<br />\r\n<strong>Nivel 3:</strong> Borra registros\r\n\r\n', 1, '2014-07-04 15:01:40', 'avalle', 0),
(118, 38, 39, 0, 0, '', 'Ingresos de los Contribuyentes', '', '', '', '', 0, 0, 'AdminContaIngreso', '', '', '', 'Acceso a los Ingresos de los Contribuyentes', 3, '<div><strong>Nivel 1:</strong> Consulta de ingresos\r\n</div>\r\n<div><strong>Nivel 2: </strong>Crear y Editar registros\r\n</div>\r\n<div><strong>Nivel 3:</strong> Borrar registros\r\n</div>\r\n\r\n', 1, '2014-04-16 18:37:48', 'avalle', 0),
(119, 38, 39, 0, 0, '', 'Egresos de los Contribuyentes', '', '', '', '', 0, 0, 'AdminContaEgreso', '', '', '', 'Acceso a los Egresos de los Contribuyentes', 3, '<div><strong>Nivel 1:</strong> Consulta de registros\r\n</div>\r\n<div><strong>Nivel 2:</strong> Crear y Editar\r\n</div>\r\n<div><strong>Nivel 3:</strong> Borrar registros\r\n</div>\r\n\r\n', 1, '2014-04-16 18:38:31', 'avalle', 0),
(120, 38, 39, 0, 0, '', 'Cálculo de Contribuyentes', '', '', '', '', 0, 0, 'AdminContaCalculo', '', '', '', 'Acceso al cálculo de los contribuyentes', 3, '\r\n<div><strong>Nivel 1:</strong> Consulta de registros\r\n</div>\r\n<div><strong>Nivel 2:</strong> Crear cálculos nuevos\r\n</div>\r\n<div><strong>Nivel 3:</strong> Borrar cálculos\r\n</div>\r\n\r\n\r\n', 1, '2015-11-05 13:48:36', 'avalle', 0),
(121, 35, 41, 0, 0, '', 'Acceso a los archivos generales', '', '', '', '', 0, 0, 'AdminArcComercial', '', '', '', 'Permite acceder a los archivos generales del módulo', 3, '<strong>Nivel 1:</strong> Consulta<br />\r\n<strong>Nivel 2:</strong> Crear nuevos<br />\r\n<strong>Nivel 3:</strong> Borrar', 1, '2014-05-24 12:04:42', 'avalle', 0),
(122, 26, 42, 0, 0, '', 'Acceso a los archivos generales', '', '', '', '', 0, 0, 'AdminArcContabilidad', '', '', '', 'Permite acceder a los archivos generales del módulo', 3, '<strong>Nivel 1:</strong>&nbsp;Consulta<br />\r\n<strong>Nivel 2:</strong>&nbsp;Crear nuevos<br />\r\n<strong>Nivel 3:</strong>&nbsp;Borrar\r\n\r\n', 1, '2014-05-24 12:05:30', 'avalle', 0),
(123, 39, 43, 0, 0, '', 'Acceso a los archivos generales', '', '', '', '', 0, 0, 'AdminArcConpersonas', '', '', '', 'Permite acceder a los archivos generales del módulo', 3, '<div><strong>Nivel 1:</strong> Consulta\r\n</div>\r\n<div><strong>Nivel 2:</strong> Crear nuevos\r\n</div>\r\n<div><strong>Nivel 3:</strong> Borrar\r\n</div>\r\n\r\n', 1, '2014-05-24 12:06:46', 'avalle', 0),
(124, 1, 44, 0, 0, '', 'Acceso a los archivos generales', '', '', '', '', 0, 0, 'AdminArcContratos', '', '', '', 'Permite acceder a los archivos generales del módulo', 3, '<div><strong>Nivel 1:</strong>&nbsp;Consulta\r\n</div>\r\n<div><strong>Nivel 2:</strong>&nbsp;Crear nuevos\r\n</div>\r\n<div><strong>Nivel 3:</strong>&nbsp;Borrar\r\n</div>\r\n\r\n', 1, '2014-05-24 12:07:32', 'avalle', 0),
(125, 15, 45, 0, 0, '', 'Acceso a los archivos generales', '', '', '', '', 0, 0, 'AdminArcSeguros', '', '', '', 'Permite acceder a los archivos generales del módulo', 3, '<div><strong>Nivel 1:</strong> Consulta\r\n</div>\r\n<div><strong>Nivel 2:</strong> Crear nuevos\r\n</div>\r\n<div><strong>Nivel 3:</strong> Borrar\r\n</div>\r\n\r\n', 1, '2014-05-24 12:08:24', 'avalle', 0),
(126, 5, 46, 0, 0, '', 'Acceso a los archivos generales', '', '', '', '', 0, 0, 'AdminArcTesoreria', '', '', '', 'Permite acceder a los archivos generales del módulo', 3, '<div><strong>Nivel 1:</strong>&nbsp;Consulta\r\n</div>\r\n<div><strong>Nivel 2:</strong>&nbsp;Crear nuevos\r\n</div>\r\n<div><strong>Nivel 3:</strong>&nbsp;Borrar\r\n</div>\r\n\r\n', 1, '2014-05-24 12:09:06', 'avalle', 0),
(127, 22, 23, 0, 0, '', 'Acceso a los datos de la Empresa', '', '', '', '', 0, 0, 'AdminDatosEmpresa', '', '', '', 'Acceso a los datos de la Empresa', 2, '\r\n<p><strong>Nivel 1:</strong>&nbsp;Consulta<br />\r\n<strong>Nivel 2:</strong>&nbsp;Editar Información</p>', 1, '2018-04-17 11:54:57', 'avalle', 0),
(128, 38, 39, 0, 0, '', 'Impresión de Contrato', '', '', '', '', 0, 0, 'AdminContribuyentesImpdoc', '', '', '', 'Permite la impresión de Caratula y Contrato de clientes', 1, '<strong>Nivel 1:</strong> Requerido\r\n\r\n', 1, '2014-07-04 14:59:55', 'avalle', 0),
(129, 38, 47, 0, 0, '', 'Acceso Directo Contribuyente', '', '', '', '', 0, 0, 'AccesoDirectoContribuyente', '', '', '', 'Permite el acceso a solo capturar Ingresos y Egresos personales. Se necesita el acceso adecuado a estos dos módulos y asociar su ID de Contribuyente. Cualquier otro acceso a otro módulo del CEN queda nulificado.', 1, '<strong>Nivel 1:</strong> Requerido\r\n\r\n', 1, '2014-07-04 15:02:36', 'avalle', 0),
(130, 30, 49, 0, 0, '', 'Tablas de Calculo de Impuestos', '', '', '', '', 0, 0, 'AdminContaTablas', '', '', '', 'Tabla de cálculo de contribuyentes y Subsidio', 3, '<p><strong>Nivel 1:</strong> Consulta<br />\r\n<strong>Nivel 2:</strong> Creación y edición<br />\r\n<strong>Nivel 3:</strong> Borrado de registros</p>', 1, '2014-07-21 09:38:10', 'avalle', 0),
(131, 38, 48, 0, 0, '', 'Cambiar tipo de Cálculo', '', '', '', '', 0, 0, 'AdminContaCalculoadmin', '', '', '', 'Permite cambiar el tipo de cálculo en las declaraciones', 1, '\r\n<strong>Nivel 1:</strong> Requerido\r\n\r\n\r\n', 1, '2014-07-22 18:51:46', 'avalle', 0),
(132, 35, 50, 0, 0, '', 'Creación de Cotizaciones', '', '', '', '', 0, 0, 'AdminCotizacion', '', '', '', 'Permite la creación de Cotizaciones', 4, '<div><strong>Nivel 1.</strong> Consulta de Cotizaciones existentes\r\n</div>\r\n<div><strong>Nivel 2.</strong> Creación y edición de Cotizaciones\r\n</div>\r\n<div><strong>Nivel 3.</strong> Puede modificar precios en la cotización\r\n</div>\r\n<div><strong>Nivel 4</strong>. Puede borrar registros\r\n</div>\r\n\r\n', 1, '2014-09-16 16:59:55', 'avalle', 0),
(133, 22, 25, 0, 0, '', 'Asociación de Documentos a modulos', '', '', '', '', 0, 0, 'AdminDocumentos', '', '', '', 'Permite la asociación de reportes, contratos y documentos', 3, '\r\n<div>Nivel 1: Consulta de asociaciones\r\n<br />\r\nNivel 2: Editar y Crear<br />\r\nNivel 3: Borrar\r\n</div>\r\n\r\n\r\n\r\n\r\n\r\n\r\n', 1, '2014-12-14 22:06:45', 'avalle', 0),
(134, 35, 51, 0, 0, '', 'Acceso a Ventas', '', '', '', '', 0, 0, 'AdminVentas', '', '', '', 'Acceso a Ventas', 4, '\r\n<strong>Nivel 1:</strong>&nbsp;Consulta<br />\r\n<strong>\r\nNivel 2:</strong> Creación y Edición<br />\r\n<strong>\r\nNivel 3:</strong> Cancelar Ventas<br />\r\n<strong>Nivel 4:</strong> Borrar Ventas', 1, '2018-05-02 21:58:03', 'avalle', 0),
(135, 52, 54, 0, 0, '', 'Unidades', '', '', '', '', 0, 0, 'AdminUnidades', '', '', '', 'Acceso al catálogo de unidades', 5, '\r\nNivel 1:&nbsp;Consulta<br />\r\nNivel 2:&nbsp;Puede crear y editar Archivos<br />\r\nNivel 3:&nbsp;Se pueden Borrar archivos y agregar Neumáticos<br />\r\nNivel 4:&nbsp;Se puede crear y editar registros<br />\r\nNivel 5:&nbsp;Se puede borrar registros\r\n\r\n\r\n\r\n', 1, '2016-04-05 17:45:21', 'avalle', 0),
(136, 52, 54, 0, 0, '', 'Acceso a Catálogos generales', '', '', '', '', 0, 0, 'AdminUnidadesCatalogos', '', '', '', 'Catalogos que utiliza el modulo de Unidades', 3, '\r\n<p><strong>\r\nNivel 1</strong>: Consulta<br />\r\n<strong>\r\nNivel 2</strong>: Crear y editar<br />\r\n<strong>\r\nNivel 3</strong>: Borrar</p>\r\n', 1, '2016-02-19 15:50:02', 'avalle', 0),
(137, 55, 56, 0, 0, '', 'Acceso al catálogo principal de Personal', '', '', '', '', 0, 0, 'AdminPopera', '', '', '', 'Acceso a consultar, crear y editar personal', 4, '<strong>\r\nNivel 1</strong>: Consulta de registros<br />\r\n<strong>\r\nNivel 2</strong>: Crear y edición Limitada<br />\r\n<strong>\r\nNivel 3</strong>: Edición Total (Excepto Status)<br />\r\n<strong>\r\nNivel 4</strong>:&nbsp;Puede Borrar registros\r\n\r\n\r\n\r\n\r\n', 1, '2015-02-20 15:38:06', 'avalle', 0),
(138, 55, 58, 0, 0, '', 'Configuración de modulo de Capital Humano', '', '', '', '', 0, 0, 'AdminOperaAdmin', '', '', '', 'Permite modificar aspectos del comportamiento del modulo de Capital Humano', 1, '<strong>\r\nNivel 1:</strong> Requerido &nbsp;&nbsp;\r\n\r\n\r\n', 1, '2015-01-08 17:05:35', 'avalle', 0),
(139, 30, 59, 0, 0, '', 'Acceso a Cursos', '', '', '', '', 0, 0, 'AdminCursos', '', '', '', 'Accesa a Cursos', 3, 'Nivel 1: Consulta<br />\r\nNivel 2: Creación y Edición<br />\r\nNivel 3: Borrado de Registros\r\n\r\n', 1, '2015-01-13 17:33:56', 'avalle', 0),
(140, 55, 56, 0, 0, '', 'Exportar Capital Humano', '', '', '', '', 0, 0, 'AdminPoperaExp', '', '', '', 'Permite Exportar a un archivo Excel los elementos del Capital Humano', 1, '<strong>\r\nNivel 1:</strong> Requerido\r\n', 1, '2015-01-14 11:25:51', 'avalle', 0),
(141, 52, 60, 0, 0, '', 'Captura de Combustible', '', '', '', '', 0, 0, 'AdminCapCom', '', '', '', 'Captura de Combustible en Unidades', 3, '\r\n<strong>\r\nNivel 1:</strong> Requerido\r\n<br />\r\n<strong>\r\nNivel 2:</strong> Creación y edición<br />\r\n<strong>\r\nNivel 3:</strong> Borrado de registros\r\n\r\n', 1, '2015-02-09 11:17:57', 'avalle', 0),
(142, 52, 60, 0, 0, '', 'Captura de Bitacora de Salidas y Llegadas', '', '', '', '', 0, 0, 'AdminCapCir', '', '', '', 'Captura de Bitacora de Salidas y Llegadas', 5, '\r\n<p><strong>Nivel 1:</strong> Consulta<br />\r\n<strong>\r\nNivel 2</strong>: Creación de ciclos y captura de \r\nregistros<br />\r\n<strong>\r\nNivel 3:</strong> Edición de registros existentes y captura de \r\nincidencias<br />\r\n<strong>\r\nNivel 4:</strong> Edición de eco, operador y fecha<br />\r\n<strong>\r\nNivel \r\n5:</strong> Borrado</p>\r\n\r\n\r\n', 1, '2015-01-23 10:29:19', 'avalle', 0),
(143, 55, 56, 0, 0, '', 'Permite cambiar el status', '', '', '', '', 0, 0, 'AdminPoperaStatus', '', '', '', 'Permite cambiar el Status del personal de Capital Humano', 2, '\r\n<strong>\r\nNivel 1:</strong> Requerido para cambiar status<br />\r\n<strong>Nivel 2</strong>: Cambiar status que no cambian', 1, '2016-07-07 17:17:03', 'avalle', 0),
(144, 52, 61, 0, 0, '', 'Catálogo de Siniestros', '', '', '', '', 0, 0, 'AdminSiniestrosCatalogos', '', '', '', 'Acceso a todos los catálogos utilizados en la captura de Siniestros', 3, '\r\n<strong>\r\nNivel 1:</strong> Requerido\r\n\r\n\r\n<br />\r\n<strong>Nivel 2:</strong> Creación y edición<br />\r\n<strong>Nivel 3:</strong> Borrado\r\n', 1, '2018-08-23 18:29:28', 'avalle', 0),
(145, 52, 61, 0, 0, '', 'Administración de Folios y año de trabajo', '', '', '', '', 0, 0, 'AdminSiniestrosFolios', '', '', '', 'Personal con este permiso, podrá administrar el rango de folios permicibles en la documentación de Siniestros', 1, '\r\n<strong>\r\nNivel 1:</strong> Requerido\r\n\r\n', 1, '2015-01-28 06:30:26', 'avalle', 0),
(146, 52, 61, 0, 0, '', 'Siniestros', '', '', '', '', 0, 0, 'AdminSiniestros', '', '', '', 'Permite el acceso a los Siniestros', 4, '\r\n<p><strong>Nivel 1:</strong> Consulta de registros<br />\r\n<strong>\r\nNivel 2:</strong> Crear y editar Registros<br />\r\n<strong>\r\nNivel \r\n3:</strong> Puede cambiar Status<br />\r\n<strong>\r\nNivel 4:</strong> Borrar registros</p>\r\n\r\n\r\n\r\n\r\n', 1, '2015-01-28 05:32:44', 'avalle', 0),
(147, 52, 61, 0, 0, '', 'Actuaciones', '', '', '', '', 0, 0, 'AdminSiniestrosAct', '', '', '', 'Permite el acceso a las actuaciones de los siniestros', 3, '<strong>\r\nNivel 1:</strong> Consulta<br />\r\n<strong>\r\nNivel 2:</strong> Creación y Edición<br />\r\n<strong>\r\nNivel 3:</strong> Borrado de \r\nregistros&nbsp;\r\n\r\n\r\n', 1, '2015-01-28 05:33:34', 'avalle', 0),
(148, 52, 61, 0, 0, '', 'Archivos', '', '', '', '', 0, 0, 'AdminSiniestrosArc', '', '', '', 'Permite Acceder a los archivos de los Siniestros', 3, '<strong>\r\nNivel 1:</strong> Consulta<br />\r\n<strong>\r\nNivel 2:</strong> Creación y Edición<br />\r\n<strong>\r\nNivel 3:</strong> Borrado de \r\nregistros&nbsp;\r\n\r\n\r\n\r\n', 1, '2015-01-28 05:33:03', 'avalle', 0),
(149, 52, 62, 0, 0, '', 'Esquemas de Salidas', '', '', '', '', 0, 0, 'AdminEsquemas', '', '', '', 'Creación y Aplicación de equemas para crear el rol de operación de Salidas', 5, '<strong>\r\nNivel 1:</strong> Consulta<br />\r\n<strong>\r\nNivel 2:</strong> Aplicación de Esquemas<br />\r\n<strong>\r\nNivel \r\n3:</strong> Creación y edición<br />\r\n<strong>\r\nNivel 4:</strong> Borrado de esquemas \r\naplicados<br />\r\n<strong>\r\nNivel 5:</strong> Borrado General&nbsp;\r\n\r\n\r\n', 1, '2015-02-03 09:52:32', 'avalle', 0),
(150, 52, 60, 0, 0, '', 'Incidencias de Operadores', '', '', '', '', 0, 0, 'AdminIncidencias', '', '', '', 'Incidencias de Operadores', 3, '<strong>\r\nNivel 1:</strong> Consulta de Registros<br />\r\n<strong>\r\nNivel 2:</strong> Creación y Edición<br />\r\n<strong>\r\nNivel 3:</strong> Borrado\r\n', 1, '2015-02-06 22:36:14', 'avalle', 0),
(151, 52, 60, 0, 0, '', 'Captura de AdBlue', '', '', '', '', 0, 0, 'AdminCapAdb', '', '', '', 'Captura de AdBlue', 3, '\r\n<div>\r\n<div>Nivel 1: Requerido&nbsp;\r\n</div>\r\n<div>Nivel 2: Creación y edición\r\n</div>\r\n<div>Nivel 3: Borrado de registros\r\n</div>\r\n</div>\r\n\r\n\r\n\r\n\r\n', 1, '2015-12-30 14:45:27', 'avalle', 0),
(152, 55, 56, 0, 0, '', 'Documentos Laborales', '', '', '', '', 0, 0, 'AdminPoperaDoc', '', '', '', 'Consulta y Creación de Documentos Laborales', 3, '<strong>\r\nNivel 1:</strong> Consulta e Impresión<br />\r\n<strong>\r\nNivel 2:</strong> Creación y \r\nedición<br />\r\n<strong>\r\nNivel 3:</strong> Borrado de documentos&nbsp;\r\n\r\n\r\n', 1, '2015-02-10 16:47:39', 'avalle', 0),
(153, 63, 64, 0, 0, '', 'Acceso General', '', '', '', '', 0, 0, 'AdminAppDirect', '', '', '', '', 1, '<strong>\r\nNivel 1:</strong> Requerido\r\n', 1, '2015-02-12 17:16:57', 'avalle', 0),
(154, 52, 60, 0, 0, '', 'Capturar Ingreso AdBlue', '', '', '', '', 0, 0, 'AdminIngBlue', '', '', '', '', 3, '<strong>\r\nNivel 1:</strong> Consulta<br />\r\n<strong>\r\nNivel 2:</strong> Capturar y Editar \r\nRegistros<br />\r\n<strong>\r\nNivel 3:</strong> Borrar<br />\r\n\r\n\r\n', 1, '2015-02-19 12:04:32', 'avalle', 0),
(155, 52, 62, 0, 0, '', 'Controla fechas de Corte', '', '', '', '', 0, 0, 'AdminUOperacionFechaCorte', '', '', '', 'Deshabilita la posibilidad de modificar información anterior a la última fecha de ', 5, '<strong>\r\nNivel 1</strong>:&nbsp;Sólo consulta<br />\r\n<strong>\r\nNivel 2</strong>:&nbsp;Puede agregar nuevas fechas<br />\r\n<strong>\r\nNivel 3</strong>:&nbsp;Puede habilitar / Deshabilitar<br />\r\n<strong>\r\nNivel 5</strong>:&nbsp;Puede Borrar\r\n', 1, '2015-02-19 17:28:31', 'avalle', 0),
(156, 55, 56, 0, 0, '', 'Acceso a los archivos', '', '', '', '', 0, 0, 'adminPoperaArc', '', '', '', 'Acceso a los archivos de los expedientes', 4, '\r\n<strong>\r\nNivel 1:</strong> Consultar<br />\r\n<strong>\r\nNivel 2:</strong> Crear<br />\r\n<strong>\r\nNivel 3:</strong> Editar<br />\r\n<strong>\r\nNivel 4:</strong> Borrar&nbsp;\r\n\r\n\r\n\r\n', 1, '2015-02-20 15:40:44', 'avalle', 0),
(157, 63, 65, 0, 0, '', 'Acceso a la App de Bitacora', '', '', '', '', 0, 0, 'AdminAppDirectBit', '', '', '', '', 1, '<strong>\r\nNivel 1:</strong> Requerido\r\n', 1, '2015-02-21 14:30:25', 'avalle', 0),
(158, 63, 64, 0, 0, '', 'Utilizar Terminal Americas', '', '', '', '', 0, 0, 'AdminAppDirectBitAme', '', '', '', '', 1, '<strong>\r\nNivel 1:</strong> Requerido\r\n', 1, '2015-02-21 14:31:25', 'avalle', 0),
(159, 63, 64, 0, 0, '', 'Utilizar Terminal Quebrada', '', '', '', '', 0, 0, 'AdminAppDirectBitQue', '', '', '', '', 1, '<strong>\r\nNivel 1:</strong> Requerido\r\n', 1, '2015-02-21 14:32:30', 'avalle', 0),
(160, 52, 66, 0, 0, '', 'Resumen de Unidades', '', '', '', '', 0, 0, 'AdminUnidadesRes', '', '', '', '', 1, '\r\n<strong>\r\nNivel 1:</strong> Requerido\r\n\r\n', 1, '2015-03-07 09:58:46', 'avalle', 0),
(161, 52, 66, 0, 0, '', 'Resumen de Unidades Costos', '', '', '', '', 0, 0, 'AdminUnidadesResV', '', '', '', 'Permite consultar el cálculo de costos en la vista', 1, '\r\n<strong>\r\nNivel 1:</strong> Requerido\r\n\r\n', 1, '2015-03-07 11:16:08', 'avalle', 0),
(162, 52, 66, 0, 0, '', 'Resumen de Unidades Export', '', '', '', '', 0, 0, 'AdminUnidadesResEx', '', '', '', 'Permite utilizar la herramienta Export', 1, '<strong>\r\nNivel 1:</strong> Requerido\r\n', 1, '2015-03-07 10:00:33', 'avalle', 0),
(163, 52, 66, 0, 0, '', 'Resumen de Operadores', '', '', '', '', 0, 0, 'AdminOperadoresRes', '', '', '', '', 1, '<strong>\r\nNivel 1:</strong> Requerido\r\n', 1, '2015-03-07 10:01:19', 'avalle', 0),
(164, 52, 66, 0, 0, '', 'Resumen de Operadores Costos', '', '', '', '', 0, 0, 'AdminOperadoresResV', '', '', '', 'Permite consultar los costos de la vista', 1, '<strong>Nivel 1:</strong> Requerido', 1, '2015-03-07 10:02:15', 'avalle', 0),
(165, 52, 66, 0, 0, '', 'Resumen de Operadores Export', '', '', '', '', 0, 0, 'AdminOperadoresResEx', '', '', '', 'Permite utilizar la herramienta Export', 1, '<strong>Nivel 1:</strong> Requerido', 1, '2015-03-07 10:03:03', 'avalle', 0),
(166, 52, 60, 0, 0, '', 'Ver costos en vista Combustible', '', '', '', '', 0, 0, 'AdminCapComC', '', '', '', '', 1, '\r\n<strong>Nivel 1:</strong> Requerido\r\n\r\n\r\n', 1, '2015-07-07 09:46:06', 'avalle', 0),
(167, 52, 60, 0, 0, '', 'Ver costos en vista AdBlue', '', '', '', '', 0, 0, 'AdminCapAdbC', '', '', '', '', 1, '<strong>Nivel 1:</strong> Requerido\r\n\r\n', 1, '2015-03-07 11:32:47', 'avalle', 0),
(168, 52, 60, 0, 0, '', 'Permite ver costos en Ingresos de AdBlue', '', '', '', '', 0, 0, 'AdminIngBlueC', '', '', '', '', 1, '<strong>Nivel 1:</strong> Requerido\r\n\r\n', 1, '2015-03-07 11:37:32', 'avalle', 0),
(169, 30, 67, 0, 0, '', 'Acceso al Organigrama', '', '', '', '', 0, 0, 'AdminOrganigrama', '', '', '', '', 3, '\r\n<strong>\r\nNivel 1:</strong> Consulta<br />\r\n<strong>\r\nNivel 2:</strong> Alterar Organigrama<br />\r\n<strong>\r\nNivel 3:</strong> Borrar partes del Organigrama\r\n\r\n', 1, '2015-03-10 11:19:07', 'avalle', 0),
(170, 55, 56, 0, 0, '', 'Permite agregar Persona al Organigrama', '', '', '', '', 0, 0, 'AdminSelOrganigrama', '', '', '', 'Solo aparece la opción en status de Contratación', 1, '<strong>\r\nNivel 1:</strong> Requerido\r\n', 1, '2015-03-10 11:20:30', 'avalle', 0),
(171, 52, 60, 0, 0, '', 'Exportar Bitacora de Operación', '', '', '', '', 0, 0, 'AdminCapCirEx', '', '', '', '', 1, '<strong>\r\nNivel 1:</strong> Requerido\r\n', 1, '2015-03-19 17:09:39', 'avalle', 0),
(172, 52, 60, 0, 0, '', 'Exportar Bitacora de Combustible', '', '', '', '', 0, 0, 'AdminCapComEx', '', '', '', 'Permite exportar los datos de combustible', 1, '<strong>Nivel 1:</strong> Requerido', 1, '2015-03-23 13:36:11', 'avalle', 0),
(173, 52, 60, 0, 0, '', 'Exportar Bitacora de AdBlue', '', '', '', '', 0, 0, 'AdminCapAdbEx', '', '', '', 'Permite exportar a Excel los datos de AdBlue', 1, '\r\n<strong>Nivel 1:</strong> Requerido\r\n', 1, '2015-03-23 13:42:16', 'avalle', 0),
(174, 55, 58, 0, 0, '', 'Catálogo de Capital Humano', '', '', '', '', 0, 0, 'AdminPoperaCat', '', '', '', 'Permite Consultar, Editar y Borrar Status del Capital Humano ', 3, '\r\n<strong>Nivel 1:</strong> Consulta<br />\r\n<strong>Nivel 2:</strong> Creación y Edición<br />\r\n<strong>Nivel 3</strong>: Borrado', 1, '2017-04-21 11:41:42', 'avalle', 0),
(175, 52, 54, 0, 0, '', 'Catálogo de Taller', '', '', '', '', 0, 0, 'AdminMantoCat', '', '', '', 'Acceso al catálogo utilizado para el acceso al Taller', 3, '<strong>\r\nNivel 1:</strong> Consulta<br />\r\n<strong>\r\nNivel 2:</strong> Creación y edición<br />\r\n<strong>\r\nNivel 3:</strong> Borrado de registros\r\n', 1, '2015-04-10 05:53:25', 'avalle', 0),
(176, 30, 59, 0, 0, '', 'Agregar Archivos a Cursos', '', '', '', '', 0, 0, 'AdminCursosArc', '', '', '', 'Permite agregar archivos al catálogo de cursos', 3, '<strong>\r\nNivel 1:</strong> Consultar Archivos<br />\r\n<strong>\r\nNivel 2:</strong> Agregar y Editar Archivos<br />\r\n<strong>\r\nNivel 3:</strong> Borrar Archivos\r\n', 1, '2015-04-16 05:18:54', 'avalle', 0),
(177, 52, 60, 0, 0, '', 'Cambios de unidades y operadores', '', '', '', '', 0, 0, 'AdminCirCam', '', '', '', 'Cambios de unidades y operadores en las bitacoras de operación', 1, '<strong>Nivel 1:</strong> Requerido', 1, '2015-05-07 11:02:39', 'avalle', 0),
(178, 52, 68, 0, 0, '', 'Acceso al modulo de Mantenimiento', '', '', '', '', 0, 0, 'AdminManto', '', '', '', 'Acceso al modulo de Mantenimiento. Es necesario la combinación de otros modulos, pero es indispensable este acceso, minimo nivel 1', 5, '\r\n<p><strong>Nivel 1:</strong> Consulta<br />\r\n<strong>Nivel 2:</strong> Edición<br />\r\n<strong>Nivel 3:</strong> Cancelado<br />\r\n<strong>Nivel 4:</strong> Cerrado<br />\r\n<strong>Nivel 5:</strong> Borrado</p>\r\n', 1, '2018-12-18 13:57:57', 'avalle', 0),
(179, 52, 68, 0, 0, '', 'Administración Mantenimiento', '', '', '', '', 0, 0, 'AdminMantoAdmin', '', '', '', 'Permite cambiar configuraciones propias del módulo de Mantenimiento', 1, '<strong>\r\nNivel 1:</strong> Requerido\r\n', 1, '2015-06-04 14:15:20', 'avalle', 0),
(180, 55, 58, 0, 0, '', 'Importa Capital Humano', '', '', '', '', 0, 0, 'AdminImOpera', '', '', '', 'Importa Capital Humano de otra empresa del CEN', 1, '<strong>\r\nNivel 1:</strong> Requerido\r\n', 1, '2015-06-06 12:49:16', 'avalle', 0),
(181, 52, 60, 0, 0, '', 'Permite la captura de Ingreso a Combustible', '', '', '', '', 0, 0, 'AdminIngCom', '', '', '', 'Permite la captura de Ingreso a Combustible', 3, '<div>Nivel 1: Consulta\r\n</div>\r\n<div>Nivel 2: Capturar y Editar Registros\r\n</div>\r\n<div>Nivel 3: Borrar\r\n</div>', 1, '2015-07-06 17:07:19', 'avalle', 0),
(182, 52, 62, 0, 0, '', 'Reporte de Código de Barras de CH', '', '', '', '', 0, 0, 'AdminPoperaRep', '', '', '', '', 1, '\r\n<strong>\r\nNivel 1:</strong> Requerido\r\n\r\n', 1, '2015-07-30 17:16:57', 'avalle', 0),
(183, 52, 62, 0, 0, '', 'Importar Información de Lectores', '', '', '', '', 0, 0, 'AdminLector', '', '', '', '', 1, '<strong>\r\nNivel 1:</strong> Requerido\r\n', 1, '2015-07-30 17:18:03', 'avalle', 0),
(184, 52, 60, 0, 0, '', 'Genera Jornadas de Operación', '', '', '', '', 0, 0, 'AdminJornadas', '', '', '', 'Genera Jornadas en base a esquemas preestablecidos', 2, '\r\n<div><strong>Nivel 1:</strong> Crear Jornadas\r\n</div>\r\n<div><strong>Nivel 2:</strong> Borrar Jornadas\r\n</div>\r\n\r\n\r\n', 1, '2015-08-29 07:16:35', 'avalle', 0),
(185, 52, 72, 0, 0, '', 'Administrar Neumáticos', '', '', '', '', 0, 0, 'Adminllantas', '', '', '', 'Permite consultar, asignar y capturar registros de los Neumáticos', 4, '\r\n<strong>\r\nNivel 1</strong>: Consulta de Neumáticos<br />\r\n<strong>\r\nNivel 2</strong>:&nbsp;Agrega información a Neumáticos<br />\r\n<strong>\r\nNivel 3</strong>:&nbsp;Creación y asignación de Neumáticos a Unidades<br />\r\n<strong>\r\nNivel 4</strong>: Eliminar Neumáticos\r\n\r\n', 1, '2015-10-10 07:59:43', 'avalle', 0),
(186, 52, 62, 0, 0, '', 'Importa información de Torniquetes', '', '', '', '', 0, 0, 'AdminATM', '', '', '', 'Importa información de Torniquetes', 1, 'Nivel 1: Requerido', 1, '2015-09-11 16:00:37', 'avalle', 0),
(187, 52, 60, 0, 0, '', 'Consulta Tarjetas Vendidas', '', '', '', '', 0, 0, 'AdminConsultaATMTar', '', '', '', '', 1, '\r\nNivel 1: Requerido\r\n', 1, '2015-09-17 15:04:30', 'avalle', 0),
(188, 70, 71, 0, 0, '', 'Folios Correspondencia', '', '', '', '', 0, 0, 'AdminCorres', '', '', '', 'Acceso al sistema de folios de correspondencia', 3, 'Nivel 1: Consulta de registros<br />\r\nNivel 2: Creación y edición<br />\r\nNivel 3: Borrado de registros', 1, '2015-09-22 11:53:21', 'avalle', 0);
INSERT INTO `adm_modulos` (`id`, `idcata`, `idcatb`, `orden`, `tipo`, `grupo`, `nombre`, `tabla`, `tablaimg`, `dirimg`, `dirimgtotal`, `fotoimg`, `prefijoimg`, `modulo`, `extra`, `acceso`, `recurso`, `descripcion`, `maxniveles`, `niveles`, `status`, `ultactfec`, `ultactusu`, `scan`) VALUES
(193, 55, 56, 0, 0, '', 'Comentarios en Capital Humano', '', '', '', '', 0, 0, 'AdminPoperaComs', '', '', '', 'Permite ver, editar y/o borrar comentarios en el Capital humano', 4, '<strong>\r\nNivel 1</strong>: Consulta<br />\r\n<strong>\r\nNivel 2:</strong> Creación de Comentarios<br />\r\n<strong>\r\nNivel 3:</strong> Editar Comentarios<br />\r\n<strong>\r\nNivel 4:</strong> Borrar Comentarios\r\n', 1, '2015-11-13 14:07:10', 'avalle', 0),
(194, 55, 56, 0, 0, '', 'Permite editar personal ya contratado', '', '', '', '', 0, 0, 'AdminPoperaSupered', '', '', '', 'Permite editar personal ya contratado', 2, '\r\n<strong>\r\nNivel 1:</strong> Editar solo la información financiera<br />\r\n<strong>Nivel 2:</strong> Editar todo el perfil', 1, '2015-12-01 23:59:55', 'avalle', 0),
(195, 52, 72, 0, 0, '', 'Exportar Neumáticos Asignados', '', '', '', '', 0, 0, 'AdminllantasExp', '', '', '', 'Permite exportar los neumaticos asignados', 1, '<strong>\r\nNivel 1:</strong> Requerido\r\n', 1, '2015-12-12 10:35:23', 'avalle', 0),
(196, 63, 65, 0, 0, '', 'Aplicación Acceso Principal', '', '', '', '', 0, 0, 'AdminAcceso', '', '', '', 'Permite utilizar la appDirecto de Acceso a puerta principal y Acceso desde el módulo de herramientas.', 3, '\r\n<p><strong>Nivel 1:</strong> Acceso y captura.<br />\r\n<strong>\r\nNivel 2:</strong> Permite dar salida a la gente.<br />\r\n<strong>\r\nNivel 3:</strong> Permite eliminar registros.</p>\r\n', 1, '2015-12-18 15:47:57', 'avalle', 0),
(197, 52, 60, 0, 0, '', 'Exportar Bitacora de Aceite', '', '', '', '', 0, 0, 'AdminCapOilEx', '', '', '', 'Permite exportar a Excel los datos de Aceite', 1, '\r\n<strong>Nivel 1:</strong> Requerido\r\n', 1, '2015-12-30 14:52:21', 'avalle', 0),
(198, 52, 60, 0, 0, '', 'Capturar Ingreso Aceite', '', '', '', '', 0, 0, 'AdminIngOil', '', '', '', '', 3, '<strong>\r\nNivel 1:</strong> Consulta<br />\r\n<strong>\r\nNivel 2:</strong> Capturar y Editar \r\nRegistros<br />\r\n<strong>\r\nNivel 3:</strong> Borrar<br />\r\n\r\n\r\n', 1, '2015-12-30 14:52:30', 'avalle', 0),
(199, 52, 60, 0, 0, '', 'Permite ver costos en Ingresos de Aceite', '', '', '', '', 0, 0, 'AdminIngOilC', '', '', '', '', 1, '<strong>Nivel 1:</strong> Requerido\r\n\r\n', 1, '2015-12-30 14:52:43', 'avalle', 0),
(200, 52, 60, 0, 0, '', 'Captura de Aceite', '', '', '', '', 0, 0, 'AdminCapOil', '', '', '', 'Captura de Aceite', 3, '\r\n<div><strong>Nivel 1</strong>: Requerido&nbsp;\r\n</div>\r\n<div><strong>Nivel 2</strong>: Creación y edición\r\n</div>\r\n<div><strong>Nivel 3</strong>: Borrado de registros\r\n</div>\r\n\r\n\r\n', 1, '2015-12-30 14:54:58', 'avalle', 0),
(201, 26, 29, 0, 0, '', 'Consultar todas las polizas', '', '', '', '', 0, 0, 'AdminPolizaAcceso', '', '', '', 'Con este permiso, el usuario puede consultar cualquier poliza creada, incluso si no fuera el creador', 1, 'Nivel 1: Requerido', 1, '2016-01-29 15:40:16', 'avalle', 0),
(202, 52, 54, 0, 0, '', 'Catálogo de Estaciones, Rutas y sub rutas', '', '', '', '', 0, 0, 'AdminUnidadesCattra', '', '', '', 'Catálogo de Estaciones, Rutas y sub rutas, Tipo de servicios de Rol, Razones de cambio de operador', 3, '\r\n<p><strong>Nivel 1</strong>: Consulta<br />\r\n<strong>Nivel 2:</strong> Creación y edici[on<br />\r\n<strong>Nivel 3</strong>: Borrado de registros</p>\r\n\r\n\r\n', 1, '2016-09-19 23:10:55', 'avalle', 0),
(203, 52, 68, 0, 0, '', 'Exportar Mantenimiento', '', '', '', '', 0, 0, 'AdminMantoEx', '', '', '', 'Exportar información de Mantenimiento', 1, '<strong>\r\nNivel 1:</strong> Requerido\r\n', 1, '2016-02-18 16:40:26', 'avalle', 0),
(204, 55, 57, 0, 0, '', 'Catalogo de posiciones', '', '', '', '', 0, 0, 'AdminPosicion', '', '', '', 'Permite acceder al catalogo de posiciones', 3, '<strong>\r\nNivel 1:</strong> Consulta<br />\r\n<strong>\r\nNivel 2:</strong> Crear y editar registros<br />\r\n<strong>\r\nNivel 3:</strong> Borrar registros\r\n', 1, '2016-02-23 15:58:11', 'avalle', 0),
(205, 55, 56, 0, 0, '', 'Permite agregar posición', '', '', '', '', 0, 0, 'AdminSelPosicion', '', '', '', 'Permite agregar una posición al capital humano', 1, '\r\n<strong>\r\nNivel 1:</strong> Requerido\r\n\r\n', 1, '2016-08-09 13:46:58', 'avalle', 0),
(206, 35, 73, 0, 0, '', 'Acceso a Salidas', '', '', '', '', 0, 0, 'AdminSalidasInv', '', '', '', 'Acceso a Salidas de Inventario', 4, '<strong>\r\nNivel 1: </strong>Consulta de Salidas<br />\r\n<strong>\r\nNivel 2:</strong> Crear y Editar Registros<br />\r\n<strong>\r\nNivel 3:</strong> Regresar a modo de Edición<br />\r\n<strong>\r\nNivel 4:</strong> Borrar Salidas\r\n', 1, '2016-03-15 13:04:46', 'avalle', 0),
(207, 35, 73, 0, 0, '', 'Exportar Salidas', '', '', '', '', 0, 0, 'AdminSalidasInvExp', '', '', '', '', 1, '<strong>\r\nNivel 1:</strong> Requerido\r\n', 1, '2016-03-15 13:05:52', 'avalle', 0),
(208, 70, 74, 0, 0, '', 'Consulta Asistencias', '', '', '', '', 0, 0, 'AdminAsistencias', '', '', '', '', 1, '<strong>\r\nNivel 1:</strong> Requerido\r\n', 1, '2016-03-28 14:00:41', 'avalle', 0),
(209, 70, 74, 0, 0, '', 'Exportar reporte de Asistencias', '', '', '', '', 0, 0, 'AdminAsistenciasEx', '', '', '', 'Permite exportar el reporte de Asistencias', 1, '<strong>Nivel 1:</strong> Requerido', 1, '2016-03-28 14:01:43', 'avalle', 0),
(210, 70, 74, 0, 0, '', 'Importar información', '', '', '', '', 0, 0, 'AdminAsisImp', '', '', '', 'Permite acceder al control de asistencias e importar archivos planos para alimentar el reporte de asistencias', 1, '<strong>Nivel 1:</strong> Requerido', 1, '2016-03-28 14:03:06', 'avalle', 0),
(211, 70, 74, 0, 0, '', 'Permite eliminar dias de asistencias', '', '', '', '', 0, 0, 'AdminAsisEli', '', '', '', 'Permite acceder al control de asistencias y borrar un periodo de tiempo de asistencias', 1, '\r\n<strong>Nivel 1</strong>: Requerido\r\n', 1, '2016-03-28 14:53:45', 'avalle', 0),
(212, 70, 74, 0, 0, '', 'Recalcular Asistencias', '', '', '', '', 0, 0, 'AdminAsisCha', '', '', '', 'Permite acceder al control de asistencias y recalcular las asistencias de los empleados contratados', 1, '<strong>Nivel 1:</strong> Requerido', 1, '2016-03-28 14:05:32', 'avalle', 0),
(213, 70, 74, 0, 0, '', 'Periodos no laborables', '', '', '', '', 0, 0, 'AdminAsisNL', '', '', '', 'Acceso a los periodos no laborables los cuales impactan en el cálculo de asistencias de los empleados contratados', 3, '<strong>Nivel 1:</strong> Consulta<br />\r\n<strong>Nivel 2:</strong> Crear y Editar registros<br />\r\n<strong>Nivel 3:</strong> Eliminar Registros', 1, '2016-03-28 14:07:21', 'avalle', 0),
(214, 70, 74, 0, 0, '', 'Configuración de asistencias', '', '', '', '', 0, 0, 'AdminAsisAdmin', '', '', '', 'Permite establecer parámetros generales para el módulo de Asistencias', 1, '<strong>Nivel 1</strong>: Requerido', 1, '2016-03-28 14:08:33', 'avalle', 0),
(215, 70, 75, 0, 0, '', 'Consulta el reporte de Alimentos', '', '', '', '', 0, 0, 'AdminAlimentos', '', '', '', '', 1, '<strong>Nivel 1:</strong> Requerido', 1, '2016-03-28 14:09:06', 'avalle', 0),
(216, 70, 75, 0, 0, '', 'Permite exportar el reporte de Alimentos', '', '', '', '', 0, 0, 'AdminAlimentosEx', '', '', '', '', 1, '<strong>Nivel 1</strong>: Requerido', 1, '2016-03-28 14:09:53', 'avalle', 0),
(217, 70, 75, 0, 0, '', 'Permite importar información de alimentos', '', '', '', '', 0, 0, 'AdminAlimImp', '', '', '', 'Permite acceder al control de alimentos e importar archivos planos', 1, '<strong>Nivel 1</strong>: Requerido', 1, '2016-03-28 14:10:50', 'avalle', 0),
(218, 70, 75, 0, 0, '', 'Eliminar información de alimentos', '', '', '', '', 0, 0, 'AdminAlimEli', '', '', '', 'Permite acceder al control de alimentos y eliminar información de alimentos', 1, '<strong>Nivel 1:</strong> Requerido', 1, '2016-03-28 14:11:48', 'avalle', 0),
(219, 26, 29, 0, 0, '', 'Editar Poliza Automatica', '', '', '', '', 0, 0, 'AdminPolizaCatego', '', '', '', 'Edita poliza automatica de las polizas SIN IMPORTAR si estan cerradas, auditadas, etc.', 1, '<strong>\r\nNivel 1:</strong> Requerido\r\n', 1, '2016-04-05 19:33:04', 'avalle', 0),
(220, 52, 60, 0, 0, '', 'Parámetros de Aceite', '', '', '', '', 0, 0, 'AdminOiladmin', '', '', '', 'Permite cambiar los parámetros relativos al aceite', 1, '<strong>Nivel 1:</strong> Requerido', 1, '2016-04-07 12:58:43', 'avalle', 0),
(221, 52, 69, 0, 0, '', 'Ver costos en vista Aceite', '', '', '', '', 0, 0, 'AdminCapOilC', '', '', '', 'Permite ver costos en la vista de Salidas de aceite', 1, '<strong>Nivel 1:</strong> Requerido', 1, '2016-04-07 13:16:26', 'avalle', 0),
(222, 52, 60, 0, 0, '', 'Parámetros de AdBlue', '', '', '', '', 0, 0, 'AdminAdbadmin', '', '', '', 'Permite cambiar los parámetros relativos al adblue', 1, '<strong>Nivel 1:</strong> Requerido', 1, '2016-04-12 17:11:42', 'avalle', 0),
(223, 35, 76, 0, 0, '', 'Acceso al reporte de Costos por Eco', '', '', '', '', 0, 0, 'AdminRepCxeco', '', '', '', '', 1, '<strong>\r\nNivel 1:</strong> Requerido\r\n', 1, '2016-04-15 17:34:16', 'avalle', 0),
(224, 35, 37, 0, 0, '', 'Parámetros de Facturación', '', '', '', '', 0, 0, 'AdminDatosFac', '', '', '', '', 1, '<strong>\r\nNivel 1:</strong> Requerido\r\n', 1, '2016-04-17 19:04:38', 'avalle', 0),
(225, 35, 77, 0, 0, '', 'Ordenes de Compra', '', '', '', '', 0, 0, 'AdminOrdenesInv', '', '', '', 'Permite el acceso a las Ordenes de Compra', 5, '\r\n<strong>\r\nNivel 1</strong>: Consulta<br />\r\n<strong>\r\nNivel 2:</strong> Crear y edición de registros<br />\r\n<strong>\r\nNivel 3</strong>: Cancelar ordenes de Compra<br />\r\n<strong>\r\nNivel 4</strong>: Reabrir Ordenes<br />\r\n<strong>\r\nNivel 5</strong>: Borrar ordenes\r\n\r\n\r\n\r\n', 1, '2016-06-17 14:52:19', 'avalle', 0),
(226, 35, 77, 0, 0, '', 'Exportar Ordenes de compra', '', '', '', '', 0, 0, 'AdminOrdenesInvExp', '', '', '', 'Permite exportar las ordenes de compra', 1, '\r\n<strong>\r\nNivel 1</strong>: Requerido\r\n\r\n', 1, '2016-04-18 11:23:31', 'avalle', 0),
(227, 52, 66, 0, 0, '', 'Análisis de Reporte de Combustible', '', '', '', '', 0, 0, 'AdminRepRendCom', '', '', '', 'Permite acceder al reporte de análisis de combustible', 2, '<strong>\r\nNivel 1:</strong> Acceso y Consulta<br />\r\n<strong>\r\nNivel 2:</strong> Exportar Información\r\n', 1, '2016-04-21 12:32:28', 'avalle', 0),
(228, 52, 60, 0, 0, '', 'Archivos Incidencias', '', '', '', '', 0, 0, 'AdminIncidenciasArc', '', '', '', 'Permite trabajar con archivos para las incidencias', 3, '<strong>\r\nNivel 1:</strong> Consulta<br />\r\n<strong>\r\nNivel 2:</strong> Crear y editar<br />\r\n<strong>\r\nNivel 3:</strong> Borrar archivos\r\n', 1, '2016-04-21 17:11:39', 'avalle', 0),
(229, 35, 37, 0, 0, '', 'Facturas sin timbre fiscal', '', '', '', '', 0, 0, 'AdminFacturar', '', '', '', 'Permite consultar y generar facturas pero sin timbre fiscal', 4, '<strong>\r\nNivel 1:</strong> Consulta Facturas sin timbre<br />\r\n<strong>\r\nNivel 2:</strong> Permite Facturar sin timbrar<br />\r\n<strong>\r\nNivel 3:</strong> Permite cancelar facturas<br />\r\n<strong>\r\nNivel 4:</strong> Permite eliminar facturas\r\n', 1, '2016-04-25 09:25:59', 'avalle', 0),
(230, 35, 37, 0, 0, '', 'Generar CFDI', '', '', '', '', 0, 0, 'AdminCFDI', '', '', '', 'Consulta y administra CFDI', 3, '<strong>\r\nNivel 1:</strong> Consulta de CFDI<br />\r\n<strong>\r\nNivel 2:</strong> Permite generar CFDI<br />\r\n<strong>\r\nNivel 3:</strong> Permite cancelar CFDI\r\n', 1, '2016-04-25 09:29:04', 'avalle', 0),
(231, 52, 60, 0, 0, '', 'Ver última actualización de Incidencias', '', '', '', '', 0, 0, 'AdminIncidenciasView', '', '', '', '', 1, '<strong>Nivel 1:</strong> Requerido', 1, '2016-04-26 13:59:48', 'avalle', 0),
(232, 52, 60, 0, 0, '', 'Exportar Incidencias', '', '', '', '', 0, 0, 'AdminIncidenciasExp', '', '', '', 'Permite exportar el reporte de incidencias', 1, '<strong>Nivel 1:</strong> Requerido', 1, '2016-04-26 14:00:27', 'avalle', 0),
(233, 70, 78, 0, 0, '', 'Acceso a las Incapacidades', '', '', '', '', 0, 0, 'AdminIncapacidades', '', '', '', 'Acceso a las Incapacidades', 3, '\r\n<strong>\r\nNivel 1:</strong> Consultar<br />\r\n<strong>\r\nNivel 2:</strong> Crear y Editar registros<br />\r\n<strong>\r\nNivel 3:</strong> Borrado de registros\r\n\r\n\r\n', 1, '2016-05-06 17:56:26', 'avalle', 0),
(234, 70, 78, 0, 0, '', 'Archivos de Incapacidades', '', '', '', '', 0, 0, 'AdminIncapacidadesArc', '', '', '', 'Permite consultar, editar y/o borrar archivos de las incapacidades', 3, '<strong>Nivel 1:</strong> Consulta<br />\r\n<strong>Nivel 2:</strong> Crear y Editar<br />\r\n<strong>Nivel 3:</strong> Borrar', 1, '2016-05-06 17:53:17', 'avalle', 0),
(235, 70, 78, 0, 0, '', 'Exportar Incapacidades', '', '', '', '', 0, 0, 'AdminIncapacidadesExp', '', '', '', '', 1, '<strong>Nivel 1:</strong> Requerido', 1, '2016-05-06 17:53:51', 'avalle', 0),
(236, 70, 78, 0, 0, '', 'Catálogo de informacion Incapacidades', '', '', '', '', 0, 0, 'AdminIncapacidadesCat', '', '', '', 'Permite el acceso al catálogo de los objetos que se utilizan en Incapacidades.', 3, '<strong>Nivel 1:</strong> Consulta<br />\r\n<strong>Nivel 2:</strong> Creación y Edición<br />\r\n<strong>Nivel 3:</strong> Borrado', 1, '2016-05-06 17:55:29', 'avalle', 0),
(237, 52, 60, 0, 0, '', 'Auditor Bitacora de operación', '', '', '', '', 0, 0, 'AdminBitAuditor', '', '', '', 'Con este permiso, los cambios realizados en la bitácora de operación seran de un color diferente.', 1, '\r\n<strong>\r\nNivel 1:</strong> Requerido\r\n\r\n\r\n\r\n', 1, '2016-05-19 12:58:28', 'avalle', 0),
(238, 52, 72, 0, 0, '', 'Exportar el Inventario de Neumáticos', '', '', '', '', 0, 0, 'AdminllantasInvExp', '', '', '', '', 1, '<strong>Nivel 1:</strong> Requerido', 1, '2016-05-19 17:30:30', 'avalle', 0),
(239, 35, 51, 0, 0, '', 'Permite ver todas las ventas', '', '', '', '', 0, 0, 'AdminVentasAll', '', '', '', 'Permite ver todas las ventas creadas por cualquier vendedor', 1, '<strong>Nivel 1:</strong> Requerido', 1, '2016-05-23 09:06:12', 'avalle', 0),
(240, 52, 60, 0, 0, '', 'Incidencias Operación', '', '', '', '', 0, 0, 'AdminIncidenciasopera', '', '', '', 'Incidencias Operación', 3, 'Nivel 1: Consulta<br />\r\nNivel 2: Crear y editar<br />\r\nNivel 3: Borrar Registros', 1, '2016-05-26 11:07:10', 'avalle', 0),
(241, 52, 60, 0, 0, '', 'Archivos Incidencias Operación', '', '', '', '', 0, 0, 'AdminIncidenciasoperaArc', '', '', '', 'Permite trabajar con archivos para las incidencias', 3, '<div>Nivel 1: Consulta\r\n</div>\r\n<div>Nivel 2: Crear y editar\r\n</div>\r\n<div>Nivel 3: Borrar archivos\r\n</div>\r\n\r\n', 1, '2016-05-26 11:24:42', 'avalle', 0),
(242, 52, 60, 0, 0, '', 'Exportar Incidencias Operación', '', '', '', '', 0, 0, 'AdminIncidenciasoperaExp', '', '', '', 'Permite exportar el reporte de incidencias', 1, '<strong>Nivel 1:</strong> Requerido', 1, '2016-05-26 11:25:40', 'avalle', 0),
(243, 52, 60, 0, 0, '', 'Ver última actualización de Incidencias', '', '', '', '', 0, 0, 'AdminIncidenciasoperaView', '', '', '', 'Ver última actualización de Incidencias', 1, '<strong>Nivel 1:</strong> Requerido', 1, '2016-05-26 11:26:19', 'avalle', 0),
(244, 35, 73, 0, 0, '', 'Consulta el Inventario', '', '', '', '', 0, 0, 'AdminInventario', '', '', '', '', 2, '<strong>Nivel 1:</strong> Consulta<br />\r\n<strong>Nivel 2:</strong> Permite ver costos', 1, '2016-05-29 09:00:56', 'avalle', 0),
(245, 35, 79, 0, 0, '', 'Entradas al Inventario', '', '', '', '', 0, 0, 'AdminEntradasInv', '', '', '', 'Acceso a Entradas al Inventario', 4, '\r\n<p><strong>Nivel 1</strong>: Consulta de Entradas<br />\r\n<strong>Nivel 2:</strong> Creación y Edición<br />\r\n<strong>Nivel 3:</strong> Reabrir entradas<br />\r\n<strong>Nivel 4:</strong> Borrar entradas<br />\r\n<br />\r\n</p>\r\n', 1, '2016-06-20 08:42:42', 'avalle', 0),
(246, 35, 79, 0, 0, '', 'Ver todas las Entradas Inventario ', '', '', '', '', 0, 0, 'AdminEntradasInvAll', '', '', '', 'Permite trabajar con cualquier Entrada al Inventario', 1, '<strong>Nivel 1:</strong> Requerido', 1, '2016-05-30 22:09:16', 'avalle', 0),
(247, 35, 79, 0, 0, '', 'Permite Exportar las entradas al inventario', '', '', '', '', 0, 0, 'AdminEntradasInvExp', '', '', '', '', 1, '<strong>Nivel 1:</strong> Requerido', 1, '2016-05-30 22:10:05', 'avalle', 0),
(248, 35, 73, 0, 0, '', 'Parámetros Inventario', '', '', '', '', 0, 0, 'AdminDatosInv', '', '', '', 'Permite cambiar los parámetros del inventario', 1, '<strong>Nivel 1:</strong> Requerido', 1, '2016-06-01 13:32:39', 'avalle', 0),
(249, 52, 68, 0, 0, '', 'Polizas de Mantenimiento', '', '', '', '', 0, 0, 'AdminPolmanto', '', '', '', 'Permite el acceso a las polizas de mantenimiento, asi como la captura de Kilometrajes', 4, '<strong>Nivel 1:</strong> Consulta de registros<br />\r\n<strong>Nivel 2:</strong> Crear Nuevos Registros<br />\r\n<strong>Nivel 3:</strong> Editar Registros existentes<br />\r\n<strong>Nivel 4</strong>: Eliminar Registros', 1, '2016-06-25 08:09:36', 'avalle', 0),
(250, 35, 77, 0, 0, '', 'Permite ver todas las ordenes', '', '', '', '', 0, 0, 'AdminOrdenesInvAll', '', '', '', 'Usuarios SIN este permiso, solo podra ver las ordenes que esa misma persona genere', 1, '<strong>Nivel 1:</strong> Requerido', 1, '2016-06-27 11:00:10', 'avalle', 0),
(251, 52, 61, 0, 0, '', 'Permite reabrir Siniestros concluidos', '', '', '', '', 0, 0, 'AdminSiniestrosReabrir', '', '', '', '', 1, '<strong>Nivel 1:</strong> Requerido', 1, '2016-06-28 14:08:54', 'avalle', 0),
(252, 52, 72, 0, 0, '', 'Archivos en Neumáticos', '', '', '', '', 0, 0, 'AdminllantasInvArc', '', '', '', '', 3, '<strong>Nivel 1</strong>: Consulta de Archivos<br />\r\n<strong>Nivel 2</strong>: Crear y editar<br />\r\n<strong>Nivel 3</strong>: Borrar Archivo', 1, '2016-06-30 16:29:42', 'avalle', 0),
(253, 30, 31, 0, 0, '', 'Permite trabajar Archivos de clientes', '', '', '', '', 0, 0, 'AdminClientesArc', '', '', '', '', 3, '<strong>Nivel 1:</strong> Consulta de Archivos<br />\r\n<strong>Nivel 2:</strong> Creación y edición de Archivos<br />\r\n<strong>Nivel 3:</strong> Borrado de Archivos', 1, '2016-06-30 17:29:00', 'avalle', 0),
(254, 52, 68, 0, 0, '', 'Acceso a las tablas de Mantenimiento', '', '', '', '', 0, 0, 'AdminConfigManto', '', '', '', 'Permite el acceso a las tablas de mantenimiento para el calculo correcto de los mantenimientos en base a los km de las unidades.', 3, '<strong>Nivel 1:</strong> Consulta<br />\r\n<strong>Nivel 2:</strong> Crear y Editar registros<br />\r\n<strong>Nivel 3:</strong> Borrado de registros', 1, '2016-07-02 10:00:08', 'avalle', 0),
(255, 52, 68, 0, 0, '', 'Exportar Costos por Mantenimiento', '', '', '', '', 0, 0, 'AdminPolmantoEx', '', '', '', 'Permite exportar la información de los Costos por Mantenimiento.', 1, '<strong>Nivel 1:</strong> Requerido', 1, '2016-07-02 14:11:53', 'avalle', 0),
(256, 35, 37, 0, 0, '', 'Notas de Crédito', '', '', '', '', 0, 0, 'AdminNotaCredito', '', '', '', 'Permite Consultar o Generar Notas de Crédito', 3, '\r\n<strong>Nivel 1:</strong> Consulta<br />\r\n<strong>Nivel 2:</strong> Generar NC<br />\r\n<strong>Nivel 3:</strong> Cancelar NC\r\n', 1, '2016-07-07 01:33:00', 'avalle', 0),
(257, 15, 45, 0, 0, '', 'Acceso Archivos Pólizas Seguro', '', '', '', '', 0, 0, 'AdminPolsegArc', '', '', '', 'Acceso al apartado de los archivos en las pólizas de seguro', 3, '<strong>Nivel 1:</strong> Consulta<br />\r\n<strong>Nivel 2:</strong> Creación y edición<br />\r\n<strong>Nivel 3:</strong> Borrar archivos', 1, '2016-07-16 12:43:36', 'avalle', 0),
(258, 52, 61, 0, 0, '', 'Permite exportar Siniestros', '', '', '', '', 0, 0, 'AdminSiniestrosEx', '', '', '', '', 1, '<strong>Nivel 1:</strong> Requerido', 1, '2016-07-18 17:59:42', 'avalle', 0),
(259, 52, 69, 0, 0, '', 'Trabajar con Roles de operación', '', '', '', '', 0, 0, 'AdminRolopera', '', '', '', 'Permite trabajar con los roles de operación', 3, '<strong>Nivel 1:</strong> Consulta<br />\r\n<strong>Nivel 2:</strong> Crear nuevos y Edición<br />\r\n<strong>Nivel 3:</strong> Borrado', 1, '2016-07-21 16:51:46', 'avalle', 0),
(260, 52, 69, 0, 0, '', 'Permite aplicar posiciones del rol', '', '', '', '', 0, 0, 'AdminRoloperaAplicar', '', '', '', 'Es necesario tener el acceso a los roles de operación', 1, '<strong>Nivel 1</strong>: Requerido', 1, '2016-07-21 16:52:30', 'avalle', 0),
(261, 55, 56, 0, 0, '', 'Permite consultar el log de Cambios', '', '', '', '', 0, 0, 'AdminPoperaLog', '', '', '', '', 1, '<strong>Nivel 1:</strong> Requerido', 1, '2016-07-31 11:03:53', 'avalle', 0),
(262, 52, 62, 0, 0, '', 'Parámetros de Combustible', '', '', '', '', 0, 0, 'AdminConfigCom', '', '', '', '', 1, '<strong>Nivel 1:</strong> Requerido', 1, '2016-08-01 20:25:00', 'avalle', 0),
(263, 55, 56, 0, 0, '', 'Acceso información confidencial', '', '', '', '', 0, 0, 'AdminPoperaConf', '', '', '', 'Permite el acceso a información confidencial', 4, '<div><strong>Nivel 1:</strong> Consulta\r\n</div>\r\n<div><strong>Nivel 2:</strong> Crear Información\r\n</div>\r\n<div><strong>Nivel 3</strong>: EditarInformación\r\n</div>\r\n<div><strong>Nivel 4</strong>: Borrar información\r\n</div>\r\n\r\n', 1, '2016-08-02 16:18:56', 'avalle', 0),
(264, 52, 60, 0, 0, '', 'Incidencias Redes Sociales', '', '', '', '', 0, 0, 'AdminIncidenciasRedes', '', '', '', 'Incidencias de Operadores', 3, '<strong>\r\nNivel 1:</strong> Consulta de Registros<br />\r\n<strong>\r\nNivel 2:</strong> Creación y Edición<br />\r\n<strong>\r\nNivel 3:</strong> Borrado\r\n', 1, '2015-02-06 22:36:14', 'avalle', 0),
(265, 52, 60, 0, 0, '', 'Archivos Incidencias Redes', '', '', '', '', 0, 0, 'AdminIncidenciasRedesArc', '', '', '', 'Permite trabajar con archivos para las incidencias de redes sociales', 3, '<strong>\r\nNivel 1:</strong> Consulta<br />\r\n<strong>\r\nNivel 2:</strong> Crear y editar<br />\r\n<strong>\r\nNivel 3:</strong> Borrar archivos\r\n', 1, '2016-04-21 17:11:39', 'avalle', 0),
(266, 52, 60, 0, 0, '', 'Ver última actualización de Incidencias Redes', '', '', '', '', 0, 0, 'AdminIncidenciasRedesView', '', '', '', '', 1, '<strong>Nivel 1:</strong> Requerido', 1, '2016-04-26 13:59:48', 'avalle', 0),
(267, 52, 60, 0, 0, '', 'Exportar Incidencias Redes sociales', '', '', '', '', 0, 0, 'AdminIncidenciasRedesExp', '', '', '', 'Permite exportar el reporte de incidencias de redes sociales', 1, '\r\n<strong>Nivel 1:</strong> Requerido\r\n', 1, '2016-09-29 16:51:22', 'avalle', 0),
(268, 52, 60, 0, 0, '', 'Catalogo de Incidencias', '', '', '', '', 0, 0, 'AdminIncidenciasRedesC', '', '', '', 'Acceso al catalogo de Incidencias', 3, '\r\n<strong>Nivel 1:</strong>&nbsp;Consulta&nbsp;<br />\r\n<strong>Nivel 2:</strong> Creación y Edición<br />\r\n<strong>Nivel 3</strong>: Borrado de registros\r\n', 1, '2016-08-11 17:58:42', 'avalle', 0),
(269, 52, 54, 0, 0, '', 'Permite manejar proyectos', '', '', '', '', 0, 0, 'AdminProyectos', '', '', '', 'En un proyecto conviven las estaciones, rutas y sub rutas', 3, '\r\n<p><strong>Nivel 1:</strong> Consulta<br />\r\n<strong>\r\nNivel 2:</strong> Creacion y Edicion de registros<br />\r\n<strong>\r\nNivel 3:</strong> Borrado de registros</p>\r\n', 1, '2016-09-19 23:13:22', 'avalle', 0),
(270, 52, 68, 0, 0, '', 'Notas de Crédito a Pólizas de Manto', '', '', '', '', 0, 0, 'AdminPolmantoNC', '', '', '', 'Notas de Crédito a Pólizas de Mantenimiento y BALANCE', 3, '<strong>Nivel 1:</strong> Consulta de Registros<br />\r\n<strong>Nivel 2:</strong> Creación y edición<br />\r\n<strong>Nivel 3:</strong> Borrado de registros', 1, '2016-09-22 13:18:33', 'avalle', 0),
(271, 52, 80, 0, 0, '', 'Incidencias de Operación', '', '', '', '', 0, 0, 'AdminCOIncidencias', '', '', '', 'Permite el acceso a las Incidencias de Operación', 5, '\r\n<strong>Nivel 1:</strong> Consulta de Incidencias\r\n<br />\r\n<strong>Nivel 2:</strong> Crear archivos y Editarlos y Asignarlos\r\n<br />\r\n<strong>Nivel 3:</strong> Reabrir registros asignados\r\n<br />\r\n<strong>Nivel 4:</strong> Cerrar Incidencias\r\n<br />\r\n<strong>Nivel 5:</strong> Borrar registros\r\n\r\n\r\n', 1, '2017-09-02 09:09:15', 'avalle', 0),
(272, 52, 80, 0, 0, '', 'Archivos de Incidencias de Operación', '', '', '', '', 0, 0, 'AdminCOIncidenciasArc', '', '', '', 'Permite el acceso a los archivos en las incidencias de Comite de Operación', 3, '\r\n<strong>Nivel 1:</strong> Consulta de Archivos<br />\r\n<strong>Nivel 2:</strong> Creación y edición<br />\r\n<strong>Nivel 3:</strong> Borrado de Archivos\r\n', 1, '2016-10-11 18:26:23', 'avalle', 0),
(273, 52, 80, 0, 0, '', 'Acceso a Sesiones de Comite', '', '', '', '', 0, 0, 'AdminSesiones', '', '', '', 'Permite el acceso a las sesiones de comite utilizadas en las Incidencias de Comite de Operación', 3, '<strong>Nivel 1: </strong>Consulta de registros.<br />\r\n<strong>Nivel 2:</strong> Creación y edición de registros<br />\r\n<strong>Nivel 3:</strong> Borrado de registros', 1, '2016-10-11 18:27:55', 'avalle', 0),
(274, 52, 80, 0, 0, '', 'Acceso Incidencia de Operación Área', '', '', '', '', 0, 0, 'AdminCOIncidenciasArea', '', '', '', 'Permite acceder a las  Incidencia de operación a nivel de Área', 3, '\r\n<strong>Nivel 1:</strong> Consulta<br />\r\n<strong>Nivel 2:</strong> Permite agregar comentarios de seguimiento<br />\r\n<strong>Nivel 3:</strong> Permite Cerrar Incidencia a nivel área\r\n', 1, '2016-10-21 18:12:11', 'avalle', 0),
(275, 55, 56, 0, 0, '', 'Permite cambiar la Gerencia', '', '', '', '', 0, 0, 'AdminPoperaGerencia', '', '', '', 'Permite cambiar la Gerecnia del personal de Capital Humano', 1, '<strong>Nivel 1:</strong> Requerido', 1, '2016-11-03 12:44:52', 'avalle', 0),
(276, 52, 60, 0, 0, '', 'Permite imprimir Rol de Operación', '', '', '', '', 0, 0, 'AdminUnidadesRol', '', '', '', 'Permite imprimir Rol de Operación', 3, '\r\n<strong>Nivel 1</strong>: Requerido\r\n\r\n<br />\r\n<strong>\r\nNivel 2</strong>: Crear nuevos Roles<br />\r\n<strong>\r\nNivel 3</strong>: Borrar\r\n', 1, '2018-04-13 12:12:50', 'avalle', 0),
(277, 30, 32, 0, 0, '', 'Archivos en proveedores', '', '', '', '', 0, 0, 'AdminProveedoresArc', '', '', '', '', 3, '<strong>Nivel 1:</strong> Consulta de Archivos<br />\r\n<strong>Nivel 2:</strong> Crear y Editar Archivos<br />\r\n<strong>Nivel 3:</strong> Borrar Archivos', 1, '2016-11-24 17:26:39', 'avalle', 0),
(278, 52, 68, 0, 0, '', 'Archivos en Facturas NC', '', '', '', '', 0, 0, 'AdminPolmantoNCArc', '', '', '', '', 3, '<strong>Nivel 1</strong>: Consulta<br />\r\n<strong>Nivel 2</strong>: Crear y editar<br />\r\n<strong>Nivel 3</strong>: Borrar archivos', 1, '2016-11-26 09:18:31', 'avalle', 0),
(279, 52, 80, 0, 0, '', 'Exportar Incidencias Comite de Operación', '', '', '', '', 0, 0, 'AdminCOIncidenciasExp', '', '', '', '', 1, '<strong>Nivel 1</strong>: Requerido', 1, '2016-12-15 11:57:04', 'avalle', 0),
(280, 52, 81, 0, 0, '', 'Acceso módulo Venta Tarjetas', '', '', '', '', 0, 0, 'AdminDataTarjetas', '', '', '', '', 3, '<strong>Nivel 1</strong>: Consulta<br />\r\n<strong>Nivel 2</strong>: Edición y creación de registros<br />\r\n<strong>NIvel 3</strong>: Borrado de registros', 1, '2016-12-15 12:00:18', 'avalle', 0),
(281, 52, 81, 0, 0, '', 'Acceso módulo Acceso Usuarios', '', '', '', '', 0, 0, 'AdminDataUsuarios', '', '', '', '', 3, '<strong>Nivel 1</strong>: Consulta<br />\r\n<strong>Nivel 2</strong>: Edición y creación de registros<br />\r\n<strong>NIvel 3</strong>: Borrado de registros\r\n\r\n', 1, '2016-12-15 12:01:51', 'avalle', 0),
(282, 26, 29, 0, 0, '', 'Permite mover status de polizas', '', '', '', '', 0, 0, 'AdminPolizaStatus', '', '', '', 'Permiso administrativo para mover Status en polizas, es decir; regresar al status anterior', 1, '<strong>\r\nNivel 1:</strong> Requerido\r\n', 1, '2016-12-16 15:56:06', 'avalle', 0),
(283, 26, 29, 0, 0, '', 'Exportar Pólizas de egreso', '', '', '', '', 0, 0, 'AdminPolizaExp', '', '', '', '', 1, '<strong>Nivel 1</strong>: Requerido', 1, '2016-12-18 19:22:25', 'avalle', 0),
(284, 26, 29, 0, 0, '', 'Permite Imprimir polizas de egreso', '', '', '', '', 0, 0, 'AdminPolizaImp', '', '', '', '', 1, '<strong>Nivel 1</strong>: Requerido', 1, '2016-12-18 19:42:15', 'avalle', 0),
(285, 22, 23, 0, 0, '', 'Acceder a Categorias de Archivos generales', '', '', '', '', 0, 0, 'AdminCatArchivos', '', '', '', 'Permite trabajar con las categorias de los archivos generales, es dependiente del modulo desde donde accese', 3, '<strong>Nivel 1:</strong> Consulta<br />\r\n<strong>Nivel 2:</strong> Creación y edición<br />\r\n<strong>Nivel 3:</strong> Borrado de categorías', 1, '2016-12-22 00:45:44', 'avalle', 0),
(286, 52, 82, 0, 0, '', 'Acceso a los archivos generales', '', '', '', '', 0, 0, 'AdminArcUnidades', '', '', '', 'Permite acceder a los archivos generales del módulo', 3, '<strong>Nivel 1:</strong> Consulta<br />\r\n<strong>Nivel 2:</strong> Creación y edición<br />\r\n<strong>Nivel 3:</strong> Borrado', 1, '2016-12-22 01:06:59', 'avalle', 0),
(287, 30, 83, 0, 0, '', 'Acceso a los archivos generales', '', '', '', '', 0, 0, 'AdminArcCatalogos', '', '', '', 'Permite acceder a los archivos generales del módulo', 3, '<strong>Nivel 1:</strong> Consulta<br />\r\n<strong>Nivel 2:</strong> Creación y edición<br />\r\n<strong>Nivel 3:</strong> Borrado', 1, '2016-12-29 14:57:45', 'avalle', 0),
(288, 26, 29, 0, 0, '', 'Super Editor de Polizas', '', '', '', '', 0, 0, 'AdminPolizaSuperEditor', '', '', '', 'Permite editar polizas en cualquier status, pero bajo la regla de los cortes', 1, '<strong>Nivel 1:</strong> Requerido\r\n\r\n', 1, '2016-12-30 17:39:26', 'avalle', 0),
(289, 30, 83, 0, 0, '', 'Acceso a los archivos generales Operación', '', '', '', '', 0, 0, 'AdminArcOperacion', '', '', '', 'Permite acceder a los archivos generales del módulo', 3, '<strong>Nivel 1</strong>: Consulta<br />\r\n<strong>Nivel 2</strong>: Creación y Edición<br />\r\n<strong>Nivel 3</strong>: Borrado de archivos', 1, '2017-01-05 15:47:39', 'avalle', 0),
(290, 30, 83, 0, 0, '', 'Acceso a los archivos generales Capital Humano', '', '', '', '', 0, 0, 'AdminArcCH', '', '', '', 'Permite acceder a los archivos generales del módulo', 3, '<div><strong>Nivel 1</strong>: Consulta\r\n</div>\r\n<div><strong>Nivel 2</strong>: Creación y Edición\r\n</div>\r\n<div><strong>Nivel 3</strong>: Borrado de archivos\r\n</div>\r\n\r\n', 1, '2017-01-05 15:48:50', 'avalle', 0),
(291, 30, 83, 0, 0, '', 'Acceso a los archivos generales Finanzas', '', '', '', '', 0, 0, 'AdminArcFinanzas', '', '', '', 'Permite acceder a los archivos generales del módulo', 3, '<strong>Nivel 1</strong>: Consulta<br />\r\n<strong>Nivel 2</strong>: Creación y Edición<br />\r\n<strong>Nivel 3</strong>: Borrado', 1, '2017-01-05 15:51:42', 'avalle', 0),
(292, 52, 81, 0, 0, '', 'Parametros de medición', '', '', '', '', 0, 0, 'AdminDataParametros', '', '', '', 'Permite el acceso de los parámetros de medición', 3, '<strong>Nivel 1:</strong> Consulta<br />\r\n<strong>Nivel 2</strong>: Creación y Edición<br />\r\n<strong>Nivel 3</strong>: Borrado', 1, '2017-01-05 16:23:37', 'avalle', 0),
(293, 52, 81, 0, 0, '', 'Catalogo de parámetros de medición', '', '', '', '', 0, 0, 'AdminDataParametrosCat', '', '', '', 'Permite acceder al catálogo de parametros', 4, '\r\n<p><strong>Nivel 1:</strong> Consulta<br />\r\n<strong>Nivel 2:</strong> Creación y Edición<br />\r\n<strong>Nivel 3</strong>: Permite ver parametros de otros periodos<br />\r\n<strong>Nivel 4</strong>: Borrado</p>\r\n\r\n', 1, '2017-05-18 14:09:18', 'avalle', 0),
(294, 26, 29, 0, 0, '', 'Permite Cancelar Pólizas', '', '', '', '', 0, 0, 'AdminPolizaCancelar', '', '', '', '', 1, '<strong>Nivel 1:</strong> Requerido', 1, '2017-01-05 18:18:43', 'avalle', 0),
(295, 70, 84, 0, 0, '', 'Permite acceso a Actividades', '', '', '', '', 0, 0, 'AdminActividades', '', '', '', '', 3, '<strong>Nivel 1:</strong> Consulta<br />\r\n<strong>Nivel 2:</strong> Crear y Editar<br />\r\n<strong>Nivel 3:</strong> Borrado', 1, '2017-01-19 16:01:21', 'avalle', 0),
(296, 70, 84, 0, 0, '', 'Catalogo de las Actividades de Personal', '', '', '', '', 0, 0, 'AdminActividadesCat', '', '', '', 'Permite editar los catalogos del modulo de Actividades del Personal', 3, '<strong>Nivel 1:</strong> Consulta<br />\r\n<strong>Nivel 2:</strong> Creación y edición<br />\r\n<strong>Nivel 3:</strong> Borrado', 1, '2017-01-19 16:38:14', 'avalle', 0),
(297, 85, 86, 0, 0, '', 'Control de Folios de Tarjetas', '', '', '', '', 0, 0, 'AdminFinanzasFolios', '', '', '', 'Control de Folios de Tarjetas', 1, '<span style="color: rgb(0, 0, 0); font-family: &quot;Times New Roman&quot;; font-size: medium; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: normal; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; display: inline !important; float: none;">Nivel 1: Requerido</span>\r\n\r\n', 1, '2017-01-23 08:57:41', 'avalle', 0),
(298, 85, 86, 0, 0, '', 'Creación de Ciclos (semanas)', '', '', '', '', 0, 0, 'AdminFinanzasCiclos', '', '', '', 'Permite crear Ciclos o semanas necesarias para tesoreria', 1, '\r\n<strong style="color: rgb(0, 0, 0); font-family: " times="" new="" roman";="" font-size:="" medium;="" font-style:="" normal;="" font-variant-ligatures:="" font-variant-caps:="" letter-spacing:="" orphans:="" 2;="" text-align:="" start;="" text-indent:="" 0px;="" text-transform:="" none;="" white-space:="" widows:="" word-spacing:="" -webkit-text-stroke-width:="" 0px;"="">Nivel 1:</strong><span style="color: rgb(0, 0, 0); font-family: " times="" new="" roman";="" font-size:="" medium;="" font-style:="" normal;="" font-variant-ligatures:="" font-variant-caps:="" font-weight:="" letter-spacing:="" orphans:="" 2;="" text-align:="" start;="" text-indent:="" 0px;="" text-transform:="" none;="" white-space:="" widows:="" word-spacing:="" -webkit-text-stroke-width:="" display:="" inline="" !important;="" float:="" none;"="">&nbsp;Requerido</span>\r\n\r\n\r\n', 1, '2017-01-23 08:58:23', 'avalle', 0),
(299, 85, 87, 0, 0, '', 'Avisos de Tarjeta', '', '', '', '', 0, 0, 'AdminFinanzasAvisos', '', '', '', 'Permite acceder al modulo de Avisos de Tarjeta', 5, '<div style="color: rgb(0, 0, 0); font-family: &quot;Times New Roman&quot;; font-size: medium; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: normal; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px;"><strong>Nivel 1:</strong><span class="Apple-converted-space">&nbsp;</span>Consulta<br />\r\n<strong>Nivel 2:</strong><span class="Apple-converted-space"> </span>Creación y Edición de avisos (creados por el mismom usuario)\r\n</div>\r\n<div style="color: rgb(0, 0, 0); font-family: &quot;Times New Roman&quot;; font-size: medium; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: normal; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px;"><strong>Nivel 5:<span class="Apple-converted-space">&nbsp;</span></strong>Puede editar y borrar avisos de cualquier usuario\r\n</div>\r\n\r\n', 1, '2017-01-23 08:59:04', 'avalle', 0),
(300, 85, 88, 0, 0, '', 'Cargos', '', '', '', '', 0, 0, 'AdminFinanzasCargos', '', '', '', 'Permite acceder al modulo de Tesorería y Consultar /Editar Cargos (descontinuado)', 5, '<strong style="color: rgb(0, 0, 0); font-family: &quot;Times New Roman&quot;; font-size: medium; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px;">Nivel 1:&nbsp;</strong><span style="color: rgb(0, 0, 0); font-family: &quot;Times New Roman&quot;; font-size: medium; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: normal; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; display: inline !important; float: none;">Requerido</span><br style="color: rgb(0, 0, 0); font-family: &quot;Times New Roman&quot;; font-size: medium; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: normal; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px;" /><strong style="color: rgb(0, 0, 0); font-family: &quot;Times New Roman&quot;; font-size: medium; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px;">Nivel 2:&nbsp;</strong><span style="color: rgb(0, 0, 0); font-family: &quot;Times New Roman&quot;; font-size: medium; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: normal; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; display: inline !important; float: none;">Crear y borrar Cargos creados por el usuario</span><br style="color: rgb(0, 0, 0); font-family: &quot;Times New Roman&quot;; font-size: medium; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: normal; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px;" /><strong style="color: rgb(0, 0, 0); font-family: &quot;Times New Roman&quot;; font-size: medium; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px;">Nivel 3:&nbsp;</strong><span style="color: rgb(0, 0, 0); font-family: &quot;Times New Roman&quot;; font-size: medium; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: normal; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; display: inline !important; float: none;">Acceso a Consulta General de Cargos</span><br style="color: rgb(0, 0, 0); font-family: &quot;Times New Roman&quot;; font-size: medium; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: normal; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px;" /><strong style="color: rgb(0, 0, 0); font-family: &quot;Times New Roman&quot;; font-size: medium; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px;">Nivel 4:&nbsp;</strong><span style="color: rgb(0, 0, 0); font-family: &quot;Times New Roman&quot;; font-size: medium; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: normal; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; display: inline !important; float: none;">Permite editar Cargos desde la Consulta General</span><br style="color: rgb(0, 0, 0); font-family: &quot;Times New Roman&quot;; font-size: medium; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: normal; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px;" /><strong style="color: rgb(0, 0, 0); font-family: &quot;Times New Roman&quot;; font-size: medium; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px;">Nivel 5:&nbsp;</strong><span style="color: rgb(0, 0, 0); font-family: &quot;Times New Roman&quot;; font-size: medium; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: normal; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; display: inline !important; float: none;">Permite editar y borrar cargos especiales</span>\r\n\r\n', 1, '2017-01-23 08:59:45', 'avalle', 0),
(301, 85, 88, 0, 0, '', 'Tarjeta', '', '', '', '', 0, 0, 'AdminFinanzasTarjeta', '', '', '', 'Permite acceder al modulo de Tarjetas y trabajar con Tarjetas', 5, '<strong style="color: rgb(0, 0, 0); font-family: &quot;Times New Roman&quot;; font-size: medium; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px;">Nivel 1:&nbsp;</strong><span style="color: rgb(0, 0, 0); font-family: &quot;Times New Roman&quot;; font-size: medium; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: normal; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; display: inline !important; float: none;">Consulta de Tarjetas Impresas</span><br style="color: rgb(0, 0, 0); font-family: &quot;Times New Roman&quot;; font-size: medium; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: normal; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px;" /><strong style="color: rgb(0, 0, 0); font-family: &quot;Times New Roman&quot;; font-size: medium; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px;">Nivel 2:&nbsp;</strong><span style="color: rgb(0, 0, 0); font-family: &quot;Times New Roman&quot;; font-size: medium; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: normal; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; display: inline !important; float: none;">Puede crear e imprimir tarjetas</span><br style="color: rgb(0, 0, 0); font-family: &quot;Times New Roman&quot;; font-size: medium; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: normal; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px;" /><strong style="color: rgb(0, 0, 0); font-family: &quot;Times New Roman&quot;; font-size: medium; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px;">Nivel 3:&nbsp;</strong><span style="color: rgb(0, 0, 0); font-family: &quot;Times New Roman&quot;; font-size: medium; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: normal; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; display: inline !important; float: none;">Puede consultar el reporte de depositos</span><br style="color: rgb(0, 0, 0); font-family: &quot;Times New Roman&quot;; font-size: medium; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: normal; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px;" /><strong style="color: rgb(0, 0, 0); font-family: &quot;Times New Roman&quot;; font-size: medium; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px;">Nivel 5:&nbsp;</strong><span style="color: rgb(0, 0, 0); font-family: &quot;Times New Roman&quot;; font-size: medium; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: normal; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; display: inline !important; float: none;">Puede borrar tarjetas</span>\r\n\r\n', 1, '2017-01-23 09:00:20', 'avalle', 0),
(302, 85, 89, 0, 0, '', 'Revisar Solicitudes de Reimpresion', '', '', '', '', 0, 0, 'AdminFinanzasTarjetaSolicitudes', '', '', '', 'Permite acceder a las Solicitudes de reimpresion', 3, '<strong style="color: rgb(0, 0, 0); font-family: &quot;Times New Roman&quot;; font-size: medium; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px;">Nivel 1:&nbsp;</strong><span style="color: rgb(0, 0, 0); font-family: &quot;Times New Roman&quot;; font-size: medium; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: normal; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; display: inline !important; float: none;">Requerido</span><br style="color: rgb(0, 0, 0); font-family: &quot;Times New Roman&quot;; font-size: medium; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: normal; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px;" /><strong style="color: rgb(0, 0, 0); font-family: &quot;Times New Roman&quot;; font-size: medium; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px;">Nivel 3:</strong><span style="color: rgb(0, 0, 0); font-family: &quot;Times New Roman&quot;; font-size: medium; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: normal; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; display: inline !important; float: none;"><span class="Apple-converted-space">&nbsp;</span>Puede Borrar solicitudes</span>\r\n\r\n', 1, '2017-01-23 09:00:55', 'avalle', 0),
(303, 5, 6, 0, 0, '', 'Acceso a parametros del sistema', '', '', '', '', 0, 0, 'AdminTesoreriaAdmin', '', '', '', 'Acceso a los parámetros del sistema pertenecientes al area de Tesorería', 1, '<strong style="color: rgb(0, 0, 0); font-family: &quot;Times New Roman&quot;; font-size: medium; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px;">Nivel 1:<span class="Apple-converted-space">&nbsp;</span></strong><span style="color: rgb(0, 0, 0); font-family: &quot;Times New Roman&quot;; font-size: medium; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: normal; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; display: inline !important; float: none;">Requerido</span>\r\n\r\n', 1, '2017-01-23 09:01:29', 'avalle', 0),
(304, 52, 81, 0, 0, '', 'Permite reabrir captura de USUARIOS en BigData', '', '', '', '', 0, 0, 'AdminDataUeditor', '', '', '', 'Permite reabrir captura de usuarios en BigData', 1, '\r\n<strong>Nivel:</strong> Requerido\r\n\r\n', 1, '2017-02-17 12:20:00', 'avalle', 0),
(305, 52, 81, 0, 0, '', 'Editar tarjetas BigData', '', '', '', '', 0, 0, 'AdminDataTeditor', '', '', '', 'Este permiso es para otorgar la edición del registro de TARJETAS', 1, '\r\n<div style="text-align: left;"><strong>Nivel:</strong> 1 requerido\r\n</div>\r\n', 1, '2017-02-17 12:20:16', 'avalle', 0);
INSERT INTO `adm_modulos` (`id`, `idcata`, `idcatb`, `orden`, `tipo`, `grupo`, `nombre`, `tabla`, `tablaimg`, `dirimg`, `dirimgtotal`, `fotoimg`, `prefijoimg`, `modulo`, `extra`, `acceso`, `recurso`, `descripcion`, `maxniveles`, `niveles`, `status`, `ultactfec`, `ultactusu`, `scan`) VALUES
(306, 52, 62, 0, 0, '', 'Permiso para administrar periodos de nomina', '', '', '', '', 0, 0, 'AdminJornadasNom', '', '', '', 'Éste permiso otorga la creacion, edición y borrado de nuevas jornadas', 4, '<div>Nivel: 1 Consulta registro\r\n</div>\r\n<div>Nivel: 2 Edicion e inserción de registro\r\n</div>\r\n<div>Nivel: 3 Cerrar periodo\r\n</div>\r\n<div>Nivel: 4 Eliminar registro\r\n</div>\r\n\r\n', 1, '2017-09-02 08:43:57', 'avalle', 0),
(307, 63, 90, 0, 0, '', 'Catálogo para Bahías', '', '', '', '', 0, 0, 'AdminBahiasCat', '', '', '', 'Acceso al catálogo de Bahías', 3, '\r\n<strong>Nivel 1:</strong> Consulta<br />\r\n<strong>Nivel 2:</strong> Crear y editar<br />\r\n<strong>Nivel 3:</strong> Borrar\r\n\r\n', 1, '2017-02-23 02:04:08', 'avalle', 0),
(308, 63, 90, 0, 0, '', 'Acceso a Bahías', '', '', '', '', 0, 0, 'AdminBahias', '', '', '', 'Acceso al modulo de captura de acceso a las bahias', 3, '<div><strong>Nivel 1:</strong> Consulta<br />\r\n<strong>Nivel 2:</strong> Creación y registro de accesos<br />\r\n<strong>Nivel 3:</strong> Borrado de accesos\r\n</div>\r\n\r\n', 1, '2017-02-23 02:05:46', 'avalle', 0),
(309, 52, 60, 0, 0, '', 'Calificar Ciclos realizados', '', '', '', '', 0, 0, 'AdminCicCalif', '', '', '', 'Permite calificar ciclos realizados por jornada', 3, '<strong>Nivel 1:</strong> Consulta de modulos<br />\r\n<strong>Nivel 2:</strong> Permite calificar ciclos<br />\r\n<strong>Nivel 3:</strong> Permite Cerrar Jornada', 1, '2017-03-17 23:14:06', 'avalle', 0),
(310, 52, 60, 0, 0, '', 'Permite consultar Jornadas cerradas', '', '', '', '', 0, 0, 'AdminCicCalifCerr', '', '', '', 'Es necesario el permiso de Calificar Jornadas como mínimo en 1 (consulta) para acceder.', 2, '\r\n<strong>Nivel 1:</strong> Requerido\r\n<br />\r\n<strong>Nivel 2:</strong> Permite Revertir Cierres', 1, '2017-05-04 11:40:49', 'avalle', 0),
(311, 1, 91, 0, 0, '', 'Acceso a las solicitudes de Crédito', '', '', '', '', 0, 0, 'AdminSolCred', '', '', '', 'Acceso a las solicitudes de Crédito', 3, '<strong>Nivel 1:</strong> Consulta<br />\r\n<strong>Nivel 2:</strong> Crear y Editar Registros<br />\r\n<strong>Nivel 3:</strong> Borrado de registros<br />\r\n\r\n', 1, '2017-03-23 13:49:00', 'avalle', 0),
(312, 1, 91, 0, 0, '', 'Autorizar Solicitudes Estación 1', '', '', '', '', 0, 0, 'AdminSolCredAut1', '', '', '', 'Permite autorizar solicitudes en estación 1', 1, '<strong>Nivel 1:</strong> Requerido\r\n\r\n', 1, '2017-03-23 13:50:06', 'avalle', 0),
(313, 1, 91, 0, 0, '', 'Autorizar Solicitudes Estación 2', '', '', '', '', 0, 0, 'AdminSolCredAut2', '', '', '', 'Permite autorizar Solictudes de crédito en estación 2', 1, '<strong>Nivel 1:</strong> Requerido\r\n\r\n', 1, '2017-03-23 13:50:55', 'avalle', 0),
(314, 1, 91, 0, 0, '', 'Catálogos de Solicitudes de crédito', '', '', '', '', 0, 0, 'AdminSolCredCat', '', '', '', '', 3, '<strong>Nivel 1:</strong> Consulta de registros<br />\r\n<strong>Nivel 2:</strong> Creación y edición de registros<br />\r\n<strong>Nivel 3:</strong> Borrado de registros<br />\r\n\r\n', 1, '2017-03-23 13:52:03', 'avalle', 0),
(315, 55, 56, 0, 0, '', 'Acceso al estudio Socioeconómico', '', '', '', '', 0, 0, 'AdminCHEstudio', '', '', '', 'Acceso al estudio Socioeconómico del capital humano', 3, '<strong>Nivel 1:</strong> Consulta<br />\r\n<strong>Nivel 2:</strong> Creación y edición<br />\r\n<strong>Nivel 3:</strong> Borrado', 1, '2017-03-24 14:54:03', 'avalle', 0),
(316, 55, 56, 0, 0, '', 'Acceso CH Confidencial', '', '', '', '', 0, 0, 'AdminPoperaConfidencial', '', '', '', 'Permite el acceso a Expedientes de Capital Humano Confidencial', 1, '<strong>Nivel 1:</strong> Requerido', 1, '2017-04-06 15:25:11', 'avalle', 0),
(317, 35, 37, 0, 0, '', 'Generación CFDI Directo', '', '', '', '', 0, 0, 'AdminCFDIDir', '', '', '', 'Permite generar CFDI sin pasar por el catalogo de productos y servicios', 1, '<strong>Nivel 1:</strong> Requerido', 1, '2017-04-19 08:37:00', 'avalle', 0),
(318, 35, 37, 0, 0, '', 'Crear Facturas Directas', '', '', '', '', 0, 0, 'AdminFacturarDir', '', '', '', 'Permite fenerar Facturas de manera directa sin pasar por un intrumento previo', 1, '<strong>Nivel 1:</strong> Requerido', 1, '2017-04-19 08:38:33', 'avalle', 0),
(319, 30, 32, 0, 0, '', 'Permite editar RFC y Razón Social', '', '', '', '', 0, 0, 'AdminProveedoresRFC', '', '', '', 'Permite editar RFC y Razón Social', 1, '<strong>Nivel 1:</strong> Requerido', 1, '2017-04-21 18:35:40', 'avalle', 0),
(320, 1, 4, 0, 0, '', 'Administrar el Catalogo de Contratos', '', '', '', '', 0, 0, 'AdminContratoAdmin', '', '', '', 'Permite Administrar el Catálogo de Contratos, Subcontratos, caracteristicas, Tasa de amortización, etc.', 3, '<strong>Nivel 1:</strong> Consulta<br />\r\n<strong>Nivel 2:</strong> Creación y edición<br />\r\n<strong>Nivel 3:</strong> Borrado', 1, '2017-05-04 01:18:51', 'avalle', 0),
(321, 52, 92, 0, 0, '', 'Acceso General a Viajes', '', '', '', '', 0, 0, 'AdminViajes', '', '', '', 'Permite iniciar, editar, cancelar y borrar viajes', 4, '<p><strong>Nivel 1:</strong> Consulta</p>\r\n<p><strong>Nivel 2: </strong>Crear y Editar</p>\r\n<p><strong>Nivel 3:</strong> Cancelar</p>\r\n<p><strong>Nivel 4:</strong> Borrar</p>', 1, '2017-05-05 10:40:44', 'a.lopez', 0),
(322, 52, 92, 0, 0, '', 'Permite Reabrir Viajes en Curso', '', '', '', '', 0, 0, 'AdminViajeBack', '', '', '', 'Permite reabrir un viaje sin importar el estatus en el que se encuentre', 1, '\r\n<p><strong>Nivel 1:</strong>Requerido</p>', 1, '2017-05-05 11:13:27', 'a.lopez', 0),
(323, 52, 92, 0, 0, '', 'Permite Liquidar Viajes', '', '', '', '', 0, 0, 'AdminViajeLiq', '', '', '', 'Permite liquidar un viaje después de haber concluido el recorrido.', 1, '<strong>Nivel 1:</strong> Requerido', 1, '2017-05-05 11:40:13', 'a.lopez', 0),
(324, 52, 92, 0, 0, '', 'Acceso a los catálogos de Viajes Foráneos', '', '', '', '', 0, 0, 'AdminViajesCat', '', '', '', 'Acceso a los catálogos de Viajes Foráneos', 3, '<strong>Nivel 1:</strong> Consulta<br />\r\n<strong>Nivel 2</strong>: Creación y edición<br />\r\n<strong>Nivel 3:</strong> Borrado de registros', 1, '2017-05-05 18:48:56', 'avalle', 0),
(325, 52, 81, 0, 0, '', 'Permite alterar el monto final de parametros', '', '', '', '', 0, 0, 'AdminDataParamCambiaMontos', '', '', '', 'Permite alterar el monto final de parametros', 1, '<strong>Nivel 1:</strong> Requerido', 1, '2017-05-18 17:10:04', 'avalle', 0),
(326, 52, 81, 0, 0, '', 'Permite exportar Calificaciones', '', '', '', '', 0, 0, 'AdminDataParametrosEx', '', '', '', 'Permite exportar Calificaciones', 1, '<strong>Nivel 1:</strong> Requerido', 1, '2017-05-24 13:40:48', 'avalle', 0),
(327, 52, 69, 0, 0, '', 'Accesos a Patio', '', '', '', '', 0, 0, 'AdminPatio', '', '', '', 'Permite acceder al modulo de Ingresos al Patio', 4, '\r\n<p><strong>Nivel 1:</strong>Consulta<br />\r\n<strong>Nivel 2:</strong>Crear y editar<br />\r\n<strong>Nivel 3:</strong>Cancelar<br />\r\n<strong>Nivel 4:</strong>Borrar</p>\r\n\r\n\r\n', 1, '2017-09-02 09:06:02', 'avalle', 0),
(328, 52, 93, 0, 0, '', 'Acceder a las Campañas generales', '', '', '', '', 0, 0, 'AdminCampania', '', '', '', 'Permite crear nuevas campañas, agregar registros y cerrar una campaña en el momento que se desee.', 4, '<div><strong>Nivel 1: Consulta</strong>\r\n</div>\r\n<div><strong>Nivel 2: Crear y editar</strong>\r\n</div>\r\n<div><strong>Nivel 3: Cerrar Campañas</strong>\r\n</div>\r\n<div><strong>Nivel 4: Borrar</strong>\r\n</div>', 1, '2017-09-02 08:46:04', 'avalle', 0),
(329, 52, 93, 0, 0, '', 'Agrega registros a campañas', '', '', '', '', 0, 0, 'AdminCampaCap', '', '', '', 'Permite agregar registros a las campañas ya generadas, borrarlas y consultarlas', 3, '<div><strong>Nivel 1: Consulta</strong>\r\n</div>\r\n<div><strong>Nivel 2: Crear y editar</strong>\r\n</div>\r\n<div><strong>Nivel 3: Borrar</strong>\r\n</div>', 1, '2017-09-02 08:47:56', 'avalle', 0),
(330, 52, 93, 0, 0, '', 'Acceso a Catálogos de Campañas', '', '', '', '', 0, 0, 'AdminCampaCat', '', '', '', 'Permite ver, editar y eliminar Campañas a partir del nivel de usuario', 3, '<div><strong>Nivel 1: Consulta</strong>\r\n</div>\r\n<div><strong>Nivel 2: Crear y editar</strong>\r\n</div>\r\n<div><strong>Nivel 3: Borrar</strong>\r\n</div>', 1, '2017-09-02 08:47:10', 'avalle', 0),
(331, 52, 93, 0, 0, '', 'Seguimiento de campañas', '', '', '', '', 0, 0, 'AdminCampaGen', '', '', '', 'Permiso para seguimiento de campañas(Gerencia)', 1, '<strong>Nivel 1:</strong> Requerido\r\n\r\n', 1, '2017-06-16 18:48:13', 'a.lopez', 0),
(332, 52, 69, 0, 0, '', 'Permite ingresar al checklist', '', '', '', '', 0, 0, 'AdminPatiochk', '', '', '', 'Permite ver y editar el checklist de todas las unidades', 2, '\r\n<p><strong>Nivel 1:</strong>Consulta<br />\r\n<strong>Nivel 2:</strong>Limpiar Checklist</p>\r\n', 1, '2017-09-02 09:05:13', 'avalle', 0),
(333, 35, 94, 0, 0, '', 'Acceso a Traspasos entre Almacenes', '', '', '', '', 0, 0, 'AdminTraspasoInv', '', '', '', 'Acceso a Traspasos entre Almacenes', 4, '<strong>Nivel 1:&nbsp;</strong>Consulta de Salidas<br />\r\n<strong>Nivel 2:</strong>&nbsp;Crear y Editar Registros<br />\r\n<strong>Nivel 3:</strong>&nbsp;Regresar a modo de Edición<br />\r\n<strong>Nivel 4:</strong>&nbsp;Borrar Salidas\r\n\r\n\r\n', 1, '2017-07-20 11:41:35', 'avalle', 0),
(334, 35, 94, 0, 0, '', 'Exportar Traspasos', '', '', '', '', 0, 0, 'AdminTraspasoInvExp', '', '', '', '', 1, '<strong>Nivel 1:</strong>&nbsp;Requerido\r\n\r\n', 1, '2017-07-20 11:42:46', 'avalle', 0),
(335, 52, 68, 0, 0, '', 'Permite ver Costos en Manto', '', '', '', '', 0, 0, 'AdminMantoC', '', '', '', 'Permite ver Costos en el modulo de Mantenimiento', 1, '<strong>Nivel 1</strong>: Requerido', 1, '2017-08-10 12:22:07', 'avalle', 0),
(336, 52, 68, 0, 0, '', 'Permite trabajar con los archivos', '', '', '', '', 0, 0, 'AdminMantoArc', '', '', '', 'Permite trabajar con los archivos del modúlo de Mantenimiento', 3, '\r\n<strong>Nivel 1:</strong> Consulta de archivos<br />\r\n<strong>Nivel 2:</strong> Crear y editar archivos<br />\r\n<strong>Nivel 3:</strong> Borrado de archivos\r\n', 1, '2017-08-10 12:40:33', 'avalle', 0),
(337, 52, 68, 0, 0, '', 'Mantenimiento Presupuestos', '', '', '', '', 0, 0, 'AdminMantoPre', '', '', '', 'Permite el acceso al proceso de Presupuestos en Mantenimiento', 2, '<strong>Nivel 1:</strong> Consulta<br />\r\n<strong>Nivel 2:</strong> Iniciar Manto, Aceptar y Rechazar trabajos', 1, '2017-08-10 12:57:21', 'avalle', 0),
(338, 52, 68, 0, 0, '', 'Mantenimiento Ordenes', '', '', '', '', 0, 0, 'AdminMantoOrd', '', '', '', 'Permite el acceso al proceso de Ordenes', 3, '<strong>Nivel 1</strong>: Consulta<br />\r\n<strong>Nivel 2:</strong> Acceso a las acciones<br />\r\n<strong>Nivel 3:</strong> Regresar status', 1, '2017-08-10 13:06:26', 'avalle', 0),
(339, 52, 68, 0, 0, '', 'Mantenimiento Salidas', '', '', '', '', 0, 0, 'AdminMantoSal', '', '', '', 'Permite el acceso al proceso de salidas en Mantenimiento', 3, '\r\n<strong>Nivel 1:</strong> Consulta<br />\r\n<strong>Nivel 2: </strong>Acciones<br />\r\n<strong>Nivel 3:</strong> Reabrir Mantenimiento', 1, '2017-08-10 13:16:38', 'avalle', 0),
(340, 52, 60, 0, 0, '', 'Permite visualizar Bitacora de Operacion Ver 1', '', '', '', '', 0, 0, 'AdminBitacoraVer1', '', '', '', 'Permite visualizar Bitacora de Operacion Ver 1', 1, '\r\n<strong>Nivel 1:</strong> Requerido\r\n', 1, '2018-06-07 10:34:21', 'avalle', 0),
(341, 55, 56, 0, 0, '', 'Acceso Procedimientos Legales', '', '', '', '', 0, 0, 'AdminPoperaAct', '', '', '', 'Acceso a la sección de procedimientos legales; Actuaciones y Costos', 3, '<strong>Nivel 1:</strong> Consulta<br />\r\n<strong>Nivel 2:</strong> Creación y edición<br />\r\n<strong>Nivel 3:</strong> Borrado de registros', 1, '2017-08-24 13:06:59', 'avalle', 0),
(342, 52, 81, 0, 0, '', 'Acceso al Kiosko CEN', '', '', '', '', 0, 0, 'AdminKiosko', '', '', '', 'Acceso al Kiosko versión CEN', 1, '<strong>Nivel 1:</strong> Requerido', 1, '2017-09-21 14:32:46', 'avalle', 0),
(343, 30, 97, 0, 0, '', 'Administrador de Encuestas', '', '', '', '', 0, 0, 'AdminEncuesta', '', '', '', 'Permite el acceso, editar, crear y borrar encuestas.', 3, '<div><strong>Nivel 1: </strong>Creación\r\n</div>\r\n<div><strong>Nivel 2: </strong>Edición\r\n</div>\r\n<div><strong>Nivel 3: </strong>Borrado\r\n</div>', 1, '2017-10-06 17:47:21', 'a.lopez', 0),
(346, 35, 73, 0, 0, '', 'Exportar Inventario', '', '', '', '', 0, 0, 'AdminInventarioExp', '', '', '', 'Permite exportar inventario a Excel', 1, '<strong>Nivel 1:</strong> Requerido', 1, '2017-10-09 10:52:52', 'avalle', 0),
(344, 55, 56, 0, 0, '', 'Acceso a vista de encuestas de usuario', '', '', '', '', 0, 0, 'Encuestas', '', '', '', 'Permite borrar, editar, crear y mostrar encuestas para el usuario final.', 4, '<div><strong>Nivel 1:</strong> Lectura\r\n</div>\r\n<div><strong>Nivel 2:</strong> Creación\r\n</div>\r\n<div><strong>Nivel 3:</strong> Edición\r\n</div>\r\n<div><strong>Nivel 4:</strong> Borrado\r\n</div>\r\n\r\n', 1, '2017-10-06 17:45:22', 'a.lopez', 0),
(345, 70, 96, 0, 0, '', 'Módulo vacaciones', '', '', '', '', 0, 0, 'AdminVacaciones', '', '', '', 'Acceso Módulo vacaciones', 4, '\r\n<strong>Nivel 1:</strong> Consulta<br />\r\n<strong>Nivel 2: </strong>Creación y Edición<br />\r\n<strong>Nivel 3:</strong>&nbsp;Puede Guardar en cualquier momento<strong><br />\r\n</strong>\r\n<div><strong>Nivel 4:</strong> Borrar Registros\r\n</div>', 1, '2018-05-03 13:10:52', 'avalle', 0),
(347, 52, 80, 0, 0, '', 'Deshabilitar Incidencias', '', '', '', '', 0, 0, 'AdminAlertas', '', '', '', 'Permite Deshabilitar Incidencias', 1, '<strong>Nivel 1:</strong> Requerido', 1, '2017-10-12 18:11:40', 'avalle', 0),
(348, 35, 37, 0, 0, '', 'Catálogos CFDI', '', '', '', '', 0, 0, 'AdminCatCFDI', '', '', '', 'Permite agregar, editar y borrar catálogos para CFDI', 3, '<div><strong>Nivel 1:</strong> Lectura\r\n</div>\r\n<div><strong>Nivel 2:</strong> Edición\r\n</div>\r\n<div><strong>Nivel 3:</strong> Borrado\r\n</div>', 1, '2017-11-10 16:27:24', 'a.lopez', 0),
(349, 52, 60, 0, 0, '', 'Permite Crear Ciclos Extra', '', '', '', '', 0, 0, 'AdminAddCir', '', '', '', 'Permite Crear Ciclos Extra independientes a esquemas de operación.', 1, '<strong>Nivel 1: </strong>Requerido', 1, '2017-11-29 20:24:38', 'avalle', 0),
(350, 35, 76, 0, 0, '', 'Permite ver el reporte de Costo de Ventas', '', '', '', '', 0, 0, 'AdminCostoV', '', '', '', 'Permite ver el reporte de Costo de Ventas', 1, '<strong>Nivel 1:</strong> Requerido', 1, '2017-12-21 18:53:09', 'avalle', 0),
(351, 35, 76, 0, 0, '', 'Permite exportar el reporte de Costo de Ventas', '', '', '', '', 0, 0, 'AdminCostoVExp', '', '', '', 'Permite exportar el reporte de Costo de Ventas', 1, '<strong>Nivel 1:</strong> Requerido', 1, '2017-12-21 18:54:05', 'avalle', 0),
(353, 100, 101, 0, 0, '', 'Concesiones', '', '', '', '', 0, 0, 'AdminConcesiones', '', '', '', 'Permiso para tener control total en las Concesiones (este permiso incluye todos los demas relacionados a Concesiones).', 5, '\r\n<p>Nivel 1: Consulta<br />\r\nNivel 2: Puede generar trámites<br />\r\nNivel 3: Crear nuevas Concesiones<br />\r\nNivel 4: Puede limpiar Concesiones&nbsp;<br />\r\nNivel 5: Permite Borrar</p>\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n', 1, '2018-03-09 12:52:11', 'avalle', 0),
(354, 100, 102, 0, 0, '', 'Acceso a los catálogos de concesiones', '', '', '', '', 0, 0, 'AdminConcesionesCatalogos', '', '', '', 'Permiso para alterar los catálogos que tienen que ver con las concesiones (Status, Trámites, Bases, Vehículos, Marcas, etc.)', 1, '\r\n<p>Nivel 1: Requerido<br />\r\n</p>\r\n', 1, '2018-01-05 17:28:34', 'avalle', 0),
(355, 100, 101, 0, 0, '', 'Concesiones Mensajes Log', '', '', '', '', 0, 0, 'AdminConcesionesMsg', '', '', '', 'Permite visualizar y agregar Mensajes tipo log en el modulo de Concesiones', 1, '\r\nNivel 1: Requerido\r\n', 1, '2018-01-05 17:28:58', 'avalle', 0),
(356, 100, 101, 0, 0, '', 'Pagos Concesiones', '', '', '', '', 0, 0, 'AdminConcesionesPago', '', '', '', 'Permiso para poder agregar o modificar Pagos en el tramite de las concesiones.', 5, '\r\n<p>Nivel 1: Permite capturar montos<br />\r\nNivel 2: Permite Capturar Bancos y Fecha de Pago<br />\r\nNivel 5: Permite editar todo y puede habilitar el pago</p>\r\n\r\n\r\n\r\n', 1, '2018-01-05 17:27:12', 'avalle', 0),
(357, 100, 101, 0, 0, '', 'Permisos Concesiones', '', '', '', '', 0, 0, 'AdminConcesionesPermisos', '', '', '', 'Permiso para agregar y editar permisos en los tramites de las concesiones.', 1, '\r\nNivel 1: Requerido\r\n', 1, '2018-01-05 17:27:33', 'avalle', 0),
(358, 100, 104, 0, 0, '', 'Socios', '', '', '', '', 0, 0, 'AdminSocios', '', '', '', 'Permite el acceso a la sección de Socios', 7, '\r\n<p>Nivel 1: Solo consulta.<br />\r\nNivel 2: Permite Crear y edición de registros ya existentes, solo campos de teléfonos y correos.<br />\r\nNivel 3: Permite la edición de registros ya existentes, todos los campos excepto Nombre, eco y fechas.<br />\r\nNivel 4: Permite Crear Históricos.<br />\r\nNivel 5: Permite edición total.<br />\r\nNivel 6: Permite Reactivar<br />\r\nNivel 7: Borrar registros</p>\r\n\r\n\r\n\r\n', 1, '2018-03-23 17:39:59', 'avalle', 0),
(359, 100, 104, 0, 0, '', 'Socios Imágenes', '', '', '', '', 0, 0, 'AdminSociosImg', '', '', '', 'Permite la edición de Imágenes del modulo de Socios', 3, '\r\nNivel 1: Requerido lectura<br />\r\nNivel 2: Edición y creación<br />\r\nNivel 3: Borrado\r\n', 1, '2018-02-01 13:27:54', 'a.lopez', 0),
(360, 52, 72, 0, 0, '', 'Costos de Inventarios', '', '', '', '', 0, 0, 'AdminllantasInvC', '', '', '', 'Permite visualizar los costos de Neumáticos', 1, '<strong>Nivel 1:</strong> Requerido', 1, '2018-01-04 18:51:09', 'avalle', 0),
(361, 52, 80, 0, 0, '', 'Catalogo Incidencias Comite de Operación Área', '', '', '', '', 0, 0, 'AdminCOIncidenciasCat', '', '', '', 'Catalogo Incidencias Comite de Operación Área', 1, 'Nivel 1: Requerido', 1, '2018-01-26 19:15:24', 'avalle', 0),
(362, 100, 104, 0, 0, '', 'Socios Documentación', '', '', '', '', 0, 0, 'AdminSociosDoc', '', '', '', 'Permite ver el modulo de documentación de contratación del socio', 3, '\r\n<p>Nivel 1: Solo lectura<br />\r\nNivel 2: Edición<br />\r\nNivel 3: Borrado</p>\r\n', 1, '2018-02-01 13:27:10', 'a.lopez', 0),
(363, 100, 105, 0, 0, '', 'Acceso General para Arrendatarios', '', '', '', '', 0, 0, 'AdminArrendatario', '', '', '', 'Ingreso al módulo general de arrendatarios', 5, '\r\nNivel 1: Requerido, solo lectura<br />\r\nNivel 2: Creación de arrendatarios y edición limitada<br />\r\nNivel 3: Edición completa y permite generar históricos<br />\r\nNivel 4: Permite Reactivar<br />\r\n<div>\r\nNivel 5: Borrado\r\n\r\n</div>\r\n', 1, '2018-07-26 23:13:38', 'avalle', 0),
(364, 100, 105, 0, 0, '', 'Acceso a los archivos del arrendatario', '', '', '', '', 0, 0, 'AdminArrendatarioArc', '', '', '', 'Permite subir, eliminar y editar archivos', 3, '\r\n<p>Nivel 1: Requerido, solo lectura<br />\r\nNivel 2: Edición y cargar archivos<br />\r\nNivel 3: Borrado de archivos</p>\r\n', 1, '2018-02-01 13:28:31', 'a.lopez', 0),
(365, 100, 105, 0, 0, '', 'Documentación del arrendatario', '', '', '', '', 0, 0, 'AdminArrendatarioDoc', '', '', '', 'Acceso a toda la documentación del arrendatario, crear nueva documentación, edición o borrado de la misma.', 3, '\r\nNivel 1: Requerido, solo lectura<br />\r\nNivel 2: Edición y creación<br />\r\nNivel 3: Borrado', 1, '2018-02-01 13:28:39', 'a.lopez', 0),
(366, 26, 28, 0, 0, '', 'Catálogo de Tipo de Presupuestos', '', '', '', '', 0, 0, 'AdminCatalogoPresupuestos', '', '', '', 'Acceso al catálogo de tipo de presupuestos en el menu Catálogos', 3, '\r\n<p>Nivel 1: Requerido<br />\r\nNivel 2: Creación y Edición<br />\r\nNivel 3: Borrado</p>\r\n', 1, '2018-02-01 16:21:56', 'a.lopez', 0),
(367, 100, 102, 0, 0, '', 'Catalogo de Grupos de operador', '', '', '', '', 0, 0, 'AdminGpoCV', '', '', '', 'Catalogo de Grupos de operador', 3, '\r\nNivel 1: Consulta<br />\r\nNivel 2: Creación y edición<br />\r\nNivel 3: Borrado<br />\r\n\r\n\r\n\r\n', 1, '2018-02-01 16:22:02', 'a.lopez', 0),
(368, 100, 106, 0, 0, '', 'Configuración de modulo de Capital Humano', '', '', '', '', 0, 0, 'AdminOperaAdmin2', '', '', '', 'Permite modificar aspectos del comportamiento del modulo de Capital Humano', 1, '\r\n<strong>\r\nNivel 1:</strong> Requerido\r\n\r\n\r\n\r\n', 1, '2018-02-01 16:22:07', 'a.lopez', 0),
(369, 100, 106, 0, 0, '', 'Acceso al catálogo principal de Personal', '', '', '', '', 0, 0, 'AdminPopera2', '', '', '', 'Acceso a consultar, crear y editar personal', 4, 'Nivel 1: Consulta de registros<br />\r\nNivel 2: Crear y edición Limitada<br />\r\nNivel 3: Edición Total (Excepto Status)<br />\r\nNivel 4: Puede Borrar registros\r\n\r\n', 1, '2018-02-01 16:22:12', 'a.lopez', 0),
(370, 100, 106, 0, 0, '', 'Acceso a los archivos', '', '', '', '', 0, 0, 'AdminPoperaArc2', '', '', '', 'Acceso a los archivos de los expedientes', 4, 'Nivel 1: Consultar<br />\r\nNivel 2: Crear<br />\r\nNivel 3: Editar<br />\r\nNivel 4: Borrar\r\n', 1, '2018-02-01 16:22:17', 'a.lopez', 0),
(371, 100, 106, 0, 0, '', 'Comentarios en Capital Humano', '', '', '', '', 0, 0, 'AdminPoperaComs2', '', '', '', 'Permite ver, editar y/o borrar comentarios en el Capital humano', 4, 'Nivel 1: Consulta<br />\r\nNivel 2: Creación de Comentarios<br />\r\nNivel 3: Editar Comentarios<br />\r\nNivel 4: Borrar Comentarios\r\n\r\n', 1, '2018-02-01 16:22:24', 'a.lopez', 0),
(372, 100, 102, 0, 0, '', 'Acceso a los grupos de operadores', '', '', '', '', 0, 0, 'AdminPoperaCV', '', '', '', 'Permite el acceso a los grupos de operadores, asignar grupos, crear y borrarlos.', 3, '\r\nNivel 1: Consulta<br />\r\nNivel 2: Crear y Editar grupos<br />\r\nNivel 3: Borrar grupos<br />\r\n\r\n\r\n\r\n\r\n\r\n', 1, '2018-02-09 15:09:59', 'avalle', 0),
(373, 100, 106, 0, 0, '', 'Documentos Laborales', '', '', '', '', 0, 0, 'AdminPoperaDoc2', '', '', '', 'Consulta y Creación de Documentos Laborales', 3, 'Nivel 1: Consulta e Impresión<br />\r\nNivel 2: Creación y edición<br />\r\nNivel 3: Borrado de documentos\r\n\r\n', 1, '2018-02-01 16:31:14', 'a.lopez', 0),
(374, 100, 106, 0, 0, '', 'Exportar Capital Humano', '', '', '', '', 0, 0, 'AdminPoperaExp2', '', '', '', 'Permite Exportar a un archivo Excel los elementos del Capital Humano', 1, '\r\n<strong>Nivel 1:</strong> Requerido\r\n', 1, '2018-02-01 16:31:19', 'a.lopez', 0),
(375, 100, 106, 0, 0, '', 'Permite cambiar el status', '', '', '', '', 0, 0, 'AdminPoperaStatus2', '', '', '', 'Permite cambiar el Status del personal de Capital Humano', 1, '\r\n<strong>Nivel 1:</strong> Requerido\r\n\r\n\r\n', 1, '2018-02-01 16:31:24', 'a.lopez', 0),
(376, 100, 106, 0, 0, '', 'Asignar Eco y Grupo a Operadores', '', '', '', '', 0, 0, 'AdminPoperaCVA', '', '', '', 'Permite asignar Eco y Grupo a los operadores', 2, 'Nivel 1: Permite asignar Eco<br />\r\nNivel 2: Permite asignar Grupo', 1, '2018-02-09 15:09:46', 'avalle', 0),
(377, 100, 106, 0, 0, '', 'Permite editar operadores ya contratados', '', '', '', '', 0, 0, 'AdminPoperaSupered2', '', '', '', 'Permite editar operadores ya contratados', 2, '<strong>Nivel 1:</strong>&nbsp;Editar solo la información financiera<br />\r\n<strong>Nivel 2:</strong>&nbsp;Editar todo el perfil', 1, '2018-02-15 09:23:02', 'avalle', 0),
(378, 52, 93, 0, 0, '', 'Permite Exportar Campañas por eco', '', '', '', '', 0, 0, 'AdminCampaniaExp', '', '', '', '', 1, '<strong>Nivel 1:</strong> Requerido', 1, '2018-02-15 13:16:25', 'avalle', 0),
(379, 52, 72, 0, 0, '', 'Seguimiento a Neumaticos', '', '', '', '', 0, 0, 'AdminllantasSeguimiento', '', '', '', 'Permite la captura de profuncidad de dibujo en neumáticos', 3, '<strong>Nivel 1:</strong> Consulta<br />\r\n<strong>Nivel 2:</strong> Creacipon y edición<br />\r\n<strong>Nivel 3:</strong> Borrado', 1, '2018-03-01 10:07:18', 'avalle', 0),
(380, 100, 101, 0, 0, '', 'Acceso a Trámites', '', '', '', '', 0, 0, 'AdminConTram', '', '', '', 'Acceso a los tramites', 5, '\r\nNivel 1: Consulta de trámites<br />\r\nNivel 2: Crear trámites<br />\r\nNivel 3: Agregar status del trámite&nbsp;<br />\r\nNivel 4: Procesar trámites<br />\r\nNivel 5: Borrar trámites', 1, '2018-03-09 16:57:36', 'avalle', 0),
(381, 100, 107, 0, 0, '', 'Trabajar con Tenencias', '', '', '', '', 0, 0, 'AdminConcesionesTenencia', '', '', '', 'Permiso para agregar y editar Tenencias en los tramites de las concesiones respecto a la unidad activa.', 3, '<strong>\r\nNivel 1:</strong> Consulta\r\n<br />\r\n<strong>Nivel 2:</strong> Creación y edición<br />\r\n<strong>Nivel 3:</strong> Borrado de registros', 1, '2018-03-15 11:25:54', 'avalle', 0),
(382, 100, 108, 0, 0, '', 'Acceso a TrámitesVerificaciones', '', '', '', '', 0, 0, 'AdminConcesionesVerificacion', '', '', '', 'Permiso para agregar y editar Verificaciones en el tramite de las concesiones correspondiente a la unidad actual.', 3, '\r\n<strong>Nivel 1:</strong> Consulta<br />\r\n<strong>Nivel 2:</strong> Crear y Editar<br />\r\n<strong>Nivel 3:</strong> Borrar\r\n', 1, '2018-03-15 14:02:25', 'avalle', 0),
(383, 35, 76, 0, 0, '', 'Reporte de Facturas por Producto', '', '', '', '', 0, 0, 'AdminRepFacturaxProd', '', '', '', 'Reporte de Facturas por Producto', 1, '<strong>Nivel 1:</strong> Requerido', 1, '2018-03-20 12:00:13', 'avalle', 0),
(384, 35, 76, 0, 0, '', 'Reporte de Cuentas por Cobrar', '', '', '', '', 0, 0, 'AdminRepCxC', '', '', '', 'Reporte de Cuentas por Cobrar', 1, '<strong>Nivel 1:</strong> Requerido', 1, '2018-03-20 12:00:54', 'avalle', 0),
(385, 35, 76, 0, 0, '', 'Reporte de Saldos por Cliente', '', '', '', '', 0, 0, 'AdminRepSaldosCli', '', '', '', 'Reporte de Saldos por Cliente', 1, '<strong>Nivel 1:</strong> Requerido', 1, '2018-03-20 12:01:59', 'avalle', 0),
(386, 35, 76, 0, 0, '', 'Reporte de Saldos por Proveedor', '', '', '', '', 0, 0, 'AdminRepSaldosPro', '', '', '', '', 1, '<strong>Nivel 1:</strong> Requerido', 1, '2018-03-20 12:02:40', 'avalle', 0),
(387, 35, 76, 0, 0, '', 'Reporte Estados de cuenta Clientes', '', '', '', '', 0, 0, 'AdminRepEdoCli', '', '', '', 'Permite consultar los estados de cuenta de los cientes', 1, '<strong>Nivel 1:</strong> Requerido', 1, '2018-03-20 12:03:38', 'avalle', 0),
(388, 35, 76, 0, 0, '', 'Reporte de Compras', '', '', '', '', 0, 0, 'AdminRepCompras', '', '', '', 'Reporte de Compras', 1, '<strong>Nivel 1:</strong> Requerido', 1, '2018-03-20 12:04:20', 'avalle', 0),
(389, 35, 76, 0, 0, '', 'Graficas de facturación', '', '', '', '', 0, 0, 'AdminRepGraficas', '', '', '', 'Graficas de facturación', 1, '<strong>Nivel 1:</strong> Requerido', 1, '2018-03-20 12:04:59', 'avalle', 0),
(390, 100, 101, 0, 0, '', 'Manejo de Archivos en tramites', '', '', '', '', 0, 0, 'AdminConTramArc', '', '', '', 'Permite consultar, crear y editar los archivos en los Trámites', 3, '<strong>Nivel 1:</strong> Consulta<br />\r\n<strong>Nivel 2:</strong> Creación y edición<br />\r\n<strong>Nivel 3:</strong> Borrar', 1, '2018-03-20 17:04:53', 'avalle', 0),
(391, 100, 101, 0, 0, '', 'Permite Reversar Transacciones en trámites', '', '', '', '', 0, 0, 'AdminConTramRev', '', '', '', '', 1, '<strong>Nivel 1:</strong> Requerido', 1, '2018-03-24 06:56:54', 'avalle', 0),
(392, 70, 84, 0, 0, '', 'Permite Exportar las actividades de personal', '', '', '', '', 0, 0, 'AdminActividadesExp', '', '', '', 'Permite Exportar las actividades de personal', 1, '<strong>Nivel 1:</strong> Requerido', 1, '2018-04-20 09:03:43', 'avalle', 0),
(393, 100, 101, 0, 0, '', 'Permite mover documentos entre trámites', '', '', '', '', 0, 0, 'AdminConTramMov', '', '', '', 'Permite mover documentos de un trámite activo a otro', 1, '<strong>Nivel 1:</strong> Requerido', 1, '2018-04-23 14:26:09', 'avalle', 0),
(394, 100, 101, 0, 0, '', 'Permite la baja en trámites', '', '', '', '', 0, 0, 'AdminConTramBaja', '', '', '', 'Permite la baja en trámites de Concesiones', 1, 'Nivel 1: Requerido', 1, '2018-04-24 15:03:55', 'avalle', 0),
(395, 55, 56, 0, 0, '', 'Permite cambiar el Tipo de CH', '', '', '', '', 0, 0, 'AdminPoperaTipo', '', '', '', 'Permite cambiar el tipo Capital Humano en cualquier registro', 1, '<strong>Nivel 1:</strong> Requerido', 1, '2018-04-26 14:11:28', 'avalle', 0),
(396, 55, 56, 0, 0, '', 'Permite actualizar la edad de CH', '', '', '', '', 0, 0, 'AdminPoperaEdad', '', '', '', 'Permite realizar un barrido en todo el capital umano filtrado y actualizar el campo edad de acuerdo a la fehca cuando se ejecute', 1, '<strong>Nivel 1:</strong> Requerido', 1, '2018-04-26 14:45:25', 'avalle', 0),
(397, 52, 60, 0, 0, '', 'Exportar lar jornadas por calificar', '', '', '', '', 0, 0, 'AdminCicCalifExp', '', '', '', 'Exportar lar jornadas por calificar', 1, '<strong>Nivel 1:</strong> Requerido', 1, '2018-04-26 16:45:57', 'avalle', 0),
(398, 35, 51, 0, 0, '', 'Permite abrir ventas cerradas', '', '', '', '', 0, 0, 'AdminVentasOpen', '', '', '', 'Permite abrir ventas cerradas, siempre y cuando la venta no este facturada.', 1, '<strong>Nivel 1:</strong> Requerido', 1, '2018-05-02 19:41:57', 'avalle', 0),
(399, 55, 56, 0, 0, '', 'Exportar Consulta de Documentos CH', '', '', '', '', 0, 0, 'AdminPoperaDocEx', '', '', '', 'Permite exportar la consulta de doucmentos del capital humano', 1, '<strong>Nivel 1:</strong> Requerido', 1, '2018-05-03 11:48:40', 'avalle', 0),
(400, 35, 51, 0, 0, '', 'Catálogo de elementos de Ventas', '', '', '', '', 0, 0, 'AdminVentasCat', '', '', '', 'Catálogo de elementos utilizadas en el módulo de Ventas', 3, '\r\n<strong>Nivel 1:</strong> Consulta de elementos<br />\r\n<strong>Nivel 2:</strong> Creación y edición de registros<br />\r\n<strong>Nivel 3:</strong> Borrado de elementos\r\n', 1, '2018-05-04 11:18:32', 'avalle', 0),
(401, 70, 74, 0, 0, '', 'Revierte Asistencias ya procesadas', '', '', '', '', 0, 0, 'AdminAsistenciasProcBack', '', '', '', 'Revierte Asistencias ya procesadas', 1, '<strong>Nivel 1: </strong>Requerido', 1, '2018-05-08 10:49:39', 'avalle', 0),
(402, 52, 92, 0, 0, '', 'Super editor de Viajes foraneos', '', '', '', '', 0, 0, 'AdminViajeSeditor', '', '', '', 'Permite editar los valor del viaje foraneo, incluso en status Liquidado.', 1, '<strong>Nivel 1: </strong>Requerido', 1, '2018-05-21 20:00:25', 'avalle', 0),
(403, 70, 84, 0, 0, '', 'Permite Calificar Jornadas', '', '', '', '', 0, 0, 'AdminActividadesCalif', '', '', '', 'Permite Calificar Jornadas', 2, '\r\n<p><strong>Nivel 1:</strong> Califica<br />\r\n<strong>Nivel 2:</strong>&nbsp;Permite reversar Calificaciones</p>', 1, '2018-05-27 20:01:32', 'avalle', 0),
(404, 1, 2, 0, 0, '', 'Permite Cambiar el ID Interempresa', '', '', '', '', 0, 0, 'AdminCreditosRef2', '', '', '', 'Permite Cambiar el ID Interempresa de los contratos, sin importar si estan en proceso', 1, '<strong>Nivel 1:</strong> Requerido', 1, '2018-06-05 11:42:46', 'avalle', 0),
(405, 30, 83, 0, 0, '', 'Acceso a los archivos generales Asamblea y Poderes', '', '', '', '', 0, 0, 'AdminArcAsamblea', '', '', '', 'Permite acceder a los archivos generales del módulo', 3, '<strong>Nivel 1</strong>: Consulta<br />\r\n<strong>Nivel 2</strong>: Creación y Edición<br />\r\n<strong>Nivel 3</strong>: Borrado de archivos\r\n\r\n\r\n', 1, '2018-06-07 08:22:23', 'avalle', 0),
(406, 52, 60, 0, 0, '', 'Captura de Anticongelante', '', '', '', '', 0, 0, 'AdminCapAnt', '', '', '', 'Captura de Anticongelante', 3, '\r\n<div>\r\n<div>Nivel 1: Requerido&nbsp;\r\n</div>\r\n<div>Nivel 2: Creación y edición\r\n</div>\r\n<div>Nivel 3: Borrado de registros\r\n</div>\r\n</div>\r\n\r\n\r\n\r\n\r\n\r\n', 1, '2018-06-07 10:41:52', 'avalle', 0),
(407, 52, 60, 0, 0, '', 'Ver costos en vista Anticongelante', '', '', '', '', 0, 0, 'AdminCapAntC', '', '', '', '', 1, '<strong>Nivel 1:</strong> Requerido\r\n\r\n', 1, '2015-03-07 11:32:47', 'avalle', 0),
(408, 52, 60, 0, 0, '', 'Exportar Bitacora de Anticongelante', '', '', '', '', 0, 0, 'AdminCapAntEx', '', '', '', 'Permite exportar a Excel los datos de Anticongelante', 1, '\r\n<strong>Nivel 1:</strong> Requerido\r\n', 1, '2015-03-23 13:42:16', 'avalle', 0),
(409, 52, 60, 0, 0, '', 'Parámetros de Anticongelante', '', '', '', '', 0, 0, 'AdminAntadmin', '', '', '', 'Permite cambiar los parámetros relativos al anticongelante', 1, '<strong>Nivel 1:</strong> Requerido', 1, '2016-04-12 17:11:42', 'avalle', 0),
(410, 52, 60, 0, 0, '', 'Capturar Ingreso Anticongelante', '', '', '', '', 0, 0, 'AdminIngAnt', '', '', '', '', 3, '<strong>\r\nNivel 1:</strong> Consulta<br />\r\n<strong>\r\nNivel 2:</strong> Capturar y Editar \r\nRegistros<br />\r\n<strong>\r\nNivel 3:</strong> Borrar<br />\r\n\r\n\r\n', 1, '2015-02-19 12:04:32', 'avalle', 0),
(411, 35, 109, 0, 0, '', 'Acceso a Ventas Restaurante', '', '', '', '', 0, 0, 'AdminVentasRes', '', '', '', '', 4, '<strong>Nivel 1:</strong>&nbsp;Consulta<br />\r\n<strong>Nivel 2:</strong>&nbsp;Creación y Edición<br />\r\n<strong>Nivel 3:</strong>&nbsp;Cancelar Ventas<br />\r\n<strong>Nivel 4:</strong>&nbsp;Borrar Ventas\r\n\r\n\r\n', 1, '2018-06-12 09:18:30', 'avalle', 0),
(412, 35, 109, 0, 0, '', 'Permite ver todas las ventas', '', '', '', '', 0, 0, 'AdminVentasAllRes', '', '', '', '', 1, '<strong>Nivel 1:</strong>&nbsp;Requerido\r\n\r\n', 1, '2018-06-12 09:19:23', 'avalle', 0),
(413, 35, 109, 0, 0, '', 'Permite abrir ventas cerradas Restaurant', '', '', '', '', 0, 0, 'AdminVentasOpen', '', '', '', 'Permite abrir ventas cerradas, siempre y cuando la venta restaurant no este facturada.', 1, '<strong>Nivel 1:</strong> Requerido', 1, '2018-06-12 10:40:09', 'avalle', 0),
(414, 52, 80, 0, 0, '', 'Permite reabrir incidencias de operador', '', '', '', '', 0, 0, 'AdminIncidenciasOpen', '', '', '', 'Permite reabrir incidencias de operador', 1, '<strong>Nivel 1:</strong> Requerido', 1, '2018-06-14 11:10:52', 'avalle', 0),
(415, 70, 84, 0, 0, '', 'Permite editar los catalogos del modulo de Actividades del Operador', '', '', '', '', 0, 0, 'AdminActividadesCatOpe', '', '', '', 'Permite editar los catalogos del modulo de Actividades del Operador', 3, '<strong>Nivel 1:</strong> Consulta<br />\r\n<strong>Nivel 2:</strong> Edición<br />\r\n<strong>Nivel 3:</strong> Borrado', 1, '2018-06-15 14:22:13', 'avalle', 0),
(416, 70, 84, 0, 0, '', 'Permite acceso a Actividades Operador', '', '', '', '', 0, 0, 'AdminActividadesOpe', '', '', '', '', 3, '<strong>Nivel 1:</strong>&nbsp;Consulta<br />\r\n<strong>Nivel 2:</strong>&nbsp;Crear y Editar<br />\r\n<strong>Nivel 3:</strong>&nbsp;Borrado\r\n\r\n', 1, '2018-06-15 14:23:46', 'avalle', 0),
(417, 70, 84, 0, 0, '', 'Permite Calificar Actividades Operador', '', '', '', '', 0, 0, 'AdminActividadesCalifOpe', '', '', '', '', 2, '<strong>Nivel 1:</strong>&nbsp;Califica<br />\r\n<strong>Nivel 2:</strong>&nbsp;Permite reversar Calificaciones\r\n\r\n', 1, '2018-06-15 14:24:50', 'avalle', 0),
(418, 70, 84, 0, 0, '', 'Permite Exportar las actividades de personal operador', '', '', '', '', 0, 0, 'AdminActividadesExpOpe', '', '', '', 'Permite Exportar las actividades de personal operador', 1, '<strong>Nivel 1:</strong> Requerido', 1, '2018-06-15 14:25:44', 'avalle', 0),
(419, 100, 103, 0, 0, '', 'Consulta el resumen de unidades', '', '', '', '', 0, 0, 'AdminResumenUni', '', '', '', 'Consulta el resumen de unidades', 1, '<strong>Nivel 1:</strong> Requerido', 1, '2018-06-27 15:07:43', 'avalle', 0),
(420, 52, 60, 0, 0, '', 'Permite reabrir capturas de combustible de salida', '', '', '', '', 0, 0, 'AdminCapComOpen', '', '', '', 'Permite reabrir capturas de combustible de salida', 1, '<strong>Nivel 1</strong>: Requerido', 1, '2018-07-19 17:24:35', 'avalle', 0),
(421, 100, 106, 0, 0, '', 'Permite agregar Persona al Organigrama Operadores', '', '', '', '', 0, 0, 'AdminSelOrganigrama2', '', '', '', 'Solo aparece la opción en status de Contratación de Operadores', 1, '\r\n<strong>\r\nNivel 1:</strong> Requerido\r\n\r\n', 1, '2018-07-25 00:01:21', 'avalle', 0),
(422, 100, 106, 0, 0, '', 'Permite agregar posición Operador', '', '', '', '', 0, 0, 'AdminSelPosicion2', '', '', '', 'Permite agregar una posición al capital humano operador', 1, '\r\n<strong>\r\nNivel 1:</strong> Requerido\r\n\r\n\r\n', 1, '2018-07-25 00:02:47', 'avalle', 0),
(423, 100, 110, 0, 0, '', 'Acceder a los Servicios de Grua', '', '', '', '', 0, 0, 'AdminGruas', '', '', '', 'Acceder a los Servicios de Grua', 3, '<strong>Nivel 1:</strong> Requerido<br />\r\n<strong>Nivel 2:</strong> Creación y edición de servicios<br />\r\n<strong>Nivel 3</strong>: Borrado', 1, '2018-08-14 15:57:07', 'avalle', 0),
(424, 100, 110, 0, 0, '', 'Acceso a las imagenes de los servicios de grua', '', '', '', '', 0, 0, 'AdminGruasArc', '', '', '', 'Acceso a las imagenes de los servicios de grua', 3, '<strong>Nivel 1:</strong> Consulta<br />\r\n<strong>Nivel 2:</strong> Creación y edición<br />\r\n<strong>Nivel 3:</strong> Borrado', 1, '2018-08-14 16:24:19', 'avalle', 0),
(425, 100, 111, 0, 0, '', 'Salidas de operación', '', '', '', '', 0, 0, 'AdminSalidas', '', '', '', 'Permiso para acceder a la operacion de Servicios asi como consulta de estadisticas y reportes', 5, '\r\n<div><strong>Nivel 1:</strong> Solo captura y puede cerrar reportes.\r\n</div>\r\n<div><strong>Nivel 2:</strong> El usuario puede ver los reportes de todos los usuarios que compartan el nivel 2.\r\n</div>\r\n<div><strong>Nivel 3,4:</strong> Ve todo, puede borrar reportes sin terminar\r\n</div>\r\n<div><strong>Nivel 5:</strong> puede borrar cualquier reporte, puede Reabrir reportes.\r\n</div>\r\n<div><br />\r\n</div>\r\n\r\n\r\n', 1, '2018-08-24 18:58:39', 'avalle', 0),
(426, 100, 110, 0, 0, '', 'Administración de Folios', '', '', '', '', 0, 0, 'AdminGruasFolios', '', '', '', 'Personal con este permiso, podrá administrar el rango de folios permicibles en la documentación de Servicio de Grua', 1, '<strong>Nivel 1:</strong> Requerido', 1, '2018-09-08 06:02:32', 'avalle', 0),
(427, 100, 110, 0, 0, '', 'Catálogos de servicio de Grua', '', '', '', '', 0, 0, 'AdminGruasCat', '', '', '', 'Catálogos de servicio de Grua', 3, '<strong>Nivel 1:</strong> Consulta<br />\r\n<strong>Nivel 2:</strong> Creación y edición<br />\r\n<strong>Nivel 3:</strong> Borrado', 1, '2018-09-08 06:09:28', 'avalle', 0),
(428, 52, 60, 0, 0, '', 'Exportar Bitacora de Aceite Proveedor', '', '', '', '', 0, 0, 'AdminProvCapaceiteEx', '', '', '', 'Permite exportar a Excel los datos de Aceite Proveedor', 1, '\r\n<strong>Nivel 1:</strong> Requerido\r\n', 1, '2015-12-30 14:52:21', 'avalle', 0),
(429, 52, 60, 0, 0, '', 'Capturar Ingreso Aceite Proveedor', '', '', '', '', 0, 0, 'AdminProvIngaceite', '', '', '', '', 3, '<strong>\r\nNivel 1:</strong> Consulta<br />\r\n<strong>\r\nNivel 2:</strong> Capturar y Editar \r\nRegistros<br />\r\n<strong>\r\nNivel 3:</strong> Borrar<br />\r\n\r\n\r\n', 1, '2015-12-30 14:52:30', 'avalle', 0),
(430, 52, 60, 0, 0, '', 'Permite ver costos en Ingresos de Aceite Proveedor', '', '', '', '', 0, 0, 'AdminProvIngaceiteC', '', '', '', '', 1, '<strong>Nivel 1:</strong> Requerido\r\n\r\n', 1, '2015-12-30 14:52:43', 'avalle', 0),
(431, 52, 60, 0, 0, '', 'Captura de Aceite Proveedor', '', '', '', '', 0, 0, 'AdminProvCapaceite', '', '', '', 'Captura de Aceite Proveedor', 3, '\r\n<div><strong>Nivel 1</strong>: Requerido&nbsp;\r\n</div>\r\n<div><strong>Nivel 2</strong>: Creación y edición\r\n</div>\r\n<div><strong>Nivel 3</strong>: Borrado de registros\r\n</div>\r\n\r\n\r\n', 1, '2015-12-30 14:54:58', 'avalle', 0),
(432, 52, 60, 0, 0, '', 'Parámetros de Aceite Proveedor', '', '', '', '', 0, 0, 'AdminProvaceiteadmin', '', '', '', 'Permite cambiar los parámetros relativos al aceite Proveedor', 1, '<strong>Nivel 1:</strong> Requerido', 1, '2016-04-07 12:58:43', 'avalle', 0),
(433, 52, 69, 0, 0, '', 'Ver costos en vista Aceite Proveedor', '', '', '', '', 0, 0, 'AdminProvCapaceiteC', '', '', '', 'Permite ver costos en la vista de Salidas de aceite Proveedor', 1, '<strong>Nivel 1:</strong> Requerido', 1, '2016-04-07 13:16:26', 'avalle', 0),
(434, 52, 81, 0, 0, '', 'Agregar Parametros de medición nivel Administración', '', '', '', '', 0, 0, 'AdminDataParametrosAdmin', '', '', '', 'Agregar Parametros de medición nivel Administración', 1, '<strong>Nivel 1:</strong> Requerido', 1, '2018-09-14 01:23:09', 'avalle', 0),
(435, 52, 60, 0, 0, '', 'Exportar Bitacora Proveedor Adblue', '', '', '', '', 0, 0, 'AdminProvCapadblueEx', '', '', '', 'Permite exportar a Excel los datos de Adblue Proveedor', 1, '\r\n<strong>Nivel 1:</strong> Requerido\r\n', 1, '2015-12-30 14:52:21', 'avalle', 0),
(436, 52, 60, 0, 0, '', 'Capturar Ingreso Adblue Proveedor', '', '', '', '', 0, 0, 'AdminProvIngadblue', '', '', '', '', 3, '<strong>\r\nNivel 1:</strong> Consulta<br />\r\n<strong>\r\nNivel 2:</strong> Capturar y Editar \r\nRegistros<br />\r\n<strong>\r\nNivel 3:</strong> Borrar<br />\r\n\r\n\r\n', 1, '2015-12-30 14:52:30', 'avalle', 0),
(437, 52, 60, 0, 0, '', 'Permite ver costos en Ingresos de Adblue Proveedor', '', '', '', '', 0, 0, 'AdminProvIngadblueC', '', '', '', '', 1, '<strong>Nivel 1:</strong> Requerido\r\n\r\n', 1, '2015-12-30 14:52:43', 'avalle', 0),
(438, 52, 60, 0, 0, '', 'Captura de Adblue Proveedor', '', '', '', '', 0, 0, 'AdminProvCapadblue', '', '', '', 'Captura de Adblue Proveedor', 3, '\r\n<div><strong>Nivel 1</strong>: Requerido&nbsp;\r\n</div>\r\n<div><strong>Nivel 2</strong>: Creación y edición\r\n</div>\r\n<div><strong>Nivel 3</strong>: Borrado de registros\r\n</div>\r\n\r\n\r\n', 1, '2015-12-30 14:54:58', 'avalle', 0),
(439, 52, 60, 0, 0, '', 'Parámetros de Adblue Proveedor', '', '', '', '', 0, 0, 'AdminProvadblueadmin', '', '', '', 'Permite cambiar los parámetros relativos al adblue Proveedor', 1, '<strong>Nivel 1:</strong> Requerido', 1, '2016-04-07 12:58:43', 'avalle', 0),
(440, 52, 69, 0, 0, '', 'Ver costos en vista Adblue Proveedor', '', '', '', '', 0, 0, 'AdminProvCapadblueC', '', '', '', 'Permite ver costos en la vista de Salidas de adblue Proveedor', 1, '<strong>Nivel 1:</strong> Requerido', 1, '2016-04-07 13:16:26', 'avalle', 0),
(441, 52, 60, 0, 0, '', 'Exportar Bitacora Proveedor Pintura', '', '', '', '', 0, 0, 'AdminProvCappinturaEx', '', '', '', 'Permite exportar a Excel los datos de Pintura Proveedor', 1, '\r\n<strong>Nivel 1:</strong> Requerido\r\n', 1, '2015-12-30 14:52:21', 'avalle', 0),
(442, 52, 60, 0, 0, '', 'Capturar Ingreso Pintura Proveedor', '', '', '', '', 0, 0, 'AdminProvIngpintura', '', '', '', '', 3, '<strong>\r\nNivel 1:</strong> Consulta<br />\r\n<strong>\r\nNivel 2:</strong> Capturar y Editar \r\nRegistros<br />\r\n<strong>\r\nNivel 3:</strong> Borrar<br />\r\n\r\n\r\n', 1, '2015-12-30 14:52:30', 'avalle', 0),
(443, 52, 60, 0, 0, '', 'Permite ver costos en Ingresos de Pintura Proveedor', '', '', '', '', 0, 0, 'AdminProvIngpinturaC', '', '', '', '', 1, '<strong>Nivel 1:</strong> Requerido\r\n\r\n', 1, '2015-12-30 14:52:43', 'avalle', 0),
(444, 52, 60, 0, 0, '', 'Captura de Pintura Proveedor', '', '', '', '', 0, 0, 'AdminProvCappintura', '', '', '', 'Captura de Pintura Proveedor', 3, '\r\n<div><strong>Nivel 1</strong>: Requerido&nbsp;\r\n</div>\r\n<div><strong>Nivel 2</strong>: Creación y edición\r\n</div>\r\n<div><strong>Nivel 3</strong>: Borrado de registros\r\n</div>\r\n\r\n\r\n', 1, '2015-12-30 14:54:58', 'avalle', 0),
(445, 52, 60, 0, 0, '', 'Parámetros de Pintura Proveedor', '', '', '', '', 0, 0, 'AdminProvpinturaadmin', '', '', '', 'Permite cambiar los parámetros relativos al Pintura Proveedor', 1, '<strong>Nivel 1:</strong> Requerido', 1, '2016-04-07 12:58:43', 'avalle', 0),
(446, 52, 69, 0, 0, '', 'Ver costos en vista Pintura Proveedor', '', '', '', '', 0, 0, 'AdminProvCappinturaC', '', '', '', 'Permite ver costos en la vista de Salidas de Pintura Proveedor', 1, '<strong>Nivel 1:</strong> Requerido', 1, '2016-04-07 13:16:26', 'avalle', 0),
(447, 55, 56, 0, 0, '', 'Acceder Catálogo Exámenes Médicos', '', '', '', '', 0, 0, 'AdminCatMed', '', '', '', 'Usados en el módulo de capital humano', 3, '<strong>Nivel 1:</strong> Consulta&nbsp;<br />\r\n<strong>Nivel 2:</strong> Creación y Edición de registros<br />\r\n<strong>Nivel 3:</strong> Borrado de registros', 1, '2018-09-20 20:11:56', 'c.loredo', 0),
(448, 35, 37, 0, 0, '', 'Parametros Complemento pago', '', '', '', '', 0, 0, 'AdminDatosPagFac', '', '', '', 'Parametros utilizados en los CFDI tipo complemento de pagos', 1, '<strong>Nivel 1:</strong> Requerido', 1, '2018-09-26 03:07:41', 'avalle', 0),
(449, 35, 37, 0, 0, '', 'Permite generar Complementos de pago', '', '', '', '', 0, 0, 'AdminComplementoPago', '', '', '', 'Permite generar Complementos de pago y timbrarlos (es necesario tener configurado la opción de generr CFDI en el CEN)', 3, '\r\n<strong>Nivel 1:</strong> Permite generar complementos de pago<br />\r\n<strong>Nivel 2: </strong>Permite enviar correo de notificación<br />\r\n<strong>Nivel 3:</strong> Permite regenerar el CFDI\r\n', 1, '2018-10-05 04:31:22', 'avalle', 0),
(450, 55, 56, 0, 0, '', 'Permite agregar información medica al CH', '', '', '', '', 0, 0, 'AdminPoperaMds', '', '', '', '', 3, '<strong>Nivel 1</strong>: Consultar<br />\r\n<strong>Nivel 2</strong>: Crear y editar información<br />\r\n<strong>Nivel 3</strong>: Eliminar registros', 1, '2018-10-09 17:07:08', 'avalle', 0),
(451, 52, 93, 0, 0, '', 'Campaña Mayor', '', '', '', '', 0, 0, 'AdminCamMay', '', '', '', 'Permite subir y editar registros a campaña mayor', 3, '\r\n<p><strong>Nivel 1: </strong>Consulta<strong>&nbsp;<br />\r\n</strong><strong>Nivel 2: </strong>Crear y Editar<br />\r\n<strong>Nivel 3: </strong>Borrar</p>\r\n\r\n\r\n', 1, '2018-10-12 00:00:17', 'c.loredo', 0),
(452, 52, 93, 0, 0, '', 'Campaña Mayor Archivos', '', '', '', '', 0, 0, 'AdminCamMayArc', '', '', '', 'Permite subir y editar archivos a campaña mayor', 3, '<p><strong>Nivel 1: </strong>Consulta<strong>&nbsp; &nbsp; &nbsp; <br />\r\nNi</strong><strong>vel 2: </strong>Crear y Editar<br />\r\n<strong>Nivel 3: </strong>Borrar</p>', 1, '2018-10-11 23:58:51', 'c.loredo', 0),
(453, 22, 23, 0, 0, '', 'Cambia párametros del sistema', '', '', '', '', 0, 0, 'AdminParametros', '', '', '', 'El acceso y cambio de parámetros es MUY delicado. Soló personal de desarrollo', 1, '<strong>Nivel 1: </strong>Requerido', 1, '2018-12-20 14:33:45', 'avalle', 0);

-- --------------------------------------------------------

--
-- Table structure for table `adm_parametros`
--

CREATE TABLE IF NOT EXISTS `adm_parametros` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `parametro` varchar(25) NOT NULL,
  `valor` double DEFAULT NULL,
  `valorvar` varchar(100) DEFAULT NULL,
  `valordate` date DEFAULT NULL,
  `grupo` varchar(25) NOT NULL DEFAULT '',
  `descripcion` varchar(100) NOT NULL DEFAULT '',
  `tipo` int(3) NOT NULL,
  `status` tinyint(2) NOT NULL,
  `ultactfec` datetime NOT NULL,
  `ultactusu` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `adm_parametros`
--

INSERT INTO `adm_parametros` (`id`, `parametro`, `valor`, `valorvar`, `valordate`, `grupo`, `descripcion`, `tipo`, `status`, `ultactfec`, `ultactusu`) VALUES
(1, 'resultadosxpagina', 25, NULL, NULL, 'Principal', 'Número de resultados por página', 0, 1, '0000-00-00 00:00:00', ''),
(2, 'numopeauto', 1, NULL, NULL, 'Clientes', 'Generar ID automático', 0, 1, '0000-00-00 00:00:00', '');

-- --------------------------------------------------------

--
-- Table structure for table `adm_permisos`
--

CREATE TABLE IF NOT EXISTS `adm_permisos` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `idusuario` int(5) DEFAULT '0',
  `idmodulo` int(5) NOT NULL,
  `modulo` varchar(50) DEFAULT '',
  `tipo` varchar(10) DEFAULT '',
  `extra1` int(5) NOT NULL,
  `extra2` int(5) NOT NULL,
  `extra3` int(5) NOT NULL,
  `extra4` int(5) NOT NULL,
  `extra5` int(5) NOT NULL,
  `ultactfec` varchar(25) DEFAULT '',
  `ultactusu` varchar(25) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `adm_permisos`
--

INSERT INTO `adm_permisos` (`id`, `idusuario`, `idmodulo`, `modulo`, `tipo`, `extra1`, `extra2`, `extra3`, `extra4`, `extra5`, `ultactfec`, `ultactusu`) VALUES
(1, 2, 92, 'AdminClientes', '5', 0, 0, 0, 0, 0, '2011-09-05 12:54:41', 'admin'),
(2, 2, 20, 'AdminCatalogos', '3', 0, 0, 0, 0, 0, '2011-09-05 12:54:41', 'admin'),
(3, 2, 20, 'AdminClientesCom', '4', 0, 0, 0, 0, 0, '2011-09-05 12:54:41', 'admin'),
(4, 2, 20, 'AdminClientesInt', '1', 0, 0, 0, 0, 0, '2011-09-05 12:54:41', 'admin'),
(5, 2, 20, 'AdminClientesAse', '1', 0, 0, 0, 0, 0, '2011-09-05 12:54:41', 'admin'),
(6, 1, 20, 'AdminClientes', '3', 0, 0, 0, 0, 0, '2011-09-05 12:54:41', 'admin'),
(7, 2, 20, 'AdminClientesArc', '3', 0, 0, 0, 0, 0, '2011-09-05 12:54:41', 'admin'),
(8, 2, 20, 'AdminClientesFor', '2', 0, 0, 0, 0, 0, '2011-09-05 12:54:41', 'admin'),
(9, 91, 92, 'AdminModulos', '5', 0, 0, 0, 0, 0, '2011-09-05 12:54:41', 'admin'),
(10, 91, 20, 'AdminToolsFI', '3', 0, 0, 0, 0, 0, '2011-09-05 12:54:41', 'admin'),
(11, 91, 20, 'AdminToolsHE', '3', 0, 0, 0, 0, 0, '2011-09-05 12:54:41', 'admin'),
(12, 265, 20, 'AdminTools', '1', 0, 0, 0, 0, 0, '2011-09-05 12:54:41', 'admin'),
(13, 265, 92, 'AdminModulos', '5', 0, 0, 0, 0, 0, '2011-09-05 12:54:41', 'admin'),
(14, 265, 20, 'AdminToolsFI', '3', 0, 0, 0, 0, 0, '2011-09-05 12:54:41', 'admin'),
(15, 265, 20, 'AdminToolsHE', '3', 0, 0, 0, 0, 0, '2011-09-05 12:54:41', 'admin'),
(16, 277, 92, 'AdminModulos', '5', 0, 0, 0, 0, 0, '2011-09-05 12:54:41', 'admin'),
(17, 277, 20, 'AdminTools', '1', 0, 0, 0, 0, 0, '2011-09-05 12:54:41', 'admin'),
(18, 277, 20, 'AdminToolsMD', '1', 0, 0, 0, 0, 0, '2011-09-05 12:54:41', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `adm_usuarios`
--

CREATE TABLE IF NOT EXISTS `adm_usuarios` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `idcategoria` tinyint(3) NOT NULL DEFAULT '0',
  `disponible` tinyint(2) NOT NULL DEFAULT '0',
  `nombre` varchar(200) NOT NULL DEFAULT '',
  `usuario` varchar(20) NOT NULL DEFAULT '',
  `password` varchar(50) NOT NULL DEFAULT '',
  `mail` varchar(200) NOT NULL DEFAULT '',
  `cumpleanios` date NOT NULL,
  `empresa` varchar(250) NOT NULL,
  `avatar` varchar(100) NOT NULL,
  `comentario` varchar(200) NOT NULL DEFAULT '',
  `status` tinyint(2) NOT NULL DEFAULT '0',
  `ultactfec` varchar(25) NOT NULL DEFAULT '',
  `ultactusu` varchar(25) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `adm_usuarios`
--

INSERT INTO `adm_usuarios` (`id`, `idcategoria`, `disponible`, `nombre`, `usuario`, `password`, `mail`, `cumpleanios`, `empresa`, `avatar`, `comentario`, `status`, `ultactfec`, `ultactusu`) VALUES
(1, 0, 0, 'Administrator', 'admin', '20549dcb6c26479bfee08e3b07b9fffa', 'abraham@im-pulso.com.mx', '0000-00-00', '', '', '', 1, '', ''),
(2, 0, 0, 'Abraham Valle', 'avalle', '20549dcb6c26479bfee08e3b07b9fffa', 'abraham@im-pulso.com.mx', '1976-10-25', '', '', '', 1, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `arc_clientes`
--

CREATE TABLE IF NOT EXISTS `arc_clientes` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `idorigen` int(3) NOT NULL DEFAULT '0',
  `iddoc` int(5) NOT NULL,
  `tipo` varchar(10) NOT NULL DEFAULT '0',
  `archivo` varchar(150) NOT NULL DEFAULT '',
  `tipoarchivo` varchar(10) NOT NULL DEFAULT '',
  `tamaarchivo` varchar(15) NOT NULL DEFAULT '',
  `fecha` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `descripcion` varchar(150) NOT NULL DEFAULT '',
  `comentario` varchar(150) NOT NULL DEFAULT '',
  `ultactfec` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ultactusu` varchar(10) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `arc_clientes`
--

INSERT INTO `arc_clientes` (`id`, `idorigen`, `iddoc`, `tipo`, `archivo`, `tipoarchivo`, `tamaarchivo`, `fecha`, `descripcion`, `comentario`, `ultactfec`, `ultactusu`) VALUES
(2, 1, 1, 'must', '', '', '', '0000-00-00 00:00:00', 'INE', '', '2018-12-28 04:53:15', 'avalle'),
(4, 1, 3, 'must', '', '', '', '0000-00-00 00:00:00', 'RFC', '', '2018-12-28 04:53:15', 'avalle'),
(5, 1, 4, 'must', '000000005_04f215443826f105b2a635a578df74a2.jpg', 'image/jpeg', '26495', '2018-12-29 01:24:00', 'CURP', '', '2018-12-29 01:24:00', 'avalle'),
(6, 1, 5, 'must', '000000006_45f3ad120e61add1347f87dd3c9a5674.jpg', 'image/jpeg', '5201', '2018-12-29 01:15:04', 'Acta de nacimiento', '', '2018-12-29 01:15:04', 'avalle');

-- --------------------------------------------------------

--
-- Table structure for table `cat_clientes`
--

CREATE TABLE IF NOT EXISTS `cat_clientes` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `idcli` varchar(25) DEFAULT NULL,
  `nombre` longtext,
  `apellidop` varchar(150) DEFAULT NULL,
  `apellidom` varchar(150) DEFAULT NULL,
  `nacimiento` date NOT NULL,
  `ecivil` varchar(50) NOT NULL,
  `nss` varchar(50) NOT NULL,
  `escolaridad` varchar(100) NOT NULL,
  `calle` varchar(100) DEFAULT NULL,
  `numero` varchar(50) DEFAULT NULL,
  `colonia` varchar(100) DEFAULT NULL,
  `municipio` varchar(100) NOT NULL,
  `estado` varchar(50) DEFAULT NULL,
  `cp` varchar(5) DEFAULT NULL,
  `rfc` varchar(14) DEFAULT NULL,
  `curp` varchar(25) DEFAULT NULL,
  `celular` varchar(50) DEFAULT NULL,
  `oficina` varchar(25) NOT NULL,
  `telefonos` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `profesion` varchar(200) DEFAULT NULL,
  `ocupacion` varchar(200) DEFAULT NULL,
  `idextranjero` varchar(100) DEFAULT NULL,
  `estadonac` varchar(100) DEFAULT NULL,
  `nacionalidad` varchar(100) NOT NULL,
  `idbanco` int(3) NOT NULL,
  `cuenta` varchar(100) NOT NULL,
  `clabe` varchar(100) NOT NULL,
  `beneficiario` varchar(250) NOT NULL,
  `genero` varchar(250) NOT NULL,
  `tipoid` varchar(50) NOT NULL,
  `fuentei` varchar(250) NOT NULL,
  `puestopolitico` varchar(200) NOT NULL,
  `procedencia` varchar(100) NOT NULL,
  `propietarior` varchar(50) DEFAULT NULL,
  `callef` varchar(100) NOT NULL,
  `numerof` varchar(50) NOT NULL,
  `coloniaf` varchar(100) NOT NULL,
  `municipiof` varchar(100) NOT NULL,
  `estadof` varchar(100) NOT NULL,
  `cpf` varchar(10) NOT NULL,
  `integradora` varchar(150) NOT NULL,
  `asesor` varchar(150) NOT NULL,
  `recursosori` varchar(200) NOT NULL,
  `recursosdes` varchar(200) NOT NULL,
  `valorampliacion` double NOT NULL,
  `valorregla` double NOT NULL,
  `valorneto` double NOT NULL,
  `docmust` int(3) NOT NULL,
  `fecha` datetime NOT NULL,
  `fechafin` datetime NOT NULL,
  `idproducto` int(3) NOT NULL,
  `idtipoproducto` int(3) NOT NULL,
  `iddestino` int(3) NOT NULL,
  `plazocredito` int(5) NOT NULL,
  `segundocredito` tinyint(2) NOT NULL,
  `discapacidad` tinyint(2) NOT NULL,
  `tipodiscapacidad` varchar(25) NOT NULL,
  `personacapacidad` varchar(50) NOT NULL,
  `montopresupuesto` double NOT NULL,
  `afectaestructura` tinyint(2) NOT NULL,
  `razonsocialpatron` varchar(200) NOT NULL,
  `rfcpatron` varchar(25) NOT NULL,
  `telpatron` varchar(50) NOT NULL,
  `ref1nombre` varchar(100) NOT NULL,
  `ref1apellidop` varchar(100) NOT NULL,
  `ref1apellidom` varchar(100) NOT NULL,
  `ref1telefono` varchar(50) NOT NULL,
  `ref2nombre` varchar(100) NOT NULL,
  `ref2apellidop` varchar(100) NOT NULL,
  `ref2apellidom` varchar(100) NOT NULL,
  `ref2telefono` varchar(50) NOT NULL,
  `razonsocialacreditado` varchar(200) NOT NULL,
  `rfcacreditado` varchar(25) NOT NULL,
  `nombreacreditado` varchar(200) NOT NULL,
  `clabeacreditado` varchar(25) NOT NULL,
  `owner` varchar(100) NOT NULL,
  `status` int(2) NOT NULL,
  `ultactfec` varchar(25) DEFAULT NULL,
  `ultactusu` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `cat_clientes`
--

INSERT INTO `cat_clientes` (`id`, `idcli`, `nombre`, `apellidop`, `apellidom`, `nacimiento`, `ecivil`, `nss`, `escolaridad`, `calle`, `numero`, `colonia`, `municipio`, `estado`, `cp`, `rfc`, `curp`, `celular`, `oficina`, `telefonos`, `email`, `profesion`, `ocupacion`, `idextranjero`, `estadonac`, `nacionalidad`, `idbanco`, `cuenta`, `clabe`, `beneficiario`, `genero`, `tipoid`, `fuentei`, `puestopolitico`, `procedencia`, `propietarior`, `callef`, `numerof`, `coloniaf`, `municipiof`, `estadof`, `cpf`, `integradora`, `asesor`, `recursosori`, `recursosdes`, `valorampliacion`, `valorregla`, `valorneto`, `docmust`, `fecha`, `fechafin`, `idproducto`, `idtipoproducto`, `iddestino`, `plazocredito`, `segundocredito`, `discapacidad`, `tipodiscapacidad`, `personacapacidad`, `montopresupuesto`, `afectaestructura`, `razonsocialpatron`, `rfcpatron`, `telpatron`, `ref1nombre`, `ref1apellidop`, `ref1apellidom`, `ref1telefono`, `ref2nombre`, `ref2apellidop`, `ref2apellidom`, `ref2telefono`, `razonsocialacreditado`, `rfcacreditado`, `nombreacreditado`, `clabeacreditado`, `owner`, `status`, `ultactfec`, `ultactusu`) VALUES
(1, '000001', 'Jose Abraham', 'Valle', 'Villanueva', '1979-12-14', 'Casado', 'b', 'Pre Escolar', 'r', 's', 't', 'u', 'Baja California', '8', 'VAVA761025MVA', 'a', 'f', 'e', 'd', 'c', 'i', 'j', 'h', 'Aguascalientes', 'g', 3, '6', '7', '8', 'Masculino', '', 'k', 'm', 'l', 'Propios', 'n', 'ñ', 'o', 'Pachuca', 'Hidalgo', '8', 'Integradora B', 'Abraham Valle', 'w', 'x', 3, 4, 5, 5, '2018-12-21 06:27:31', '0000-00-00 00:00:00', 0, 0, 0, 0, 0, 0, '', '', 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0', 1, '2019-01-02 05:45:25', 'avalle');

-- --------------------------------------------------------

--
-- Table structure for table `cat_credestino`
--

CREATE TABLE IF NOT EXISTS `cat_credestino` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) NOT NULL DEFAULT '',
  `status` tinyint(2) NOT NULL DEFAULT '0',
  `ultactusu` varchar(25) NOT NULL,
  `ultactfec` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cat_creplazo`
--

CREATE TABLE IF NOT EXISTS `cat_creplazo` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) NOT NULL DEFAULT '',
  `status` tinyint(2) NOT NULL DEFAULT '0',
  `ultactusu` varchar(25) NOT NULL,
  `ultactfec` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cat_creproductos`
--

CREATE TABLE IF NOT EXISTS `cat_creproductos` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) NOT NULL DEFAULT '',
  `status` tinyint(2) NOT NULL DEFAULT '0',
  `ultactusu` varchar(25) NOT NULL,
  `ultactfec` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cat_cretipopro`
--

CREATE TABLE IF NOT EXISTS `cat_cretipopro` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) NOT NULL DEFAULT '',
  `status` tinyint(2) NOT NULL DEFAULT '0',
  `ultactusu` varchar(25) NOT NULL,
  `ultactfec` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cat_docsmust`
--

CREATE TABLE IF NOT EXISTS `cat_docsmust` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) NOT NULL DEFAULT '',
  `status` tinyint(2) NOT NULL DEFAULT '0',
  `ultactusu` varchar(25) NOT NULL,
  `ultactfec` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `cat_docsmust`
--

INSERT INTO `cat_docsmust` (`id`, `descripcion`, `status`, `ultactusu`, `ultactfec`) VALUES
(1, 'INE', 1, '', ''),
(2, 'Comprobante de Domicilio', 1, '', ''),
(3, 'RFC', 1, '', ''),
(4, 'CURP', 1, '', ''),
(5, 'Acta de nacimiento', 1, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `cat_ecivil`
--

CREATE TABLE IF NOT EXISTS `cat_ecivil` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) NOT NULL DEFAULT '',
  `status` tinyint(2) NOT NULL DEFAULT '0',
  `ultactusu` varchar(25) NOT NULL,
  `ultactfec` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `cat_ecivil`
--

INSERT INTO `cat_ecivil` (`id`, `descripcion`, `status`, `ultactusu`, `ultactfec`) VALUES
(1, 'Casado', 1, '', ''),
(2, 'Soltero', 1, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `cat_escolaridad`
--

CREATE TABLE IF NOT EXISTS `cat_escolaridad` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) NOT NULL DEFAULT '',
  `status` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=235 ;

--
-- Dumping data for table `cat_escolaridad`
--

INSERT INTO `cat_escolaridad` (`id`, `descripcion`, `status`) VALUES
(227, 'Pre Escolar', 1),
(228, 'Primaria', 1),
(229, 'Secundaria', 1),
(230, 'Medio Superior', 1),
(231, 'Superior', 1),
(232, 'Postgrado', 1),
(233, 'Maestria', 1),
(234, 'Doctorado', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cat_estadosrep`
--

CREATE TABLE IF NOT EXISTS `cat_estadosrep` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) NOT NULL DEFAULT '',
  `status` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=227 ;

--
-- Dumping data for table `cat_estadosrep`
--

INSERT INTO `cat_estadosrep` (`id`, `descripcion`, `status`) VALUES
(195, 'Aguascalientes', 1),
(196, 'Baja California', 1),
(197, 'Baja California Sur', 1),
(198, 'Campeche', 1),
(199, 'Chiapas', 1),
(200, 'Chihuahua', 1),
(201, 'Coahuila', 1),
(202, 'Colima', 1),
(203, 'Ciudad de México', 1),
(204, 'Durango', 1),
(205, 'Estado de México', 1),
(206, 'Guanajuato', 1),
(207, 'Guerrero', 1),
(208, 'Hidalgo', 1),
(209, 'Jalisco', 1),
(210, 'Michoacán', 1),
(211, 'Morelos', 1),
(212, 'Nayarit', 1),
(213, 'Nuevo León', 1),
(214, 'Oaxaca', 1),
(215, 'Puebla', 1),
(216, 'Querétaro', 1),
(217, 'Quintana Roo', 1),
(218, 'San Luis Potosí', 1),
(219, 'Sinaloa', 1),
(220, 'Sonora', 1),
(221, 'Tabasco', 1),
(222, 'Tamaulipas', 1),
(223, 'Tlaxcala', 1),
(224, 'Veracruz', 1),
(225, 'Yucatán', 1),
(226, 'Zacatecas', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cat_instituciones`
--

CREATE TABLE IF NOT EXISTS `cat_instituciones` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) NOT NULL DEFAULT '',
  `status` tinyint(2) NOT NULL DEFAULT '0',
  `ultactusu` varchar(25) NOT NULL,
  `ultactfec` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `cat_instituciones`
--

INSERT INTO `cat_instituciones` (`id`, `descripcion`, `status`, `ultactusu`, `ultactfec`) VALUES
(1, 'Scotiabank Inverlat, SA', 1, 'admin', '2015-07-30 11:40:04'),
(3, 'Banco Nacional de México, S.A.', 1, 'laura', '2017-04-21 11:46:03'),
(4, 'BBVA Bancomer S.A.', 1, 'laura', '2017-04-21 11:50:46'),
(5, 'Santander S.A.', 1, 'd.lopez', '2018-11-01 10:16:20');

-- --------------------------------------------------------

--
-- Table structure for table `cat_integradoras`
--

CREATE TABLE IF NOT EXISTS `cat_integradoras` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) NOT NULL DEFAULT '',
  `status` tinyint(2) NOT NULL DEFAULT '0',
  `ultactusu` varchar(25) NOT NULL,
  `ultactfec` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `cat_integradoras`
--

INSERT INTO `cat_integradoras` (`id`, `descripcion`, `status`, `ultactusu`, `ultactfec`) VALUES
(1, 'Integradora A', 1, '', ''),
(2, 'Integradora B', 1, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `cat_recursos`
--

CREATE TABLE IF NOT EXISTS `cat_recursos` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `orden` int(3) NOT NULL,
  `tipo` tinyint(2) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `status` tinyint(2) NOT NULL,
  `ultactfec` datetime NOT NULL,
  `ultactusu` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `cat_recursos`
--

INSERT INTO `cat_recursos` (`id`, `orden`, `tipo`, `descripcion`, `status`, `ultactfec`, `ultactusu`) VALUES
(1, 1, 1, 'Patrimonio /Ahorro', 1, '2018-12-27 10:14:22', 'avalle'),
(2, 2, 1, 'Venta de Negocio', 1, '2018-12-27 10:15:34', 'avalle'),
(3, 3, 1, 'Beca', 1, '2018-12-27 10:20:41', 'avalle'),
(4, 4, 1, 'Bono Laboral', 1, '2018-12-27 10:21:07', 'avalle'),
(5, 5, 1, 'Venta de Inmuebles', 1, '2018-12-27 10:21:24', 'avalle'),
(6, 6, 1, 'Herencia', 1, '2018-12-27 10:22:19', 'avalle'),
(7, 7, 1, 'Venta de Activos', 1, '2018-12-27 10:22:34', 'avalle'),
(8, 8, 1, 'Liquidación o finiquito', 1, '2018-12-27 10:22:48', 'avalle'),
(9, 9, 1, 'Jubilaciones y Pensiones', 1, '2018-12-27 10:23:07', 'avalle'),
(10, 10, 1, 'Rifas, premios, sorteos', 1, '2018-12-27 10:23:19', 'avalle'),
(11, 11, 1, 'Comisiones', 1, '2018-12-27 10:24:02', 'avalle'),
(12, 12, 1, 'Honorarios', 1, '2018-12-27 10:24:14', 'avalle'),
(13, 13, 1, 'Inversión', 1, '2018-12-27 10:24:31', 'avalle'),
(14, 14, 1, 'Rentas', 1, '2018-12-27 10:24:44', 'avalle'),
(15, 15, 1, 'Sueldos', 1, '2018-12-27 10:24:57', 'avalle'),
(16, 16, 1, 'Venta de productos/ servicios', 1, '2018-12-27 10:25:16', 'avalle'),
(17, 50, 2, 'Administración de Gastos e Ingresos', 1, '2018-12-27 10:25:43', 'avalle'),
(18, 51, 2, 'Concertación de Fondos', 1, '2018-12-27 10:26:00', 'avalle'),
(19, 52, 2, 'Crédito', 1, '2018-12-27 10:26:18', 'avalle'),
(20, 53, 2, 'Cuenta de Inversión', 1, '2018-12-27 10:26:38', 'avalle'),
(21, 54, 2, 'Pago proveedores', 1, '2018-12-27 10:26:54', 'avalle');

-- --------------------------------------------------------

--
-- Table structure for table `cat_statuscliente`
--

CREATE TABLE IF NOT EXISTS `cat_statuscliente` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) NOT NULL DEFAULT '',
  `color` varchar(10) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '0',
  `ultactusu` varchar(25) NOT NULL,
  `ultactfec` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `cat_statuscliente`
--

INSERT INTO `cat_statuscliente` (`id`, `descripcion`, `color`, `status`, `ultactusu`, `ultactfec`) VALUES
(1, 'En Captura', '#000000', 1, '', ''),
(2, 'Por Documentar', '#000000', 1, '', ''),
(3, 'En Proceso', '#000000', 1, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `log_capitalhumano`
--

CREATE TABLE IF NOT EXISTS `log_capitalhumano` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `idorigen` int(5) NOT NULL,
  `tipo` tinyint(2) NOT NULL,
  `descripcion` longtext NOT NULL,
  `status` tinyint(2) NOT NULL,
  `ultactfec` datetime NOT NULL,
  `ultactusu` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `log_clientes`
--

CREATE TABLE IF NOT EXISTS `log_clientes` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `idorigen` int(5) NOT NULL,
  `tipo` tinyint(2) NOT NULL,
  `descripcion` longtext NOT NULL,
  `status` tinyint(2) NOT NULL,
  `ultactfec` datetime NOT NULL,
  `ultactusu` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `log_clientes`
--

INSERT INTO `log_clientes` (`id`, `idorigen`, `tipo`, `descripcion`, `status`, `ultactfec`, `ultactusu`) VALUES
(1, 1, 1, 'Cambio el CURP de  a a, Cambio el banco de 0 a , ', 1, '2018-12-27 21:15:45', 'avalle'),
(2, 1, 1, 'Cambio el CURP de  a a, Cambio el banco de 0 a , ', 1, '2018-12-27 21:17:26', 'avalle'),
(3, 1, 1, 'Cambio el CURP de  a a, Cambio el banco de 0 a , ', 1, '2018-12-27 21:17:59', 'avalle'),
(4, 1, 1, 'Cambio el CURP de  a a, Cambio el banco de 0 a , ', 1, '2018-12-27 21:18:42', 'avalle'),
(5, 1, 1, 'Cambio el CP de la dirección de 2 a 8, Cambio en Origen de los recursos de 0 a 0,1 (ids del sistema), Cambio en Destino de los recursos de 0 a 0,17 (ids del sistema), ', 1, '2018-12-27 21:22:57', 'avalle'),
(6, 1, 1, 'Cambio en Origen de los recursos de 0,1 a 0,1,3,5,7,9,11 (ids del sistema), Cambio en Destino de los recursos de 0,17 a 0,17,21 (ids del sistema), ', 1, '2018-12-27 21:23:17', 'avalle'),
(7, 1, 1, 'Comentario nuevo: ''prueba 1,2,3''''. ', 1, '2018-12-27 21:28:34', 'avalle'),
(8, 1, 1, 'Cambio un Comentario, de ''prueba 1,2,3'' a ''prueba 1,2,3... ok''. ', 1, '2018-12-27 21:30:18', 'avalle'),
(9, 1, 5, 'Borrado del Comentario ''prueba 1,2,3... ok''. ', 1, '2018-12-27 21:32:06', 'avalle'),
(10, 1, 5, 'Actualización de Asesor de  a Abraham Valle.', 1, '2018-12-28 01:45:07', 'avalle'),
(11, 1, 5, 'Actualización de Integradora de  a Integradora A.', 1, '2018-12-28 01:46:25', 'avalle'),
(12, 1, 5, 'Actualización de Asesor de Abraham Valle a Administrator.', 1, '2018-12-28 01:50:51', 'avalle'),
(13, 1, 5, 'Actualización de Integradora de Integradora A a Integradora B.', 1, '2018-12-28 01:51:05', 'avalle'),
(14, 1, 5, 'Actualización de Asesor de  a Abraham Valle.', 1, '2019-01-02 17:42:40', 'avalle'),
(15, 1, 5, 'Actualización de Asesor de  a Administrator.', 1, '2019-01-02 17:43:36', 'avalle'),
(16, 1, 5, 'Actualización de Asesor de Administrator a Abraham Valle.', 1, '2019-01-02 17:45:25', 'avalle'),
(17, 1, 1, 'Comentario nuevo: ''Prueba comentario''''. ', 1, '2019-01-02 17:46:08', 'avalle'),
(18, 1, 1, 'Cambio un Comentario, de ''Prueba comentario'' a ''Prueba comentario2''. ', 1, '2019-01-02 17:46:33', 'avalle');

-- --------------------------------------------------------

--
-- Table structure for table `ope_clientecoms`
--

CREATE TABLE IF NOT EXISTS `ope_clientecoms` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `idorigen` int(5) NOT NULL,
  `tipo` int(2) DEFAULT NULL,
  `descripcion` longtext,
  `fecha` datetime NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `ultactfec` varchar(25) DEFAULT NULL,
  `ultactusu` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `ope_clientecoms`
--

INSERT INTO `ope_clientecoms` (`id`, `idorigen`, `tipo`, `descripcion`, `fecha`, `usuario`, `ultactfec`, `ultactusu`) VALUES
(2, 1, 0, 'Prueba comentario2', '2019-01-02 17:46:08', 'avalle', '2019-01-02 17:46:33', 'avalle');

-- --------------------------------------------------------

--
-- Table structure for table `ope_formatos`
--

CREATE TABLE IF NOT EXISTS `ope_formatos` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `idpersona` int(5) NOT NULL,
  `idformato` varchar(200) NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `servicio` longtext NOT NULL,
  `honorarios` varchar(250) NOT NULL,
  `duracion` varchar(250) NOT NULL,
  `fecha` date NOT NULL,
  `puesto` varchar(200) NOT NULL,
  `departamento` varchar(200) NOT NULL,
  `actividades` longtext NOT NULL,
  `sueldodiario` longtext NOT NULL,
  `jornada` longtext NOT NULL,
  `persona` varchar(250) NOT NULL,
  `fechadoc` date NOT NULL,
  `lugar` longtext NOT NULL,
  `ultactfec` varchar(25) NOT NULL,
  `ultactusu` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `ope_formatos`
--

INSERT INTO `ope_formatos` (`id`, `idpersona`, `idformato`, `descripcion`, `servicio`, `honorarios`, `duracion`, `fecha`, `puesto`, `departamento`, `actividades`, `sueldodiario`, `jornada`, `persona`, `fechadoc`, `lugar`, `ultactfec`, `ultactusu`) VALUES
(1, 1, 'clienteformato1', 'Acuse', '', '', '', '2019-01-10', '', '', '', '', '', 'Juan Perez', '0000-00-00', 'Ciudad de México', '2019-01-03 16:33:14', 'avalle'),
(2, 1, 'clienteformato2', 'Crédito de línea IV sin garantía', '', '', '', '2019-01-16', '', '', '', '', '', 'Juan Perez', '0000-00-00', 'Mineral de la Reforma', '2019-01-03 17:56:23', 'avalle'),
(5, 1, 'clienteformato3', 'Contrato de Obra (Vitta)', '', '', '', '2019-01-15', '', '', '', '', '', '', '2019-01-31', '', '2019-01-07 07:46:59', 'avalle');

-- --------------------------------------------------------

--
-- Table structure for table `ope_hits`
--

CREATE TABLE IF NOT EXISTS `ope_hits` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `pagina` varchar(250) NOT NULL DEFAULT '',
  `usuario` varchar(200) NOT NULL,
  `descripcion` varchar(250) NOT NULL DEFAULT '',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `fecha` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `idusuario` int(5) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idusuario` (`idusuario`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `ope_hits`
--

INSERT INTO `ope_hits` (`id`, `pagina`, `usuario`, `descripcion`, `ip`, `fecha`, `idusuario`) VALUES
(1, 'acceso', '1', 'avalle', '127.0.0.1', '2018-12-26 11:44:36', 2),
(2, 'acceso', '1', 'avalle', '127.0.0.1', '2018-12-26 12:07:39', 2),
(3, 'acceso', '1', 'avalle', '127.0.0.1', '2018-12-26 13:12:56', 2),
(4, 'acceso', '1', 'avalle', '127.0.0.1', '2018-12-26 16:47:40', 2),
(5, 'acceso', '1', 'avalle', '127.0.0.1', '2018-12-29 14:38:03', 2),
(6, 'acceso', '1', 'avalle', '127.0.0.1', '2018-12-31 11:50:55', 2),
(7, 'acceso', '1', 'avalle', '127.0.0.1', '2018-12-31 11:51:19', 2),
(8, 'acceso', '1', 'avalle', '127.0.0.1', '2019-01-02 12:25:29', 2),
(9, 'acceso', '1', 'avalle', '127.0.0.1', '2019-01-07 07:46:10', 2),
(10, 'acceso', '1', 'avalle', '127.0.0.1', '2019-01-07 08:49:46', 2);

-- --------------------------------------------------------

--
-- Table structure for table `rel_recursos`
--

CREATE TABLE IF NOT EXISTS `rel_recursos` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `tipo` tinyint(2) NOT NULL,
  `idcliente` int(5) NOT NULL,
  `idrecurso` int(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `rel_recursos`
--

INSERT INTO `rel_recursos` (`id`, `tipo`, `idcliente`, `idrecurso`) VALUES
(3, 1, 1, 1),
(9, 2, 1, 17),
(4, 1, 1, 3),
(5, 1, 1, 5),
(6, 1, 1, 7),
(7, 1, 1, 9),
(8, 1, 1, 11),
(10, 2, 1, 21);

-- --------------------------------------------------------

--
-- Table structure for table `rel_usuarios`
--

CREATE TABLE IF NOT EXISTS `rel_usuarios` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `idusuario` int(5) NOT NULL,
  `idempresa` int(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `rel_usuarios`
--

INSERT INTO `rel_usuarios` (`id`, `idusuario`, `idempresa`) VALUES
(2, 1, 1),
(3, 2, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
