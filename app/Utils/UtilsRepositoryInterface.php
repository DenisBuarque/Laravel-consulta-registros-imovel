<?php

namespace App\Utils;

interface UtilsRepositoryInterface
{
    public function formatMoney($value);
    public function extensionValueMoney($value);
}