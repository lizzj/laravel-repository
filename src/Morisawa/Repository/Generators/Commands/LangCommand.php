<?php

namespace Morisawa\Repository\Generators\Commands;

use File;
use Illuminate\Console\Command;
use ReflectionClass;

/**
 * Class LangCommand
 *
 * @author Morisawa Kana
 */
class LangCommand extends Command
{
    /**
     * The name of command.
     *
     * @var string
     */
    protected $name = 'mino:lang';

    /**
     * The description of command.
     *
     * @var string
     */
    protected $description = 'Batch sync all Request rules to _Validation lang file with compact format.';

    /**
     * Execute the command.
     *
     * @return void
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
        $masterFile = lang_path('en/_Validation.php');
        if (!File::exists($masterFile) || File::size($masterFile) === 0) {
            $this->initializeMasterFile($masterFile);
        }
        try {
            $data = include $masterFile;
            if (!is_array($data)) {
                $data = ['Failed' => 'Operation failed, please try again later.'];
            }
        } catch (\Throwable $e) {
            $data = ['Failed' => 'Operation failed, please try again later.'];
        }
        $requestPath = app_path('Http/Requests');
        if (!File::isDirectory($requestPath)) {
            $this->error("Directory not found: {$requestPath}");
            return;
        }
        $files = File::allFiles($requestPath);
        foreach ($files as $file) {
            $className = $this->getClassFullNameFromFile($file);
            if (!class_exists($className)) {
                continue;
            }
            $reflection = new ReflectionClass($className);
            if ($reflection->isAbstract()) {
                continue;
            }
            $request = new $className();
            if (!isset($request->langPath) || !method_exists($request, 'rules')) {
                continue;
            }
            $this->syncRequestToData($data, $request);
        }
        $this->saveDataToMasterFile($masterFile, $data);
        $this->info("Successfully batch synced all rules to: {$masterFile}");
    }
    protected function initializeMasterFile($path)
    {
        $dir = dirname($path);
        if (!File::exists($dir)) {
            File::makeDirectory($dir, 0755, true);
        }
        $initial = "<?php\n\nreturn [\n    'Failed' => 'Operation failed, please try again later.',\n];\n";
        File::put($path, $initial);
    }
    protected function syncRequestToData(&$data, $request)
    {
        $parts = explode('.', $request->langPath);
        if ($parts[0] === '_Validation') {
            array_shift($parts);
        }
        $temp = &$data;
        foreach ($parts as $step) {
            if (!isset($temp[$step]) || !is_array($temp[$step])) {
                $temp[$step] = [];
            }
            $temp = &$temp[$step];
        }
        $rules = $request->rules();
        foreach ($rules as $field => $payload) {
            if (is_string($payload)) {
                $individualRules = explode('|', $payload);
            } elseif (is_array($payload)) {
                $individualRules = $payload;
            } else {
                $individualRules = [];
            }
            foreach ($individualRules as $rule) {
                $ruleName = head(explode(':', $rule));
                $langKey = "{$field}.{$ruleName}";

                if (!isset($temp[$langKey])) {
                    $temp[$langKey] = '';
                }
            }
        }
    }

    protected function saveDataToMasterFile($path, $data)
    {
        $export = var_export($data, true);
        $patterns = [
            "/\barray\s*\(\s*/" => '[',           // array( -> [
            "/\n\s*\)/" => ']',           // ) -> ]
            "/\)/" => ']',           // ) -> ]
            "/=>\s+\[/" => ' => [',      // => [
            "/  /" => '    ',
        ];
        $export = preg_replace(array_keys($patterns), array_values($patterns), $export);
        $content = "<?php\n\nreturn {$export};\n";
        File::put($path, $content);
    }

    protected function getClassFullNameFromFile($file)
    {
        $relativePath = $file->getRelativePathname();
        return "App\\Http\\Requests\\".str_replace(['/', '.php'], ['\\', ''], $relativePath);
    }

    public function getArguments()
    {
        return [];
    }
}
