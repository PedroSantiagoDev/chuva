<?php

namespace Chuva\Php\WebScrapping\Entity;

/**
 * Paper Author personal information.
 */
class Person
{

    /**
     * Person name.
     */
    public string $name;

    /**
     * Person institution.
     */
    public string $institution;

    /**
     * Builder.
     */
    public function __construct($name, $institution)
    {
        $this->name = $name;
        $this->institution = $institution;
    }

    /**
     * @return string
     */
    public function getInstitution(): string
    {
        return $this->institution;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

}
