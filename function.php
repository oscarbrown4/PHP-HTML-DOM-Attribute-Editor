/* This function takes html code and either replaces or adds to DOM element attribute.
 * $html - the full html code to process
 * $attributes - an array of attributes and values OR a string with an attribute (ie 'h1')
 * $value - only used if $attributes is a string, an array with the values to add to the element
 */


function processHTML($html, $attributes, $value=false) {

  // check if $attributes is an array.  If not, get $value and put into array
	if (!is_array($attributes)) $attributes=array($attributes=>$value);

	// run the function on each attribute in the array
	foreach ($attributes as $needle => $attrs) {	

		// add '<' to beginning of needle for searching... 'h1' becomes '<h1'
		$needle = "<".$needle;
		// set last position of search = 0
		$lastPos = 0;
		
		// run for each matched item in the html
		while ($lastPos = strpos($html, $needle, $lastPos)) {
			
			// finds the end of the beginning element tag (the first > after the tag was found
			$end=strpos($html, '>', $lastPos)+1;
			// the entire current tag
			$tag=substr($html, $lastPos, $end-$lastPos);
		
			// run for each attribute 
			foreach ($attrs as $attr => $vals) {
		
				// if the element already has the attribute
				if (strpos($tag, $attr.'="')) {
					
					//find start & end of attribute value, then get the attribute value
					$start=strpos($tag, $attr.'="')+strlen($attr.'="');
					$end=strpos($tag, '"',$start)-$start;
					$origValsString=substr($tag, $start, $end);
					
					// convert the values to an array
					// handle differently if it's a style attribute
					if ($attr=='style') {
						// separate each style attribute with a ;
						$attrValsArray=explode(';', $origValsString);
						//make a key=>value array with each inline style
						$attrVals=array();
						foreach ($attrValsArray as $attrval) {
		    				$attrval=trim($attrval);
							$attrvalsfind=explode(':',$attrval);
							$k=trim($attrvalsfind[0]);
							$v=trim($attrvalsfind[1]);
							if (strlen($k)>0) $attrVals[$k]=$v;
						}
						
						// new style values overrite current values
						$vals=array_merge($attrVals,$vals);
						
						// turn values into string
						$valsString='';
						foreach ($vals as $styleName=>$styleValue) $valsString.=$styleName.':'.$styleValue.'; ';
						
					}
					else {
						$attrVals=explode(' ', $origValsString);
						
						//merge the current values with the new values
						$newVals=array_merge($attrVals,$vals);
						
						//remove duplicates
						$newVals=array_unique($newVals);
						
						//turn the values into a strings
						$valsString=implode(' ', $newVals);
					}
					
					// replace the old values with the new values
					$newTag=str_replace($attr.'="'.$origValsString.'"', $attr.'="'.$valsString.'" ', $tag);
    			}
    			
    			//otherwise add the values to the element
				else {
				
					// if $vals is an array, turn it into a string
					if (is_array($vals)) {
						// handle it differnetly if it's a style attribute
						if ($attr=='style') {
							$valsString='';
							foreach ($vals as $styleName=>$styleValue) $valsString.=$styleName.':'.$styleValue.'; ';
						}
						else $valsString=implode(' ', $vals);
					}
					else $valsString=$vals;
											 
					$newTag=str_replace($needle, $needle.' '.$attr.'="'.$valsString.'" ', $tag);
				}
				
				// replace the old opening element tag with the new one
				$html = substr_replace($html, $newTag, $lastPos, strlen($tag));
				
				//set tag as the new tag to run through the next attribute
				$tag=$newTag;
    		}
		//set the last position so it can search again for the next matching element
    	$lastPos = $lastPos + strlen($needle);
		}
	}
	
	// return the filtered html
	return $html;
}
