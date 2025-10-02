<?php

namespace Passionweb\DataHandler\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class Codebreak extends AbstractEntity
{

    public string $title;

    public string $description;

    public string $link;

    public function getUid(): ?int
    {
        return $this->uid;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getLink(): string
    {
        return $this->link;
    }

    public function setLink(string $link): void
    {
        $this->link = $link;
    }
}
