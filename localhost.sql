-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb2+deb7u5
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 12-01-2017 a las 20:10:02
-- Versión del servidor: 5.5.49
-- Versión de PHP: 5.5.38-1~dotdeb+7.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `mychef`
--
CREATE DATABASE `mychef` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `mychef`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `chef`
--

CREATE TABLE IF NOT EXISTS `chef` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_usuario` int(10) unsigned NOT NULL,
  `dnichef` varchar(9) NOT NULL,
  `descripcion` varchar(700) NOT NULL,
  `puntuacion_total` int(11) NOT NULL,
  `numero_Votos` int(11) DEFAULT '0',
  `cocina` varchar(50) NOT NULL,
  `personas` int(2) unsigned NOT NULL,
  `comida` int(1) NOT NULL,
  `barco` int(1) NOT NULL,
  `precio` int(3) NOT NULL,
  `alta` date NOT NULL,
  `ciudad` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=207 ;

--
-- Volcado de datos para la tabla `chef`
--

INSERT INTO `chef` (`id`, `id_usuario`, `dnichef`, `descripcion`, `puntuacion_total`, `numero_Votos`, `cocina`, `personas`, `comida`, `barco`, `precio`, `alta`, `ciudad`) VALUES
(5, 17, '47997458T', 'Chef especialista en pasta y pasteleria.\r\n\r\n\r\n                \r\n\r\n', 3, 1, '2', 3, 1, 0, 25, '0000-00-00', 2),
(10, 24, '47330931J', '', 0, 0, '2', 3, 1, 0, 75, '0000-00-00', 2),
(11, 18, '45874587G', 'Tengo el agrado de dirigirme a ustedes con el fin de transmitirles mi deseo en firme de incorporarme a su empresa. A tal efecto adjunto, junto a la presente, mi curriculum vitae.Me presento como una persona activa, responsable, creativa, flexible, orientada al logro de resultados y a la resolución y evolución constante en las tareas asignadas.Además de los datos que surgen de mi CV, quiero hacerle saber mi amplio gusto y pasión por la gastronomía y por cual mi compromiso y dedicación para mi desarrollo personal y laboral. Hola\r\n                \r\n\r\n              \r\n                \r\n\r\n\r\n                \r\n\r\n', 10, 3, '2', 3, 0, 0, 28, '0000-00-00', 2),
(12, 27, '12345678m', '', 4, 1, '', 0, 0, 0, 0, '0000-00-00', 0),
(203, 28, '45698745A', 'Chef especialista en pescados y mariscos. 13 años de experiencia.  Una presentación puede llevar textos, imágenes, vídeos y archivos de audio. Se puede dividir en dos tipos: la presentación multimedia que es generalmente más utilizada a través de un programa de presentaciones pero que también es posible realizar a través de carteles con imágenes y audio generalmente grabados para su reproducción (utilizado para presentar productos, proyectos, etc.). O la presentación común (ésta solo utiliza imágenes y texto en carteles), una presentación que contiene sólo imágenes, a menudo acompañadas de efectos o texto superpuesto; Lo mismo que ocurre con la presentación multimedia ocurre con este tipo de', 5, 1, '', 0, 0, 0, 0, '0000-00-00', 0),
(206, 1, '12345678k', '', 0, 0, '', 0, 0, 0, 0, '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ciudades`
--

CREATE TABLE IF NOT EXISTS `ciudades` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `ciudades`
--

INSERT INTO `ciudades` (`id`, `nombre`) VALUES
(1, 'Barcelona'),
(2, 'Madrid'),
(3, 'Zaragoza'),
(4, 'Valencia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE IF NOT EXISTS `cliente` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_usuario` int(10) unsigned NOT NULL,
  `dnicliente` varchar(9) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`id`, `id_usuario`, `dnicliente`) VALUES
(8, 24, '47330931J'),
(11, 27, '12345678m'),
(12, 28, '45698745A'),
(13, 29, '45512548N'),
(14, 30, '37738437S');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comida`
--

CREATE TABLE IF NOT EXISTS `comida` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Volcado de datos para la tabla `comida`
--

INSERT INTO `comida` (`id`, `nombre`) VALUES
(1, 'Mediterranea'),
(2, 'Italiana'),
(3, 'Francesa'),
(4, 'Japonesa'),
(5, 'Mexica'),
(6, 'Autor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contrato`
--

CREATE TABLE IF NOT EXISTS `contrato` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fecha` varchar(25) NOT NULL,
  `id_cliente` int(10) unsigned NOT NULL,
  `id_chef` int(10) unsigned NOT NULL,
  `id_menu` int(10) unsigned NOT NULL,
  `barco` varchar(2) NOT NULL,
  `metodo` int(10) NOT NULL,
  `mensaje` varchar(700) NOT NULL,
  `estado` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=92 ;

--
-- Volcado de datos para la tabla `contrato`
--

INSERT INTO `contrato` (`id`, `fecha`, `id_cliente`, `id_chef`, `id_menu`, `barco`, `metodo`, `mensaje`, `estado`) VALUES
(91, '06/03/2016', 11, 10, 1, '', 3, '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `foto`
--

CREATE TABLE IF NOT EXISTS `foto` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_chef` int(10) unsigned NOT NULL,
  `imagen` varchar(150) NOT NULL,
  `descripcion` varchar(700) NOT NULL,
  `fecha` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=56 ;

--
-- Volcado de datos para la tabla `foto`
--

INSERT INTO `foto` (`id`, `id_chef`, `imagen`, `descripcion`, `fecha`) VALUES
(2, 2, 'http://www.mychef.cat/uploads/2_imgPerfil_cara.jpg', 'imgPerfil', '0000-00-00'),
(4, 11, 'http://www.mychef.cat/uploads/11_imgMenu1_plato-chef2.jpg', 'imgMenu1', '0000-00-00'),
(5, 11, 'http://www.mychef.cat/uploads/11_imgMenu2_plato1.jpg', 'imgMenu2', '0000-00-00'),
(6, 11, 'http://www.mychef.cat/uploads/11_imgMenu3_menu3.jpg', 'imgMenu3', '0000-00-00'),
(9, 11, 'http://www.mychef.cat/uploads/11_galeria_menu3.jpg', 'Esto es el titulo', '0000-00-00'),
(12, 0, 'http://www.mychef.cat/uploads/imagenGaleria_galeria_plato1.jpg', 'fgdfgdfgdgd', '0000-00-00'),
(16, 11, 'http://www.mychef.cat/uploads/11_galeria_menu1.png', 'Menu1', '0000-00-00'),
(22, 0, 'http://www.mychef.cat/uploads/eliminarFotosGaleria_galeria_fondo3.jpg', 'fondo', '0000-00-00'),
(24, 0, 'http://www.mychef.cat/uploads/eliminarFotosGaleria_imgPerfil_cara.jpg', 'imgPerfil', '0000-00-00'),
(26, 11, 'http://www.mychef.cat/uploads/11_imgPerfil_11.jpg', 'imgPerfil', '0000-00-00'),
(29, 0, 'http://www.mychef.cat/uploads/imagenGaleria_galeria_fondo3.jpg', 'dfgfdgfdgdf', '0000-00-00'),
(30, 0, 'http://www.mychef.cat/uploads/imagenGaleria_galeria_fondo3.jpg', 'dfgfdgfdgdf', '0000-00-00'),
(36, 203, 'http://www.mychef.cat/uploads/203_imgPerfil_chefa.jpg', 'imgPerfil', '0000-00-00'),
(37, 203, 'http://www.mychef.cat/uploads/203_imgMenu1_Salmorejo_cordobes.jpg', 'imgMenu1', '0000-00-00'),
(39, 203, 'http://www.mychef.cat/uploads/203_imgMenu3_tarta_santiago.jpg', 'imgMenu3', '0000-00-00'),
(40, 203, 'http://www.mychef.cat/uploads/203_imgMenu2_Lubina.jpg', 'imgMenu2', '0000-00-00'),
(42, 203, 'http://www.mychef.cat/uploads/203_galeria_Tallarines_salsa_champiñones.jpg', 'Tallarines en salsa de champiñones', '0000-00-00'),
(44, 11, 'http://www.mychef.cat/uploads/11_galeria_menu2.jpg', 'Plato especial del chef', '0000-00-00'),
(45, 12, 'http://www.mychef.cat/uploads/12_imgPerfil_12.jpg', 'imgPerfil', '0000-00-00'),
(46, 10, 'http://www.mychef.cat/uploads/10_imgPerfil_10.jpg', 'imgPerfil', '0000-00-00'),
(47, 5, 'http://www.mychef.cat/uploads/5_imgPerfil_5.jpg', 'imgPerfil', '0000-00-00'),
(49, 11, 'http://www.mychef.cat/uploads/11_galeria_Gastronomía-canadiense-570x321.jpg', 'Tortetas de miel', '0000-00-00'),
(50, 11, 'http://www.mychef.cat/uploads/11_galeria_comida para noche.jpg', 'Patatas rellenas', '0000-00-00'),
(51, 11, 'http://www.mychef.cat/uploads/11_galeria_comida-mexicana.jpg', 'Presentacion del menu tres', '0000-00-00'),
(52, 11, 'http://www.mychef.cat/uploads/11_galeria_Comida-muy-creativa-14.jpg', 'Postre para los mas pequeños', '0000-00-00'),
(53, 11, 'http://www.mychef.cat/uploads/11_galeria_comida-china-3.jpg', 'Ramen', '0000-00-00'),
(54, 11, 'http://www.mychef.cat/uploads/11_galeria_Bandeja de sushi.jpg', 'Bandeja de sushi', '0000-00-00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_chef` int(10) unsigned NOT NULL,
  `entrantes` varchar(350) NOT NULL,
  `primeros` varchar(350) NOT NULL,
  `segundos` varchar(350) NOT NULL,
  `postres` varchar(350) NOT NULL,
  `menu` int(1) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `menu` (`menu`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=63 ;

--
-- Volcado de datos para la tabla `menu`
--

INSERT INTO `menu` (`id`, `id_chef`, `entrantes`, `primeros`, `segundos`, `postres`, `menu`) VALUES
(1, 11, 'Crujientes de manchego con mermelada manzana', 'ensalada de burrata con vinagreta de maracuya y toques silvestres', 'solomillo en salsa de vino y cerezas confitadas', 'cazuelita de chocolate', 1),
(2, 11, 'ceviche de salmón con toques de mango y patacones.', 'steak tartar', 'tataki de atun', 'canelones de piña con crema de coco', 1),
(3, 11, 'Blinis de pulpo con mayonesa de lima', 'Salteado de verduras con curry', 'Pad thaide pollo', 'Culan de chocolate', 1),
(7, 11, 'Pieles de patata con salsa tartata y mermelada de tomate', 'Ensalada de la huerta', 'Salmón gratinado con espuma de arroz y frutos secos', 'Taten de manzana', 2),
(8, 11, 'Patacones con guacamole y pico de gallo', 'Humos de remolacha', 'Cuscus con verduras', 'Helado de canela con toques de ron', 2),
(9, 11, 'croquetas caseras de pato', 'Sopa de puerro', 'Risoto de gambas rojas', 'crema de coco', 2),
(16, 203, 'Tortilla española', 'Salmorejo cordobés', 'Lubina en cama de patatas', 'Flan de huevo', 1),
(17, 203, 'Croquetas con secreto', 'Ensalada del mar', 'Churrasco de ternera', 'Macedonia tropical', 1),
(18, 203, 'Boquerones en vinagre', 'Marmitko de bonito', 'Conejo a las hierbas provenzales', 'Tarta de queso curado de oveja', 1),
(21, 5, 'Pulpo A-Brasa', 'Dry-Aged', 'Steak tartar cortado a cuchillo con Mantequilla al cafe de Paris', 'Frapé de mojito estilo “Guana”', 1),
(22, 5, 'Foie por las nubes', 'Lenguado enterrado bajo las olas del mar', 'Esparracada de Butifarra del Perol, Oreja de Cerdo y Navajas del Delta del Ebro', 'Tarta Tatin de Manzana', 1),
(23, 5, 'Ovo', 'Rabitos de cerdo iberico Crujientes con Creme Fraiche', 'Chuletón de buey a la piedra (precio Kg)', 'Coulant de chocolate con helado de vainilla y crema inglesa', 1),
(24, 11, 'Salmonejo', 'Ensalada tibia de marisco', 'Wok de verduras', 'Helado de mandarina', 3),
(25, 11, 'Gazpacho', 'Sashimi de salmon', 'Paella', 'Trufas de chocolate', 3),
(26, 11, 'Ñoquis', 'Sopa de ajo', 'Atún a la plancha', 'Tiramisu', 3),
(33, 203, 'Ensalada de 5 tipos de algas con salsa miso ', 'Pescado blanco macerado con lima, cebolla, cilantro y shichimi', 'Relleno de bogavante, pepino y mayonesa picante, envuelto en aguacate ', 'Helado de Maracuya', 2),
(34, 203, 'Ensalada de marisco variado, vieira, calamar, bogavante,', 'Salmón macerado con lima, cebolla, cilantro, shichimi y salsa de maracuyá', 'Palmito, aguacate y mayonesa picante envuelto en picanha de ternera y cebolla crujient', 'Flan de Huevo con fruta de la Pasion', 2),
(35, 203, 'Tortilla española', 'Salmorejo cordobés', 'Lubina en cama de patatas', 'Flan de huevo', 2),
(36, 203, '“Escalivada” con anchoas', 'Ensalada de ventresca', 'Paella de marisco', 'Crema catalana', 3),
(37, 203, 'Burrata con tomate', 'Verduras de temporada', 'Arroz con verduras ', 'Crema de leche', 3),
(38, 203, 'Rillete de caballa', 'Ostras de Normandía ', 'Lubina salvaje ', 'Arroz de leche', 3),
(39, 10, 'Mollete de calamar', 'Ensalada de salmón de Alaska', 'Steak Tartar de buey', 'Dulce de coco', 1),
(40, 10, 'Huevos fritos de corral con parmentier', 'Pulpo de roca', 'Espaldita de cordero lechal', 'Tiramisu', 1),
(41, 10, 'Coca tostada con tomate', 'Mollete de costilla de cerdo ibérico', 'Burger de ternera con o sin pan', 'Helado de tofu', 1),
(42, 10, 'Calçots rebozado con romesco.', 'Huevos rotos de temporada.', 'Wok de pato laqueado sobre verduritas de temporada y arroz basmati.', 'Coulant chocolate', 2),
(43, 10, 'Croquetas Carlitos', 'Steak tartare cortado a cuchillo con alcaparrones, piparras y tostas de pan sardo.', 'Tagliatelle con crema suave de queso y tartufata', 'Pasteles caseros', 2),
(44, 10, 'Edamame frito con salsa picante de pimienta Bode de Goias', 'Sardinas ahumadas, cebollitas dulces, rúcula, alcachofa en aceite y picatostes de aceite de oliva', 'Lomo de salmón, panceta, gorgonzola y mermelada de tomate', 'Pastel tibio de plátano, espuma de queso y coco, salsa “toffee” y helado de chocolate', 2),
(45, 10, 'Burrata', 'Ensalada fresca de quinoa', 'Wok de pollo estilo thai', 'Milhojas de maracuyá y toffee', 3),
(46, 10, 'Ceviche de dorada', 'Salmón marinado con mantequilla de tomillo y tostaditas', 'Lomo de bacalao con mermelada de pimiento rojo y aceite de ajo', 'Tatin de manzana con espuma de vainilla y pimienta rosa', 3),
(47, 10, 'Steak tartar', 'Foie por las nubes', 'Tajine de cordero', 'Tiramisú', 3),
(48, 5, 'Picatoste de anguila ahumada.', 'Caldo Dashi con cigalas', 'Tartar de atún bluefin con crema de aguacate, espuma de yuzu y caviar de Riofrío.', 'Coulant de chocolate.', 2),
(49, 5, 'Esferificación de jengibre, manzana y oro.', 'Micro mariscada.', 'Brochetas de pollo Teriyaki con espuma de boniato y tempura de verduras.', 'Apoteosis de frutas exóticas, cucuruchos de mango y coco, flan de sésamo negro, min-colada de piña con espuma de coco y caviar de ron Zacapa Centenario.', 2),
(50, 5, 'Edamame frito con salsa picante de pimienta Bode de Goias', 'Sardinas ahumadas, cebollitas dulces, rúcula, alcachofa en aceite y picatostes de aceite de oliva', 'Lomo de salmón, panceta, gorgonzola y mermelada de tomate', 'Pastel tibio de plátano, espuma de queso y coco, salsa “toffee” y helado de chocolate', 2),
(51, 5, 'Semiesférico eléctrico de leche de tigre', 'Verduras texturizadas con quesos catalanes, cereales infusionados y pilpil de miel', 'Sobrebarriga (entraña) glaseada en glass de ternera y panela, marranitas abiertas de plátano macho, pico de gallo y boniato', 'Postre de yogur: 7 texturas de yogur vivo', 3),
(52, 5, 'Ceviche vegetal de cactus, mango y manzana', 'Ostra del delta del Ebro en ceviche amazónico y helado de tomate de árbol ahumado', 'Pescado azul marinada con taboulé de coliflor y ceps', 'Caribe Colombia (pan de plátano, crema de yuca, queso costeño, helado de arroz y crema catalana de plátano macho)', 3),
(53, 5, 'Arepa de choco, Stilton afinado y miel', 'Lazo crujiente de panceta ibérica curada', 'Laminas de ternera', 'Cucurucho de tarta de queso', 3),
(54, 12, 'BONITO MARINADO EN SAKE Y PESTO', 'ENSALADA DE MANGO ', 'CANELÓN DE RUSTIDO Y FOIE', 'HELADO DE MARACUYA Y TOQUES DE VINO ', 1),
(55, 12, 'CENTOLLO, REMOLACHA Y MAHONESA DE JENGIBRE', 'TACOS DE COCHINILLO', 'LOMO ALTO DE ANGUS BLACK NEBRASKA', 'CAZUELITA DE CHOCOLATE CON HELADO DE CANELA', 1),
(56, 12, 'ALMEJAS, ZAMBURIÑAS Y COCO', 'BURRATA', 'CALAMARES RELLENOS DE IBÉRICO, BUTIFARRA Y TRUFA NEGRA', 'ESPUMA DE ARROZ DE LECHE CON TOQUES DE ANÍS ', 1),
(57, 12, 'Terrina', 'Gambas rojas', 'Carré de cordero sobre demi-glace de garnacha negra, chalotas a la miel y puré de guisantes al jengibre', 'Texturas cítricas', 2),
(58, 12, 'Tartar de atun', 'Ensalada de la huerta', 'Presa Ibérica con chutney de cebolla morada al Oporto, duquesa de yuca', 'Tarta Tatin de mango con salsa inglesa', 2),
(59, 12, 'Blinis de pulpo con mayonesa de lima', 'Salteado de verduras con curry', 'Pad thaide pollo', 'Culan de chocolate', 2),
(60, 12, 'Alitas de pollo con Coca-Cola', 'Rodaballo a la Vizcaína con oreja adobada', 'Arroz negro crujiente con tinta de calamar', 'Polo de pomelo rosa', 3),
(61, 12, 'Canelones de gulas y salsa de marisco', 'Vichyssoise de pera con panceta', 'Canelones de gulas y salsa de marisco', 'Crujiente de crema con gelatina balsámica', 3),
(62, 12, 'Goffre con aillade y caballa escabechada', 'Sopa de ajo', 'Wok de verduras de temporada ', 'Mojito de sandía', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE IF NOT EXISTS `pagos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_cliente` int(10) unsigned NOT NULL,
  `tipo` int(10) NOT NULL,
  `numero` varchar(255) NOT NULL,
  `fecha` varchar(25) NOT NULL,
  `cvc` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `pagos`
--

INSERT INTO `pagos` (`id`, `id_cliente`, `tipo`, `numero`, `fecha`, `cvc`) VALUES
(3, 11, 3, '2132', '12-12', 321);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `precio`
--

CREATE TABLE IF NOT EXISTS `precio` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_chef` int(10) unsigned NOT NULL,
  `precio` float unsigned NOT NULL,
  `menu` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Volcado de datos para la tabla `precio`
--

INSERT INTO `precio` (`id`, `id_chef`, `precio`, `menu`) VALUES
(1, 11, 58, 1),
(4, 203, 150, 1),
(5, 5, 55, 1),
(6, 11, 70, 3),
(7, 11, 150, 2),
(10, 203, 66, 3),
(11, 10, 77, 1),
(12, 10, 80, 3),
(13, 5, 55, 2),
(14, 5, 95, 3),
(15, 12, 78, 1),
(16, 12, 65, 3),
(17, 10, 90, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puntuacion`
--

CREATE TABLE IF NOT EXISTS `puntuacion` (
  `id_chef` int(10) unsigned NOT NULL,
  `id_cliente` int(10) unsigned NOT NULL,
  `puntuacion` float unsigned DEFAULT NULL,
  `opinion` varchar(150) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Volcado de datos para la tabla `puntuacion`
--

INSERT INTO `puntuacion` (`id_chef`, `id_cliente`, `puntuacion`, `opinion`, `id`) VALUES
(11, 11, 5, NULL, 11),
(10, 8, 5, 'el profe de pryecto mola ', 12),
(11, 18, 4, 'Esto es un comentario', 13),
(5, 8, 3, NULL, 14),
(203, 18, 5, 'Esto es un comentario de prueba', 22),
(11, 17, NULL, 'Muy buena comida.', 23),
(12, 18, 4, NULL, 25),
(11, 33, 5, 'Que tal', 27),
(11, 34, 1, 'Hola', 28);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `receta`
--

CREATE TABLE IF NOT EXISTS `receta` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_chef` int(10) unsigned NOT NULL,
  `id_video` int(10) unsigned NOT NULL,
  `fecha` date NOT NULL,
  `archivotexto` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tarjeta`
--

CREATE TABLE IF NOT EXISTS `tarjeta` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `tarjeta`
--

INSERT INTO `tarjeta` (`id`, `nombre`) VALUES
(1, 'visa'),
(2, 'MasterCard'),
(3, 'DinersClub'),
(4, 'AmericanExpress');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ciudad` int(10) unsigned DEFAULT NULL,
  `alias` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `poblacion` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `codigo_postal` int(6) DEFAULT NULL,
  `direccion` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `chef` int(1) unsigned NOT NULL DEFAULT '0',
  `dni` varchar(9) CHARACTER SET latin1 NOT NULL,
  `nombre` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `apellidos` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `admin` int(11) NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `activada` int(11) NOT NULL DEFAULT '0',
  `codigo_activacion` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `codigo_reestablecimiento` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `usuarios_dni_unique` (`dni`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=31 ;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `ciudad`, `alias`, `poblacion`, `codigo_postal`, `direccion`, `chef`, `dni`, `nombre`, `apellidos`, `email`, `password`, `admin`, `remember_token`, `created_at`, `updated_at`, `activada`, `codigo_activacion`, `codigo_reestablecimiento`) VALUES
(1, NULL, NULL, NULL, NULL, NULL, 0, '12345678k', 'Pablo ', 'Muñoz', 'pmuñoz@gmail.com', '', 0, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '', ''),
(17, 1, 'Yoquese', 'Vilassar', 8340, 'Yoquese', 1, '47997458T', 'Adrià ', 'Alberich', 'atunerin@gmail.com', '$2y$10$g1NRWGyTI3sV.EoiXk2yFOJa6xf12uAzeuZqyAbC2NP3r3LR34aQW', 1, 'WfhfFkY3vMbKjZayTXxfB30ri8aTGbvUwjamq0dmYbOSsfBY0CP1J4DnSAeA', '2016-05-02 05:30:32', '2016-05-02 05:30:32', 1, '', ''),
(18, 1, 'Pepita', 'Barcelona', 8012, 'Industria', 1, '45874587G', 'Beatriz', 'G', 'galgrabe@gmail.com', '$2y$10$15jZB3b0rtM0PGrvHsXoY.1VHhyGT8YA6IsRbtMAQXKS6cx2zCLUC', 0, 'LxfNITKSef0AeX8vauO2f9ADc5Fqc7qiha26RPufonsBZdZSFHupmqYLLnmM', '2016-05-02 05:39:01', '2016-05-02 05:39:01', 1, '', '8cdd01401f88192607c87750b04ee67d'),
(20, NULL, NULL, NULL, NULL, NULL, 0, '12345678o', 'pedro', 'perez', 'perez@gmail.com', 'perez', 0, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '', ''),
(24, 1, 'weqw', 'qwqwewe', 12, 'qwewqe', 1, '47330931J', 'Carlos', 'Ramos Torres', 'carlosrt1994@gmail.com', '$2y$10$pDtQ.HcmDfrcDbZzDQDO5On4A/h3OK5GKP2h2l4QNA.b42/hXTFWe', 1, 'BgIYZuU4j6X3xzWMeZMVp3AxDMZogV09fEIISSYKZeZ94bAgKAKAJ4cMDD6o', '2016-05-05 08:29:11', '2016-05-05 08:29:11', 1, '', ' '),
(27, 1, 'qwr', 'wer', 135, 'wer', 1, '12345678m', 'orlando david', 'Lucero Escobar', 'orlandodavidlucero@gmail.com', '$2y$10$zCCauZLvrA0LK7xECvEWU.8p9qDKpHR5ZlYA39EFMaFZUtW5K.4RK', 1, '0R1yBKIxa9BYAzGD881EaNHDeSx9P0DywkTnYdCbaJa4NchW98LWXqUZlies', '2016-05-05 05:27:39', '2016-05-05 05:27:39', 1, '', ' '),
(28, NULL, NULL, NULL, NULL, NULL, 1, '45698745A', 'Ainhoa', 'Perez', 'killua_141@hotmail.com', '$2y$10$y2XlNjlEIe7H6jEKpAd4yeKpOj98f4vQv.Y/MhTusXnxHNE7CF7o2', 0, 'ML6VeovE3Fj3NulTL7XAs8N79NJnOJzvhccLhEo4WPFGvLqVEoI5EYteSbxC', '2016-05-10 00:55:23', '2016-05-10 00:55:23', 1, '', ''),
(29, NULL, NULL, NULL, NULL, NULL, 0, '45512548N', 'Tomas', 'Turbao', 'tomasturbao@gmail.es', '$2y$10$gqf8xm2PVCrkg7j.6D/nue/BU14bg16hWrDegpSnQp3B5PIO0QXO6', 0, NULL, '2016-05-10 04:38:09', '2016-05-10 04:38:09', 1, 'c0b3d056d19d6b0426cfd425e97ce716', ' '),
(30, NULL, NULL, NULL, NULL, NULL, 0, '37738437S', 'Roser', 'Massana', 'rosjaum@gmail.com', '$2y$10$ah02Bu3T9uJBbHn/EM1EG.KSrp6FSSWMKlLfRbIYELAjXDVX9vuOS', 0, 'uq41rvvNixTk0Fbu1j23sFCRtA1sw8E4kvLY0eM4HaQV9TmYR34iRtUYeBKV', '2016-05-12 02:04:45', '2016-05-12 02:04:45', 1, '', ' ');

--
-- Disparadores `usuarios`
--
DROP TRIGGER IF EXISTS `nuevousuario`;
DELIMITER //
CREATE TRIGGER `nuevousuario` AFTER INSERT ON `usuarios`
 FOR EACH ROW IF new.chef = 1 then 
INSERT INTO chef (id_usuario,dnichef) VALUES (new.id,new.dni);
ELSEIF new.chef = 0 THEN
INSERT INTO cliente (id_usuario,dnicliente) VALUES (new.id,new.dni);
END IF
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `video`
--

CREATE TABLE IF NOT EXISTS `video` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_chef` int(10) unsigned NOT NULL,
  `archivovideos` varchar(150) NOT NULL,
  `fecha` date NOT NULL,
  `descripcion` varchar(700) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
