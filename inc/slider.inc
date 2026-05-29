<div class="marquee" id="mycrawler2">
      <?php 

    require_once("admin/class/filereader.php");

  $path = "sliderbrands/";

$dir = new filereader($path);

                        $lista = $dir->LeerDirectorio(); 
                        for($i=0;$i<count($lista);$i++){
                        ?>
                        <img src="<?php echo $path.$lista[$i];?>" class="logo_brand" >
                        <?php

                        };
                        ?>  
</div>

<script type="text/javascript">
marqueeInit({
	uniqueid: 'mycrawler2',
    	style: {
		'padding': '2px',
        'margin-right': '10px',
		'width': '4000px',
		'height': '60px'
	},
	inc: 2, //speed - pixel increment for each iteration of this marquee's movement
	mouse: 'cursor driven', //mouseover behavior ('pause' 'cursor driven' or false)
	moveatleast: 1,
	neutral: 150,
	savedirection: true,
	random: true
});
</script>
<script src="js/lightbox.js"></script>