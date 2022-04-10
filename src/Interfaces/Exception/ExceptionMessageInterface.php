<?php

namespace App\Interfaces\Exception;

interface ExceptionMessageInterface
{
    public const JSON_VALIDATE_EXCEPTION = 'Json is not valid';
    public const PRODUCT_IS_NOT_EXIST = 'product id must be a exist product';
    public const PRODUCT_DONT_HAVE_ENOUGH_STOCK = 'this product dont have enough stock for this order';
    public const ORDER_CAN_NOT_UPDATE = 'can not update order if shipping date exist';
    public const ORDER_NOT_FOUND = 'order not found';
}
