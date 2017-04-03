<?php
/**
 * @package      Prism
 * @subpackage   Constants
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism;

defined('JPATH_PLATFORM') or die;

/**
 * Prism constants
 *
 * @package      Prism
 * @subpackage   Constants
 */
class Constants
{
    // States
    const PUBLISHED          = 1;
    const UNPUBLISHED        = 0;
    const TRASHED            = -2;
    const AWAITING_APPROVAL  = -3;

    const YES = 1;
    const OK  = 1;
    const NO  = 0;

    const APPROVED     = 1;
    const NOT_APPROVED = 0;

    const ALLOWED      = 1;
    const NOT_ALLOWED  = 0;

    const FEATURED = 1;
    const NOT_FEATURED = 0;

    const ENABLED = 1;
    const DISABLED = 0;

    const VERIFIED     = 1;
    const NOT_VERIFIED = 0;

    const FOLLOWED     = 1;
    const UNFOLLOWED   = 0;

    const DISPLAY          = 1;
    const DO_NOT_DISPLAY   = 0;

    const INACTIVE = 0;
    const ACTIVE = 1;

    // Mail modes - html and plain text.
    const MAIL_MODE_HTML  = true;
    const MAIL_MODE_PLAIN = false;

    // Logs
    const ENABLE_SYSTEM_LOG  = true;
    const DISABLE_SYSTEM_LOG = false;

    // Notification statuses
    const SENT     = 1;
    const NOT_SENT = 0;
    const READ     = 1;
    const NOT_READ = 0;

    // Categories
    const CATEGORY_ROOT = 1;

    // Return values
    const RETURN_DEFAULT = 1;
    const DO_NOT_RETURN_DEFAULT = 0;

    // State default
    const STATE_DEFAULT = 1;
    const STATE_NOT_DEFAULT = 0;

    // State replace
    const REPLACE = 1;
    const DO_NOT_REPLACE = 0;

    // Access state
    const ACCESS_PRIVATE = 0;
    const ACCESS_PUBLIC = 1;
    const ACCESS_FOLLOWERS = 2;
    const ACCESS_FRIENDS = 3;
    const ACCESS_FOLLOWERS_FRIENDS = 5;

    const ORDER_MOST_RECENT_FIRST = 'rdate';
    const ORDER_OLDEST_FIRST = 'date';
    const ORDER_TITLE_ALPHABETICAL = 'alpha';
    const ORDER_TITLE_REVERSE_ALPHABETICAL = 'ralpha';
    const ORDER_AUTHOR_ALPHABETICAL = 'author';
    const ORDER_AUTHOR_REVERSE_ALPHABETICAL = 'rauthor';
    const ORDER_MOST_HITS = 'hits';
    const ORDER_LEAST_HITS = 'rhits';
    const ORDER_RANDOM_ORDER = 'random';
    const ORDER_ITEM_MANAGER_ORDER = 'order';

    // Time
    const TIME_SECONDS_24H = 86400;

    // Date
    const DATE_DEFAULT_SQL_DATE = '1000-01-01';
    const DATE_DEFAULT_SQL_DATETIME = '1000-01-01 00:00:00';
    const DATE_FORMAT_SQL_DATE  = 'Y-m-d';
    const DATE_FORMAT_SQL_DATETIME  = 'Y-m-d H:i:s';

    // Numbers
    const NUMBER_DEFAULT_FORMAT = '#0.00';
    const NUMBER_DEFAULT_MONEY_FORMAT = '#,##0.00';

    // Payment statuses
    const PAYMENT_STATUS_COMPLETED = 1;
    const PAYMENT_STATUS_PENDING = 2;
    const PAYMENT_STATUS_CANCELED = 4;
    const PAYMENT_STATUS_REFUNDED = 8;
    const PAYMENT_STATUS_FAILED = 16;

    // Locale
    const LOCALE_DEFAULT_LANGUAGE_CODE = 'en_GB';

    // Images
    const QUALITY_MAXIMUM = 100;
    const QUALITY_VERY_HIGH = 80;
    const QUALITY_HIGH = 60;
    const QUALITY_MEDIUM = 30;
    const QUALITY_LOW = 10;
}
