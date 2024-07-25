<?php

namespace Morisawa\Repository\Generators\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Morisawa\Repository\Generators\ControllerGenerator;
use Morisawa\Repository\Generators\RequestGenerator;
use Morisawa\Repository\Generators\FileAlreadyExistsException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class ControllerCommand
 * @package Morisawa\Repository\Generators\Commands
 * @author Morisawa Kana
 */
class ControllerCommand extends Command
{

    /**
     * The name of command.
     *
     * @var string
     */
    protected $name = 'mino:controller';

    /**
     * The description of command.
     *
     * @var string
     */
    protected $description = 'Create a new RESTful controller.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Controller';

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
            $choices = [
                1 => 'CreateRequest And UpdateRequest',
                2 => 'CreateRequest',
                3 => 'UpdateRequest',
                0 => 'Nothing'
            ];
            $request_option = $this->choice(
                'What would you like to do?',
                $choices,
                0
            );
            $generateRequests = function ($case_name, $requests) {
                foreach ($requests as $request) {
                    (new RequestGenerator(['name' => $case_name.'/'.$request]))->run();
                }
            };
            $action = match (array_search($request_option, $choices)) {
                1 => function () use ($case_name, $generateRequests) {
                    $generateRequests($case_name, ['Create', 'Update']);
                    $this->info('CreateRequest and UpdateRequest created successfully.');
                },
                2 => function () use ($case_name, $generateRequests) {
                    $generateRequests($case_name, ['Create']);
                    $this->info('CreateRequest created successfully.');
                },
                3 => function () use ($case_name, $generateRequests) {
                    $generateRequests($case_name, ['Update']);
                    $this->info('UpdateRequest created successfully.');
                },
                default => function () {
                    $this->info('No request created.');
                },
            };
            call_user_func($action);
            (new ControllerGenerator([
                'name' => $case_name
            ]))->run();
            $this->info($this->type.' created successfully.');
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
