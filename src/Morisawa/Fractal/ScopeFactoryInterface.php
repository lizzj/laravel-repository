<?php



namespace Morisawa\Fractal;

use Morisawa\Fractal\Resource\ResourceInterface;

interface ScopeFactoryInterface
{
    public function createScopeFor(
        Manager $manager,
        ResourceInterface $resource,
        ?string $scopeIdentifier = null
    ): Scope;

    public function createChildScopeFor(
        Manager $manager,
        Scope $parentScope,
        ResourceInterface $resource,
        ?string $scopeIdentifier = null
    ): Scope;
}
