<?php

namespace ServiceProviders;

use PaymentCalculation\PaymentController;
use PaymentCalculation\PaymentFactory;
use PaymentCalculation\YearPayments;
use Silex\Application;
use Silex\ServiceProviderInterface;

class PaymentServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['paymentFactory'] = function () use ($app) {
            return new PaymentFactory();
        };
        $app['yearPayments'] = function () use ($app) {
            return new YearPayments($app['paymentFactory']);
        };
        $app['paymentController'] = function () use ($app) {
            return new PaymentController($app['yearPayments']);
        };
    }

    public function boot(Application $app)
    {

    }
}
