<?php
namespace Morisawa\Repository\Presenter;

use Exception;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Morisawa\Fractal\Manager;
use Morisawa\Fractal\Pagination\IlluminatePaginatorAdapter;
use Morisawa\Fractal\Resource\Collection;
use Morisawa\Fractal\Resource\Item;
use Morisawa\Fractal\Serializer\SerializerAbstract;
use Morisawa\Repository\Contracts\PresenterInterface;

/**
 * Class FractalPresenter
 * @package Morisawa\Repository\Presenter
 * @author Morisawa Kana
 */
abstract class FractalPresenter implements PresenterInterface
{
    /**
     * @var string
     */
    protected $resourceKeyItem = null;

    /**
     * @var string
     */
    protected $resourceKeyCollection = null;

    /**
     * @var \Morisawa\Fractal\Manager
     */
    protected $fractal = null;

    /**
     * @var \Morisawa\Fractal\Resource\Collection
     */
    protected $resource = null;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        if (!class_exists('Morisawa\Fractal\Manager')) {
            throw new Exception(trans('repository::packages.Morisawa_fractal_required'));
        }

        $this->fractal = new Manager();
        $this->parseIncludes();
        $this->setupSerializer();
    }

    /**
     * @return $this
     */
    protected function setupSerializer()
    {
        $serializer = $this->serializer();

        if ($serializer instanceof SerializerAbstract) {
            $this->fractal->setSerializer(new $serializer());
        }

        return $this;
    }

    /**
     * @return $this
     */
    protected function parseIncludes()
    {

        $request = app('Illuminate\Http\Request');
        $paramIncludes = config('repository.fractal.params.include', 'include');

        if ($request->has($paramIncludes)) {
            $this->fractal->parseIncludes($request->get($paramIncludes));
        }

        return $this;
    }

    /**
     * Get Serializer
     *
     * @return SerializerAbstract
     */
    public function serializer()
    {
        $serializer = config('repository.fractal.serializer', 'Morisawa\\Fractal\\Serializer\\DataArraySerializer');

        return new $serializer();
    }

    /**
     * Transformer
     *
     * @return \Morisawa\Fractal\TransformerAbstract
     */
    abstract public function getTransformer();

    /**
     * Prepare data to present
     *
     * @param $data
     *
     * @return mixed
     * @throws Exception
     */
    public function present($data)
    {
        if (!class_exists('Morisawa\Fractal\Manager')) {
            throw new Exception(trans('repository::packages.Morisawa_fractal_required'));
        }

        if ($data instanceof EloquentCollection) {
            $this->resource = $this->transformCollection($data);
        } elseif ($data instanceof AbstractPaginator) {
            $this->resource = $this->transformPaginator($data);
        } else {
            $this->resource = $this->transformItem($data);
        }

        return $this->fractal->createData($this->resource)->toArray();
    }

    /**
     * @param $data
     *
     * @return Item
     */
    protected function transformItem($data)
    {
        return new Item($data, $this->getTransformer(), $this->resourceKeyItem);
    }

    /**
     * @param $data
     *
     * @return \Morisawa\Fractal\Resource\Collection
     */
    protected function transformCollection($data)
    {
        return new Collection($data, $this->getTransformer(), $this->resourceKeyCollection);
    }

    /**
     * @param AbstractPaginator|LengthAwarePaginator|Paginator $paginator
     *
     * @return \Morisawa\Fractal\Resource\Collection
     */
    protected function transformPaginator($paginator)
    {
        $collection = $paginator->getCollection();
        $resource = new Collection($collection, $this->getTransformer(), $this->resourceKeyCollection);
        $resource->setPaginator(new IlluminatePaginatorAdapter($paginator));

        return $resource;
    }
}
