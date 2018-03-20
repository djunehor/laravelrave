<?php

namespace Tests;

use Mockery;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase {

    public $m;

    protected $envVars;

    protected $data;

    protected $formData;

    function setUp () {

        $this->m = new Mockery;

        $this->envVars = (array) include __DIR__ . "/Stubs/env.php";

        $this->data = (array) include __DIR__ . "/Stubs/request_data.php";

        $this->formData = $this->data["form"];

        parent::setUp();
    }

    /**
     * Clear mockery after every test in preparation for a new mock.
     *
     * @return void
     */
    function tearDown() {

        $this->m->close();

        parent::tearDown();
    }

    /**
     * Register package.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return array      Packages to register
     */
    protected function getPackageProviders($app)
    {
        return [ \KingFlamez\Rave\RaveServiceProvider::class ];
    }

    /**
     * Get alias packages from app.
     *
     * @param  \illuminate\Foundation\Application $app
     * @return array      Aliases.
     */
    protected function getPackageAliases($app)
    {
        return [
            "Rave" => \KingFlamez\Rave\Facades\Rave::class
        ];
    }

    /**
     * Configure Environment.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        array_walk($this->envVars, function ($value, $key) use (&$app) {

            $app["config"]->set("rave.{$key}", $value);
        });
    }
}
