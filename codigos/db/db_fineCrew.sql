-- MySQL Script generated by MySQL Workbench
-- Wed Nov 17 17:17:46 2021
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema db_fineCrew
-- -----------------------------------------------------

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
  `status_usuario` ENUM('ATIVO', 'INATIVO') NOT NULL,
  PRIMARY KEY (`id_usuario`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_fineCrew`.`produto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_fineCrew`.`produto` (
  `id_produto` INT NOT NULL AUTO_INCREMENT,
  `nome_produto` VARCHAR(75) NOT NULL,
  `categoria_produto` VARCHAR(75) NOT NULL,
  `quantidade_produto` VARCHAR(100) NOT NULL,
  `entrega_produto` DATE NOT NULL,
  `validade_produto` DATE NOT NULL,
  `observacao_produto` VARCHAR(300) NOT NULL,
  `usuarios_id_usuario` INT NOT NULL,
  PRIMARY KEY (`id_produto`),
  UNIQUE INDEX `nome_produto_UNIQUE` (`nome_produto` ASC) VISIBLE,
  INDEX `fk_produto_usuarios_idx` (`usuarios_id_usuario` ASC) VISIBLE,
  CONSTRAINT `fk_produto_usuarios`
    FOREIGN KEY (`usuarios_id_usuario`)
    REFERENCES `db_fineCrew`.`usuarios` (`id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_fineCrew`.`categorias_de_produtos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_fineCrew`.`categorias_de_produtos` (
  `id_categoria` INT NOT NULL AUTO_INCREMENT,
  `nome_categoria` VARCHAR(75) NOT NULL,
  `usuarios_id_usuario` INT NOT NULL,
  `produto_id_produto` INT NOT NULL,
  PRIMARY KEY (`id_categoria`),
  UNIQUE INDEX `nome_categoria_UNIQUE` (`nome_categoria` ASC) VISIBLE,
  INDEX `fk_categorias_de_produtos_usuarios1_idx` (`usuarios_id_usuario` ASC) VISIBLE,
  INDEX `fk_categorias_de_produtos_produto1_idx` (`produto_id_produto` ASC) VISIBLE,
  CONSTRAINT `fk_categorias_de_produtos_usuarios1`
    FOREIGN KEY (`usuarios_id_usuario`)
    REFERENCES `db_fineCrew`.`usuarios` (`id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_categorias_de_produtos_produto1`
    FOREIGN KEY (`produto_id_produto`)
    REFERENCES `db_fineCrew`.`produto` (`id_produto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
