drop database inventario;
create database inventario;
use inventario;

-- TABLA DEPARTAMENTO
create table Departamento (
NOMBRE varchar(20) primary key,
JEFE varchar(50),
UBICACION varchar(5)
-- foreign key (JEFE) references Usuario(NOMBRE)
);

-- TABLA USUARIOS
create table Usuario (
DNI varchar(9) primary key,
NOMBRE varchar(50) not null,
APELLIDOS varchar(100) not null,
EMAIL varchar(50) not null,
CLAVE varchar(20) not null,
ROL varchar(2) not null,
VALIDAR varchar(2) not null,
DEPARTAMENTO varchar(20),
foreign key (DEPARTAMENTO) references Departamento(NOMBRE)
);

-- TABLA TAREAS
create table Tareas (
COD_TAREA varchar(10) primary key,
ESTADO varchar(50) not null,
NIVEL_TAREA varchar(50) not null,
COMENTARIO varchar(100) not null,
IMAGEN varchar(50) not null,
LOCALIZACION varchar(60) not null,
FECHA_INICIO date not null,
FECHA_FIN date not null,
COD_USUARIO_GESTION varchar(9),
COD_USUARIO_CREA varchar(9),
foreign key (COD_USUARIO_GESTION) references Usuario(DNI),
foreign key (COD_USUARIO_CREA) references Usuario(DNI)
);

-- TABLA ARTICULO
create table Articulo (
CODIGO varchar(10) primary key,
FECHA_ALTA date,
NUM_SERIE int(20),
NOMBRE varchar(50),
DESCRIPCION varchar(20),
UNIDADES int(5),
LOCALIZACION varchar(20),
PROCEDENCIA_ENTRADA varchar(200),
MOTIVO_BAJA varchar(200),
FECHA_BAJA date,
RUTA_IMAGEN varchar(200)
);

-- TABLA ARTICULO
create table Fungible (
CODIGO varchar(10) primary key,
PEDIR varchar(2),
foreign key (CODIGO) references Articulo(CODIGO)
);

-- TABLA ARTICULO
create table NoFungible (
CODIGO varchar(10) primary key,
FECHA int(4),
foreign key (CODIGO) references Articulo(CODIGO)
);

-- TABLA TIENE
create table Tiene (
COD_ARTICULO varchar(10),
COD_DEPARTAMENTO varchar(20),
primary key (COD_ARTICULO, COD_DEPARTAMENTO),
foreign key (COD_ARTICULO) references Articulo(CODIGO),
foreign key (COD_DEPARTAMENTO) references Departamento(NOMBRE)
);

CREATE TABLE Alumno(
    DNI_ALUMNO varchar(9) primary key,
    NOMBRE varchar(20) not null,
    APELLIDOS varchar(50) not null,
    GENERO varchar(20) not null,
    CORREO_ALUMNO varchar(100) not null,
    TELEFONO_ALUMNO varchar(11) not null,
    FECHA_NAC date not null,
    LUGAR_NAC varchar(40) not null,
    DOMICILIO_ALUMNO varchar(100), 
    CP_ALUMNO varchar(5) not null
);

CREATE TABLE Empresa(
    COD_CONVENIO varchar(30) primary key,
    TIPO varchar(7),
    RESPO_EMPRESA varchar(50),
    DNI_RESPONSABLE varchar(9),
    NOMBRE_EMPRESA varchar(150),
    LOCALIDAD_EMPRESA varchar(60),
    PROVINCIA_EMPRESA varchar(11),
    DIRECC_EMPRESA varchar(100),
    CP_EMPRESA varchar(5), 
    CIF_EMPRESA varchar(11),
    LOCALIDAD_FIRMA varchar(40),
    FECHA_FIRMA date
);

CREATE TABLE Mail_Empresas (
    COD_CONVENIO varchar(30),
    EMAIL varchar(100),
    Primary key(COD_CONVENIO, EMAIL),
    foreign key(COD_CONVENIO) references Empresa(COD_CONVENIO)
);

CREATE TABLE Ciclo_Empresas (
    COD_CONVENIO varchar(30),
    CICLO varchar(6),
    Primary key(COD_CONVENIO, CICLO),
    foreign key(COD_CONVENIO) references Empresa(COD_CONVENIO)
);

CREATE TABLE Telefono_Empresas (
    COD_CONVENIO varchar(30),
    TELEFONO varchar(9),
    Primary key(COD_CONVENIO, TELEFONO),
    foreign key(COD_CONVENIO) references Empresa(COD_CONVENIO)
); 

CREATE TABLE Pertenece(
    COD_CONVENIO varchar(30),
    COD_USUARIO varchar(9),
    DNI_ALUMNO varchar(9),
    F_INICIO_BECA date not null,
    F_FIN_BECA date not null,
    TUTOR_PRACTICAS varchar(40) not null,
    CICLO varchar(6) not null,
    ANEXO_I varchar(30),
    ANEXO_II varchar(30),
    ANEXO_IX varchar(30),
    ANEXO_XI varchar(30),
    ANEXO_IV varchar(30),
    ANEXO_V varchar(30),
    ANEXO_VI varchar(30),
    ANEXO_VII varchar(30),
    ANEXO_XII varchar(30),
    ANEXO_XV varchar(30),
    Primary key(COD_CONVENIO, COD_USUARIO, DNI_ALUMNO),
    foreign key(COD_CONVENIO) references Empresa(COD_CONVENIO),
    foreign key(COD_USUARIO) references Usuario(DNI),
    foreign key(DNI_ALUMNO) references Alumno(DNI_ALUMNO)
);

-- Valores de las tabla Usuarios
-- insert into Usuario(DNI,NOMBRE, APELLIDOS, EMAIL, CLAVE, DEPARTAMENTO, ROL, VALIDAR)
-- values('US01','nerea.doal@gmail.com','1234',10000,'Calle Nerea', '45593', 'España', 1);