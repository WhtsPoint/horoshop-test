<?php

namespace App\Flusher;

use Doctrine\ORM\EntityManagerInterface;

final readonly class Flusher implements FlusherInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function flush(): void
    {
        $this->entityManager->flush();
    }
}