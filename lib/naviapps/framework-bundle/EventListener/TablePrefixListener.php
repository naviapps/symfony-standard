<?php

namespace Naviapps\Bundle\FrameworkBundle\EventListener;

use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Mapping\ClassMetadataInfo;

class TablePrefixListener
{
    /** @var string */
    private $prefix;
    /** @var string */
    private $entityNamespace;

    /**
     * @param string $prefix
     * @param null|string $entityNamespace
     */
    public function __construct(string $prefix, ?string $entityNamespace = null)
    {
        $this->prefix = $prefix;
        $this->entityNamespace = $entityNamespace;
    }

    /**
     * @param LoadClassMetadataEventArgs $eventArgs
     */
    public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs): void
    {
        $classMetadata = $eventArgs->getClassMetadata();

        if ($this->entityNamespace && $classMetadata->namespace !== $this->entityNamespace) {
            return;
        } elseif (!$classMetadata->isInheritanceTypeSingleTable() || $classMetadata->getName() === $classMetadata->rootEntityName) {
            $classMetadata->setPrimaryTable([
                'name' => $this->prefix . $classMetadata->getTableName(),
            ]);
        }

        foreach ($classMetadata->getAssociationMappings() as $fieldName => $mapping) {
            if ($mapping['type'] == ClassMetadataInfo::MANY_TO_MANY && $mapping['isOwningSide']) {
                $mappedTableName = $mapping['joinTable']['name'];
                $classMetadata->associationMappings[$fieldName]['joinTable']['name'] = $this->prefix . $mappedTableName;
            }
        }
    }
}
