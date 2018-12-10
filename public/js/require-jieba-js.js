// <script data-main="scripts/main" src="scripts/require.js"></script>

var _JIEBA_CUT_QUEUE = [];

/**
 * 自訂詞典
 * @type JSON
 */
JIEBA_CUSTOM_DICTIONARY = undefined;

call_jieba_cut = function (_text, _dict, _callback) {
	
    if (typeof(_dict) === "function") {
        _callback = _dict;
        _dict = undefined;
    }
	
    if (typeof(_callback) !== "function") {
        return;
    }

    if (typeof(_dict) === "string" || Array.isArray(_dict)) {
        JIEBA_CUSTOM_DICTIONARY = _dict;
    }
    
    if (typeof(jieba_cut) !== 'function') {
        //console.log("set queue:" + _text);
        _JIEBA_CUT_QUEUE.push({
            text: _text,
            callback: _callback
        });
    }
    else {
        if (typeof(_callback) === 'function') {
            var _result = jieba_cut(_text);
            _callback(_result);
        }
    }
};

call_jieba_cut_join = function (_text, _join, _callback) {
    if (typeof(_callback) !== "function") {
        return;
    }
    
    call_jieba_cut(_text, function (_result) {
        _result = _result.join(_join);
        while (_result.indexOf("  ") > -1) {
            _result = _result.replace(/  /g, ' ');
        }
        if (typeof(_callback) === "function") {
            _callback(_result);
        }
    });
};

resume_jieba_cut = function () {
    //console.log(_JIEBA_CUT_QUEUE.length);
    for (var _i = 0; _i < _JIEBA_CUT_QUEUE.length; _i++) {
        var _text = _JIEBA_CUT_QUEUE[_i].text;
        var _callback = _JIEBA_CUT_QUEUE[_i].callback;
        call_jieba_cut(_text, _callback);
    }
};

// ------------------------------------------------------




// ------------------------------------------------------

var _endsWith = function(_str, searchString, position) {
    if (_str === undefined) {
        return false;
    }
    var subjectString = _str.toString();
    if (typeof position !== 'number' 
            || !isFinite(position) 
            || Math.floor(position) !== position 
            || position > subjectString.length) {
        position = subjectString.length;
    }
    position -= searchString.length;
    var lastIndex = subjectString.lastIndexOf(searchString, position);
    return lastIndex !== -1 && lastIndex === position;
};

get_host = function () {
    var _host = undefined;
    var scripts = document.getElementsByTagName("script");
    for (var i = 0; i < scripts.length; ++i) {
        var _src = scripts[i].src;
        //console.log(_src);
        if (_endsWith(_src, "/require-jieba-js.js")) {
            _host = _src;
            break;
        }
    }

    if (_host === undefined) {
        _host = "//pulipulichen.github.io/jieba-js/";
    }
    else {
        _host = _host.substr(0, _host.lastIndexOf("require-jieba-js.js"));
    }
    console.log("host: " + _host);
    return _host;
};

if (typeof (document) === "object") {
    var _host = get_host();

    var s = document.createElement("script");
    s.type = "text/javascript";
    s.setAttribute("data-main", _host + "scripts/main");
    s.src = _host + "scripts/require.js";
    document.body.appendChild(s);
}
