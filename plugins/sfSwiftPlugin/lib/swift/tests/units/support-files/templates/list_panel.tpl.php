<html>
	<head>
		<style type="text/css">
		body {
			font-size: 0.8em;
			background: #eeeeee;
		}
		
		ul {
			padding: 0;
			margin: 0;
		}
		
		li {
			padding: 0;
			margin: 0;
			margin-left: 20px;
		}
		
		h3 {
		  padding-bottom: 0;
		  margin-bottom: 1em;
		  padding-top: 0;
		  margin-top: 0;
	  }
	  
	  #sys_info {
	    margin: 5px;
	    padding: 5px;
	    background: #fff;
	    border: 1px solid #000;
    }
    
    td {
      font-size: 0.8em;
    }
		</style>
	</head>
	<body>
	  <div id="sys_info">
		  <h3>System information</h3>
		  <table>
		    <tr>
		      <td><strong>PHP Version</strong></td>
		      <td><?php echo $phpVersion ?></td>
	      </tr>
	      <tr>
		      <td><strong>SimpleTest Version</strong></td>
		      <td><?php echo $simpletestVer ?></td>
	      </tr>
	      <tr>
		      <td><strong>Swift Version</strong></td>
		      <td><?php echo $swiftVer ?></td>
	      </tr>
	      <tr>
		      <td><strong>Operating System</strong></td>
		      <td><?php echo $os ?></td>
	      </tr>
	      <tr>
		      <td><strong>INI safe_mode</strong></td>
		      <td><?php echo $safeMode ?></td>
	      </tr>
	      <tr>
		      <td><strong>INI register_globals</strong></td>
		      <td><?php echo $registerGlobals ?></td>
	      </tr>
	      <tr>
		      <td><strong>INI magic_quotes_runtime</strong></td>
		      <td><?php echo $magicQuotes ?></td>
	      </tr>
	      <tr>
		      <td><strong>INI memory_limit</strong></td>
		      <td><?php echo $memLimit ?></td>
	      </tr>
	      <tr>
	        <td><strong>TestConfiguration</strong></td>
	        <td><?php echo $confOk ?></td>
        </tr>
	    </table>
	  </div>
	  
		<h1>Test cases</h1>
		<ul>
			<li>
				<strong>
					<a href="./test_runner.php?doTests=all" target="runner">
						All Tests
					</a>
				</strong>
				
				<ul>
					<?php foreach ($tests as $path => $data): ?>
					<li>
						<strong>
							<a href="./test_runner.php?doTests=<?php echo $path ?>" target="runner">
								<?php echo $data["name"] ?>
							</a>
						</strong>
						
						<?php if (!empty($data["tests"])): ?>
						<ul>
							<?php foreach ($data["tests"] as $testpath => $testname): ?>
							<li>
								<a href="./test_runner.php?doTests=<?php echo $testpath ?>" target="runner">
									<?php echo $testname ?>
								</a>
							</li>
							<?php endforeach ?>
						</ul>
						<?php endif ?>
						
					</li>
					<?php endforeach ?>
				</ul>
				
			</li>
		</ul>
	</body>
</html>
