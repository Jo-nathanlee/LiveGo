$(function () {
    $(".editicon_pic").css({ top: $("#blah").height() / 4, left: $("#blah").width() * 1.34 });
    var options =
    {
        imageBox: '.imageBox',
        thumbBox: '.thumbBox',
        spinner: '.spinner',
        imgSrc: 'avatar.png'
    }
    var cropper;
    options.imgSrc = "img/59891.jpg";
    cropper = new cropbox(options);
    cropper.zoomStart();
    document.querySelector('#btnCrop').addEventListener('click', function () {
        var img = cropper.getDataURL()
        $('#pictureEdit_upload').attr('src', img);
        $("#activity").addClass("d-none");
    })
    document.querySelector('#btnZoomIn').addEventListener('click', function () {
        cropper.zoomIn();
    })
    document.querySelector('#btnZoomOut').addEventListener('click', function () {
        cropper.zoomOut();
    })
});