<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Örnek Form</title>
</head>
<body>
    <form method="post" action="{{route('sonuc')}}">
        @csrf
        <textarea name="metin" ></textarea><br>
        <input type="submit" value="Gönder" name="ilet">
    </form>
</body>
</html>