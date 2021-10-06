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
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.4.0/cropper.css" crossorigin="anonymous">
<!-- <link rel="stylesheet" href="{{ URL::asset('css/cropper.css') }}"> -->
<style>
    #galleryImages, #cropper{
        width: 100%;
        float: left;
    }
    canvas{
        max-width: 100%;
        display: inline-block;
    }
    #ratiobtn{
        display: none;
    }
    #ratiofields{
        display: none;
    }
    #cropImageBtn{
        display: none;
    }
    #downloadimage{
        display: none;
    }
    #reselectimage{
        display: none;
    }
    img{
        width: 100%;
    }
    .img-preview{
        float: left;
        margin-bottom: 0.5rem;
        margin-right: 0.5rem;
        overflow: hidden;
    }
    .singleImageCanvasContainer{
        max-width: 300px;
        display: inline-block;
        position: relative;
        margin: 2px;
        border: 1px solid #ccc;
        border-radius: 3px;
        margin-bottom: 15px;
    }
    .singleImageCanvasCloseBtn{
        position: absolute;
        top: 5px;
        right: 5px;
    }
    .uploadFiles {
        height: 75vh;
        display: flex;
    }
    .btn-primary {
        color: #fff;
        background-color: #5600e3;
        border-color: #5600e3;
    }
   .btn-primary:hover {
       color: #fff;
       background-color: #4800bd;
       border-color: #4300b0;
   }
    #cropping_section{
      display: none;
    }

</style>
</head>
<body>
<section class='debutify-section'>
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div id="imageUploadDiv" class="justify-content-center align-items-start py-4 uploadFiles">
            <div class="border rounded d-flex justify-content-center align-items-center p-5 shadow bg-white">
              <input type="file" id="imageCropFileInput" multiple="" accept=".jpg,.jpeg,.png">
              <p id="fp"></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class='debutify-section'   >
    <div class='container-fluid py-5'  >
      <div class="col-md-12">
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
            <div class="col-md-2 docs-toggles" id="cropping_section">
              <div class="border p-2 rounded">
                <div class="img-preview preview-lg" ></div>
                <div class="docs-data" id="ratiofields">
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
                <div class="mb-2" id="ratiobtn" data-toggle="buttons">
                  <div class="btn-group d-flex">
                    <label class="btn btn-primary mr-1">
                        <input type="radio" class="sr-only" id="aspectRatio0" name="aspectRatio" value="1.7777777777777777">
                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="aspectRatio: 16 / 9">
                            16:9
                        </span>
                    </label>
                    <label class="btn btn-primary mr-1">
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
                    <label class="btn btn-primary ml-1">
                        <input type="radio" class="sr-only" id="aspectRatio3" name="aspectRatio" value="0.6666666666666666">
                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="aspectRatio: 2 / 3">
                            2:3
                        </span>
                    </label>
                  </div>
                </div>
                  <div class="btn-group d-flex flex-wrap mb-2">
                    <button class="cropImageBtn btn btn-primary mr-1" id="cropImageBtn">Crop</button>
                    <button class="btn btn-primary" id="downloadimage" onclick="download()">Download</button>
                  </div>
                  <div class="btn-group d-flex flex-wrap mb-2 ">
                    <button class="btn btn-primary" id="reselectimage" onclick="reselectall()">Reselect Images</button>
                  </div>
                </div>
            </div>
          </div>
      </div>
    </div>
  <input type="hidden" name="defaultdownloadformat" id="defaultdownloadformat">
</section>

<!-- Modal -->
<div id="myModal" class="modal fade show" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <h3 id="myModalLabel">Download Image Format</h3>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <select class="form-control" name="downloadformat" id="downloadformat" onchange="downloadimage()">
                    <option value="image/jpeg">Choose Image Format</option>
                    <option value="image/jpeg">jpg</option>
                    <option value="image/png">png</option>
                    <option value="image/jpeg">jpeg</option>
                </select>
            </div>
            <div class="modal-footer">
                <div id="croppedimages" >
                    <a class="btn btn-primary " id="downloadall"  onclick="downloadZip()" >Download All</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.4.0/cropper.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.7.1/jszip.min.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.0/FileSaver.min.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip-utils/0.1.0/jszip-utils.min.js" crossorigin="anonymous"></script>

<script type="text/javascript" src="js/imageCropperjs.js" ></script>
</body>
</html>
