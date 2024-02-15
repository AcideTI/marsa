
CREATE TABLE `tb_estado` (
  `IdEstado` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `TipoEstado` varchar(255) NOT NULL,
  `Descripcion` varchar(255) NOT NULL,
  `DateCreate` datetime NOT NULL,
  `DateUpdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

CREATE TABLE `tb_TipoUsuario` (
  `IdTipoUsu` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `DescripcionTipo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

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

CREATE TABLE `tb_tipopersonal` (
  `IdTipoPer` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `IdUsu` int(11) NULL,
  FOREIGN KEY (`IdUsu`) REFERENCES `tb_usuario` (`IdUsu`),
  `DescripcionTipoPer` varchar(255) NOT NULL,
  `DateCreate` datetime NOT NULL,
  `DateUpdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

CREATE TABLE `tb_personal` (
  `IdPer` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `IdTipoPer` int(11) NOT NULL,
  FOREIGN KEY (`IdTipoPer`) REFERENCES `tb_tipopersonal` (`IdTipoPer`),
  `dni` int(11) NOT NULL,
  `NombrePer` varchar(255) NOT NULL,
  `ApellidoPer` varchar(255) NOT NULL,
  `TelefonoPer` varchar(12) NOT NULL,
  `DireccionPer` varchar(255) NOT NULL,
  `Estado` int(10) NOT NULL,
  `DateCreate` datetime NOT NULL,
  `DateUpdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

CREATE TABLE `tb_categoriaprod` (
  `IdCate` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `NombreCategoria` varchar(255) NOT NULL,
  `DateCreate` datetime NOT NULL,
  `DateUpdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

CREATE TABLE `tb_producto` (
  `IdProd` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `IdCate` int(11) NOT NULL,
  FOREIGN KEY (`IdCate`) REFERENCES `tb_categoriaprod` (`IdCate`),
  `NombreProducto` varchar(255) NOT NULL,
  `DetalleProducto` varchar(255) NULL,
  `Unidad` varchar(50) NOT NULL,
  `Cantidad` int(250) NOT NULL,
  `Precio` decimal(10,2) NOT NULL,
  `DateCreate` datetime NOT NULL,
  `DateUpdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

CREATE TABLE `tb_ingreso` (
  `IdIng` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `IdPer` int(11) NOT NULL,
  FOREIGN KEY (`IdPer`) REFERENCES `tb_personal` (`IdPer`),
  `DescripcionIng` varchar(150) NULL,
  `DatosProductosIngresoJson` json NOT NULL,
  `FechaProduccionIng` date NOT NULL,
  `FechaVencimientoIng` date NOT NULL,
  `FechaReingresoIng` date NULL,
  `FechaMermaIng` date NULL,
  `Estado` int(10) NOT NULL,
  `DateCreate` datetime NOT NULL,
  `DateUpdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;



CREATE TABLE `tb_almacen` (
  `IdAlma` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `IdProd` int(11) NOT NULL,
  FOREIGN KEY (`IdProd`) REFERENCES `tb_producto` (`IdProd`),
  `CantidadTotal` int(250) NOT NULL,
  `DateCreate` date NOT NULL,
  `DateUpdate` date NOT NULL,
  `HoraCreate` time NOT NULL,
  `HoraUpdate` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

CREATE TABLE `tb_lote` (
  `IdLote` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `IdPer` int(11) NOT NULL,
  FOREIGN KEY (`IdPer`) REFERENCES `tb_personal` (`IdPer`),
  `CodigoLote` varchar(50) NOT NULL,
  `DescripcionLote` varchar(150) NULL,
  `DatosLoteIngresoJson` json NOT NULL,
  `FechaProduccionLote` date NOT NULL,
  `FechaVencimientoLote` date NOT NULL,
  `Estado` int(10) NOT NULL,
  `DateCreate` datetime NOT NULL,
  `DateUpdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

CREATE TABLE `tb_cliente` (
  `IdCli` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `RucCli`  varchar(255)  NULL,
  `NombreCli` varchar(255) NOT NULL,
  `CorreoCli` varchar(255) NOT NULL,
  `DireccionCli` varchar(255) NOT NULL,
  `TelefonoCli` int(12) NOT NULL,
  `Estado` int(10) NOT NULL,
  `DateCreate` datetime NOT NULL,
  `DateUpdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

CREATE TABLE `tb_notapedido` (
  `IdNotaP` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `IdLote` int(11) NULL,
  `IdPer` int(11) NOT NULL,
  FOREIGN KEY (`IdPer`) REFERENCES `tb_personal` (`IdPer`),
  `IdRes` int(11) NOT NULL,
  `IdCliente` int(11) NOT NULL,
  `TipoDeNotaPe` varchar(100) NULL,
  `TipoNotaPeFactura` varchar(100) NULL,
  `NotaPorFA` varchar(100) NULL,
  `DatosProductosNotaPedidoJson` json NOT NULL,
  `SubTotal` decimal(10,2) NOT NULL,
  `IGV` decimal(10,2) NOT NULL,
  `Total` decimal(10,2) NOT NULL,
  `ComentarioNotaDev` varchar(255) NULL,
  `Estado` int(10) NOT NULL,
  `FechaNotaPedido` date NULL,
  `FechaNotaDevolucion` date NULL,
  `DateCreate` datetime NOT NULL,
  `DateUpdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;


