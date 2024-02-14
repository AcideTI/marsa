-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-02-2024 a las 07:12:11
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
CREATE DATABASE IF NOT EXISTS `marsa_db` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
USE `marsa_db`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_almacen`
--

CREATE TABLE `tb_almacen` (
  `IdAlma` int(11) NOT NULL,
  `IdProd` int(11) NOT NULL,
  `CantidadTotal` int(250) NOT NULL,
  `DateCreate` date NOT NULL,
  `DateUpdate` date NOT NULL,
  `HoraCreate` time NOT NULL,
  `HoraUpdate` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `tb_almacen`
--

INSERT INTO `tb_almacen` (`IdAlma`, `IdProd`, `CantidadTotal`, `DateCreate`, `DateUpdate`, `HoraCreate`, `HoraUpdate`) VALUES
(1, 94, 26, '2024-02-09', '2024-02-09', '22:45:31', '23:01:10'),
(2, 93, 1, '2024-02-09', '2024-02-09', '22:45:31', '22:45:31'),
(3, 92, 5, '2024-02-09', '2024-02-09', '22:45:31', '23:05:55'),
(4, 91, 2, '2024-02-09', '2024-02-09', '22:45:31', '23:02:42'),
(5, 85, 77, '2024-02-09', '2024-02-09', '23:05:55', '23:05:55'),
(6, 1, 19, '2024-02-11', '2024-02-13', '21:33:59', '23:55:27'),
(7, 2, 27, '2024-02-11', '2024-02-13', '21:33:59', '23:55:27'),
(8, 50, 0, '2024-02-12', '2024-02-12', '01:22:43', '06:25:18'),
(9, 49, 0, '2024-02-12', '2024-02-12', '01:22:43', '06:25:17'),
(10, 95, 0, '2024-02-12', '2024-02-12', '06:12:42', '00:22:40');

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
(2, '098765432101234567890', 'Cliente 2', 'clientecorreo2@gmail.com', 'Direccion Cliente 2', 987654321, 4, '2024-01-26 10:40:00', '2024-01-26 10:40:09'),
(8, '234145134513451345', 'alex cliente', 'alex@gmail.com', 'casita 2', 123456758, 3, '2024-02-01 11:56:38', '2024-02-01 11:56:38'),
(9, '654654654654654', 'plaza vea', 'plazavea@gmail.com', 'ejercioto 200', 54999999, 3, '2024-02-12 00:14:09', '2024-02-12 00:14:30');

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
  `DescripcionIng` varchar(150) DEFAULT NULL,
  `DatosProductosIngresoJson` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`DatosProductosIngresoJson`)),
  `FechaProduccionIng` date NOT NULL,
  `FechaVencimientoIng` date NOT NULL,
  `FechaReingresoIng` date DEFAULT NULL,
  `FechaMermaIng` date DEFAULT NULL,
  `Estado` int(10) NOT NULL,
  `DateCreate` datetime NOT NULL,
  `DateUpdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `tb_ingreso`
--

INSERT INTO `tb_ingreso` (`IdIng`, `IdPer`, `DescripcionIng`, `DatosProductosIngresoJson`, `FechaProduccionIng`, `FechaVencimientoIng`, `FechaReingresoIng`, `FechaMermaIng`, `Estado`, `DateCreate`, `DateUpdate`) VALUES
(1, 1, 'ingreso por que si', '[{\"codProduct\":\"94\",\"countProduct\":\"1.00\"},{\"codProduct\":\"93\",\"countProduct\":\"1.00\"},{\"codProduct\":\"94\",\"countProduct\":\"1.00\"},{\"codProduct\":\"93\",\"countProduct\":\"54.00\"}]', '2024-02-07', '2024-02-09', '0000-00-00', '0000-00-00', 7, '2024-02-07 20:53:36', '2024-02-07 20:53:36'),
(2, 1, 'ingreso por que si', '[{\"codProduct\":\"94\",\"countProduct\":\"1.00\"},{\"codProduct\":\"93\",\"countProduct\":\"1.00\"}]', '2024-02-07', '2024-02-09', '0000-00-00', '0000-00-00', 7, '2024-02-07 20:56:30', '2024-02-07 20:56:30'),
(3, 1, 'ingreso por que si', '[{\"codProduct\":\"94\",\"countProduct\":\"1.00\"},{\"codProduct\":\"93\",\"countProduct\":\"1.00\"},{\"codProduct\":\"94\",\"countProduct\":\"1.00\"},{\"codProduct\":\"93\",\"countProduct\":\"1.00\"},{\"codProduct\":\"94\",\"countProduct\":\"1.00\"},{\"codProduct\":\"94\",\"countProduct\":\"1.00\"},{\"codProduct\":\"94\",\"countProduct\":\"1.00\"}]', '2024-02-07', '2024-02-07', '0000-00-00', '2024-02-07', 2, '2024-02-07 21:02:28', '2024-02-07 21:02:28'),
(4, 1, 'ingreso por que si', '[{\"codProduct\":\"94\",\"countProduct\":\"1.00\"},{\"codProduct\":\"94\",\"countProduct\":\"1.00\"},{\"codProduct\":\"93\",\"countProduct\":\"1.00\"},{\"codProduct\":\"93\",\"countProduct\":\"1.00\"},{\"codProduct\":\"94\",\"countProduct\":\"1.00\"},{\"codProduct\":\"94\",\"countProduct\":\"1.00\"},{\"codProduct\":\"93\",\"countProduct\":\"1.00\"},{\"codProduct\":\"93\",\"countProduct\":\"1.00\"}]', '2024-02-07', '2024-02-09', '0000-00-00', '0000-00-00', 7, '2024-02-07 22:33:33', '2024-02-07 22:33:33'),
(5, 1, '', '[{\"codProduct\":\"94\",\"countProduct\":\"1.00\"},{\"codProduct\":\"94\",\"countProduct\":\"1.00\"},{\"codProduct\":\"93\",\"countProduct\":\"1.00\"},{\"codProduct\":\"93\",\"countProduct\":\"1.00\"},{\"codProduct\":\"93\",\"countProduct\":\"1.00\"},{\"codProduct\":\"93\",\"countProduct\":\"1.00\"}]', '2024-02-07', '0000-00-00', '0000-00-00', '0000-00-00', 7, '2024-02-07 22:34:40', '2024-02-07 22:34:40'),
(6, 1, 'ingreso por que si', '[{\"codProduct\":\"93\",\"countProduct\":\"1.00\"},{\"codProduct\":\"93\",\"countProduct\":\"1.00\"},{\"codProduct\":\"94\",\"countProduct\":\"1.00\"},{\"codProduct\":\"93\",\"countProduct\":\"1.00\"},{\"codProduct\":\"94\",\"countProduct\":\"1.00\"},{\"codProduct\":\"93\",\"countProduct\":\"1.00\"}]', '2024-02-07', '2024-02-16', '0000-00-00', '0000-00-00', 7, '2024-02-07 22:35:27', '2024-02-07 22:35:27'),
(7, 1, 'ingreso por que si', '[{\"codProduct\":\"94\",\"countProduct\":\"1.00\"},{\"codProduct\":\"93\",\"countProduct\":\"1.00\"},{\"codProduct\":\"93\",\"countProduct\":\"1.00\"},{\"codProduct\":\"94\",\"countProduct\":\"1.00\"},{\"codProduct\":\"94\",\"countProduct\":\"1.00\"},{\"codProduct\":\"93\",\"countProduct\":\"1.00\"},{\"codProduct\":\"93\",\"countProduct\":\"1.00\"},{\"codProduct\":\"94\",\"countProduct\":\"1.00\"}]', '2024-02-07', '2024-02-06', '0000-00-00', '0000-00-00', 2, '2024-02-07 22:37:23', '2024-02-07 22:37:23'),
(8, 1, 'ingreso por que six2', '[{\"codProduct\":\"94\",\"countProduct\":\"1.00\"},{\"codProduct\":\"94\",\"countProduct\":\"1.00\"},{\"codProduct\":\"93\",\"countProduct\":\"1.00\"},{\"codProduct\":\"93\",\"countProduct\":\"1.00\"},{\"codProduct\":\"94\",\"countProduct\":\"1.00\"},{\"codProduct\":\"94\",\"countProduct\":\"1.00\"},{\"codProduct\":\"93\",\"countProduct\":\"1.00\"},{\"codProduct\":\"93\",\"countProduct\":\"1.00\"},{\"codProduct\":\"94\",\"countProduct\":\"1.00\"},{\"codProduct\":\"94\",\"countProduct\":\"1.00\"}]', '2024-02-07', '0000-00-00', '0000-00-00', '0000-00-00', 7, '2024-02-07 22:56:23', '2024-02-07 22:56:23'),
(9, 1, 'ingreso por que si', '[{\"codProduct\":\"94\",\"countProduct\":\"4.00\"},{\"codProduct\":\"94\",\"countProduct\":\"1.00\"},{\"codProduct\":\"93\",\"countProduct\":\"1.00\"},{\"codProduct\":\"93\",\"countProduct\":\"1.00\"},{\"codProduct\":\"94\",\"countProduct\":\"1.00\"},{\"codProduct\":\"94\",\"countProduct\":\"1.00\"},{\"codProduct\":\"93\",\"countProduct\":\"1.00\"},{\"codProduct\":\"93\",\"countProduct\":\"1.00\"}]', '2024-02-08', '2024-02-09', '0000-00-00', '0000-00-00', 7, '2024-02-08 14:53:08', '2024-02-08 14:53:08'),
(10, 1, '', '[{\"codProduct\":\"94\",\"countProduct\":\"1.00\"},{\"codProduct\":\"94\",\"countProduct\":\"1.00\"}]', '2024-02-08', '0000-00-00', '0000-00-00', '0000-00-00', 7, '2024-02-08 16:14:45', '2024-02-08 16:14:45');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_lote`
--

CREATE TABLE `tb_lote` (
  `IdLote` int(11) NOT NULL,
  `IdPer` int(11) NOT NULL,
  `CodigoLote` varchar(50) NOT NULL,
  `DescripcionLote` varchar(150) DEFAULT NULL,
  `DatosLoteIngresoJson` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`DatosLoteIngresoJson`)),
  `FechaProduccionLote` date NOT NULL,
  `FechaVencimientoLote` date NOT NULL,
  `Estado` int(10) NOT NULL,
  `DateCreate` datetime NOT NULL,
  `DateUpdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `tb_lote`
--

INSERT INTO `tb_lote` (`IdLote`, `IdPer`, `CodigoLote`, `DescripcionLote`, `DatosLoteIngresoJson`, `FechaProduccionLote`, `FechaVencimientoLote`, `Estado`, `DateCreate`, `DateUpdate`) VALUES
(1, 1, 'L-240208#00000FV2403', 'lote factura', '[{\"codProduct\":\"94\",\"countProduct\":\"1.00\"},{\"codProduct\":\"93\",\"countProduct\":\"1.00\"},{\"codProduct\":\"93\",\"countProduct\":\"1.00\"},{\"codProduct\":\"93\",\"countProduct\":\"1.00\"}]', '2024-02-08', '2024-03-08', 7, '2024-02-08 21:13:58', '2024-02-08 21:13:58'),
(2, 1, 'L-240209#00025FV2403', 'lote factura', '[{\"codProduct\":\"94\",\"countProduct\":\"1.00\"},{\"codProduct\":\"93\",\"countProduct\":\"1.00\"},{\"codProduct\":\"94\",\"countProduct\":\"1.00\"},{\"codProduct\":\"93\",\"countProduct\":\"1.00\"},{\"codProduct\":\"94\",\"countProduct\":\"1.00\"},{\"codProduct\":\"93\",\"countProduct\":\"1.00\"}]', '2024-02-09', '2024-03-08', 7, '2024-02-09 17:00:34', '2024-02-09 17:00:34'),
(3, 1, 'L-240209#00000FV2402', 'lote factura', '[{\"codProduct\":\"93\",\"countProduct\":\"1.00\"}]', '2024-02-09', '2024-02-23', 5, '2024-02-09 17:05:01', '2024-02-09 17:05:01'),
(4, 1, 'L-240211#00000FV2402', 'lote2', '[{\"codProduct\":\"1\",\"countProduct\":\"5\"}]', '2024-02-11', '2024-02-20', 7, '2024-02-11 21:55:08', '2024-02-11 21:55:08'),
(5, 1, 'L-240211#00000FV2402', 'lote2', '[{\"codProduct\":\"1\",\"countProduct\":\"5\"}]', '2024-02-11', '2024-02-20', 7, '2024-02-11 21:57:37', '2024-02-11 21:57:37'),
(6, 1, 'L-240211#00000FV2402', 'lote2', '[{\"codProduct\":\"1\",\"countProduct\":\"5\"}]', '2024-02-11', '2024-02-20', 8, '2024-02-11 21:58:19', '2024-02-11 21:58:19'),
(7, 1, 'L-240211#00000FV2402', 'lote2', '[{\"codProduct\":\"1\",\"countProduct\":\"5\"}]', '2024-02-11', '2024-02-20', 7, '2024-02-11 22:15:48', '2024-02-11 22:15:48'),
(8, 1, 'L-240211#00000FV2402', 'lote2', '[{\"codProduct\":\"1\",\"countProduct\":\"5\"}]', '2024-02-11', '2024-02-20', 7, '2024-02-11 22:21:47', '2024-02-11 22:21:47'),
(9, 1, 'L-240211#00000FV2402', 'lote2', '[{\"codProduct\":\"1\",\"countProduct\":\"5\"}]', '2024-02-11', '2024-02-20', 8, '2024-02-11 22:23:16', '2024-02-11 22:23:16'),
(10, 1, 'L-240211#00000FV2402', 'lote2', '[{\"codProduct\":\"1\",\"countProduct\":\"5\"}]', '2024-02-11', '2024-02-20', 5, '2024-02-11 22:23:50', '2024-02-11 22:23:50'),
(26, 1, 'L-240212#00A01FV2403', 'lote productos', '[{\"codProduct\":\"49\",\"countProduct\":\"1.00\"},{\"codProduct\":\"50\",\"countProduct\":\"1.00\"}]', '2024-02-12', '2024-03-08', 7, '2024-02-12 06:25:17', '2024-02-12 06:25:17'),
(27, 1, 'L-240212#00000FV2402', 'lote2', '[{\"codProduct\":\"95\",\"countProduct\":\"1.00\"},{\"codProduct\":\"49\",\"countProduct\":\"1.00\"},{\"codProduct\":\"50\",\"countProduct\":\"1.00\"},{\"codProduct\":\"2\",\"countProduct\":\"1.00\"},{\"codProduct\":\"1\",\"countProduct\":\"1.00\"},{\"codProduct\":\"2\",\"countProduct\":\"1.00\"},{\"codProduct\":\"1\",\"countProduct\":\"1.00\"},{\"codProduct\":\"2\",\"countProduct\":\"1.00\"}]', '2024-02-12', '2024-02-15', 7, '2024-02-12 06:35:24', '2024-02-12 06:35:24'),
(28, 1, 'L-240212#00000FV2402', 'lote2', '[{\"codProduct\":\"1\",\"countProduct\":\"5\"},{\"codProduct\":\"2\",\"countProduct\":\"5\"}]', '2024-02-12', '2024-02-15', 7, '2024-02-12 06:36:47', '2024-02-12 06:36:47');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_notapedido`
--

CREATE TABLE `tb_notapedido` (
  `IdNotaP` int(11) NOT NULL,
  `IdLote` int(11) DEFAULT NULL,
  `IdPer` int(11) NOT NULL,
  `IdRes` int(11) NOT NULL,
  `IdCliente` int(11) NOT NULL,
  `TipoDeNotaPe` varchar(100) DEFAULT NULL,
  `TipoNotaPeFactura` varchar(100) DEFAULT NULL,
  `NotaPorFA` varchar(100) DEFAULT NULL,
  `DatosProductosNotaPedidoJson` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`DatosProductosNotaPedidoJson`)),
  `SubTotal` decimal(10,2) NOT NULL,
  `IGV` decimal(10,2) NOT NULL,
  `Total` decimal(10,2) NOT NULL,
  `ComentarioNotaDev` varchar(255) DEFAULT NULL,
  `Estado` int(10) NOT NULL,
  `FechaNotaPedido` date DEFAULT NULL,
  `FechaNotaDevolucion` date DEFAULT NULL,
  `DateCreate` datetime NOT NULL,
  `DateUpdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `tb_notapedido`
--

INSERT INTO `tb_notapedido` (`IdNotaP`, `IdLote`, `IdPer`, `IdRes`, `IdCliente`, `TipoDeNotaPe`, `TipoNotaPeFactura`, `NotaPorFA`, `DatosProductosNotaPedidoJson`, `SubTotal`, `IGV`, `Total`, `ComentarioNotaDev`, `Estado`, `FechaNotaPedido`, `FechaNotaDevolucion`, `DateCreate`, `DateUpdate`) VALUES
(1, 1, 5, 1, 9, 'Lote', 'afdfasdfsadf', 'Factura', '[{\"codProduct\":\"2\",\"priceProduct\":\"0.00\",\"countProduct\":\"1.00\",\"newSum\":\"0.00\"},{\"codProduct\":\"1\",\"priceProduct\":\"0.00\",\"countProduct\":\"1.00\",\"newSum\":\"0.00\"},{\"codProduct\":\"2\",\"priceProduct\":\"0.00\",\"countProduct\":\"1.00\",\"newSum\":\"0.00\"}]', 0.00, 0.00, 0.00, '', 5, '2024-02-13', '0000-00-00', '2024-02-13 23:55:27', '2024-02-13 23:55:27');

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
(1, 1, 123456789, 'Alex Responsable 1', 'ApellidoResponsable', '1234567890', 'DirecciónResponsable', 3, '2023-09-14 11:54:27', '2024-02-09 11:17:19'),
(2, 2, 987654321, 'NombreOperario', 'ApellidoOperario', '9876543210', 'DirecciónOperario', 3, '2023-09-14 11:54:27', '2023-09-14 11:54:27'),
(3, 3, 456789012, 'NombreVendedor', 'ApellidoVendedor', '4567890123', 'DirecciónVendedor', 3, '2023-09-14 11:54:27', '2023-09-14 11:54:27'),
(4, 4, 456789012, 'Alex R 2', 'ApellidoResponsable', '4567890124', 'DirecciónResponsable', 3, '2023-09-14 11:54:27', '2024-01-29 17:24:44'),
(5, 3, 2147483647, 'alex', 'flores', '435443543', 'casita 2', 3, '2024-02-01 11:43:18', '2024-02-01 11:43:18'),
(6, 3, 2147483647, 'alex vendepuertas', 'flores', '654654654', 'casita cerro', 3, '2024-02-12 00:16:52', '2024-02-12 00:16:52');

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
(29, 2, 'Aceituna Negra 1ra Manchada x Balde de 15kg.', NULL, 'kg', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(30, 2, 'Aceituna Negra 1ra x Balde 15kg.', NULL, 'kg', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(31, 2, 'Aceituna Negra 250gr.', NULL, 'gr', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(32, 2, 'Aceituna Negra 500gr.', NULL, 'gr', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(33, 2, 'Aceituna Negra Cocktail kg.', NULL, 'kg', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(34, 2, 'Aceituna Negra Deshuesada 250gr.', NULL, 'gr', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(35, 2, 'Aceituna Negra Deshuesada 500gr.', NULL, 'gr', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(36, 2, 'Aceituna Negra Deshuesada Premium kg.', NULL, 'kg', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
(37, 2, 'Aceituna Negra Premium 500gr.', NULL, 'gr', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30'),
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
(95, 5, 'Cañita de  Azucar', 'Azucar', 'Kg', 1, 4.00, '2024-02-12 00:09:26', '2024-02-12 00:09:26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_tipopersonal`
--

CREATE TABLE `tb_tipopersonal` (
  `IdTipoPer` int(11) NOT NULL,
  `DescripcionTipoPer` varchar(255) NOT NULL,
  `DateCreate` datetime NOT NULL,
  `DateUpdate` datetime NOT NULL,
  `IdUsu` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `tb_tipopersonal`
--

INSERT INTO `tb_tipopersonal` (`IdTipoPer`, `DescripcionTipoPer`, `DateCreate`, `DateUpdate`, `IdUsu`) VALUES
(1, 'Responsable', '2023-09-14 11:54:27', '2023-09-14 11:54:27', 3),
(2, 'Operario', '2023-09-14 11:54:27', '2023-09-14 11:54:27', NULL),
(3, 'Vendedor', '2023-09-14 11:54:27', '2023-09-14 11:54:27', NULL),
(4, 'Responsable', '2023-09-14 11:54:27', '2023-09-14 11:54:27', 4);

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
(1, 1, 'admin', 'admin', 'admin', '$argon2id$v=19$m=4096,t=2,p=2$UWpleWtkc2hqM3RXeXlxbg$8On5PLoftLU6P/RR7R6AYdbYsYRg1uWLmZOL7Fc/bY8', '2024-01-29 17:31:10', '2023-09-14 11:54:27', '2023-09-14 11:54:27'),
(3, 2, 'alex', 'Alex R 1', 'Flores ', '$argon2id$v=19$m=4096,t=2,p=2$UWpleWtkc2hqM3RXeXlxbg$8On5PLoftLU6P/RR7R6AYdbYsYRg1uWLmZOL7Fc/bY8', '2024-02-13 23:48:29', '2023-09-14 11:54:27', '2023-09-14 11:54:27'),
(4, 2, 'alex2', 'Alex R 2', 'Responsable', '$argon2id$v=19$m=4096,t=2,p=2$OGxRc0lvQ3JleXY0UTlXLw$F91eyjVOr93VDJEy7tGFf9InNjkMuZDm7jmXeIizWdE', '2024-01-29 17:24:05', '2024-01-29 15:36:20', '2024-01-29 15:36:20');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tb_almacen`
--
ALTER TABLE `tb_almacen`
  ADD PRIMARY KEY (`IdAlma`),
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
  ADD KEY `IdPer` (`IdPer`);

--
-- Indices de la tabla `tb_lote`
--
ALTER TABLE `tb_lote`
  ADD PRIMARY KEY (`IdLote`),
  ADD KEY `IdPer` (`IdPer`);

--
-- Indices de la tabla `tb_notapedido`
--
ALTER TABLE `tb_notapedido`
  ADD PRIMARY KEY (`IdNotaP`),
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
  ADD PRIMARY KEY (`IdTipoPer`),
  ADD KEY `fk_tb_tipopersonal_tb_usuario` (`IdUsu`);

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
  MODIFY `IdAlma` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `tb_categoriaprod`
--
ALTER TABLE `tb_categoriaprod`
  MODIFY `IdCate` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tb_cliente`
--
ALTER TABLE `tb_cliente`
  MODIFY `IdCli` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `tb_estado`
--
ALTER TABLE `tb_estado`
  MODIFY `IdEstado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `tb_ingreso`
--
ALTER TABLE `tb_ingreso`
  MODIFY `IdIng` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT de la tabla `tb_lote`
--
ALTER TABLE `tb_lote`
  MODIFY `IdLote` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `tb_notapedido`
--
ALTER TABLE `tb_notapedido`
  MODIFY `IdNotaP` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tb_personal`
--
ALTER TABLE `tb_personal`
  MODIFY `IdPer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tb_producto`
--
ALTER TABLE `tb_producto`
  MODIFY `IdProd` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT de la tabla `tb_tipopersonal`
--
ALTER TABLE `tb_tipopersonal`
  MODIFY `IdTipoPer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tb_tipousuario`
--
ALTER TABLE `tb_tipousuario`
  MODIFY `IdTipoUsu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tb_usuario`
--
ALTER TABLE `tb_usuario`
  MODIFY `IdUsu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
-- Filtros para la tabla `tb_tipopersonal`
--
ALTER TABLE `tb_tipopersonal`
  ADD CONSTRAINT `fk_tb_tipopersonal_tb_usuario` FOREIGN KEY (`IdUsu`) REFERENCES `tb_usuario` (`IdUsu`);

--
-- Filtros para la tabla `tb_usuario`
--
ALTER TABLE `tb_usuario`
  ADD CONSTRAINT `tb_usuario_ibfk_1` FOREIGN KEY (`IdTipoUsu`) REFERENCES `tb_tipousuario` (`IdTipoUsu`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
