<?php
declare(strict_types=1);

namespace CodingChallenge\Domain;

final class Longitude
{
    /**
     * @var float|null
     */
    private ?float $value;

    /**
     * @param float|null $value
     */
    public function __construct(?float $value)
    {
        $this->value = $value;
    }

    /**
     * @return float|null
     */
    public function getValue(): ?float
    {
        return $this->value;
    }
}
