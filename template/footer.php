<div class="hero-unit">
<?php
$stop_time = MICROTIME(TRUE);
// get the difference in seconds
$time = $stop_time - $starting_time_measure;
echo '<p>Sidan laddades p&aring; ' . $time . ' sekunder.</p>';
?>
</div>
</div><!-- container main -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="js/bootstrap.js"></script>
</body>
</html>
