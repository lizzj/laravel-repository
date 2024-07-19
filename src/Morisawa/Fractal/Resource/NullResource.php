<?php



namespace Morisawa\Fractal\Resource;

/**
 * The Null Resource represents a resource that doesn't exist. This can be
 * useful to indicate that a certain relationship is null in some output
 * formats (e.g. JSON API), which require even a relationship that is null at
 * the moment to be listed.
 */
class NullResource extends ResourceAbstract
{
    /**
     * Get the data.
     *
     * @return mixed
     */
    #[\ReturnTypeWillChange]
    public function getData()
    {
        // Null has no data associated with it.
        return null;
    }
}
