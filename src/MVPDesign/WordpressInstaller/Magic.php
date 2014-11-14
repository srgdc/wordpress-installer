<?php

namespace MVPDesign\WordpressInstaller;

use Composer\Script\Event;

class Magic
{
    public static $KEYS = array(
        'AUTH_KEY',
        'SECURE_AUTH_KEY',
        'LOGGED_IN_KEY',
        'NONCE_KEY',
        'AUTH_SALT',
        'SECURE_AUTH_SALT',
        'LOGGED_IN_SALT',
        'NONCE_SALT'
    );

    public static function happens(Event $event)
    {
        $io = $event->getIO();

        if ($io->isInteractive()) {
            $magicAnswers = askQuestions($io);
            $io->write($magicAnswers);
        }
    }

    public static function askQuestions($io)
    {
        $generate_salts = $io->askConfirmation('<info>Generate salts?</info> [<comment>Y,n</comment>]?', true);
        $salts = array_map(function($key) {
            return sprintf("%s='%s'", $key, Magic::generateSalts());
        }, self::$KEYS);

        $db_name        = $io->ask('Database Name?');
        $db_user        = $io->ask('Database User?');
        $db_password    = $io->ask('Database Password?');
        $db_host        = $io->ask('Database Host?');
        $wp_env 		= $io->askConfirmation('<info>What is the environment</info> [<comment>development</comment>]?', true);

        $info              = new Info;
        $info->DB_NAME     = $db_name;
        $info->DB_USER     = $db_user;
        $info->DB_PASSWORD = $db_password;
        $info->DB_HOST     = $db_host;
        $info->WP_ENV      = $wp_env;
        $info->salts       = $salts;

        return $info;
    }

    public static function createEnvironment()
    {

    }

    public static function generateSalts()
    {
        $chars  = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $chars .= '!@#$%^&*()';
        $chars .= '-_ []{}<>~`+=,.;:/?|';

        $salt = '';

        for ($i = 0; $i < $length; $i++) {
            $salt .= substr($chars, rand(0, strlen($chars) - 1), 1);
        }

        return $salt;
    }
}

class Info {
    public $DB_NAME;
    public $DB_USER;
    public $DB_PASSWORD;
    public $DB_HOST;
    public $WP_ENV;
    public $salts;
}
