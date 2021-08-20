<?php

Route::any('/login/instant/{user_id}', function(){
    return redirect(route('index'), 301);
});

Route::any('/login/instant/{user_id}/{username}', function(){
    return redirect(route('index'), 301);
});

Route::group(array('prefix' => 'form1/demo/'), function () {
    Route::get('{any}', function(){
        return redirect(route('index'), 301);
    });
});

Route::group(array('prefix' => 'admin/demo/'), function () {
    Route::get('{any}', function(){
        return redirect(route('index'), 301);
    });
});

Route::any('portal/home%E6%8F%90%E5%87%BA%E8%B5%94%E5%81%BF%E3', function(){
    return redirect(route('index'), 301);
});
