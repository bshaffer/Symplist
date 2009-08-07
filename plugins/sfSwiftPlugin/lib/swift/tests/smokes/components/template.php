<html>

<head>
  
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

  <title><?php $this->paintTestName() ?> [SMOKE]</title>

  <style type="text/css">
  
  body {
    padding: 20px;
    margin: 0;
    background: #ffffff;
    color: #000000;
    font-size: 0.9em;
    
  }
  
  h1 {
    background: #5588dd;
    padding: 5px;
    color: #ffffff;
  }
  
  div#bottom {
    padding: 10px;
    background: #f6f6f6;
    margin: 10px 0;
  }
  
  div#screenshot {
    padding: 10px;
    margin: 10px 0;
    background: #fff;
    border: 1px dotted #cccccc;
  }
  
  div#info {
    padding: 10px;
    margin: 10px 0;
    background: #dddddd;
  }
  
  .washed {
    color: #aaaaaa;
  }
  
  .error {
    background: #f64444;
    color: #fff;
    padding: 5px;
  }
  
  .success {
    background: #44aa44;
    color: #fff;
    padding: 5px;
  }
  
  </style>
  
</head>

<body>

  <div>
    
    <strong class="washed" style="text-decoration: underline;">&raquo; Swift Mailer Smoke Test &laquo;</strong>
    
    <h1><?php $this->paintTestName() ?></h1>
    
    <div id="info">
      
      <?php $this->paintTopInfo() ?>
      
      <?php if ($this->isError()): ?>
      
      <div class="error"><strong>Error:</strong> <?php $this->paintError() ?></div>
      
      <?php else: ?>
      
      <div class="success"><?php $this->paintResult() ?></div>
      
      <?php endif ?>
      
    </div>
    
    <div id="screenshot">
      <img src="images/<?php $this->paintImageName() ?>" alt="Screenshot" />
    </div>
    
    <div id="bottom">
      <?php $this->paintBottomInfo() ?>
    </div>
    
    <strong class="washed">Having Problems? <a href="mailto:chris@w3style.co.uk">E-mail me</a>.</strong>
    
  </div>

</body>

</html>