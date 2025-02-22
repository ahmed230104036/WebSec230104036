<?php
use Illuminate\Support\Facades\Route;
Route::get('/', function () {
 return view('welcome');
});
Route::get('/', function () {
    return view('welcome'); //welcome.blade.php
   });
   Route::get('/multable', function () {
    return view('multable'); //multable.blade.php
   });
   Route::get('/even', function () {
    return view('even'); //even.blade.php
   });
   Route::get('/prime', function () {
    return view('prime'); //prime.blade.php
   });

Route::get('/multable', function () {
 $j = 6;
 return view('multable', compact('j')); //multable.blade.php
});
<div class="card m-4 col-sm-2">
 <div class="card-header">{{$j}} Multiplication Table</div>
 <div class="card-body">
 <table>
 @foreach (range(1, 10) as $i)
 <tr><td>{{$i}} * {{$j}}</td><td> = {{ $i * $j }}</td></li>
 @endforeach
 </table>
 </div>
 </div> 
 ?>