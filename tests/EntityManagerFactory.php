<?php
/**
 * File EntityManagerFacory.php
 *
 * @author Edward Pfremmer <epfremme@nerdery.com>
 */
namespace Epfremme\Eav\Tests;

use Doctrine\Common\Persistence\Mapping\Driver\MappingDriverChain;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\Tools\Setup;
use Gedmo;
use Ramsey\Uuid\Doctrine\UuidType;

// define doctrine connection config values
define('DB_DRIVER', @getenv('DB_DRIVER') ?: 'pdo_sqlite');

/**
 * Class EntityManagerFactory
 *
 * @package Epfremme\Eav\Tests
 */
class EntityManagerFactory
{
    /** Entity paths */
    const ENTITY_PATHS = [
        __DIR__ . '/../src',
    ];

    /**  */
    const CONN_CONFIG = [
        'driver' => DB_DRIVER,
        'memory' => true,
    ];

    /**
     * @var Connection
     */
    private static $connection;

    /**
     * @var Configuration
     */
    private static $configuration;

    /**
     * Return new Entity Manager
     *
     * @return EntityManager
     */
    public static function build() : EntityManager
    {
        self::registerTypes();

        $em = EntityManager::create(self::getConnection(), self::getConfiguration());

        self::registerListeners($em);
        self::buildSchema($em);

        return $em;
    }

    /**
     * Register Uuid Doctrine Type
     *
     * @throws DBALException
     */
    private static function registerTypes()
    {
        if (!Type::hasType('uuid')) {
            Type::addType('uuid', UuidType::class);
        }
    }

    /**
     * Build DB Schema
     *
     * @param EntityManager $em
     * @throws \Doctrine\ORM\Tools\ToolsException
     */
    private static function buildSchema(EntityManager $em)
    {
        $tool = new SchemaTool($em);
        $metadata = $em->getMetadataFactory()->getAllMetadata();

        $tool->dropSchema($metadata);
        $tool->createSchema($metadata);
    }

    /**
     * Return DB Connection
     *
     * @return Connection
     * @throws DBALException
     */
    private static function getConnection() : Connection
    {
        if (!self::$connection) {
            self::$connection = DriverManager::getConnection(self::CONN_CONFIG);
        }

        return self::$connection;
    }

    /**
     * Return ORM Configuration
     *
     * @return Configuration
     */
    private static function getConfiguration() : Configuration
    {
        if (!self::$configuration) {
            self::$configuration = Setup::createAnnotationMetadataConfiguration(self::ENTITY_PATHS, true, null, null, false);
        }

        return self::$configuration;
    }

    /**
     * Register Custom Doctrine Listeners
     *
     * @param EntityManager $em
     */
    private static function registerListeners(EntityManager $em)
    {
        /** @var AnnotationDriver $annotationDriver */
        $annotationDriver = self::$configuration->getMetadataDriverImpl();
        $driverChain = new MappingDriverChain();

        Gedmo\DoctrineExtensions::registerAbstractMappingIntoDriverChainORM($driverChain, $annotationDriver->getReader());

        $eventManager = $em->getEventManager();

        $timestampableListener = new Gedmo\Timestampable\TimestampableListener();
        $timestampableListener->setAnnotationReader($annotationDriver->getReader());

        $eventManager->addEventSubscriber($timestampableListener);
    }
}
