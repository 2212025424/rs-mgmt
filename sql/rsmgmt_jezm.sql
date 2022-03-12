

-- Empresa clienta:     El Cangrejo Dorado
-- Dueño empresa: 	Adrian Zempoaltecatl Xochitecatl
-- Desarrollador: 	Jose Enrique Zempoaltecatl Moyotl
-- Fecha termino: 	17 de Octubre de 2020

CREATE DATABASE rsmgmt_jezm
    DEFAULT CHARACTER SET utf8;

USE rsmgmt_jezm;

--
-- Parte derecha del modelo entidad relación
--

CREATE TABLE Proveedor (
    clave VARCHAR(10) NOT NULL UNIQUE,
    razonsocial VARCHAR(100) NOT NULL UNIQUE, 
    RFC VARCHAR(20) NOT NULL UNIQUE,
    telefono VARCHAR(10) NOT NULL UNIQUE,
    correo VARCHAR(100) NOT NULL UNIQUE,
    nota TEXT CHARACTER SET utf8,
    PRIMARY KEY (clave)
) ENGINE=INNODB;


CREATE TABLE Unidad (
    clave VARCHAR(10) NOT NULL UNIQUE,
    unidad VARCHAR(20) NOT NULL UNIQUE,
    PRIMARY KEY (clave)
) ENGINE=INNODB;


CREATE TABLE AreaProduccion (
    clave VARCHAR(10) NOT NULL UNIQUE,
    area VARCHAR(50) NOT NULL UNIQUE,
    PRIMARY KEY (clave)
) ENGINE=INNODB;

CREATE TABLE CategoriaProducto (
    clave VARCHAR(10) NOT NULL UNIQUE,
    categoria VARCHAR(50) NOT NULL UNIQUE,
    PRIMARY KEY (clave)
) ENGINE=INNODB;

CREATE TABLE Producto (
    clave VARCHAR(10) NOT NULL UNIQUE,
    cvl_proveedor VARCHAR(10) NOT NULL,
    cvl_area VARCHAR(10) NOT NULL,
    cvl_categoria VARCHAR(10) NOT NULL,
    cvl_unidad VARCHAR(10) NOT NULL,
    producto VARCHAR(50) NOT NULL UNIQUE,
    existencias INT NOT NULL DEFAULT 0,
    reOrden INT NOT NULL DEFAULT 0,
    precio FLOAT(5,2) NOT NULL,
    nota TEXT CHARACTER SET utf8,
    estado TINYINT NOT NULL,
    PRIMARY KEY (clave),
    FOREIGN KEY (cvl_proveedor)
        REFERENCES Proveedor (clave)
                ON UPDATE CASCADE
                ON DELETE RESTRICT,
    FOREIGN KEY (cvl_area)
        REFERENCES AreaProduccion (clave)
                ON UPDATE CASCADE
                ON DELETE RESTRICT,
    FOREIGN KEY (cvl_categoria)
        REFERENCES CategoriaProducto (clave)
                ON UPDATE CASCADE
                ON DELETE RESTRICT,
    FOREIGN KEY (cvl_unidad)
        REFERENCES Unidad (clave)
                ON UPDATE CASCADE
                ON DELETE RESTRICT
) ENGINE=INNODB;

CREATE TABLE CategoriaInsumo (
    clave VARCHAR(10) NOT NULL UNIQUE,
    categoria VARCHAR(50) NOT NULL UNIQUE,
    PRIMARY KEY (clave)
) ENGINE=INNODB;

CREATE TABLE Insumo (
    clave VARCHAR(10) NOT NULL UNIQUE,
    cvl_proveedor VARCHAR(10) NOT NULL,
    cvl_categoria VARCHAR(10) NOT NULL,
    cvl_unidad VARCHAR(10) NOT NULL,
    insumo VARCHAR(50) NOT NULL UNIQUE,
    existencias INT NOT NULL DEFAULT 0,
    reOrden INT NOT NULL DEFAULT 0,
    nota TEXT CHARACTER SET utf8,
    PRIMARY KEY (clave),
    FOREIGN KEY (cvl_proveedor)
        REFERENCES Proveedor (clave)
            ON UPDATE CASCADE
            ON DELETE RESTRICT,
    FOREIGN KEY (cvl_categoria)
        REFERENCES CategoriaInsumo (clave)
            ON UPDATE CASCADE
            ON DELETE RESTRICT,
    FOREIGN KEY (cvl_unidad)
        REFERENCES Unidad (clave)
            ON UPDATE CASCADE
            ON DELETE RESTRICT
) ENGINE=INNODB;


CREATE TABLE ConsumoInsumo (
    cvl_producto VARCHAR(10) NOT NULL,
    cvl_insumo VARCHAR(10) NOT NULL,
    numproductos INT NOT NULL,
    cantidadMin INT NOT NULL,
    cantidadMax INT NOT NULL,
    PRIMARY KEY (cvl_producto, cvl_insumo),
    FOREIGN KEY (cvl_producto)
        REFERENCES Producto (clave)
            ON UPDATE CASCADE
            ON DELETE CASCADE,
    FOREIGN KEY (cvl_insumo)
        REFERENCES Insumo (clave)
            ON UPDATE CASCADE
            ON DELETE CASCADE
) ENGINE=INNODB;




--
-- Parte izquiera del modelo entidad relación
--




CREATE TABLE Puesto (
    clave VARCHAR(10) NOT NULL UNIQUE,
    puesto VARCHAR(50) NOT NULL UNIQUE,
    nota TEXT CHARACTER SET utf8,
    PRIMARY KEY (clave)
) ENGINE=INNODB;




CREATE TABLE Empleado (
    clave VARCHAR(10) NOT NULL UNIQUE,
    cvl_puesto VARCHAR(10) NOT NULL,
    nombre VARCHAR(20) NOT NULL,
    aPaterno VARCHAR(20) NOT NULL,
    aMaterno VARCHAR(20) NOT NULL,
    fechaNac DATE NOT NULL,
    fechaReg DATE NOT NULL,
    PRIMARY KEY (clave),
    FOREIGN KEY (cvl_puesto)
        REFERENCES Puesto (clave)
            ON UPDATE CASCADE
            ON DELETE RESTRICT
) ENGINE=INNODB;




CREATE TABLE Rol (
    clave VARCHAR(10) NOT NULL UNIQUE,
    rol VARCHAR(20) NOT NULL UNIQUE,
    PRIMARY KEY (clave)
) ENGINE=INNODB;




CREATE TABLE Usuario (
    cvl_empleado VARCHAR(10) NOT NULL UNIQUE,
    cvl_rol VARCHAR(10) NOT NULL,
    contrasenia VARCHAR(255) NOT NULL,
    estado TINYINT NOT NULL,
    PRIMARY KEY (cvl_empleado),
    FOREIGN KEY (cvl_empleado) 
        REFERENCES Empleado (clave)
            ON UPDATE CASCADE
            ON DELETE RESTRICT,
    FOREIGN KEY (cvl_rol) 
        REFERENCES Rol (clave)
            ON UPDATE CASCADE
            ON DELETE RESTRICT
) ENGINE=INNODB;





CREATE TABLE Caja (
    clave VARCHAR(10) NOT NULL UNIQUE,
    caja VARCHAR(20) NOT NULL UNIQUE,
    estado TINYINT NOT NULL,
    PRIMARY KEY (clave)
) ENGINE=INNODB;


CREATE TABLE CajaApertura (
    clave VARCHAR(10) NOT NULL UNIQUE,
    cvl_caja VARCHAR(10) NOT NULL,
    cvl_cajero VARCHAR(10) NOT NULL,
    montoApertura FLOAT(5,2) NOT NULL,
    estado TINYINT NOT NULL,
    PRIMARY KEY (clave),
    FOREIGN KEY (cvl_caja)
        REFERENCES Caja (clave)
            ON UPDATE CASCADE
            ON DELETE RESTRICT,
    FOREIGN KEY (cvl_cajero)
        REFERENCES Usuario (cvl_empleado)
            ON UPDATE CASCADE
            ON DELETE RESTRICT
) ENGINE=INNODB;




--
-- Parte central del modelo entidad relación
--




CREATE TABLE Venta (
    clave VARCHAR(10) NOT NULL UNIQUE,
    cvl_caja VARCHAR(10) NOT NULL,
    fecha DATE NOT NULL,
    hora TIME NOT NULL,
    total FLOAT (6,2) NOT NULL,
    estado TINYINT NOT NULL,
    PRIMARY KEY (clave),
    FOREIGN KEY (cvl_caja)
        REFERENCES CajaApertura (clave)
            ON UPDATE CASCADE
            ON DELETE RESTRICT
) ENGINE=INNODB;


CREATE TABLE DetatalleVenta (
    cvl_venta VARCHAR(10) NOT NULL,
    cvl_producto VARCHAR(10) NOT NULL,
    cantidad INT NOT NULL,
    subtotal FLOAT(5,2) NOT NULL,
    PRIMARY KEY (cvl_venta, cvl_producto),
    FOREIGN KEY (cvl_venta)
        REFERENCES Venta (clave)
            ON UPDATE CASCADE
            ON DELETE RESTRICT,
    FOREIGN KEY (cvl_producto)
        REFERENCES Producto (clave)
            ON UPDATE CASCADE
            ON DELETE RESTRICT
) ENGINE=INNODB;


CREATE TABLE Mesa (
    clave VARCHAR(10) NOT NULL UNIQUE,
    mesa VARCHAR(20) NOT NULL UNIQUE,
    estado TINYINT NOT NULL,
    PRIMARY KEY (clave)
) ENGINE=INNODB;


CREATE TABLE MesaVenta (
    cvl_venta VARCHAR(10) NOT NULL,
    cvl_mesa VARCHAR(10) NOT NULL,
    PRIMARY KEY (cvl_venta, cvl_mesa),
    FOREIGN KEY (cvl_venta)
        REFERENCES Venta (clave)
            ON UPDATE CASCADE
            ON DELETE RESTRICT,
    FOREIGN KEY (cvl_mesa)
        REFERENCES Mesa (clave)
            ON UPDATE CASCADE
            ON DELETE RESTRICT
) ENGINE=INNODB;




--
-- Informacion inicial
--


INSERT INTO Puesto SET clave='DEFAULT', puesto='DEFAULT';

INSERT INTO Empleado SET clave='USER-ADMIN', cvl_puesto='DEFAULT', nombre='DEFAULT', aPaterno='DEFAULT', aMaterno='DEFAULT', fechaNac='0-0-0', fechaReg=CURDATE();

INSERT INTO `Rol` (`clave`, `rol`) VALUES ('J2hBnK2js4', 'ADMINISTRADOR'), ('6EgYd2tR4W', 'CAJERO'), ('FSe7Hsg5K2', 'ENCARGADO DE PISO');

INSERT INTO Usuario SET cvl_empleado='USER-ADMIN', cvl_rol='J2hBnK2js4', contrasenia=md5('123123'), estado=1;

INSERT INTO `Proveedor` (`clave`, `razonsocial`, `RFC`, `telefono`, `correo`, `nota`) VALUES ('12cs4dss2a', 'EL CANGREJO DORADO', 'AZXECD3821325', '222894488', 'cagrejo@dorado.com', NULL);

INSERT INTO `Unidad` (`clave`, `unidad`) VALUES ('wD7o4cBZUG', 'GRAMOS'), ('Na5htScacj', 'MILILITROS'), ('ppaeuSn19R', 'PIEZA'), ('QQgdr1kxQ4', 'BOLSA'), ('Ks182fRIEO', 'CAJA'), ('jeRSeaQxfL', 'LATA');

INSERT INTO `CategoriaInsumo` (`clave`, `categoria`) VALUES ('vuXZZ5JW0Y', 'VERDURAS'), ('4iWge3Mw5s', 'CARNES'), ('lcgYQsNm46', 'LICORES'), ('87T0wREmHi', 'CREMAS'), ('iMPf5ZMunl', 'LECHE'), ('U8TGXArtyg', 'PANES'), ('HIJtLbjpem', 'AGUA'), ('osbSe0YZU6', 'BEBIDAS');

INSERT INTO `AreaProduccion` (`clave`, `area`) VALUES ('mR2FmiVvQs', 'BARRA DE SERVICIO'), ('TYahU1CUGi', 'COCINA');