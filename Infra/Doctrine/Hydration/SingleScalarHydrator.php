<?php

declare(strict_types=1);

/*
 * This file is part of the MsgPHP package.
 *
 * (c) Roland Franssen <franssen.roland@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace MsgPhp\Domain\Infra\Doctrine\Hydration;

use Doctrine\ORM\Internal\Hydration\SingleScalarHydrator as BaseSingleScalarHydrator;
use MsgPhp\Domain\Infra\Doctrine\DomainIdType;

final class SingleScalarHydrator extends BaseSingleScalarHydrator
{
    public const NAME = 'msgphp_single_scalar';

    protected function gatherScalarRowData(&$data): array
    {
        array_walk($data, function (&$value, $key): void {
            if (($info = $this->hydrateColumnInfo($key)) && isset($info['type']) && $info['type'] instanceof DomainIdType) {
                $value = DomainIdType::getType($info['type']::getDataType())->convertToPHPValue($value, $this->_platform);
            }

            unset($value);
        });

        return parent::gatherScalarRowData($data);
    }
}
