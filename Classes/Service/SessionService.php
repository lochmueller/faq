<?php

declare(strict_types = 1);
/**
 * SessionService.php.
 */

namespace HDNET\Faq\Service;

use TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication;

/**
 * SessionService.
 */
class SessionService extends AbstractService
{
    /**
     * Frontend user.
     *
     * @var FrontendUserAuthentication
     */
    protected $frontendUser;

    /**
     * Init the current object.
     */
    public function initializeObject(): void
    {
        $this->frontendUser = $GLOBALS['TSFE']->fe_user;
    }

    /**
     * Set and Get.
     *
     * @param mixed $value
     *
     * @return mixed
     */
    public function setAndGet(string $sessionIdentifier, $value)
    {
        if (!$this->has($sessionIdentifier)) {
            $this->set($sessionIdentifier, $value);
        }

        return $this->get($sessionIdentifier);
    }

    /**
     * Has.
     *
     * @param $sessionIdentifier
     */
    public function has($sessionIdentifier): bool
    {
        return (bool)$this->get($sessionIdentifier);
    }

    /**
     * Get.
     *
     * @return mixed
     */
    public function get(string $sessionIdentifier)
    {
        return $this->frontendUser->getSessionData($sessionIdentifier);
    }

    /**
     * Set.
     *
     * @param mixed $value
     */
    public function set(string $sessionIdentifier, $value)
    {
        $this->frontendUser->setAndSaveSessionData($sessionIdentifier, $value);
    }
}
