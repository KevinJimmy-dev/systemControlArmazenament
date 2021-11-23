-- -----------------------------------------------------
-- Schema db_fineCrew
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `db_fineCrew` DEFAULT CHARACTER SET utf8 ;
USE `db_fineCrew` ;

-- -----------------------------------------------------
-- Table `db_fineCrew`.`requisicao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_fineCrew`.`requisicao` (
  `id_requisicao` INT NOT NULL,
  `data_requisicao` VARCHAR(45) NULL,
  `id_usuario` VARCHAR(45) NULL,
  `id_produto` VARCHAR(45) NULL,
  PRIMARY KEY (`id_requisicao`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_fineCrew`.`categorias_de_produtos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_fineCrew`.`categorias_de_produtos` (
  `id_categoria` INT NOT NULL AUTO_INCREMENT,
  `nome_categoria` VARCHAR(75) NOT NULL,
  `usuarios_id_usuario` INT NOT NULL,
  `usuarios_requisicao_id_requisicao` INT NOT NULL,
  `usuarios_produto_id_produto` INT NOT NULL,
  PRIMARY KEY (`id_categoria`, `usuarios_id_usuario`, `usuarios_requisicao_id_requisicao`, `usuarios_produto_id_produto`),
  UNIQUE INDEX `nome_categoria_UNIQUE` (`nome_categoria` ASC) VISIBLE,
  CONSTRAINT `fk_categorias_de_produtos_usuarios1`
    FOREIGN KEY (`usuarios_id_usuario` , `usuarios_requisicao_id_requisicao` , `usuarios_produto_id_produto`)
    REFERENCES `db_fineCrew`.`usuarios` (`id_usuario` , `requisicao_id_requisicao` , `produto_id_produto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
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
  `observacao_produto` VARCHAR(300) NOT NULL,
  `categorias_de_produtos_id_categoria` INT NOT NULL,
  PRIMARY KEY (`id_produto`),
  CONSTRAINT `fk_produto_categorias_de_produtos1`
    FOREIGN KEY (`categorias_de_produtos_id_categoria`)
    REFERENCES `db_fineCrew`.`categorias_de_produtos` (`id_categoria`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_fineCrew`.`usuarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_fineCrew`.`usuarios` (
  `id_usuario` INT NOT NULL AUTO_INCREMENT,
  `username_usuario` VARCHAR(75) NOT NULL,
  `senha_usuario` VARCHAR(75) NOT NULL,
  `nivel_usuario` INT NOT NULL,
  `status_usuario` BINARY NOT NULL,
  `requisicao_id_requisicao` INT NOT NULL,
  `produto_id_produto` INT NOT NULL,
  PRIMARY KEY (`id_usuario`, `requisicao_id_requisicao`, `produto_id_produto`),
  CONSTRAINT `fk_usuarios_requisicao1`
    FOREIGN KEY (`requisicao_id_requisicao`)
    REFERENCES `db_fineCrew`.`requisicao` (`id_requisicao`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuarios_produto1`
    FOREIGN KEY (`produto_id_produto`)
    REFERENCES `db_fineCrew`.`produto` (`id_produto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_fineCrew`.`requisicao_has_produto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_fineCrew`.`requisicao_has_produto` (
  `requisicao_id_requisicao` INT NOT NULL,
  `produto_id_produto` INT NOT NULL,
  PRIMARY KEY (`requisicao_id_requisicao`, `produto_id_produto`),
  CONSTRAINT `fk_requisicao_has_produto_requisicao1`
    FOREIGN KEY (`requisicao_id_requisicao`)
    REFERENCES `db_fineCrew`.`requisicao` (`id_requisicao`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_requisicao_has_produto_produto1`
    FOREIGN KEY (`produto_id_produto`)
    REFERENCES `db_fineCrew`.`produto` (`id_produto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_fineCrew`.`GrupoDeUsuarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_fineCrew`.`GrupoDeUsuarios` (
  `id_grupo` INT NOT NULL AUTO_INCREMENT,
  `nome_grupo` VARCHAR(45) NOT NULL,
  `nivel_grupo` INT NOT NULL,
  PRIMARY KEY (`id_grupo`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_fineCrew`.`GrupoDeUsuarios_has_usuarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_fineCrew`.`GrupoDeUsuarios_has_usuarios` (
  `GrupoDeUsuarios_id_grupo` INT NOT NULL,
  `usuarios_id_usuario` INT NOT NULL,
  PRIMARY KEY (`GrupoDeUsuarios_id_grupo`, `usuarios_id_usuario`),
  CONSTRAINT `fk_GrupoDeUsuarios_has_usuarios_GrupoDeUsuarios1`
    FOREIGN KEY (`GrupoDeUsuarios_id_grupo`)
    REFERENCES `db_fineCrew`.`GrupoDeUsuarios` (`id_grupo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_GrupoDeUsuarios_has_usuarios_usuarios1`
    FOREIGN KEY (`usuarios_id_usuario`)
    REFERENCES `db_fineCrew`.`usuarios` (`id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;