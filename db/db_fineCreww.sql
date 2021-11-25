-- -----------------------------------------------------
-- Schema db_fineCrew
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `db_fineCrew` DEFAULT CHARACTER SET utf8 ;
USE `db_fineCrew` ;

-- -----------------------------------------------------
-- Table `db_fineCrew`.`usuarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_fineCrew`.`usuarios` (
  `id_usuario` INT NOT NULL AUTO_INCREMENT,
  `username_usuario` VARCHAR(75) NOT NULL,
  `senha_usuario` VARCHAR(75) NOT NULL,
  `nivel_usuario` INT NOT NULL,
  `status_usuario` BINARY NOT NULL,
  `id_requisicao` INT NOT NULL,
  PRIMARY KEY (`id_usuario`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `db_fineCrew`.`categorias_de_produtos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_fineCrew`.`categorias_de_produtos` (
  `id_categoria` INT NOT NULL AUTO_INCREMENT,
  `nome_categoria` VARCHAR(75) NOT NULL,
  PRIMARY KEY (`id_categoria`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `db_fineCrew`.`produto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_fineCrew`.`produto` (
  `id_produto` INT NOT NULL AUTO_INCREMENT,
  `nome_produto` VARCHAR(75) NOT NULL,
  `categoria_produto` VARCHAR(75) NOT NULL,
  `quantidade_produto` FLOAT NOT NULL,
  `entrega_produto` DATE NOT NULL,
  `validade_produto` DATE NOT NULL,
  `observacao_produto` TEXT(200) NOT NULL,
  `id_categoria` INT NOT NULL,
  PRIMARY KEY (`id_produto`),
  CONSTRAINT `fk_produto_categorias_de_produtos1`
    FOREIGN KEY (`id_categoria`)
    REFERENCES `db_fineCrew`.`categorias_de_produtos` (`id_categoria`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `db_fineCrew`.`requisicao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_fineCrew`.`requisicao` (
  `id_requisicao` INT NOT NULL,
  `data_requisicao` DATE NOT NULL,
  `id_produto` INT NULL,
  `id_usuario` INT NOT NULL,
  PRIMARY KEY (`id_requisicao`, `id_usuario`),
  CONSTRAINT `fk_requisicao_usuarios1`
    FOREIGN KEY (`id_usuario`)
    REFERENCES `db_fineCrew`.`usuarios` (`id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `db_fineCrew`.`requisicao_produto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_fineCrew`.`requisicao_produto` (
  `id` INT NOT NULL,
  `quantidade` FLOAT NOT NULL,
  `id_requisicao` INT NOT NULL,
  `id_produto` INT NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_requisicao_has_produto_requisicao1`
    FOREIGN KEY (`id_requisicao`)
    REFERENCES `db_fineCrew`.`requisicao` (`id_requisicao`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_requisicao_has_produto_produto1`
    FOREIGN KEY (`id_produto`)
    REFERENCES `db_fineCrew`.`produto` (`id_produto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `db_fineCrew`.`grupo_usuarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_fineCrew`.`grupo_usuarios` (
  `id_grupo` INT NOT NULL AUTO_INCREMENT,
  `nome_grupo` VARCHAR(45) NOT NULL,
  `nivel_grupo` INT NOT NULL,
  PRIMARY KEY (`id_grupo`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `db_fineCrew`.`usarios_grupos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_fineCrew`.`usarios_grupos` (
  `id` INT NOT NULL,
  `id_grupo` INT NOT NULL,
  `id_usuario` INT NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_GrupoDeUsuarios_has_usuarios_GrupoDeUsuarios1`
    FOREIGN KEY (`id_grupo`)
    REFERENCES `db_fineCrew`.`grupo_usuarios` (`id_grupo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_GrupoDeUsuarios_has_usuarios_usuarios1`
    FOREIGN KEY (`id_usuario`)
    REFERENCES `db_fineCrew`.`usuarios` (`id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `db_fineCrew`.`controle`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_fineCrew`.`controle` (
  `id_controle` INT NOT NULL,
  `dataCriacao_controle` DATE NOT NULL,
  `observacao_controle` TEXT(200) NULL,
  `id_usuario` INT NOT NULL,
  PRIMARY KEY (`id_controle`, `id_usuario`),
  CONSTRAINT `fk_controle_usuarios1`
    FOREIGN KEY (`id_usuario`)
    REFERENCES `db_fineCrew`.`usuarios` (`id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `db_fineCrew`.`controle_produto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_fineCrew`.`controle_produto` (
  `id` INT NOT NULL,
  `id_controle` INT NOT NULL,
  `id_produto` INT NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_controle_has_produto_controle1`
    FOREIGN KEY (`id_controle`)
    REFERENCES `db_fineCrew`.`controle` (`id_controle`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_controle_has_produto_produto1`
    FOREIGN KEY (`id_produto`)
    REFERENCES `db_fineCrew`.`produto` (`id_produto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;
