
$html='<h1>This is some HTML code</h1><h2 style="color:red;">It will have attributes added to it.</h2><a href="http://youtu.be/oHg5SJYRHA0">Enjoy!</a>';

$attr=array(
  		'h1'=>array('style'=>
					  array('font-size'=>'24px',
							'font-weight'=>'bold',
							'padding'=>0,
							'margin'=>0,
							'line-height'=>'36px',
							'font-family'=>"\'Helvetica Neue\', Helvetica, Arial, sans-serif")),
			'h2'=>array('style'=>
					  array('font-size'=>'20px',
							'font-weight'=>'bold',
							'padding'=>0,
							'margin'=>0,
							'line-height'=>'32px',
							'font-family'=>"\'Helvetica Neue\', Helvetica, Arial, sans-serif")),
			'a'=>array('target'=>'_blank',
					'style'=>
						array('color'=>'#278ec2',
								'text-decoration'=>'underline')
								)
			);
		
$html=processHTML($html,$attr);
    
echo $html;
