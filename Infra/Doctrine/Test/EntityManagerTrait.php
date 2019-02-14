<?php

declare(strict_types=1);

namespace MsgPhp\Domain\Infra\Doctrine\Test;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\ORM\Tools\SchemaTool;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 *
 * @internal
 */
trait EntityManagerTrait
{
    /**
     * @var EntityManager
     */
    private static $em;

    public static function setUpBeforeClass(): void
    {
        foreach (self::getTypes() as $type) {
            if (Type::hasType($type::NAME)) {
                Type::overrideType($type::NAME, $type);
            } else {
                Type::addType($type::NAME, $type);
            }
        }

        $paths = self::getEntityPaths();
        $config = new Configuration();
        $config->setMetadataDriverImpl(new AnnotationDriver(new AnnotationReader(), \is_array($paths) ? $paths : iterator_to_array($paths)));
        $config->setProxyDir(sys_get_temp_dir().'/msgphp_'.md5(static::class."\0".microtime()));
        $config->setProxyNamespace(static::class);

        self::$em = EntityManager::create(['driver' => 'pdo_sqlite', 'memory' => true], $config);
    }

    public static function tearDownAfterClass(): void
    {
        /** @psalm-suppress DocblockTypeContradiction */
        if (null === self::$em) {
            throw new \LogicException('Entity manager not set.');
        }

        $proxyDir = self::$em->getConfiguration()->getProxyDir();

        if (null !== $proxyDir && is_dir($proxyDir)) {
            /** @var \SplFileInfo $file */
            foreach (new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($proxyDir, \RecursiveDirectoryIterator::SKIP_DOTS), \RecursiveIteratorIterator::CHILD_FIRST) as $file) {
                if ($file->isDir()) {
                    @rmdir($file->getRealPath() ?: $file->getPath());
                } else {
                    @unlink($file->getRealPath() ?: $file->getPath());
                }
            }
            @rmdir($proxyDir);
        }

        self::$em->close();
        self::$em = null;
    }

    protected function setUp(): void
    {
        /** @psalm-suppress DocblockTypeContradiction */
        if (null === self::$em) {
            throw new \LogicException('Entity manager not set.');
        }

        if (!self::$em->isOpen()) {
            self::$em = self::$em::create(self::$em->getConnection(), self::$em->getConfiguration(), self::$em->getEventManager());
        }

        if (self::createSchema()) {
            (new SchemaTool(self::$em))->createSchema(self::$em->getMetadataFactory()->getAllMetadata());
        }
    }

    protected function tearDown(): void
    {
        /** @psalm-suppress DocblockTypeContradiction */
        if (null === self::$em) {
            throw new \LogicException('Entity manager not set.');
        }

        self::$em->clear();

        if (self::createSchema()) {
            (new SchemaTool(self::$em))->dropDatabase();
        }
    }

    abstract protected static function createSchema(): bool;

    abstract protected static function getEntityPaths(): iterable;

    abstract protected static function getTypes(): iterable;
}
