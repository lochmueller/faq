CREATE TABLE tx_faq_mm_question_questioncategory (
	uid int(11) NOT NULL auto_increment,
  PRIMARY KEY (uid),
	KEY parent (pid)
);
