<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <!-- <link rel="icon" href="<%= BASE_URL %>favicon.ico"> -->

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Students</title>
  </head>
  <body>
    <noscript>
      <strong>You need to enable javasccript to view this page.</strong>
    </noscript>
    <div id="app"></div>
    <script src="{{ mix('js/idesk-student/main.js') }}" type="text/javascript"></script>
    <!-- built files will be auto injected -->
  </body>
</html>
