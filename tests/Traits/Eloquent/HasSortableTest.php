<?php

use Midnite81\Core\Traits\Eloquent\HasSortable;

it('gets sort order column', function () {
    $class = new class
    {
        use HasSortable;
    };

    expect($class->getSortOrderColumn())->toBe('sort_order');
});

it('gets sort order direction', function () {
    $class = new class
    {
        use HasSortable;
    };

    expect($class->getSortOrderDirection())->toBe('ASC');
});

it('scope sorts', function () {
    $class = new class
    {
        use HasSortable;
    };

    $builder = \Mockery::mock(Illuminate\Database\Eloquent\Builder::class);
    $builder->shouldReceive('orderBy')
        ->with('sort_order', 'ASC')
        ->once()
        ->andReturnSelf();

    expect($class->scopeSort($builder))
        ->toBeInstanceOf(\Illuminate\Database\Eloquent\Builder::class);
});
