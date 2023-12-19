<?php
declare(strict_types=1);

namespace Codedot\Mindbox\Object;

use JetBrains\PhpStorm\ArrayShape;
use \ReflectionClass;
use \ReflectionMethod;

class ProductGroup
{
    use ObjectStandart;

    private int $websiteID;

    public function __construct($params) {
        $this->name = 'productGroup';

        foreach ($params as $keyParam => $valueParam) {
            $setKey = "set$keyParam";

            $this->$setKey($valueParam);
        }
    }

    /**
     * @param int $websiteID
     * @return ProductGroup
     */
    public function setWebsiteID(int $websiteID): ProductGroup
    {
        $this->websiteID = $websiteID;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getIds(): ?array
    {
        return (!empty($this->websiteID)) ? ['websiteID' => $this->websiteID] : null;
    }
}