CREATE DATABASE CONTABILIDAD;
USE CONTABILIDAD;
CREATE TABLE Cuentas
( NumCuenta integer,
 NombreCuenta varchar(50),
 Tipo char(1),
 PRIMARY KEY(NumCuenta),
 CHECK (Tipo IN ('A','P','C','I','G'))
);
CREATE TABLE Polizas
( NumPoliza integer,
 Fecha date,
 Descripcion varchar(100),
 PRIMARY KEY (NumPoliza)
);
CREATE TABLE DetallePoliza
( NumPoliza integer,
 NumCuenta integer,
 DebeHaber char(1),
 Valor Float,
 PRIMARY KEY (NumPoliza, NumCuenta),
 FOREIGN KEY (NumPoliza) REFERENCES Polizas,
 FOREIGN KEY (NumCuenta) REFERENCES Cuentas,
 CHECK (DebeHaber IN ('D','H'))
);
