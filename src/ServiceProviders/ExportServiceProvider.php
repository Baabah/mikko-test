<?php

namespace ServiceProviders;

use Exporting\CsvExporter;
use Silex\Application;
use Silex\ServiceProviderInterface;

class ExportServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['csvExporter'] = $app->protect(function ($filename, $root) use ($app) {
            return new CsvExporter($filename, $root);
        });
    }

    public function boot(Application $app)
    {

    }
}
