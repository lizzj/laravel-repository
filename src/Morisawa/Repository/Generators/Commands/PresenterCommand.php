<?php

namespace Morisawa\Repository\Generators\Commands;

use Illuminate\Console\Command;
use Morisawa\Repository\Generators\FileAlreadyExistsException;
use Morisawa\Repository\Generators\PresenterGenerator;
use Morisawa\Repository\Generators\TransformerGenerator;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class PresenterCommand
 * @package Morisawa\Repository\Generators\Commands
 * @author Morisawa Kana
 */
class PresenterCommand extends Command
{

    /**
     * The name of command.
     *
     * @var string
     */
    protected $name = 'mino:presenter';

    /**
     * The description of command.
     *
     * @var string
     */
    protected $description = 'Create a new presenter.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Presenter';

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
        $case_name = \Illuminate\Support\Str::title($this->argument("name"));
        foreach (explode("\\", $case_name) as $item) {
            if (blank($item) || !preg_match('/^[A-Z]/', $item[0])) {
                 $this->error($case_name.' Invalid Namespace!');
                 return false;
            }
        }
        try {
            (new PresenterGenerator([
                'name' => $case_name,
                
            ]))->run();
            $this->info("Presenter created successfully.");

            if (!\File::exists(app()->path().'/Transformers/'.$case_name.'Transformer.php')) {
                if ($this->confirm('Would you like to create a Transformer? [y|N]')) {
                    (new TransformerGenerator([
                        'name' => $case_name,
                        
                    ]))->run();
                    $this->info("Transformer created successfully.");
                }
            }
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
                'The name of model for which the presenter is being generated.',
                null
            ],
        ];
    }
}
