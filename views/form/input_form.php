<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Form</title>
    <link rel="stylesheet" href="/css/app.css">
</head>
<body>
<div class="container mt-5">
    <form method="post" action="create" enctype="multipart/form-data">
        <input placeholder="<?=$placeholder?>" id="name" class="form-control" type="text" name="name"/>
        <input class="form-control" type="file" name="doc" accept="application/pdf"/><br>
        <button class="btn btn-primary">Upload</button>
    </form>
</div>
</body>
</html>