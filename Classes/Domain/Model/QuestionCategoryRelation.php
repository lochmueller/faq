<?php

declare(strict_types = 1);
/**
 * Relation.
 */

namespace HDNET\Faq\Domain\Model;

use HDNET\Autoloader\Domain\Model\AbstractAdvancedRelation;

/**
 * Relation.
 *
 * @smartExclude EnableFields,Language,Workspaces
 * @db           tx_faq_mm_question_questioncategory
 */
class QuestionCategoryRelation extends AbstractAdvancedRelation
{
}
