<?php

namespace Dovutuan\Serpo\Commands;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;

class MakeCriteriaCommand extends GeneratorCommand
{
    protected $name = 'make:criteria';
    protected $description = 'Create a new custom criteria class';
    protected $type = 'Criteria';

    protected function getStub(): string
    {
        return __DIR__ . '/../Stubs/criteria.stub';
    }

    protected function getDefaultNamespace($rootNamespace): string
    {
        $configNamespace = config('serpo.criteria.namespace');

        return $configNamespace
            ? rtrim($rootNamespace, '\\') . '\\' . ltrim($configNamespace, '\\')
            : $rootNamespace . '\\Criteria';
    }

    protected function buildClass($name): string
    {
        $stub = parent::buildClass($name);

        return str_replace('DummyClass', $this->getClassName($name), $stub);
    }

    protected function getClassName($name): string
    {
        return class_basename($name);
    }

    protected function getOptions(): array
    {
        return [
            ['force', 'f', InputOption::VALUE_NONE, 'Create the class even if the criteria already exists'],
        ];
    }
}
