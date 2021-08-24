<?php
/**
 * This file is part of webman.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the MIT-LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author    walkor<walkor@workerman.net>
 * @copyright walkor<walkor@workerman.net>
 * @link      http://www.workerman.net/
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */

use Webman\Route;

Route::fallback(fn() => json(200, 'Not Found!'));

Route::post('/login', 'app\Users\Presentation\AuthenticationPresentation@login');
Route::post('/register', 'app\Users\Presentation\AuthenticationPresentation@register');
Route::group('/users', function () {
    Route::get('/index', 'app\Users\Presentation\UsersPresentation@index');
    Route::get('/{id}', 'app\Users\Presentation\UsersPresentation@get');
    Route::delete('/delete/{id}', 'app\Users\Presentation\UsersPresentation@delete');
    Route::post('/update', 'app\Users\Presentation\UsersPresentation@update');
    Route::post('/updatePassword', 'app\Users\Presentation\UsersPresentation@updatePassword');
})->middleware([support\middleware\CheckLogin::class]);
Route::get('/systemStatus', 'app\Presentation\SystemStatusPresentation@getSystemStatus')
    ->middleware([support\middleware\CheckLogin::class]);