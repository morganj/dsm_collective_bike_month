<?php
/*
 * This file is part of the ManageWP Worker plugin.
 *
 * (c) ManageWP LLC <contact@managewp.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class MWP_EventListener_FixCompatibility implements Symfony_EventDispatcher_EventSubscriberInterface
{

    private $context;

    public function __construct(MWP_WordPress_Context $context)
    {
        $this->context = $context;
    }

    public static function getSubscribedEvents()
    {
        return array(
            MWP_Event_Events::ACTION_RESPONSE => 'fixWpSuperCache',
            MWP_Event_Events::MASTER_REQUEST  => array(
                array('fixAllInOneSecurity', -10000),
                array('fixWpSimpleFirewall', -10000),
                array('fixDuoFactor', -10000),
            ),
        );
    }

    public function fixWpSuperCache()
    {
        if ($this->context->hasConstant('ADVANCEDCACHEPROBLEM') && $this->context->getConstant('ADVANCEDCACHEPROBLEM')) {
            $this->context->set('wp_cache_config_file', null);
        }
    }

    public function fixDuoFactor()
    {
        if (!$this->context->isPluginEnabled('duo-wordpress/duo_wordpress.php')) {
            return;
        }

        $this->context->addAction('init', array($this, '_fixDuoFactor'), -1);
    }

    /**
     * @internal
     */
    public function _fixDuoFactor()
    {
        $this->context->removeAction('init', 'duo_verify_auth', 10);
    }

    public function fixAllInOneSecurity()
    {
        if (!$this->context->isPluginEnabled('all-in-one-wp-security-and-firewall/wp-security.php')) {
            return;
        }

        $this->context->addAction('init', array($this, '_fixAllInOneSecurity'), -1);
    }

    /**
     * @internal
     */
    public function _fixAllInOneSecurity()
    {
        $user = $this->context->getCurrentUser();

        if (empty($user->ID)) {
            return;
        }

        $this->context->updateUserMeta($user->ID, 'last_login_time', $this->context->getCurrentTime()->format('Y-m-d H:i:s'));
    }

    public function fixWpSimpleFirewall()
    {
        if (!$this->context->isPluginEnabled('wp-simple-firewall/icwp-wpsf.php')) {
            return;
        }

        /** @handled function */
        MWP_FixCompatibility_ICWP_WPSF();
    }
}

function MWP_FixCompatibility_ICWP_WPSF()
{
    if (class_exists('ICWP_WPSF_Processor_LoginProtect_TwoFactorAuth', false)) {
        return;
    }

    class ICWP_WPSF_Processor_LoginProtect_TwoFactorAuth
    {
        public function run()
        {
        }
    }
}
