<html>
<head>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div id="app" class="container">
        <br>
        <h3>ウェブカメラで名刺を読みとってデータ入力する</h3>
        <div class="row">
            <div class="col-md-4 form-group">
                <label>名前</label>
                <input type="text" class="form-control form-control-sm" v-model="params.name">
            </div>
            <div class="col-md-4 form-group">
                <label>会社名</label>
                <input type="text" class="form-control form-control-sm" v-model="params.organization">
            </div>
            <div class="col-md-4 form-group">
                <label>住所</label>
                <input type="text" class="form-control form-control-sm" v-model="params.address">
            </div>
            <div class="col-md-4 form-group">
                <label>TEL</label>
                <input type="text" class="form-control form-control-sm" v-model="params.tel">
            </div>
            <div class="col-md-4 form-group">
                <label>E-Mail</label>
                <input type="text" class="form-control form-control-sm" v-model="params.email">
            </div>
            <div class="col-md-4 form-group">
                <label>URL</label>
                <input type="text" class="form-control form-control-sm" v-model="params.url">
            </div>
        </div>
        <hr>
        <h5>
            名刺をウェブカメラに見せて「キャプチャ」ボタンをクリックしてください。<br>
            3秒後に画像がキャプチャされます。
        </h5>
        <div v-show="isModeVideo">
            <div class="float-right">
                <span class="text-right" v-if="this.timeCount > 0">
                    @{{ timeCount }} 秒
                    &nbsp;&nbsp;&nbsp;
                </span>
                <button type="button" class="btn btn-warning" @click="capture">キャプチャ</button>
            </div>
            <video ref="video" width="640" height="480"></video>
        </div>
        <div v-show="isModeImage">
            <div class="float-right">
                キャプチャしました。<br>この画像から情報を読みとりますか？
                <br>
                <div class="text-right">
                    <button type="button" class="btn btn-light" @click="cancel">キャンセル</button>
                    <button type="button" class="btn btn-success" @click="extract">OK</button>
                </div>
                <div style="white-space:pre;" v-if="extractedText">
                    <hr>
                    <span class="badge badge-primary">取得されたテキスト</span>
                    <div v-text="extractedText" @mouseup="selection"></div>
                </div>
            </div>
            <canvas ref="canvas" width="640" height="480"></canvas>
        </div>
        <!-- モーダル -->
        <div class="modal fade" id="modal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">自動入力する項目を選択してください</h5>
                    </div>
                    <div class="modal-body">
                        <strong>選択されたテキスト：</strong> <span v-text="selectedText"></span>
                        <br>
                        <br>
                        <h3 class="float-left" v-for="(text,key) in inputs">
                            <a class="badge badge-primary" href="#" v-text="text" @click.prevent="enterText(key)"></a>&nbsp;
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.10/dist/vue.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.0/axios.min.js"></script>
    <script>

        new Vue({
            el: '#app',
            data: {
                params: {
                    name: '',
                    organization: '',
                    address: '',
                    tel: '',
                    email: '',
                    url: ''
                },
                inputs: {
                    name: '名前',
                    organization: '会社名',
                    address: '住所',
                    tel: 'TEL',
                    email: 'E-Mail',
                    url: 'URL'
                },
                imageData: null,
                mode: 'video',
                timeCount: 0,
                extractedText: '',
                selectedText: ''
            },
            computed: {
                video() {

                    return this.$refs['video'];

                },
                canvas() {

                    return this.$refs['canvas'];

                },
                context() {

                    return this.canvas.getContext('2d');

                },
                isModeVideo() {

                    return (this.mode === 'video');

                },
                isModeImage() {

                    return (this.mode === 'image');

                }
            },
            methods: {
                capture() {

                    this.timeCount = 3;

                    // ３秒後に画像をキャプチャ
                    const timer = setInterval(() => {

                        if(this.timeCount === 1) {

                            clearInterval(timer);
                            const video = this.video;
                            this.context.drawImage(video, 0, 0, video.videoWidth, video.videoHeight);
                            this.imageData = this.canvas.toDataURL('image/jpeg', 1.0);
                            this.mode = 'image';

                        }

                        this.timeCount -= 1;

                    }, 1000);

                },
                cancel() {

                    this.mode = 'video';

                },
                extract() {

                    const url = '/business_card/extract';
                    const formData = new FormData();
                    formData.append('image', this.imageData);

                    axios.post(url, formData)
                        .then((response) => {

                            const result = response.data.result;

                            if(result) {

                                this.extractedText = response.data.text;

                            }

                        });

                },
                selection() {

                    this.selectedText = window.getSelection().toString();

                    if(this.selectedText !== '') {

                        $('#modal').modal('show');

                    }

                },
                enterText(targetKey) {

                    let newParams = {};

                    for(let key in this.params) {

                        if(key === targetKey) {

                            newParams[key] = this.selectedText;

                        } else {

                            newParams[key] = this.params[key];

                        }

                    }

                    this.params = newParams;
                    $('#modal').modal('hide');
                    window.getSelection().empty();

                }
            },
            mounted() {

                // ウェブカメラへアクセス
                navigator.mediaDevices.getUserMedia({ video: true })
                    .then((stream) => {

                        this.video.srcObject = stream;
                        this.video.play();

                    });

            }
        });

    </script>
</body>
</html>