<?php
/**
 * QuestioncategoryTest
 */

namespace HDNET\Faq\Tests\Unit\Domain\Model;

use HDNET\Faq\Domain\Model\Questioncategory;

/**
 * QuestioncategoryTest
 */
class QuestioncategoryTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{

    /**
     * @var Questioncategory
     */
    protected $fileDomainModelInstance;

    /**
     * Setup
     *
     * @return void
     */
    protected function setUp()
    {
        $this->fileDomainModelInstance = new Questioncategory();
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
