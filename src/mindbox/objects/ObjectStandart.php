<?php
declare(strict_types=1);

namespace Codedot\Mindbox\Object;

use \ReflectionClass;
use \ReflectionMethod;

trait ObjectStandart
{
    protected string $name;

    public function array(): array
    {
        $data = [];

        $reflection = new ReflectionClass($this);
        foreach ($reflection->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
            $originalNameMethod = $method->getName();
            if (strpos($originalNameMethod, 'get') === 0) {
                $nameMethod = lcfirst(substr($originalNameMethod, 3));

                $valueMethod = $this->$originalNameMethod();

                if (!empty($valueMethod)) {
                    $data[$nameMethod] = $valueMethod;
                }
            }
        }

        return [
            $this->name => $data
        ];
    }
}
