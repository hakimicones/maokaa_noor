ALTER TABLE `sliders`
  ADD COLUMN IF NOT EXISTS `subtitle` varchar(500) DEFAULT NULL AFTER `label`,
  ADD COLUMN IF NOT EXISTS `text_position` varchar(20) NOT NULL DEFAULT 'center' AFTER `image`;
