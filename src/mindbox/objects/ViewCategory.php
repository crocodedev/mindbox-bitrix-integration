<?php
declare(strict_types=1);

namespace Codedot\Mindbox\Object;

use JetBrains\PhpStorm\ArrayShape;
use \ReflectionClass;
use \ReflectionMethod;

class ViewCategory
{
    use ObjectStandart;

    private int $websiteID;

    public function __construct($params) {
        $this->name = 'viewProductCategory';

        foreach ($params as $keyParam => $valueParam) {
            $setKey = "set$keyParam";

            $this->$setKey($valueParam);
        }
    }


    /**
     * @param int $websiteID
     * @return ViewCategory
     */
    public function setWebsiteID(int $websiteID): ViewCategory
    {
        $this->websiteID = $websiteID;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getProductCategory(): ?array
    {
        return (!empty($this->websiteID)) ? ['ids' => ['websiteID' => $this->websiteID]] : null;
    }

}