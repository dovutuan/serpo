<?php

namespace Dovutuan\Serpo\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Symfony\Component\Console\Input\InputOption;

class MakeRepositoryCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:repository';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new repository class (optionally with service)';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Repository';

    /**
     * Get the stub file path for the generator.
     *
     * @return string
     */
    protected function getStub(): string
    {
        return __DIR__ . '/../Stubs/repository.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        $configNamespace = config('serpo.repository.namespace');

        return $configNamespace
            ? rtrim($rootNamespace, '\\') . '\\' . ltrim($configNamespace, '\\')
            : $rootNamespace . '\\Repositories';
    }

    /**
     * Build the class with the given name, replacing model placeholders.
     *
     * @param string $name
     * @return string
     * @throws FileNotFoundException
     */
    protected function buildClass($name): string
    {
        $stub = parent::buildClass($name);

        $model = $this->option('model') ?? str_replace('Repository', '', class_basename($name));
        $modelNamespace = $this->qualifyModel($model);

        return str_replace(
            ['DummyModelNamespace', 'DummyModel'],
            [$modelNamespace, class_basename($modelNamespace)],
            $stub
        );
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions(): array
    {
        return [
            ['model', 'm', InputOption::VALUE_OPTIONAL, 'The model that the repository applies to'],
            ['service', 's', InputOption::VALUE_NONE, 'Create corresponding service class'],
            ['force', 'f', InputOption::VALUE_NONE, 'Create the class even if it already exists'],
        ];
    }

    /**
     * Execute the console command.
     *
     * @return void
     * @throws FileNotFoundException
     */
    public function handle(): void
    {
        parent::handle();

        if ($this->option('service')) {
            $this->createService();
        }
    }

    /**
     * Create the corresponding service class for the repository.
     *
     * @return void
     */
    protected function createService(): void
    {
        $name = str_replace('Repository', 'Service', $this->argument('name'));
        $options = [
            '--repository' => $this->argument('name'),
            '--force' => $this->option('force'),
            'name' => $name
        ];

        $this->call('make:service', $options);
    }
}
