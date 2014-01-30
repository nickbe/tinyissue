ALTER TABLE `projects`
    ADD `default_assignee` bigint(20) unsigned NULL;
ALTER TABLE `projects_issues`
	ADD `time_quote` bigint(20) default 0 ;
