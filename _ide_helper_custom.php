<?php

namespace Spatie\Ray
{
    use Spatie\LaravelRay\Ray as LaravelRay;

    class Ray
    {
        public function inside(): LaravelRay
        {
            /** @var LaravelRay */
            return ray();
        }
    }
}
