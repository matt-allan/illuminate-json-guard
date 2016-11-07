<?php

use League\JsonGuard\Constraints;

return [
    Constraints\AdditionalItems::KEYWORD      => 'Additional items are not allowed',
    Constraints\AdditionalProperties::KEYWORD => 'Additional properties found which are not allowed: :diff',
    Constraints\AnyOf::KEYWORD                => 'Failed matching any of the provided schemas',
    Constraints\Dependencies::KEYWORD         => 'Unmet dependency :dependency',
    Constraints\Enum::KEYWORD                 => 'Value :value is not one of: :choices',
    Constraints\Format::KEYWORD               => 'Value :value does not match the format :format',
    Constraints\Max::KEYWORD                  => 'Value :value is not at most :max',
    Constraints\Max::EXCLUSIVE_KEYWORD        => 'Value :value is not less than :exclusive_max',
    Constraints\MaxItems::KEYWORD             => 'Array does not contain less than :max_items items',
    Constraints\MaxLength::KEYWORD            => 'String is not at most :max_length characters long',
    Constraints\MaxProperties::KEYWORD        => 'Object does not contain less than :max_properties properties',
    Constraints\Min::KEYWORD                  => 'Number :value is not at least :min',
    Constraints\Min::EXCLUSIVE_KEYWORD        => 'Number :value is not at least greater than :exclusive_min',
    Constraints\MinItems::KEYWORD             => 'Array does not contain more than :min_items items',
    Constraints\MinLength::KEYWORD            => 'String is not at least :min_length characters long',
    Constraints\MinProperties::KEYWORD        => 'Object does not contain at least :min_properties properties',
    Constraints\MultipleOf::KEYWORD           => 'Number :value is not a multiple of :multiple_of',
    Constraints\Not::KEYWORD                  => 'Data should not match the schema',
    Constraints\OneOf::KEYWORD                => 'Failed matching exactly one of the provided schemas',
    Constraints\Pattern::KEYWORD              => 'Value :value does not match the pattern :pattern',
    Constraints\Required::KEYWORD             => 'Required properties missing: :missing',
    Constraints\Type::KEYWORD                 => 'Value :value is not a(n) :type',
    Constraints\UniqueItems::KEYWORD          => 'Array {value} is not unique.',
];
