-- Fix User Status Values
-- This script converts old numeric status (0/1) to new string status (Pending/Active)

-- First, check the current u_status column type
-- If it's INT or TINYINT, we need to change it to VARCHAR

-- Change column type to VARCHAR if needed
ALTER TABLE `users` MODIFY COLUMN `u_status` VARCHAR(20) DEFAULT 'Active';

-- Convert numeric values to string values
-- 1 = Active (can login)
UPDATE `users` SET `u_status` = 'Active' WHERE `u_status` = '1';

-- 0 = Pending (cannot login, needs activation)
UPDATE `users` SET `u_status` = 'Pending' WHERE `u_status` = '0';

-- Set NULL or empty to Pending
UPDATE `users` SET `u_status` = 'Pending' WHERE `u_status` IS NULL OR `u_status` = '';

-- Verify the changes
SELECT u_id, u_username, u_role, u_status FROM `users` ORDER BY u_id;
