<?php

namespace app\classes;

abstract class Controller
{
    protected bool $only_auth = true;

    abstract public function run(): void;
}