<?php

declare(strict_types = 1);
/**
 * QuestionCategoryTest.
 */

namespace HDNET\Faq\Tests\Unit\Domain\Model;

use HDNET\Faq\Domain\Model\QuestionCategory;

/**
 * QuestionCategoryTest.
 *
 * @internal
 * @coversNothing
 */
class QuestionCategoryTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var QuestionCategory
     */
    protected $fileDomainModelInstance;

    /**
     * Setup.
     */
    protected function setUp()
    {
        $this->fileDomainModelInstance = new QuestionCategory();
    }

    public function testTitleCanBeSet()
    {
        $title = 'This is the title';
        $this->fileDomainModelInstance->setTitle($title);
        $this->assertSame($title, $this->fileDomainModelInstance->getTitle());
    }
}
