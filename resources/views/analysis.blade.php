<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>jieba-js demo</title>
    <script>
        (function (i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r; i[r] = i[r] || function () {
            (i[r].q = i[r].q || []).push(arguments)
        }, i[r].l = 1 * new Date(); a = s.createElement(o),
            m = s.getElementsByTagName(o)[0]; a.async = 1; a.src = g; m.parentNode.insertBefore(a, m)
        })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

        ga('create', 'UA-37178375-7', 'auto');
        ga('send', 'pageview');
    </script>
    <style>
        html,
        body {
            height: 100%;
            width: 100%;
            margin: 0;
            padding: 0;
        }

        #myChart {
            height: 100%;
            width: 100%;
            min-height: 150px;
        }

        .zc-ref {
            display: none;
        }

        
    input.input-field[type='file'] {
        display: none;
    }
    </style>
</head>

<body>
    <script src="js/zingchart.min.js"></script>
    <script>
        zingchart.MODULESDIR = "https://cdn.zingchart.com/modules/";
        ZC.LICENSE = ["569d52cefae586f634c54f86dc99e6a9", "ee6b7db5b51705a13dc2339db3edaf6d"];
    </script>
    <script src="js/jquery.js"></script>
    <script src="js/require-jieba-js.js"></script>
    <link rel="stylesheet" href="css/semantic.min.css" />
    <script src="js/semantic.min.js"></script>
    <!-- <script src="html-lib/Garlic.js/garlic.js"></script> -->
    <script src="js/input-file-loader.js"></script>
    <script src="js/FileSaver.js"></script>
    <script src="js/puli-util.clipboard.js"></script>

    <form onsubmit="return false;" class="ui form" data-persist="garlic">
        <div class="ui grid container">


            <!-- <div class="eight wide column"> -->


            <div class="sixteen wide column field" style="display: none">
                <button type="submit" class="fluid primary ui button" id="trigger">開始斷詞</button>
            </div>


        </div>
        <!-- <div class="ui grid container"> -->
        <div id="myChart"></div>
        <script>
            $(function () {
                var _form = $("form");
                var _submit_button = _form.find('button#trigger');
                _submit_button.click(function () {
                    var _text ="{{ $comments  }} ";
            
                    //console.log(_text);
                    var _submit = $(this).find("button#trigger");
                    _submit.attr("disabled", "disabled");
                    _submit.html("處理中...");
                    $("body").css("cursor", "wait");

                    var _custom_dict = _load_custom_dict();
                    //console.log(_custom_dict);

                    call_jieba_cut(_text, _custom_dict, function (_result) {
                        _result = _filter_stop_words(_result);

                        _result = _result.join(" ");
                        while (_result.indexOf("  ") > -1) {
                            _result = _result.replace(/  /g, ' ');
                        }
                        _result = _result.replace(/ \n /g, "\n");
                        _result = _result.replace(/ \t /g, "\t");
                        _result = _result.replace(/ \' /g, "'");
                        _result = _result.replace(/\' /g, "'");
                        _result = _result.trim();
                        
                        var myConfig = {
                            type: 'wordcloud',
                            options: {
                                text: _result,
                            }
                        };

                        zingchart.render({
                            id: 'myChart',
                            data: myConfig,
                            height: 400,
                            width: '100%'
                        });
                        _submit.removeAttr("disabled");
                        _submit.html("開始斷詞");
                        $("body").css("cursor", "default");
                    });
                    return false;
                });

                /*
                _load_file("user_dict.txt", "user_dict", function () {
                    _load_file("stop_words.txt", "stop_words", function () {
                        setTimeout(function () {
                            //_submit_button.click();
                        }, 0);
                    });
                });
                */

                _submit_button.click();
            });

            var _load_file = function (_url, _textarea_id, _callback) {
                $.get(_url, function (_result) {
                    $("#" + _textarea_id).val(_result);
                    if (typeof (_callback) === "function") {
                        _callback();
                    }
                });
            };

            var _load_custom_dict = function () {
                var _config = ["漫畫,9999999,n"];
                var _output = [];
                for (var _l in _config) {
                    var _line = _config[_l].split(",");
                    _output.push([
                        _line[0].trim(),
                        parseInt(_line[1]),
                        _line[2]
                    ]);
                }
                return _output;
            };

            var _filter_stop_words = function (_result) {
                var _stopwords = ["這個", "，", "、", "。", "！"];
                for (var _s in _stopwords) {
                    _stopwords[_s] = _stopwords[_s].trim();
                }

                var _output = [];
                for (var _r in _result) {
                    var _word = _result[_r].trim();
                    if (_stopwords.indexOf(_word) === -1) {
                        _output.push(_word);
                    }
                }
                return _output;
            };


        </script>

</body>

</html>