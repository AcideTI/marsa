-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-01-2024 a las 17:35:42
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
-- Base de datos: `db_marsa`
--
CREATE DATABASE IF NOT EXISTS `db_marsa` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
USE `db_marsa`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_almacen`
--

CREATE TABLE `tb_almacen` (
  `IdAlma` int(11) NOT NULL,
  `IdIngDet` int(11) NOT NULL,
  `IdProd` int(11) NOT NULL,
  `CantidadTotal` int(250) NOT NULL,
  `FechaProduccion` datetime NOT NULL,
  `FechaReingreso` datetime DEFAULT NULL,
  `Estado` int(10) DEFAULT NULL,
  `DateCreate` datetime NOT NULL,
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
(1, 'Aceites', '2024-01-26 11:25:44', '2024-01-26 11:25:44'),
(2, 'Aceitunas', '2024-01-26 11:25:44', '2024-01-26 11:25:44'),
(3, 'Endulzantes y Jarabes', '2024-01-26 11:25:44', '2024-01-26 11:25:44'),
(4, 'Untables y Salsas', '2024-01-26 11:25:44', '2024-01-26 11:25:44'),
(5, 'Jugos y Bebidas', '2024-01-26 11:25:44', '2024-01-26 11:25:44'),
(6, 'Vinagres', '2024-01-26 11:25:44', '2024-01-26 11:25:44');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_cliente`
--

CREATE TABLE `tb_cliente` (
  `IdCli` int(11) NOT NULL,
  `RucCli` varchar(255) DEFAULT NULL,
  `NombreCli` varchar(255) NOT NULL,
  `CorreoCli` varchar(255) NOT NULL,
  `DireccionCli` varchar(255) NOT NULL,
  `TelefonoCli` int(12) NOT NULL,
  `Estado` int(10) NOT NULL,
  `DateCreate` datetime NOT NULL,
  `DateUpdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `tb_cliente`
--

INSERT INTO `tb_cliente` (`IdCli`, `RucCli`, `NombreCli`, `CorreoCli`, `DireccionCli`, `TelefonoCli`, `Estado`, `DateCreate`, `DateUpdate`) VALUES
(1, '01234567890123456789', 'cliente 1', 'clientecorreo@gmail.com', 'Cliente Dirreccion', 123456789, 3, '2023-09-14 11:54:27', '2024-01-26 10:39:06'),
(7, '098765432101234567890', 'Cliente 2', 'clientecorreo2@gmail.com', 'Direccion Cliente 2', 987654321, 4, '2024-01-26 10:40:00', '2024-01-26 10:40:09');

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
(1, 'Vigente', 'Estado vigente para productos', '2024-01-26 11:24:24', '2024-01-26 11:24:24'),
(2, 'Vencido', 'Estado vencido para productos', '2024-01-26 11:24:24', '2024-01-26 11:24:24'),
(3, 'Activo', 'Estado activo para personal', '2024-01-26 11:24:24', '2024-01-26 11:24:24'),
(4, 'Inactivo', 'Estado inactivo para personal', '2024-01-26 11:24:24', '2024-01-26 11:24:24'),
(5, 'Completado', 'Estado completado para nota perdido', '2024-01-26 11:24:24', '2024-01-26 11:24:24'),
(6, 'Devolucion', 'Estado de devolución para nota pedido', '2024-01-26 11:24:24', '2024-01-26 11:24:24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_ingreso`
--

CREATE TABLE `tb_ingreso` (
  `IdIng` int(11) NOT NULL,
  `IdPer` int(11) NOT NULL,
  `IdProd` int(11) NOT NULL,
  `DescripcionIng` varchar(255) NOT NULL,
  `CantidadIng` int(150) NOT NULL,
  `FechaProduccion` datetime NOT NULL,
  `FechaVencimiento` datetime NOT NULL,
  `FechaReingreso` datetime DEFAULT NULL,
  `Estado` int(10) NOT NULL,
  `DateCreate` datetime NOT NULL,
  `DateUpdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_ingresodetalle`
--

CREATE TABLE `tb_ingresodetalle` (
  `IdIngDet` int(11) NOT NULL,
  `IdIng` int(11) NOT NULL,
  `IdProd` int(11) NOT NULL,
  `CantidadDet` int(250) NOT NULL,
  `DateCreate` datetime NOT NULL,
  `DateUpdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_lote`
--

CREATE TABLE `tb_lote` (
  `IdLote` int(11) NOT NULL,
  `IdAlma` int(11) DEFAULT NULL,
  `IdPer` int(11) NOT NULL,
  `CodigoLote` int(15) NOT NULL,
  `Lote` varchar(255) NOT NULL,
  `Cantidad` int(255) NOT NULL,
  `Estado` int(10) NOT NULL,
  `FechaProduccion` datetime NOT NULL,
  `FechaVencimiento` datetime NOT NULL,
  `DateCreate` datetime NOT NULL,
  `DateUpdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_notapedido`
--

CREATE TABLE `tb_notapedido` (
  `IdNotaP` int(11) NOT NULL,
  `IdAlma` int(11) DEFAULT NULL,
  `IdLote` int(11) DEFAULT NULL,
  `IdPer` int(11) NOT NULL,
  `NombreCliNota` int(15) NOT NULL,
  `RucCli` int(15) NOT NULL,
  `DireccionCliNota` varchar(255) NOT NULL,
  `ProductoNota` varchar(255) NOT NULL,
  `CantidadNota` int(255) NOT NULL,
  `PrecioNota` decimal(10,2) NOT NULL,
  `SubTotal` decimal(10,2) NOT NULL,
  `IGV` decimal(10,2) NOT NULL,
  `Total` decimal(10,2) NOT NULL,
  `Estado` int(10) NOT NULL,
  `FechaNotaPedido` datetime NOT NULL,
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
  `ApellidoPer` varchar(255) NOT NULL,
  `TelefonoPer` varchar(12) NOT NULL,
  `DireccionPer` varchar(255) NOT NULL,
  `Estado` int(10) NOT NULL,
  `DateCreate` datetime NOT NULL,
  `DateUpdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `tb_personal`
--

INSERT INTO `tb_personal` (`IdPer`, `IdTipoPer`, `dni`, `NombrePer`, `ApellidoPer`, `TelefonoPer`, `DireccionPer`, `Estado`, `DateCreate`, `DateUpdate`) VALUES
(1, 1, 123456789, 'NombreResponsable', 'ApellidoResponsable', '1234567890', 'DirecciónResponsable', 3, '2023-09-14 11:54:27', '2023-09-14 11:54:27'),
(2, 2, 987654321, 'NombreOperario', 'ApellidoOperario', '9876543210', 'DirecciónOperario', 3, '2023-09-14 11:54:27', '2023-09-14 11:54:27'),
(3, 3, 456789012, 'NombreVendedor', 'ApellidoVendedor', '4567890123', 'DirecciónVendedor', 4, '2023-09-14 11:54:27', '2024-01-26 11:28:50');

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
  `Cantidad` int(250) NOT NULL,
  `Precio` decimal(10,2) DEFAULT NULL,
  `DateCreate` datetime NOT NULL,
  `DateUpdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `tb_producto`
--

INSERT INTO `tb_producto` (`IdProd`, `IdCate`, `NombreProducto`, `DetalleProducto`, `Unidad`, `Cantidad`, `Precio`, `DateCreate`, `DateUpdate`) VALUES
(1, 1, 'Aceite de Ajonjolí x 250ml.', NULL, 'ml', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(2, 1, 'Aceite de Castaña x 250ml.', NULL, 'ml', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(3, 1, 'Aceite de Chía x 250ml.', NULL, 'ml', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(4, 1, 'Aceite de Coco x 120gr.', NULL, 'gr', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(5, 1, 'Aceite de Coco x 200gr.', NULL, 'gr', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(6, 1, 'Aceite de Coco x 350gr.', NULL, 'gr', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(7, 1, 'Aceite de Coco x 710gr.', NULL, 'gr', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(8, 1, 'Aceite de Linaza x 250ml.', NULL, 'ml', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(9, 1, 'Aceite de Olivo Extra x 1L.', 'PET', 'L', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(10, 1, 'Aceite de Olivo Extra x 200ml.', 'Vidrio', 'ml', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(11, 1, 'Aceite de Olivo Extra x 200ml.', 'PET', 'ml', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(12, 1, 'Aceite de Olivo Extra x 250ml.', 'Vidrio', 'ml', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(13, 1, 'Aceite de Olivo Extra x 250ml.', 'Vidrio', 'ml', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(14, 1, 'Aceite de Olivo Extra x 275', 'Spray', 'ml', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(15, 1, 'Aceite de Olivo Extra x 500 ', 'Spray', 'ml', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(16, 1, 'Aceite de Olivo Extra x 500 ', 'Vidrio Oscuro', 'ml', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(17, 1, 'Aceite de Olivo Extra x 500 ', 'Vidrio', 'ml', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(18, 1, 'Aceite de Olivo Extra x 500ml.', 'PET', 'ml', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(19, 1, 'Aceite de Olivo Extra x 500ml.', 'Vidrio', 'ml', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(20, 1, 'Aceite de Olivo Extra x 1L.', 'PET', 'L', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(21, 1, 'Aceite de Olivo Extra x 1L. ', 'Vidrio Verde', 'L', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(22, 1, 'Aceite de Olivo Extravirgen x 5L.', NULL, 'L', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(23, 1, 'Aceite de Olivo Virgen x 200ml. ', 'PET', 'ml', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(24, 1, 'Aceite de Olivo Virgen x 250ml.', NULL, 'ml', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(25, 1, 'Aceite de Olivo Virgen x 500', 'Vidrio', 'ml', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(26, 1, 'Aceite de Olivo Virgen x 500ml.', 'PET', 'ml', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(27, 1, 'Aceite de Olivo Virgen x 1L.', 'PET', 'L', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(28, 1, 'Aceite de Sacha Inchi x 250ml.', NULL, 'ml', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(29, 2, 'Aceituna Negra 1ra Manchada x Balde de 15kg.', NULL, 'kg', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(30, 2, 'Aceituna Negra 1ra x Balde 15kg.', NULL, 'kg', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(31, 2, 'Aceituna Negra 250gr.', NULL, 'gr', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(32, 2, 'Aceituna Negra 500gr.', NULL, 'gr', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(33, 2, 'Aceituna Negra Cocktail kg.', NULL, 'kg', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(34, 2, 'Aceituna Negra Deshuesada 250gr.', NULL, 'gr', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(35, 2, 'Aceituna Negra Deshuesada 500gr.', NULL, 'gr', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(36, 2, 'Aceituna Negra Deshuesada Premium kg.', NULL, 'kg', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(37, 2, 'Aceituna Negra Premium 500gr.', NULL, 'gr', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(38, 2, 'Aceituna Negra Rodaja 250gr.', NULL, 'gr', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(39, 2, 'Aceituna Negra Rodaja 500gr.', NULL, 'gr', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(40, 2, 'Aceituna Negra Rodaja kg.', NULL, 'kg', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(41, 2, 'Aceituna Negra x 1kg.', NULL, 'kg', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(42, 2, 'Aceituna Premium kg.', 'Extra', 'kg', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(43, 2, 'Aceituna Primera kg. Promoción', NULL, 'kg', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(44, 2, 'Aceituna Verde 250gr.', NULL, 'gr', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(45, 2, 'Aceituna Verde 500gr.', NULL, 'gr', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(46, 2, 'Aceituna Verde Deshuesada 250gr.', NULL, 'gr', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(47, 2, 'Aceituna Verde Deshuesada 500gr.', NULL, 'gr', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(48, 2, 'Aceituna Verde Deshuesada kg.', NULL, 'kg', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(49, 2, 'Aceituna Verde kg.', NULL, 'kg', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(50, 2, 'Aceituna Verde Relleno Pimiento 250gr.', NULL, 'gr', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(51, 2, 'Aceituna Verde Relleno Pimiento 500gr.', NULL, 'gr', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(52, 2, 'Aceituna Verde Relleno Pimiento kg.', NULL, 'kg', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(53, 2, 'Aceituna Verde Relleno Pimiento x 500gr.', NULL, 'gr', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(54, 2, 'Aceituna Verde Relleno Rocoto 250gr.', NULL, 'gr', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(55, 2, 'Aceituna Verde Relleno Rocoto kg.', NULL, 'kg', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(56, 2, 'Aceituna Verde Rocoto x 500gr.', NULL, 'gr', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(57, 2, 'Aceituna Verde Rodaja 250gr.', NULL, 'gr', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(58, 2, 'Aceituna Verde Rodaja 500gr.', NULL, 'gr', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(59, 2, 'Aceituna Verde Rodaja kg.', NULL, 'kg', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(60, 2, 'Aceituna Verde x 1kg. a granel', NULL, 'kg', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(61, 2, 'Aceituna Verde x Balde de 15kg.', NULL, 'kg', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(62, 2, 'Bidón Aceituna Negra x 2kg.', '1era', 'kg', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(63, 2, 'Bidón Aceituna Negra x 2kg.', '3era', 'kg', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(64, 2, 'Bidón de Aceituna Verde x 2kg.', NULL, 'kg', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(65, 3, 'Algarrobina x 500 ', 'PET', 'ml', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(66, 3, 'Algarrobina x 500 ', 'Vidrio', 'ml', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(67, 3, 'Miel de Abeja x 1.100gr.', NULL, 'gr', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(68, 3, 'Miel de Abeja x 500gr.', NULL, 'gr', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(69, 3, 'Miel de Abeja x 500 ', 'PET', 'gr', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(70, 3, 'Miel de Caña x 500 ', 'PET', 'gr', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(71, 3, 'Panela x 500gr.', NULL, 'gr', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(72, 3, 'Panela x kg.', NULL, 'kg', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(73, 3, 'Panela x saco kg.', NULL, 'kg', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(74, 4, 'Crema de Aceituna 250gr.', NULL, 'gr', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(75, 4, 'Crema de Aceituna 500gr.', NULL, 'gr', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(76, 5, 'Manzana 2L.', NULL, 'L', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(77, 5, 'Manzana Premium 1L.', NULL, 'L', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(78, 5, 'Maracuyá Normal 2L.', NULL, 'L', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(79, 5, 'Maracuyá Premium 1L.', NULL, 'L', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(80, 5, 'Piña 2L.', NULL, 'L', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(81, 5, 'Piña Premium 1L.', NULL, 'L', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(82, 5, 'Cebada 2L.', NULL, 'L', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(83, 5, 'Cebada Premium 1L.', NULL, 'L', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(84, 5, 'Maíz Morado Premium 1L.', NULL, 'L', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(85, 5, 'Maíz Morado Premium 2L.', NULL, 'L', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(86, 5, 'Membrillo 1L.', NULL, 'L', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(87, 5, 'Membrillo 2L.', NULL, 'L', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(88, 6, 'Vinagre de Manzana x 1L.', 'PET', 'L', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(89, 6, 'Vinagre de Manzana x 1L.', 'Vidrio', 'L', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(90, 6, 'Vinagre de Manzana x 200ml.', 'PET', 'ml', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(91, 6, 'Vinagre de Manzana x 280', 'Spray', 'ml', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(92, 6, 'Vinagre de Manzana x 500', 'PET', 'ml', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(93, 6, 'Vinagre de Manzana x 500', 'Vidrio', 'ml', 1, NULL, '2024-01-26 11:26:31', '2024-01-26 11:26:31'),
(94, 6, 'Vinagre de Manzana x 500', 'Spray', 'ml', 0, 0.00, '2024-01-26 11:26:31', '2024-01-26 11:31:45');

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
(2, 'Responsable'),
(3, 'Usuario Tipo 2');

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
(1, 1, 'admin', 'David', 'Poblette', '$argon2id$v=19$m=4096,t=2,p=2$UWpleWtkc2hqM3RXeXlxbg$8On5PLoftLU6P/RR7R6AYdbYsYRg1uWLmZOL7Fc/bY8', '2024-01-12 16:35:33', '2023-09-14 11:54:27', '2023-09-14 11:54:27'),
(2, 1, 'admin3', 'Alex', 'Flores', '$argon2id$v=19$m=4096,t=2,p=2$UWpleWtkc2hqM3RXeXlxbg$8On5PLoftLU6P/RR7R6AYdbYsYRg1uWLmZOL7Fc/bY8', '2024-01-12 16:35:33', '2023-09-14 11:54:27', '2023-09-14 11:54:27'),
(3, 2, 'alex', 'Alex R', 'Flores R', '$argon2id$v=19$m=4096,t=2,p=2$UWpleWtkc2hqM3RXeXlxbg$8On5PLoftLU6P/RR7R6AYdbYsYRg1uWLmZOL7Fc/bY8', '2024-01-26 11:28:36', '2023-09-14 11:54:27', '2023-09-14 11:54:27');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tb_almacen`
--
ALTER TABLE `tb_almacen`
  ADD PRIMARY KEY (`IdAlma`),
  ADD KEY `IdIngDet` (`IdIngDet`),
  ADD KEY `IdProd` (`IdProd`);

--
-- Indices de la tabla `tb_categoriaprod`
--
ALTER TABLE `tb_categoriaprod`
  ADD PRIMARY KEY (`IdCate`);

--
-- Indices de la tabla `tb_cliente`
--
ALTER TABLE `tb_cliente`
  ADD PRIMARY KEY (`IdCli`);

--
-- Indices de la tabla `tb_estado`
--
ALTER TABLE `tb_estado`
  ADD PRIMARY KEY (`IdEstado`);

--
-- Indices de la tabla `tb_ingreso`
--
ALTER TABLE `tb_ingreso`
  ADD PRIMARY KEY (`IdIng`),
  ADD KEY `IdPer` (`IdPer`),
  ADD KEY `IdProd` (`IdProd`);

--
-- Indices de la tabla `tb_ingresodetalle`
--
ALTER TABLE `tb_ingresodetalle`
  ADD PRIMARY KEY (`IdIngDet`),
  ADD KEY `IdIng` (`IdIng`),
  ADD KEY `IdProd` (`IdProd`);

--
-- Indices de la tabla `tb_lote`
--
ALTER TABLE `tb_lote`
  ADD PRIMARY KEY (`IdLote`),
  ADD KEY `IdAlma` (`IdAlma`),
  ADD KEY `IdPer` (`IdPer`);

--
-- Indices de la tabla `tb_notapedido`
--
ALTER TABLE `tb_notapedido`
  ADD PRIMARY KEY (`IdNotaP`),
  ADD KEY `IdAlma` (`IdAlma`),
  ADD KEY `IdLote` (`IdLote`),
  ADD KEY `IdPer` (`IdPer`);

--
-- Indices de la tabla `tb_personal`
--
ALTER TABLE `tb_personal`
  ADD PRIMARY KEY (`IdPer`),
  ADD KEY `IdTipoPer` (`IdTipoPer`);

--
-- Indices de la tabla `tb_producto`
--
ALTER TABLE `tb_producto`
  ADD PRIMARY KEY (`IdProd`),
  ADD KEY `IdCate` (`IdCate`);

--
-- Indices de la tabla `tb_tipopersonal`
--
ALTER TABLE `tb_tipopersonal`
  ADD PRIMARY KEY (`IdTipoPer`);

--
-- Indices de la tabla `tb_tipousuario`
--
ALTER TABLE `tb_tipousuario`
  ADD PRIMARY KEY (`IdTipoUsu`);

--
-- Indices de la tabla `tb_usuario`
--
ALTER TABLE `tb_usuario`
  ADD PRIMARY KEY (`IdUsu`),
  ADD KEY `IdTipoUsu` (`IdTipoUsu`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tb_almacen`
--
ALTER TABLE `tb_almacen`
  MODIFY `IdAlma` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tb_categoriaprod`
--
ALTER TABLE `tb_categoriaprod`
  MODIFY `IdCate` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tb_cliente`
--
ALTER TABLE `tb_cliente`
  MODIFY `IdCli` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `tb_estado`
--
ALTER TABLE `tb_estado`
  MODIFY `IdEstado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tb_ingreso`
--
ALTER TABLE `tb_ingreso`
  MODIFY `IdIng` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tb_ingresodetalle`
--
ALTER TABLE `tb_ingresodetalle`
  MODIFY `IdIngDet` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tb_lote`
--
ALTER TABLE `tb_lote`
  MODIFY `IdLote` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tb_notapedido`
--
ALTER TABLE `tb_notapedido`
  MODIFY `IdNotaP` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tb_personal`
--
ALTER TABLE `tb_personal`
  MODIFY `IdPer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tb_producto`
--
ALTER TABLE `tb_producto`
  MODIFY `IdProd` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT de la tabla `tb_tipopersonal`
--
ALTER TABLE `tb_tipopersonal`
  MODIFY `IdTipoPer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tb_tipousuario`
--
ALTER TABLE `tb_tipousuario`
  MODIFY `IdTipoUsu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tb_usuario`
--
ALTER TABLE `tb_usuario`
  MODIFY `IdUsu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tb_almacen`
--
ALTER TABLE `tb_almacen`
  ADD CONSTRAINT `tb_almacen_ibfk_1` FOREIGN KEY (`IdIngDet`) REFERENCES `tb_ingresodetalle` (`IdIngDet`),
  ADD CONSTRAINT `tb_almacen_ibfk_2` FOREIGN KEY (`IdProd`) REFERENCES `tb_producto` (`IdProd`);

--
-- Filtros para la tabla `tb_ingreso`
--
ALTER TABLE `tb_ingreso`
  ADD CONSTRAINT `tb_ingreso_ibfk_1` FOREIGN KEY (`IdPer`) REFERENCES `tb_personal` (`IdPer`),
  ADD CONSTRAINT `tb_ingreso_ibfk_2` FOREIGN KEY (`IdProd`) REFERENCES `tb_producto` (`IdProd`);

--
-- Filtros para la tabla `tb_ingresodetalle`
--
ALTER TABLE `tb_ingresodetalle`
  ADD CONSTRAINT `tb_ingresodetalle_ibfk_1` FOREIGN KEY (`IdIng`) REFERENCES `tb_ingreso` (`IdIng`),
  ADD CONSTRAINT `tb_ingresodetalle_ibfk_2` FOREIGN KEY (`IdProd`) REFERENCES `tb_producto` (`IdProd`);

--
-- Filtros para la tabla `tb_lote`
--
ALTER TABLE `tb_lote`
  ADD CONSTRAINT `tb_lote_ibfk_1` FOREIGN KEY (`IdAlma`) REFERENCES `tb_almacen` (`IdAlma`),
  ADD CONSTRAINT `tb_lote_ibfk_2` FOREIGN KEY (`IdPer`) REFERENCES `tb_personal` (`IdPer`);

--
-- Filtros para la tabla `tb_notapedido`
--
ALTER TABLE `tb_notapedido`
  ADD CONSTRAINT `tb_notapedido_ibfk_1` FOREIGN KEY (`IdAlma`) REFERENCES `tb_almacen` (`IdAlma`),
  ADD CONSTRAINT `tb_notapedido_ibfk_2` FOREIGN KEY (`IdLote`) REFERENCES `tb_lote` (`IdLote`),
  ADD CONSTRAINT `tb_notapedido_ibfk_3` FOREIGN KEY (`IdPer`) REFERENCES `tb_personal` (`IdPer`);

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
