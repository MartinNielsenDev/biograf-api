<?php


namespace Lib;


use Models\AuthUser;

class CurrentUser
{
    /** @var AuthUser|null $current_user */
    public static $current_user = null;
}
