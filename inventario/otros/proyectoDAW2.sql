DROP DATABASE IF EXISTS ProyectoDAW;
create database ProyectoDAW;
use ProyectoDAW;

-- TABLA DEPARTAMENTO
create table Departamento (
codigo smallint primary key auto_increment,
NOMBRE varchar(100)  not null,
JEFE varchar(50),
UBICACION varchar(5)
);

-- TABLA USUARIOS
create table Usuario (
COD_USUARIO integer primary key auto_increment,
DNI varchar(9) unique not null,
NOMBRE varchar(50) not null,
APELLIDOS varchar(100) not null,
EMAIL varchar(50) not null,
CLAVE varchar(20) not null,
ROL varchar(2) not null,
VALIDAR varchar(2) not null,
DEPARTAMENTO smallint,
foreign key (DEPARTAMENTO) references Departamento(codigo)
);

-- TABLA TAREAS
create table Tareas (
COD_TAREA integer primary key auto_increment,
ESTADO varchar(50) not null,
NIVEL_TAREA varchar(50) not null,
COMENTARIO varchar(255) not null,
IMAGEN varchar(50),
LOCALIZACION varchar(60) not null,
FECHA_INICIO date not null,
FECHA_FIN date,
COD_USUARIO_GESTION integer,
COD_USUARIO_CREA integer,
foreign key (COD_USUARIO_GESTION) references Usuario(COD_USUARIO),
foreign key (COD_USUARIO_CREA) references Usuario(COD_USUARIO)
);

-- TABLA ARTICULO
create table Articulo (
CODIGO integer primary key auto_increment,
FECHA_ALTA date not null,
NUM_SERIE int(20) not null,
NOMBRE varchar(50) not null,
DESCRIPCION varchar(255) not null,
UNIDADES int(5) not null,
LOCALIZACION varchar(20) not null,
PROCEDENCIA_ENTRADA varchar(200) not null,
MOTIVO_BAJA varchar(200),
FECHA_BAJA date,
RUTA_IMAGEN longblob
);

-- TABLA ARTICULO
create table Fungible (
CODIGO integer primary key,
PEDIR varchar(2),
foreign key (CODIGO) references Articulo(CODIGO)
);

-- TABLA ARTICULO
create table NoFungible (
CODIGO integer primary key,
FECHA int(4),
foreign key (CODIGO) references Articulo(CODIGO)
);

-- TABLA TIENE
create table Tiene (
COD_ARTICULO integer,
COD_DEPARTAMENTO smallint,
primary key (COD_ARTICULO, COD_DEPARTAMENTO),
foreign key (COD_ARTICULO) references Articulo(CODIGO),
foreign key (COD_DEPARTAMENTO) references Departamento(codigo)
);

-- TABLA ALUMNO
CREATE TABLE Alumno(
	COD_ALUMNO integer primary key auto_increment,
    DNI_ALUMNO varchar(9) not null unique,
    NOMBRE varchar(20) not null,
    APELLIDOS varchar(50) not null,
    GENERO varchar(20) not null,
    CORREO_ALUMNO varchar(100) not null,
    TELEFONO_ALUMNO varchar(11) not null,
    FECHA_NAC date not null,
    LUGAR_NAC varchar(40) not null,
	LOCALIDAD_ALUMNO varchar(100) not null, 
    PROVINCIA_ALUMNO varchar(100) not null, 
    DOMICILIO_ALUMNO varchar(100) not null, 
    CP_ALUMNO varchar(5) not null
);

-- TABLA EMPRESA
CREATE TABLE Empresa(
    COD_EMPRESA varchar(30) primary key,
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
    FECHA_FIRMA date,
    ANEXO_0 varchar(60),
	ANEXO_0A varchar(60),
    ANEXO_0B varchar(60),
    ANEXO_XVI varchar(60)

);

-- TABLA MAIL_EMPRESAS
CREATE TABLE Mail_Empresas (
    COD_EMPRESA varchar(30),
    EMAIL varchar(100),
    Primary key(COD_EMPRESA, EMAIL),
    foreign key(COD_EMPRESA) references Empresa(COD_EMPRESA)
);

-- TABLA CICLO_EMPRESAS
CREATE TABLE Ciclo_Empresas (
    COD_EMPRESA varchar(30),
    CICLO varchar(6),
    Primary key(COD_EMPRESA, CICLO),
    foreign key(COD_EMPRESA) references Empresa(COD_EMPRESA)
);

-- TABLA TELEFONO_EMPRESAS
CREATE TABLE Telefono_Empresas (
    COD_EMPRESA varchar(30),
    TELEFONO varchar(9),
    Primary key(COD_EMPRESA, TELEFONO),
    foreign key(COD_EMPRESA) references Empresa(COD_EMPRESA)
); 

-- TABLA PERTENECE
CREATE TABLE Pertenece(
    COD_EMPRESA varchar(30) not null,
    COD_USUARIO integer not null,
    COD_ALUMNO integer not null,
    F_INICIO_BECA date not null,
    F_FIN_BECA date not null,
    TUTOR_PRACTICAS varchar(40) not null,
    CICLO varchar(6) not null,
    ANEXO_I varchar(60),
    ANEXO_II varchar(60),
    ANEXO_IV varchar(60),
    ANEXO_V varchar(60),
    ANEXO_VI varchar(60),
    ANEXO_VIbis varchar(60),
    ANEXO_VII varchar(60),
    ANEXO_IX varchar(60),
    ANEXO_XI varchar(60),
    ANEXO_XII varchar(60),
    ANEXO_XV varchar(60),
    Primary key(COD_EMPRESA, COD_USUARIO, COD_ALUMNO),
    foreign key(COD_EMPRESA) references Empresa(COD_EMPRESA),
    foreign key(COD_USUARIO) references Usuario(COD_USUARIO),
    foreign key(COD_ALUMNO) references Alumno(COD_ALUMNO)
);

-- TABLA ANEXOIII_PERTENECE
CREATE TABLE AnexoIII_Pertenece (
    COD_EMPRESA varchar(30) not null,
    COD_USUARIO integer not null,
    COD_ALUMNO integer not null,
    ANEXO_III varchar(60),
    Primary key(COD_EMPRESA, COD_USUARIO, COD_ALUMNO),
    foreign key(COD_EMPRESA, COD_USUARIO, COD_ALUMNO) references Pertenece(COD_EMPRESA, COD_USUARIO, COD_ALUMNO)
);

-- Valores de las tabla Usuarios
insert into Usuario(DNI,NOMBRE, APELLIDOS, EMAIL, CLAVE, ROL, VALIDAR)
values('11111111A', 'administrador', 'administrador', 'incidencias@iesbargas.com','AppIncidencias',0,'si');

-- Valores de las tabla Departamentos
insert into Departamento(NOMBRE, JEFE, UBICACION)
values('DPTO Francés', 'x', 'xxx');

insert into Departamento(NOMBRE, JEFE, UBICACION)
values('DPTO Inglés', 'x', 'xxx');

insert into Departamento(NOMBRE, JEFE, UBICACION)
values('DPTO Tecnología', 'x', 'xxx');

insert into Departamento(NOMBRE, JEFE, UBICACION)
values('DPTO Religión', 'x', 'xxx');

insert into Departamento(NOMBRE, JEFE, UBICACION)
values('DPTO Matemáticas', 'x', 'xxx');

insert into Departamento(NOMBRE, JEFE, UBICACION)
values('DPTO Educación Física', 'x', 'xxx');

insert into Departamento(NOMBRE, JEFE, UBICACION)
values('DPTO Dibujo', 'x', 'xxx');

insert into Departamento(NOMBRE, JEFE, UBICACION)
values('DPTO Informática', 'x', 'xxx');

insert into Departamento(NOMBRE, JEFE, UBICACION)
values('DPTO Lengua', 'x', 'xxx');

insert into Departamento(NOMBRE, JEFE, UBICACION)
values('DPTO Filosofía', 'x', 'xxx');

insert into Departamento(NOMBRE, JEFE, UBICACION)
values('DPTO Geografía e Historia', 'x', 'xxx');

insert into Departamento(NOMBRE, JEFE, UBICACION)
values('DPTO Orientación', 'x', 'xxx');

insert into Departamento(NOMBRE, JEFE, UBICACION)
values('DPTO Física y Química', 'x', 'xxx');

insert into Departamento(NOMBRE, JEFE, UBICACION)
values('DPTO Música', 'x', 'xxx');

insert into Departamento(NOMBRE, JEFE, UBICACION)
values('DPTO Biología y Geología', 'x', 'xxx');

insert into Departamento(NOMBRE, JEFE, UBICACION)
values('DPTO Griego', 'x', 'xxx');

insert into Departamento(NOMBRE, JEFE, UBICACION)
values('DPTO Economía', 'x', 'xxx');