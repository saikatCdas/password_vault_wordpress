<?php

namespace FluentPlugin\Framework\Database;

use FluentPlugin\Framework\Foundation\App;
use FluentPlugin\Framework\Database\ConnectionResolverInterface;

class ConnectionResolver implements ConnectionResolverInterface
{
    /**
     * Get a database connection instance.
     *
     * @param  string  $name
     * @return \FluentPlugin\Framework\Database\ConnectionInterface
     */
    public function connection($name = null)
    {
        return App::getInstance('db');
    }

    /**
     * Get the default connection name.
     *
     * @return string
     */
    public function getDefaultConnection()
    {
        // Pass
    }

    /**
     * Set the default connection name.
     *
     * @param  string  $name
     * @return void
     */
    public function setDefaultConnection($name)
    {
        // Pass
    }
}
