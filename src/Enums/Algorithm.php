<?php

declare(strict_types=1);

namespace Midnite81\Core\Enums;

enum Algorithm: string
{
    case Md5 = 'md5';
    case Sha1 = 'sha1';
    case Sha224 = 'sha224';
    case Sha256 = 'sha256';
    case Sha384 = 'sha384';
    case Sha512 = 'sha512';
    case Ripemd160 = 'ripemd160';
}
