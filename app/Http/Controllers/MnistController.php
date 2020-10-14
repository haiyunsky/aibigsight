<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MnistController extends Controller
{
    //
    public function index(Request $request)
    {
        $data = [
            'msg' => "画像を入力してください",
        ];
        return view('mnist.index', $data);
    }

    public function test(Request $request)
    {
        if(!empty($request->test_image))
        {
            // POSTで送信された画像を取得します
            $image = $request->file('test_image');
            // 保存先は"storage/app/public/image"になります
            // ファイル名は自動で割り振られます
            $up_pass = $image->store('public/image');
            $image_pass = "./storage/image/".basename($up_pass);
            // Pythonのファイルがあるパスを設定
            $pythonPath =  "../app/Python/";
            $command = "/python " . $pythonPath . "mnist_test.py " . $pythonPath . " " .$image_pass;

            exec($command , $outputs);

            //正規表現で結果行の抽出
            $results = preg_grep('/result:.*/' , $outputs);
            if(count($results) == 1){
                // 連想配列の先頭を取得
                $result = reset($results);
                $result = substr($result , strlen('result:') , 1 );
            } 
            else {
                $result = "解析に失敗しました。";
            }
            $data = [
                'msg' => "あってますか？",
                'image_pass' => $image_pass,
                'result'  => $result,
                'lines'   => count($outputs),
                'outputs' => $outputs,
            ];
        }
        else {
            $data = [
                'msg' => "画像がありません",
            ];
        }
        return view('mnist.index', $data);
    }
}
