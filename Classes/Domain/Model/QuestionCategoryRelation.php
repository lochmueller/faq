<?php

declare(strict_types = 1);
/**
 * Relation.
 */

namespace HDNET\Faq\Domain\Model;

use HDNET\Autoloader\Annotation\DatabaseTable;
use HDNET\Autoloader\Annotation\SmartExclude;
use HDNET\Autoloader\Domain\Model\AbstractAdvancedRelation;

/**
 * Relation.
 *
 * @SmartExclude(excludes={"EnableFields", "Language", "Workspaces"})
 * @DatabaseTable(tableName="tx_faq_mm_question_questioncategory")
 */
class QuestionCategoryRelation extends AbstractAdvancedRelation
{
}
