<?php
/**
 * File index.php
 *
 * @author Edward Pfremmer <epfremme@nerdery.com>
 */

declare(strict_types=1);

use Doctrine\DBAL\Types\Type as DbalTypes;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\Tools\Setup;
use Epfremme\Eav\Entity\Entity;
use Ramsey\Uuid\Doctrine\UuidType;

require_once "vendor/autoload.php";

$paths = [
    __DIR__ . '/src',
];

$conn = [
    'driver' => 'pdo_sqlite',
    'memory' => true,
//    'path' => __DIR__ . '/db.sqlite',
];

//DbalTypes::addType('uuid', UuidType::class);

$config = Setup::createAnnotationMetadataConfiguration($paths, true, null, null, false);
$em = EntityManager::create($conn, $config);

$tool = new SchemaTool($em);
$metadata = $em->getMetadataFactory()->getAllMetadata();

$tool->createSchema($metadata);

$entity = new Entity();

$em->persist($entity);
$em->flush();

$test = $em->getRepository(Entity::class)->findAll();

var_dump($test, $test !== $entity);
