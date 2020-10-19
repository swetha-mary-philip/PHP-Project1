-- Schema bookstore
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `bookstore` ;

-- -----------------------------------------------------
-- Schema bookstore
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `bookstore` DEFAULT CHARACTER SET utf8 ;
USE `bookstore` ;

-- -----------------------------------------------------
-- Table `bookstore`.`book_inventory`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `bookstore`.`book_inventory` ;

CREATE TABLE IF NOT EXISTS `bookstore`.`book_inventory` (
  `Book_ID` INT(11) NOT NULL AUTO_INCREMENT,
  `Name` VARCHAR(200) NOT NULL,
  `Available_Copies` INT(11) NOT NULL DEFAULT 0,
  `Price` DECIMAL(9,2) NOT NULL,
  `Created_Datetime` DATETIME NOT NULL,
  `Modified_Datetime` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  `Author` VARCHAR(45) NOT NULL,
  `Image_URL` VARCHAR(100) NULL DEFAULT NULL,
  PRIMARY KEY (`Book_ID`))
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `bookstore`.`customers`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `bookstore`.`customers` ;

CREATE TABLE IF NOT EXISTS `bookstore`.`customers` (
  `Customer_ID` INT(11) NOT NULL AUTO_INCREMENT,
  `First_Name` VARCHAR(45) NOT NULL,
  `Last_Name` VARCHAR(45) NULL DEFAULT NULL,
  `Email_Address` VARCHAR(45) NULL DEFAULT NULL,
  `PhoneNumber` INT(11) NULL DEFAULT NULL,
  `Created_Datetime` DATETIME NOT NULL,
  `Modified_Datetime` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  PRIMARY KEY (`Customer_ID`))
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `bookstore`.`bookinventoryorder`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `bookstore`.`bookinventoryorder` ;

CREATE TABLE IF NOT EXISTS `bookstore`.`bookinventoryorder` (
  `Order_ID` INT(11) NOT NULL AUTO_INCREMENT,
  `Order_Date` DATETIME NOT NULL,
  `Amount` DECIMAL(9,2) NOT NULL,
  `Customers_Customer_ID` INT(11) NOT NULL,
  `IsCancelled` TINYINT(4) NOT NULL DEFAULT 0,
  `Payment_Type` VARCHAR(45) NOT NULL,
  `Payment_Status` VARCHAR(45) NOT NULL,
  `Card_Number` BIGINT(14) NOT NULL,
  `Card_Holder_Name` VARCHAR(50) NOT NULL,
  `Card_Expirydate` INT(4) NOT NULL,
  PRIMARY KEY (`Order_ID`),
  INDEX `fk_Orders_Customers1_idx` (`Customers_Customer_ID` ASC) ,
  CONSTRAINT `fk_Orders_Customers1`
    FOREIGN KEY (`Customers_Customer_ID`)
    REFERENCES `bookstore`.`customers` (`Customer_ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `bookstore`.`customer_address`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `bookstore`.`customer_address` ;

CREATE TABLE IF NOT EXISTS `bookstore`.`customer_address` (
  `Address_ID` INT(11) NOT NULL AUTO_INCREMENT,
  `Address_Line1` VARCHAR(100) NOT NULL,
  `City` VARCHAR(45) NOT NULL,
  `ZIP_Code` VARCHAR(45) NOT NULL,
  `Province` VARCHAR(45) NOT NULL,
  `Country` VARCHAR(45) NOT NULL,
  `Customers_Customer_ID` INT(11) NOT NULL,
  `Created_Datetime` DATETIME NOT NULL,
  `Modified_Datetime` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  `Address_Line2` VARCHAR(100) NULL DEFAULT NULL,
  PRIMARY KEY (`Address_ID`),
  INDEX `fk_Customer_Address_Customers_idx` (`Customers_Customer_ID` ASC) ,
  CONSTRAINT `fk_Customer_Address_Customers`
    FOREIGN KEY (`Customers_Customer_ID`)
    REFERENCES `bookstore`.`customers` (`Customer_ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `bookstore`.`order_details`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `bookstore`.`order_details` ;

CREATE TABLE IF NOT EXISTS `bookstore`.`order_details` (
  `Order_details_ID` INT(11) NOT NULL AUTO_INCREMENT,
  `Copies` INT(11) NOT NULL,
  `Book_Inventory_Book_ID` INT(11) NOT NULL,
  `BookInventoryOrder_Order_ID` INT(11) NOT NULL,
  PRIMARY KEY (`Order_details_ID`),
  INDEX `fk_Order_details_Book_Inventory1_idx` (`Book_Inventory_Book_ID` ASC) ,
  INDEX `fk_Order_details_BookInventoryOrder1_idx` (`BookInventoryOrder_Order_ID` ASC) ,
  CONSTRAINT `fk_Order_details_BookInventoryOrder1`
    FOREIGN KEY (`BookInventoryOrder_Order_ID`)
    REFERENCES `bookstore`.`bookinventoryorder` (`Order_ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Order_details_Book_Inventory1`
    FOREIGN KEY (`Book_Inventory_Book_ID`)
    REFERENCES `bookstore`.`book_inventory` (`Book_ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8;

USE `bookstore` ;

-- -----------------------------------------------------
-- procedure SP_PLACE_ORDER
-- -----------------------------------------------------

USE `bookstore`;
DROP procedure IF EXISTS `bookstore`.`SP_PLACE_ORDER`;

DELIMITER $$
USE `bookstore`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_PLACE_ORDER`(
    IN firstname VARCHAR(45),
    IN lastname VARCHAR(45),
    IN email VARCHAR(45),
    IN address1 VARCHAR(100),
    IN address2 VARCHAR(100),
    IN phone INT,
    IN pin VARCHAR(45),
    IN city VARCHAR(45),
    IN province VARCHAR(45),
    IN country VARCHAR(45),
    IN payment_type VARCHAR(50),
    IN cardholdername VARCHAR(50),
    IN cardholdernumber BIGINT(14),
    IN expirydate INT(4),
    IN bookid INT,
    IN amount decimal(9,2),
    IN copies INT
)
BEGIN

	DECLARE customer_id INT;
    DECLARE order_id INT;
    DECLARE hasError TINYINT DEFAULT FALSE;
    
    DECLARE CONTINUE HANDLER FOR SQLEXCEPTION 
	SET hasError = TRUE;
	SET SQL_SAFE_UPDATES = 0;

    START TRANSACTION;
    
    -- customer details
    INSERT INTO `bookstore`.`customers` (`First_Name`, `Last_Name`,`Email_Address`,`PhoneNumber`,`Created_Datetime`)
	VALUES (firstname, lastname, email, phone, now());
    SELECT LAST_INSERT_ID() into customer_id;

   -- customer address
	INSERT INTO `bookstore`.`customer_address` (`Address_Line1`, `City`,`ZIP_Code`,`Province`,`Country`,`Customers_Customer_ID`,`Created_Datetime`,`Address_Line2`)
	VALUES (address1, city,pin,province,country,customer_id,now(),address2);

	-- order table
    INSERT INTO `bookstore`.`bookinventoryorder` (`Order_Date`,`Amount`,`Customers_Customer_ID`,`IsCancelled`,`Payment_Type`,`Payment_Status`,`Card_Number`,`Card_Holder_Name`, `Card_Expirydate`)
	VALUES (now(),amount,customer_id,0,payment_type,'Success',cardholdernumber,cardholdername, expirydate);
	SELECT LAST_INSERT_ID() into order_id;
    
    -- order details table
    INSERT INTO `bookstore`.`order_details`(`Copies`, `Book_Inventory_Book_ID`,`BookInventoryOrder_Order_ID`)
	VALUES (copies,bookid,order_id);
    
    IF hasError = FALSE THEN
	COMMIT;
	ELSE
	ROLLBACK;
	END IF;

END$$

DELIMITER ;
USE `bookstore`;

DELIMITER $$

USE `bookstore`$$
DROP TRIGGER IF EXISTS `bookstore`.`Book_Copies` $$
USE `bookstore`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `bookstore`.`Book_Copies`
AFTER INSERT ON `bookstore`.`order_details`
FOR EACH ROW
BEGIN
DECLARE copies_available int default 0;
DECLARE remaining_copies int default 0;

SET copies_available = (select available_copies FROM book_inventory WHERE Book_ID = NEW.Book_Inventory_Book_ID);
set remaining_copies = (copies_available - New.Copies);

IF copies_available = 0 THEN
SIGNAL SQLSTATE 'HY000'
SET MESSAGE_TEXT = 'No copies available for this book';
ELSE
update book_inventory set available_copies = remaining_copies where Book_ID = NEW.Book_Inventory_Book_ID;
END IF;
END$$
DELIMITER ;

