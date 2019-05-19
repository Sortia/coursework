/*
 Navicat Premium Data Transfer

 Source Server         : msql
 Source Server Type    : MySQL
 Source Server Version : 100313
 Source Host           : localhost:3306
 Source Schema         : coursework

 Target Server Type    : MySQL
 Target Server Version : 100313
 File Encoding         : 65001

 Date: 19/05/2019 10:03:40
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for employees
-- ----------------------------
DROP TABLE IF EXISTS `employees`;
CREATE TABLE `employees`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fio` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `birthday` date NULL DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `phone` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `position` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `salary` decimal(10, 2) NULL DEFAULT NULL,
  `experience` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `work_start_date` date NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of employees
-- ----------------------------
INSERT INTO `employees` VALUES (3, 'Иванов Иван Иванович', '1990-01-17', 'г. Луганск, ул. Советская, д. 40, кв. 33', '09968747254', 'Директор', 30000.00, '20', '2018-12-01');
INSERT INTO `employees` VALUES (4, 'Петров Петр Петрович', '1990-01-17', 'г. Луганск, ул. Советская, д. 40, кв. 33', '09968747255', 'Зам. директора', 25000.00, '18', '2018-12-01');
INSERT INTO `employees` VALUES (5, 'Сидоренко Николай Петрович', '1990-01-17', 'г. Луганск, ул. Советская, д. 40, кв. 33', '09968747259', 'Менеджер', 20000.00, '15', '2018-12-01');

-- ----------------------------
-- Table structure for relax
-- ----------------------------
DROP TABLE IF EXISTS `relax`;
CREATE TABLE `relax`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `relax_with` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `relax_by` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `relax_type` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `employee_id` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of relax
-- ----------------------------
INSERT INTO `relax` VALUES (4, '2019-05-10', '2019-05-16', 'vacExp', 3);

SET FOREIGN_KEY_CHECKS = 1;
