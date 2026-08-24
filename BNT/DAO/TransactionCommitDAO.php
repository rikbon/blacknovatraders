<?php

declare(strict_types=1);

namespace BNT\DAO;

class TransactionCommitDAO extends \BNT\DAO
{
    use \BNT\Traits\DatabaseTrait;

    public function serve(): void
    {
        $this->db()->commit();
    }
}
