<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Örnek Form</title>
</head>
<body>
    <form method="post" action="{{route('iletisimsonuc')}}">
        @csrf
        <label>Ad Soyad</label></br>
        <input type="text" name="adsoyad"></br>
        <label>Telefon</label></br>
        <input type="text" name="telefon"></br>
        <label>E-Mail</label></br>
        <input type="text" name="mail"></br>
        <label>Mesaj</label></br>
        <textarea name="metin" ></textarea><br>
        <input type="submit" value="Gönder" name="ilet">
    </form>
</body>
</html>