<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Import</title>
</head>
<body>
    @if($errors->any())
    @foreach ($errors->all() as $error)
        <div>{{ $error }}</div>
    @endforeach
    @endif

    @if(isset($added) || isset($duplicate))
    <div>
        Rows count: {{ $rowsCount}}</br>
        Rows added: {{ $added }}</br>
        Duplicates: {{ $duplicate }}</br>
    </div>
    @endif
</body>
</html>