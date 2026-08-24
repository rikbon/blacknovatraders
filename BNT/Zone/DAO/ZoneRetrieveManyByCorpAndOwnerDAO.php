<?php

declare(strict_types=1);

namespace BNT\Zone\DAO;

use BNT\Zone\Entity\Zone;

class ZoneRetrieveManyByCorpAndOwnerDAO extends ZoneDAO
{
    public ?int $limit = null;
    public ?bool $corp_zone = null;
    public ?int $owner = null;
    /**
     * @var Zone[]
     */
    public array $zones = [];
    public ?Zone $firstOfZones = null;

    public function serve(): void
    {
        $qb = $this->db()->createQueryBuilder();
        $qb->select('*');
        $qb->from($this->table());

        if (isset($this->corp_zone)) {
            $qb->andWhere('corp_zone = :corp_zone');
            $qb->setParameter('corp_zone', fromBool($this->corp_zone));
        }

        if (isset($this->owner)) {
            $qb->andWhere('owner = :owner');
            $qb->setParameter('owner', $this->owner);
        }

        if ($this->limit !== null) {
            $qb->setMaxResults($this->limit);
        }

        $this->zones = $this->asZones($qb->fetchAllAssociative());
        $this->firstOfZones = $this->zones[0] ?? null;
    }
}
