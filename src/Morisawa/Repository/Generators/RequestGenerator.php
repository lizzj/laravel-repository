<?php

namespace Morisawa\Repository\Generators;


use Illuminate\Support\Str;

/**
 * Class RequestGenerator
 * @package Morisawa\Repository\Generators
 * @author Morisawa Kana
 */
class RequestGenerator extends Generator
{
    /**
     * Get stub name.
     *
     * @var string
     */
    protected $stub = 'request/request';

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
     * Get destination path for generated file.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->getBasePath().'/'.parent::getConfigGeneratorClassPath($this->getPathConfigNode(), true).'/'.$this->getName().'Request.php';
    }

    /**
     * Get generator path config node.
     *
     * @return string
     */
    public function getPathConfigNode()
    {
        return 'validators';
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
     * Get array replacements.
     *
     * @return array
     */
    public function getReplacements()
    {
        return array_merge(parent::getReplacements(), [
            'appname' => $this->getAppNamespace(),
            'messages'=>str_replace(["\\", '/'], '.', $this->getName()),
        ]);
    }

}
