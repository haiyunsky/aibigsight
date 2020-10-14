# -*- coding: utf-8 -*-
print('mnist_test.py START')
import sys
import tensorflow as tf
import cv2
import numpy as np
import DeepConvNet as CNN
#コマンドライン引数を取得
args = sys.argv

IMAGE_SIZE  = 28    # 画像サイズ
NUM_CLASSES = 10    # 識別数

if __name__ == "__main__":
    tf.reset_default_graph()

    print('設定 START')
    # 式に用いる変数設定
    x_image = tf.placeholder("float", shape=[None, IMAGE_SIZE * IMAGE_SIZE])    # 入力
    y_label = tf.placeholder("float", shape=[None, NUM_CLASSES]) # 出力
    keep_prob = tf.placeholder("float")

    # モデルを作成
    logits = CNN.CNN.makeMnistCNN(x_image, keep_prob , IMAGE_SIZE , NUM_CLASSES)
    sess = tf.InteractiveSession()

    saver = tf.train.Saver()
    #変数を初期化して実行
    sess.run(tf.global_variables_initializer())
    print('設定 END')

    print('Restore Param Start')
    ckpt = tf.train.get_checkpoint_state(args[1] + 'ckpt')
    #print(os.path.exists(args[1] + 'ckpt'))
    if ckpt: # checkpointがある場合
        last_model = ckpt.model_checkpoint_path # 最後に保存したmodelへのパス
        print ("Restore load:" + last_model)
        saver.restore(sess, last_model) # 変数データの読み込み
    else:
        print('Restore Failed')
    print('Restore Param End')


    # 画像読み込み
    inputNum = 1
    for count in range(int(inputNum)):
        fileName =  args[2]
        print('fileName:' + fileName)

        # 初期化
        ximage = []

        # 画像読み込み
        image = cv2.imread(fileName, cv2.IMREAD_GRAYSCALE)
        if not image is None:
            image = cv2.resize(image, (IMAGE_SIZE, IMAGE_SIZE))
            ximage = image.flatten().astype(np.float32)/255.0
        else:
            print('Error:File Read Failed !!')

        if len(ximage)!=0:
            pred = np.argmax(logits.eval(feed_dict={x_image: [ximage], keep_prob: 1.0})[0])

            print("result:" + str(pred))
    sess.close()
    print('mnist_test.py END')