<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- <link rel="icon" href="<%= BASE_URL %>favicon.ico"> -->

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <!--annotator css -->
    <link rel="stylesheet" href="/js/annotatorjs/annotator.min.css">

    <!-- annotator plugins css -->
    <link rel="stylesheet" type="text/css" href="/js/annotatorjs/dist/main.css">
    <link rel="stylesheet" href="/js/annotatorjs/plugins/annotator-marginalia-master/src/styles/annotator.marginalia.css">

    <title>Teachers</title>
  </head>
  <body>
    <noscript>
      <strong>You need to enable javasccript to view this page.</strong>
    </noscript>

    {{-- <div class="sss"></div> --}}

    <div id="app">
    </div>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>

    <!--annotator js -->
    <script src="/js/annotatorjs/annotator.min.js"></script>
    <script src="/js/annotatorjs/dist/main.js"></script>

    <!--annotator plugis js -->
    <script src="/js/annotatorjs/plugins/annotator-marginalia-master/src/scripts/bootstrap.dropdown.js"></script>
    <script src="/js/annotatorjs/plugins/annotator-marginalia-master/src/scripts/moment.min.js"></script>
    <script src="/js/annotatorjs/plugins/annotator-marginalia-master/src/scripts/annotator.marginalia.js"></script>
    

    <!-- built files will be auto injected -->
    <script src="{{ mix('js/idesk-teacher/main.js') }}" type="text/javascript"></script>
  </body>
</html>
