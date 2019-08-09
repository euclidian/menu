<?php

Route::post('/tiketux/menu/api/list/v1', 'Tiketux\Menu\Api\MenuApi@list_halaman');
Route::post('/tiketux/menu/api/detail/v1', 'Tiketux\Menu\Api\MenuApi@detail');
Route::post('/tiketux/menu/api/delete/v1', 'Tiketux\Menu\Api\MenuApi@delete');
Route::post('/tiketux/menu/api/save/v1', 'Tiketux\Menu\Api\MenuApi@save');

Route::get('/menu/api/list', 'Tiketux\Menu\Api\MenuApi@list');