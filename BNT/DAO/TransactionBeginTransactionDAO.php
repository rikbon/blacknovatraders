<?php

declare(strict_types=1);

namespace BNT\DAO;

class TransactionBeginTransactionDAO extends \BNT\DAO
{
    use \BNT\Traits\DatabaseTrait;

    public function serve(): void
    {
        $this->db()->beginTransaction();
    }
}
