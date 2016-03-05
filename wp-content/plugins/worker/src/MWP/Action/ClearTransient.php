<?php
/*
 * This file is part of the ManageWP Worker plugin.
 *
 * (c) ManageWP LLC <contact@managewp.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class MWP_Action_ClearTransient extends MWP_Action_Abstract
{
    public function execute(array $params = array())
    {
        $timeout = $params['timeout'];
        $mask    = $params['mask'];
        $limit   = !empty($params['limit']) ? $params['limit'] : 25000;

        $clearedTransients     = $this->clearTransients('_transient_', $timeout, $mask, $limit);
        $clearedSiteTransients = $this->clearTransients('_site_transient_', $timeout, $mask, $limit);

        return array(
            'deletedTransients'        => $clearedTransients['deletedTransients'] + $clearedSiteTransients['deletedTransients'],
            'deletedTransientTimeouts' => $clearedTransients['deletedTransientTimeouts'] + $clearedSiteTransients['deletedTransientTimeouts'],
        );
    }

    private function clearTransients($transientType, $timeout, $mask, $limit)
    {
        $wpdb   = $this->container->getWordPressContext()->getDb();
        $prefix = $wpdb->prefix;

        $timeoutName  = $transientType.'timeout_';
        $subStrLength = strlen($timeoutName) + 1;

        $escapedTimeoutName = str_replace('_', '\_', $timeoutName);

        $selectTimeOutedTransients = <<<SQL
SELECT SUBSTR(option_name, {$subStrLength}) AS transient_name FROM {$prefix}options WHERE option_name LIKE '{$escapedTimeoutName}{$mask}' AND option_value < {$timeout} LIMIT {$limit}
SQL;

        $transientsToDelete = $wpdb->get_col($selectTimeOutedTransients);
        $timeoutsToDelete   = array();

        if (count($transientsToDelete) === 0) {
            return array(
                'deletedTransients'        => 0,
                'deletedTransientTimeouts' => 0,
            );
        }

        foreach ($transientsToDelete as &$transient) {
            $timeoutsToDelete[] = "'".$timeoutName.$transient."'";
            $transient          = "'".$transientType.$transient."'";
        }

        $deleteQuery = implode(',', $transientsToDelete);

        $deleteTransients = <<<SQL
DELETE FROM {$prefix}options WHERE option_name IN ({$deleteQuery})
SQL;

        $deletedTransients = $wpdb->query($deleteTransients);

        $deleteQuery = implode(',', $timeoutsToDelete);

        $deleteTransients = <<<SQL
DELETE FROM {$prefix}options WHERE option_name IN ({$deleteQuery})
SQL;

        $deletedTransientTimeouts = $wpdb->query($deleteTransients);

        return array(
            'deletedTransients'        => $deletedTransients,
            'deletedTransientTimeouts' => $deletedTransientTimeouts,
        );
    }
}
