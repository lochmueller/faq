<?php
/**
 * Build up the Question
 *
 * @author     Tim Lochmüller
 */

namespace HDNET\Faq\Domain\Repository;

use HDNET\Faq\Domain\Model\Question;
use HDNET\Faq\Domain\Model\Questioncategory;
use HDNET\Faq\Domain\Model\Request\Faq;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

/**
 * Build up the Question
 */
class QuestionRepository extends AbstractRepository
{

    /**
     * Orderings
     *
     * @var array
     */
    protected $defaultOrderings = array(
        'title' => QueryInterface::ORDER_ASCENDING,
    );

    /**
     * Get the top questions
     *
     * @param int   $limit
     *
     * @param int   $topCategoryId
     *
     * @param array $topQuestions
     *
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findTop($limit = 5, $topCategoryId = 0, $topQuestions = array())
    {
        $questions = $this->getStaticQuestionsAndReduceLimit($topQuestions, $limit);
        if ($limit > 0) {
            $query = $this->createQuery();
            $constraintsOr = array();
            $constraintsOr[] = $query->contains('categories', $topCategoryId);
            $constraintsOr[] = $query->equals('categories.parent', $topCategoryId);

            $constraintsAnd = array();
            $constraintsAnd[] = $query->logicalOr($constraintsOr);
            $constraintsAnd[] = $query->logicalNot($query->in('uid', $topQuestions));

            $query->matching($query->logicalAnd($constraintsAnd));

            $query->setOrderings(array('topCounter' => QueryInterface::ORDER_DESCENDING));
            $query->setLimit($limit);
            $results = $query->execute()
                ->toArray();

            $questions = array_merge($questions, $results);
        }

        return $questions;
    }

    /**
     * Get the newest questions
     *
     * @param int $limit
     *
     * @param int $topCategoryId
     *
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findNewest($limit = 5, $topCategoryId = 0)
    {
        $query = $this->createQuery();

        $constraintsOr = array();
        $constraintsOr[] = $query->contains('categories', $topCategoryId);
        $constraintsOr[] = $query->equals('categories.parent', $topCategoryId);

        $query->matching($query->logicalOr($constraintsOr));

        $query->setOrderings(array('crdate' => QueryInterface::ORDER_DESCENDING));
        $query->setLimit($limit);
        return $query->execute();
    }

    /**
     * Returns all objects of this repository.
     *
     * @param int $topCategoryId
     *
     * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface|array
     */
    public function findAll($topCategoryId = 0)
    {
        if (!$topCategoryId) {
            return parent::findAll();
        } else {
            $query = $this->createQuery();

            $constraintsOr = array();
            $constraintsOr[] = $query->contains('categories', $topCategoryId);
            $constraintsOr[] = $query->equals('categories.parent', $topCategoryId);

            $query->matching($query->logicalOr($constraintsOr));
            return $query->execute();
        }
    }

    /**
     * Find by FAQ model
     *
     * @param Faq $faq
     * @param int $topCategoryId
     *
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findByFaq(Faq $faq, $topCategoryId = 0)
    {
        $query = $this->createQuery();

        $constraintsOr = array();
        $constraintsOr[] = $query->contains('categories', $topCategoryId);
        $constraintsOr[] = $query->equals('categories.parent', $topCategoryId);

        $constraints = array();
        $constraints[] = $query->logicalOr($constraintsOr);

        if ($faq->getCategory() instanceof Questioncategory) {
            $constraints[] = $query->contains('categories', $faq->getCategory()
                ->getUid());
        }

        if (strlen($faq->getSearchWord())) {
            $constraints[] = $query->logicalOr(array(
                $query->like('title', '%' . $faq->getSearchWord() . '%'),
                $query->like('answer', '%' . $faq->getSearchWord() . '%')
            ));
        }

        if (sizeof($constraints)) {
            $query->matching($query->logicalAnd($constraints));
        }

        return $query->execute();
    }

    /**
     * Get the teaser questions
     *
     * @param  array $topQuestions
     * @param array  $categories
     * @param int    $limit
     *
     * @return array
     */
    public function findByTeaserConfiguration(array $topQuestions, array $categories, $limit)
    {
        $questions = $this->getStaticQuestionsAndReduceLimit($topQuestions, $limit);
        if ($limit > 0) {
            $categories[] = 0;

            /** @var \TYPO3\CMS\Frontend\Page\PageRepository $pageRepository */
            $pageRepository = GeneralUtility::makeInstance('TYPO3\\CMS\\Frontend\\Page\\PageRepository');
            $t = $this->getTableName();

            $topExclude = '';
            if (sizeof($topQuestions)) {
                $topExclude = ' AND ' . $t . '.uid NOT IN (' . implode(',', $topQuestions) . ')';
            }
            $db = $GLOBALS['TYPO3_DB'];
            $rows = $db->exec_SELECTgetRows($t . '.*', $t . ',tx_hdnet_faq_mm_question_questioncategory',
                    $t . '.uid=tx_hdnet_faq_mm_question_questioncategory.uid_local AND tx_hdnet_faq_mm_question_questioncategory.uid_foreign IN (' . implode(',',
                        $categories) . ')' . $topExclude . $pageRepository->enableFields($t), $t . '.uid', 'RAND()', $limit);
            foreach ($rows as $row) {
                $q = $this->findByUid((int)$row['uid']);
                if ($q instanceof Question) {
                    $questions[] = $q;
                }
            }
        }
        return $questions;
    }

    /**
     * Get the Questsions with the given IDS and reduce the limit
     *
     * @param array $ids
     * @param int   $limit
     *
     * @return array
     */
    protected function getStaticQuestionsAndReduceLimit(array $ids, &$limit)
    {
        $questions = array();
        foreach ($ids as $id) {
            $q = $this->findByUid((int)$id);
            if ($q instanceof Question) {
                $questions[] = $q;
                $limit--;
            }
        }
        return $questions;
    }

}
