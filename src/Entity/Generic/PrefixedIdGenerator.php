<?php

namespace App\Entity\Generic;

use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Id\AbstractIdGenerator;
use InvalidArgumentException;

class PrefixedIdGenerator extends AbstractIdGenerator
{
    private static string $SQL_TEMPLATE = "SELECT NEXTVAL('%s')";
    private static int $ZERO_COUNT = 2;

    /**
     * @throws Exception
     */
    public function generateId(EntityManagerInterface $em, ?object $entity): mixed
    {
        if (!$entity instanceof AbstractPrefixedIdEntity)
            throw new InvalidArgumentException("L'argument entity doit être de type \"AbstractPrefixedIdEntity\"");

        $sequenceValue = $em->getConnection()
            ->fetchOne(sprintf(self::$SQL_TEMPLATE, $entity->getSequenceName()));

        return $entity->getPrefix() . str_pad($sequenceValue,
                self::$ZERO_COUNT +  strlen(strval($sequenceValue)),
                "0", STR_PAD_LEFT);
    }
}
