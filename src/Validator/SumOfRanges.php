<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Attribute\HasNamedArguments;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class SumOfRanges extends Constraint
{
    public $message = 'The total of the three gas mix would be 100 as a percentage.';

    public int $limit;

    #[HasNamedArguments]
    public function __construct(string $limit, array $groups = null, mixed $payload = null)
    {
        parent::__construct([], $groups, $payload);

        $this->limit = $limit;
    }

}
