<?php

declare(strict_types=1);

namespace Utils\JsonPayloadValidator\Service;

use DateTimeImmutable;
use Utils\JsonPayloadValidator\Exception\EntryEmptyException;
use Utils\JsonPayloadValidator\Exception\EntryForbiddenException;
use Utils\JsonPayloadValidator\Exception\EntryMissingException;
use Utils\JsonPayloadValidator\Exception\InvalidDateValueException;
use Utils\JsonPayloadValidator\Exception\OptionalPropertyNotAStringException;
use Utils\JsonPayloadValidator\Exception\StringIsNotAnUrlException;
use Utils\JsonPayloadValidator\Exception\ValueNotAStringException;
use Utils\JsonPayloadValidator\Exception\ValueStringNotExactLengthException;
use Utils\JsonPayloadValidator\Exception\ValueStringTooSmallException;
use Utils\JsonPayloadValidator\UseCase\CheckPropertyPresence;
use Utils\JsonPayloadValidator\UseCase\CheckPropertyString;

class PropertyStringChecker implements CheckPropertyString
{
    private CheckPropertyPresence $checkPropertyPresence;

    public function __construct(CheckPropertyPresence $checkPropertyPresence)
    {
        $this->checkPropertyPresence = $checkPropertyPresence;
    }

    /**
     * @inheritDoc
     */
    public function required(string $key, array $payload): self
    {
        $this->checkPropertyPresence->required($key, $payload);

        $value = $payload[$key];

        if (!is_string($value)) {
            throw ValueNotAStringException::constructForStandardMessage($key);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function optional(string $key, array $payload): self
    {
        try {
            $this->checkPropertyPresence->forbidden($key, $payload);
            return $this;
        } catch (EntryForbiddenException $e) {
            // Property present, so make sure it is a string
            try {
                $this->required($key, $payload);
                return $this;
            } catch (EntryEmptyException | EntryMissingException | ValueNotAStringException $e) {
                throw OptionalPropertyNotAStringException::constructForStandardMessage($key);
            }
        }
    }

    /**
     * @inheritDoc
     */
    public function minimumLength(string $key, array $payload, int $minimumLength): self
    {
        $this->checkPropertyPresence->required($key, $payload);
        $this->required($key, $payload);

        $len = strlen($payload[$key]);
        if ($len < $minimumLength) {
            throw new ValueStringTooSmallException(
                "Entry $key is expected to be at least $minimumLength chars long, but it is $len"
            );
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function urlFormat(string $key, array $payload): self
    {
        $this->checkPropertyPresence->required($key, $payload);

        $val = $payload[$key];
        if (!filter_var($val, FILTER_VALIDATE_URL)) {
            throw StringIsNotAnUrlException::constructForStandardMessage($val);
        }

        return $this;
    }


    /**
     * @inheritDoc
     */
    public function exactLength(string $key, array $payload, int $exactLength): self
    {
        $this->checkPropertyPresence->required($key, $payload);

        $len = strlen($payload[$key]);
        if ($len !== $exactLength) {
            throw ValueStringNotExactLengthException::constructForStandardMessage($key, $exactLength, $len);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function dateTimeFormat(string $key, array $payload, string $dateFormat): self
    {
        $this->checkPropertyPresence->required($key, $payload);

        $value = $payload[$key];

        $parsed = DateTimeImmutable::createFromFormat($dateFormat, $value);

        if ($parsed === false) {
            throw InvalidDateValueException::constructForStandardMessage($key, $dateFormat, $value);
        }

        return $this;
    }
}
