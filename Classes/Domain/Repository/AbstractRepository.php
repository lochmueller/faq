<?php

declare(strict_types = 1);
/**
 * AbstractRepository.php.
 *
 * General file information
 */

namespace HDNET\Faq\Domain\Repository;

use Exception;
use TYPO3\CMS\Extbase\Persistence\Generic\Query;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * AbstractRepository.
 *
 * General class information
 */
abstract class AbstractRepository extends Repository
{
    /**
     * Return the current tablename.
     *
     * @throws Exception
     */
    public function getTableName(): string
    {
        $query = $this->createQuery();
        if ($query instanceof Query) {
            $source = $query->getSource();
            if (method_exists($source, 'getSelectorName')) {
                return $source->getSelectorName();
            }
        }

        throw new Exception('Can\'t get the table name of the current object', 123671823123);
    }

    /**
     * Find objects by the given ids in the given order.
     */
    public function findByUidsSorted(array $uids): array
    {
        $return = [];
        foreach ($uids as $uid) {
            $obj = $this->findByUid($uid);
            if (\is_object($obj)) {
                $return[] = $obj;
            }
        }

        return $return;
    }
}
