<?php

namespace App\Views;

use App\Views\Layouts\AppLayout;

abstract class AbstractView
{
    private string $title = '';

    private int $httpResponseCode = 200;

    private string $httpResponseContentType = "Content-Type: text/html; charset=utf-8";

    public function setHttpResponseCode(int $httpResponseCode): void
    {
        $this->httpResponseCode = $httpResponseCode;
    }

    public function getHttpResponseCode(): int
    {
        return $this->httpResponseCode;
    }

    public function setHttpResponseContentType(string $httpResponseContentType): void
    {
        $this->httpResponseContentType = $httpResponseContentType;
    }

    public function getHttpResponseContentType(): string
    {
        return $this->httpResponseContentType;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function renderViewInLayout(): void
    {
        $layout = new AppLayout($this);
        $layout->render();
    }

    abstract public function render(): void;
}
