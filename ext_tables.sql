#
# Table structure for table 'tx_faq_domain_model_question'
#

CREATE TABLE tx_faq_domain_model_question (
    uid INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    answer TEXT,
    crdate INT,
    tstamp INT,
    deleted INT DEFAULT 0,
    hidden INT DEFAULT 0,
    starttime INT DEFAULT 0,
    endtime INT DEFAULT 0
);

CREATE TABLE tx_faq_domain_model_questioncategory (
    uid INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    answer TEXT,
    crdate INT,
    tstamp INT,
    deleted INT DEFAULT 0,
    hidden INT DEFAULT 0,
    starttime INT DEFAULT 0,
    endtime INT DEFAULT 0
);

CREATE TABLE tx_faq_mm_question_questioncategory (
    uid_local INT,
    uid_foreign INT,
    PRIMARY KEY(uid_local, uid_foreign),
    FOREIGN KEY (uid_local) REFERENCES tx_faq_domain_model_question (uid),
    FOREIGN KEY (uid_foreign) REFERENCES tx_faq_domain_model_questioncategory (uid)
);
