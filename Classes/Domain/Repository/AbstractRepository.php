<?php
/**
 * AbstractRepository.php
 *
 * General file information
 *
 * @author     Tim Spiekerkoetter
 */

namespace HDNET\Faq\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * AbstractRepository
 *
 * General class information
 */
abstract class AbstractRepository extends Repository
{

    /**
     * Find objects by the given ids in the given order
     *
     * @param array $uids
     *
     * @return array
     */
    public function findByUidsSorted(array $uids)
    {
        $return = [];
        foreach ($uids as $uid) {
            $obj = $this->findByUid($uid);
            if (is_object($obj)) {
                $return[] = $obj;
            }
        }
        return $return;
    }
}
