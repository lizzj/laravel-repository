<?php

namespace Morisawa\Repository\Generators\Commands;

use Illuminate\Console\Command;
use Morisawa\Repository\Generators\CriteriaGenerator;
use Morisawa\Repository\Generators\FileAlreadyExistsException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class CriteriaCommand
 * @package Morisawa\Repository\Generators\Commands
 * @author Morisawa Kana
 */
class CriteriaCommand extends Command
{
    /**
     * The name of command.
     *
     * @var string
     */
    protected $name = 'mino:criteria';

    /**
     * The description of command.
     *
     * @var string
     */
    protected $description = 'Create a new criteria.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Criteria';

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
            (new CriteriaGenerator([
                'name' => $case_name,
            ]))->run();
            $this->info("Criteria created successfully.");
        } catch (FileAlreadyExistsException $ex) {
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
