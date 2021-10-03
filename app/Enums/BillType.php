<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class BillType extends Enum
{
    const GeneralBill =   0;
    const SpecificBill =   1;
    const StoreBill = 2;
    const SpecificCompulsory  = 3;
}
