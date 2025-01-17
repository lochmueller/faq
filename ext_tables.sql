#
# Table structure for table 'tx_faq_domain_model_question'
#

CREATE TABLE tx_faq_domain_model_question (
    uid INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    answer TEXT,
    tags VARCHAR(255) NOT NULL,
    categories INT DEFAULT 0,
    crdate INT,
    tstamp INT,
    deleted INT DEFAULT 0,
    hidden INT DEFAULT 0,
    starttime INT DEFAULT 0,
    endtime INT DEFAULT 0,
    sys_language_uid INT DEFAULT 0 NOT NULL,
    l10n_parent INT DEFAULT 0 NOT NULL,
    sorting int(11) DEFAULT 0 NOT NULL
);

CREATE TABLE tx_faq_domain_model_questioncategory (
    uid INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    parent INT DEFAULT 0,
    description TEXT,
    answer TEXT,
    crdate INT,
    tstamp INT,
    deleted INT DEFAULT 0,
    hidden INT DEFAULT 0,
    starttime INT DEFAULT 0,
    endtime INT DEFAULT 0,
    sys_language_uid INT DEFAULT 0 NOT NULL,
    l10n_parent INT DEFAULT 0 NOT NULL,
    sorting int(11) DEFAULT 0 NOT NULL

);

CREATE TABLE tx_faq_mm_question_questioncategory (
    uid_local INT NOT NULL,
    uid_foreign INT NOT NULL,
    PRIMARY KEY(uid_local, uid_foreign),
    FOREIGN KEY (uid_local) REFERENCES tx_faq_domain_model_question (uid) ON DELETE CASCADE,
    FOREIGN KEY (uid_foreign) REFERENCES tx_faq_domain_model_questioncategory (uid) ON DELETE CASCADE
);