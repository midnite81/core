<?php

declare(strict_types=1);

namespace Midnite81\Core\Enums;

enum DateFormat: string
{
    case DatabaseFormat = 'Y-m-d H:i:s';
    case UKDateTimeShort = 'd/m/Y H:i';
    case UKDateTime = 'd/m/Y H:i:s';
    case UKDate = 'd/m/Y';
    case UKShortDate = 'd/m/y';
    case Time24Hour = 'H:i';
    case Time24HourWithSeconds = 'H:i:s';

    case ISO8601 = 'Y-m-dTH:i:sO';
    case RFC822 = 'D, d M y H:i:s O';
    /** RFC850 and Cookie */
    case RFC850_COOKIE = 'l, d-M-y H:i:s T';
    /** RFC1123 and RSS */
    case RFC1123_RSS = 'D, d M Y H:i:s T';
    case DATE_RFC2822 = 'D, d M Y H:i:s O';
    /** RFC3339, ATOM and W3C */
    case RFC3339_ATOM_W3C = 'Y-m-dTH:i:sP';

    case DayMonthYearHourMinute_Hyphenated = 'd-m-Y H:i';
    case DayMonthYearHourMinuteSecond_Hyphenated = 'd-m-Y H:i:s';
}
