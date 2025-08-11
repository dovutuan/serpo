<?php

namespace Dovutuan\Serpo\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class MakeServiceCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:service';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new service class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Service';

    /**
     * Get the stub file path for the generator.
     *
     * @return string
     */
    protected function getStub(): string
    {
        return __DIR__ . '/../Stubs/service.stub';
    }

    /**
     * Get the default namespace for the service class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        $configNamespace = config('serpo.service.namespace');

        return $configNamespace
            ? rtrim($rootNamespace, '\\') . '\\' . ltrim($configNamespace, '\\')
            : $rootNamespace . '\\Services';
    }

    /**
     * Get the default namespace for the repository class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getRepositoryNamespace($rootNamespace): string
    {
        $configNamespace = config('serpo.repository.namespace');

        return $configNamespace
            ? rtrim($rootNamespace, '\\') . '\\' . ltrim($configNamespace, '\\')
            : $rootNamespace . '\\Repositories';
    }

    /**
     * Build the service class with the given name, replacing repository placeholders.
     *
     * @param  string  $name
     * @return string
     */
    protected function buildClass($name): string
    {
        $stub = parent::buildClass($name);

        $repositoryNamespace = $this->qualifyRepository($name);
        $repositoryClass = class_basename($repositoryNamespace);
        $repositoryVar = lcfirst($repositoryClass);

        return str_replace(
            ['DummyRepositoryNamespace', '$DummyRepository', 'DummyRepository'],
            [$repositoryNamespace, "$$repositoryVar", $repositoryClass],
            $stub
        );
    }

    /**
     * Determine the fully-qualified repository class name.
     *
     * @param  string  $name
     * @return string
     */
    protected function qualifyRepository($name): string
    {
        $rootNamespace = $this->laravel->getNamespace();
        $repository = $this->option('repository');

        if (!$repository) {
            $repository = str_replace('Service', 'Repository', class_basename($name));
        }

        if (Str::startsWith($repository, $rootNamespace)) {
            return $repository;
        }

        if (Str::contains($repository, '/')) {
            $repository = str_replace('/', '\\', $repository);
        }

        return $this->getRepositoryNamespace(trim($rootNamespace, '\\')) . '\\' . $repository;
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions(): array
    {
        return [
            ['repository', 'r', InputOption::VALUE_OPTIONAL, 'The repository that the service depends on'],
            ['force', null, InputOption::VALUE_NONE, 'Create the class even if the service already exists'],
        ];
    }
}
