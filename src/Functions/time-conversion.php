<?php

declare(strict_types=1);

namespace Midnite81\Core\Functions;

use Midnite81\Core\Converters\TimeConverter;

function microseconds(float $value): TimeConverter
{
    return (new TimeConverter)->fromMicroseconds($value);
}

function milliseconds(float $value): TimeConverter
{
    return (new TimeConverter)->fromMilliseconds($value);
}

function seconds(float $value): TimeConverter
{
    return (new TimeConverter)->fromSeconds($value);
}

function minutes(float $value): TimeConverter
{
    return (new TimeConverter)->fromMinutes($value);
}

function hours(float $value): TimeConverter
{
    return (new TimeConverter)->fromHours($value);
}

function days(float $value): TimeConverter
{
    return (new TimeConverter)->fromDays($value);
}

function weeks(float $value): TimeConverter
{
    return (new TimeConverter)->fromWeeks($value);
}

function months(float $value): TimeConverter
{
    return (new TimeConverter)->fromMonths($value);
}

function quarters(float $value): TimeConverter
{
    return (new TimeConverter)->fromQuarters($value);
}

function years(float $value): TimeConverter
{
    return (new TimeConverter)->fromYears($value);
}
