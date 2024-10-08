<?php

namespace Morisawa\Repository\Generators\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Morisawa\Repository\Generators\FileAlreadyExistsException;
use Morisawa\Repository\Generators\TransformerGenerator;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class TransformerCommand
 * @package Morisawa\Repository\Generators\Commands
 * @author Morisawa Kana
 */
class TransformerCommand extends Command
{

    /**
     * The name of command.
     *
     * @var string
     */
    protected $name = 'mino:transformer';

    /**
     * The description of command.
     *
     * @var string
     */
    protected $description = 'Create a new transformer.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Transformer';

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
            (new TransformerGenerator([
                'name' => $case_name,
            ]))->run();
            $this->info("Transformer created successfully.");
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
                'The name of model for which the transformer is being generated.',
                null
            ],
        ];
    }
}
