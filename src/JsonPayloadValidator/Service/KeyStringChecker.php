<?php

declare(strict_types=1);

namespace Utils\JsonPayloadValidator\Service;

use DateTimeImmutable;
use Utils\JsonPayloadValidator\Exception\EntryEmptyException;
use Utils\JsonPayloadValidator\Exception\EntryForbiddenException;
use Utils\JsonPayloadValidator\Exception\EntryMissingException;
use Utils\JsonPayloadValidator\Exception\IncorrectParametrizationException;
use Utils\JsonPayloadValidator\Exception\InvalidDateValueException;
use Utils\JsonPayloadValidator\Exception\OptionalPropertyNotAStringException;
use Utils\JsonPayloadValidator\Exception\StringIsNotAnUrlException;
use Utils\JsonPayloadValidator\Exception\ValueNotAStringException;
use Utils\JsonPayloadValidator\Exception\ValueStringNotExactLengthException;
use Utils\JsonPayloadValidator\Exception\ValueTooBigException;
use Utils\JsonPayloadValidator\Exception\ValueTooSmallException;
use Utils\JsonPayloadValidator\UseCase\CheckKeyPresence;
use Utils\JsonPayloadValidator\UseCase\CheckKeyString;

class KeyStringChecker implements CheckKeyString
{
    private CheckKeyPresence $checkPropertyPresence;

    public function __construct(CheckKeyPresence $checkPropertyPresence)
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
    public function byteLengthRange(
        string $key,
        array $payload,
        ?int $minimumLength,
        ?int $maximumLength,
        bool $required = true
    ): CheckKeyString {

        if (($minimumLength === null) && ($maximumLength === null)) {
            throw new IncorrectParametrizationException('No range defined');
        }

        if ($minimumLength !== null) {
            if ($minimumLength < 0) {
                throw new IncorrectParametrizationException(
                    "Negative lengths not allowed, but you specified a minimum length of '$minimumLength'"
                );
            }

            if ($minimumLength === 0) {
                throw new IncorrectParametrizationException(
                    "Zero lengths would require the 'optional' validator. Please correct the minimum length"
                );
            }
        }

        if ($maximumLength !== null) {
            if ($maximumLength < 0) {
                throw new IncorrectParametrizationException(
                    "Negative lengths not allowed, but you specified a maximum length of '$maximumLength'"
                );
            }

            if ($maximumLength === 0) {
                throw new IncorrectParametrizationException(
                    "Zero lengths would require the 'optional' validator. Please correct the maximum length"
                );
            }
        }

        if (($minimumLength !== null) && ($maximumLength !== null) && ($minimumLength >= $maximumLength)) {
            throw new IncorrectParametrizationException(
                "Minimum length cannot be greater or equals than maximum length"
            );
        }

        if (!$required) {
            try {
                $this->checkPropertyPresence->forbidden($key, $payload);
                return $this;
            } catch (EntryForbiddenException $e) {
                // The property exists, so validate it as if it was required
            }
        }

        $this->required($key, $payload);

        $trim = trim($payload[$key]);

        $length = strlen($trim);

        if (($minimumLength !== null) && ($length < $minimumLength)) {
            throw ValueTooSmallException::constructForStringLength($key, $minimumLength, $length);
        }

        if ($maximumLength !== null && ($length > $maximumLength)) {
            throw ValueTooBigException::constructForStringLength($key, $maximumLength, $length);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function urlFormat(string $key, array $payload, bool $required = true): self
    {
        if (!$required) {
            try {
                $this->checkPropertyPresence->forbidden($key, $payload);
                return $this;
            } catch (EntryForbiddenException $e) {
                // Continue validation as if it was required
            }
        }

        $this->required($key, $payload);

        $val = $payload[$key];
        if (!filter_var($val, FILTER_VALIDATE_URL)) {
            throw StringIsNotAnUrlException::constructForStandardMessage($val);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function exactByteLength(string $key, array $payload, int $exactLength, bool $required = true): self
    {
        if ($exactLength < 0) {
            throw new IncorrectParametrizationException(
                "Negative lengths not allowed, but you specified an exact length of '$exactLength'"
            );
        }

        if ($exactLength === 0) {
            throw new IncorrectParametrizationException(
                "Zero lengths would require the 'optional' validator. Please correct the length"
            );
        }

        if (!$required) {
            try {
                $this->checkPropertyPresence->forbidden($key, $payload);
                return $this;
            } catch (EntryForbiddenException $e) {
                // Property exists, validate it as if it was required
            }
        }

        $this->required($key, $payload);

        $len = strlen(trim($payload[$key]));
        if ($len !== $exactLength) {
            throw ValueStringNotExactLengthException::constructForStandardMessage($key, $exactLength, $len);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function dateTimeFormat(string $key, array $payload, string $dateFormat, bool $required = true): self
    {
        if (!$required) {
            try {
                $this->checkPropertyPresence->forbidden($key, $payload);
                return $this;
            } catch (EntryForbiddenException $e) {
            }
        }

        $this->required($key, $payload);

        $value = trim((string)$payload[$key]);

        $parsed = DateTimeImmutable::createFromFormat($dateFormat, $value);

        if ($parsed === false) {
            throw InvalidDateValueException::constructForStandardMessage($key, $dateFormat, $value);
        }

        return $this;
    }
}
