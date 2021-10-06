<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="theme-color" content="#5600e3">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="mobile-web-app-capable" content="yes">
  <meta name="author" content="Debutify">
  <!--<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css" crossorigin="anonymous">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" crossorigin="anonymous">
  <link rel="stylesheet" href="https://unpkg.com/cropperjs/dist/cropper.css" crossorigin="anonymous">
  <link rel="stylesheet" href="{{ URL::asset('css/cropper.css') }}"> -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.4.0/cropper.css" crossorigin="anonymous">
  <link rel="stylesheet" href="{{ URL::asset('css/cropper.css') }}">
  <style>
  #galleryImages, #cropper{
    width: 100%;
    float: left;
    }
    canvas{
    max-width: 100%;
    display: inline-block;
    }
    #cropperImg{
    /*max-width: 0;
    max-height: 0;*/
    }
    #cropImageBtn{
    display: none;
    }
    img{
    width: 100%;
    }
    .img-preview{
    float: left;
    }
    .singleImageCanvasContainer{
      max-width: 300px;
      display: inline-block;
      position: relative;
      margin: 2px;
      border: 1px solid #ccc;
      border-radius: 3px;
    }
    .singleImageCanvasCloseBtn{
    position: absolute;
    top: 5px;
    right: 5px;
    }

  </style>
</head>
<body>
  <section class='debutify-section'>
    <div class="container">
      <div class="d-flex justify-content-center py-4">
        <input type="file" id="imageCropFileInput" multiple="" accept=".jpg,.jpeg,.png">
      </div>
    </div>
    <div class='container-fluid'>
      <input type="hidden" id="profile_img_data">
      <div class="row">
        <div class="col-md-2">
          <div id="galleryImages" class="d-flex flex-column mb-2"></div>
        </div>
        <div class="col-md-8 d-flex flex-column">
          <div id="cropper">
            <canvas id="cropperImg" width="0" height="0"></canvas>
          </div>

        </div>
        <div class="col-md-2 docs-toggles">
            <div class="img-preview"></div>
            <div class="docs-data">
              <div class="input-group input-group-sm">
                <span class="input-group-prepend">
                  <label class="input-group-text" for="dataWidth">Width</label>
                </span>
                <input type="text" class="form-control" id="dataWidth" placeholder="width">
                <span class="input-group-append">
                  <span class="input-group-text">px</span>
                </span>
              </div>
              <div class="input-group input-group-sm">
                <span class="input-group-prepend">
                  <label class="input-group-text" for="dataHeight">Height</label>
                </span>
                <input type="text" class="form-control" id="dataHeight" placeholder="height">
                <span class="input-group-append">
                  <span class="input-group-text">px</span>
                </span>
              </div>
            </div>
            <div class="btn-group d-flex flex-nowrap" data-toggle="buttons">
              <label class="btn btn-primary">
                <input type="radio" class="sr-only" id="aspectRatio0" name="aspectRatio" value="1.7777777777777777">
                <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="aspectRatio: 16 / 9">
                  16:9
                </span>
              </label>
              <label class="btn btn-primary">
                <input type="radio" class="sr-only" id="aspectRatio1" name="aspectRatio" value="1.3333333333333333">
                <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="aspectRatio: 4 / 3">
                  4:3
                </span>
              </label>
              <label class="btn btn-primary">
                <input type="radio" class="sr-only" id="aspectRatio2" name="aspectRatio" value="1">
                <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="aspectRatio: 1 / 1">
                  1:1
                </span>
              </label>
              <label class="btn btn-primary">
                <input type="radio" class="sr-only" id="aspectRatio3" name="aspectRatio" value="0.6666666666666666">
                <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="aspectRatio: 2 / 3">
                  2:3
                </span>
              </label>
              <!--label class="btn btn-primary">
                <input type="radio" class="sr-only" id="aspectRatio4" name="aspectRatio" value="NaN">
                <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="aspectRatio: NaN">
                  Free
                </span>
              </label-->
            </div>
            <button class="cropImageBtn btn btn-primary" id="cropImageBtn">Crop</button>

            <button class="btn btn-primary" id="downloadimage" onclick="download()">Download</button>

<!--<button class="btn btn-primary" id="downloadAll">Download All</button> -->
        </div>
      </div>
    </div>
  </section>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Download Image Format</h3>
    </div>
    <div class="modal-body">
        <select class="form-control" name="downloadformat" id="downloadformat" onchange="downloadimage()">
			<option value="image/jpeg">Choose Image Format</option>
			<option value="image/jpeg">jpg</option>
			<option value="image/png">png</option>
			<option value="image/jpeg">jpeg</option>
		<select>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        <a class="btn btn-primary" id="download"  href="javascript:void(0);" download="cropped.jpg">Download</a>
    </div>
 </div>
</div>
</div>
  <!--script src="https://unpkg.com/cropperjs/dist/cropper.js" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" crossorigin="anonymous"></script>
  <script src="{{ URL::asset('js/dist/jquery-cropper.js') }}"></script>
  <!--script src="{{ URL::asset('js/dist/main.js') }}"></script-->

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" crossorigin="anonymous"></script>

  <!--script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script-->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.4.0/cropper.js" crossorigin="anonymous"></script>
  <script>
    var c;
    var galleryImagesContainer = document.getElementById('galleryImages');
    var imageCropFileInput = document.getElementById('imageCropFileInput');
    var cropperImageInitCanvas = document.getElementById('cropperImg');
    var cropImageButton = document.getElementById('cropImageBtn');
	var selectedcanvas="imageCanvas0";
    // Crop Function On change
    function imagesPreview(input) {
      var cropper;
      galleryImagesContainer.innerHTML = '';
      var img = [];
      if(cropperImageInitCanvas.cropper){
        cropperImageInitCanvas.cropper.destroy();
        cropImageButton.style.display = 'none';
        cropperImageInitCanvas.width = 0;
        cropperImageInitCanvas.height = 0;
      }
      if (input.files.length) {
        var i = 0;
        var index = 0;
        for (let singleFile of input.files) {
          var reader = new FileReader();
          reader.onload = function(event) {
            var blobUrl = event.target.result;
            img.push(new Image());
            img[i].onload = function(e) {
              // Canvas Container
              var singleCanvasImageContainer = document.createElement('div');
              singleCanvasImageContainer.id = 'singleImageCanvasContainer'+index;
              singleCanvasImageContainer.className = 'singleImageCanvasContainer';
              // Canvas Close Btn
              var singleCanvasImageCloseBtn = document.createElement('button');
              var singleCanvasImageCloseBtnText = document.createTextNode('Close');
              // var singleCanvasImageCloseBtnText = document.createElement('i');
              // singleCanvasImageCloseBtnText.className = 'fa fa-times';
              singleCanvasImageCloseBtn.id = 'singleImageCanvasCloseBtn'+index;
              singleCanvasImageCloseBtn.className = 'singleImageCanvasCloseBtn';
              singleCanvasImageCloseBtn.onclick = function() { removeSingleCanvas(this) };
              singleCanvasImageCloseBtn.appendChild(singleCanvasImageCloseBtnText);
              singleCanvasImageContainer.appendChild(singleCanvasImageCloseBtn);
              // Image Canvas
              var canvas = document.createElement('canvas');
              canvas.id = 'imageCanvas'+index;
              canvas.className = 'imageCanvas singleImageCanvas';
              canvas.width = e.currentTarget.width;
              canvas.height = e.currentTarget.height;
              canvas.onclick = function() { selectedcanvas=canvas.id; cropInit(canvas.id); };
              singleCanvasImageContainer.appendChild(canvas)
              // Canvas Context
              var ctx = canvas.getContext('2d');
              ctx.drawImage(e.currentTarget,0,0);
              // galleryImagesContainer.append(canvas);
              galleryImagesContainer.appendChild(singleCanvasImageContainer);
              while (document.querySelectorAll('.singleImageCanvas').length == input.files.length) {
                var allCanvasImages = document.querySelectorAll('.singleImageCanvas')[0].getAttribute('id');
                cropInit(allCanvasImages);
                break;
              };
              urlConversion();
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
    imageCropFileInput.addEventListener("change", function(event){
      imagesPreview(event.target);
    });
    // Initialize Cropper
    function cropInit(selector,a=9,b=12,w=0,h=0) {
      c = document.getElementById(selector);
      console.log(document.getElementById(selector));
      if(cropperImageInitCanvas.cropper){
          cropperImageInitCanvas.cropper.destroy();
      }
      var allCloseButtons = document.querySelectorAll('.singleImageCanvasCloseBtn');
      for (let element of allCloseButtons) {
        element.style.display = 'block';
      }
      c.previousSibling.style.display = 'none';
      // c.id = croppedImg;
      var ctx=c.getContext('2d');
      var imgData=ctx.getImageData(0, 0, c.width, c.height);
      var image = cropperImageInitCanvas;

      image.width = c.width;
      image.height = c.height;
	  if(w!=0 && w!=''){
		  image.width=w;
	  }
	  if(h!=0 && h!=''){
		  image.height=h;
	  }
      var ctx = image.getContext('2d');
      ctx.putImageData(imgData,0,0);

	  cropper = new Cropper(image, {
        aspectRatio: a / b,
        preview: '.img-preview',
        crop: function(event) {
          cropImageButton.style.display = 'block';
        }
      });

    }
    // Initialize Cropper on CLick On Image
    // function cropInitOnClick(selector) {
    //   if(cropperImageInitCanvas.cropper){
    //       cropperImageInitCanvas.cropper.destroy();
    //       // cropImageButton.style.display = 'none';
    //       cropInit(selector);
    //       // addCropButton();
    //       // cropImageButton.style.display = 'block';
    //   } else {
    //       cropInit(selector);
    //       // addCropButton();
    //       // cropImageButton.style.display = 'block';
    //   }
    // }
    // Crop Image
    function image_crop() {
      if(cropperImageInitCanvas.cropper){

        var cropcanvas = cropperImageInitCanvas.cropper.getCroppedCanvas();
        // document.getElementById('cropImages').appendChild(cropcanvas);
        var ctx=cropcanvas.getContext('2d');
          var imgData=ctx.getImageData(0, 0, cropcanvas.width, cropcanvas.height);
          // var image = document.getElementById(c);
          c.width = cropcanvas.width;
          c.height = cropcanvas.height;
          var ctx = c.getContext('2d');
          ctx.putImageData(imgData,0,0);
          /*cropperImageInitCanvas.cropper.destroy();
          cropperImageInitCanvas.width = 0;
          cropperImageInitCanvas.height = 0;
          cropImageButton.style.display = 'none';*/
          var allCloseButtons = document.querySelectorAll('.singleImageCanvasCloseBtn');
          for (let element of allCloseButtons) {
            element.style.display = 'block';
          }
		  cropInit(selectedcanvas);
          urlConversion();
		  // download();
          // cropperImageInitCanvas.style.display = 'none';
      } else {
        alert('Please select any Image you want to crop');
      }
    }
    cropImageButton.addEventListener("click", function(){
      image_crop();
    });
    // Image Close/Remove
    function removeSingleCanvas(selector) {
      selector.parentNode.remove();
      urlConversion();
    }
    // Dynamically Add Crop Btn
    // function addCropButton() {
    //   // add crop button
    //     var cropBtn = document.createElement('button');
    //     cropBtn.setAttribute('type', 'button');
    //     cropBtn.id = 'cropImageBtn';
    //     cropBtn.className = 'btn btn-block crop-button';
    //     var cropBtntext = document.createTextNode('crop');
    //     cropBtn.appendChild(cropBtntext);
    //     document.getElementById('cropper').appendChild(cropBtn);
    //     cropBtn.onclick = function() { image_crop(cropBtn.id); };
    // }
    // Get Converted Url
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

	if(cropperImageInitCanvas.cropper){
	if (type === 'radio') {
	$(".btn-group").find("label").removeClass('active');
	 $this.parent().addClass("active");
      if($this.val()==1.7777777777777777){
			cropInit(selectedcanvas,16,9);
	  }else if($this.val()==1.3333333333333333){
		cropInit(selectedcanvas,4,3);
	  }else if($this.val()==1){
		cropInit(selectedcanvas,1,1);
	  }else if($this.val()==0.6666666666666666){
		cropInit(selectedcanvas,2,3);
	  }
    }else if (type === 'text') {
		var a=$('#dataWidth').val();
		var b=$('#dataHeight').val();
		cropInit(selectedcanvas,9,12,a,b);
	}
	 } else {
        alert('Please select any Image you want to crop');
      }
  });

  function download(){
	  $('#myModal').modal('show');
	  var downloadformat = $('#downloadformat').val();
	  $('#download').attr('href', cropperImageInitCanvas.toDataURL(downloadformat));
  }
  function downloadimage(){
	  var downloadformat = $('#downloadformat').val();
      $('#download').attr('href', cropperImageInitCanvas.toDataURL(downloadformat));
  }
  </script>
</body>
</html>
