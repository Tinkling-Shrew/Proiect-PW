<?php

declare(strict_types=1);

namespace app\Models;

class GraphFile
{
    public int $id;
    public string $path;
    public string $title;

    /**
     * @param string $path
     * @param string $title
     */
    public function __construct(string $path, string $title)
    {
        $this->path = $path;
        $this->title = $title;
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
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath(string $path): void
    {
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }


}