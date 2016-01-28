<?php

namespace ServiceProviders;

use Exporting\CsvExporter;
use Silex\Application;
use Silex\ServiceProviderInterface;

/**
 * This class provides all instantiatable classes in the Exporting namespace
 * Class ExportServiceProvider
 */
class ExportServiceProvider implements ServiceProviderInterface
{
    /**
     * This method is used to define services available to the application
     * @param Application $app
     */
    public function register(Application $app)
    {
        $app['csvExporter'] = $app->protect(function ($filename, $root) use ($app) {
            return new CsvExporter($filename, $root);
        });
    }

    /**
     * This method can be used for configuration, right before the application handles a request
     * @param Application $app
     */
    public function boot(Application $app)
    {

    }
}
