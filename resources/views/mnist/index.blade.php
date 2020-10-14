<html>
<head>
    <title>Mnist</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" >
    <style>
        body{
            background-color: #EEFFEE;
        }
    </style>
</head>

<body>
<div class="container">
        <div class="row">
            <div class="col-sm-10">
                <h2>1-9の数字を認識します</h2>
                <p>{{$msg}}</p>

                <form method = "POST" action="/mnist" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="test_image"><BR>
                    <input type="submit" id="submit" value="送信">
                </form>
            </div>
        </div>

        <div class="row">
            @isset($image_pass)
                <div class="col-sm-5">
                    <h3>結果</h3>
                    <img src="{{ asset($image_pass)}}" width="112" height="112"> <BR>
                    @isset($result)
                        <p>この画像は「　{{$result}}　」です</p>
                    @endempty
                </div>
            @endempty

            @isset($outputs)
                <div class="col-sm-5">
                    <h3>Python出力( {{$lines}} 行)</h3>
                    @foreach ($outputs as $output)
                        {{$output}}<BR>
                    @endforeach
                </div>
            @endempty
        </div>
    </div>
</body>
</html>