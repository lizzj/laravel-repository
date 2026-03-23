<?php

/*
 * @Author: もりさわかな
 * @LastEditTime: 2026-03-23 18:12:34
 */

namespace Morisawa\Repository\Generators\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Morisawa\Repository\Generators\FileAlreadyExistsException;
use Morisawa\Repository\Generators\ModelGenerator;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class ModelCommand
 *
 * @author Morisawa Kana
 */
class ModelCommand extends Command
{
    /**
     * The name of command.
     *
     * @var string
     */
    protected $name = 'mino:model';

    /**
     * The description of command.
     *
     * @var string
     */
    protected $description = 'Create Model.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Model';

    /**
     * Execute the command.
     *
     * @return void
     *
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
        // Normalize the case name
        $case_name = Str::title($this->argument('name'));

        // Validate the namespace
        foreach (explode('\\', $case_name) as $item) {
            if (blank($item) || ! preg_match('/^[A-Z]/', $item[0])) {
                $this->error($case_name.' Invalid Namespace!');

                return false;
            }
        }

        try {
            // Define choices
            (new ModelGenerator([
                'name' => $case_name,
            ]))->run();
            $this->info('Model created successfully.');
        } catch (FileAlreadyExistsException $e) {
            $this->error('File already exists!');

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
                null,
            ],
        ];
    }
}
