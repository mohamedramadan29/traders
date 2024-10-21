<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<h2> عزيزي {{ $name  }} ! </h2>
<br>
<p> من فضلك فعل الحساب الخاص بك من خلال الرابط :- </p>
<br>
<p><a href="{{url('user/confirm/'.$code)}}"> {{url('user/confirm/'.$code)}} </a></p>
<br>
<p> شكرا لك علي التسجيل </p>

</body>
</html>
