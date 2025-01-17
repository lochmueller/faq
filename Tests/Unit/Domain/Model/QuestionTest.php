<?php

declare(strict_types = 1);
/**
 * QuestionTest.
 */

namespace HDNET\Faq\Tests\Unit\Domain\Model;

use HDNET\Faq\Domain\Model\Question;

/**
 * QuestionTest.
 *
 * @internal
 * @coversNothing
 */
class QuestionTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var Question
     */
    protected $fileDomainModelInstance;

    /**
     * Setup.
     */
    protected function setUp()
    {
        $this->fileDomainModelInstance = new Question();
    }

    public function testTitleCanBeSet()
    {
        $title = 'This is the title';
        $this->fileDomainModelInstance->setTitle($title);
        $this->assertSame($title, $this->fileDomainModelInstance->getTitle());
    }
}
