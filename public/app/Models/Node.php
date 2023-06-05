<?php

declare(strict_types=1);

namespace app\Models;
class Node
{
    public string $name;
    public int $cost;
    public object $children;

    /**
     * @param string $name
     * @param int $cost
     * @param object $children
     */
    public function __construct(string $name, int $cost, object $children)
    {
        $this->name = $name;
        $this->cost = $cost;
        $this->children = $children;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getCost(): int
    {
        return $this->cost;
    }

    /**
     * @param int $cost
     */
    public function setCost(int $cost): void
    {
        $this->cost = $cost;
    }

    /**
     * @return object
     */
    public function getChildren(): object
    {
        return $this->children;
    }

    /**
     * @param object $children
     */
    public function setChildren(object $children): void
    {
        $this->children = $children;
    }
}