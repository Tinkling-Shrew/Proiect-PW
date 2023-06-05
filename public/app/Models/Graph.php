<?php

declare(strict_types=1);

namespace app\Models;

class Graph
{
    public int $id;
    public string $start;
    public string $goal;
    public object $search_space;
    public HeuristicObject $heuristics;

    /**
     * @param string $start
     * @param string $goal
     * @param object $search_space
     * @param HeuristicObject $heuristics
     */
    public function __construct(string $start, string $goal, object $search_space, HeuristicObject $heuristics)
    {
        $this->start = $start;
        $this->goal = $goal;
        $this->search_space = $search_space;
        $this->heuristics = $heuristics;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getStart(): string
    {
        return $this->start;
    }

    /**
     * @param string $start
     */
    public function setStart(string $start): void
    {
        $this->start = $start;
    }

    /**
     * @return string
     */
    public function getGoal(): string
    {
        return $this->goal;
    }

    /**
     * @param string $goal
     */
    public function setGoal(string $goal): void
    {
        $this->goal = $goal;
    }

    /**
     * @return object
     */
    public function getSearchSpace(): object
    {
        return $this->search_space;
    }

    /**
     * @param object $search_space
     */
    public function setSearchSpace(object $search_space): void
    {
        $this->search_space = $search_space;
    }

    /**
     * @return HeuristicObject
     */
    public function getHeuristics(): HeuristicObject
    {
        return $this->heuristics;
    }

    /**
     * @param HeuristicObject $heuristics
     */
    public function setHeuristics(HeuristicObject $heuristics): void
    {
        $this->heuristics = $heuristics;
    }


}