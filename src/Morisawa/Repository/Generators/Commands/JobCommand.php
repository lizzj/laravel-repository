<?php

/*
 * @Author: もりさわかな
 * @LastEditTime: 2026-08-04 17:03:45
 */

namespace Morisawa\Repository\Generators\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Morisawa\Repository\Generators\FileAlreadyExistsException;
use Morisawa\Repository\Generators\JobGenerator;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class JobCommand extends Command
{
    /**
     * The name of command.
     *
     * @var string
     */
    protected $name = 'mino:job';

    /**
     * The description of command.
     *
     * @var string
     */
    protected $description = 'Create Job.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Job';

    public function __construct()
    {
        parent::__construct();
        $this->ignoreValidationErrors();
    }

    public function handle()
    {
        return $this->laravel->call([$this, 'fire'], func_get_args());
    }

    public function fire()
    {
        $name = Str::title($this->argument('name'));
        // 判定子路径名称
        $sub = null;
        $_path = $this->option('path');
        $sub = match ($_path) {
            'business', 'b' => 'business',
            'guardian', 'g' => 'guardian',
            'routine', 'r' => 'routine',
            'support', 's' => 'support',
            default => $_path,
        };
        try {
            (new JobGenerator([
                'name' => $name,
                'subpath' => $sub,
            ]))->run();

            $this->info("Job $name created successfully");
        } catch (FileAlreadyExistsException $e) {
            $this->error('File already exists!');

            return false;
        }
    }

    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of class being generated.'],
        ];
    }

    protected function getOptions()
    {
        return [
            ['path', 'p', InputOption::VALUE_OPTIONAL, 'Specify subpath (business, guardian, routine, support).'],
        ];
    }
}
