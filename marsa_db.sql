/*
 Navicat Premium Data Transfer

 Source Server         : mysqlDB
 Source Server Type    : MySQL
 Source Server Version : 100428
 Source Host           : localhost:3306
 Source Schema         : marsa_db

 Target Server Type    : MySQL
 Target Server Version : 100428
 File Encoding         : 65001

 Date: 27/02/2024 00:43:12
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for tb_almacen
-- ----------------------------
DROP TABLE IF EXISTS `tb_almacen`;
CREATE TABLE `tb_almacen`  (
  `IdAlma` int NOT NULL AUTO_INCREMENT,
  `IdProd` int NOT NULL,
  `CantidadTotal` int NOT NULL,
  `DateCreate` date NOT NULL,
  `DateUpdate` date NOT NULL,
  `HoraCreate` time NOT NULL,
  `HoraUpdate` time NOT NULL,
  PRIMARY KEY (`IdAlma`) USING BTREE,
  INDEX `IdProd`(`IdProd`) USING BTREE,
  CONSTRAINT `tb_almacen_ibfk_1` FOREIGN KEY (`IdProd`) REFERENCES `tb_producto` (`IdProd`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 19 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_almacen
-- ----------------------------
INSERT INTO `tb_almacen` VALUES (1, 94, 15, '2024-02-09', '2024-02-22', '22:45:31', '01:56:52');
INSERT INTO `tb_almacen` VALUES (2, 93, 4, '2024-02-09', '2024-02-21', '22:45:31', '15:20:10');
INSERT INTO `tb_almacen` VALUES (3, 92, 9, '2024-02-09', '2024-02-22', '22:45:31', '01:59:31');
INSERT INTO `tb_almacen` VALUES (4, 91, 6, '2024-02-09', '2024-02-15', '22:45:31', '15:04:52');
INSERT INTO `tb_almacen` VALUES (5, 85, 45, '2024-02-09', '2024-02-22', '23:05:55', '01:53:50');
INSERT INTO `tb_almacen` VALUES (6, 1, 17, '2024-02-11', '2024-02-21', '21:33:59', '22:27:42');
INSERT INTO `tb_almacen` VALUES (7, 2, 16, '2024-02-11', '2024-02-22', '21:33:59', '01:50:03');
INSERT INTO `tb_almacen` VALUES (8, 50, 0, '2024-02-12', '2024-02-12', '01:22:43', '06:25:18');
INSERT INTO `tb_almacen` VALUES (9, 49, 0, '2024-02-12', '2024-02-12', '01:22:43', '06:25:17');
INSERT INTO `tb_almacen` VALUES (10, 95, 14, '2024-02-12', '2024-02-21', '06:12:42', '21:40:44');
INSERT INTO `tb_almacen` VALUES (11, 87, 5, '2024-02-13', '2024-02-15', '15:02:51', '15:04:52');
INSERT INTO `tb_almacen` VALUES (12, 67, 0, '2024-02-13', '2024-02-15', '15:02:51', '14:35:27');
INSERT INTO `tb_almacen` VALUES (13, 66, 0, '2024-02-13', '2024-02-15', '15:02:51', '14:34:41');
INSERT INTO `tb_almacen` VALUES (14, 65, 8, '2024-02-13', '2024-02-13', '15:11:57', '15:13:08');
INSERT INTO `tb_almacen` VALUES (15, 90, 1, '2024-02-15', '2024-02-15', '15:04:52', '15:04:52');
INSERT INTO `tb_almacen` VALUES (16, 88, 1, '2024-02-15', '2024-02-15', '15:04:52', '15:04:52');
INSERT INTO `tb_almacen` VALUES (17, 86, 6, '2024-02-15', '2024-02-15', '15:04:52', '15:04:52');
INSERT INTO `tb_almacen` VALUES (18, 96, -19, '2024-02-22', '2024-02-26', '05:18:06', '23:12:11');

-- ----------------------------
-- Table structure for tb_almacen_merma
-- ----------------------------
DROP TABLE IF EXISTS `tb_almacen_merma`;
CREATE TABLE `tb_almacen_merma`  (
  `IdAlmacenMerma` int NOT NULL AUTO_INCREMENT,
  `IdProducto` int NOT NULL,
  `IdSalida` int NOT NULL,
  `IdIngresoDev` int NOT NULL,
  `Cantidad` int NOT NULL,
  `DateCreate` datetime NOT NULL,
  `TipoSalida` varchar(25) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `DateUpdate` datetime NOT NULL,
  PRIMARY KEY (`IdAlmacenMerma`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_almacen_merma
-- ----------------------------
INSERT INTO `tb_almacen_merma` VALUES (1, 85, 27, 62, 10, '2024-02-21 22:27:42', 'Nota de Pedido', '2024-02-21 22:27:42');
INSERT INTO `tb_almacen_merma` VALUES (2, 1, 27, 62, 3, '2024-02-21 22:27:42', 'Nota de Pedido', '2024-02-21 22:27:42');
INSERT INTO `tb_almacen_merma` VALUES (3, 2, 36, 64, 7, '2024-02-22 01:50:03', 'Nota de Pedido', '2024-02-22 01:50:03');
INSERT INTO `tb_almacen_merma` VALUES (4, 85, 34, 0, 4, '2024-02-22 01:53:50', 'Nota de Pedido', '2024-02-22 01:53:50');
INSERT INTO `tb_almacen_merma` VALUES (5, 94, 25, 0, 2, '2024-02-22 01:57:03', 'Nota de Pedido', '2024-02-22 01:57:03');
INSERT INTO `tb_almacen_merma` VALUES (6, 92, 33, 67, 3, '2024-02-22 01:59:31', 'Nota de Pedido', '2024-02-22 01:59:31');

-- ----------------------------
-- Table structure for tb_categoriaprod
-- ----------------------------
DROP TABLE IF EXISTS `tb_categoriaprod`;
CREATE TABLE `tb_categoriaprod`  (
  `IdCate` int NOT NULL AUTO_INCREMENT,
  `NombreCategoria` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `DateCreate` datetime NOT NULL,
  `DateUpdate` datetime NOT NULL,
  PRIMARY KEY (`IdCate`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_categoriaprod
-- ----------------------------
INSERT INTO `tb_categoriaprod` VALUES (1, 'Aceites', '2024-01-26 16:14:25', '2024-01-26 16:14:25');
INSERT INTO `tb_categoriaprod` VALUES (2, 'Aceitunas', '2024-01-26 16:14:25', '2024-01-26 16:14:25');
INSERT INTO `tb_categoriaprod` VALUES (3, 'Endulzantes y Jarabes', '2024-01-26 16:14:25', '2024-01-26 16:14:25');
INSERT INTO `tb_categoriaprod` VALUES (4, 'Untables y Salsas', '2024-01-26 16:14:25', '2024-01-26 16:14:25');
INSERT INTO `tb_categoriaprod` VALUES (5, 'Jugos y Bebidas', '2024-01-26 16:14:25', '2024-01-26 16:14:25');
INSERT INTO `tb_categoriaprod` VALUES (6, 'Vinagres', '2024-01-26 16:14:25', '2024-01-26 16:14:25');
INSERT INTO `tb_categoriaprod` VALUES (11, 'Categoria 2', '2024-02-20 16:41:34', '2024-02-20 16:41:34');

-- ----------------------------
-- Table structure for tb_cliente
-- ----------------------------
DROP TABLE IF EXISTS `tb_cliente`;
CREATE TABLE `tb_cliente`  (
  `IdCli` int NOT NULL AUTO_INCREMENT,
  `RucCli` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `NombreCli` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `CorreoCli` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `DireccionCli` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `TelefonoCli` int NOT NULL,
  `Estado` int NOT NULL,
  `DateCreate` datetime NOT NULL,
  `DateUpdate` datetime NOT NULL,
  PRIMARY KEY (`IdCli`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 27 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_cliente
-- ----------------------------
INSERT INTO `tb_cliente` VALUES (1, '01234567890123456789', 'cliente 1', 'clientecorreo@gmail.com', 'Cliente Dirreccion', 123456789, 3, '2023-09-14 11:54:27', '2024-01-26 10:39:06');
INSERT INTO `tb_cliente` VALUES (8, '234145134513451345', 'alex cliente', 'alex@gmail.com', 'casita 2', 123456758, 3, '2024-02-01 11:56:38', '2024-02-01 11:56:38');
INSERT INTO `tb_cliente` VALUES (10, '1231231', 'Cliente X', 'asda@asda', 'asdasd', 3333333, 3, '2024-02-20 16:41:52', '2024-02-20 16:41:58');
INSERT INTO `tb_cliente` VALUES (11, '1231', '1231', 'asda@asda', '', 0, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `tb_cliente` VALUES (12, '5436', '456', 'asda@asda', '', 0, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `tb_cliente` VALUES (13, '5436', '6464565', 'asda@asda', '', 0, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `tb_cliente` VALUES (14, '5436', '123123', 'asda@asda', '', 0, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `tb_cliente` VALUES (15, '5436', '123123', 'asda@asda', '', 0, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `tb_cliente` VALUES (16, '5436', '34532', 'asda@asda', '', 0, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `tb_cliente` VALUES (17, '5436', '53', 'asda@asda', '', 0, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `tb_cliente` VALUES (18, '5436', '34', 'asda@asda', '', 0, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `tb_cliente` VALUES (19, '5436', '4356', 'asda@asda', '', 0, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `tb_cliente` VALUES (20, '5436', '43', 'asda@asda', '', 0, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `tb_cliente` VALUES (21, '5436', '3456', 'asda@asda', '', 0, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `tb_cliente` VALUES (22, '5436', '5', 'asda@asda', '', 0, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `tb_cliente` VALUES (23, '5436', '43', 'asda@asda', '', 0, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `tb_cliente` VALUES (24, '5436', '65', 'asda@asda', '', 0, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `tb_cliente` VALUES (25, '5436', '63', 'asda@asda', '', 0, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `tb_cliente` VALUES (26, '5436', '43', 'asda@asda', '', 0, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- ----------------------------
-- Table structure for tb_estado
-- ----------------------------
DROP TABLE IF EXISTS `tb_estado`;
CREATE TABLE `tb_estado`  (
  `IdEstado` int NOT NULL AUTO_INCREMENT,
  `TipoEstado` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `Descripcion` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `DateCreate` datetime NOT NULL,
  `DateUpdate` datetime NOT NULL,
  PRIMARY KEY (`IdEstado`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_estado
-- ----------------------------
INSERT INTO `tb_estado` VALUES (1, 'Vigente', 'Estado vigente para productos', '2024-01-26 13:17:10', '2024-01-26 13:17:10');
INSERT INTO `tb_estado` VALUES (2, 'Vencido', 'Estado vencido para productos', '2024-01-26 13:17:10', '2024-01-26 13:17:10');
INSERT INTO `tb_estado` VALUES (3, 'Activo', 'Estado activo para personal', '2024-01-26 13:17:10', '2024-01-26 13:17:10');
INSERT INTO `tb_estado` VALUES (4, 'Inactivo', 'Estado inactivo para personal', '2024-01-26 13:17:10', '2024-01-26 13:17:10');
INSERT INTO `tb_estado` VALUES (5, 'Completado', 'Estado completado para nota pedido', '2024-01-26 13:17:10', '2024-01-26 13:17:10');
INSERT INTO `tb_estado` VALUES (6, 'Devolucion', 'Estado de devolución para nota pedido y ingreso', '2024-01-26 13:17:10', '2024-01-26 13:17:10');
INSERT INTO `tb_estado` VALUES (7, 'Ingresado', 'Estado de detalle de ingreso', '2024-01-26 16:09:22', '2024-01-26 16:09:22');
INSERT INTO `tb_estado` VALUES (8, 'Retirado', 'Estado de salida para nota pedido', '2024-01-26 16:09:22', '2024-01-26 16:09:22');
INSERT INTO `tb_estado` VALUES (9, 'Merma', 'Estado de detalle de perdida para ingreso', '2024-01-29 10:51:07', '2024-01-29 10:51:07');

-- ----------------------------
-- Table structure for tb_ingreso
-- ----------------------------
DROP TABLE IF EXISTS `tb_ingreso`;
CREATE TABLE `tb_ingreso`  (
  `IdIng` int NOT NULL AUTO_INCREMENT,
  `IdPer` int NOT NULL,
  `DatosRefSalida` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT NULL,
  `TipoIngreso` int NULL DEFAULT NULL,
  `DescripcionIng` varchar(250) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `DatosProductosIngresoJson` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `FechaProduccionIng` date NULL DEFAULT NULL,
  `FechaVencimientoIng` date NULL DEFAULT NULL,
  `Estado` int NOT NULL,
  `DateCreate` datetime NOT NULL,
  `DateUpdate` datetime NOT NULL,
  PRIMARY KEY (`IdIng`) USING BTREE,
  INDEX `IdPer`(`IdPer`) USING BTREE,
  CONSTRAINT `tb_ingreso_ibfk_1` FOREIGN KEY (`IdPer`) REFERENCES `tb_personal` (`IdPer`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 68 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_ingreso
-- ----------------------------
INSERT INTO `tb_ingreso` VALUES (1, 1, NULL, 1, 'ingreso por que si', '[{\"codProduct\":\"94\",\"countProduct\":\"1.00\"},{\"codProduct\":\"93\",\"countProduct\":\"1.00\"},{\"codProduct\":\"94\",\"countProduct\":\"1.00\"},{\"codProduct\":\"93\",\"countProduct\":\"54.00\"}]', '2024-02-07', '2024-02-07', 7, '2024-02-07 20:53:36', '2024-02-07 20:53:36');
INSERT INTO `tb_ingreso` VALUES (2, 1, NULL, 1, 'ingreso por que si', '[{\"codProduct\":\"94\",\"countProduct\":\"1.00\"},{\"codProduct\":\"93\",\"countProduct\":\"1.00\"}]', '2024-02-07', '2024-02-07', 7, '2024-02-07 20:56:30', '2024-02-07 20:56:30');
INSERT INTO `tb_ingreso` VALUES (3, 1, '{\"codSalida\":\"26\",\"tipoSalida\":\"Nota de Pedido\"}', 2, 'ingreso por que si', '[{\"codProduct\":\"94\",\"countProduct\":\"1.00\"},{\"codProduct\":\"93\",\"countProduct\":\"1.00\"},{\"codProduct\":\"94\",\"countProduct\":\"1.00\"},{\"codProduct\":\"93\",\"countProduct\":\"1.00\"},{\"codProduct\":\"94\",\"countProduct\":\"1.00\"},{\"codProduct\":\"94\",\"countProduct\":\"1.00\"},{\"codProduct\":\"94\",\"countProduct\":\"1.00\"}]', '2024-02-06', NULL, 6, '2024-02-07 21:02:28', '2024-02-07 21:02:28');
INSERT INTO `tb_ingreso` VALUES (4, 1, NULL, 1, 'ingreso por que si', '[{\"codProduct\":\"94\",\"countProduct\":\"1.00\"},{\"codProduct\":\"94\",\"countProduct\":\"1.00\"},{\"codProduct\":\"93\",\"countProduct\":\"1.00\"},{\"codProduct\":\"93\",\"countProduct\":\"1.00\"},{\"codProduct\":\"94\",\"countProduct\":\"1.00\"},{\"codProduct\":\"94\",\"countProduct\":\"1.00\"},{\"codProduct\":\"93\",\"countProduct\":\"1.00\"},{\"codProduct\":\"93\",\"countProduct\":\"1.00\"}]', '2024-02-07', '2024-02-07', 7, '2024-02-07 22:33:33', '2024-02-07 22:33:33');
INSERT INTO `tb_ingreso` VALUES (5, 1, NULL, 1, '', '[{\"codProduct\":\"94\",\"countProduct\":\"1.00\"},{\"codProduct\":\"94\",\"countProduct\":\"1.00\"},{\"codProduct\":\"93\",\"countProduct\":\"1.00\"},{\"codProduct\":\"93\",\"countProduct\":\"1.00\"},{\"codProduct\":\"93\",\"countProduct\":\"1.00\"},{\"codProduct\":\"93\",\"countProduct\":\"1.00\"}]', '2024-02-07', '2024-02-07', 7, '2024-02-07 22:34:40', '2024-02-07 22:34:40');
INSERT INTO `tb_ingreso` VALUES (6, 1, NULL, 1, 'ingreso por que si', '[{\"codProduct\":\"93\",\"countProduct\":\"1.00\"},{\"codProduct\":\"93\",\"countProduct\":\"1.00\"},{\"codProduct\":\"94\",\"countProduct\":\"1.00\"},{\"codProduct\":\"93\",\"countProduct\":\"1.00\"},{\"codProduct\":\"94\",\"countProduct\":\"1.00\"},{\"codProduct\":\"93\",\"countProduct\":\"1.00\"}]', '2024-02-07', '2024-02-07', 7, '2024-02-07 22:35:27', '2024-02-07 22:35:27');
INSERT INTO `tb_ingreso` VALUES (7, 1, '{\"codSalida\":\"22\",\"tipoSalida\":\"Lote\"}', 2, 'ingreso por que si', '[{\"codProduct\":\"94\",\"countProduct\":\"1.00\"},{\"codProduct\":\"93\",\"countProduct\":\"1.00\"},{\"codProduct\":\"93\",\"countProduct\":\"1.00\"},{\"codProduct\":\"94\",\"countProduct\":\"1.00\"},{\"codProduct\":\"94\",\"countProduct\":\"1.00\"},{\"codProduct\":\"93\",\"countProduct\":\"1.00\"},{\"codProduct\":\"93\",\"countProduct\":\"1.00\"},{\"codProduct\":\"94\",\"countProduct\":\"1.00\"}]', '2024-02-06', NULL, 6, '2024-02-07 22:37:23', '2024-02-07 22:37:23');
INSERT INTO `tb_ingreso` VALUES (8, 1, NULL, 1, 'ingreso por que six2', '[{\"codProduct\":\"94\",\"countProduct\":\"1.00\"},{\"codProduct\":\"94\",\"countProduct\":\"1.00\"},{\"codProduct\":\"93\",\"countProduct\":\"1.00\"},{\"codProduct\":\"93\",\"countProduct\":\"1.00\"},{\"codProduct\":\"94\",\"countProduct\":\"1.00\"},{\"codProduct\":\"94\",\"countProduct\":\"1.00\"},{\"codProduct\":\"93\",\"countProduct\":\"1.00\"},{\"codProduct\":\"93\",\"countProduct\":\"1.00\"},{\"codProduct\":\"94\",\"countProduct\":\"1.00\"},{\"codProduct\":\"94\",\"countProduct\":\"1.00\"}]', '2024-02-07', '2024-02-07', 7, '2024-02-07 22:56:23', '2024-02-07 22:56:23');
INSERT INTO `tb_ingreso` VALUES (9, 1, NULL, 1, 'ingreso por que si', '[{\"codProduct\":\"94\",\"countProduct\":\"4.00\"},{\"codProduct\":\"94\",\"countProduct\":\"1.00\"},{\"codProduct\":\"93\",\"countProduct\":\"1.00\"},{\"codProduct\":\"93\",\"countProduct\":\"1.00\"},{\"codProduct\":\"94\",\"countProduct\":\"1.00\"},{\"codProduct\":\"94\",\"countProduct\":\"1.00\"},{\"codProduct\":\"93\",\"countProduct\":\"1.00\"},{\"codProduct\":\"93\",\"countProduct\":\"1.00\"}]', '2024-02-08', '2024-02-07', 7, '2024-02-08 14:53:08', '2024-02-08 14:53:08');
INSERT INTO `tb_ingreso` VALUES (10, 1, NULL, 1, '', '[{\"codProduct\":\"94\",\"countProduct\":\"1.00\"},{\"codProduct\":\"94\",\"countProduct\":\"1.00\"}]', '2024-02-08', '2024-02-07', 7, '2024-02-08 16:14:45', '2024-02-08 16:14:45');
INSERT INTO `tb_ingreso` VALUES (49, 1, NULL, 1, 'ingreso azucar por Kg', '[{\"codProduct\":\"95\",\"countProduct\":\"100\"}]', '2024-02-12', '2024-02-07', 7, '2024-02-12 06:12:42', '2024-02-12 06:12:42');
INSERT INTO `tb_ingreso` VALUES (50, 1, NULL, 1, '', '[{\"codProduct\":\"95\",\"countProduct\":\"3\"},{\"codProduct\":\"87\",\"countProduct\":\"4\"},{\"codProduct\":\"67\",\"countProduct\":\"5\"},{\"codProduct\":\"66\",\"countProduct\":\"6\"}]', '2024-02-13', '2024-02-07', 7, '2024-02-13 15:02:51', '2024-02-13 15:02:51');
INSERT INTO `tb_ingreso` VALUES (51, 1, NULL, 1, '', '[{\"codProduct\":\"65\",\"countProduct\":\"8\"}]', '2024-02-13', '2024-02-07', 7, '2024-02-13 15:11:57', '2024-02-13 15:11:57');
INSERT INTO `tb_ingreso` VALUES (52, 1, NULL, 1, '', '[{\"codProduct\":\"65\",\"countProduct\":\"15\"}]', '2024-02-13', '2024-02-07', 7, '2024-02-13 15:12:28', '2024-02-13 15:12:28');
INSERT INTO `tb_ingreso` VALUES (53, 4, NULL, 1, '', '[{\"codProduct\":\"95\",\"countProduct\":\"3\"}]', '2024-02-13', '2024-02-07', 7, '2024-02-13 18:34:57', '2024-02-15 16:59:12');
INSERT INTO `tb_ingreso` VALUES (56, 4, NULL, 1, 'asda', '[{\"codProduct\":\"93\",\"countProduct\":\"3\"},{\"codProduct\":\"94\",\"countProduct\":\"23\"}]', '2024-02-15', '2024-02-07', 7, '2024-02-15 23:15:30', '2024-02-21 15:20:10');
INSERT INTO `tb_ingreso` VALUES (57, 4, '{\"codSalida\":\"22\",\"tipoSalida\":\"Nota de Pedido\"}', 2, 'Devolución porque un producto está roto', '[{\"codProduct\":\"95\",\"priceProduct\":\"12.00\",\"countProduct\":\"3\",\"newSum\":\"36.00\"}]', '2024-02-23', NULL, 6, '2024-02-21 21:40:11', '2024-02-21 21:40:11');
INSERT INTO `tb_ingreso` VALUES (58, 4, '{\"codSalida\":\"22\",\"tipoSalida\":\"Nota de Pedido\"}', 2, 'Devolución porque un producto está roto', '[{\"codProduct\":\"95\",\"priceProduct\":\"12.00\",\"countProduct\":\"3\",\"newSum\":\"36.00\"}]', '2024-02-23', NULL, 6, '2024-02-21 21:40:25', '2024-02-21 21:40:25');
INSERT INTO `tb_ingreso` VALUES (59, 4, '{\"codSalida\":\"22\",\"tipoSalida\":\"Nota de Pedido\"}', 2, 'Devolución porque un producto está roto', '[{\"codProduct\":\"95\",\"priceProduct\":\"12.00\",\"countProduct\":\"3\",\"newSum\":\"36.00\"}]', '2024-02-23', NULL, 6, '2024-02-21 21:40:44', '2024-02-21 21:40:44');
INSERT INTO `tb_ingreso` VALUES (60, 4, '{\"codSalida\":\"26\",\"tipoSalida\":\"Nota de Pedido\"}', 2, 'Se devuelve porque dos productos llegaron en mal estado', '[{\"codProduct\":\"94\",\"priceProduct\":\"50.00\",\"countProduct\":\"5\",\"newSum\":\"250.00\"}]', '2024-02-23', NULL, 6, '2024-02-21 21:49:48', '2024-02-21 21:49:48');
INSERT INTO `tb_ingreso` VALUES (61, 4, '{\"codSalida\":\"26\",\"tipoSalida\":\"Nota de Pedido\"}', 2, 'Se devuelve porque dos productos llegaron en mal estado', '[{\"codProduct\":\"94\",\"priceProduct\":\"50.00\",\"countProduct\":\"5\",\"newSum\":\"250.00\"}]', '2024-02-23', NULL, 6, '2024-02-21 21:54:58', '2024-02-21 21:54:58');
INSERT INTO `tb_ingreso` VALUES (62, 4, '{\"codSalida\":\"27\",\"tipoSalida\":\"Nota de Pedido\"}', 2, '1231', '[{\"codProduct\":\"85\",\"countProduct\":\"5\"},{\"codProduct\":\"1\",\"countProduct\":\"2\"},{\"codProduct\":\"2\",\"countProduct\":\"10\"}]', '2024-03-01', NULL, 6, '2024-02-21 22:27:42', '2024-02-21 22:27:42');
INSERT INTO `tb_ingreso` VALUES (63, 4, NULL, 1, 'asdasda', '[{\"codProduct\":\"96\",\"countProduct\":\"25\"}]', '2024-02-22', '2025-02-21', 7, '2024-02-22 05:18:06', '2024-02-21 23:18:23');
INSERT INTO `tb_ingreso` VALUES (64, 4, '{\"codSalida\":\"36\",\"tipoSalida\":\"Lote\"}', 2, 'Motivo X', '[{\"codProduct\":\"2\",\"countProduct\":\"3\"}]', '2024-02-23', NULL, 6, '2024-02-22 01:50:03', '2024-02-22 01:50:03');
INSERT INTO `tb_ingreso` VALUES (65, 4, '{\"codSalida\":\"34\",\"tipoSalida\":\"Lote\"}', 2, 'asda', '[{\"codProduct\":\"85\",\"countProduct\":\"1\"}]', '2024-02-23', NULL, 6, '2024-02-22 01:53:50', '2024-02-22 01:53:50');
INSERT INTO `tb_ingreso` VALUES (66, 4, '{\"codSalida\":\"25\",\"tipoSalida\":\"Nota de Pedido\"}', 2, 'asda', '[{\"codProduct\":\"94\",\"countProduct\":\"1\"}]', '2024-02-24', NULL, 6, '2024-02-22 01:56:52', '2024-02-22 01:56:52');
INSERT INTO `tb_ingreso` VALUES (67, 4, '{\"codSalida\":\"33\",\"tipoSalida\":\"Lote\"}', 2, '21', '[{\"codProduct\":\"92\",\"countProduct\":\"2\"}]', '2024-02-24', NULL, 6, '2024-02-22 01:59:31', '2024-02-22 01:59:31');

-- ----------------------------
-- Table structure for tb_lote
-- ----------------------------
DROP TABLE IF EXISTS `tb_lote`;
CREATE TABLE `tb_lote`  (
  `IdLote` int NOT NULL AUTO_INCREMENT,
  `IdPer` int NOT NULL,
  `IdCliente` int NOT NULL,
  `CodigoLote` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `DescripcionLote` varchar(150) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `DatosLoteIngresoJson` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `FechaProduccionLote` date NOT NULL,
  `FechaVencimientoLote` date NOT NULL,
  `Estado` int NOT NULL,
  `FechaDevolucion` date NULL DEFAULT NULL,
  `NroFactura` varchar(150) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `DateCreate` datetime NOT NULL,
  `DateUpdate` datetime NOT NULL,
  PRIMARY KEY (`IdLote`) USING BTREE,
  INDEX `IdPer`(`IdPer`) USING BTREE,
  CONSTRAINT `tb_lote_ibfk_1` FOREIGN KEY (`IdPer`) REFERENCES `tb_personal` (`IdPer`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 38 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_lote
-- ----------------------------
INSERT INTO `tb_lote` VALUES (33, 1, 8, 'L-21_02_1_92', 'Nuevo Lote 2', '[{\"codProduct\":\"92\",\"countProduct\":\"5\"}]', '2024-02-21', '2025-06-17', 3, '2024-02-24', '', '2024-02-19 21:43:10', '2024-02-22 01:59:31');
INSERT INTO `tb_lote` VALUES (34, 7, 10, 'L-20_02_7_85', '1231', '[{\"codProduct\":\"85\",\"countProduct\":\"5\"}]', '2024-02-20', '2024-02-29', 3, '2024-02-23', '', '2024-02-20 17:10:07', '2024-02-22 01:53:50');
INSERT INTO `tb_lote` VALUES (35, 7, 1, 'L-20_02_7_2', 'fsda', '[{\"codProduct\":\"2\",\"countProduct\":\"6\"}]', '2024-02-20', '2024-03-09', 3, NULL, '', '2024-02-20 17:10:21', '2024-02-20 17:10:21');
INSERT INTO `tb_lote` VALUES (36, 1, 8, 'L-21_02_1_2', '', '[{\"codProduct\":\"2\",\"countProduct\":\"10\"}]', '2024-02-21', '2024-03-01', 3, '2024-02-23', '001-055155', '2024-02-21 09:50:21', '2024-02-22 01:50:03');
INSERT INTO `tb_lote` VALUES (37, 7, 24, 'L-01_03_7_85', 'x', '[{\"codProduct\":\"85\",\"countProduct\":\"5\"}]', '2024-03-01', '2024-03-07', 1, NULL, NULL, '2024-02-22 01:14:56', '2024-02-22 01:14:56');

-- ----------------------------
-- Table structure for tb_notapedido
-- ----------------------------
DROP TABLE IF EXISTS `tb_notapedido`;
CREATE TABLE `tb_notapedido`  (
  `IdNotaP` int NOT NULL AUTO_INCREMENT,
  `IdPer` int NOT NULL,
  `IdRes` int NOT NULL,
  `Observacion` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `EstadoNota` int NOT NULL,
  `IdCliente` varchar(25) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `DatosProductosNotaPedidoJson` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `Total` decimal(10, 2) NOT NULL,
  `FechaNotaPedido` date NULL DEFAULT NULL,
  `FechaDevolucion` date NULL DEFAULT NULL,
  `NroFactura` varchar(150) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `DateCreate` datetime NOT NULL,
  `DateUpdate` datetime NOT NULL,
  PRIMARY KEY (`IdNotaP`) USING BTREE,
  INDEX `IdPer`(`IdPer`) USING BTREE,
  CONSTRAINT `tb_notapedido_ibfk_1` FOREIGN KEY (`IdPer`) REFERENCES `tb_personal` (`IdPer`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 32 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_notapedido
-- ----------------------------
INSERT INTO `tb_notapedido` VALUES (22, 3, 1, '', 1, '8', '[{\"codProduct\":\"95\",\"priceProduct\":\"12.00\",\"countProduct\":\"3\",\"newSum\":\"36.00\"}]', 42.48, '2024-02-14', NULL, NULL, '2024-02-14 08:35:30', '2024-02-14 08:35:30');
INSERT INTO `tb_notapedido` VALUES (23, 3, 1, '', 2, '9', '[{\"codProduct\":\"94\",\"priceProduct\":\"50.00\",\"countProduct\":\"34\",\"newSum\":\"1700.00\"}]', 1700.00, '2024-02-16', NULL, NULL, '2024-02-16 10:03:00', '2024-02-16 10:03:00');
INSERT INTO `tb_notapedido` VALUES (24, 5, 1, '', 3, '1', '[{\"codProduct\":\"94\",\"priceProduct\":\"50.00\",\"countProduct\":\"5\",\"newSum\":\"250.00\"}]', 250.00, '2024-02-16', NULL, NULL, '2024-02-16 10:57:15', '2024-02-16 10:57:15');
INSERT INTO `tb_notapedido` VALUES (25, 3, 1, '', 4, '8', '[{\"codProduct\":\"94\",\"priceProduct\":\"50.00\",\"countProduct\":\"3\",\"newSum\":\"150.00\"}]', 150.00, '2024-02-20', '2024-02-24', NULL, '2024-02-16 12:59:09', '2024-02-22 01:57:03');
INSERT INTO `tb_notapedido` VALUES (26, 3, 1, '', 1, '1', '[{\"codProduct\":\"94\",\"priceProduct\":\"50.00\",\"countProduct\":\"5\",\"newSum\":\"250.00\"}]', 250.00, '2024-02-17', '2024-02-23', '123', '2024-02-17 09:34:07', '2024-02-21 21:54:58');
INSERT INTO `tb_notapedido` VALUES (27, 5, 1, '', 2, '8', '[{\"codProduct\":\"85\",\"priceProduct\":\"0.00\",\"countProduct\":\"15\",\"newSum\":\"0.00\"},{\"codProduct\":\"1\",\"priceProduct\":\"0.00\",\"countProduct\":\"5\",\"newSum\":\"0.00\"},{\"codProduct\":\"2\",\"priceProduct\":\"0.00\",\"countProduct\":\"10\",\"newSum\":\"0.00\"}]', 0.00, '2024-02-17', '2024-03-01', NULL, '2024-02-17 11:06:08', '2024-02-26 23:59:13');
INSERT INTO `tb_notapedido` VALUES (30, 5, 7, '', 3, '1', '[{\"codProduct\":\"94\",\"priceProduct\":\"50.00\",\"countProduct\":\"3\",\"newSum\":\"150.00\"}]', 150.00, '2024-02-23', NULL, NULL, '2024-02-21 09:43:19', '2024-02-21 09:43:19');
INSERT INTO `tb_notapedido` VALUES (31, 3, 7, '', 5, '24', '[{\"codProduct\":\"96\",\"priceProduct\":\"123.00\",\"countProduct\":\"44\",\"newSum\":\"5412.00\"}]', 5412.00, '2024-02-26', NULL, NULL, '2024-02-26 23:12:11', '2024-02-26 23:12:11');

-- ----------------------------
-- Table structure for tb_personal
-- ----------------------------
DROP TABLE IF EXISTS `tb_personal`;
CREATE TABLE `tb_personal`  (
  `IdPer` int NOT NULL AUTO_INCREMENT,
  `IdTipoPer` int NOT NULL,
  `dni` int NOT NULL,
  `NombrePer` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `ApellidoPer` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `TelefonoPer` varchar(12) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `DireccionPer` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `Estado` int NOT NULL,
  `DateCreate` datetime NOT NULL,
  `DateUpdate` datetime NOT NULL,
  PRIMARY KEY (`IdPer`) USING BTREE,
  INDEX `IdTipoPer`(`IdTipoPer`) USING BTREE,
  CONSTRAINT `tb_personal_ibfk_1` FOREIGN KEY (`IdTipoPer`) REFERENCES `tb_tipopersonal` (`IdTipoPer`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_personal
-- ----------------------------
INSERT INTO `tb_personal` VALUES (1, 1, 123456789, 'Alex Responsable 1', 'Andrade', '1234567890', 'DirecciónResponsable', 3, '2023-09-14 11:54:27', '2024-02-09 11:17:19');
INSERT INTO `tb_personal` VALUES (3, 3, 456789012, 'NombreVendedorrrrrrrr', 'ApellidoVendedor', '4567890123', 'DirecciónVendedor', 3, '2023-09-14 11:54:27', '2024-02-13 09:07:54');
INSERT INTO `tb_personal` VALUES (4, 2, 456789012, 'Alex R 2', 'ApellidoResponsable', '4567890124', 'DirecciónResponsable', 3, '2023-09-14 11:54:27', '2024-01-29 17:24:44');
INSERT INTO `tb_personal` VALUES (5, 3, 2147483647, 'alex', 'flores', '435443543', 'casita 2', 3, '2024-02-01 11:43:18', '2024-02-01 11:43:18');
INSERT INTO `tb_personal` VALUES (6, 3, 2147483647, 'alex vendepuertas', 'flores', '654654654', 'casita cerro', 4, '2024-02-12 00:16:52', '2024-02-16 12:18:27');
INSERT INTO `tb_personal` VALUES (7, 1, 1233, 'Nuevo Personal', 'Persona', '888888', 'asdasda', 3, '2024-02-20 16:41:05', '2024-02-20 16:41:23');

-- ----------------------------
-- Table structure for tb_producto
-- ----------------------------
DROP TABLE IF EXISTS `tb_producto`;
CREATE TABLE `tb_producto`  (
  `IdProd` int NOT NULL AUTO_INCREMENT,
  `IdCate` int NOT NULL,
  `NombreProducto` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `DetalleProducto` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `Unidad` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `Cantidad` int NOT NULL,
  `Precio` decimal(10, 2) NOT NULL,
  `DateCreate` datetime NOT NULL,
  `DateUpdate` datetime NOT NULL,
  PRIMARY KEY (`IdProd`) USING BTREE,
  INDEX `IdCate`(`IdCate`) USING BTREE,
  CONSTRAINT `tb_producto_ibfk_1` FOREIGN KEY (`IdCate`) REFERENCES `tb_categoriaprod` (`IdCate`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 97 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_producto
-- ----------------------------
INSERT INTO `tb_producto` VALUES (1, 1, 'Aceite de Ajonjolí x 250ml.', NULL, 'ml', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (2, 1, 'Aceite de Castaña x 250ml.', NULL, 'ml', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (3, 1, 'Aceite de Chía x 250ml.', NULL, 'ml', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (4, 1, 'Aceite de Coco x 120gr.', NULL, 'gr', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (5, 1, 'Aceite de Coco x 200gr.', NULL, 'gr', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (6, 1, 'Aceite de Coco x 350gr.', NULL, 'gr', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (7, 1, 'Aceite de Coco x 710gr.', NULL, 'gr', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (8, 1, 'Aceite de Linaza x 250ml.', NULL, 'ml', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (9, 1, 'Aceite de Olivo Extra x 1L.', 'PET', 'L', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (10, 1, 'Aceite de Olivo Extra x 200ml.', 'Vidrio', 'ml', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (11, 1, 'Aceite de Olivo Extra x 200ml.', 'PET', 'ml', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (12, 1, 'Aceite de Olivo Extra x 250ml.', 'Vidrio', 'ml', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (13, 1, 'Aceite de Olivo Extra x 250ml.', 'Vidrio', 'ml', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (14, 1, 'Aceite de Olivo Extra x 275', 'Spray', 'ml', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (15, 1, 'Aceite de Olivo Extra x 500 ', 'Spray', 'ml', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (16, 1, 'Aceite de Olivo Extra x 500 ', 'Vidrio Oscuro', 'ml', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (17, 1, 'Aceite de Olivo Extra x 500 ', 'Vidrio', 'ml', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (18, 1, 'Aceite de Olivo Extra x 500ml.', 'PET', 'ml', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (19, 1, 'Aceite de Olivo Extra x 500ml.', 'Vidrio', 'ml', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (20, 1, 'Aceite de Olivo Extra x 1L.', 'PET', 'L', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (21, 1, 'Aceite de Olivo Extra x 1L. ', 'Vidrio Verde', 'L', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (22, 1, 'Aceite de Olivo Extravirgen x 5L.', NULL, 'L', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (23, 1, 'Aceite de Olivo Virgen x 200ml. ', 'PET', 'ml', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (24, 1, 'Aceite de Olivo Virgen x 250ml.', NULL, 'ml', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (25, 1, 'Aceite de Olivo Virgen x 500', 'Vidrio', 'ml', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (26, 1, 'Aceite de Olivo Virgen x 500ml.', 'PET', 'ml', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (27, 1, 'Aceite de Olivo Virgen x 1L.', 'PET', 'L', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (28, 1, 'Aceite de Sacha Inchi x 250ml.', NULL, 'ml', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (30, 2, 'Aceituna Negra 1ra x Balde 15kg.', NULL, 'kg', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (31, 2, 'Aceituna Negra 250gr.', NULL, 'gr', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (32, 2, 'Aceituna Negra 500gr.', NULL, 'gr', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (33, 2, 'Aceituna Negra Cocktail kg.', NULL, 'kg', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (34, 2, 'Aceituna Negra Deshuesada 250gr.', NULL, 'gr', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (35, 2, 'Aceituna Negra Deshuesada 500gr.', NULL, 'gr', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (36, 2, 'Aceituna Negra Deshuesada Premium kg.', NULL, 'kg', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (38, 2, 'Aceituna Negra Rodaja 250gr.', NULL, 'gr', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (39, 2, 'Aceituna Negra Rodaja 500gr.', NULL, 'gr', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (40, 2, 'Aceituna Negra Rodaja kg.', NULL, 'kg', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (41, 2, 'Aceituna Negra x 1kg.', NULL, 'kg', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (42, 2, 'Aceituna Premium kg.', 'Extra', 'kg', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (43, 2, 'Aceituna Primera kg. Promoción', NULL, 'kg', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (44, 2, 'Aceituna Verde 250gr.', NULL, 'gr', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (45, 2, 'Aceituna Verde 500gr.', NULL, 'gr', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (46, 2, 'Aceituna Verde Deshuesada 250gr.', NULL, 'gr', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (47, 2, 'Aceituna Verde Deshuesada 500gr.', NULL, 'gr', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (48, 2, 'Aceituna Verde Deshuesada kg.', NULL, 'kg', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (49, 2, 'Aceituna Verde kg.', NULL, 'kg', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (50, 2, 'Aceituna Verde Relleno Pimiento 250gr.', NULL, 'gr', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (51, 2, 'Aceituna Verde Relleno Pimiento 500gr.', NULL, 'gr', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (52, 2, 'Aceituna Verde Relleno Pimiento kg.', NULL, 'kg', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (53, 2, 'Aceituna Verde Relleno Pimiento x 500gr.', NULL, 'gr', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (54, 2, 'Aceituna Verde Relleno Rocoto 250gr.', NULL, 'gr', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (55, 2, 'Aceituna Verde Relleno Rocoto kg.', NULL, 'kg', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (56, 2, 'Aceituna Verde Rocoto x 500gr.', NULL, 'gr', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (57, 2, 'Aceituna Verde Rodaja 250gr.', NULL, 'gr', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (58, 2, 'Aceituna Verde Rodaja 500gr.', NULL, 'gr', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (59, 2, 'Aceituna Verde Rodaja kg.', NULL, 'kg', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (60, 2, 'Aceituna Verde x 1kg. a granel', NULL, 'kg', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (61, 2, 'Aceituna Verde x Balde de 15kg.', NULL, 'kg', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (62, 2, 'Bidón Aceituna Negra x 2kg.', '1era', 'kg', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (63, 2, 'Bidón Aceituna Negra x 2kg.', '3era', 'kg', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (64, 2, 'Bidón de Aceituna Verde x 2kg.', NULL, 'kg', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (65, 3, 'Algarrobina x 500 ', 'PET', 'ml', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (66, 3, 'Algarrobina x 500 ', 'Vidrio', 'ml', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (67, 3, 'Miel de Abeja x 1.100gr.', NULL, 'gr', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (68, 3, 'Miel de Abeja x 500gr.', NULL, 'gr', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (69, 3, 'Miel de Abeja x 500 ', 'PET', 'gr', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (70, 3, 'Miel de Caña x 500 ', 'PET', 'gr', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (71, 3, 'Panela x 500gr.', NULL, 'gr', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (72, 3, 'Panela x kg.', NULL, 'kg', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (73, 3, 'Panela x saco kg.', NULL, 'kg', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (74, 4, 'Crema de Aceituna 250gr.', NULL, 'gr', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (75, 4, 'Crema de Aceituna 500gr.', NULL, 'gr', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (76, 5, 'Manzana 2L.', NULL, 'L', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (77, 5, 'Manzana Premium 1L.', NULL, 'L', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (78, 5, 'Maracuyá Normal 2L.', NULL, 'L', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (79, 5, 'Maracuyá Premium 1L.', NULL, 'L', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (80, 5, 'Piña 2L.', NULL, 'L', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (81, 5, 'Piña Premium 1L.', NULL, 'L', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (82, 5, 'Cebada 2L.', NULL, 'L', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (83, 5, 'Cebada Premium 1L.', NULL, 'L', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (84, 5, 'Maíz Morado Premium 1L.', NULL, 'L', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (85, 5, 'Maíz Morado Premium 2L.', NULL, 'L', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (86, 5, 'Membrillo 1L.', NULL, 'L', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (87, 5, 'Membrillo 2L.', NULL, 'L', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (88, 6, 'Vinagre de Manzana x 1L.', 'PET', 'L', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (89, 6, 'Vinagre de Manzana x 1L.', 'Vidrio', 'L', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (90, 6, 'Vinagre de Manzana x 200ml.', 'PET', 'ml', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (91, 6, 'Vinagre de Manzana x 280', 'Spray', 'ml', 1, 0.00, '2024-01-26 16:14:30', '2024-01-26 16:14:30');
INSERT INTO `tb_producto` VALUES (92, 6, 'Vinagre de Manzana x 500', 'PET', 'ml', 1, 50.00, '2024-01-26 16:14:30', '2024-02-02 08:40:38');
INSERT INTO `tb_producto` VALUES (93, 6, 'Vinagre de Manzana x 500', 'Vidrio', 'ml', 1, 50.00, '2024-01-26 16:14:30', '2024-02-02 08:40:26');
INSERT INTO `tb_producto` VALUES (94, 6, 'Vinagre de Manzana x 500', 'Spray', 'ml', 1, 50.00, '2024-01-26 16:14:30', '2024-02-02 08:40:13');
INSERT INTO `tb_producto` VALUES (95, 5, 'Cañita de  Azucarrrr', 'Azucarararara', 'Kg', 1, 12.00, '2024-02-12 00:09:26', '2024-02-13 11:48:48');
INSERT INTO `tb_producto` VALUES (96, 4, 'Nuevo Producto', '1333', 'unidad', 0, 123.00, '2024-02-20 16:40:38', '2024-02-20 16:40:46');

-- ----------------------------
-- Table structure for tb_tipopersonal
-- ----------------------------
DROP TABLE IF EXISTS `tb_tipopersonal`;
CREATE TABLE `tb_tipopersonal`  (
  `IdTipoPer` int NOT NULL AUTO_INCREMENT,
  `DescripcionTipoPer` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `DateCreate` datetime NOT NULL,
  `DateUpdate` datetime NOT NULL,
  PRIMARY KEY (`IdTipoPer`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_tipopersonal
-- ----------------------------
INSERT INTO `tb_tipopersonal` VALUES (1, 'Responsable', '2023-09-14 11:54:27', '2023-09-14 11:54:27');
INSERT INTO `tb_tipopersonal` VALUES (2, 'Operario', '2023-09-14 11:54:27', '2023-09-14 11:54:27');
INSERT INTO `tb_tipopersonal` VALUES (3, 'Vendedor', '2023-09-14 11:54:27', '2023-09-14 11:54:27');

-- ----------------------------
-- Table structure for tb_tipousuario
-- ----------------------------
DROP TABLE IF EXISTS `tb_tipousuario`;
CREATE TABLE `tb_tipousuario`  (
  `IdTipoUsu` int NOT NULL AUTO_INCREMENT,
  `DescripcionTipo` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`IdTipoUsu`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_tipousuario
-- ----------------------------
INSERT INTO `tb_tipousuario` VALUES (1, 'Administrador');
INSERT INTO `tb_tipousuario` VALUES (2, 'Responsable');

-- ----------------------------
-- Table structure for tb_usuario
-- ----------------------------
DROP TABLE IF EXISTS `tb_usuario`;
CREATE TABLE `tb_usuario`  (
  `IdUsu` int NOT NULL AUTO_INCREMENT,
  `IdTipoUsu` int NOT NULL,
  `NombreUsu` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `Nombre` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `Apellido` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `LastConnection` datetime NULL DEFAULT NULL,
  `DateCreate` datetime NOT NULL,
  `DateUpdate` datetime NOT NULL,
  PRIMARY KEY (`IdUsu`) USING BTREE,
  INDEX `IdTipoUsu`(`IdTipoUsu`) USING BTREE,
  CONSTRAINT `tb_usuario_ibfk_1` FOREIGN KEY (`IdTipoUsu`) REFERENCES `tb_tipousuario` (`IdTipoUsu`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_usuario
-- ----------------------------
INSERT INTO `tb_usuario` VALUES (4, 2, 'alex2', 'Alex R 2', 'Responsable', '$argon2id$v=19$m=4096,t=2,p=2$OGxRc0lvQ3JleXY0UTlXLw$F91eyjVOr93VDJEy7tGFf9InNjkMuZDm7jmXeIizWdE', '2024-02-16 12:13:50', '2024-01-29 15:36:20', '2024-01-29 15:36:20');
INSERT INTO `tb_usuario` VALUES (5, 1, 'dpoblette', 'david', 'poblette', '$argon2id$v=19$m=4096,t=2,p=2$N2ZrdFlnRHBicHRudFlidw$Gu60C9Oitlc5FFcxPs0AWY1P4Qb3/IUceu6wsNCYEbA', NULL, '2024-02-13 10:03:07', '2024-02-13 10:03:07');
INSERT INTO `tb_usuario` VALUES (6, 1, 'admin', 'Administrador', 'administrador', '$argon2id$v=19$m=4096,t=2,p=2$ZURZWG0yNkNOZVJTLlg5Lw$MvzbwXUNlV+Inxssd1nN+A8EN5Il6CdSAs7pTc3szJk', '2024-02-26 23:06:18', '2024-02-16 12:09:23', '2024-02-16 12:09:23');
INSERT INTO `tb_usuario` VALUES (7, 2, 'userx', 'Usuar', 'Nuev', '$argon2id$v=19$m=4096,t=2,p=2$OURadTllTlRhOTBoczl6OA$yF40fIzeke/vG1FDi7+0GsnpQ+yvHen0klMxzYjUt74', NULL, '2024-02-20 16:42:22', '2024-02-20 16:42:22');

SET FOREIGN_KEY_CHECKS = 1;
