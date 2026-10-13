#
# The remaining columns (uid, pid, title, answer, categories, tstamp, crdate,
# deleted, hidden, starttime, endtime, sys_language_uid, l10n_parent, ...) are
# derived from TCA by the core's DefaultTcaSchema. Only the "sorting" column is
# declared here, because the repositories order by it even when manual sorting
# (ctrl.sortby) is disabled and would otherwise not be created.
#
CREATE TABLE tx_faq_domain_model_question (
    sorting int DEFAULT 0 NOT NULL
);

CREATE TABLE tx_faq_domain_model_questioncategory (
    sorting int DEFAULT 0 NOT NULL
);
