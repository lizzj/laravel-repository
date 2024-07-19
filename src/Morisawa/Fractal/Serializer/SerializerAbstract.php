<?php



namespace Morisawa\Fractal\Serializer;

use Morisawa\Fractal\Pagination\CursorInterface;
use Morisawa\Fractal\Pagination\PaginatorInterface;
use Morisawa\Fractal\Resource\ResourceInterface;

abstract class SerializerAbstract implements Serializer
{
    /**
     * {@inheritDoc}
     */
    public function mergeIncludes(array $transformedData, array $includedData): array
    {
        // If the serializer does not want the includes to be side-loaded then
        // the included data must be merged with the transformed data.
        if (! $this->sideloadIncludes()) {
            return array_merge($transformedData, $includedData);
        }

        return $transformedData;
    }

    /**
     * {@inheritDoc}
     */
    public function sideloadIncludes(): bool
    {
        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function injectData(array $data, array $rawIncludedData): array
    {
        return $data;
    }

    /**
     * {@inheritDoc}
     */
    public function injectAvailableIncludeData(array $data, array $availableIncludes): array
    {
        return $data;
    }

    /**
     * {@inheritDoc}
     */
    public function filterIncludes(array $includedData, array $data): array
    {
        return $includedData;
    }

    /**
     * {@inheritDoc}
     */
    public function getMandatoryFields(): array
    {
        return [];
    }
}
