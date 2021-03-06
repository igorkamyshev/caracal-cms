<?php

namespace App\Business\Library\Create;

use App\Business\Library\ArticleData;
use App\Command\CreateCommand;

class ArticleCreateCommand extends CreateCommand
{
    public static function fromData(ArticleData $data): self
    {
        return new self($data);
    }

    public function getData(): ArticleData
    {
        return $this->data;
    }
}
