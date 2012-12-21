-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 21-12-2012 a las 23:41:17
-- Versión del servidor: 5.5.23
-- Versión de PHP: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `about_me`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `application`
--

CREATE TABLE IF NOT EXISTS `application` (
  `app_code` int(11) NOT NULL AUTO_INCREMENT,
  `app_slogan` varchar(100) DEFAULT NULL COMMENT 'Representa el slogan de la empresa o compania',
  `app_slogan_e` varchar(100) DEFAULT NULL COMMENT 'Representa el slogan de la empresa o compania en ingles',
  `app_information_office` text COMMENT 'representa la informacion general de la empresa, como la direccion de las oficinas, telefonos, emails',
  `app_information_office_e` text COMMENT 'representa la informacion general de la empresa, como la direccion de las oficinas, telefonos, emails. (en ingles)',
  `app_text_footer` varchar(200) DEFAULT NULL COMMENT 'representa el texto que aparece como footer de la aplicacion, generalmente es un copyright',
  `app_text_footer_e` varchar(200) DEFAULT NULL,
  `app_google_maps` text COMMENT 'representa el codigo que se obtiene de google maps para mostrar la ubicacion de nuestra empresa.',
  `app_background` varchar(45) DEFAULT NULL,
  `app_background_e` varchar(45) DEFAULT NULL,
  `app_background_type` enum('1','2','3') DEFAULT NULL COMMENT 'representa el tipo de fondo que tiene la aplicación:\n1. default\n2. image\n3. color',
  `app_background_color` varchar(7) DEFAULT NULL,
  `app_keywords` varchar(160) DEFAULT NULL COMMENT 'Representa las palabras claves que van a ser usadas en el meta del sitio',
  `app_keywords_e` varchar(160) DEFAULT NULL COMMENT 'Representa las palabras claves que van a ser usadas en el meta del sitio',
  PRIMARY KEY (`app_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Tabla responsable de manejar la configuracion del sitio' AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `application`
--

INSERT INTO `application` (`app_code`, `app_slogan`, `app_slogan_e`, `app_information_office`, `app_information_office_e`, `app_text_footer`, `app_text_footer_e`, `app_google_maps`, `app_background`, `app_background_e`, `app_background_type`, `app_background_color`, `app_keywords`, `app_keywords_e`) VALUES
(1, 'Su celular en manos expertas...', 'His phone in expert hands', 'Calle 10 No. 12N-06\nTel/Fax: (57) 748 14 01\nArmenia - Quindio - Colombia\nEmail email@gmail.co oiajsd', 'Street 10 No. 12N-06\nTel/Fax: (57) 748 14 01\nArmenia - Quindio - Colombia\nEmail email@gmail.co', '©2012 miempresa.com | todos los derechos reservados', '©2012 micompany.com | all rights reserved', NULL, '13508414541003351201.jpg', '13496564671622352213.jpg', '2', '#4278ff', 'celulares, dispositivos moviles, soluciones celulares, telefonia, apertura bandas, servicio tecnico celular, tecnico celulares, accesorios celulares', 'phones, mobile devices, mobile solutions, telephony, opening bands, mobile technical service, technician phones, cellular accessories');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `app_link`
--

CREATE TABLE IF NOT EXISTS `app_link` (
  `link_code` int(11) NOT NULL AUTO_INCREMENT,
  `link_name` varchar(45) DEFAULT NULL COMMENT 'representa el nombre del sitio o aplicacion a la cual se va a hacer el enlace',
  `link_url` varchar(150) DEFAULT NULL COMMENT 'representa la url a la que se va a enlazar',
  `link_image_rename` varchar(45) DEFAULT NULL COMMENT 'representa la imagen representativa del enlace.',
  `link_status` enum('1','2','3') DEFAULT NULL COMMENT 'representa el estado del link:\n1. activo\n2. inactivo\n3. eliminado',
  PRIMARY KEY (`link_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='esta tabla representa los enlaces que tiene la aplicacion a otros sitios, ej: redes socialees' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `app_menu`
--

CREATE TABLE IF NOT EXISTS `app_menu` (
  `menu_code` int(11) NOT NULL AUTO_INCREMENT,
  `menu_value` varchar(45) DEFAULT NULL COMMENT 'representa el nombre de menu que se muestra en la app',
  `menu_value_e` varchar(45) DEFAULT NULL COMMENT 'representa el nombre de menu que se muestra en la app (en ingles)',
  `menu_order` int(11) DEFAULT NULL COMMENT 'representa el orden en el que se muestra el menu.',
  `menu_status` enum('1','2','3') DEFAULT NULL COMMENT 'representa el estado del menu:\n1. activo\n2. inactivo\n3. proximamente',
  `menu_link` varchar(45) DEFAULT NULL COMMENT 'representa el link que se muestra en la url',
  `menu_link_e` varchar(45) DEFAULT NULL COMMENT 'representa el link que se muestra en la url en inglés',
  PRIMARY KEY (`menu_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='representa los items de menu que contiene la aplicacion' AUTO_INCREMENT=9 ;

--
-- Volcado de datos para la tabla `app_menu`
--

INSERT INTO `app_menu` (`menu_code`, `menu_value`, `menu_value_e`, `menu_order`, `menu_status`, `menu_link`, `menu_link_e`) VALUES
(1, 'Inicio', 'Home', 1, '1', 'inicio', 'home'),
(2, 'Nosotros', 'Us', 2, '1', 'nosotros', 'us'),
(3, 'Servicios', 'Services', 3, '1', 'servicios', 'services'),
(4, 'Personal', 'Personal', 4, '2', '#', '#'),
(5, 'Galerías', 'Galleries', 5, '1', 'galerias', 'galleries'),
(6, 'Videos', 'Videos', 6, '1', 'videos', 'videos'),
(7, 'Contáctenos', 'Contact Us', 7, '1', 'contactenos', 'contact_us'),
(8, 'FAQ', 'FAQ', 8, '1', 'faq', 'faq');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `attachment`
--

CREATE TABLE IF NOT EXISTS `attachment` (
  `attach_code` int(11) NOT NULL AUTO_INCREMENT,
  `email_code` int(11) NOT NULL,
  `attach_name` varchar(100) DEFAULT NULL,
  `attach_rename` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`attach_code`),
  KEY `fk_attachment_mail1` (`email_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `charge`
--

CREATE TABLE IF NOT EXISTS `charge` (
  `chg_code` int(11) NOT NULL AUTO_INCREMENT,
  `chg_name` varchar(45) NOT NULL COMMENT 'representa en nombre del cargo.',
  `chg_name_e` varchar(45) DEFAULT NULL COMMENT 'representa el nombre del cargo (inglés)',
  `chg_status` enum('1','2','3') NOT NULL COMMENT 'estado del cargo:\n1. activo\n2. inactivo\n3. eliminado',
  `chg_order` int(11) NOT NULL COMMENT 'campo par ordenar los cargos',
  PRIMARY KEY (`chg_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Esta tabla representa los diferentes cargos con los que posee la organización' AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `charge`
--

INSERT INTO `charge` (`chg_code`, `chg_name`, `chg_name_e`, `chg_status`, `chg_order`) VALUES
(1, 'Presidencia es', 'presidence en', '1', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `charge_person`
--

CREATE TABLE IF NOT EXISTS `charge_person` (
  `chgpers_id` int(11) NOT NULL AUTO_INCREMENT,
  `chg_code` int(11) NOT NULL,
  `pers_code` int(11) NOT NULL,
  PRIMARY KEY (`chgpers_id`),
  KEY `fk_charge_person_charge1` (`chg_code`),
  KEY `fk_charge_person_person1` (`pers_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='representa la relación del cargo que tiene una persona en la organización.' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contact`
--

CREATE TABLE IF NOT EXISTS `contact` (
  `contact_code` int(11) NOT NULL AUTO_INCREMENT,
  `contact_name` varchar(50) NOT NULL COMMENT 'nombre de quien hace el contacto',
  `contact_email` varchar(50) DEFAULT NULL COMMENT 'email de quien hace el contacto',
  `contact_phone` varchar(25) DEFAULT NULL COMMENT 'telefono(s) de quien hace el contacto',
  `contact_text` text NOT NULL COMMENT 'pregunta o inquietud',
  `contact_date_create` datetime NOT NULL COMMENT 'fecha de creacion del contacto.',
  `contact_status` enum('1','2','3','4') NOT NULL COMMENT 'estado del contacto:\n1. sin responder\n2. respuesto\n3. ignorado\n4. eliminado',
  `use_code` int(11) DEFAULT NULL COMMENT 'usuario que responde al contacto',
  `contact_answer` text COMMENT 'respuesta que se le da a quien hizo el contacto.',
  `contact_date_answer` datetime DEFAULT NULL COMMENT 'fecha en la que fue respuesto o cambiado el estado para el contactenos',
  `contact_city` varchar(50) DEFAULT NULL COMMENT 'representa el pais, estado y/o ciudad desde donde se hace el contacto.',
  PRIMARY KEY (`contact_code`),
  KEY `fk_contact_user1` (`use_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='tabla para almacenar la informacion de contacto que ingresan los usuarios de la aplicacion.' AUTO_INCREMENT=12 ;

--
-- Volcado de datos para la tabla `contact`
--

INSERT INTO `contact` (`contact_code`, `contact_name`, `contact_email`, `contact_phone`, `contact_text`, `contact_date_create`, `contact_status`, `use_code`, `contact_answer`, `contact_date_answer`, `contact_city`) VALUES
(1, 'jhoan sebastian lara puentes', 'jhoansebastianlara@gmail.com', '312 774 8821 - 748 18 72', 'hola esto es un contactenos de prueba, hola esto es un contactenos de prueba, hola esto es un contactenos de prueba, hola esto es un contactenos de prueba, hola esto es un contactenos de prueba, hola esto es un contactenos de prueba, hola esto es un contactenos de prueba, hola esto es un contactenos de prueba, hola esto es un contactenos de prueba, hola esto es un contactenos de prueba, hola esto es un contactenos de prueba, hola esto es un contactenos de prueba, hola esto es un contactenos de prueba,', '2012-09-02 19:04:12', '2', 7, 'bueno jhoan', '2012-09-24 10:44:35', NULL),
(2, 'jeni lara', 'jeni@hotmail.com', '311 332 00 00', 'hola esto es una inquietud que tengo, hola esto es una inquietud que tengo, hola esto es una inquietud que tengo, hola esto es una inquietud que tengo, hola esto es una inquietud que tengo, hola esto es una inquietud que tengo, hola esto es una inquietud que tengo, hola esto es una inquietud que tengo, hola esto es una inquietud que tengo, hola esto es una inquietud que tengo,', '2012-09-02 19:29:34', '3', 7, '', '2012-09-24 11:13:31', NULL),
(3, 'daniela', 'daniela@gmail.com', '344 544 00 45', 'hola esto es una inquietud que tengo, hola esto es una inquietud que tengo, hola esto es una inquietud que tengo, hola esto es una inquietud que tengo, hola esto es una inquietud que tengo, hola esto es una inquietud que tengo, hola esto es una inquietud que tengo, hola esto es una inquietud que tengo, hola esto es una inquietud que tengo, hola esto es una inquietud que tengo, hola esto es una inquietud que tengo, hola esto es una inquietud que tengo, hola esto es una inquietud que tengo, hola esto es una inquietud que tengo, hola esto es una inquietud que tengo,', '2012-09-03 19:30:20', '2', 7, 'ok daniela', '2012-09-24 10:38:24', NULL),
(4, 'ana isabel', 'ana@hotmail.com', '112 014 24 11', 'hello this is a support test, hello this is a support test, hello this is a support test, hello this is a support test, hello this is a support test, hello this is a support test, hello this is a support test, hello this is a support test,', '2012-09-02 19:36:29', '4', 7, '', '2012-09-24 11:13:48', NULL),
(5, 'andrea', 'andrea@gmail.com', '312 774 88 21', 'hola esta es una prueba de soporte desde el footer', '2012-09-02 22:03:36', '2', 7, 'ok andrea', '2012-09-24 10:43:35', NULL),
(6, 'Rubiela Puentes', 'rpuetes@gmail.com', '748 12 45', 'esto es una prueba de soporte, esto es una prueba de soporte, esto es una prueba de soporte, esto es una prueba de soporte, esto es una prueba de soporte,', '2012-09-02 22:07:34', '4', 7, '', '2012-09-24 11:20:20', NULL),
(7, 'andrea gonzales', 'andreagonzales@uniquindio.edu.co', '312 444 87 21', 'prueba de soporte # 2', '2012-09-02 22:10:52', '2', 7, 'ihoih', '2012-10-21 12:59:41', NULL),
(8, 'david', 'david@gmail.com', '312 444 56 85', 'pregunta de prueba', '2012-09-02 22:32:16', '2', 7, 'it´s true david', '2012-09-24 10:40:09', NULL),
(9, 'sebas', 'ss@gmail.om', '121212', 'preh', '2012-09-03 14:22:05', '2', 7, 'ok ss', '2012-09-24 10:39:50', NULL),
(10, 'juan carlos morales', 'carlosmorales64@hotmail.com', '312 221 88 21 / 748 12 75', 'Hola queria saber cuanto costaba el servicio de reparacion completa y tambien que medios de pago tienen y cuanto se demora. cualquier inquietud visiten mi blog: www.blog.com.\r\n\r\ngracias ! espero pronta respuesta.', '2012-09-20 10:56:39', '2', 7, 'bueno juanete', '2012-09-24 10:36:20', NULL),
(11, 'alejo', 'alt@h.com', '7777', 'kgiuggugfyui biughi bvhiuuiy', '2012-11-11 10:05:52', '2', 7, 'lkniiu ibibib ui ui  ui   yvbuy ohoi i', '2012-11-11 10:06:18', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `content`
--

CREATE TABLE IF NOT EXISTS `content` (
  `cont_code` int(11) NOT NULL AUTO_INCREMENT,
  `cont_name` varchar(45) NOT NULL COMMENT 'nombre del contenido en español.',
  `cont_text` text NOT NULL COMMENT 'contenido en español.',
  `cont_date_create` datetime NOT NULL COMMENT 'fecha de creación del contenido.',
  `cont_status` enum('1','2','3') NOT NULL COMMENT 'estado del contenido:\n1. activo\n2. inactivo\n3. eliminado',
  `cont_name_e` varchar(45) DEFAULT NULL COMMENT 'nombre del contenido en ingles.',
  `cont_text_e` text COMMENT 'contenido en inglés.',
  `cont_order` int(11) DEFAULT NULL COMMENT 'campo para ordenar la aparicion de los contenidos en la aplicacion',
  PRIMARY KEY (`cont_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='tabla para manejar los contenidos de la aplicación.' AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `content`
--

INSERT INTO `content` (`cont_code`, `cont_name`, `cont_text`, `cont_date_create`, `cont_status`, `cont_name_e`, `cont_text_e`, `cont_order`) VALUES
(1, 'Nuestra trayectoria', '<p style="text-align: justify;"><span style="font-family: arial, helvetica, sans-serif; font-size: small;">Somos una empresa de Topograf&iacute;a, dirigida al desarrollos de proyectos de construcci&oacute;n, asesorar&iacute;a, reparaci&oacute;n, calibraci&oacute;n y mantenimiento de equipos y venta de toda clase de equipos de topograf&iacute;a generando desarrollo y progreso a Colombia y Sur America.</span></p>\r\n<p style="text-align: justify;"><span style="font-family: arial, helvetica, sans-serif; font-size: small;">Somos una empresa de Topograf&iacute;a, dirigida al desarrollos de proyectos de construcci&oacute;n, asesorar&iacute;a, reparaci&oacute;n, calibraci&oacute;n y mantenimiento de equipos y venta de toda clase de equipos de topograf&iacute;a generando desarrollo y progreso a Colombia y Sur America.</span></p>\r\n<p style="text-align: justify;"><span style="font-family: arial, helvetica, sans-serif; font-size: small;">Somos una empresa de Topograf&iacute;a, dirigida al desarrollos de proyectos de construcci&oacute;n, asesorar&iacute;a, reparaci&oacute;n, calibraci&oacute;n y mantenimiento de equipos y venta de toda clase de equipos de topograf&iacute;a generando desarrollo y progreso a Colombia y Sur America.</span></p>\r\n<p style="text-align: justify;"><span style="font-family: arial, helvetica, sans-serif; font-size: small;">Somos una empresa de Topograf&iacute;a, dirigida al desarrollos de proyectos de construcci&oacute;n, asesorar&iacute;a, reparaci&oacute;n, calibraci&oacute;n y mantenimiento de equipos y venta de toda clase de equipos de topograf&iacute;a generando desarrollo y progreso a Colombia y Sur America.</span></p>\r\n<p style="text-align: justify;"><span style="font-family: arial, helvetica, sans-serif; font-size: small;">Somos una empresa de Topograf&iacute;a, dirigida al desarrollos de proyectos de construcci&oacute;n, asesorar&iacute;a, reparaci&oacute;n, calibraci&oacute;n y mantenimiento de equipos y venta de toda clase de equipos de topograf&iacute;a generando desarrollo y progreso a Colombia y Sur America.</span></p>\r\n<p style="text-align: justify;"><span style="font-family: arial, helvetica, sans-serif; font-size: small;">Somos una empresa de Topograf&iacute;a, dirigida al desarrollos de proyectos de construcci&oacute;n, asesorar&iacute;a, reparaci&oacute;n, calibraci&oacute;n y mantenimiento de equipos y venta de toda clase de equipos de topograf&iacute;a generando desarrollo y progreso a Colombia y Sur America.</span></p>\r\n<p style="text-align: justify;"><span style="font-family: arial, helvetica, sans-serif; font-size: small;">Somos una empresa de Topograf&iacute;a, dirigida al desarrollos de proyectos de construcci&oacute;n, asesorar&iacute;a, reparaci&oacute;n, calibraci&oacute;n y mantenimiento de equipos y venta de toda clase de equipos de topograf&iacute;a generando desarrollo y progreso a Colombia y Sur America.</span></p>\r\n<p style="text-align: justify;"><span style="font-family: arial, helvetica, sans-serif; font-size: small;">Somos una empresa de Topograf&iacute;a, dirigida al desarrollos de proyectos de construcci&oacute;n, asesorar&iacute;a, reparaci&oacute;n, calibraci&oacute;n y mantenimiento de equipos y venta de toda clase de equipos de topograf&iacute;a generando desarrollo y progreso a Colombia y Sur America.</span></p>', '2012-08-16 15:14:13', '2', 'Our Trajectory', '<p><span>Somos una empresa de Topograf&iacute;a, dirigida al desarrollos de proyectos de construcci&oacute;n, asesorar&iacute;a, reparaci&oacute;n, calibraci&oacute;n y mantenimiento de equipos y venta de toda clase de equipos de topograf&iacute;a generando desarrollo y progreso a Colombia y Sur America.</span></p>\r\n<p><span>Somos una empresa de Topograf&iacute;a, dirigida al desarrollos de proyectos de construcci&oacute;n, asesorar&iacute;a, reparaci&oacute;n, calibraci&oacute;n y mantenimiento de equipos y venta de toda clase de equipos de topograf&iacute;a generando desarrollo y progreso a Colombia y Sur America.</span></p>\r\n<p><span>Somos una empresa de Topograf&iacute;a, dirigida al desarrollos de proyectos de construcci&oacute;n, asesorar&iacute;a, reparaci&oacute;n, calibraci&oacute;n y mantenimiento de equipos y venta de toda clase de equipos de topograf&iacute;a generando desarrollo y progreso a Colombia y Sur America.</span></p>\r\n<p><span>Somos una empresa de Topograf&iacute;a, dirigida al desarrollos de proyectos de construcci&oacute;n, asesorar&iacute;a, reparaci&oacute;n, calibraci&oacute;n y mantenimiento de equipos y venta de toda clase de equipos de topograf&iacute;a generando desarrollo y progreso a Colombia y Sur America.</span></p>\r\n<p><span>Somos una empresa de Topograf&iacute;a, dirigida al desarrollos de proyectos de construcci&oacute;n, asesorar&iacute;a, reparaci&oacute;n, calibraci&oacute;n y mantenimiento de equipos y venta de toda clase de equipos de topograf&iacute;a generando desarrollo y progreso a Colombia y Sur America.</span></p>\r\n<p><span>Somos una empresa de Topograf&iacute;a, dirigida al desarrollos de proyectos de construcci&oacute;n, asesorar&iacute;a, reparaci&oacute;n, calibraci&oacute;n y mantenimiento de equipos y venta de toda clase de equipos de topograf&iacute;a generando desarrollo y progreso a Colombia y Sur America.</span></p>\r\n<p><span>Somos una empresa de Topograf&iacute;a, dirigida al desarrollos de proyectos de construcci&oacute;n, asesorar&iacute;a, reparaci&oacute;n, calibraci&oacute;n y mantenimiento de equipos y venta de toda clase de equipos de topograf&iacute;a generando desarrollo y progreso a Colombia y Sur America.</span></p>\r\n<p><span>Somos una empresa de Topograf&iacute;a, dirigida al desarrollos de proyectos de construcci&oacute;n, asesorar&iacute;a, reparaci&oacute;n, calibraci&oacute;n y mantenimiento de equipos y venta de toda clase de equipos de topograf&iacute;a generando desarrollo y progreso a Colombia y Sur America.</span></p>', 2),
(2, 'Quienes Somos', '<p style="text-align: justify;"><span style="font-family: arial, helvetica, sans-serif; font-size: small;">Somos&nbsp;una empresa de &aacute;mbito nacional con gran experiencia en el desarrollo de proyectos especializados en todo tipo de trabajos de topograf&iacute;a, dirigidos a la construcci&oacute;n. Creciendo y evolucionando en el desarrollo de actividades encaminadas al campo de obras civiles. Adem&aacute;s cuenta con servicio de laboratorio &oacute;ptico-mec&aacute;nico y electr&oacute;nico para la calibraci&oacute;n, mantenimiento y reparaci&oacute;n de equipos de topograf&iacute;a y venta de equipos.</span></p>\r\n<p style="text-align: justify;"><span style="font-family: arial, helvetica, sans-serif; font-size: small;">Somos&nbsp;una empresa de &aacute;mbito nacional con gran experiencia en el desarrollo de proyectos especializados en todo tipo de trabajos de topograf&iacute;a, dirigidos a la construcci&oacute;n. Creciendo y evolucionando en el desarrollo de actividades encaminadas al campo de obras civiles. Adem&aacute;s cuenta con servicio de laboratorio &oacute;ptico-mec&aacute;nico y electr&oacute;nico para la calibraci&oacute;n, mantenimiento y reparaci&oacute;n de equipos de topograf&iacute;a y venta de equipos.</span></p>\r\n<p style="text-align: justify;"><span style="font-family: arial, helvetica, sans-serif; font-size: small;">Somos&nbsp;una empresa de &aacute;mbito nacional con gran experiencia en el desarrollo de proyectos especializados en todo tipo de trabajos de topograf&iacute;a, dirigidos a la construcci&oacute;n. Creciendo y evolucionando en el desarrollo de actividades encaminadas al campo de obras civiles. Adem&aacute;s cuenta con servicio de laboratorio &oacute;ptico-mec&aacute;nico y electr&oacute;nico para la calibraci&oacute;n, mantenimiento y reparaci&oacute;n de equipos de topograf&iacute;a y venta de equipos.</span></p>\r\n<p style="text-align: justify;"><span style="font-family: arial, helvetica, sans-serif; font-size: small;">Somos&nbsp;una empresa de &aacute;mbito nacional con gran experiencia en el desarrollo de proyectos especializados en todo tipo de trabajos de topograf&iacute;a, dirigidos a la construcci&oacute;n. Creciendo y evolucionando en el desarrollo de actividades encaminadas al campo de obras civiles. Adem&aacute;s cuenta con servicio de laboratorio &oacute;ptico-mec&aacute;nico y electr&oacute;nico para la calibraci&oacute;n, mantenimiento y reparaci&oacute;n de equipos de topograf&iacute;a y venta de equipos.</span></p>\r\n<p style="text-align: justify;"><span style="font-family: arial, helvetica, sans-serif; font-size: small;">Somos&nbsp;una empresa de &aacute;mbito nacional con gran experiencia en el desarrollo de proyectos especializados en todo tipo de trabajos de topograf&iacute;a, dirigidos a la construcci&oacute;n. Creciendo y evolucionando en el desarrollo de actividades encaminadas al campo de obras civiles. Adem&aacute;s cuenta con servicio de laboratorio &oacute;ptico-mec&aacute;nico y electr&oacute;nico para la calibraci&oacute;n, mantenimiento y reparaci&oacute;n de equipos de topograf&iacute;a y venta de equipos.</span></p>\r\n<p style="text-align: justify;"><span style="font-family: arial, helvetica, sans-serif; font-size: small;">Somos&nbsp;una empresa de &aacute;mbito nacional con gran experiencia en el desarrollo de proyectos especializados en todo tipo de trabajos de topograf&iacute;a, dirigidos a la construcci&oacute;n. Creciendo y evolucionando en el desarrollo de actividades encaminadas al campo de obras civiles. Adem&aacute;s cuenta con servicio de laboratorio &oacute;ptico-mec&aacute;nico y electr&oacute;nico para la calibraci&oacute;n, mantenimiento y reparaci&oacute;n de equipos de topograf&iacute;a y venta de equipos.</span></p>', '2012-08-16 15:54:57', '1', 'About us', '<p style="text-align: justify;"><span style="font-family: arial, helvetica, sans-serif; font-size: small;">We are a national company with extensive experience in developing specialized projects in all types of survey work, led to the construction. Grow and evolve in the development of activities for the field of civil works. It also has optical-service laboratory for mechanical and electronic calibration, maintenance and repair of surveying equipment and equipment sales.</span></p>\r\n<p style="text-align: justify;"><span style="font-family: arial, helvetica, sans-serif; font-size: small;">We are a national company with extensive experience in developing specialized projects in all types of survey work, led to the construction. Grow and evolve in the development of activities for the field of civil works. It also has optical-service laboratory for mechanical and electronic calibration, maintenance and repair of surveying equipment and equipment sales.</span></p>\r\n<p style="text-align: justify;"><span style="font-family: arial, helvetica, sans-serif; font-size: small;">We are a national company with extensive experience in developing specialized projects in all types of survey work, led to the construction. Grow and evolve in the development of activities for the field of civil works. It also has optical-service laboratory for mechanical and electronic calibration, maintenance and repair of surveying equipment and equipment sales.</span></p>\r\n<p style="text-align: justify;"><span style="font-family: arial, helvetica, sans-serif; font-size: small;">We are a national company with extensive experience in developing specialized projects in all types of survey work, led to the construction. Grow and evolve in the development of activities for the field of civil works. It also has optical-service laboratory for mechanical and electronic calibration, maintenance and repair of surveying equipment and equipment sales.</span></p>\r\n<p style="text-align: justify;"><span style="font-family: arial, helvetica, sans-serif; font-size: small;">We are a national company with extensive experience in developing specialized projects in all types of survey work, led to the construction. Grow and evolve in the development of activities for the field of civil works. It also has optical-service laboratory for mechanical and electronic calibration, maintenance and repair of surveying equipment and equipment sales.</span></p>\r\n<p style="text-align: justify;"><span style="font-family: arial, helvetica, sans-serif; font-size: small;">We are a national company with extensive experience in developing specialized projects in all types of survey work, led to the construction. Grow and evolve in the development of activities for the field of civil works. It also has optical-service laboratory for mechanical and electronic calibration, maintenance and repair of surveying equipment and equipment sales.</span></p>', 1),
(3, 'Nuestra empresa.', '<p style="text-align: justify;"><span style="color: #000080;"><strong>contenido ..<span style="font-family: arial, helvetica, sans-serif;">.</span></strong></span></p>', '2012-09-04 17:18:48', '1', 'Our Company.', '<p>...</p>', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `faq`
--

CREATE TABLE IF NOT EXISTS `faq` (
  `faq_code` int(11) NOT NULL AUTO_INCREMENT,
  `faq_query` varchar(200) DEFAULT NULL COMMENT 'pregunta frecuente',
  `faq_answer` text COMMENT 'respuesta a la pregunta frecuente',
  `faq_query_e` varchar(200) DEFAULT NULL COMMENT 'pregunta frecuente (ingles)',
  `faq_answer_e` text COMMENT 'respuesta a la pregunta frecuente (ingles)',
  `faq_status` enum('1','2','3') DEFAULT NULL COMMENT 'estado del faq:\n1. activo\n2. inactivo\n3. eliminado',
  `faq_order` int(11) DEFAULT NULL COMMENT 'campo para ordenar los faqs',
  PRIMARY KEY (`faq_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='En esta tabla se almacena la informacion de las preguntas y respuestas mas frecuentes para la entidad' AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `faq`
--

INSERT INTO `faq` (`faq_code`, `faq_query`, `faq_answer`, `faq_query_e`, `faq_answer_e`, `faq_status`, `faq_order`) VALUES
(1, '¿Cuanto cuesta el servicio de reparación completo?', 'El precio de este servicio varía según el tipo de cliente que seas y que tipo de reparación necesitas, primero necesitas ser valorado.', 'How much does the full repair service?', 'The price for this service varies depending on the type of customer you are and what kind of repair you need, you first need to be assessed.', '1', 4),
(2, '¿Qué proceso debo de seguir para iniciar un tratamiento?', 'para iniciar un tratamiento debes ...', 'What process should I follow to start treatment?', 'to start treatment you ...', '3', 2),
(3, '¿que garantia tienen por los productos?', 'la garantia que damos por nuestros productos es...', 'What is the warranty for the products?', 'the guarantee that we take for our products is ...', '1', 3),
(4, '¿que garantia tienen por los productos?', '...', 'What is the warranty for the products?', '...', '1', 5),
(5, '¿Con cuales certificados de calidad cuentan?', '...', '¿Con cuales certificados de calidad cuentan? e', '......', '1', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gallery`
--

CREATE TABLE IF NOT EXISTS `gallery` (
  `gall_code` int(11) NOT NULL AUTO_INCREMENT,
  `use_code` int(11) NOT NULL,
  `img_code` int(11) DEFAULT NULL COMMENT 'representa la imagen portada de la galería',
  `gall_name` varchar(45) NOT NULL COMMENT 'nombre de la galería en español.',
  `gall_description` text COMMENT 'descripción de la categoría en español.',
  `gall_date_create` datetime NOT NULL COMMENT 'fecha de creación de la galería.',
  `gall_status` enum('1','2','3') NOT NULL COMMENT 'estado de la galería:\n1. activo\n2. inactivo\n3. eliminado',
  `gall_name_e` varchar(45) DEFAULT NULL COMMENT 'nombre de la galería en inglés.',
  `gall_description_e` text COMMENT 'descripción de la galería en inglés.',
  `gall_order` int(11) DEFAULT NULL COMMENT 'campo para ordenar las galerías.',
  PRIMARY KEY (`gall_code`),
  KEY `fk_gallery_user1` (`use_code`),
  KEY `fk_gallery_image1` (`img_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='tabla para almacenar la información de las galerías de la aplicación.' AUTO_INCREMENT=17 ;

--
-- Volcado de datos para la tabla `gallery`
--

INSERT INTO `gallery` (`gall_code`, `use_code`, `img_code`, `gall_name`, `gall_description`, `gall_date_create`, `gall_status`, `gall_name_e`, `gall_description_e`, `gall_order`) VALUES
(14, 7, 28, 'Nuestras instalaciones ok esto es una prueba', 'Nuestras instalaciones ok esto es una prueba Nuestras instalaciones ok esto es una prueba Nuestras instalaciones ok esto es una prueba Nuestras instalaciones ok esto es una prueba Nuestras instalaciones ok esto es una prueba', '2012-09-10 12:27:29', '1', 'Our facilities ok', '', 1),
(15, 7, 23, 'Pacientes', 'p', '2012-09-10 12:29:42', '1', 'Patients', 'p e', 2),
(16, 7, 25, 'm', 'mm', '2012-09-10 12:32:08', '1', 'n', 'nn', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `image`
--

CREATE TABLE IF NOT EXISTS `image` (
  `img_code` int(11) NOT NULL,
  `gall_code` int(11) NOT NULL,
  `use_code` int(11) NOT NULL,
  `img_rename` varchar(100) NOT NULL COMMENT 'renombre ded la imagen con el que fué guardada en la app.',
  `img_date_create` datetime NOT NULL,
  `img_original_name` varchar(100) DEFAULT NULL COMMENT 'nombre de la imagen.',
  `img_width` int(11) DEFAULT NULL COMMENT 'ancho de la imagen.',
  `img_high` int(11) DEFAULT NULL COMMENT 'alto de la imagen.',
  `img_name` varchar(45) DEFAULT NULL,
  `img_name_e` varchar(45) DEFAULT NULL,
  `img_description` text,
  `img_description_e` text,
  PRIMARY KEY (`img_code`),
  KEY `fk_table1_gallery1` (`gall_code`),
  KEY `fk_image_user1` (`use_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='tabla para almacenar la información de las imagenes de la galería.';

--
-- Volcado de datos para la tabla `image`
--

INSERT INTO `image` (`img_code`, `gall_code`, `use_code`, `img_rename`, `img_date_create`, `img_original_name`, `img_width`, `img_high`, `img_name`, `img_name_e`, `img_description`, `img_description_e`) VALUES
(21, 14, 7, '1347298022207093908.jpg', '2012-09-10 12:27:30', '', 870, 522, '', '', '', ''),
(23, 15, 7, '1347298163326114394.jpg', '2012-09-10 12:29:42', '', 870, 522, '', '', '', ''),
(24, 15, 7, '1347298094689273034.jpg', '2012-09-10 12:29:43', '', 870, 522, '', '', '', ''),
(25, 16, 7, '1347298305985983416.jpg', '2012-09-10 12:32:08', '', 870, 522, '', '', '', ''),
(26, 14, 7, '13472989262051509096.jpg', '2012-09-10 12:42:21', '', 870, 522, '', '', '', ''),
(27, 14, 7, '1347299033417724871.jpg', '2012-09-10 12:43:59', '', 870, 522, '', '', '', ''),
(28, 14, 7, '13472999681833402775.jpg', '2012-09-10 12:59:35', '', 870, 522, '', '', '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mail`
--

CREATE TABLE IF NOT EXISTS `mail` (
  `email_code` int(11) NOT NULL AUTO_INCREMENT,
  `use_code` int(11) NOT NULL,
  `email_subject` varchar(100) NOT NULL COMMENT 'asunto del correo electronico',
  `email_to` varchar(100) NOT NULL COMMENT 'direccion de correo electronico a quien se envia',
  `email_content` text NOT NULL COMMENT 'cuerpo del correo',
  `email_date_create` datetime NOT NULL COMMENT 'fecha de envio del correo',
  PRIMARY KEY (`email_code`),
  KEY `fk_mail_user1` (`use_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `person`
--

CREATE TABLE IF NOT EXISTS `person` (
  `pers_code` int(11) NOT NULL AUTO_INCREMENT,
  `pers_name` varchar(45) NOT NULL,
  `pers_lastname` varchar(45) DEFAULT NULL,
  `pers_profesional_objetive` text COMMENT 'descripción de la experiencia y los objetivos profesionales de la persona.',
  `pers_photo_original` varchar(45) DEFAULT NULL COMMENT 'representa el nombre original de la imagen que se carga a para la persona.',
  `pers_photo_rename` varchar(45) DEFAULT NULL COMMENT 'representa el nombre que el sistema le da a la imagen que se carga a para la persona.',
  `pers_status` enum('1','2','3') NOT NULL COMMENT 'Estado de la personal:\n1. activo\n2. inactivo\n3. eliminado',
  `pers_order` int(11) DEFAULT NULL COMMENT 'campo para ordenar las personas.',
  PRIMARY KEY (`pers_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='representa el personal de la organización' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `service`
--

CREATE TABLE IF NOT EXISTS `service` (
  `serv_code` int(11) NOT NULL AUTO_INCREMENT,
  `sertype_code` int(11) NOT NULL COMMENT 'tipo de servicio.',
  `use_code` int(11) NOT NULL,
  `serv_name` varchar(45) NOT NULL COMMENT 'nombre del servicio en español.',
  `serv_summary` text NOT NULL COMMENT 'pequeño resumen del servicio en español.',
  `serv_description` text NOT NULL COMMENT 'descripcion del servicio en español.',
  `serv_image` varchar(100) DEFAULT NULL COMMENT 'imagen del servicio en español.',
  `serv_status` enum('1','2','3') NOT NULL COMMENT 'estado del servicio:\n1. activo\n2. inactivo\n3. eliminado',
  `serv_date_create` datetime NOT NULL COMMENT 'fecha de creación.',
  `serv_name_e` varchar(45) DEFAULT NULL COMMENT 'nombre del servicio en inglés.',
  `serv_summary_e` text COMMENT 'pequeño resumen del servicio en inglés.',
  `serv_description_e` text COMMENT 'descripción del servicio en inglés.',
  `serv_image_e` varchar(100) DEFAULT NULL COMMENT 'imagen del servicio en español.',
  `serv_order` int(11) DEFAULT NULL COMMENT 'representa el campo para ordenar los servicios.',
  `serv_highlight` tinyint(4) DEFAULT NULL COMMENT 'representa si el servicio está o no destacado.\n1. destacado\n0. no destacado',
  PRIMARY KEY (`serv_code`),
  KEY `fk_service_service_type1` (`sertype_code`),
  KEY `fk_service_user1` (`use_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Volcado de datos para la tabla `service`
--

INSERT INTO `service` (`serv_code`, `sertype_code`, `use_code`, `serv_name`, `serv_summary`, `serv_description`, `serv_image`, `serv_status`, `serv_date_create`, `serv_name_e`, `serv_summary_e`, `serv_description_e`, `serv_image_e`, `serv_order`, `serv_highlight`) VALUES
(1, 2, 7, 'Levantamientos', 'este es un resumen de prueba para el este es un resumen de prueba para el servicio # 1 este es un resumen de prueba para el servicio # 1 este es un resumen de prueba para el servicio # 1 servicio # 1 ok2', '<p><strong>esta es una descripcion de prueba para el servicio # 1</strong> esta es una descripcion de prueba para el servicio # 1 esta es una descripcion de prueba para el servicio # 1 esta es una descripcion de prueba para el servicio # 1 esta es una descripcion de prueba para el servicio # 1 esta es una descripcion de prueba para el servicio # 1 esta es una descripcion de prueba para el servicio # 1 esta es una descripcion de prueba para el servicio # 1 esta es una descripcion de prueba para el servicio # 1 esta es una descripcion de prueba para el servicio # 1 esta es una descripcion de prueba para el servicio # 1 esta es una descripcion de prueba para el servicio # 1 esta es una descripcion de prueba para el servicio # 1 esta es una descripcion de prueba para el servicio # 1 esta es una descripcion de prueba para el servicio # 1 esta es una descripcion de prueba para el servicio # 1 esta es una descripcion de prueba para el servicio # 1 esta es una descripcion de prueba para el servicio # 1 esta es una descripcion de prueba para el servicio # 1 esta es una descripcion de prueba para el servicio # 1 esta es una descripcion de prueba para el servicio # 1 esta es una descripcion de prueba para el servicio # 1 esta es una descripcion de prueba para el servicio # 1 esta es una descripcion de prueba para el servicio # 1 esta es una descripcion de prueba para el servicio # 1 esta es una descripcion de prueba para el servicio # 1 esta es una descripcion de prueba para el servicio # 1 esta es una descripcion de prueba para el servicio # 1 esta es una descripcion de prueba para el servicio # 1 esta es una descripcion de prueba para el servicio # 1 esta es una descripcion de prueba para el servicio # 1 esta es una descripcion de prueba para el servicio # 1 esta es una descripcion de prueba para el servicio # 1 esta es una descripcion de prueba para el servicio # 1 esta es una descripcion de prueba para el servicio # 1 esta es una descripcion de prueba para el servicio # 1 esta es una descripcion de prueba para el servicio # 1 esta es una descripcion de prueba para el servicio # 1 esta es una descripcion de prueba para el servicio # 1 esta es una descripcion de prueba para el servicio # 1 esta es una descripcion de prueba para el servicio # 1 esta es una descripcion de prueba para el servicio # 1 esta es una descripcion de prueba para el servicio # 1 esta es una descripcion de prueba para el servicio # 1 esta es una descripcion de prueba para el servicio # 1 esta es una descripcion de prueba para el servicio # 1 esta es una descripcion de prueba para el servicio # 1 esta es una descripcion de prueba para el servicio # 1 esta es una descripcion de prueba para el servicio # 1 esta es una descripcion de prueba para el servicio # 1 esta es una descripcion de prueba para el servicio # 1 esta es una descripcion de prueba para el servicio # 1 esta es una descripcion de prueba para el servicio # 1 esta es una descripcion de prueba para el servicio # 1 esta es una descripcion de prueba para el servicio # 1 esta es una descripcion de prueba para el servicio # 1 esta es una descripcion de prueba para el servicio # 1 esta es una descripcion de prueba para el servicio # 1 esta es una descripcion de prueba para el servicio # 1 esta es una descripcion de prueba para el servicio # 1 ok3</p>', '13508829021596950075.jpg', '1', '2012-08-25 14:52:23', 'Levantamientos', 'this es a test summary for the service # 1 this es a test summary for the service # 1 this es a test summary for the service # 1 this es a test summary for the service # 1 ok5', '<p><strong>this es a test description for the service # 1</strong>&nbsp; this es a test description for the service # 1&nbsp; this es a test description for the service # 1&nbsp; this es a test description for the service # 1&nbsp; this es a test description for the service # 1&nbsp; this es a test description for the service # 1&nbsp; this es a test description for the service # 1&nbsp; this es a test description for the service # 1&nbsp; this es a test description for the service # 1&nbsp; this es a test description for the service # 1&nbsp; this es a test description for the service # 1&nbsp; this es a test description for the service # 1&nbsp; this es a test description for the service # 1&nbsp; this es a test description for the service # 1&nbsp; this es a test description for the service # 1&nbsp; this es a test description for the service # 1&nbsp; this es a test description for the service # 1&nbsp; this es a test description for the service # 1&nbsp; this es a test description for the service # 1&nbsp; this es a test description for the service # 1&nbsp; this es a test description for the service # 1&nbsp; this es a test description for the service # 1&nbsp; this es a test description for the service # 1&nbsp; this es a test description for the service # 1&nbsp; this es a test description for the service # 1&nbsp; this es a test description for the service # 1&nbsp; this es a test description for the service # 1&nbsp; this es a test description for the service # 1&nbsp; this es a test description for the service # 1&nbsp; this es a test description for the service # 1&nbsp; this es a test description for the service # 1&nbsp; this es a test description for the service # 1&nbsp; this es a test description for the service # 1&nbsp; this es a test description for the service # 1&nbsp; this es a test description for the service # 1&nbsp; this es a test description for the service # 1&nbsp; this es a test description for the service # 1&nbsp; this es a test description for the service # 1&nbsp; this es a test description for the service # 1&nbsp; this es a test description for the service # 1&nbsp; this es a test description for the service # 1&nbsp; this es a test description for the service # 1&nbsp; this es a test description for the service # 1&nbsp; this es a test description for the service # 1&nbsp; this es a test description for the service # 1&nbsp; this es a test description for the service # 1&nbsp; this es a test description for the service # 1&nbsp; this es a test description for the service # 1&nbsp; this es a test description for the service # 1&nbsp; this es a test description for the service # 1&nbsp; this es a test description for the service # 1&nbsp; this es a test description for the service # 1&nbsp; this es a test description for the service # 1&nbsp; this es a test description for the service # 1&nbsp; this es a test description for the service # 1&nbsp; this es a test description for the service # 1&nbsp; this es a test description for the service # 1&nbsp; this es a test description for the service # 1&nbsp; this es a test description for the service # 1&nbsp; this es a test description for the service # 1&nbsp; this es a test description for the service # 1&nbsp; this es a test description for the service # 1&nbsp; this es a test description for the service # 1&nbsp; this es a test description for the service # 1&nbsp; this es a test description for the service # 1&nbsp; this es a test description for the service # 1&nbsp; this es a test description for the service # 1&nbsp; ok6</p>', '13508829021596950075.jpg', 2, 0),
(2, 2, 7, 'Reparacion de equipos celulares', 'Tenemos los mejores profesionales en el Tenemos los mejores profesionales en el campo, danos la oportunidad de atenderte Tenemos los mejores profesionales en el campo, danos la oportunidad de atenderte Tenemos los mejores profesionales en el campo, danos la oportunidad de atenderte Tenemos los mejores profesionales en el campo, danos la oportunidad de atenderte campo, danos la oportunidad de atenderte', '<p>Tenemos los mejores profesionales en el campo, danos la oportunidad de atenderte&nbsp;Tenemos los mejores profesionales en el campo, danos la oportunidad de atenderte&nbsp;Tenemos los mejores profesionales en el campo, danos la oportunidad de atenderte&nbsp;Tenemos los mejores profesionales en el campo, danos la oportunidad de atenderte&nbsp;Tenemos los mejores profesionales en el campo, danos la oportunidad de atenderte&nbsp;Tenemos los mejores profesionales en el campo, danos la oportunidad de atenderte&nbsp;Tenemos los mejores profesionales en el campo, danos la oportunidad de atenderte&nbsp;Tenemos los mejores profesionales en el campo, danos la oportunidad de atenderte&nbsp;Tenemos los mejores profesionales en el campo, danos la oportunidad de atenderte&nbsp;Tenemos los mejores profesionales en el campo, danos la oportunidad de atenderte&nbsp;Tenemos los mejores profesionales en el campo, danos la oportunidad de atenderte&nbsp;Tenemos los mejores profesionales en el campo, danos la oportunidad de atenderte&nbsp;Tenemos los mejores profesionales en el campo, danos la oportunidad de atenderte&nbsp;Tenemos los mejores profesionales en el campo, danos la oportunidad de atenderte&nbsp;Tenemos los mejores profesionales en el campo, danos la oportunidad de atenderte&nbsp;Tenemos los mejores profesionales en el campo, danos la oportunidad de atenderte&nbsp;Tenemos los mejores profesionales en el campo, danos la oportunidad de atenderte&nbsp;Tenemos los mejores profesionales en el campo, danos la oportunidad de atenderte&nbsp;Tenemos los mejores profesionales en el campo, danos la oportunidad de atenderte&nbsp;Tenemos los mejores profesionales en el campo, danos la oportunidad de atenderte&nbsp;Tenemos los mejores profesionales en el campo, danos la oportunidad de atenderte&nbsp;Tenemos los mejores profesionales en el campo, danos la oportunidad de atenderte&nbsp;Tenemos los mejores profesionales en el campo, danos la oportunidad de atenderte&nbsp;Tenemos los mejores profesionales en el campo, danos la oportunidad de atenderte&nbsp;</p>', '1350882723403641588.jpg', '1', '2012-08-26 14:06:01', 'Carreteras', 'we are the best in the professional makeup we are the best in the professional makeup we are the best in the professional makeup we are the best in the professional makeup we are the best in the professional makeup we are the best in the professional makeup', '<p>we are the best in the professional makeup&nbsp;we are the best in the professional makeup&nbsp;we are the best in the professional makeup&nbsp;we are the best in the professional makeup&nbsp;we are the best in the professional makeup&nbsp;we are the best in the professional makeup&nbsp;we are the best in the professional makeup&nbsp;we are the best in the professional makeup&nbsp;we are the best in the professional makeup&nbsp;we are the best in the professional makeup&nbsp;we are the best in the professional makeup&nbsp;we are the best in the professional makeup&nbsp;we are the best in the professional makeup&nbsp;we are the best in the professional makeup&nbsp;we are the best in the professional makeup&nbsp;we are the best in the professional makeup&nbsp;we are the best in the professional makeup&nbsp;we are the best in the professional makeup&nbsp;we are the best in the professional makeup&nbsp;we are the best in the professional makeup&nbsp;we are the best in the professional makeup&nbsp;we are the best in the professional makeup&nbsp;we are the best in the professional makeup&nbsp;we are the best in the professional makeup&nbsp;we are the best in the professional makeup&nbsp;we are the best in the professional makeup&nbsp;we are the best in the professional makeup&nbsp;we are the best in the professional makeup&nbsp;we are the best in the professional makeup&nbsp;we are the best in the professional makeup&nbsp;</p>', '1350882723403641588.jpg', 0, 1),
(3, 2, 7, 'Estudios de hundimientos', 'Mediante trabajos de nivelación se pueden conocer los hundimientos que sufre cierta superficie, este tipo de trabajos permiten observar la magnitud de los hundimientos y así mismo las posibles soluciones que pueden llevar acabo sobre estos. Mediante trabajos de nivelación se pueden conocer los hundimientos que sufre cierta superficie, este tipo de trabajos permiten observar la magnitud de los hundimientos y así mismo las posibles soluciones que pueden llevar acabo sobre estos.', '<p style="text-align: justify;"><span style="font-family: arial, helvetica, sans-serif; font-size: small;">Mediante trabajos de nivelaci&oacute;n se pueden conocer los hundimientos que sufre cierta superficie, este tipo de trabajos permiten observar la magnitud de los hundimientos y as&iacute; mismo las posibles soluciones que pueden llevar acabo sobre estos.&nbsp;Mediante trabajos de nivelaci&oacute;n se pueden conocer los hundimientos que sufre cierta superficie, este tipo de trabajos permiten observar la magnitud de los hundimientos y as&iacute; mismo las posibles soluciones que pueden llevar acabo sobre estos.&nbsp;Mediante trabajos de nivelaci&oacute;n se pueden conocer los hundimientos que sufre cierta superficie, este tipo de trabajos permiten observar la magnitud de los hundimientos y as&iacute; mismo las posibles soluciones que pueden llevar acabo sobre estos.&nbsp;Mediante trabajos de nivelaci&oacute;n se pueden conocer los hundimientos que sufre cierta superficie, este tipo de trabajos permiten observar la magnitud de los hundimientos y as&iacute; mismo las posibles soluciones que pueden llevar acabo sobre estos.&nbsp;Mediante trabajos de nivelaci&oacute;n se pueden conocer los hundimientos que sufre cierta superficie, este tipo de trabajos permiten observar la magnitud de los hundimientos y as&iacute; mismo las posibles soluciones que pueden llevar acabo sobre estos.&nbsp;</span></p>', '1346794089486228189.jpg', '1', '2012-08-26 14:09:26', 'Estudio de hundimientos', 'Mediante trabajos de nivelación se pueden conocer los hundimientos que sufre cierta superficie, este tipo de trabajos permiten observar la magnitud de los hundimientos y así mismo las posibles soluciones que pueden llevar acabo sobre estos. Mediante trabajos de nivelación se pueden conocer los hundimientos que sufre cierta superficie, este tipo de trabajos permiten observar la magnitud de los hundimientos y así mismo las posibles soluciones que pueden llevar acabo sobre estos. Mediante trabajos de nivelación se pueden conocer los hundimientos que sufre cierta superficie, este tipo de trabajos permiten observar la magnitud de los hundimientos y así mismo las posibles soluciones que pueden llevar acabo sobre estos.', '<p style="text-align: justify;"><span style="font-family: arial, helvetica, sans-serif; font-size: small;">Mediante trabajos de nivelaci&oacute;n se pueden conocer los hundimientos que sufre cierta superficie, este tipo de trabajos permiten observar la magnitud de los hundimientos y as&iacute; mismo las posibles soluciones que pueden llevar acabo sobre estos.&nbsp;Mediante trabajos de nivelaci&oacute;n se pueden conocer los hundimientos que sufre cierta superficie, este tipo de trabajos permiten observar la magnitud de los hundimientos y as&iacute; mismo las posibles soluciones que pueden llevar acabo sobre estos.&nbsp;Mediante trabajos de nivelaci&oacute;n se pueden conocer los hundimientos que sufre cierta superficie, este tipo de trabajos permiten observar la magnitud de los hundimientos y as&iacute; mismo las posibles soluciones que pueden llevar acabo sobre estos.&nbsp;Mediante trabajos de nivelaci&oacute;n se pueden conocer los hundimientos que sufre cierta superficie, este tipo de trabajos permiten observar la magnitud de los hundimientos y as&iacute; mismo las posibles soluciones que pueden llevar acabo sobre estos.&nbsp;Mediante trabajos de nivelaci&oacute;n se pueden conocer los hundimientos que sufre cierta superficie, este tipo de trabajos permiten observar la magnitud de los hundimientos y as&iacute; mismo las posibles soluciones que pueden llevar acabo sobre estos.&nbsp;Mediante trabajos de nivelaci&oacute;n se pueden conocer los hundimientos que sufre cierta superficie, este tipo de trabajos permiten observar la magnitud de los hundimientos y as&iacute; mismo las posibles soluciones que pueden llevar acabo sobre estos.&nbsp;</span></p>', '1346794089486228189.jpg', 3, 1),
(4, 2, 7, 'Peritajes', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque</p>', '13508827941755156829.jpg', '1', '2012-08-26 16:42:26', 'Peritajes', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque</p>', '13508827941755156829.jpg', 1, 0),
(5, 2, 7, 'Alquiler de equipos', 'servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5', '<p>servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5 servicio de prueba # 5</p>', '13508829591195281263.jpg', '1', '2012-08-26 20:03:55', 'Alquiler de equipos', 'Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5', '<p>Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5 Service test # 5</p>', '13508829591195281263.jpg', 5, 0),
(6, 5, 7, 'Trazo', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet', '<p style=text-align: justify;>&nbsp; <span style=font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-size: 13px; text-align: justify; background-color: rgba(255, 255, 255, 0.496094);>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet&nbsp;</span> &nbsp;&nbsp;<span style=font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-size: 13px; text-align: justify; background-color: rgba(255, 255, 255, 0.496094);>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet&nbsp;</span> &nbsp;&nbsp;<span style=font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-size: 13px; text-align: justify; background-color: rgba(255, 255, 255, 0.496094);>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet&nbsp;</span> &nbsp;&nbsp;<span style=font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-size: 13px; text-align: justify; background-color: rgba(255, 255, 255, 0.496094);>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet&nbsp;</span> &nbsp;&nbsp;<span style=font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-size: 13px; text-align: justify; background-color: rgba(255, 255, 255, 0.496094);>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet&nbsp;</span> &nbsp;&nbsp;<span style=font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-size: 13px; text-align: justify; background-color: rgba(255, 255, 255, 0.496094);>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet&nbsp;</span> &nbsp;&nbsp;<span style=font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-size: 13px; text-align: justify; background-color: rgba(255, 255, 255, 0.496094);>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet&nbsp;</span> &nbsp;&nbsp;<span style=font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-size: 13px; text-align: justify; background-color: rgba(255, 255, 255, 0.496094);>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet&nbsp;</span> &nbsp;&nbsp;<span style=font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-size: 13px; text-align: justify; background-color: rgba(255, 255, 255, 0.496094);>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet&nbsp;</span>&nbsp;&nbsp;<span style=font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-size: 13px; text-align: justify; background-color: rgba(255, 255, 255, 0.496094);>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet&nbsp;</span> &nbsp;&nbsp;<span style=font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-size: 13px; text-align: justify; background-color: rgba(255, 255, 255, 0.496094);>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet&nbsp;</span> &nbsp;&nbsp;<span style=font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-size: 13px; text-align: justify; background-color: rgba(255, 255, 255, 0.496094);>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet&nbsp;</span> &nbsp;&nbsp;<span style=font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-size: 13px; text-align: justify; background-color: rgba(255, 255, 255, 0.496094);>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet&nbsp;</span> &nbsp;&nbsp;<span style=font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-size: 13px; text-align: justify; background-color: rgba(255, 255, 255, 0.496094);>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet&nbsp;</span> &nbsp;&nbsp;<span style=font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-size: 13px; text-align: justify; background-color: rgba(255, 255, 255, 0.496094);>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet&nbsp;</span> &nbsp;&nbsp;<span style=font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-size: 13px; text-align: justify; background-color: rgba(255, 255, 255, 0.496094);>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet&nbsp;</span> &nbsp;&nbsp;<span style=font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-size: 13px; text-align: justify; background-color: rgba(255, 255, 255, 0.496094);>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet&nbsp;</span> &nbsp;&nbsp;<span style=font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-size: 13px; text-align: justify; background-color: rgba(255, 255, 255, 0.496094);>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet&nbsp;</span>&nbsp;&nbsp;<span style=font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-size: 13px; text-align: justify; background-color: rgba(255, 255, 255, 0.496094);>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet&nbsp;</span></p>', '13508830411689024319.jpg', '1', '2012-08-30 09:27:10', 'trazo', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet   Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet', '<p style=text-align: justify;>&nbsp; &nbsp;&nbsp;<span style=font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-size: 13px; text-align: justify; background-color: rgba(255, 255, 255, 0.496094);>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet&nbsp;</span> &nbsp;&nbsp;<span style=font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-size: 13px; text-align: justify; background-color: rgba(255, 255, 255, 0.496094);>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet&nbsp;</span> &nbsp;&nbsp;<span style=font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-size: 13px; text-align: justify; background-color: rgba(255, 255, 255, 0.496094);>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet&nbsp;</span> &nbsp;&nbsp;<span style=font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-size: 13px; text-align: justify; background-color: rgba(255, 255, 255, 0.496094);>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet&nbsp;</span> &nbsp;&nbsp;<span style=font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-size: 13px; text-align: justify; background-color: rgba(255, 255, 255, 0.496094);>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet&nbsp;</span> &nbsp;&nbsp;<span style=font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-size: 13px; text-align: justify; background-color: rgba(255, 255, 255, 0.496094);>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet&nbsp;</span> &nbsp;&nbsp;<span style=font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-size: 13px; text-align: justify; background-color: rgba(255, 255, 255, 0.496094);>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet&nbsp;</span> &nbsp;&nbsp;<span style=font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-size: 13px; text-align: justify; background-color: rgba(255, 255, 255, 0.496094);>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet&nbsp;</span> &nbsp;&nbsp;<span style=font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-size: 13px; text-align: justify; background-color: rgba(255, 255, 255, 0.496094);>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet&nbsp;</span>&nbsp;&nbsp;<span style=font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-size: 13px; text-align: justify; background-color: rgba(255, 255, 255, 0.496094);>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet&nbsp;</span> &nbsp;&nbsp;<span style=font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-size: 13px; text-align: justify; background-color: rgba(255, 255, 255, 0.496094);>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet&nbsp;</span> &nbsp;&nbsp;<span style=font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-size: 13px; text-align: justify; background-color: rgba(255, 255, 255, 0.496094);>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet&nbsp;</span> &nbsp;&nbsp;<span style=font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-size: 13px; text-align: justify; background-color: rgba(255, 255, 255, 0.496094);>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet&nbsp;</span> &nbsp;&nbsp;<span style=font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-size: 13px; text-align: justify; background-color: rgba(255, 255, 255, 0.496094);>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet&nbsp;</span> &nbsp;&nbsp;<span style=font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-size: 13px; text-align: justify; background-color: rgba(255, 255, 255, 0.496094);>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet&nbsp;</span> &nbsp;&nbsp;<span style=font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-size: 13px; text-align: justify; background-color: rgba(255, 255, 255, 0.496094);>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet&nbsp;</span> &nbsp;&nbsp;<span style=font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-size: 13px; text-align: justify; background-color: rgba(255, 255, 255, 0.496094);>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet&nbsp;</span> &nbsp;&nbsp;<span style=font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-size: 13px; text-align: justify; background-color: rgba(255, 255, 255, 0.496094);>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet&nbsp;</span>&nbsp;&nbsp;<span style=font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-size: 13px; text-align: justify; background-color: rgba(255, 255, 255, 0.496094);>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet&nbsp;</span> &nbsp;&nbsp;<span style=font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-size: 13px; text-align: justify; background-color: rgba(255, 255, 255, 0.496094);>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet&nbsp;</span> &nbsp;&nbsp;<span style=font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-size: 13px; text-align: justify; background-color: rgba(255, 255, 255, 0.496094);>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet&nbsp;</span> &nbsp;&nbsp;<span style=font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-size: 13px; text-align: justify; background-color: rgba(255, 255, 255, 0.496094);>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet&nbsp;</span> &nbsp;&nbsp;<span style=font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-size: 13px; text-align: justify; background-color: rgba(255, 255, 255, 0.496094);>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet&nbsp;</span> &nbsp;&nbsp;<span style=font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-size: 13px; text-align: justify; background-color: rgba(255, 255, 255, 0.496094);>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet&nbsp;</span> &nbsp;&nbsp;<span style=font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-size: 13px; text-align: justify; background-color: rgba(255, 255, 255, 0.496094);>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed feugiat porttitor enim, vel cursus mi fringilla nec. scelerisque Lorem ipsum dolor sit amet&nbsp;</span></p>', '13508830411689024319.jpg', 1, 0);
INSERT INTO `service` (`serv_code`, `sertype_code`, `use_code`, `serv_name`, `serv_summary`, `serv_description`, `serv_image`, `serv_status`, `serv_date_create`, `serv_name_e`, `serv_summary_e`, `serv_description_e`, `serv_image_e`, `serv_order`, `serv_highlight`) VALUES
(7, 2, 7, 'Lotificaciones', 'La topografía tiene mucho que ver con la planeación, elaboración y ejecución de un proyecto carretero. Una brigada de topografía es capaz de llevar acabo los estudios necesarios para poder planear la ruta más optima que satisfaga las necesidades de las comunidades que se beneficien con esta obra, así como su proyección final y el trazo de la misma. \r\nCabe mencionar que las actividades en cuanto a la topografía no se limitan a lo antes mencionado si no que cuando se requiere de ampliaciones, modificaciones y el mantenimiento de carreteras que ya estan construidas, los topografos son requeridos para llevar acabo estos\r\ntrabajos. La topografía tiene mucho que ver con la planeación, elaboración y ejecución de un proyecto carretero. Una brigada de topografía es capaz de llevar acabo los estudios necesarios para poder planear la ruta más optima que satisfaga las necesidades de las comunidades que se beneficien con esta obra, así como su proyección final y el trazo de la misma. \r\nCabe mencionar que las actividades en cuanto a la topografía no se limitan a lo antes mencionado si no que cuando se requiere de ampliaciones, modificaciones y el mantenimiento de carreteras que ya estan construidas, los topografos son requeridos para llevar acabo estos\r\ntrabajos. La topografía tiene mucho que ver con la planeación, elaboración y ejecución de un proyecto carretero. Una brigada de topografía es capaz de llevar acabo los estudios necesarios para poder planear la ruta más optima que satisfaga las necesidades de las comunidades que se beneficien con esta obra, así como su proyección final y el trazo de la misma. \r\nCabe mencionar que las actividades en cuanto a la topografía no se limitan a lo antes mencionado si no que cuando se requiere de ampliaciones, modificaciones y el mantenimiento de carreteras que ya estan construidas, los topografos son requeridos para llevar acabo estos\r\ntrabajos.', '<p style=text-align: justify;><span style=font-family: arial, helvetica, sans-serif; font-size: small;>La topograf&iacute;a tiene mucho que ver con la planeaci&oacute;n, elaboraci&oacute;n y ejecuci&oacute;n de un proyecto carretero. Una brigada de topograf&iacute;a es capaz de llevar acabo los estudios necesarios para poder planear la ruta m&aacute;s optima que satisfaga las necesidades de las comunidades que se beneficien con esta obra, as&iacute; como su proyecci&oacute;n final y el trazo de la misma.&nbsp;</span><br /><span style=font-family: arial, helvetica, sans-serif; font-size: small;>Cabe mencionar que las actividades en cuanto a la topograf&iacute;a no se limitan a lo antes mencionado si no que cuando se requiere de ampliaciones, modificaciones y el mantenimiento de carreteras que ya estan construidas, los topografos son requeridos para llevar acabo estos</span><br /><span style=font-family: arial, helvetica, sans-serif; font-size: small;>trabajos.&nbsp;La topograf&iacute;a tiene mucho que ver con la planeaci&oacute;n, elaboraci&oacute;n y ejecuci&oacute;n de un proyecto carretero. Una brigada de topograf&iacute;a es capaz de llevar acabo los estudios necesarios para poder planear la ruta m&aacute;s optima que satisfaga las necesidades de las comunidades que se beneficien con esta obra, as&iacute; como su proyecci&oacute;n final y el trazo de la misma.&nbsp;<br />Cabe mencionar que las actividades en cuanto a la topograf&iacute;a no se limitan a lo antes mencionado si no que cuando se requiere de ampliaciones, modificaciones y el mantenimiento de carreteras que ya estan construidas, los topografos son requeridos para llevar acabo estos<br />trabajos.&nbsp;La topograf&iacute;a tiene mucho que ver con la planeaci&oacute;n, elaboraci&oacute;n y ejecuci&oacute;n de un proyecto carretero. Una brigada de topograf&iacute;a es capaz de llevar acabo los estudios necesarios para poder planear la ruta m&aacute;s optima que satisfaga las necesidades de las comunidades que se beneficien con esta obra, as&iacute; como su proyecci&oacute;n final y el trazo de la misma.&nbsp;<br />Cabe mencionar que las actividades en cuanto a la topograf&iacute;a no se limitan a lo antes mencionado si no que cuando se requiere de ampliaciones, modificaciones y el mantenimiento de carreteras que ya estan construidas, los topografos son requeridos para llevar acabo estos<br />trabajos.&nbsp;La topograf&iacute;a tiene mucho que ver con la planeaci&oacute;n, elaboraci&oacute;n y ejecuci&oacute;n de un proyecto carretero. Una brigada de topograf&iacute;a es capaz de llevar acabo los estudios necesarios para poder planear la ruta m&aacute;s optima que satisfaga las necesidades de las comunidades que se beneficien con esta obra, as&iacute; como su proyecci&oacute;n final y el trazo de la misma.&nbsp;<br />Cabe mencionar que las actividades en cuanto a la topograf&iacute;a no se limitan a lo antes mencionado si no que cuando se requiere de ampliaciones, modificaciones y el mantenimiento de carreteras que ya estan construidas, los topografos son requeridos para llevar acabo estos<br />trabajos.</span></p>', '13508733541158523535.jpg', '1', '2012-09-03 14:16:58', 'Lotificaciones', 'La topografía tiene mucho que ver con la planeación, elaboración y ejecución de un proyecto carretero. Una brigada de topografía es capaz de llevar acabo los estudios necesarios para poder planear la ruta más optima que satisfaga las necesidades de las comunidades que se beneficien con esta obra, así como su proyección final y el trazo de la misma. \r\nCabe mencionar que las actividades en cuanto a la topografía no se limitan a lo antes mencionado si no que cuando se requiere de ampliaciones, modificaciones y el mantenimiento de carreteras que ya estan construidas, los topografos son requeridos para llevar acabo estos\r\ntrabajos. La topografía tiene mucho que ver con la planeación, elaboración y ejecución de un proyecto carretero. Una brigada de topografía es capaz de llevar acabo los estudios necesarios para poder planear la ruta más optima que satisfaga las necesidades de las comunidades que se beneficien con esta obra, así como su proyección final y el trazo de la misma. \r\nCabe mencionar que las actividades en cuanto a la topografía no se limitan a lo antes mencionado si no que cuando se requiere de ampliaciones, modificaciones y el mantenimiento de carreteras que ya estan construidas, los topografos son requeridos para llevar acabo estos\r\ntrabajos.', '<p style=text-align: justify;><span style=font-family: arial, helvetica, sans-serif; font-size: small;>La topograf&iacute;a tiene mucho que ver con la planeaci&oacute;n, elaboraci&oacute;n y ejecuci&oacute;n de un proyecto carretero. Una brigada de topograf&iacute;a es capaz de llevar acabo los estudios necesarios para poder planear la ruta m&aacute;s optima que satisfaga las necesidades de las comunidades que se beneficien con esta obra, as&iacute; como su proyecci&oacute;n final y el trazo de la misma.&nbsp;</span><br /><span style=font-family: arial, helvetica, sans-serif; font-size: small;>Cabe mencionar que las actividades en cuanto a la topograf&iacute;a no se limitan a lo antes mencionado si no que cuando se requiere de ampliaciones, modificaciones y el mantenimiento de carreteras que ya estan construidas, los topografos son requeridos para llevar acabo estos</span><br /><span style=font-family: arial, helvetica, sans-serif; font-size: small;>trabajos.&nbsp;La topograf&iacute;a tiene mucho que ver con la planeaci&oacute;n, elaboraci&oacute;n y ejecuci&oacute;n de un proyecto carretero. Una brigada de topograf&iacute;a es capaz de llevar acabo los estudios necesarios para poder planear la ruta m&aacute;s optima que satisfaga las necesidades de las comunidades que se beneficien con esta obra, as&iacute; como su proyecci&oacute;n final y el trazo de la misma.&nbsp;<br />Cabe mencionar que las actividades en cuanto a la topograf&iacute;a no se limitan a lo antes mencionado si no que cuando se requiere de ampliaciones, modificaciones y el mantenimiento de carreteras que ya estan construidas, los topografos son requeridos para llevar acabo estos<br />trabajos.&nbsp;La topograf&iacute;a tiene mucho que ver con la planeaci&oacute;n, elaboraci&oacute;n y ejecuci&oacute;n de un proyecto carretero. Una brigada de topograf&iacute;a es capaz de llevar acabo los estudios necesarios para poder planear la ruta m&aacute;s optima que satisfaga las necesidades de las comunidades que se beneficien con esta obra, as&iacute; como su proyecci&oacute;n final y el trazo de la misma.&nbsp;<br />Cabe mencionar que las actividades en cuanto a la topograf&iacute;a no se limitan a lo antes mencionado si no que cuando se requiere de ampliaciones, modificaciones y el mantenimiento de carreteras que ya estan construidas, los topografos son requeridos para llevar acabo estos<br />trabajos.&nbsp;La topograf&iacute;a tiene mucho que ver con la planeaci&oacute;n, elaboraci&oacute;n y ejecuci&oacute;n de un proyecto carretero. Una brigada de topograf&iacute;a es capaz de llevar acabo los estudios necesarios para poder planear la ruta m&aacute;s optima que satisfaga las necesidades de las comunidades que se beneficien con esta obra, as&iacute; como su proyecci&oacute;n final y el trazo de la misma.&nbsp;<br />Cabe mencionar que las actividades en cuanto a la topograf&iacute;a no se limitan a lo antes mencionado si no que cuando se requiere de ampliaciones, modificaciones y el mantenimiento de carreteras que ya estan construidas, los topografos son requeridos para llevar acabo estos<br />trabajos.</span></p>', '13508733541158523535.jpg', 2, 0),
(8, 2, 7, 'Reparacion', 'Tenemos los mejores profesionales en el Tenemos los mejores profesionales en el campo, danos la oportunidad de Tenemos los mejores profesionales en el Tenemos los mejores profesionales en el campo, danos la oportunidad de', '<p><span>servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;</span></p>', '13508828421882597647.jpg', '1', '2012-09-03 17:58:46', 'reparacion (en)', '(en) servicio de prueba de reparacion, servicio de prueba de reparacion, servicio de prueba de reparacion, servicio de prueba de reparacion, servicio de prueba de reparacion, servicio de prueba de reparacion, servicio de prueba de reparacion, servicio de prueba de reparacion, servicio de prueba de reparacion, servicio de prueba de reparacion,', '<p><span>servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;servicio de prueba de reparacion,&nbsp;</span></p>', '13508828421882597647.jpg', 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `service_type`
--

CREATE TABLE IF NOT EXISTS `service_type` (
  `sertype_code` int(11) NOT NULL AUTO_INCREMENT,
  `sertype_name` varchar(45) NOT NULL COMMENT 'nombre del tipo de servicio en español.',
  `sertype_status` enum('1','2','3') NOT NULL COMMENT 'representa el estado del tipo de servicio:\n1. activo\n2. inactivo\n3. eliminado',
  `sertype_name_e` varchar(45) DEFAULT NULL COMMENT 'nombre del tipo de servicio en inglés.',
  `sertype_order` int(11) DEFAULT NULL COMMENT 'representa el orden para ordenar los tipos de servicio.',
  PRIMARY KEY (`sertype_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='tabla responsable de listar los tipos de servicio de la aplicación.' AUTO_INCREMENT=8 ;

--
-- Volcado de datos para la tabla `service_type`
--

INSERT INTO `service_type` (`sertype_code`, `sertype_name`, `sertype_status`, `sertype_name_e`, `sertype_order`) VALUES
(1, 'Servicios Generales', '1', 'General Services', 4),
(2, 'Servicios Especializados', '1', 'Specialized Services', 7),
(3, 'Servicios extra', '1', 'Extra Services', 3),
(4, 'Servicios adicionales', '1', 'Additional Services', 2),
(5, 'Otros Servicios', '1', 'Other Services', 6),
(6, 'Más Servicios', '1', 'Most Services', 5),
(7, 'Servicios especiales ko', '1', 'Special Services ok', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `slider`
--

CREATE TABLE IF NOT EXISTS `slider` (
  `slid_code` int(11) NOT NULL AUTO_INCREMENT,
  `use_code` int(11) NOT NULL,
  `slid_title` varchar(45) NOT NULL COMMENT 'titulo del banner.',
  `slid_content` text NOT NULL COMMENT 'contenido en español del banner.',
  `slid_image_name` varchar(45) NOT NULL COMMENT 'nombre de la imagen original en español cargada.',
  `slid_image_rename` varchar(30) NOT NULL COMMENT 'renombre de la imagen en español cargada.',
  `slid_url` varchar(120) DEFAULT NULL COMMENT 'url del banner.',
  `slid_status` enum('1','2','3') NOT NULL COMMENT 'estado del banner:\n1. activo\n2. inactivo\n3. eliminado',
  `slid_last_modified` datetime NOT NULL COMMENT 'fecha de la ultima modificacion hecha al banner.',
  `slid_date_create` datetime NOT NULL COMMENT 'fecha de creacion del banner.',
  `slid_title_e` varchar(45) DEFAULT NULL COMMENT 'título en inglés del banner.',
  `slid_content_e` text COMMENT 'contenido en inglés del banner.',
  `slid_image_name_e` varchar(45) DEFAULT NULL COMMENT 'nombre de la imagen original en inglés cargada.',
  `slid_image_rename_e` varchar(30) DEFAULT NULL COMMENT 'renombre de la imagen en inglés.',
  `slid_order` int(11) DEFAULT '0' COMMENT 'campo para ordenar el orden de salida de los slider',
  PRIMARY KEY (`slid_code`),
  KEY `fk_banner_user1` (`use_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='tabla para manejar la información de los items del slider de la aplicación.' AUTO_INCREMENT=10 ;

--
-- Volcado de datos para la tabla `slider`
--

INSERT INTO `slider` (`slid_code`, `use_code`, `slid_title`, `slid_content`, `slid_image_name`, `slid_image_rename`, `slid_url`, `slid_status`, `slid_last_modified`, `slid_date_create`, `slid_title_e`, `slid_content_e`, `slid_image_name_e`, `slid_image_rename_e`, `slid_order`) VALUES
(1, 7, 'test es', 'test es test es test es test es test es test es test es test es test es test es test es test es test es test es test es test es test es test es test es test es test es test es test es test es test es test es', '', '13449787291669762349.jpg', 'http://google.com', '3', '2012-08-14 16:13:16', '2012-08-14 16:13:16', 'test en', 'test en test en test en test en test en test en test en test en test en test en test en test en test en test en test en test en test en test en test en test en test en test en test en test en test en test en', 'cartagena en', '1344978770699186458.jpg', 0),
(2, 7, 'Calidad y cumplimiento', 'te ofrecemos la mejor Calidad y cumplimiento', '', '1347035452838202174.jpg', '', '3', '2012-09-07 11:31:00', '2012-08-14 19:29:54', 'Calida y cumplimiento', 'te ofrecemos la mejor Calidad y cumplimiento', '', '1347035452838202174.jpg', 5),
(3, 7, 'Los mejores accesorios', 'Dale un toque diferente a tu celular, se original y agrégale valor a tu teléfono, acércate a nuestra tienda y encuentra el mejor accesorio para tu celular.', '', '13508739841389118298.jpg', '', '1', '2012-10-21 21:53:42', '2012-08-14 19:48:58', 'Top Accessories', 'Give a different touch to your cell phone, Original and add value to your phone, come to our store to find the best accessory for your phone.', '', '13508739841389118298.jpg', 3),
(4, 7, 'obra en construccion es ok', 'obra en construccion es obra en construccion es obra en construccion es obra en construccion es obra en construccion es obra en construccion es obra en construccion es obra en construccion es obra en construccion es obra en construccion es obra en construccion es\r\nok', 'imagen 1', '1344994283216761379.jpg', 'http://translate.google.com/', '3', '2012-08-14 20:35:34', '2012-08-14 19:57:52', '', '', '', '', 0),
(5, 7, 'Deslindes', 'Dentro de los levantamientos topográficos se llevan acabo los levantamientos de deslinde. El deslinde es necesario en el momento, que se tiene duda sobre el límite de alguna colindancia de su terreno, al llevarse a cabo es posible saber si en verdad tiene o no la superficie indicada en su escritura de compra-venta o simplemente si algún vecino le esta invadiendo parte de su propiedad en parte de la colindancia de la misma.', 'deslines', '1347033206351992249.jpg', '', '3', '2012-09-07 10:53:46', '2012-08-14 20:39:44', 'Deslines', 'Within topographic surveys are held demarcation. The boundary is required at the time, you have questions about the limits of any boundary of your land, to take place is indeed possible to know whether or not the area indicated in the deed of sale or simply a neighbor he is invading your property part of the boundary of the same.', 'desline', '1347033206351992249.jpg', 7),
(6, 7, 'Experiencia y calidad', 'ofrecemos Experiencia y calidad ofrecemos Experiencia y calidad ofrecemos Experiencia y calidad ofrecemos Experiencia y calidad ofrecemos Experiencia y calidad ofrecemos Experiencia y calidad ofrecemos Experiencia y calidad ofrecemos Experiencia y calidad ofrecemos Experiencia y calidad ofrecemos Experiencia y calidad ofrecemos Experiencia y calidad ofrecemos Experiencia y calidad ofrecemos Experiencia y calidad ofrecemos Experiencia y calidad ofrecemos Experiencia y calidad ofrecemos Experiencia y', '', '135264549927115781.jpg', '', '1', '2012-11-11 09:51:47', '2012-08-30 11:06:17', 'Experiencia y calidad', 'Contamos con los mejores profecionales en el campo, Contamos con los mejores profecionales en el campo, Contamos con los mejores profecionales en el campo, Contamos con los mejores profecionales en el campo, Contamos con los mejores profecionales en el campo, Contamos con los mejores profecionales en el campo, Contamos con los mejores profecionales en el campo, Contamos con los mejores profecionales en el campo, Contamos con los mejores profecionales en el campo, Contamos con los mejores profecionales en el campo, Contamos con los mejores profecionales en el campo, Contamos con los mejores profecionales en el campo, Contamos con los mejores profecionales en el campo, Contamos con los mejores profecionales en el campo,\r\nofrecemos Experiencia y calidad ofrecemos Experiencia y calidad ofrecemos Experiencia y calidad ofrecemos Experiencia y calidad ofrecemos Experiencia y calidad ofrecemos Experiencia y calidad ofrecemos Experiencia y', '', '13470356841639724244.jpg', 4),
(7, 7, 'Experiencia, calidad y los mejores precios', 'SOLUCIONES CELULARES es la empresa pionera en prestación de  soporte técnico especializado de equipos de telefonía móvil y con 12 años de experiencia en el sector de las telecomunicaciones tenemos el gusto de ofrecer nuestros servicios al más alto nivel de calidad y con los mejores precios.', '', '1350873864120822171.jpg', '', '1', '2012-10-21 21:44:32', '2012-09-02 08:26:51', 'Experience, quality and best prices', 'Mobile Solutions is the pioneer in providing specialized technical support of mobile equipment with 12 years experience in the telecommunications industry we are pleased to offer our services at the highest level of quality and the best prices.', '', '1350873864120822171.jpg', 2),
(8, 7, 'los mejores equipos', 'tenemos a tu disposicion los tenemos a tu disposicion los mejores equipos tenemos a tu disposicion los mejores equipos tenemos a tu disposicion los mejores equipos tenemos a tu disposicion los mejores equipos tenemos a tu disposicion los mejores equipos tenemos a tu disposicion los mejores equipos tenemos a tu disposicion los mejores equipos tenemos a tu disposicion los mejores equipos tenemos a tu disposicion los mejores equipos mejores equipos', '', '13467929931453946453.jpg', '', '3', '2012-09-04 16:10:39', '2012-09-03 14:11:20', 'Los mejores equipos', 'tenemos a tu disposicion los mejores equipos tenemos a tu disposicion los mejores equipos tenemos a tu disposicion los mejores equipos tenemos a tu disposicion los mejores equipos tenemos a tu disposicion los mejores equipos tenemos a tu disposicion los mejores equipos tenemos a tu disposicion los mejores equipos tenemos a tu disposicion los mejores equipos tenemos a tu disposicion los mejores equipos tenemos a tu disposicion los mejores equipos tenemos a tu disposicion los mejores equipos', '', '13467929931453946453.jpg', 6),
(9, 7, 'Lo último en tecnología', 'Nos preocupamos por ser siempre los mejores, y para ello buscamos estar siempre a la vanguardia de la tecnología. Acércate a nuestra tienda y conoce nuestros nuevos productos.', 'iPhone 5', '1350873494398908692.jpg', 'http://apple.com/iphone', '1', '2012-10-21 21:42:51', '2012-09-04 17:14:41', 'The latest in technology', 'We care about always being the best, and for that we always be at the forefront of technology. Come to our store and meet our new products.', 'iPhone 5', '1350873494398908692.jpg', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `use_code` int(11) NOT NULL AUTO_INCREMENT,
  `use_name` varchar(20) NOT NULL COMMENT 'nombre del usuario.',
  `use_lastname` varchar(20) NOT NULL COMMENT 'apellido del usuario.',
  `use_email` varchar(30) NOT NULL COMMENT 'email del usuario.',
  `use_login` varchar(15) NOT NULL COMMENT 'login del usuario, usado para autenticarse en la aplicación.',
  `use_password` varchar(100) NOT NULL,
  `use_status` enum('1','2','3','4') NOT NULL COMMENT 'estado del usuario:\n1. activo\n2. inactivo\n3. bloqueado\n4. borrado',
  `use_date_create` datetime NOT NULL COMMENT 'fecha de creación del usuario.',
  PRIMARY KEY (`use_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Tabla que contiene la información de los usuarios en la aplicación.' AUTO_INCREMENT=12 ;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`use_code`, `use_name`, `use_lastname`, `use_email`, `use_login`, `use_password`, `use_status`, `use_date_create`) VALUES
(7, 'Jhoan Sebastián', 'Lara Puentes', 'j_sebastian_l@hotmail.com', 'sebastian', '717519909dffdeca96233cad894849988ee0201dae0e32ffa00cf6c79f28ba5a', '1', '2012-08-12 17:22:28'),
(8, 'Luis', 'Velandia', 'lavz67@gmail.com', 'luis_velandia', 'd48530dc04350e46a9633a03aa81bda6d491e3241f4ae90b6f29ad3453bc5bff', '4', '2012-08-13 11:47:36'),
(9, 'Daniela', 'Velandia', 'daniela-0135@hotmail.com', 'daniela', '4cc0204e10996147960331e215d1fade780fad8966581f1a6a66f66bf80f8e38', '1', '2012-08-13 11:48:50'),
(10, 'Tonny', 'Lara Velandia', 'tonny@gmail.com', 'tonny', '88a9fc9a8cd50c88141c95adc00274a5', '1', '2012-08-13 12:30:16'),
(11, 'Luis', 'Velandia', 'luisvelandia@gmail.com', 'luisvela', '411323a4f38cb713f642a99b5f44067b47eb5e14c55287ca9feeeefc482883bf', '1', '2012-09-04 21:13:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `video`
--

CREATE TABLE IF NOT EXISTS `video` (
  `vid_code` int(11) NOT NULL AUTO_INCREMENT,
  `use_code` int(11) NOT NULL,
  `vid_name` varchar(45) NOT NULL COMMENT 'nombre del video en español.',
  `vid_summary` text COMMENT 'resumen del video en español.',
  `vid_original` varchar(100) NOT NULL COMMENT 'nombre original del video si es de tipo 1, url completa si es de tipo 2',
  `vid_file` varchar(45) NOT NULL COMMENT 'url del video si es de youtube o el rename del archivo si es flv',
  `vid_image` varchar(45) NOT NULL COMMENT 'imagen a mostrar del video.',
  `vid_date_create` datetime NOT NULL COMMENT 'fecha de creacion del video',
  `vid_status` enum('1','2','3') NOT NULL COMMENT 'estado del video:\n1. activo\n2. inactivo\n3. eliminado',
  `vid_type` enum('1','2') NOT NULL COMMENT 'tipo de video: 1. video desde el computador 2. video desde youtube',
  `vid_name_e` varchar(45) DEFAULT NULL COMMENT 'nombre del video en ingles.',
  `vid_summary_e` text COMMENT 'resumen del video en inglés.',
  `vid_imag_type` enum('1','2') DEFAULT NULL COMMENT '1. imagen cargada por el usuario  2. seleccionar imagen por defecto desde el video',
  `vid_order` int(11) DEFAULT NULL COMMENT 'para ordenar los videos',
  PRIMARY KEY (`vid_code`),
  KEY `fk_video_user1` (`use_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='tabla para almacenar la información de los videos en la aplicación.' AUTO_INCREMENT=11 ;

--
-- Volcado de datos para la tabla `video`
--

INSERT INTO `video` (`vid_code`, `use_code`, `vid_name`, `vid_summary`, `vid_original`, `vid_file`, `vid_image`, `vid_date_create`, `vid_status`, `vid_type`, `vid_name_e`, `vid_summary_e`, `vid_imag_type`, `vid_order`) VALUES
(1, 7, 'PES 2013 ok', 'descr ok', 'http://www.youtube.com/watch?v=lkNLVj24iLw', 'lkNLVj24iLw', '13475942712080846199.jpg', '2012-09-13 21:37:48', '1', '2', 'PES 2013 EN ok', 'description ok', '1', 1),
(2, 7, 'video mp4', 'descripcion video mp4', 'video.mp4', '1347651016123837066.mp4', '1347651009889561829.jpg', '2012-09-14 14:30:17', '1', '1', 'video mp4 e', 'description mp4', '1', 2),
(3, 7, 'otro video mp4', 'descripcion', 'video.mp4', '1347651183926270743.mp4', '1347651143818164881.jpg', '2012-09-14 14:33:04', '1', '1', 'other video mp4', 'description', '1', 3),
(4, 7, 'video PES 2013', 'descripcion de prueba', 'PES 2013 Trailer Oficial.flv', '13476514261401478341.flv', '1347651420219045688.jpg', '2012-09-14 14:37:07', '1', '1', 'Video PES 2013', 'test decription', '1', 4),
(5, 7, 'nueva prueba de carga de video desde mi pc', 'esta es una desc', 'Natura Colombia   Consejos para Una base Ideal.flv', '13480231151418814013.flv', '13480230781294098946.jpg', '2012-09-18 21:51:56', '1', '1', 'Load test video from mi pc', 'this is a description', '1', 5),
(6, 7, 'Juanito alimaña', 'cancion', 'http://www.youtube.com/watch?v=embxRelpaVI&feature=fvst', 'embxRelpaVI', '1348026145723769905.jpg', '2012-09-18 22:42:34', '1', '2', 'Juanito alimaña', 'song', '1', 6),
(7, 7, 'Google Colombia', 'Google Colombia', 'http://www.youtube.com/user/GoogleColombia?v=zu-z3iHe9rI', 'zu-z3iHe9rI', '', '2012-09-18 22:59:23', '1', '2', 'Google Colombia e', 'Google Colombia en', '1', 7),
(8, 7, 'video android', '', 'http://www.youtube.com/watch?v=aIgG6sTHrwM&feature=g-all-u', 'aIgG6sTHrwM', '', '2012-09-19 12:07:57', '1', '2', 'Video android', '', '1', 8),
(9, 7, 'iPhone 5 el nuevo telefono de la manzana', '', 'http://www.youtube.com/watch?v=xvej5gmbyPw&feature=related', 'xvej5gmbyPw', '', '2012-09-19 12:11:24', '1', '2', 'iPhone 5', '', '1', 9),
(10, 7, 'Prueba YT', '', 'http://www.youtube.com/watch?v=tNr9zSJPn_Q', 'tNr9zSJPn_Q', '', '2012-09-24 16:57:33', '1', '2', 'Test YT', '', '1', 10);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `attachment`
--
ALTER TABLE `attachment`
  ADD CONSTRAINT `fk_attachment_mail1` FOREIGN KEY (`email_code`) REFERENCES `mail` (`email_code`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `charge_person`
--
ALTER TABLE `charge_person`
  ADD CONSTRAINT `fk_charge_person_charge1` FOREIGN KEY (`chg_code`) REFERENCES `charge` (`chg_code`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_charge_person_person1` FOREIGN KEY (`pers_code`) REFERENCES `person` (`pers_code`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `contact`
--
ALTER TABLE `contact`
  ADD CONSTRAINT `fk_contact_user1` FOREIGN KEY (`use_code`) REFERENCES `user` (`use_code`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `gallery`
--
ALTER TABLE `gallery`
  ADD CONSTRAINT `fk_gallery_image1` FOREIGN KEY (`img_code`) REFERENCES `image` (`img_code`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_gallery_user1` FOREIGN KEY (`use_code`) REFERENCES `user` (`use_code`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `image`
--
ALTER TABLE `image`
  ADD CONSTRAINT `fk_image_user1` FOREIGN KEY (`use_code`) REFERENCES `user` (`use_code`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_table1_gallery1` FOREIGN KEY (`gall_code`) REFERENCES `gallery` (`gall_code`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `image_ibfk_1` FOREIGN KEY (`gall_code`) REFERENCES `gallery` (`gall_code`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `mail`
--
ALTER TABLE `mail`
  ADD CONSTRAINT `fk_mail_user1` FOREIGN KEY (`use_code`) REFERENCES `user` (`use_code`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `service`
--
ALTER TABLE `service`
  ADD CONSTRAINT `fk_service_service_type1` FOREIGN KEY (`sertype_code`) REFERENCES `service_type` (`sertype_code`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_service_user1` FOREIGN KEY (`use_code`) REFERENCES `user` (`use_code`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `video`
--
ALTER TABLE `video`
  ADD CONSTRAINT `fk_video_user1` FOREIGN KEY (`use_code`) REFERENCES `user` (`use_code`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
