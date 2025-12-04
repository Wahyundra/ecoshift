ALTER TABLE `schedule` ADD `status` ENUM('pending','completed','verified') NOT NULL DEFAULT 'pending' AFTER `task_description`;
