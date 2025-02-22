<!-- <!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <title>Bootstrap Test</title>
 <link href="public/css/bootstrap.min.css" rel="stylesheet">
 <script src="public/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="card m-4">
 <div class="card-header">Basic Web Page with Bootstrap</div>
 <div class="card-body">Lorem ipsum dolor ...</div>
 </div>
 @php($j = 5)
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
<div class="card">
 <div class="card-header">Even Numbers</div>
 <div class="card-body">
 @foreach (range(1, 100) as $i)
 @if($i%2==0)
 <span class="badge bg-primary">{{$i}}</span>
 @else
 <span class="badge bg-secondary">{{$i}}</span>
 @endif
 @endforeach
 </div>
</div>
<?php
//  function isPrime($number) {
//  if($number<=1) return false;
//  $i = $number - 1;
//  while($i>1) {
//  if($number%$i==0) return false;
//  $i--;
//  }
//  return true;
//  }
?>

<div class="card m-4">
 <div class="card-header">Prime Numbers</div>
 <div class="card-body">
 @foreach (range(1, 100) as $i)
 @if(isPrime($i))
 <span class="badge bg-primary">{{$i}}</span>
 @else
 <span class="badge bg-secondary">{{$i}}</span>
 @endif
 @endforeach
 </div>
</div>
<body>
 <nav class="navbar navbar-expand-sm bg-light">
 <div class="container-fluid">
 <ul class="navbar-nav">
 <li class="nav-item">
 <a class="nav-link" href="./">Home</a>
 </li>
 <li class="nav-item">
 <a class="nav-link" href="./even">Even Numbers</a>
 </li>
 <li class="nav-item">
 <a class="nav-link" href="./prime">Prime Numbers</a>
 </li>
 <li class="nav-item">
 <a class="nav-link" href="./multable">Multiplication Table</a>
 </li>
 </ul>
 </div>
 </nav>
 <div class="card m-4">
 <div class="card-body">
 Welcome to Home Page
 </div>
 </div>
</body> 
</body>
</html> -->