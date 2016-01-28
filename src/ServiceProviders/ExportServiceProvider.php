<?php

namespace ServiceProviders;

use Exporting\CsvExporter;
use PaymentCalculation\PaymentController;
use Silex\Application;
use Silex\ServiceProviderInterface;

class ExportServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['csvExporter'] = function () use ($app) {
            return new CsvExporter();
        };
    }

    public function boot(Application $app)
    {

    }
}
