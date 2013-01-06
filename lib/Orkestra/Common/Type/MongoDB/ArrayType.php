<?php
namespace Orkestra\Common\Type\MongoDB;

use Doctrine\ODM\MongoDB\Mapping\Types\Type;
use Orkestra\Common\Exception\TypeException;

class ArrayType extends Type
{
    public function convertToDatabaseValue($value)
    {
        return serialize($value);
    }

    public function convertToPHPValue($value)
    {
        if ($value === null) {
            return null;
        }

        $value = (is_resource($value)) ? stream_get_contents($value) : $value;
        $val = unserialize($value);
        if ($val === false && $value != 'b:0;') {
            throw new TypeException('Invalid array conversion');
        }
        return $val;
    }
}
