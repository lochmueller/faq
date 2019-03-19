<?php

declare(strict_types = 1);
/**
 * SessionService.php.
 */

namespace HDNET\Faq\Service;

/**
 * SessionService.
 */
class SessionService extends AbstractService
{
    /**
     * Frontend user.
     *
     * @var \TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication
     */
    protected $frontendUser;

    /**
     * Init the current object.
     */
    public function initializeObject()
    {
        $this->frontendUser = $GLOBALS['TSFE']->fe_user;
    }

    /**
     * Set and Get.
     *
     * @param string $sessionIdentifier
     * @param mixed  $value
     *
     * @return mixed
     */
    public function setAndGet($sessionIdentifier, $value)
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
     *
     * @return bool
     */
    public function has($sessionIdentifier)
    {
        return (bool)$this->get($sessionIdentifier);
    }

    /**
     * Get.
     *
     * @param string $sessionIdentifier
     *
     * @return mixed
     */
    public function get($sessionIdentifier)
    {
        return $this->frontendUser->getSessionData($sessionIdentifier);
    }

    /**
     * Set.
     *
     * @param string $sessionIdentifier
     * @param mixed  $value
     */
    public function set($sessionIdentifier, $value)
    {
        $this->frontendUser->setAndSaveSessionData($sessionIdentifier, $value);
    }
}
