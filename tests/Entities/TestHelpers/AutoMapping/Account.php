<?php

declare(strict_types=1);

namespace Midnite81\Core\Tests\Entities\TestHelpers\AutoMapping;

use Midnite81\Core\Attributes\ArrayOf;
use Midnite81\Core\Entities\BaseEntity;
use Midnite81\Core\Exceptions\PropertyMappingException;

class Account extends BaseEntity
{
    public string $accountName;

    public int $accountNumber;

    public string $upperCaseString;

    public Address $address;

    /**
     * @var array<int, Orders>
     */
    #[ArrayOf(Orders::class)]
    public array $orders;

    /**
     * @param array|object $data
     * @throws PropertyMappingException
     */
    public function __construct(array|object $data = [])
    {
        parent::__construct();
        $this->mapProperties($data);
    }

    public function defineTypeHandlers(): void
    {
        $this->typeHandlers = [
            ...$this->scalarHandlers(),
            Address::class => fn($value) => new Address($value),
            Orders::class => fn($value) => new Orders($value),
        ];
    }

    public function definePropertyHandlers(): void
    {
        $this->propertyHandlers = [
            'upperCaseString' => fn($value) => strtoupper($value),
        ];
    }
}
