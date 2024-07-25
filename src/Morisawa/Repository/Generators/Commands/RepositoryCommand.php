<?php

namespace Morisawa\Repository\Generators\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Morisawa\Repository\Generators\FileAlreadyExistsException;
use Morisawa\Repository\Generators\ModelGenerator;
use Morisawa\Repository\Generators\RepositoryEloquentGenerator;
use Morisawa\Repository\Generators\RepositoryInterfaceGenerator;
use Morisawa\Repository\Generators\PresenterGenerator;
use Morisawa\Repository\Generators\TransformerGenerator;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class RepositoryCommand
 * @package Morisawa\Repository\Generators\Commands
 * @author Morisawa Kana
 */
class RepositoryCommand extends Command
{

    /**
     * The name of command.
     *
     * @var string
     */
    protected $name = 'mino:repository';

    /**
     * The description of command.
     *
     * @var string
     */
    protected $description = 'Create a new repository.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Repository';

    /**
     * @var Collection
     */
    protected $generators = null;


    /**
     * Execute the command.
     *
     * @return void
     * @see fire()
     */
    public function handle()
    {
        $this->laravel->call([$this, 'fire'], func_get_args());
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function fire()
    {
        $this->generators = new Collection();
        $case_name = \Illuminate\Support\Str::title($this->argument("name"));
        foreach (explode("\\", $case_name) as $item) {
            if (blank($item) || !preg_match('/^[A-Z]/', $item[0])) {
                $this->error($case_name.' Invalid Namespace!');
                return false;
            }
        }

        $this->generators->push(new RepositoryInterfaceGenerator([
            'name' => $case_name,
        ]));
        $modelGenerator = new ModelGenerator([
            'name' => $case_name,
        ]);
        $this->generators->push($modelGenerator);
        $this->generators->push(new PresenterGenerator([
            'name' => $case_name,
        ]));
        $this->generators->push(new TransformerGenerator([
            'name' => $case_name,
        ]));
        foreach ($this->generators as $generator) {
            $generator->run();
        }
        $model = $modelGenerator->getRootNamespace().'\\'.$modelGenerator->getName();
        $model = str_replace([
            "\\",
            '/'
        ], '\\', $model);

        try {
            (new RepositoryEloquentGenerator([
                'name' => $case_name,
                'model' => $model
            ]))->run();
            \Illuminate\Support\Facades\Artisan::call("mino:bind", ["name" => $this->argument("name")]);
            $this->info("Repository Interface Presenter Transformer created successfully.");
        } catch (FileAlreadyExistsException $e) {
            $this->error($this->type.' already exists!');

            return false;
        }
    }


    /**
     * The array of command arguments.
     *
     * @return array
     */
    public function getArguments()
    {
        return [
            [
                'name',
                InputArgument::REQUIRED,
                'The name of class being generated.',
                null
            ],
        ];
    }
}
