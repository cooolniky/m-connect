<?php
/**
 * Created by Mobio Solutions.
 * User: Nikhil Jain
 * Date: 19-01-2017
 * Time: 13:59
 */

return [
    'FROM_EMAIL' => 'contact@mobiosolutions.com',
    'FROM_NAME' => 'IMS One World',
    'permissions' => [
        1 => "Add",
        2 => "Edit",
        3 => "Export",
        4 => "Import",
    ],
    /*
     * userDataTableFieldArray use for sorting
     * */
    "userDataTableFieldArray" => [

        "first_name",
        "last_name",
        "",
        "email",
        "status"
    ],

    /*
     * shopDataTableFieldArray use for sorting
     * */
    "shopDataTableFieldArray" => [
        "name",
        "email",
        "",
        "",
        "",
        "status",
        ""
    ],

    /*
     * productDataTableFieldArray use for sorting
     * */
    "productDataTableFieldArray" => [
        "name",
        "sku",
        "",
        "",
        "qty",
        "",
        "status",
        ""
    ],


];

