-- Company Settings Table
CREATE TABLE IF NOT EXISTS `company_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(255) NOT NULL,
  `company_email` varchar(255) NOT NULL,
  `company_phone` varchar(50) DEFAULT NULL,
  `company_logo` varchar(255) DEFAULT NULL,
  `company_address` text DEFAULT NULL,
  `company_city` varchar(100) DEFAULT NULL,
  `company_state` varchar(100) DEFAULT NULL,
  `company_country` varchar(100) DEFAULT NULL,
  `company_postal_code` varchar(20) DEFAULT NULL,
  `registration_number` varchar(100) DEFAULT NULL,
  `tax_id` varchar(100) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `business_hours_start` time DEFAULT '09:00:00',
  `business_hours_end` time DEFAULT '17:00:00',
  `financial_year_start` date DEFAULT NULL,
  `financial_year_end` date DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Departments Table
CREATE TABLE IF NOT EXISTS `departments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `department_name` varchar(255) NOT NULL,
  `department_head` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Branches Table
CREATE TABLE IF NOT EXISTS `branches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_name` varchar(255) NOT NULL,
  `branch_code` varchar(50) NOT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `postal_code` varchar(20) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `manager` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `branch_code` (`branch_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Job Categories Table
CREATE TABLE IF NOT EXISTS `job_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Job Positions Table
CREATE TABLE IF NOT EXISTS `job_positions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `position_name` varchar(255) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `job_positions_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `job_categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert sample data
INSERT INTO `company_settings` (`company_name`, `company_email`, `company_phone`, `website`, `business_hours_start`, `business_hours_end`) 
VALUES ('Your Company Name', 'info@company.com', '+1-234-567-8900', 'https://www.company.com', '09:00:00', '17:00:00')
ON DUPLICATE KEY UPDATE `id`=`id`;

INSERT INTO `departments` (`department_name`, `department_head`, `description`) VALUES
('Human Resources', 'HR Manager', 'Manages recruitment, employee relations, and HR policies'),
('Information Technology', 'IT Manager', 'Manages technology infrastructure and software development'),
('Finance', 'Finance Manager', 'Handles financial planning, accounting, and budgeting'),
('Marketing', 'Marketing Manager', 'Manages marketing campaigns and brand strategy')
ON DUPLICATE KEY UPDATE `id`=`id`;

INSERT INTO `branches` (`branch_name`, `branch_code`, `city`, `state`, `country`, `phone`, `email`, `manager`) VALUES
('Head Office', 'HQ001', 'New York', 'NY', 'USA', '+1-234-567-8900', 'hq@company.com', 'John Doe'),
('Branch Office', 'BR001', 'Los Angeles', 'CA', 'USA', '+1-234-567-8901', 'la@company.com', 'Jane Smith')
ON DUPLICATE KEY UPDATE `id`=`id`;

INSERT INTO `job_categories` (`category_name`, `description`) VALUES
('Information Technology', 'Software development, IT support, and technology roles'),
('Engineering', 'Mechanical, electrical, civil, and other engineering positions'),
('Sales & Marketing', 'Sales representatives, marketing specialists, and business development'),
('Human Resources', 'HR managers, recruiters, and talent acquisition specialists'),
('Finance & Accounting', 'Accountants, financial analysts, and finance managers'),
('Operations', 'Operations managers, logistics, and supply chain roles'),
('Customer Service', 'Customer support, client relations, and service representatives'),
('Design & Creative', 'Graphic designers, UI/UX designers, and creative professionals')
ON DUPLICATE KEY UPDATE `id`=`id`;

-- Add u_status column if it doesn't exist (for user activation)
ALTER TABLE `users` ADD COLUMN IF NOT EXISTS `u_status` ENUM('Active', 'Inactive', 'Suspended') DEFAULT 'Active' AFTER `u_role`;

-- Update existing users to Active status
UPDATE `users` SET `u_status` = 'Active' WHERE `u_status` IS NULL OR `u_status` = '';

INSERT INTO `job_positions` (`position_name`, `category_id`, `description`) VALUES
('Software Engineer', 1, 'Develop and maintain software applications'),
('Frontend Developer', 1, 'Build user interfaces and client-side applications'),
('Backend Developer', 1, 'Develop server-side logic and databases'),
('Full Stack Developer', 1, 'Work on both frontend and backend development'),
('DevOps Engineer', 1, 'Manage infrastructure and deployment pipelines'),
('QA Engineer', 1, 'Test software and ensure quality standards'),
('Product Manager', 1, 'Define product strategy and roadmap'),
('UI/UX Designer', 8, 'Design user interfaces and experiences'),
('Sales Executive', 3, 'Drive sales and business development'),
('Marketing Manager', 3, 'Plan and execute marketing campaigns'),
('HR Manager', 4, 'Manage human resources and recruitment'),
('Accountant', 5, 'Handle financial records and reporting'),
('Operations Manager', 6, 'Oversee daily operations and processes'),
('Customer Support Representative', 7, 'Provide customer service and support')
ON DUPLICATE KEY UPDATE `id`=`id`;




-- Change column type
ALTER TABLE `users` MODIFY COLUMN `u_status` VARCHAR(20) DEFAULT 'Active';

-- Convert values
UPDATE `users` SET `u_status` = 'Active' WHERE `u_status` = '1';
UPDATE `users` SET `u_status` = 'Pending' WHERE `u_status` = '0';
UPDATE `users` SET `u_status` = 'Pending' WHERE `u_status` IS NULL OR `u_status` = '';



-- Step 1: Change column type to VARCHAR
ALTER TABLE `users` MODIFY COLUMN `u_status` VARCHAR(20) DEFAULT 'Active';

-- Step 2: Convert numeric values to strings
UPDATE `users` SET `u_status` = 'Active' WHERE `u_status` = '1';
UPDATE `users` SET `u_status` = 'Pending' WHERE `u_status` = '0';
UPDATE `users` SET `u_status` = 'Pending' WHERE `u_status` IS NULL OR `u_status` = '';

-- Step 3: Verify the changes
SELECT u_id, u_username, u_role, u_status FROM `users` ORDER BY u_id;


