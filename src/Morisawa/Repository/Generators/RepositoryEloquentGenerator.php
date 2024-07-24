<?php
namespace Morisawa\Repository\Generators;

use Illuminate\Support\Str;
/**
 * Class RepositoryEloquentGenerator
 * @package Morisawa\Repository\Generators
 * @author Morisawa Kana
 */
class RepositoryEloquentGenerator extends Generator
{

    /**
     * Get stub name.
     *
     * @var string
     */
    protected $stub = 'repository/eloquent';

    /**
     * Get root namespace.
     *
     * @return string
     */
    public function getRootNamespace()
    {
        return parent::getRootNamespace() . parent::getConfigGeneratorClassPath($this->getPathConfigNode());
    }

    /**
     * Get generator path config node.
     *
     * @return string
     */
    public function getPathConfigNode()
    {
        return 'repositories';
    }

    /**
     * Get destination path for generated file.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->getBasePath() . '/' . parent::getConfigGeneratorClassPath($this->getPathConfigNode(), true) . '/' . $this->getName() . 'RepositoryEloquent.php';
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

        $repository = parent::getRootNamespace() . parent::getConfigGeneratorClassPath('interfaces') . '\\' . Str::ucfirst($this->name) . 'Repository;';
        $repository = str_replace([
            "\\",
            '/'
        ], '\\', $repository);

        $presenter = parent::getRootNamespace() . parent::getConfigGeneratorClassPath('presenters') . '\\' . Str::ucfirst($this->name) . 'Presenter;';
        $presenter = str_replace([
            "\\",
            '/'
        ], '\\', $presenter);


        return array_merge(parent::getReplacements(), [
            'fillable'      => '[]',
            'presenter'=>$presenter,
            'repository'    => $repository,
            'model'         => isset($this->options['model']) ? $this->options['model'] : ''
        ]);
    }
}
