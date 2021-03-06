<!DOCTYPE html>
<html lang="en">
  <head>
    <title><?php echo $title; ?></title>
    <meta charset="utf-8">
    <meta name="description" content="TLC's events timeline">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <!-- Style-->
    <style>
      html, body {
       height:100%;
       padding: 0px;
       margin: 0px;
      }
    </style>
    <!-- HTML5 shim, for IE6-8 support of HTML elements--><!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
  </head>
</html>
<body>
  <!-- BEGIN Timeline Embed -->
  <div id="timeline-embed"></div>
  <script type="text/javascript">
    var timeline_config = {
     width: "100%",
     height: "100%",
     source: "http://localhost/apricot/index.php/events/timeline_json/"
    }
  </script>
  <?php echo script_tag('js/storyjs-embed.js');?>
  <!-- END Timeline Embed-->
</body>