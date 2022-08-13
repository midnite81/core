<?php

declare(strict_types=1);

namespace Midnite81\Core\Carbon;

use Illuminate\Support\Carbon as IlluminateCarbon;

/**
 * @method $this london()
 * @method string dayDisplayWithYear()
 * @method string dayDisplay()
 */
class Carbon extends IlluminateCarbon
{
    public function __construct($time = null, $tz = null)
    {
        parent::__construct($time, $tz);
        $this->registerMacros();
    }

    public function registerMacros()
    {
        self::macro('dayDisplay', static function () {
            return self::this()->format('l, jS F');
        });

        self::macro('dayDisplayWithYear', static function () {
            return self::this()->format('l, jS F, Y');
        });

        self::macro('london', static function () {
            return self::this()->tz('Europe/London');
        });
    }
}
