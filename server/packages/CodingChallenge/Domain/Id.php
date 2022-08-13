<?php
declare(strict_types=1);

namespace CodingChallenge\Domain;

/**
 * Class Id
 * @package CodingChallenge\Domain
 */
final class Id
{
    /**
     * @var string
     */
    private string $id;

    /**
     * @param string $id
     */
    public function __construct(string $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }
}
