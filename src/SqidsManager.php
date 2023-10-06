<?php

namespace ErikSulymosi\EloquentSqids;

use Illuminate\Contracts\Foundation\Application;
use InvalidArgumentException;
use Sqids\Sqids;

class SqidsManager
{
    protected array $connections = [];

    /**
     * Create a new sqids manager instance.
     */
    public function __construct(protected Application $app)
    {}

    /**
     * Get a sqids instance.
     *
     * @param  string|null  $name
     * @return \Illuminate\Contracts\Filesystem\Filesystem
     */
    public function connection(?string $name = null): Sqids
    {
        $name = $name ?: $this->getDefaultConnection();

        return $this->connections[$name] = $this->get($name);
    }

    /**
     * Attempt to get the connection from the local cache.
     */
    protected function get(string $name): Sqids
    {
        return $this->connections[$name] ?? $this->resolve($name);
    }

    /**
     * Resolve the given connection.
     *
     * @throws \InvalidArgumentException
     */
    protected function resolve(string $name, ?array $config = null): Sqids
    {
        $config ??= $this->getConfig($name);

        if ($config === null) {
            throw new InvalidArgumentException("Sqids connection [{$name}] not have a configuration.");
        }

        return new Sqids(...$config);
    }

    /**
     * Get the sqids connection configuration.
     */
    protected function getConfig(string $name): ?array
    {
        return $this->app['config']["sqids.connections.{$name}"] ?: null;
    }

    /**
     * Get the default connection name.
     */
    public function getDefaultConnection(): string
    {
        return $this->app['config']['sqids.default'];
    }

    /**
     * Dynamically call the default connection instance.
     */
    public function __call(string $method, array $parameters): mixed
    {
        return $this->connection()->$method(...$parameters);
    }
}