CREATE TABLE IF NOT EXISTS #__myjspace (
	id int(11) NOT NULL DEFAULT 0,
	pagename VARCHAR(100) NOT NULL,
	content MEDIUMTEXT NULL,
	blockEdit TINYINT NOT NULL DEFAULT 0,
	blockView TINYINT NOT NULL DEFAULT 0,
	create_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	last_update_date TIMESTAMP,
	last_access_date TIMESTAMP,
	last_access_ip VARCHAR(39) NOT NULL DEFAULT '0',
	hits BIGINT NOT NULL DEFAULT 0,
    publish_up datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    publish_down datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
	metakey text NOT NULL DEFAULT '',
	template VARCHAR(50) NOT NULL DEFAULT '',
	UNIQUE idx_pagename (pagename),
	PRIMARY KEY (id)
	) ENGINE=MyISAM DEFAULT CHARSET=utf8;
			