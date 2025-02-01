<?php

class Config
{
    private static $constants = [
        "API_KEY" => "VWE4S3C-2R84KGN-H1TR9R3-W514NC5",
        "IPN_SECRET" => "6BCdJPz74ShyIlH3rSbaHvnJVYXfVg5G",
        "BASE_URL" => "https://ifmap.ci/test",
        "DB_HOST" => "localhost",
        "DB_USER" => "root",
        "DB_PASS" => "",
        "DB_NAME" => "ma_base_de_donnees",
        "CURRENCY" => "USD",
        "EXCHANGE_API_KEY" => "fda4059eaac38fee088d2eb5"
    ];

    public static function get($key)
    {
        return self::$constants[$key] ?? null;
    }
}
