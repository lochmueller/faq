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
use TYPO3\CMS\Core\Database\ConnectionPool;
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
    protected $defaultOrderings = [
        'title' => QueryInterface::ORDER_ASCENDING,
    ];

    /**
     * Get the top questions
     *
     * @param int $limit
     *
     * @param int $topCategoryId
     *
     * @param array $topQuestions
     *
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findTop($limit = 5, $topCategoryId = 0, $topQuestions = [])
    {
        $questions = $this->getStaticQuestionsAndReduceLimit($topQuestions, $limit);
        if ($limit > 0) {
            $query = $this->createQuery();
            $constraintsOr = [];
            $constraintsOr[] = $query->contains('categories', $topCategoryId);
            $constraintsOr[] = $query->equals('categories.parent', $topCategoryId);

            $constraintsAnd = [];
            $constraintsAnd[] = $query->logicalOr($constraintsOr);
            if (!empty($topQuestions)) {
                $constraintsAnd[] = $query->logicalNot($query->in('uid', $topQuestions));
            }

            $query->matching($query->logicalAnd($constraintsAnd));

            $query->setOrderings(['topCounter' => QueryInterface::ORDER_DESCENDING]);
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
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function findNewest($limit = 5, $topCategoryId = 0)
    {
        $query = $this->createQuery();

        $constraintsOr = [];
        $constraintsOr[] = $query->contains('categories', $topCategoryId);
        $constraintsOr[] = $query->equals('categories.parent', $topCategoryId);

        $query->matching($query->logicalOr($constraintsOr));

        $query->setOrderings(['crdate' => QueryInterface::ORDER_DESCENDING]);
        if ($limit) {
            $query->setLimit($limit);
        }
        return $query->execute();
    }

    /**
     * Returns all objects of this repository.
     *
     * @param int $topCategoryId
     *
     * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface|array
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function findAll($topCategoryId = 0)
    {
        if (!$topCategoryId) {
            return parent::findAll();
        } else {
            $query = $this->createQuery();

            $constraintsOr = [];
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
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function findByFaq(Faq $faq, $topCategoryId = 0)
    {
        $query = $this->createQuery();

        $constraintsOr = [];
        $constraintsOr[] = $query->contains('categories', $topCategoryId);
        $constraintsOr[] = $query->equals('categories.parent', $topCategoryId);

        $constraints = [];
        $constraints[] = $query->logicalOr($constraintsOr);

        $categories = GeneralUtility::intExplode(',', implode(',', $faq->getCategories()), true);
        if ($faq->getCategory() instanceof Questioncategory) {
            $categories[] = (int) $faq->getCategory()
                ->getUid();
        }

        if ($categories) {
            $catSelection = [];
            foreach ($categories as $catId) {
                $catSelection[] = $query->contains('categories', $catId);
            }
            $constraints[] = $query->logicalOr($catSelection);
        }

        if (strlen($faq->getSearchWord())) {
            $constraints[] = $query->logicalOr([
                $query->like('title', '%' . $faq->getSearchWord() . '%'),
                $query->like('answer', '%' . $faq->getSearchWord() . '%')
            ]);
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
     * @param array $categories
     * @param int $limit
     *
     * @return array
     * @throws \Exception
     */
    public function findByTeaserConfiguration(array $topQuestions, array $categories, $limit)
    {
        $questions = $this->getStaticQuestionsAndReduceLimit($topQuestions, $limit);
        if ($limit > 0) {
            $t = $this->getTableName();

            $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_faq_mm_question_questioncategory');
            $queryBuilder
                ->getRestrictions()
                ->removeAll();


            $where = [
                $queryBuilder->expr()->eq($t . '.uid', 'mm.uid_local')
            ];
            if (sizeof($topQuestions)) {
                $where[] = $queryBuilder->expr()->notIn($t . '.uid', $topQuestions);
            }
            if (!empty($categories)) {
                $where[] = $queryBuilder->expr()->in('mm.uid_foreign', $categories);
            }

            $rows = $queryBuilder->select($t . '.*')
                ->from($t)
                ->join($t, 'tx_faq_mm_question_questioncategory', 'mm')
                ->where(...$where)
                ->groupBy($t . '.uid')
                ->execute()
                ->fetchAll();

            shuffle($rows);

            foreach ($rows as $row) {
                $q = $this->findByUid((int) $row['uid']);
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
     * @param int $limit
     *
     * @return array
     */
    protected function getStaticQuestionsAndReduceLimit(array $ids, &$limit)
    {
        $questions = [];
        foreach ($ids as $id) {
            $q = $this->findByUid((int) $id);
            if ($q instanceof Question) {
                $questions[] = $q;
                $limit--;
            }
        }
        return $questions;
    }
}
