-- Host: localhost
-- Generation Time: Jan 18, 2016 at 11:37 AM
-- Server version: 5.6.27-0ubuntu1
-- PHP Version: 5.6.11-1ubuntu3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `yii2advanced`
--

--
-- Dumping data for table `religion`
--
CREATE TABLE religion (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    created_at INT UNSIGNED DEFAULT NULL,
    updated_at INT UNSIGNED DEFAULT NULL,
    deleted_at INT UNSIGNED DEFAULT NULL,
    created_by INT DEFAULT NULL,
    updated_by INT DEFAULT NULL,
    deleted_by INT DEFAULT NULL
);

INSERT INTO 
	`religion`
	(`id`, `name`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`)
VALUES
	(1, 'Islam', NULL, NULL, NULL, 1, 1, NULL),
	(2, 'Kristen', NULL, NULL, NULL, 1, 1, NULL),
	(3, 'Katolik', NULL, NULL, NULL, 1, 1, NULL),
	(4, 'Hindu', NULL, NULL, NULL, 1, 1, NULL),
	(5, 'Budha', NULL, NULL, NULL, 1, 1, NULL),
	(6, 'Kong hu cu', NULL, NULL, NULL, 1, 1, NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
