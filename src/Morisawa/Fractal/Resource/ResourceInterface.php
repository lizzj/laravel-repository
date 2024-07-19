<?php



namespace Morisawa\Fractal\Resource;

interface ResourceInterface
{
    /**
     * Get the resource key.
     */
    public function getResourceKey(): string;

    /**
     * Get the data.
     *
     * @return mixed
     */
    #[\ReturnTypeWillChange]
    public function getData();

    /**
     * Get the transformer.
     *
     * @return callable|\Morisawa\Fractal\TransformerAbstract|null
     */
    public function getTransformer();

    /**
     * Set the data.
     *
     * @param mixed $data
     */
    public function setData($data): self;

    /**
     * Set the transformer.
     *
     * @param callable|\Morisawa\Fractal\TransformerAbstract $transformer
     */
    public function setTransformer($transformer): self;

    /**
     * Get the meta data.
     */
    public function getMeta(): array;
}
