-- Create majors table
CREATE TABLE `majors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `major_name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert majors
INSERT INTO `majors` (`id`, `major_name`) VALUES
(1, 'PPLG'),
(2, 'AKL'),
(3, 'MPLB'),
(4, 'PM'),
(5, 'FS'),
(6, 'TE'),
(7, 'AP'),
(8, 'TJKT');

-- Add major_id to classes table
ALTER TABLE `classes` ADD `major_id` INT(11) NULL AFTER `class_name`;

-- Update existing classes with PPLG major_id
UPDATE `classes` SET `major_id` = 1 WHERE `major` = 'PPLG';

-- Make major_id NOT NULL
ALTER TABLE `classes` CHANGE `major_id` `major_id` INT(11) NOT NULL;

-- Add foreign key constraint
ALTER TABLE `classes` ADD CONSTRAINT `classes_ibfk_2` FOREIGN KEY (`major_id`) REFERENCES `majors` (`id`);

-- Drop the old major column
ALTER TABLE `classes` DROP `major`;
