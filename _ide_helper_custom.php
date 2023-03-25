<?php

namespace Spatie\Ray
{
    use Spatie\LaravelRay\Ray as LaravelRay;
    use function ray;

    class Ray
    {
        public function inside(): LaravelRay
        {
            /** @var LaravelRay */
            return ray();
        }
    }
}
