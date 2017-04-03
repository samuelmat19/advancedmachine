<?php
/**
 * @package      Virtualcurrency
 * @subpackage   Helpers
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Virtualcurrency\Helper;

use Joomla\Registry\Registry;
use Prism\Helper\HelperInterface;

defined('JPATH_PLATFORM') or die;

/**
 * This class provides functionality to prepare items parameters.
 *
 * @package      Virtualcurrency
 * @subpackage   Helpers
 */
class PrepareItemsParamsHelper implements HelperInterface
{
    /**
     * Prepare the parameters of the items.
     *
     * @param array $data
     * @param array $options
     */
    public function handle(&$data, array $options = array())
    {
        if (count($data) > 0) {
            foreach ($data as $key => $item) {
                if ($item->params === null) {
                    $item->params = '{}';
                }

                if (is_string($item->params) and $item->params !== '') {
                    $params = new Registry;
                    $params->loadString($item->params);
                    $item->params = $params;
                }
            }
        }
    }
}
