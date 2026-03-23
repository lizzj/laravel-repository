<?php

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
        // 使用 hasOption 检查，只有定义的选项才会被处理
        if ($this->hasOption('business') && $this->option('business')) {
            $sub = 'business';
        } elseif ($this->hasOption('guardian') && $this->option('guardian')) {
            $sub = 'guardian';
        } elseif ($this->hasOption('routine') && $this->option('routine')) {
            $sub = 'routine';
        } elseif ($this->hasOption('support') && $this->option('support')) {
            $sub = 'support';
        }

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
            ['business', 'b', InputOption::VALUE_NONE, 'Create job in Business namespace.'],
            ['guardian', 'g', InputOption::VALUE_NONE, 'Create job in Guardian namespace.'],
            ['routine', 'r', InputOption::VALUE_NONE, 'Create job in Routine namespace.'],
            ['support', 's', InputOption::VALUE_NONE, 'Create job in Support namespace.'],
        ];
    }
}
