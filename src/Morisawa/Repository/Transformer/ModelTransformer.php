<?php namespace Morisawa\Repository\Transformer;

use Morisawa\Fractal\TransformerAbstract;
use Morisawa\Repository\Contracts\Transformable;

/**
 * Class ModelTransformer
 * @package Morisawa\Repository\Transformer
 * @author Morisawa Kana
 */
class ModelTransformer extends TransformerAbstract
{
    public function transform(Transformable $model)
    {
        return $model->transform();
    }
}
