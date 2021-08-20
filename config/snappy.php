<?php


if (file_exists('C:\Program Files\wkhtmltopdf\bin\wkhtmltopdf.exe')) {
    return array(
        'pdf' => array(
            'enabled' => true,
            'binary' => "\"C:\Program Files\wkhtmltopdf\bin\wkhtmltopdf.exe\"",
            'timeout' => false,
            'options' => array(),
            'env' => array(),
        ),
        'image' => array(
            'enabled' => true,
            'binary' => "\"C:\wkhtmltopdf\bin\wkhtmltoimage.exe\"",
            'timeout' => false,
            'options' => array(),
            'env' => array(),
        ),
    );
} else {
    return array(
        'pdf' => array(
            'enabled' => true,
            'binary'  => base_path('vendor/h4cc/wkhtmltopdf-amd64/bin/wkhtmltopdf-amd64'),
    //        'binary' => '/usr/local/bin/wkhtmltopdf',
            'timeout' => false,
'options' => array(
            'encoding' => 'utf-8'
        ),            
'env' => array(),
        ),
        'image' => array(
            'enabled' => true,
            'binary' => base_path('vendor/barryvdh/wkhtmltox/bin/wkhtmltoimage'),
            'timeout' => false,
            'options' => array(),
            'env' => array(),
        ),
    );
}


/*
return array(

    'pdf' => array(
        'enabled' => true,
        'binary' => base_path('vendor/barryvdh/wkhtmltox/bin/wkhtmltopdf'),
        'timeout' => false,
        'options' => array(),
        'env' => array(),
    ),
    'image' => array(
        'enabled' => true,
        'binary' => base_path('vendor/barryvdh/wkhtmltox/bin/wkhtmltoimage'),
        'timeout' => false,
        'options' => array(),
        'env' => array(),
    ),

);

return array(

    'pdf' => array(
        'enabled' => true,
        'binary' => "\"C:\wkhtmltopdf\bin\wkhtmltopdf.exe\"",
        'timeout' => false,
        'options' => array(),
        'env' => array(),
    ),
    'image' => array(
        'enabled' => true,
        'binary' => "\"C:\wkhtmltopdf\bin\wkhtmltoimage.exe\"",
        'timeout' => false,
        'options' => array(),
        'env' => array(),
    ),

);
*/
