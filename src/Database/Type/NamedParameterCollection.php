<?php

declare(strict_types=1);

namespace Utils\Database\Type;

use Utils\Collections\AbstractStringAssociativeCollection;
use Utils\Collections\Exception\KeyAlreadyExistsException;
use Utils\Database\UseCase\CheckPdoParameterNames;
use Utils\JsonValidator\Exception\IncorrectParametrizationException;

class NamedParameterCollection extends AbstractStringAssociativeCollection
{
    /**
     * @throws IncorrectParametrizationException
     */
    public function add(
        CheckPdoParameterNames $checkPdoParameterNames,
        string $parameterName,
        string $parameterValue
    ): void {
        if (!$checkPdoParameterNames->checkStringRepresentsParameterName($parameterName)) {
            throw new IncorrectParametrizationException(
                "Parameter name '$parameterName' not in expected format. Does it start with colon?"
            );
        }

        if (trim($parameterValue) === '') {
            throw new IncorrectParametrizationException(
                "Parameter name '$parameterName' is associated with NULL or empty string, so no need to be parametrized"
            );
        }

        try {
            $this->addStringKeyUntyped($parameterName, $parameterValue);
        } catch (KeyAlreadyExistsException $e) {
            throw new IncorrectParametrizationException(
                "Parameter name '$parameterName' is already in this collection"
            );
        }
    }

    /**
     * @inheritDoc
     */
    public function getByStringKey(
        string $key
    ): string {
        return $this->getByStringKeyUntyped($key);
    }

    /**
     * @inheritDoc
     */
    public function getByNumericOffset(
        int $offset
    ): string {
        return $this->getByNumericOffsetUntyped($offset);
    }

    /**
     * @inheritDoc
     */
    public function current(): string
    {
        return $this->currentUntyped();
    }

    public function hasParameter(string $parameterName): bool
    {
        return $this->checkStringKeyExists($parameterName);
    }
}
