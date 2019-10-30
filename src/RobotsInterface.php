<?php


namespace r39u1\robots;


interface RobotsInterface
{
    public function write(): bool;

    public function read(): string;
}