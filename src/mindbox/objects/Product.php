<?php
declare(strict_types=1);

namespace Codedot\Mindbox\Object;

class Product
{
    use ObjectStandart;

    private int $websiteID = 0; // Значение по умолчанию

    public function __construct(array $params = []) {
        $this->name = 'product';

        foreach ($params as $key => $value) {
            $setter = "set" . ucfirst($key);

            if (method_exists($this, $setter)) {
                $this->$setter($value);
            }
        }
    }

    /**
     * @param int $websiteID
     * @return Product
     */
    public function setWebsiteID(int $websiteID): Product
    {
        $this->websiteID = $websiteID;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getIds(): ?array
    {
        return ($this->websiteID !== 0) ? ['website' => $this->websiteID] : null;
    }
}
