<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title></title>
    <link rel="shortcut icon" href="/favicon.ico" />
  
    <link rel="stylesheet" type="text/css" media="screen" href="/css/reset.css" />
<link rel="stylesheet" type="text/css" media="screen" href="/css/text.css" />
<link rel="stylesheet" type="text/css" media="screen" href="/css/960.css" />
<link rel="stylesheet" type="text/css" media="screen" href="/css/custom.css" />
<link rel="stylesheet" type="text/css" media="screen" href="/css/jquery.autocomplete.css" />

    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
<script type="text/javascript" src="/js/jquery.infieldlabel.min.js"></script>
<script type="text/javascript" src="/js/jquery.rating.pack.js"></script>
<script type="text/javascript" src="/js/jquery.autocomplete.js"></script>
<script type="text/javascript" src="/js/theme.js"></script>
<script type="text/javascript" src="/js/jquery.expander.js"></script>
<script type="text/javascript" src="/js/jquery.cookie.js"></script>
</head>
  <body class="interior" id="module-list-action-show">

  
<!-- Begin Header -->
<div id="header" class="clearfix">
  <div class="container_12">

    <!-- Begin Navigation -->
    <ul  id='nav-main'>
        <li><a href="/">Home</a>       </li>
 
        <li><a href="/plugins">Browse Plugins</a>       </li>

 
        <li><a href="/authors">Browse Developers</a>       </li>
 
        <li><a href="/lists">Lists</a>       </li>
 
</ul>
    <ul id='nav-utility'>
      <li><a href="/signin">Sign In</a></li>
    <li><a href="/author/new">Register</a></li>

  </ul>
    <!-- End Navigation -->

    <h1 class="grid_6"><a href="/">sympLIST</a></h1>

    <script type="text/javascript" charset="utf-8">
  $(document).ready(function(){
    $('#search-field').autocomplete('/plugins/search/auto', {
      delay:10,
			minChars:2,
			matchSubset:1,
			matchContains:1,
			cacheLength:10,
			autoFill:false
    });
  });
</script>

<form class="grid_6 search-controls" id="search" method="post" action="/plugins/search">  <fieldset>
    <label for="search-field">Search for a plugin...</label>

    <input type="text" name="form[query]" id="search-field" value="" autocomplete="off" onblur="if(this.value=='') this.value='Search Plugins...';" onfocus="if(this.value=='Search Plugins...') this.value='';" />                    
    <input type="image" name="" id="" value="" src="/images/search-arrow.png" />    <span id='indicator' style='display:none'><img src="/images/ajax-loader.gif" /></span>
  </fieldset>
</form>

<div id='ajax-search-results'></div>  

  </div>
</div>
    
<div id="content-wrapper" class="container_12">   
   
  <div id="content-main" class="grid_8">
    <div class="inner">

    


    <h2>An Unknown Error Has Occurred!</h2>
  
    <p>You have stumbled upon an unknown error.  If you are feeling helpful, please <a href="/contact">Contact Us</a> about the issue!</p>
    <p><a href="/">Home</a></p>
    </div>
  </div>

  </div>

<div id="footer" class="container_12">
  <ul class='grid_6 alpha' id='nav-secondary'>

        <li><a href="/">Home</a>       </li>
 
        <li><a href="/about">About SympLIST</a>       </li>
 
        <li><a href="/contact">Contact</a>       </li>
 
        <li><a href="http://symplist.lighthouseapp.com/projects/36266-symplist/tickets/new">Feedback</a>       </li>
 

</ul>
  <div class="copyright grid_6 omega">
    <p>©2009 Brent Shaffer. Design by <a href="#">The Black Elephant</a></p>
  </div>
</div>


<script type="text/javascript">
//<![CDATA[
var gaJsHost=(("https:"==document.location.protocol)?"https://ssl.":"http://www.");
document.write(unescape("%3Cscript src='"+gaJsHost+"google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
//]]>
</script>
<script type="text/javascript">
//<![CDATA[
var pageTracker=_gat._getTracker("UA-11590669-1");
pageTracker._initData();
pageTracker._trackPageview();
//]]>
</script>
</body>

</html>
