/*
 Navicat Premium Data Transfer

 Source Server         : localhost_3336
 Source Server Type    : MySQL
 Source Server Version : 50553
 Source Host           : localhost:3336
 Source Schema         : lumen

 Target Server Type    : MySQL
 Target Server Version : 50553
 File Encoding         : 65001

 Date: 18/09/2020 16:58:58
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for lumen_department
-- ----------------------------
DROP TABLE IF EXISTS `lumen_department`;
CREATE TABLE `lumen_department`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `department` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '部门',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for lumen_menu
-- ----------------------------
DROP TABLE IF EXISTS `lumen_menu`;
CREATE TABLE `lumen_menu`  (
  `id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '名字',
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '路径',
  `status` tinyint(1) NULL DEFAULT NULL COMMENT '是否启用\r\n',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of lumen_menu
-- ----------------------------
INSERT INTO `lumen_menu` VALUES (1, '测试1', NULL, 1);

-- ----------------------------
-- Table structure for lumen_permission
-- ----------------------------
DROP TABLE IF EXISTS `lumen_permission`;
CREATE TABLE `lumen_permission`  (
  `id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for lumen_role
-- ----------------------------
DROP TABLE IF EXISTS `lumen_role`;
CREATE TABLE `lumen_role`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '角色名',
  `rules` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '对应权限',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of lumen_role
-- ----------------------------
INSERT INTO `lumen_role` VALUES (1, '系统管理', NULL);

-- ----------------------------
-- Table structure for lumen_role_user
-- ----------------------------
DROP TABLE IF EXISTS `lumen_role_user`;
CREATE TABLE `lumen_role_user`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NULL DEFAULT NULL COMMENT '角色id',
  `user_id` int(11) NULL DEFAULT NULL COMMENT '用户id',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of lumen_role_user
-- ----------------------------
INSERT INTO `lumen_role_user` VALUES (1, 2, 1);

-- ----------------------------
-- Table structure for lumen_user
-- ----------------------------
DROP TABLE IF EXISTS `lumen_user`;
CREATE TABLE `lumen_user`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '用户名',
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '密码',
  `user_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '用户昵称',
  `api_token` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT 'token',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of lumen_user
-- ----------------------------
INSERT INTO `lumen_user` VALUES (1, 'admin', '$2y$10$rj7wfTY67jM7U5IdrlMj5uVSYR8izff/m91jKOq4vAa4nlVKR.r1G', '系统管理员', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3Q6OTlcL2xvZ2luIiwiaWF0IjoxNjAwMzk5MjQyLCJleHAiOjE2MDA0ODU2NDIsIm5iZiI6MTYwMDM5OTI0MiwianRpIjoiNGJacXVNcWRWYVlLcUtqNiIsInN1YiI6MSwicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyJ9.ov1BVitAnscMeVTQo8PovSK6wD2sxXGqa6KFPJSoFC4');

SET FOREIGN_KEY_CHECKS = 1;
