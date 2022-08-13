<?php
declare(strict_types=1);

namespace CodingChallenge\Domain;

/**
 * Class FoodItem
 * @package CodingChallenge\Domain
 */
final class FoodItem
{
    /**
     * @var string|null
     */
    private ?string $value;

    /**
     * @param string|null $value
     */
    public function __construct(?string $value)
    {
        $this->value = $value;
    }

    /**
     * @return string|null
     */
    public function getValue(): ?string
    {
        return $this->value;
    }
}
