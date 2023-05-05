<?php

use App\Models\TimeTable;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function (\Illuminate\Http\Request $request) {
    return $request->test??'null';
});

Route::get('/test',function (){
    $test = str_replace("\\","","\http://mes-backend.test/storage/xlsxs/us\\ers/EmfOvzCviXuPVR05QzZC\\PrSTD89CDjl8DvexOODI.xlsx\\");
    dd($test);
});
