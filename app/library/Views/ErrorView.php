<?php

namespace App\Views;

use Throwable;

class ErrorView extends AbstractView
{
    private Throwable $exception;

    public function __construct(Throwable $exception)
    {
        $this->exception = $exception;
        $this->setHttpResponseCode(500);
        $this->setTitle('Unexpected error');
    }

    public function render(): void
    {
        include __DIR__ . '/error.phtml';
    }
}
