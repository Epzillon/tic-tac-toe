<?php

namespace App\Views\Layouts;

class EmptyLayout extends LayoutAbstract
{
    public function render(): void
    {
        http_response_code($this->view->getHttpResponseCode());
        header($this->view->getHttpResponseContentType());
        $this->view->render();
    }
}
