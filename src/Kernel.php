<?php
declare(strict_types=1);

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\RouteCollectionBuilder;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    const CONFIG_EXTENSIONS = '.{php,xml,yaml,yml}';

    public function getCacheDir(): string
    {
        return sprintf('%s/var/cache/%s', $this->getProjectDir(), $this->environment);
    }

    public function getLogDir(): string
    {
        return sprintf('%s/var/log', $this->getProjectDir());
    }

    public function registerBundles()
    {
        $filename = sprintf('%s/config/bundles.php', $this->getProjectDir());
        /** @var array $contents */
        $contents = require $filename;
        foreach ($contents as $class => $envs) {
            if (true === isset($envs['all']) || true === isset($envs[$this->environment])) {
                yield new $class();
            }
        }
    }

    /**
     * @throws \Exception
     */
    protected function configureContainer(ContainerBuilder $container, LoaderInterface $loader): void
    {
        $container->setParameter('container.autowiring.strict_mode', true);
        $container->setParameter('container.dumper.inline_class_loader', true);

        $confDir = sprintf('%s/config', $this->getProjectDir());
        $loader->load(sprintf('%s/packages/*%s', $confDir, self::CONFIG_EXTENSIONS), 'glob');

        if (is_dir(sprintf('%s/packages/%s', $confDir, $this->environment))) {
            $loader->load(
                sprintf('%s/packages/%s/**/*%s', $confDir, $this->environment, self::CONFIG_EXTENSIONS),
                'glob'
            );
        }

        $loader->load(sprintf('%s/services%s', $confDir, self::CONFIG_EXTENSIONS), 'glob');
        $loader->load(sprintf('%s/services_%s%s', $confDir, $this->environment, self::CONFIG_EXTENSIONS), 'glob');
    }

    /**
     * @throws \Exception
     */
    protected function configureRoutes(RouteCollectionBuilder $routes): void
    {
        $confDir = sprintf('%s/config', $this->getProjectDir());

        if (is_dir(sprintf('%s/routes/', $confDir))) {
            $routes->import(sprintf('%s/routes/*%s', $confDir, self::CONFIG_EXTENSIONS), '/', 'glob');
        }

        if (is_dir(sprintf('%s/routes/%s', $confDir, $this->environment))) {
            $routes->import(
                sprintf('%s/routes/%s/**/*%s', $confDir, $this->environment, self::CONFIG_EXTENSIONS),
                '/',
                'glob'
            );
        }

        $routes->import(sprintf('%s/routes%s', $confDir, self::CONFIG_EXTENSIONS), '/', 'glob');
    }
}
