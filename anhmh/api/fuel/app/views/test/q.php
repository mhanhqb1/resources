<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Query</title>
	<?php echo Asset::css('bootstrap.css'); ?>
	<style>
		body { margin: 40px; }
        textarea {
            width: 100%;
            padding: 4px;
            margin: 10px 0px;
        }
        table {
            width: 100%;
            padding: 4px;
        }        
        .col-md-12 {
            padding: 0px;
        }
        #result {
            margin: 10px 0px;
            width: 100%;
        }
	</style>
</head>
<body>
	<div class="container">
		<div class="col-md-12">
			<h1>Query</h1>			
            <div class="col-md-12">
                <form method="POST">
                <textarea name="q"><?php echo !empty($q) ? $q : ''; ?></textarea>
                <input type="submit" />
                </form>
                <div id="result">      
                <table>
                <?php
                    if (!empty($result)) {
                        $attrs = array('field_name', 'type', 'default', 'data_type', 'extra', 'key', 'privileges');
                        echo "<tr>";                    
                        foreach ($attrs as $attr) {                        
                            echo "<td>{$attr}</td>";
                        }
                        echo "</tr>";
                        foreach ($result as $field => $info) {
                            echo "<tr>";
                            echo "<td>{$field}</td>";
                            foreach ($info as $key => $value) {
                                if (in_array($key, $attrs)) {
                                    echo "<td>{$value}&nbsp;</td>";
                                }
                            }
                            echo "</tr>";
                        }
                    }
                ?>
                </table>
                </div>                
            </div>
        </div>
		<footer>
			<p class="pull-right">Page rendered in {exec_time}s using {mem_usage}mb of memory.</p>
			<p>
				<a href="http://fuelphp.com">FuelPHP</a> is released under the MIT license.<br>
				<small>Version: <?php echo e(Fuel::VERSION); ?></small>
			</p>
		</footer>
	</div>
</body>
</html>
