-- Estructura de tabla para la tabla `tb_TipoUsuario`

DROP TABLE IF EXISTS `tb_TipoUsuario`;
CREATE TABLE `tb_TipoUsuario` (
  `IdTipoUsu` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `DescripcionTipo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;


-- Estructura de tabla para la tabla `tb_usuario`

DROP TABLE IF EXISTS `tb_usuario`;
CREATE TABLE `tb_usuario` (
  `IdUsu` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `IdTipoUsu` int(11) NOT NULL,
  FOREIGN KEY (`IdTipoUsu`) REFERENCES `tb_TipoUsuario` (`IdTipoUsu`),
  `NombreUsu` varchar(255) NOT NULL,
  `Nombre` varchar(255) NOT NULL,
  `Apellido` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `LastConnection` datetime DEFAULT NULL,
  `DateCreate` datetime NOT NULL,
  `DateUpdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

-- Estructura de tabla para la tabla `tb_Responsable`

DROP TABLE IF EXISTS `tb_Responsable`;
CREATE TABLE `tb_Responsable` (
  `IdRes` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `NombreResponsable` varchar(255) NOT NULL,
  `ApellidoResponsable` varchar(255) NOT NULL,
  `CodigoResponsable` int(11) NOT NULL,
  `CargoResponsable` varchar(255) NOT NULL,
  `DateCreate` datetime NOT NULL,
  `DateUpdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

-- Estructura de tabla para la tabla `tb_IngresoNuevo`

DROP TABLE IF EXISTS `tb_IngresoNuevo`;
CREATE TABLE `tb_IngresoNuevo` (
  `IdIngNue` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `IdRes` int(11) NOT NULL,
  FOREIGN KEY (`IdRes`) REFERENCES `tb_Responsable` (`IdRes`),
  `DescripcionIngNuevo` varchar(255) NOT NULL,
  `FechaProduccion` datetime NOT NULL,
  `FechaVencimiento` datetime NOT NULL,
  `Estado` int(10) NOT NULL,
  `DateCreate` datetime NOT NULL,
  `DateUpdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

-- Estructura de tabla para la tabla `tb_Producto`

DROP TABLE IF EXISTS `tb_Producto`;
CREATE TABLE `tb_Producto` (
  `IdProd` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `CodigoProducto` int(11) NOT NULL,
  `DescripcionProducto` varchar(255) NOT NULL,
  `Unidad` int(11) NOT NULL,
  `Cantidad` int(11) NOT NULL,
  `Estado` int(10) NOT NULL,
  `DateCreate` datetime NOT NULL,
  `DateUpdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;


-- Estructura de tabla para la tabla `tb_Categoria`

DROP TABLE IF EXISTS `tb_Categoria`;
CREATE TABLE `tb_Categoria` (
  `IdCate` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `IdProd` int(11) NOT NULL,
  FOREIGN KEY (`IdProd`) REFERENCES `tb_Producto` (`IdProd`),
  `Estado` int(10) NOT NULL,
  `DateCreate` datetime NOT NULL,
  `DateUpdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

-- Estructura de tabla para la tabla `tb_IngresoNuevoDetalles`

DROP TABLE IF EXISTS `tb_IngresoNuevoDetalles`;
CREATE TABLE `tb_IngresoNuevoDetalles` (
  `IdIngNueDet` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `IdIngNue` int(11) NOT NULL,
  FOREIGN KEY (`IdIngNue`) REFERENCES `tb_IngresoNuevo` (`IdIngNue`),
  `IdProd` int(11) NOT NULL,
  FOREIGN KEY (`IdProd`) REFERENCES `tb_Producto` (`IdProd`),
  `CantidadNuevoDetalle` int(255) NOT NULL,
  `DateCreate` datetime NOT NULL,
  `DateUpdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

-- Estructura de tabla para la tabla `tb_Almacen`

DROP TABLE IF EXISTS `tb_Almacen`;
CREATE TABLE `tb_Almacen` (
  `IdAlma` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `IdIngNueDet` int(11) NOT NULL,
  FOREIGN KEY (`IdIngNueDet`) REFERENCES `tb_IngresoNuevoDetalles` (`IdIngNueDet`),
  `IdProd` int(11) NOT NULL,
  FOREIGN KEY (`IdProd`) REFERENCES `tb_Producto` (`IdProd`),
  `Cantidad` int(11) NOT NULL,
  `Estado` int(10) NOT NULL,
  `DateCreate` datetime NOT NULL,
  `DateUpdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

-- Estructura de tabla para la tabla `tb_Operario`

DROP TABLE IF EXISTS `tb_Operario`;
CREATE TABLE `tb_Operario` (
  `IdOpe` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `CodigoOperario` int(11) NOT NULL,
  `CargoOperario` varchar(255) NOT NULL,
  `NombreOperario` varchar(255) NOT NULL,
  `ApellidoOperario` varchar(255) NOT NULL,
  `TelefonoOperario` varchar(12) NOT NULL,
  `Estado` int(10) NOT NULL,
  `DateCreate` datetime NOT NULL,
  `DateUpdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

-- Estructura de tabla para la tabla `tb_lote`

DROP TABLE IF EXISTS `tb_lote`;
CREATE TABLE `tb_lote` (
  `IdLote` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `IdProd` int(11) NOT NULL,
  FOREIGN KEY (`IdProd`) REFERENCES `tb_Producto` (`IdProd`),
  `IdOpe` int(11) NOT NULL,
  FOREIGN KEY (`IdOpe`) REFERENCES `tb_Operario` (`IdOpe`),
  `CodigoLote` int(15) NOT NULL,
  `DescripcionLote` varchar(255) NOT NULL,
  `Cantidad` int(255) NOT NULL,
  `Estado` int(10) NOT NULL,
  `FechaProduccion` datetime NOT NULL,
  `FechaVencimiento` datetime NOT NULL,
  `DateCreate` datetime NOT NULL,
  `DateUpdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

-- Estructura de tabla para la tabla `tb_SalidaLote`

DROP TABLE IF EXISTS `tb_SalidaLote`;
CREATE TABLE `tb_SalidaLote` (
  `IdSaLote` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `IdLote` int(11) NOT NULL,
  FOREIGN KEY (`IdLote`) REFERENCES `tb_lote` (`IdLote`),
  `DescripcionSaLote` varchar(255) NOT NULL,
  `Estado` int(10) NOT NULL,
  `Cantidad` int(50) NOT NULL,
  `DateCreate` datetime NOT NULL,
  `DateUpdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

-- Estructura de tabla para la tabla `tb_venta`

DROP TABLE IF EXISTS `tb_venta`;
CREATE TABLE `tb_venta` (
  `IdVenta` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `DescripcionVenta` varchar(255) NOT NULL,
  `IdProd` int(11) NOT NULL,
  FOREIGN KEY (`IdProd`) REFERENCES `tb_Producto` (`IdProd`),
  `Cantidad` int(11) NOT NULL,
  `SubTotal` decimal(10,2) NOT NULL,
  `IGV` decimal(10,2) NOT NULL,
  `Total` decimal(10,2) NOT NULL,
  `Estado` int(10) NOT NULL,
  `DateCreate` datetime NOT NULL,
  `DateUpdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

-- Estructura de tabla para la tabla `tb_TipoCliente`

DROP TABLE IF EXISTS `tb_TipoCliente`;
CREATE TABLE `tb_TipoCliente` (
  `IdtipoCli` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `DescripcionTipoCli` varchar(255) NOT NULL,
  `DateCreate` datetime NOT NULL,
  `DateUpdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

-- Estructura de tabla para la tabla `tb_Cliente`

DROP TABLE IF EXISTS `tb_Cliente`;
CREATE TABLE `tb_Cliente` (
  `IdCli` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `IdtipoCli` int(11) NOT NULL,
  FOREIGN KEY (`IdtipoCli`) REFERENCES `tb_TipoCliente` (`IdtipoCli`),
  `IdVenta` int(11) NOT NULL,
  `IdSaLote` int(11) NOT NULL,
  `RucCliente` date NOT NULL,
  `NombreCliente` varchar(255) NOT NULL,
  `CorreoCliente` varchar(255) NOT NULL,
  `DireccionCliente` varchar(255) NOT NULL,
  `TelefonoCliente` varchar(50) NOT NULL,
  `Estado` int(10) NOT NULL,
  `DateCreate` datetime NOT NULL,
  `DateUpdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;


-- Inserts para tipo usuario

INSERT INTO `tb_TipoUsuario` (`IdTipoUsu`, `DescripcionTipo`) VALUES
(1, 'Administrador'),
(2, 'Usuario Tipo 1'),
(3, 'Usuario Tipo 2');


-- Inserts para usuarios

INSERT INTO `tb_usuario` (`IdUsu`, `IdTipoUsu`, `NombreUsu`, `Nombre`, `Apellido`, password, `LastConnection`, `DateCreate`, `DateUpdate`) VALUES
(1, 1, 'admin', 'David', 'Poblette', '$argon2id$v=19$m=4096,t=2,p=2$UWpleWtkc2hqM3RXeXlxbg$8On5PLoftLU6P/RR7R6AYdbYsYRg1uWLmZOL7Fc/bY8', '2024-01-12 16:35:33', '2023-09-14 11:54:27', '2023-09-14 11:54:27');
(2, 1, 'alex', 'Alex', 'Flores', '$argon2id$v=19$m=4096,t=2,p=2$UWpleWtkc2hqM3RXeXlxbg$8On5PLoftLU6P/RR7R6AYdbYsYRg1uWLmZOL7Fc/bY8', '2024-01-12 16:35:33', '2023-09-14 11:54:27', '2023-09-14 11:54:27');
