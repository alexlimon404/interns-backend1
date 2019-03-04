<?php
/**
 * Created by PhpStorm.
 * User: Odmen
 * Date: 3/3/2019
 * Time: 11:13 PM
 */

namespace App\Enums;

use BenSampo\Enum\Enum;

final class UserType extends Enum
{
    const Admin = "Admin";
    const User = "User";

}