<?php

namespace ServiceProviders;

use Payroll\MonthPayments;
use Payroll\PaymentFactory;
use Payroll\YearPayments;
use Silex\Application;
use Silex\ServiceProviderInterface;

/**
 * This class provides all instantiatable classes in the Payroll namespace
 * Class PaymentServiceProvider
 */
class PayrollServiceProvider implements ServiceProviderInterface
{
    /**
     * This method is used to define services available to the application
     * @param Application $app
     */
    public function register(Application $app)
    {
        $app['monthPayments'] = $app->protect(function ($dateTime) use ($app) {
            return new MonthPayments($dateTime);
        });
        $app['paymentFactory'] = function () use ($app) {
            return new PaymentFactory($app['monthPayments']);
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
