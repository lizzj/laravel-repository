<?php
namespace Morisawa\Repository\Presenter;

use Exception;
use Morisawa\Repository\Transformer\ModelTransformer;

/**
 * Class ModelFractalPresenter
 * @package Morisawa\Repository\Presenter
 * @author Morisawa Kana
 */
class ModelFractalPresenter extends FractalPresenter
{

    /**
     * Transformer
     *
     * @return ModelTransformer
     * @throws Exception
     */
    public function getTransformer()
    {
        if (!class_exists('Morisawa\Fractal\Manager')) {
            throw new Exception("Package required. Please install: 'composer require Morisawa/fractal' (0.12.*)");
        }

        return new ModelTransformer();
    }
}
