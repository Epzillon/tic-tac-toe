<?php

namespace App\Views;

class NotFoundView extends AbstractView
{
    public function __construct()
    {
        $this->setHttpResponseCode(404);
        $this->setTitle('Page not found.');
    }

    public function render(): void
    {
        include __DIR__ . '/notFound.php';
    }
}
