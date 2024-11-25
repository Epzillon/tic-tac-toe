<?php

namespace App\Views\Layouts;

use App\Views\AbstractView;

abstract class LayoutAbstract
{
    protected AbstractView $view;

    public function __construct(AbstractView $view)
    {
        $this->view = $view;
    }

    abstract public function render(): void;
}
