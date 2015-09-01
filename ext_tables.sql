#
# Table structure for table 'tx_faq_mm_question_questioncategory'
#
CREATE TABLE tx_faq_mm_question_questioncategory (
	uid int(11) NOT NULL auto_increment,
	uid_local int(11) DEFAULT '0' NOT NULL,
	uid_foreign int(11) DEFAULT '0' NOT NULL,
	tablenames varchar(30) DEFAULT '' NOT NULL,
	sorting int(11) DEFAULT '0' NOT NULL,
	sorting_foreign int(11) DEFAULT '0' NOT NULL,
	ident varchar(30) DEFAULT '' NOT NULL,

	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign),
	PRIMARY KEY (uid)
);