<?php

namespace Innovarting\Hexagonal\Console\Commands;

class MakeUseCaseCommand extends BaseGeneratorCommand
{
    protected $signature = 'hexagonal:command {name : Use case name.} {--d|domain= : Specify the name of the folder where the suso case will be created.}';
    protected $description = 'Create new command and handler files for the given use case.';

    protected $type = 'Command';

    public function handle(): bool
    {
        if (!$this->option('domain')) {
            $this->error('Not enough options {missing: domain}');
            return false;
        }

        $className = $this->getNameInput() . 'Command';

        $this->makeClass($className);

        $this->call('hexagonal:handler', array_filter([
            'name'     => $this->getNameInput(),
            '--domain' => $this->option('domain'),
        ]));

        return true;
    }

    protected function getDefaultNamespace($rootNamespace): string
    {
        $domain = $this->option('domain');
        return $rootNamespace . "\Application\Services\\" . $domain;
    }

    protected function getStub(): string
    {
        return __DIR__ . '/../../stubs/UseCases/Command.php.stub';
    }
}
