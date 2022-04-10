<?php

namespace App\Interfaces;

interface ConstantInterface
{
    // HTTP METHODS
    public const HTTP_GET_METHOD= 'GET';
    public const HTTP_POST_METHOD = 'POST';
    public const HTTP_PUT_METHOD= 'PUT';

    // pagination default values
    public const PAGINATION_DEFAULT_OFFSET = 0;
    public const PAGINATION_DEFAULT_LIMIT = 5;

    // RESPONSE STATUS
    public const SUCCESS_STATUS = 'success';
    public const FAILED_STATUS = 'failed';

    // RESPONSE MESSAGE
    public const USER_REGISTER_DONE_SUCCESSFULLY = 'user register done successfully';
    public const USER_LOGIN_DONE_SUCCESSFULLY = 'user login done successfully';
    public const PRODUCT_LIST_DONE_SUCCESSFULLY = 'product list page: %s fetched successfully';
    public const ORDER_STORE_DONE_SUCCESSFULLY = 'order stored successfully';
    public const ORDER_UPDATE_DONE_SUCCESSFULLY = 'order updates successfully';
    public const ORDER_LIST_DONE_SUCCESSFULLY = 'order list page: %s fetched successfully';
    public const ORDER_SHOW_DONE_SUCCESSFULLY = 'order fetched successfully';
}
