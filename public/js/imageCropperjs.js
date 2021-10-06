    var imagesArray = []; // more efficient than new Array()
    var c;
    var galleryImagesContainer = document.getElementById('galleryImages');
    var imageCropFileInput = document.getElementById('imageCropFileInput');
    var cropperImageInitCanvas = document.getElementById('cropperImg');
    var cropImageButton = document.getElementById('cropImageBtn');
    var downloadImage = document.getElementById('downloadimage');
    var ratiobtn = document.getElementById('ratiobtn');
    var ratiofields = document.getElementById('ratiofields');
    var imageUploadDiv = document.getElementById('imageUploadDiv');
    var reselectimage = document.getElementById('reselectimage');
    var cropping_section =document.getElementById('cropping_section');
    var selectedcanvas = "imageCanvas0";
    var defaultdownloadformat;
    // Crop Function On change
    function imagesPreview(input) {
        var cropper;
        galleryImagesContainer.innerHTML = '';
        var img = [];
        if (cropperImageInitCanvas.cropper) {
            cropperImageInitCanvas.cropper.destroy();
            cropImageButton.style.display = 'none';
            downloadImage.style.display = ' none';
            reselectimage.style.display = ' none';
            ratiofields.style.display = ' none';
            ratiobtn.style.display = 'none';
            imageUploadDiv.style.display = 'block';
            cropping_section.style.display = 'none';

            cropperImageInitCanvas.width = 0;
            cropperImageInitCanvas.height = 0;
        }
        if (input.files.length) {
            var i = 0;
            var index = 0;
            for (let singleFile of input.files) {

                var reader = new FileReader();
                reader.onload = function (event) {
                    var blobUrl = event.target.result;

                    img.push(new Image());
                    img[i].onload = function (e) {

                        // Canvas Container
                        var singleCanvasImageContainer = document.createElement('div');
                        singleCanvasImageContainer.id = 'singleImageCanvasContainer' + index;
                        singleCanvasImageContainer.className = 'singleImageCanvasContainer';
                        // Canvas Close Btn
                        var singleCanvasImageCloseBtn = document.createElement('button');
                        var singleCanvasImageCloseBtnText = document.createTextNode('Close');
                        // var singleCanvasImageCloseBtnText = document.createElement('i');
                        // singleCanvasImageCloseBtnText.className = 'fa fa-times';
                        singleCanvasImageCloseBtn.id = 'singleImageCanvasCloseBtn' + index;
                        singleCanvasImageCloseBtn.className = 'singleImageCanvasCloseBtn';
                        singleCanvasImageCloseBtn.onclick = function () {
                            removeSingleCanvas(this)
                        };
                        singleCanvasImageCloseBtn.appendChild(singleCanvasImageCloseBtnText);
                        singleCanvasImageContainer.appendChild(singleCanvasImageCloseBtn);
                        // Image Canvas
                        filename = singleFile.name;
                        var canvas = document.createElement('canvas');
                        canvas.id = 'imageCanvas' + index;
                        canvas.className = 'imageCanvas singleImageCanvas';
                        canvas.width = e.currentTarget.width;
                        canvas.height = e.currentTarget.height;
                        canvas.setAttribute("data-name", filename);
                        // console.log(canvas.id);

                        canvas.onclick = function () {
                            selectedcanvas = canvas.id;
                            cropInit(canvas.id);
                        };
                        singleCanvasImageContainer.appendChild(canvas)
                        // Canvas Context
                        var ctx = canvas.getContext('2d');
                        ctx.drawImage(e.currentTarget, 0, 0);
                        // galleryImagesContainer.append(canvas);
                        galleryImagesContainer.appendChild(singleCanvasImageContainer);
                        while (document.querySelectorAll('.singleImageCanvas').length == input.files.length) {
                            var allCanvasImages = document.querySelectorAll('.singleImageCanvas')[0].getAttribute('id');
                            cropInit(allCanvasImages);
                            break;
                        }
                        ;

                        cropInit(canvas.id);
                        selectedcanvas = canvas.id;
                        urlConversion();
                        geturls(canvas.id);
                        index++;
                    };
                    img[i].src = blobUrl;
                    i++;
                }

                reader.readAsDataURL(singleFile);

            }
            // addCropButton();
            // cropImageButton.style.display = 'block';
        }
    }
    imageCropFileInput.addEventListener("change", function (event) {
        imagesPreview(event.target);
    });
    // Initialize Cropper
    function cropInit(selector, a = 9, b = 12, w = 0, h = 0) {
        c = document.getElementById(selector);

        // console.log(document.getElementById(selector));
        if (cropperImageInitCanvas.cropper) {
            cropperImageInitCanvas.cropper.destroy();
        }
        var allCloseButtons = document.querySelectorAll('.singleImageCanvasCloseBtn');
        for (let element of allCloseButtons) {
            element.style.display = 'block';
        }
        c.previousSibling.style.display = 'none';
        // c.id = croppedImg;
        var ctx = c.getContext('2d');
        var imgData = ctx.getImageData(0, 0, c.width, c.height);
        var image = cropperImageInitCanvas;

        image.width = c.width;
        image.height = c.height;
        if (w != 0 && w != '') {
            image.width = w;
        }
        if (h != 0 && h != '') {
            image.height = h;
        }
        var ctx = image.getContext('2d');
        ctx.putImageData(imgData, 0, 0);

        cropper = new Cropper(image, {
            aspectRatio: 16 / 9,
            preview: '.img-preview',
            crop: function (event) {
                cropImageButton.style.display = 'block';
                downloadImage.style.display = 'block';
                reselectimage.style.display = 'block';
                ratiobtn.style.display = 'block';
                ratiofields.style.display = 'block';
                cropping_section.style.display = 'block';
                imageUploadDiv.style.display = 'none  ';


            }
        });

    }
    function image_crop() {
        if (cropperImageInitCanvas.cropper) {
            var cropcanvas = cropperImageInitCanvas.cropper.getCroppedCanvas();
            // document.getElementById('cropImages').appendChild(cropcanvas);
            var ctx = cropcanvas.getContext('2d');
            var imgData = ctx.getImageData(0, 0, cropcanvas.width, cropcanvas.height);
            // var image = document.getElementById(c);
            c.width = cropcanvas.width;
            c.height = cropcanvas.height;
            var ctx = c.getContext('2d');
            ctx.putImageData(imgData, 0, 0);
            var allCloseButtons = document.querySelectorAll('.singleImageCanvasCloseBtn');
            for (let element of allCloseButtons) {
                element.style.display = 'block';
            }
            cropInit(selectedcanvas);
            urlConversion();
            /*var fi = document.getElementById('imageCropFileInput');
            if (fi.files.length > 0) {
                for (var i = 0; i <= fi.files.length - 1; i++) {

                    var fname = fi.files.item(i).name;      // THE NAME OF THE FILE.
                    var fsize = fi.files.item(i).size;      // THE SIZE OF THE FILE.
                }
            }*/

            geturls(selectedcanvas);
        } else {
            alert('Please select any Image you want to crop');
        }
    }
    cropImageButton.addEventListener("click", function () {
        image_crop();
    });
    // Image Close/Remove
    function removeSingleCanvas(selector) {
        selector.parentNode.remove();
        urlConversion();
    }
    function urlConversion() {
        var allImageCanvas = document.querySelectorAll('.singleImageCanvas');
        var convertedUrl = '';
        for (let element of allImageCanvas) {
            convertedUrl += element.toDataURL('image/jpeg');
            convertedUrl += 'img_url';
        }
        document.getElementById('profile_img_data').value = convertedUrl;
    }

    // Options
    $('.docs-toggles').on('change', 'input', function () {

        var $this = $(this);
        var type = $this.prop('type');
        var id = $this.prop('id');

        if (cropperImageInitCanvas.cropper) {
            if (type === 'radio') {
                $(".btn-group").find("label").removeClass('active');
                $this.parent().addClass("active");
                if ($this.val() == 1.7777777777777777) {
                    cropInit(selectedcanvas, 16, 9);
                } else if ($this.val() == 1.3333333333333333) {
                    cropInit(selectedcanvas, 4, 3);
                } else if ($this.val() == 1) {
                    cropInit(selectedcanvas, 1, 1);
                } else if ($this.val() == 0.6666666666666666) {
                    cropInit(selectedcanvas, 2, 3);
                }
            } else if (type === 'text') {
                var a = $('#dataWidth').val();
                var b = $('#dataHeight').val();
                cropInit(selectedcanvas, 9, 12, a, b);
            }
        } else {
            alert('Please select any Image you want to crop');
        }
    });

    function download() {

        $('#myModal').modal('show');
        var downloadformat = $('#downloadformat').val();
        $('#download').attr('href', cropperImageInitCanvas.toDataURL(downloadformat));
    }
    // cropInit(canvas.id);


    function geturls(selectedcanvas) {
        var downloadformat = $('#downloadformat').val();
        var defaultdownloadformat = $('#downloadformat').val();
        $("#defaultdownloadformat").val(defaultdownloadformat);
        var dataname = document.getElementById(selectedcanvas).getAttribute('data-name');
        // console.log(dataname);
        if (imagesArray) {
            for (var i = imagesArray.length - 1; i >= 0; i--) {
                if (imagesArray[i]['canvasid'] == selectedcanvas) {

                    imagesArray.splice(i, 1);

                }
            }
        }
        imagesArray.push({url: cropperImageInitCanvas.toDataURL(downloadformat), canvasid: selectedcanvas, filename: dataname});
    }

    function downloadimage() {

        var downloadformat = $('#downloadformat').val();
        var imageformat = downloadformat.split('/');
        $('#download').attr('href', cropperImageInitCanvas.toDataURL(downloadformat));
        $('#download').attr('download', "cropped." + imageformat[1]);
    }


    /* Download an img */
    function downloadsingle(img, i) {

        var link = document.createElement("a");
        link.href = img;
        link.download = "cropped" + i;
        link.style.display = "none";
        var evt = new MouseEvent("click", {
            "view": window,
            "bubbles": true,
            "cancelable": true
        });
        // console.log(link);
        document.body.appendChild(link);
        link.dispatchEvent(evt);
        document.body.removeChild(link);

    }

    /* Download all images in 'imgs'.
     * Optionaly filter them by extension (e.g. "jpg") and/or
     * download the 'limit' first only  */

    function downloadAll() {

        var downloadformat = $('#downloadformat').val();
        var defaultdownloadformat = $("#defaultdownloadformat").val();
        /* If specified, filter images by extension */

        for (var i = 0; i < imagesArray.length; i++) {
            var img = imagesArray[i]['url'];
            img = img.replace(defaultdownloadformat, downloadformat);
            downloadsingle(img, i);
        }
        $('#myModal').modal('toggle');
    }
    function urlToPromise(url) {
        return new Promise(function (resolve, reject) {
            JSZipUtils.getBinaryContent(url, function (err, data) {
                if (err) {
                    reject(err);
                } else {
                    resolve(data);
                }
            });
        });
    }

    function downloadZip() {
        var zip = new JSZip();
        var imgData;
        var downloadformat = $('#downloadformat').val();
        var imageformat = downloadformat.split('/');
        var defaultdownloadformat = $("#defaultdownloadformat").val();
        // console.log(imagesArray);
        // return false;
        for (var i = 0; i < imagesArray.length; i++) {
            imagename = imagesArray[i]['filename'];
            imagename = imagename.split(".");
            var filename = imagename[0] + '.' + imageformat[1];
            var img = imagesArray[i]['url'];
            var img = img.replace(defaultdownloadformat, downloadformat);
            zip.file(filename, urlToPromise(img), {binary: true});
        }
        zip.generateAsync({type: "blob"})
                .then(function callback(blob) {
                    saveAs(blob, "cropedfiles.zip");
                });
        $('#myModal').modal('toggle');
    }
    function reselectall() {
        $("#imageCropFileInput").val('');
        imagesPreview();
    }
