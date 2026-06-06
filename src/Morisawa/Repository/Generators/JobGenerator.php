<?php

/*
 * @Author: もりさわかな
 * @LastEditTime: 2026-06-06 17:28:29
 */

namespace Morisawa\Repository\Generators;

/**
 * Class JobGenerator
 *
 * @author Morisawa Kana
 */
class JobGenerator extends Generator
{
    /**
     * Get stub name.
     *
     * @var string
     */
    protected $stub = 'job';

    /**
     * Get root namespace.
     * 最终结果示例: App\Jobs\Business
     *
     * @return string
     */
    public function getRootNamespace()
    {
        if ($this->getOption('subpath')) {
            return parent::getRootNamespace().parent::getConfigGeneratorClassPath($this->getPathConfigNode().'.'.$this->getOption('subpath'));
        } else {
            return parent::getRootNamespace().ucfirst($this->getPathConfigNode());
        }

    }

    /**
     * Get generator path config node.
     *
     * @return string
     */
    public function getPathConfigNode()
    {
        return 'jobs';
    }

    /**
     * Get destination path for generated file.
     * 最终结果示例: /app/Jobs/Business/MyJob.php
     *
     * @return string
     */
    public function getPath()
    {
        if ($this->getOption('subpath')) {
            return $this->getBasePath().'/'.parent::getConfigGeneratorClassPath($this->getPathConfigNode().'.'.$this->getOption('subpath'), true).'/'.$this->getName().'.php';
        } else {
            return $this->getBasePath().'/'.ucfirst($this->getPathConfigNode()).'/'.$this->getName().'.php';
        }
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
            'fillable' => '[]',
        ]);
    }
}
