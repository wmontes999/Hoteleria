/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50717
Source Host           : localhost:3306
Source Database       : dbhotel

Target Server Type    : MYSQL
Target Server Version : 50717
File Encoding         : 65001

Date: 2021-11-23 19:13:11
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `tbl_acomodacion`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_acomodacion`;
CREATE TABLE `tbl_acomodacion` (
`Id_Acomod`  int(11) NOT NULL ,
`Nombre`  varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
PRIMARY KEY (`Id_Acomod`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci

;

-- ----------------------------
-- Records of tbl_acomodacion
-- ----------------------------
BEGIN;
INSERT INTO tbl_acomodacion VALUES ('1', 'SENCILLA'), ('2', 'DOBLE'), ('3', 'TRIPLE'), ('4', 'CUADRUPLE');
COMMIT;

-- ----------------------------
-- Table structure for `tbl_habitacion`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_habitacion`;
CREATE TABLE `tbl_habitacion` (
`Id_Habitacion`  int(11) NOT NULL ,
`Id_Hotel`  int(11) NULL DEFAULT NULL ,
`Cantidad`  int(11) NULL DEFAULT NULL ,
`Id_Mov_Acom`  int(11) NULL DEFAULT NULL ,
PRIMARY KEY (`Id_Habitacion`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci

;

-- ----------------------------
-- Records of tbl_habitacion
-- ----------------------------
BEGIN;
INSERT INTO tbl_habitacion VALUES ('1', '1', '25', '1');
COMMIT;

-- ----------------------------
-- Table structure for `tbl_hoteles`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_hoteles`;
CREATE TABLE `tbl_hoteles` (
`Id_Hotel`  int(11) NOT NULL ,
`Nombre`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`Direccion`  text CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`Ciudad`  varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`NIT`  varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`NumHab`  varchar(4) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
PRIMARY KEY (`Id_Hotel`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci

;

-- ----------------------------
-- Records of tbl_hoteles
-- ----------------------------
BEGIN;
INSERT INTO tbl_hoteles VALUES ('1', 'DECAMERON CARTAGENA', 'CALLE 23 58', 'CARTAGENA', '12345678-9', '42');
COMMIT;

-- ----------------------------
-- Table structure for `tbl_movacom`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_movacom`;
CREATE TABLE `tbl_movacom` (
`Id_Mov_Acom`  int(11) NOT NULL ,
`Id_TipHab`  int(11) NOT NULL ,
`Id_Acomod`  int(11) NOT NULL ,
PRIMARY KEY (`Id_Mov_Acom`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci

;

-- ----------------------------
-- Records of tbl_movacom
-- ----------------------------
BEGIN;
INSERT INTO tbl_movacom VALUES ('1', '1', '1'), ('2', '1', '2'), ('3', '2', '3'), ('4', '2', '4'), ('5', '3', '1'), ('6', '3', '2'), ('7', '3', '3');
COMMIT;

-- ----------------------------
-- Table structure for `tbl_tiphab`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_tiphab`;
CREATE TABLE `tbl_tiphab` (
`Id_TipHab`  int(11) NOT NULL ,
`Nombre`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
PRIMARY KEY (`Id_TipHab`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci

;

-- ----------------------------
-- Records of tbl_tiphab
-- ----------------------------
BEGIN;
INSERT INTO tbl_tiphab VALUES ('1', 'ESTANDAR'), ('2', 'JUNIOR'), ('3', 'SUITE');
COMMIT;

-- ----------------------------
-- Table structure for `tbl_usuarios`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_usuarios`;
CREATE TABLE `tbl_usuarios` (
`dni`  varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`nombre`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`usuario`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`usur`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`clav`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`Tipo`  varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`email`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
PRIMARY KEY (`usur`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci

;

-- ----------------------------
-- Records of tbl_usuarios
-- ----------------------------
BEGIN;
INSERT INTO tbl_usuarios VALUES ('123456', 'Administrador', '111111', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'Administrador', 'w@gmail.com');
COMMIT;
