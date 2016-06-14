<?php
/**
 * QuestionTest
 */

namespace HDNET\Faq\Tests\Unit\Domain\Model;

use HDNET\Faq\Domain\Model\Question;

/**
 * QuestionTest
 */
class QuestionTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{

    /**
     * @var Question
     */
    protected $fileDomainModelInstance;

    /**
     * Setup
     *
     * @return void
     */
    protected function setUp()
    {
        $this->fileDomainModelInstance = new Question();
    }

    /**
     * @test
     */
    public function titleCanBeSet()
    {
        $title = 'This is the title';
        $this->fileDomainModelInstance->setTitle($title);
        $this->assertEquals($title, $this->fileDomainModelInstance->getTitle());
    }
}
