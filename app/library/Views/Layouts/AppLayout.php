<?php

namespace App\Views\Layouts;

class AppLayout extends LayoutAbstract
{
    public function render(): void
    {
        http_response_code($this->view->getHttpResponseCode());
        header($this->view->getHttpResponseContentType());
        include __DIR__ . '/app.phtml';
    }
}
