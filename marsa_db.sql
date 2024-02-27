-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-02-2024 a las 22:54:48
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
-- Base de datos: `marsa_db`
--
CREATE DATABASE IF NOT EXISTS `marsa_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `marsa_db`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_almacen`
--

CREATE TABLE `tb_almacen` (
  `IdAlma` int(11) NOT NULL,
  `IdProd` int(11) NOT NULL,
  `CantidadTotal` int(11) NOT NULL,
  `DateCreate` date NOT NULL,
  `DateUpdate` date NOT NULL,
  `HoraCreate` time NOT NULL,
  `HoraUpdate` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_almacen_merma`
--

CREATE TABLE `tb_almacen_merma` (
  `IdAlmacenMerma` int(11) NOT NULL,
  `IdProducto` int(11) NOT NULL,
  `IdSalida` int(11) NOT NULL,
  `IdIngresoDev` int(11) NOT NULL,
  `Cantidad` int(11) NOT NULL,
  `DateCreate` datetime NOT NULL,
  `TipoSalida` varchar(25) NOT NULL,
  `DateUpdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_categoriaprod`
--

CREATE TABLE `tb_categoriaprod` (
  `IdCate` int(11) NOT NULL,
  `NombreCategoria` varchar(255) NOT NULL,
  `DateCreate` datetime NOT NULL,
  `DateUpdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `tb_categoriaprod`
--

INSERT INTO `tb_categoriaprod` (`IdCate`, `NombreCategoria`, `DateCreate`, `DateUpdate`) VALUES
(1, 'Aceites', '2024-01-26 16:14:25', '2024-01-26 16:14:25'),
(2, 'Aceitunas', '2024-01-26 16:14:25', '2024-01-26 16:14:25'),
(3, 'Endulzantes y Jarabes', '2024-01-26 16:14:25', '2024-01-26 16:14:25'),
(4, 'Untables y Salsas', '2024-01-26 16:14:25', '2024-01-26 16:14:25'),
(5, 'Jugos y Bebidas', '2024-01-26 16:14:25', '2024-01-26 16:14:25'),
(6, 'Vinagres', '2024-01-26 16:14:25', '2024-01-26 16:14:25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_cliente`
--

CREATE TABLE `tb_cliente` (
  `IdCli` int(11) NOT NULL,
  `RucCli` varchar(255) DEFAULT NULL,
  `NombreCli` varchar(255) NOT NULL,
  `CorreoCli` varchar(255) DEFAULT NULL,
  `DireccionCli` varchar(255) DEFAULT NULL,
  `TelefonoCli` int(11) DEFAULT NULL,
  `Estado` int(11) NOT NULL,
  `DateCreate` datetime NOT NULL,
  `DateUpdate` datetime NOT NULL,
  `RazonSocial` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_estado`
--

CREATE TABLE `tb_estado` (
  `IdEstado` int(11) NOT NULL,
  `TipoEstado` varchar(255) NOT NULL,
  `Descripcion` varchar(255) NOT NULL,
  `DateCreate` datetime NOT NULL,
  `DateUpdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `tb_estado`
--

INSERT INTO `tb_estado` (`IdEstado`, `TipoEstado`, `Descripcion`, `DateCreate`, `DateUpdate`) VALUES
(1, 'Vigente', 'Estado vigente para productos', '2024-01-26 13:17:10', '2024-01-26 13:17:10'),
(2, 'Vencido', 'Estado vencido para productos', '2024-01-26 13:17:10', '2024-01-26 13:17:10'),
(3, 'Activo', 'Estado activo para personal', '2024-01-26 13:17:10', '2024-01-26 13:17:10'),
(4, 'Inactivo', 'Estado inactivo para personal', '2024-01-26 13:17:10', '2024-01-26 13:17:10'),
(5, 'Completado', 'Estado completado para nota pedido', '2024-01-26 13:17:10', '2024-01-26 13:17:10'),
(6, 'Devolucion', 'Estado de devolución para nota pedido y ingreso', '2024-01-26 13:17:10', '2024-01-26 13:17:10'),
(7, 'Ingresado', 'Estado de detalle de ingreso', '2024-01-26 16:09:22', '2024-01-26 16:09:22'),
(8, 'Retirado', 'Estado de salida para nota pedido', '2024-01-26 16:09:22', '2024-01-26 16:09:22'),
(9, 'Merma', 'Estado de detalle de perdida para ingreso', '2024-01-29 10:51:07', '2024-01-29 10:51:07');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_ingreso`
--

CREATE TABLE `tb_ingreso` (
  `IdIng` int(11) NOT NULL,
  `IdPer` int(11) NOT NULL,
  `DatosRefSalida` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `TipoIngreso` int(11) DEFAULT NULL,
  `DescripcionIng` varchar(250) DEFAULT NULL,
  `DatosProductosIngresoJson` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `FechaProduccionIng` date DEFAULT NULL,
  `FechaVencimientoIng` date DEFAULT NULL,
  `Estado` int(11) NOT NULL,
  `DateCreate` datetime NOT NULL,
  `DateUpdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_lote`
--

CREATE TABLE `tb_lote` (
  `IdLote` int(11) NOT NULL,
  `IdPer` int(11) NOT NULL,
  `IdCliente` int(11) NOT NULL,
  `CodigoLote` varchar(50) DEFAULT NULL,
  `DescripcionLote` varchar(150) DEFAULT NULL,
  `DatosLoteIngresoJson` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `FechaProduccionLote` date NOT NULL,
  `FechaVencimientoLote` date DEFAULT NULL,
  `Estado` int(11) NOT NULL,
  `FechaDevolucion` date DEFAULT NULL,
  `NroFactura` varchar(150) DEFAULT NULL,
  `DateCreate` datetime NOT NULL,
  `DateUpdate` datetime NOT NULL,
  `Observacion` varchar(255) DEFAULT NULL,
  `TipoSalida` varchar(35) NOT NULL,
  `TotalFactura` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_notapedido`
--

CREATE TABLE `tb_notapedido` (
  `IdNotaP` int(11) NOT NULL,
  `IdPer` int(11) NOT NULL,
  `IdRes` int(11) NOT NULL,
  `Observacion` varchar(255) NOT NULL,
  `EstadoNota` int(11) NOT NULL,
  `IdCliente` varchar(25) NOT NULL,
  `DatosProductosNotaPedidoJson` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `Total` decimal(10,2) NOT NULL,
  `FechaNotaPedido` date DEFAULT NULL,
  `FechaDevolucion` date DEFAULT NULL,
  `NroFactura` varchar(150) DEFAULT NULL,
  `DateCreate` datetime NOT NULL,
  `DateUpdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_personal`
--

CREATE TABLE `tb_personal` (
  `IdPer` int(11) NOT NULL,
  `IdTipoPer` int(11) NOT NULL,
  `dni` int(11) NOT NULL,
  `NombrePer` varchar(255) NOT NULL,
  `ApellidoPer` varchar(255) DEFAULT NULL,
  `TelefonoPer` varchar(12) DEFAULT NULL,
  `DireccionPer` varchar(255) DEFAULT NULL,
  `Estado` int(11) NOT NULL,
  `DateCreate` datetime NOT NULL,
  `DateUpdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_producto`
--

CREATE TABLE `tb_producto` (
  `IdProd` int(11) NOT NULL,
  `IdCate` int(11) NOT NULL,
  `NombreProducto` varchar(255) NOT NULL,
  `DetalleProducto` varchar(255) DEFAULT NULL,
  `Unidad` varchar(50) NOT NULL,
  `Cantidad` int(11) NOT NULL,
  `Precio` decimal(10,2) NOT NULL,
  `DateCreate` datetime NOT NULL,
  `DateUpdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `tb_producto`
--

INSERT INTO `tb_producto` (`IdProd`, `IdCate`, `NombreProducto`, `DetalleProducto`, `Unidad`, `Cantidad`, `Precio`, `DateCreate`, `DateUpdate`) VALUES
(1, 1, 'Aceite de Ajonjolí x 250ml.', NULL, 'ml', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(2, 1, 'Aceite de Castaña x 250ml.', NULL, 'ml', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(3, 1, 'Aceite de Chía x 250ml.', NULL, 'ml', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(4, 1, 'Aceite de Coco x 120gr.', NULL, 'gr', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(5, 1, 'Aceite de Coco x 200gr.', NULL, 'gr', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(6, 1, 'Aceite de Coco x 350gr.', NULL, 'gr', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(7, 1, 'Aceite de Coco x 710gr.', NULL, 'gr', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(8, 1, 'Aceite de Linaza x 250ml.', NULL, 'ml', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(9, 1, 'Aceite de Olivo Extra x 1L.', 'PET', 'L', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(10, 1, 'Aceite de Olivo Extra x 200ml.', 'Vidrio', 'ml', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(11, 1, 'Aceite de Olivo Extra x 200ml.', 'PET', 'ml', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(12, 1, 'Aceite de Olivo Extra x 250ml.', 'Vidrio', 'ml', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(13, 1, 'Aceite de Olivo Extra x 250ml.', 'Vidrio', 'ml', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(14, 1, 'Aceite de Olivo Extra x 275', 'Spray', 'ml', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(15, 1, 'Aceite de Olivo Extra x 500 ', 'Spray', 'ml', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(16, 1, 'Aceite de Olivo Extra x 500 ', 'Vidrio Oscuro', 'ml', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(17, 1, 'Aceite de Olivo Extra x 500 ', 'Vidrio', 'ml', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(18, 1, 'Aceite de Olivo Extra x 500ml.', 'PET', 'ml', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(19, 1, 'Aceite de Olivo Extra x 500ml.', 'Vidrio', 'ml', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(20, 1, 'Aceite de Olivo Extra x 1L.', 'PET', 'L', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(21, 1, 'Aceite de Olivo Extra x 1L. ', 'Vidrio Verde', 'L', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(22, 1, 'Aceite de Olivo Extravirgen x 5L.', NULL, 'L', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(23, 1, 'Aceite de Olivo Virgen x 200ml. ', 'PET', 'ml', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(24, 1, 'Aceite de Olivo Virgen x 250ml.', NULL, 'ml', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(25, 1, 'Aceite de Olivo Virgen x 500', 'Vidrio', 'ml', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(26, 1, 'Aceite de Olivo Virgen x 500ml.', 'PET', 'ml', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(27, 1, 'Aceite de Olivo Virgen x 1L.', 'PET', 'L', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(28, 1, 'Aceite de Sacha Inchi x 250ml.', NULL, 'ml', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(30, 2, 'Aceituna Negra 1ra x Balde 15kg.', NULL, 'kg', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(31, 2, 'Aceituna Negra 250gr.', NULL, 'gr', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(32, 2, 'Aceituna Negra 500gr.', NULL, 'gr', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(33, 2, 'Aceituna Negra Cocktail kg.', NULL, 'kg', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(34, 2, 'Aceituna Negra Deshuesada 250gr.', NULL, 'gr', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(35, 2, 'Aceituna Negra Deshuesada 500gr.', NULL, 'gr', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(36, 2, 'Aceituna Negra Deshuesada Premium kg.', NULL, 'kg', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(38, 2, 'Aceituna Negra Rodaja 250gr.', NULL, 'gr', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(39, 2, 'Aceituna Negra Rodaja 500gr.', NULL, 'gr', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(40, 2, 'Aceituna Negra Rodaja kg.', NULL, 'kg', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(41, 2, 'Aceituna Negra x 1kg.', NULL, 'kg', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(42, 2, 'Aceituna Premium kg.', 'Extra', 'kg', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(43, 2, 'Aceituna Primera kg. Promoción', NULL, 'kg', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(44, 2, 'Aceituna Verde 250gr.', NULL, 'gr', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(45, 2, 'Aceituna Verde 500gr.', NULL, 'gr', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(46, 2, 'Aceituna Verde Deshuesada 250gr.', NULL, 'gr', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(47, 2, 'Aceituna Verde Deshuesada 500gr.', NULL, 'gr', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(48, 2, 'Aceituna Verde Deshuesada kg.', NULL, 'kg', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(49, 2, 'Aceituna Verde kg.', NULL, 'kg', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(50, 2, 'Aceituna Verde Relleno Pimiento 250gr.', NULL, 'gr', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(51, 2, 'Aceituna Verde Relleno Pimiento 500gr.', NULL, 'gr', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(52, 2, 'Aceituna Verde Relleno Pimiento kg.', NULL, 'kg', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(53, 2, 'Aceituna Verde Relleno Pimiento x 500gr.', NULL, 'gr', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(54, 2, 'Aceituna Verde Relleno Rocoto 250gr.', NULL, 'gr', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(55, 2, 'Aceituna Verde Relleno Rocoto kg.', NULL, 'kg', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(56, 2, 'Aceituna Verde Rocoto x 500gr.', NULL, 'gr', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(57, 2, 'Aceituna Verde Rodaja 250gr.', NULL, 'gr', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(58, 2, 'Aceituna Verde Rodaja 500gr.', NULL, 'gr', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(59, 2, 'Aceituna Verde Rodaja kg.', NULL, 'kg', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(60, 2, 'Aceituna Verde x 1kg. a granel', NULL, 'kg', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(61, 2, 'Aceituna Verde x Balde de 15kg.', NULL, 'kg', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(62, 2, 'Bidón Aceituna Negra x 2kg.', '1era', 'kg', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(63, 2, 'Bidón Aceituna Negra x 2kg.', '3era', 'kg', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(64, 2, 'Bidón de Aceituna Verde x 2kg.', NULL, 'kg', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(65, 3, 'Algarrobina x 500 ', 'PET', 'ml', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(66, 3, 'Algarrobina x 500 ', 'Vidrio', 'ml', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(67, 3, 'Miel de Abeja x 1.100gr.', NULL, 'gr', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(68, 3, 'Miel de Abeja x 500gr.', NULL, 'gr', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(69, 3, 'Miel de Abeja x 500 ', 'PET', 'gr', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(70, 3, 'Miel de Caña x 500 ', 'PET', 'gr', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(71, 3, 'Panela x 500gr.', NULL, 'gr', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(72, 3, 'Panela x kg.', NULL, 'kg', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(73, 3, 'Panela x saco kg.', NULL, 'kg', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(74, 4, 'Crema de Aceituna 250gr.', NULL, 'gr', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(75, 4, 'Crema de Aceituna 500gr.', NULL, 'gr', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(76, 5, 'Manzana 2L.', NULL, 'L', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(77, 5, 'Manzana Premium 1L.', NULL, 'L', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(78, 5, 'Maracuyá Normal 2L.', NULL, 'L', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(79, 5, 'Maracuyá Premium 1L.', NULL, 'L', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(80, 5, 'Piña 2L.', NULL, 'L', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(81, 5, 'Piña Premium 1L.', NULL, 'L', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(82, 5, 'Cebada 2L.', NULL, 'L', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(83, 5, 'Cebada Premium 1L.', NULL, 'L', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(84, 5, 'Maíz Morado Premium 1L.', NULL, 'L', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(85, 5, 'Maíz Morado Premium 2L.', NULL, 'L', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(86, 5, 'Membrillo 1L.', NULL, 'L', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(87, 5, 'Membrillo 2L.', NULL, 'L', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(88, 6, 'Vinagre de Manzana x 1L.', 'PET', 'L', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(89, 6, 'Vinagre de Manzana x 1L.', 'Vidrio', 'L', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(90, 6, 'Vinagre de Manzana x 200ml.', 'PET', 'ml', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(91, 6, 'Vinagre de Manzana x 280', 'Spray', 'ml', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(92, 6, 'Vinagre de Manzana x 500', 'PET', 'ml', 1, 50.00, '2024-01-26 16:14:30', '2024-02-02 08:40:38'),
(93, 6, 'Vinagre de Manzana x 500', 'Vidrio', 'ml', 1, 50.00, '2024-01-26 16:14:30', '2024-02-02 08:40:26'),
(94, 6, 'Vinagre de Manzana x 500', 'Spray', 'ml', 1, 50.00, '2024-01-26 16:14:30', '2024-02-02 08:40:13'),
(95, 5, 'Cañita de  Azucarrrr', 'Azucarararara', 'Kg', 1, 12.00, '2024-02-12 00:09:26', '2024-02-13 11:48:48'),
(96, 4, 'Nuevo Producto', '1333', 'unidad', 0, 123.00, '2024-02-20 16:40:38', '2024-02-20 16:40:46');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_tipopersonal`
--

CREATE TABLE `tb_tipopersonal` (
  `IdTipoPer` int(11) NOT NULL,
  `DescripcionTipoPer` varchar(255) NOT NULL,
  `DateCreate` datetime NOT NULL,
  `DateUpdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `tb_tipopersonal`
--

INSERT INTO `tb_tipopersonal` (`IdTipoPer`, `DescripcionTipoPer`, `DateCreate`, `DateUpdate`) VALUES
(1, 'Responsable', '2023-09-14 11:54:27', '2023-09-14 11:54:27'),
(2, 'Operario', '2023-09-14 11:54:27', '2023-09-14 11:54:27'),
(3, 'Vendedor', '2023-09-14 11:54:27', '2023-09-14 11:54:27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_tipousuario`
--

CREATE TABLE `tb_tipousuario` (
  `IdTipoUsu` int(11) NOT NULL,
  `DescripcionTipo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `tb_tipousuario`
--

INSERT INTO `tb_tipousuario` (`IdTipoUsu`, `DescripcionTipo`) VALUES
(1, 'Administrador'),
(2, 'Responsable');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_usuario`
--

CREATE TABLE `tb_usuario` (
  `IdUsu` int(11) NOT NULL,
  `IdTipoUsu` int(11) NOT NULL,
  `NombreUsu` varchar(255) NOT NULL,
  `Nombre` varchar(255) NOT NULL,
  `Apellido` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `LastConnection` datetime DEFAULT NULL,
  `DateCreate` datetime NOT NULL,
  `DateUpdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `tb_usuario`
--

INSERT INTO `tb_usuario` (`IdUsu`, `IdTipoUsu`, `NombreUsu`, `Nombre`, `Apellido`, `password`, `LastConnection`, `DateCreate`, `DateUpdate`) VALUES
(6, 1, 'admin', 'Administrador', 'administrador', '$argon2id$v=19$m=4096,t=2,p=2$ZURZWG0yNkNOZVJTLlg5Lw$MvzbwXUNlV+Inxssd1nN+A8EN5Il6CdSAs7pTc3szJk', '2024-02-27 16:53:21', '2024-02-16 12:09:23', '2024-02-16 12:09:23');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tb_almacen`
--
ALTER TABLE `tb_almacen`
  ADD PRIMARY KEY (`IdAlma`) USING BTREE,
  ADD KEY `IdProd` (`IdProd`) USING BTREE;

--
-- Indices de la tabla `tb_almacen_merma`
--
ALTER TABLE `tb_almacen_merma`
  ADD PRIMARY KEY (`IdAlmacenMerma`) USING BTREE;

--
-- Indices de la tabla `tb_categoriaprod`
--
ALTER TABLE `tb_categoriaprod`
  ADD PRIMARY KEY (`IdCate`) USING BTREE;

--
-- Indices de la tabla `tb_cliente`
--
ALTER TABLE `tb_cliente`
  ADD PRIMARY KEY (`IdCli`) USING BTREE;

--
-- Indices de la tabla `tb_estado`
--
ALTER TABLE `tb_estado`
  ADD PRIMARY KEY (`IdEstado`) USING BTREE;

--
-- Indices de la tabla `tb_ingreso`
--
ALTER TABLE `tb_ingreso`
  ADD PRIMARY KEY (`IdIng`) USING BTREE,
  ADD KEY `IdPer` (`IdPer`) USING BTREE;

--
-- Indices de la tabla `tb_lote`
--
ALTER TABLE `tb_lote`
  ADD PRIMARY KEY (`IdLote`) USING BTREE,
  ADD KEY `IdPer` (`IdPer`) USING BTREE;

--
-- Indices de la tabla `tb_notapedido`
--
ALTER TABLE `tb_notapedido`
  ADD PRIMARY KEY (`IdNotaP`) USING BTREE,
  ADD KEY `IdPer` (`IdPer`) USING BTREE;

--
-- Indices de la tabla `tb_personal`
--
ALTER TABLE `tb_personal`
  ADD PRIMARY KEY (`IdPer`) USING BTREE,
  ADD KEY `IdTipoPer` (`IdTipoPer`) USING BTREE;

--
-- Indices de la tabla `tb_producto`
--
ALTER TABLE `tb_producto`
  ADD PRIMARY KEY (`IdProd`) USING BTREE,
  ADD KEY `IdCate` (`IdCate`) USING BTREE;

--
-- Indices de la tabla `tb_tipopersonal`
--
ALTER TABLE `tb_tipopersonal`
  ADD PRIMARY KEY (`IdTipoPer`) USING BTREE;

--
-- Indices de la tabla `tb_tipousuario`
--
ALTER TABLE `tb_tipousuario`
  ADD PRIMARY KEY (`IdTipoUsu`) USING BTREE;

--
-- Indices de la tabla `tb_usuario`
--
ALTER TABLE `tb_usuario`
  ADD PRIMARY KEY (`IdUsu`) USING BTREE,
  ADD KEY `IdTipoUsu` (`IdTipoUsu`) USING BTREE;

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tb_almacen`
--
ALTER TABLE `tb_almacen`
  MODIFY `IdAlma` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `tb_almacen_merma`
--
ALTER TABLE `tb_almacen_merma`
  MODIFY `IdAlmacenMerma` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tb_categoriaprod`
--
ALTER TABLE `tb_categoriaprod`
  MODIFY `IdCate` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `tb_cliente`
--
ALTER TABLE `tb_cliente`
  MODIFY `IdCli` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `tb_estado`
--
ALTER TABLE `tb_estado`
  MODIFY `IdEstado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `tb_ingreso`
--
ALTER TABLE `tb_ingreso`
  MODIFY `IdIng` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT de la tabla `tb_lote`
--
ALTER TABLE `tb_lote`
  MODIFY `IdLote` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT de la tabla `tb_notapedido`
--
ALTER TABLE `tb_notapedido`
  MODIFY `IdNotaP` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `tb_personal`
--
ALTER TABLE `tb_personal`
  MODIFY `IdPer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `tb_producto`
--
ALTER TABLE `tb_producto`
  MODIFY `IdProd` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT de la tabla `tb_tipopersonal`
--
ALTER TABLE `tb_tipopersonal`
  MODIFY `IdTipoPer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tb_tipousuario`
--
ALTER TABLE `tb_tipousuario`
  MODIFY `IdTipoUsu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tb_usuario`
--
ALTER TABLE `tb_usuario`
  MODIFY `IdUsu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tb_almacen`
--
ALTER TABLE `tb_almacen`
  ADD CONSTRAINT `tb_almacen_ibfk_1` FOREIGN KEY (`IdProd`) REFERENCES `tb_producto` (`IdProd`);

--
-- Filtros para la tabla `tb_ingreso`
--
ALTER TABLE `tb_ingreso`
  ADD CONSTRAINT `tb_ingreso_ibfk_1` FOREIGN KEY (`IdPer`) REFERENCES `tb_personal` (`IdPer`);

--
-- Filtros para la tabla `tb_lote`
--
ALTER TABLE `tb_lote`
  ADD CONSTRAINT `tb_lote_ibfk_1` FOREIGN KEY (`IdPer`) REFERENCES `tb_personal` (`IdPer`);

--
-- Filtros para la tabla `tb_notapedido`
--
ALTER TABLE `tb_notapedido`
  ADD CONSTRAINT `tb_notapedido_ibfk_1` FOREIGN KEY (`IdPer`) REFERENCES `tb_personal` (`IdPer`);

--
-- Filtros para la tabla `tb_personal`
--
ALTER TABLE `tb_personal`
  ADD CONSTRAINT `tb_personal_ibfk_1` FOREIGN KEY (`IdTipoPer`) REFERENCES `tb_tipopersonal` (`IdTipoPer`);

--
-- Filtros para la tabla `tb_producto`
--
ALTER TABLE `tb_producto`
  ADD CONSTRAINT `tb_producto_ibfk_1` FOREIGN KEY (`IdCate`) REFERENCES `tb_categoriaprod` (`IdCate`);

--
-- Filtros para la tabla `tb_usuario`
--
ALTER TABLE `tb_usuario`
  ADD CONSTRAINT `tb_usuario_ibfk_1` FOREIGN KEY (`IdTipoUsu`) REFERENCES `tb_tipousuario` (`IdTipoUsu`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
