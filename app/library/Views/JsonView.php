<?php

namespace App\Views;

use App\Views\Layouts\EmptyLayout;

class JsonView extends AbstractView
{
    public array $data = [];

    public function __construct()
    {
        $this->setHttpResponseContentType("Content-Type: application/json; charset=utf-8");
    }

    public function renderViewInLayout(): void
    {
        $layout = new EmptyLayout($this);
        $layout->render();
    }

    public function render(): void
    {
        $decoded_json = json_encode($this->data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        echo $decoded_json;
    }
}
