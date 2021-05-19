DROP TABLE IF EXISTS `#__blogger_items`;

DELETE FROM `#__content_types` WHERE (type_alias LIKE 'com_blogger.%');