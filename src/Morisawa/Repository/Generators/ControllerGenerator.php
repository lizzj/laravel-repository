<?php

namespace Morisawa\Repository\Generators;

use Illuminate\Support\Str;

/**
 * Class ControllerGenerator
 * @package Morisawa\Repository\Generators
 * @author Morisawa Kana
 */
class ControllerGenerator extends Generator
{

    /**
     * Get stub name.
     *
     * @var string
     */
    protected $stub = 'controller/controller';

    /**
     * Get root namespace.
     *
     * @return string
     */
    public function getRootNamespace()
    {
        return str_replace('/', '\\', parent::getRootNamespace().parent::getConfigGeneratorClassPath($this->getPathConfigNode()));
    }

    /**
     * Get generator path config node.
     *
     * @return string
     */
    public function getPathConfigNode()
    {
        return 'controllers';
    }

    /**
     * Get destination path for generated file.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->getBasePath().'/'.parent::getConfigGeneratorClassPath($this->getPathConfigNode(), true).'/'.$this->getName().'Controller.php';
    }

    /**
     * Get base path of destination file.
     *
     * @return string
     */
    public function getBasePath()
    {
        return config('repository.generator.basePath', app()->path());
    }

    /**
     * Gets controller name based on model
     *
     * @return string
     */
    public function getControllerName()
    {

        return ucfirst($this->getPluralName());
    }

    /**
     * Gets plural name based on model
     *
     * @return string
     */
    public function getPluralName()
    {
        return lcfirst(ucwords($this->getClass()));
    }

    /**
     * Get array replacements.
     *
     * @return array
     */
    public function getReplacements()
    {
        $request = str_replace([
            "\\",
            '/'
        ], '\\', $this->getName());
        return array_merge(parent::getReplacements(), [
            'controller' => $this->getControllerName(),
            'request' => $request,
            'appname' => $this->getAppNamespace(),
        ]);
    }

    /**
     * Gets singular name based on model
     *
     * @return string
     */
    public function getSingularName()
    {
        return Str::singular(lcfirst(ucwords($this->getClass())));
    }

}
