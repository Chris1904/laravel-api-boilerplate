<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\GeneratorCommand;

class BoilerplateCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:boilerplate {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Necessary Resource Files';

    public function getStub()
    {
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //Create Test Files
        $this->buildTest()
            ->buildTransformer()
            ->buildTrait()
            ->buildController()
            ->buildRequest();
    }

    protected function buildTest()
    {
        $this->call('make:test', [
            'name' => "{$this->getClassName()}Test"
        ]);

        $this->call('make:test', [
            'name' => "{$this->getClassName()}Test",
            '--unit' => true
        ]);

        return $this;
    }

    protected function buildTransformer()
    {
        $stub = $this->files->get(__DIR__.'/stubs/transform.stub');

        $stub = $this->replaceTransformerName($stub);

        $path = $this->getPath($this->TransformerNameSpace().'\\'.$this->getClassName().'Transformer');

        $this->files->put($path, $stub);

        $this->info('Transformer created successfully.');

        return $this;
    }

    protected function buildTrait()
    {
        $stub = $this->files->get(__DIR__.'/stubs/trait.stub');

        $stub = $this->replaceTraitName($stub);

        $path = $this->getPath($this->TraitNameSpace().'\\Queries'.$this->getClassName());

        $this->files->put($path, $stub);

        $this->info('Trait created successfully.');

        return $this;
    }

    protected function buildController()
    {
        $stub = $this->files->get(__DIR__.'/stubs/controller.stub');

        $stub = $this->replaceControllerName($stub);

        $path = $this->getPath($this->ControllerNameSpace().'\\'.$this->getClassName().'Controller');

        $this->files->put($path, $stub);

        $this->info('Controller created successfully.');

        return $this;
    }

    protected function buildRequest()
    {
        $stub = $this->files->get(__DIR__.'/stubs/request.stub');

        $pathDirectory = $this->getDirectoryPath($this->RequestNameSpace());

        if (! $this->files->isDirectory($pathDirectory)) {
            $this->files->makeDirectory($pathDirectory, 0777, true, true);
        }

        $types = ['Create', 'Delete', 'Update'];

        foreach ($types as $type) {
            $className = $this->getClassName().$type.'Request';

            $stub = $this->replaceRequestName($stub, $className);

            $path = $this->getPath($this->RequestNameSpace().'\\'.$className);

            $this->files->put($path, $stub);
        }

        $this->info('Requests created successfully.');

        return $this;
    }

    public function TransformerNameSpace()
    {
        return $this->rootNamespace()."Api\V1\Transformers";
    }

    public function TraitNameSpace()
    {
        return $this->rootNamespace()."Api\V1\Traits";
    }

    public function ControllerNameSpace()
    {
        return $this->rootNamespace()."Api\V1\Controllers";
    }

    public function RequestNameSpace()
    {
        return $this->rootNamespace()."Api\V1\Requests\\".$this->getClassName();
    }

    public function replaceTransformerName($stub)
    {
        return str_replace(
            ['DummyClass', 'DummyModel', 'DummyVariable', 'DummyNamespace'],
            ["{$this->getClassName()}Transformer", $this->getClassName(), strtolower($this->getClassName()), $this->TransformerNameSpace()],
            $stub
        );
    }

    public function replaceTraitName($stub)
    {
        return str_replace(
            ['DummyTrait', 'DummyModel', 'DummyVariable', 'DummyNamespace', 'DummyMethod'],
            ['Queries'.Str::plural($this->getClassName()), $this->getClassName(), strtolower($this->getClassName()).'Query', $this->TraitNameSpace(), Str::plural(strtolower($this->getClassName()))],
            $stub
        );
    }

    public function replaceControllerName($stub)
    {
        return str_replace(
            ['DummyClass', 'DummyNamespace'],
            [$this->getClassName().'Controller', $this->ControllerNameSpace()],
            $stub
        );
    }

    public function replaceRequestName($stub, $className)
    {
        return str_replace(
            ['DummyClass', 'DummyNamespace', 'DummyTrait'],
            [$className, $this->RequestNameSpace(), 'Queries'.$this->getClassName()],
            $stub
        );
    }

    protected function getDirectoryPath($name)
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        return $this->laravel['path'].'/'.str_replace('\\', '/', $name);
    }

    public function getClassName()
    {
        return ucfirst(trim($this->argument('name')));
    }

    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the class'],
        ];
    }
}
