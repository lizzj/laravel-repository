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
    // Normalize the case name
    $case_name = \Illuminate\Support\Str::title($this->argument("name"));

    // Validate the namespace
    foreach (explode("\\", $case_name) as $item) {
        if (blank($item) || !preg_match('/^[A-Z]/', $item[0])) {
            $this->error($case_name . ' Invalid Namespace!');
            return false;
        }
    }

    try {
        // Define choices
        $choices = [
            0 => 'Nothing',
            1 => 'CreateRequest And UpdateRequest',
            2 => 'CreateRequest',
            3 => 'UpdateRequest'
        ];

        // Get user choice
        $request_option = $this->choice(
            'What would you like to do?',
            array_values($choices), // Use array_values to get the list of options
            0
        );

        // Map choice to action
        $actionKey = array_search($request_option, $choices);

        $generateRequests = function ($case_name, $requests) {
            foreach ($requests as $request) {
                (new RequestGenerator(['name' => $case_name . '/' . $request]))->run();
            }
        };

        $action = match ($actionKey) {
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
            0 => function () {
                $this->info('No request created.');
            },
            default => function () {
                $this->info('Invalid option selected.');
            },
        };

        // Call the selected action
        call_user_func($action);

        // Generate controller
        (new ControllerGenerator([
            'name' => $case_name
        ]))->run();

        $this->info('Controller created successfully.');
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
                null
            ],
        ];
    }

}
