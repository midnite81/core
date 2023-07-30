<?php

declare(strict_types=1);

use Illuminate\Database\Query\Builder as QueryBuilder;
use Midnite81\Core\Eloquent\Builder;


it('correctly gets the SQL query with bindings for QueryBuilder', function () {
    $builder = \Mockery::mock(QueryBuilder::class);
    $builder->shouldReceive('toSql')->andReturn('select * from users where id = ? and name = ?');
    $builder->shouldReceive('getBindings')->andReturn([1, 'John']);

    $expectedQuery = "select * from users where id = 1 and name = 'John'";

    $query = Builder::getQueries($builder);

    expect($query)->toBe($expectedQuery);
});

