<?php

@include_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(kirby()->option('hashandsalt.auth0.env'));
$dotenv->load();

Kirby::plugin('hashandsalt/auth0', [


    // Options
    'siteMethods' => [
        'auth0' => function () {
            return new \Auth0\SDK\Auth0([
                'domain' => $_ENV['AUTH0_DOMAIN'],
                'clientId' => $_ENV['AUTH0_CLIENT_ID'],
                'clientSecret' => $_ENV['AUTH0_CLIENT_SECRET'],
                'cookieSecret' => $_ENV['AUTH0_COOKIE_SECRET']
            ]);
        },
     ],

     'routes' => [
        [
            'pattern' => 'login',
            'action' => function () {
                $auth0 = site()->auth0();
                $auth0->clear();
                go($auth0->login(url(kirby()->option('hashandsalt.auth0.baseUri') . 'callback')));
            }
        ],
        [
            'pattern' => 'callback',
            'action' => function () {
                $auth0 = site()->auth0();
                $auth0->exchange(url(kirby()->option('hashandsalt.auth0.baseUri') . 'callback'));
                go(kirby()->option('hashandsalt.auth0.baseUri'));
            }
        ],
     
        [
            'pattern' => 'logout',
            'action' => function () {
                $auth0 = site()->auth0();
                go($auth0->logout(url(kirby()->option('hashandsalt.auth0.baseUri'))));
            }
        ],
    ]


]);
