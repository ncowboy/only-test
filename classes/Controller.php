<?php

namespace app\classes;

abstract class Controller
{
    /**
     * @return void
     */
    abstract public function run(): void;
}