DROP TABLE IF EXISTS `#__blogger_items`;

DROP TABLE IF EXISTS `#__blogger_authors`;

DELETE FROM `#__content_types` WHERE (type_alias LIKE 'com_blogger.%');