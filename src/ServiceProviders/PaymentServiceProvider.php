<?php

namespace ServiceProviders;

use PaymentCalculation\PaymentController;
use PaymentCalculation\PaymentFactory;
use PaymentCalculation\YearPayments;
use Silex\Application;
use Silex\ServiceProviderInterface;

/**
 * This class provides all instantiatable classes in the PaymentCalculation namespace
 * Class PaymentServiceProvider
 */
class PaymentServiceProvider implements ServiceProviderInterface
{
    /**
     * This method is used to define services available to the application
     * @param Application $app
     */
    public function register(Application $app)
    {
        $app['paymentFactory'] = function () use ($app) {
            return new PaymentFactory();
        };
        $app['yearPayments'] = function () use ($app) {
            return new YearPayments($app['paymentFactory']);
        };
    }

    /**
     * This method can be used for configuration, right before the application handles a request
     * @param Application $app
     */
    public function boot(Application $app)
    {

    }
}
