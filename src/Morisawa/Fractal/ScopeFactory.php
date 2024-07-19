<?php



namespace Morisawa\Fractal;

use Morisawa\Fractal\Resource\ResourceInterface;

class ScopeFactory implements ScopeFactoryInterface
{
    public function createScopeFor(
        Manager $manager,
        ResourceInterface $resource,
        ?string $scopeIdentifier = null
    ): Scope {
        return new Scope($manager, $resource, $scopeIdentifier);
    }

    public function createChildScopeFor(
        Manager $manager,
        Scope $parentScope,
        ResourceInterface $resource,
        ?string $scopeIdentifier = null
    ): Scope {
        $scopeInstance = $this->createScopeFor($manager, $resource, $scopeIdentifier);

        // This will be the new children list of parents (parents parents, plus the parent)
        $scopeArray = $parentScope->getParentScopes();
        $scopeArray[] = $parentScope->getScopeIdentifier();

        $scopeInstance->setParentScopes($scopeArray);

        return $scopeInstance;
    }
}
