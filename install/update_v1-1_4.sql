ALTER TABLE `projects`
    ADD `default_assignee` bigint(20) unsigned NULL;
ALTER TABLE `projects_issues`
	ADD `time_quote` bigint(20) default 0 ;
CREATE TABLE IF NOT EXISTS `projects_notes` (
  `id` bigint(20) NOT NULL auto_increment,
  `created_by` bigint(20) default '0',
  `project_id` bigint(20) default NULL,
  `body` text character set UTF8,
  `created_at` datetime default NULL,
  `updated_at` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT IGNORE INTO `activity` (`id`, `description`, `activity`)
VALUES (6,'Note on a project','note');
