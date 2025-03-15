<?php

namespace Morisawa\Repository\Generators\Commands;

use Illuminate\Console\Command;
use Morisawa\Repository\Generators\FileAlreadyExistsException;
use Morisawa\Repository\Generators\RequestGenerator;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class ControllerCommand
 *
 * @author Morisawa Kana
 */
class RequestCommand extends Command
{
    /**
     * The name of command.
     *
     * @var string
     */
    protected $name = 'mino:request';

    /**
     * The description of command.
     *
     * @var string
     */
    protected $description = 'Create Request.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Request';

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
        $case_name = \Illuminate\Support\Str::title($this->argument('name'));

        // Validate the namespace
        foreach (explode('\\', $case_name) as $item) {
            if (blank($item) || ! preg_match('/^[A-Z]/', $item[0])) {
                $this->error($case_name.' Invalid Namespace!');

                return false;
            }
        }

        try {
            // Define choices
            (new RequestGenerator([
                'name' => $case_name,
            ]))->run();
            $this->info('Validator created successfully.');
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
