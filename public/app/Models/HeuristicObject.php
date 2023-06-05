<?php

declare(strict_types=1);

namespace app\Models;

class HeuristicObject
{
    public object $data;

    /**
     * @param object $node_heuristics
     */
    public function __construct(object $node_heuristics)
    {
        $this->data = $node_heuristics;
    }

    /**
     * @return object
     */
    public function getData(): object
    {
        return $this->data;
    }

    /**
     * @param object $data
     */
    public function setData(object $data): void
    {
        $this->data = $data;
    }

    /**
     * @param Heuristic $heuristic
     */
    public function addHeuristic(Heuristic $heuristic)
    {
        $this->data[$heuristic->name] = $heuristic->cost;
    }

    /**
     * @param Heuristic $heuristic
     */
    public function removeHeuristic(Heuristic $heuristic)
    {
        unset($this->data[$heuristic->name]);
    }

    /**
     * @param string $name
     */
    public function removeHeuristicByName(string $name)
    {
        unset($this->data[$name]);
    }
}