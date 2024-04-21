<?php

declare(strict_types=1);

namespace Utils\Database\Type;

use Utils\Collections\AbstractStringAssociativeCollection;

/**
 * @deprecated
 * See zuzsso/database
 */
class NativeSqlQueryCollection extends AbstractStringAssociativeCollection
{
    /**
     * @deprecated
     * See zuzsso/database
     */
    public function getByStringKey(string $key): AbstractSqlNativeQuery
    {
        return $this->getByStringKeyUntyped($key);
    }

    /**
     * @deprecated
     * See zuzsso/database
     */
    public function getByNumericOffset(int $offset): AbstractSqlNativeQuery
    {
        return $this->getByNumericOffsetUntyped($offset);
    }

    /**
     * @deprecated
     * See zuzsso/database
     */
    public function current(): AbstractSqlNativeQuery
    {
        return $this->currentUntyped();
    }

    /**
     * @deprecated
     * See zuzsso/database
     */
    public function add(AbstractSqlNativeQuery $a): void
    {
        $this->addUnindexedUntypedElement($a);
    }
}
