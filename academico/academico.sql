-- ============================================================
--  Sistema Acadêmico — Banco de Dados Completo
--  100 alunos | 10 professores | 5 turmas
-- ============================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
SET NAMES utf8mb4;

CREATE DATABASE IF NOT EXISTS `academico`
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_general_ci;
USE `academico`;

-- ------------------------------------------------------------
--  Drops (ordem inversa de dependência)
-- ------------------------------------------------------------
DROP TABLE IF EXISTS `itemturma`;
DROP TABLE IF EXISTS `turma`;
DROP TABLE IF EXISTS `disciplina`;
DROP TABLE IF EXISTS `alunos`;
DROP TABLE IF EXISTS `professor`;
DROP TABLE IF EXISTS `cursos`;

-- ------------------------------------------------------------
--  Tabela: cursos
-- ------------------------------------------------------------
CREATE TABLE `cursos` (
  `idcurso`   INT(5)      NOT NULL AUTO_INCREMENT,
  `nomecurso` VARCHAR(80) NOT NULL,
  PRIMARY KEY (`idcurso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `cursos` VALUES
(1,'Sistemas de Informação'),
(2,'Engenharia de Software'),
(3,'Ciência da Computação'),
(4,'Análise e Desenvolvimento de Sistemas'),
(5,'Banco de Dados');

-- ------------------------------------------------------------
--  Tabela: professor (10 registros)
-- ------------------------------------------------------------
CREATE TABLE `professor` (
  `idprofessor`   INT(5)       NOT NULL AUTO_INCREMENT,
  `nomeprofessor` VARCHAR(80)  NOT NULL,
  `cpf`           CHAR(14)     NOT NULL,
  `email`         VARCHAR(100) NOT NULL,
  `telefone`      VARCHAR(20)  DEFAULT NULL,
  `titulacao`     VARCHAR(50)  DEFAULT NULL,
  `especialidade` VARCHAR(100) DEFAULT NULL,
  `data_admissao` DATE         DEFAULT NULL,
  `ativo`         TINYINT(1)   NOT NULL DEFAULT 1,
  PRIMARY KEY (`idprofessor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `professor`
  (`idprofessor`,`nomeprofessor`,`cpf`,`email`,`telefone`,`titulacao`,`especialidade`,`data_admissao`,`ativo`)
VALUES
(1, 'Carlos Silva',      '111.111.111-11','carlos.silva@academico.edu.br',   '(11)91111-1111','Doutor',      'Banco de Dados',           '2018-02-01',1),
(2, 'Ana Souza',         '222.222.222-22','ana.souza@academico.edu.br',      '(11)92222-2222','Mestre',      'Programação Web',           '2019-08-15',1),
(3, 'Marcos Lima',       '333.333.333-33','marcos.lima@academico.edu.br',    '(21)93333-3333','Doutor',      'Estruturas de Dados',       '2017-03-10',1),
(4, 'Fernanda Costa',    '444.444.444-44','fernanda.costa@academico.edu.br', '(31)94444-4444','Especialista','Engenharia de Software',    '2020-01-20',1),
(5, 'Juliana Alves',     '555.555.555-55','juliana.alves@academico.edu.br',  '(11)95555-5555','Doutora',     'Análise de Sistemas',       '2016-07-05',1),
(6, 'Roberto Nunes',     '666.666.666-66','roberto.nunes@academico.edu.br',  '(41)96666-6666','Mestre',      'Inteligência Artificial',   '2021-03-01',1),
(7, 'Patrícia Mendes',   '777.777.777-77','patricia.mendes@academico.edu.br','(11)97777-7777','Doutora',     'Redes de Computadores',     '2015-09-12',1),
(8, 'Eduardo Rocha',     '888.888.888-88','eduardo.rocha@academico.edu.br',  '(85)98888-8888','Especialista','Segurança da Informação',   '2022-02-14',1),
(9, 'Camila Ferreira',   '999.999.999-99','camila.ferreira@academico.edu.br','(51)99999-9999','Mestre',      'Algoritmos e Complexidade', '2019-11-20',1),
(10,'Thiago Barbosa',    '000.000.000-00','thiago.barbosa@academico.edu.br', '(62)90000-0000','Doutor',      'Sistemas Operacionais',     '2014-04-30',1);

-- ------------------------------------------------------------
--  Tabela: disciplina
-- ------------------------------------------------------------
CREATE TABLE `disciplina` (
  `iddisciplina`   INT(5)      NOT NULL AUTO_INCREMENT,
  `nomedisciplina` VARCHAR(80) NOT NULL,
  `idcurso`        INT(5)      NOT NULL,
  `idprofessor`    INT(5)      NOT NULL,
  PRIMARY KEY (`iddisciplina`),
  KEY `idcurso`    (`idcurso`),
  KEY `idprofessor`(`idprofessor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `disciplina` VALUES
(1,'Banco de Dados I',          5,1),
(2,'Programação Web',           1,2),
(3,'Estruturas de Dados',       3,3),
(4,'Engenharia de Software I',  2,4),
(5,'Análise de Sistemas',       4,5),
(6,'Inteligência Artificial',   3,6),
(7,'Redes de Computadores',     1,7),
(8,'Segurança da Informação',   2,8),
(9,'Algoritmos',                3,9),
(10,'Sistemas Operacionais',    1,10);

-- ------------------------------------------------------------
--  Tabela: turma (5 turmas)
-- ------------------------------------------------------------
CREATE TABLE `turma` (
  `idturma`      INT(5)      NOT NULL AUTO_INCREMENT,
  `nometurma`    VARCHAR(80) NOT NULL,
  `iddisciplina` INT(5)      NOT NULL,
  `semestre`     INT(1)      NOT NULL,
  `ano`          INT(4)      NOT NULL,
  PRIMARY KEY (`idturma`),
  KEY `iddisciplina` (`iddisciplina`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `turma` VALUES
(1,'Turma A — Banco de Dados',        1,1,2026),
(2,'Turma B — Programação Web',       2,1,2026),
(3,'Turma C — Estruturas de Dados',   3,2,2025),
(4,'Turma D — Eng. de Software',      4,2,2025),
(5,'Turma E — Análise de Sistemas',   5,1,2026);

-- ------------------------------------------------------------
--  Tabela: alunos (100 registros)
-- ------------------------------------------------------------
CREATE TABLE `alunos` (
  `ra`        INT(16)      NOT NULL AUTO_INCREMENT,
  `nome`      VARCHAR(80)  NOT NULL,
  `cpf`       CHAR(14)     NOT NULL,
  `email`     VARCHAR(100) NOT NULL,
  `telefone`  VARCHAR(20)  DEFAULT NULL,
  `data_nasc` DATE         DEFAULT NULL,
  `endereco`  VARCHAR(150) DEFAULT NULL,
  `cidade`    VARCHAR(60)  DEFAULT NULL,
  `uf`        CHAR(2)      DEFAULT NULL,
  `ativo`     TINYINT(1)   NOT NULL DEFAULT 1,
  PRIMARY KEY (`ra`)
) ENGINE=InnoDB AUTO_INCREMENT=1001 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `alunos`
  (`ra`,`nome`,`cpf`,`email`,`telefone`,`data_nasc`,`endereco`,`cidade`,`uf`,`ativo`)
VALUES
(1001,'João Pedro Silva',       '123.456.789-00','joao.pedro@academico.edu.br',      '(11)91234-5678','2002-03-15','Rua das Flores, 123',     'São Paulo',       'SP',1),
(1002,'Maria Clara Souza',      '234.567.890-11','maria.clara@academico.edu.br',     '(11)92345-6789','2001-07-22','Av. Paulista, 456',       'São Paulo',       'SP',1),
(1003,'Lucas Santos',           '345.678.901-22','lucas.santos@academico.edu.br',    '(11)93456-7890','2003-01-10','Rua do Ipiranga, 789',    'São Paulo',       'SP',1),
(1004,'Beatriz Oliveira',       '456.789.012-33','beatriz.oliveira@academico.edu.br','(21)94567-8901','2002-11-05','Rua da Lapa, 321',        'Rio de Janeiro',  'RJ',1),
(1005,'Gabriel Rocha',          '567.890.123-44','gabriel.rocha@academico.edu.br',   '(31)95678-9012','2001-09-18','Av. Afonso Pena, 654',    'Belo Horizonte',  'MG',1),
(1006,'Larissa Ferreira',       '678.901.234-55','larissa.ferreira@academico.edu.br','(11)96789-0123','2003-05-30','Rua Augusta, 987',        'São Paulo',       'SP',1),
(1007,'Rafael Mendes',          '789.012.345-66','rafael.mendes@academico.edu.br',   '(51)97890-1234','2002-08-14','Rua dos Andradas, 111',   'Porto Alegre',    'RS',1),
(1008,'Amanda Lima',            '890.123.456-77','amanda.lima@academico.edu.br',     '(41)98901-2345','2001-04-25','Av. Sete de Setembro, 22','Curitiba',        'PR',1),
(1009,'Felipe Costa',           '901.234.567-88','felipe.costa@academico.edu.br',    '(85)99012-3456','2003-12-03','Rua Monsenhor Tabosa, 33','Fortaleza',       'CE',1),
(1010,'Isabela Nunes',          '012.345.678-99','isabela.nunes@academico.edu.br',   '(71)90123-4567','2002-06-17','Av. Oceânica, 44',        'Salvador',        'BA',1),
(1011,'Pedro Alves',            '111.222.333-44','pedro.alves@academico.edu.br',     '(62)91122-3344','2001-10-08','Rua 44, 55',              'Goiânia',         'GO',1),
(1012,'Camila Barbosa',         '222.333.444-55','camila.barbosa@academico.edu.br',  '(92)92233-4455','2003-02-19','Av. Eduardo Ribeiro, 66', 'Manaus',          'AM',1),
(1013,'Vinícius Carvalho',      '333.444.555-66','vinicius.carvalho@academico.edu.br','(81)93344-5566','2002-07-31','Rua da Aurora, 77',      'Recife',          'PE',1),
(1014,'Fernanda Dias',          '444.555.666-77','fernanda.dias@academico.edu.br',   '(91)94455-6677','2001-03-14','Tv. Padre Eutíquio, 88',  'Belém',           'PA',1),
(1015,'Thiago Gomes',           '555.666.777-88','thiago.gomes@academico.edu.br',    '(98)95566-7788','2003-09-26','Rua do Sol, 99',          'São Luís',        'MA',1),
(1016,'Natália Henrique',       '666.777.888-99','natalia.henrique@academico.edu.br','(86)96677-8899','2002-01-07','Av. Frei Serafim, 100',   'Teresina',        'PI',1),
(1017,'Rodrigo Ivo',            '777.888.999-00','rodrigo.ivo@academico.edu.br',     '(83)97788-9900','2001-05-20','Rua das Trincheiras, 110','João Pessoa',     'PB',1),
(1018,'Juliana Jardim',         '888.999.000-11','juliana.jardim@academico.edu.br',  '(84)98899-0011','2003-11-01','Av. Rio Branco, 120',     'Natal',           'RN',1),
(1019,'Bruno Leal',             '999.000.111-22','bruno.leal@academico.edu.br',      '(79)99900-1122','2002-04-13','Rua Itabaiana, 130',      'Aracaju',         'SE',1),
(1020,'Aline Macedo',           '000.111.222-33','aline.macedo@academico.edu.br',    '(82)90011-2233','2001-08-05','Av. Fernandes Lima, 140', 'Maceió',          'AL',1),
(1021,'Carlos Nascimento',      '111.333.555-77','carlos.nascimento@academico.edu.br','(27)91133-5577','2002-12-22','Av. Nossa Senhora da Penha, 150','Vitória',  'ES',1),
(1022,'Débora Oliveira',        '222.444.666-88','debora.oliveira@academico.edu.br', '(65)92244-6688','2003-03-04','Av. Isaac Póvoas, 160',   'Cuiabá',          'MT',1),
(1023,'Eduardo Prado',          '333.555.777-99','eduardo.prado@academico.edu.br',   '(67)93355-7799','2001-07-16','Av. Afonso Pena, 170',    'Campo Grande',    'MS',1),
(1024,'Flávia Queiroz',         '444.666.888-00','flavia.queiroz@academico.edu.br',  '(68)94466-8800','2002-09-28','Rua Epaminondas, 180',    'Rio Branco',      'AC',1),
(1025,'Gustavo Ramos',          '555.777.999-11','gustavo.ramos@academico.edu.br',   '(95)95577-9911','2003-06-09','Av. Brigadeiro Eduardo Gomes, 190','Boa Vista','RR',1),
(1026,'Helena Santos',          '666.888.000-22','helena.santos@academico.edu.br',   '(96)96688-0022','2001-02-21','Av. FAB, 200',            'Macapá',          'AP',1),
(1027,'Igor Teixeira',          '777.999.111-33','igor.teixeira@academico.edu.br',   '(63)97799-1133','2002-10-03','Rua 01, 210',             'Palmas',          'TO',1),
(1028,'Jéssica Uchoa',          '888.000.222-44','jessica.uchoa@academico.edu.br',   '(69)98800-2244','2003-07-15','Av. Lauro Sodré, 220',    'Porto Velho',     'RO',1),
(1029,'Kaique Viana',           '999.111.333-55','kaique.viana@academico.edu.br',    '(97)99911-3355','2001-11-27','Rua Coronel Prayinha, 230','Boa Vista',      'RR',1),
(1030,'Letícia Wanderley',      '000.222.444-66','leticia.wanderley@academico.edu.br','(48)90022-4466','2002-05-08','Rua Felipe Schmidt, 240', 'Florianópolis',   'SC',1),
(1031,'Mateus Xavier',          '111.444.777-00','mateus.xavier@academico.edu.br',   '(11)91144-7700','2003-08-20','Rua Haddock Lobo, 250',   'São Paulo',       'SP',1),
(1032,'Nathaly Yamaguchi',      '222.555.888-11','nathaly.yamaguchi@academico.edu.br','(11)92255-8811','2001-04-01','Av. Rebouças, 260',       'São Paulo',       'SP',1),
(1033,'Otávio Zanetti',         '333.666.999-22','otavio.zanetti@academico.edu.br',  '(21)93366-9922','2002-06-13','Rua Voluntários da Pátria, 270','Rio de Janeiro','RJ',1),
(1034,'Priscila Abreu',         '444.777.000-33','priscila.abreu@academico.edu.br',  '(31)94477-0033','2003-10-25','Rua Guaicurus, 280',      'Belo Horizonte',  'MG',1),
(1035,'Quésia Borges',          '555.888.111-44','quesia.borges@academico.edu.br',   '(51)95588-1144','2001-01-06','Av. Ipiranga, 290',       'Porto Alegre',    'RS',1),
(1036,'Renato Campos',          '666.999.222-55','renato.campos@academico.edu.br',   '(41)96699-2255','2002-03-18','Rua XV de Novembro, 300', 'Curitiba',        'PR',1),
(1037,'Sabrina Duarte',         '777.000.333-66','sabrina.duarte@academico.edu.br',  '(85)97700-3366','2003-05-30','Av. Beira Mar, 310',      'Fortaleza',       'CE',1),
(1038,'Tiago Esteves',          '888.111.444-77','tiago.esteves@academico.edu.br',   '(71)98811-4477','2001-09-11','Av. Sete de Setembro, 320','Salvador',       'BA',1),
(1039,'Ursula Farias',          '999.222.555-88','ursula.farias@academico.edu.br',   '(62)99922-5588','2002-11-23','Av. Goiás, 330',          'Goiânia',         'GO',1),
(1040,'Vitor Guedes',           '000.333.666-99','vitor.guedes@academico.edu.br',    '(92)90033-6699','2003-02-04','Av. Djalma Batista, 340', 'Manaus',          'AM',1),
(1041,'Wanessa Holanda',        '111.555.999-33','wanessa.holanda@academico.edu.br', '(81)91155-9933','2001-06-16','Rua da Palma, 350',       'Recife',          'PE',1),
(1042,'Xênia Ivo',              '222.666.000-44','xenia.ivo@academico.edu.br',       '(91)92266-0044','2002-08-28','Av. Almirante Barroso, 360','Belém',          'PA',1),
(1043,'Yago Júnior',            '333.777.111-55','yago.junior@academico.edu.br',     '(98)93377-1155','2003-01-09','Av. dos Holandeses, 370', 'São Luís',        'MA',1),
(1044,'Zara Klen',              '444.888.222-66','zara.klen@academico.edu.br',       '(86)94488-2266','2001-03-21','Rua Simplício Mendes, 380','Teresina',       'PI',1),
(1045,'André Lima',             '555.999.333-77','andre.lima@academico.edu.br',      '(83)95599-3377','2002-07-02','Rua Visconde de Pelotas, 390','João Pessoa', 'PB',1),
(1046,'Bianca Moura',           '666.000.444-88','bianca.moura@academico.edu.br',    '(84)96600-4488','2003-09-14','Av. Hermes da Fonseca, 400','Natal',          'RN',1),
(1047,'Caio Nóbrega',           '777.111.555-99','caio.nobrega@academico.edu.br',    '(79)97711-5599','2001-11-26','Av. Ivo do Prado, 410',   'Aracaju',         'SE',1),
(1048,'Diana Oliveira',         '888.222.666-00','diana.oliveira@academico.edu.br',  '(82)98822-6600','2002-02-07','Av. Fernandes Lima, 420', 'Maceió',          'AL',1),
(1049,'Enzo Peixoto',           '999.333.777-11','enzo.peixoto@academico.edu.br',    '(27)99933-7711','2003-04-19','Rua Chapot Presvot, 430', 'Vitória',         'ES',1),
(1050,'Fabíola Quint',          '000.444.888-22','fabiola.quint@academico.edu.br',   '(65)90044-8822','2001-08-01','Av. Mato Grosso, 440',    'Cuiabá',          'MT',1),
(1051,'Guilherme Rego',         '111.666.001-33','guilherme.rego@academico.edu.br',  '(67)91166-0133','2002-10-13','Av. Duque de Caxias, 450','Campo Grande',    'MS',1),
(1052,'Heloísa Serra',          '222.777.112-44','heloisa.serra@academico.edu.br',   '(68)92277-1244','2003-12-25','Rua Benjamin Constant, 460','Rio Branco',    'AC',1),
(1053,'Ivan Teles',             '333.888.223-55','ivan.teles@academico.edu.br',      '(95)93388-2355','2001-05-06','Av. Ville Roy, 470',      'Boa Vista',       'RR',1),
(1054,'Joana Ulhoa',            '444.999.334-66','joana.ulhoa@academico.edu.br',     '(96)94499-3466','2002-07-18','Rua Jovino Dinoá, 480',   'Macapá',          'AP',1),
(1055,'Kevin Vaz',              '555.000.445-77','kevin.vaz@academico.edu.br',       '(63)95500-4577','2003-09-30','Rua 04, 490',             'Palmas',          'TO',1),
(1056,'Luíza Werneck',          '666.111.556-88','luiza.werneck@academico.edu.br',   '(69)96611-5688','2001-01-11','Av. Sete de Setembro, 500','Porto Velho',    'RO',1),
(1057,'Marcelo Xavier',         '777.222.667-99','marcelo.xavier@academico.edu.br',  '(48)97722-6799','2002-03-23','Rua Trajano, 510',        'Florianópolis',   'SC',1),
(1058,'Nícolas Yunes',          '888.333.778-00','nicolas.yunes@academico.edu.br',   '(11)98833-7800','2003-06-04','Rua Oscar Freire, 520',   'São Paulo',       'SP',1),
(1059,'Olivia Zanini',          '999.444.889-11','olivia.zanini@academico.edu.br',   '(21)99944-8911','2001-08-16','Rua Dias Ferreira, 530',  'Rio de Janeiro',  'RJ',1),
(1060,'Paulo Assis',            '000.555.990-22','paulo.assis@academico.edu.br',     '(31)90055-9922','2002-10-28','Av. do Contorno, 540',    'Belo Horizonte',  'MG',1),
(1061,'Queila Braga',           '111.667.001-33','queila.braga@academico.edu.br',    '(51)91167-0133','2003-01-09','Av. Farrapos, 550',       'Porto Alegre',    'RS',1),
(1062,'Ricardo Cunha',          '222.778.112-44','ricardo.cunha@academico.edu.br',   '(41)92278-1244','2001-03-21','Rua das Flores, 560',     'Curitiba',        'PR',1),
(1063,'Sofia Dantas',           '333.889.223-55','sofia.dantas@academico.edu.br',    '(85)93389-2355','2002-05-02','Av. Santos Dumont, 570',  'Fortaleza',       'CE',1),
(1064,'Tadeu Espíndola',        '444.990.334-66','tadeu.espindola@academico.edu.br', '(71)94490-3466','2003-07-14','Av. ACM, 580',            'Salvador',        'BA',1),
(1065,'Úrsula Fonseca',         '555.001.445-77','ursula.fonseca@academico.edu.br',  '(62)95501-4577','2001-09-26','Rua 68, 590',             'Goiânia',         'GO',1),
(1066,'Valdecir Gama',          '666.112.556-88','valdecir.gama@academico.edu.br',   '(92)96612-5688','2002-12-07','Av. Torquato Tapajós, 600','Manaus',         'AM',1),
(1067,'Waleska Hora',           '777.223.667-99','waleska.hora@academico.edu.br',    '(81)97723-6799','2003-02-18','Rua do Bom Jesus, 610',   'Recife',          'PE',1),
(1068,'Xisto Ivo',              '888.334.778-00','xisto.ivo@academico.edu.br',       '(91)98834-7800','2001-04-30','Av. Governador José Malcher, 620','Belém',    'PA',1),
(1069,'Yasmin Jardim',          '999.445.889-11','yasmin.jardim@academico.edu.br',   '(98)99945-8911','2002-07-12','Rua Portugal, 630',       'São Luís',        'MA',1),
(1070,'Zuleika Kosloski',       '000.556.990-22','zuleika.kosloski@academico.edu.br','(86)90056-9922','2003-09-24','Av. João XXIII, 640',     'Teresina',        'PI',1),
(1071,'Alexandre Lacerda',      '111.778.002-44','alexandre.lacerda@academico.edu.br','(83)91178-0244','2001-11-05','Rua Duque de Caxias, 650','João Pessoa',    'PB',1),
(1072,'Bárbara Maia',           '222.889.113-55','barbara.maia@academico.edu.br',    '(84)92289-1355','2002-01-17','Av. Prudente de Morais, 660','Natal',         'RN',1),
(1073,'Cléber Neto',            '333.990.224-66','cleber.neto@academico.edu.br',     '(79)93390-2466','2003-03-29','Rua Itabaianinha, 670',   'Aracaju',         'SE',1),
(1074,'Daiane Omena',           '444.001.335-77','daiane.omena@academico.edu.br',    '(82)94401-3577','2001-06-10','Av. Gustavo Paiva, 680',  'Maceió',          'AL',1),
(1075,'Elias Pacheco',          '555.112.446-88','elias.pacheco@academico.edu.br',   '(27)95512-4688','2002-08-22','Av. Leitão da Silva, 690','Vitória',         'ES',1),
(1076,'Franciele Quirino',      '666.223.557-99','franciele.quirino@academico.edu.br','(65)96623-5799','2003-11-03','Rua Barão de Melgaço, 700','Cuiabá',        'MT',1),
(1077,'Gilson Rezende',         '777.334.668-00','gilson.rezende@academico.edu.br',  '(67)97734-6800','2001-01-15','Rua 26 de Agosto, 710',   'Campo Grande',    'MS',1),
(1078,'Hortência Santos',       '888.445.779-11','hortencia.santos@academico.edu.br','(68)98845-7911','2002-03-27','Rua Floriano Peixoto, 720','Rio Branco',     'AC',1),
(1079,'Iago Tito',              '999.556.880-22','iago.tito@academico.edu.br',       '(95)99956-8022','2003-06-08','Av. Capitão Ene Garcez, 730','Boa Vista',    'RR',1),
(1080,'Jaqueline Ungaretti',    '000.667.991-33','jaqueline.ungaretti@academico.edu.br','(96)90067-9133','2001-08-20','Av. Mendonça Furtado, 740','Macapá',      'AP',1),
(1081,'Kelvin Vargas',          '111.889.003-55','kelvin.vargas@academico.edu.br',   '(63)91189-0355','2002-10-01','Av. NS2, 750',            'Palmas',          'TO',1),
(1082,'Larisse Wills',          '222.990.114-66','larisse.wills@academico.edu.br',   '(69)92290-1466','2003-12-13','Rua Rogério Weber, 760',  'Porto Velho',     'RO',1),
(1083,'Murilo Xisto',           '333.001.225-77','murilo.xisto@academico.edu.br',    '(48)93301-2577','2001-02-24','Rua Victor Meireles, 770','Florianópolis',   'SC',1),
(1084,'Núbia Yamazaki',         '444.112.336-88','nubia.yamazaki@academico.edu.br',  '(11)94412-3688','2002-05-07','Rua Pamplona, 780',       'São Paulo',       'SP',1),
(1085,'Orlando Zago',           '555.223.447-99','orlando.zago@academico.edu.br',    '(21)95523-4799','2003-07-19','Rua Barão de Jaguaripe, 790','Rio de Janeiro','RJ',1),
(1086,'Patrícia Abreu',         '666.334.558-00','patricia.abreu@academico.edu.br',  '(31)96634-5800','2001-09-30','Rua Pouso Alegre, 800',   'Belo Horizonte',  'MG',1),
(1087,'Quirino Britto',         '777.445.669-11','quirino.britto@academico.edu.br',  '(51)97745-6911','2002-12-12','Rua Sarmento Leite, 810', 'Porto Alegre',    'RS',1),
(1088,'Rebeca Campos',          '888.556.770-22','rebeca.campos@academico.edu.br',   '(41)98856-7022','2003-02-23','Rua Madeira, 820',        'Curitiba',        'PR',1),
(1089,'Saulo Dantas',           '999.667.881-33','saulo.dantas@academico.edu.br',    '(85)99967-8133','2001-05-06','Rua Dragão do Mar, 830',  'Fortaleza',       'CE',1),
(1090,'Tatiana Esteves',        '000.778.992-44','tatiana.esteves@academico.edu.br', '(71)90078-9244','2002-07-18','Av. Paralela, 840',       'Salvador',        'BA',1),
(1091,'Ulisses Figueira',       '111.990.004-66','ulisses.figueira@academico.edu.br','(62)91190-0466','2003-09-29','Av. T-63, 850',           'Goiânia',         'GO',1),
(1092,'Vanessa Gonçalves',      '222.001.115-77','vanessa.goncalves@academico.edu.br','(92)92201-1577','2001-12-11','Av. André Araújo, 860',   'Manaus',          'AM',1),
(1093,'Wagner Holanda',         '333.112.226-88','wagner.holanda@academico.edu.br',  '(81)93312-2688','2002-02-22','Rua Imperial, 870',       'Recife',          'PE',1),
(1094,'Xênia Ignácio',          '444.223.337-99','xenia.ignacio@academico.edu.br',   '(91)94423-3799','2003-05-05','Rua Gaspar Viana, 880',   'Belém',           'PA',1),
(1095,'Yana Jales',             '555.334.448-00','yana.jales@academico.edu.br',      '(98)95534-4800','2001-07-17','Rua Oswaldo Cruz, 890',   'São Luís',        'MA',1),
(1096,'Zeno Keller',            '666.445.559-11','zeno.keller@academico.edu.br',     '(86)96645-5911','2002-09-28','Av. Frei Serafim, 900',   'Teresina',        'PI',1),
(1097,'Adriano Lira',           '777.556.660-22','adriano.lira@academico.edu.br',    '(83)97756-6022','2003-12-10','Av. Epitácio Pessoa, 910','João Pessoa',     'PB',1),
(1098,'Brenda Melo',            '888.667.771-33','brenda.melo@academico.edu.br',     '(84)98867-7133','2001-02-21','Rua Potengi, 920',        'Natal',           'RN',1),
(1099,'César Nóbrega',          '999.778.882-44','cesar.nobrega@academico.edu.br',   '(79)99978-8244','2002-05-04','Rua Santa Luzia, 930',    'Aracaju',         'SE',1),
(1100,'Daniela Omena',          '000.889.993-55','daniela.omena@academico.edu.br',   '(82)90089-9355','2003-07-16','Av. Comendador Leão, 940','Maceió',          'AL',1);

-- ------------------------------------------------------------
--  Tabela: itemturma — matrículas (20 alunos por turma)
-- ------------------------------------------------------------
CREATE TABLE `itemturma` (
  `iditem`  INT(11) NOT NULL AUTO_INCREMENT,
  `ra`      INT(16) NOT NULL,
  `idturma` INT(5)  NOT NULL,
  PRIMARY KEY (`iditem`),
  UNIQUE KEY `uq_ra_turma` (`ra`,`idturma`),
  KEY `ra`      (`ra`),
  KEY `idturma` (`idturma`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Turma 1 (ra 1001-1020)
INSERT INTO `itemturma` (`ra`,`idturma`) VALUES
(1001,1),(1002,1),(1003,1),(1004,1),(1005,1),
(1006,1),(1007,1),(1008,1),(1009,1),(1010,1),
(1011,1),(1012,1),(1013,1),(1014,1),(1015,1),
(1016,1),(1017,1),(1018,1),(1019,1),(1020,1);
-- Turma 2 (ra 1021-1040)
INSERT INTO `itemturma` (`ra`,`idturma`) VALUES
(1021,2),(1022,2),(1023,2),(1024,2),(1025,2),
(1026,2),(1027,2),(1028,2),(1029,2),(1030,2),
(1031,2),(1032,2),(1033,2),(1034,2),(1035,2),
(1036,2),(1037,2),(1038,2),(1039,2),(1040,2);
-- Turma 3 (ra 1041-1060)
INSERT INTO `itemturma` (`ra`,`idturma`) VALUES
(1041,3),(1042,3),(1043,3),(1044,3),(1045,3),
(1046,3),(1047,3),(1048,3),(1049,3),(1050,3),
(1051,3),(1052,3),(1053,3),(1054,3),(1055,3),
(1056,3),(1057,3),(1058,3),(1059,3),(1060,3);
-- Turma 4 (ra 1061-1080)
INSERT INTO `itemturma` (`ra`,`idturma`) VALUES
(1061,4),(1062,4),(1063,4),(1064,4),(1065,4),
(1066,4),(1067,4),(1068,4),(1069,4),(1070,4),
(1071,4),(1072,4),(1073,4),(1074,4),(1075,4),
(1076,4),(1077,4),(1078,4),(1079,4),(1080,4);
-- Turma 5 (ra 1081-1100)
INSERT INTO `itemturma` (`ra`,`idturma`) VALUES
(1081,5),(1082,5),(1083,5),(1084,5),(1085,5),
(1086,5),(1087,5),(1088,5),(1089,5),(1090,5),
(1091,5),(1092,5),(1093,5),(1094,5),(1095,5),
(1096,5),(1097,5),(1098,5),(1099,5),(1100,5);

-- ------------------------------------------------------------
--  Constraints
-- ------------------------------------------------------------
ALTER TABLE `disciplina`
  ADD CONSTRAINT `disc_curso` FOREIGN KEY (`idcurso`)     REFERENCES `cursos`    (`idcurso`),
  ADD CONSTRAINT `disc_prof`  FOREIGN KEY (`idprofessor`) REFERENCES `professor`  (`idprofessor`);

ALTER TABLE `turma`
  ADD CONSTRAINT `turma_disc` FOREIGN KEY (`iddisciplina`) REFERENCES `disciplina` (`iddisciplina`);

ALTER TABLE `itemturma`
  ADD CONSTRAINT `item_aluno` FOREIGN KEY (`ra`)      REFERENCES `alunos` (`ra`),
  ADD CONSTRAINT `item_turma` FOREIGN KEY (`idturma`) REFERENCES `turma`  (`idturma`);

COMMIT;
