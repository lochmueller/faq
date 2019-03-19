<?php

declare(strict_types = 1);
/**
 * QuestioncategoryTest.
 */

namespace HDNET\Faq\Tests\Unit\Domain\Model;

use HDNET\Faq\Domain\Model\Questioncategory;

/**
 * QuestioncategoryTest.
 *
 * @internal
 * @coversNothing
 */
class QuestioncategoryTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var Questioncategory
     */
    protected $fileDomainModelInstance;

    /**
     * Setup.
     */
    protected function setUp()
    {
        $this->fileDomainModelInstance = new Questioncategory();
    }

    public function testTitleCanBeSet()
    {
        $title = 'This is the title';
        $this->fileDomainModelInstance->setTitle($title);
        $this->assertSame($title, $this->fileDomainModelInstance->getTitle());
    }
}
