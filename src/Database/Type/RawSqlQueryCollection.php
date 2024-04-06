<?php

declare(strict_types=1);

namespace Utils\Database\Type;

use Utils\Collections\AbstractStringAssociativeCollection;

class RawSqlQueryCollection extends AbstractStringAssociativeCollection
{
    public function getByStringKey(string $key): AbstractSqlNativeQuery
    {
        return $this->getByStringKeyUntyped($key);
    }

    public function getByNumericOffset(int $offset): AbstractSqlNativeQuery
    {
        return $this->getByNumericOffsetUntyped($offset);
    }

    public function current(): AbstractSqlNativeQuery
    {
        return $this->currentUntyped();
    }

    public function add(AbstractSqlNativeQuery $a): void
    {
        $this->addUnindexedUntypedElement($a);
    }
}
