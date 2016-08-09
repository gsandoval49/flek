<?php

namespace Edu\Cnm\Flek;


require_once("autoload.php");
/**
 *
 *
 * @author Rob Harding
 * @ver 1.0.0
 **/


class Tag implements \JsonSerializable {

	private tagImageId;

	private tagHashtagId;

	public function getTagImageId() {
		return($this->tagImageId);
	}

	public function setTagImageId(int $newTagImageId){
		if($newTagImageIdId <= 0) {
			throw(new \RangeException ("image id is not positive"));
		}
		/*convert and store the image id*/
		$this->tagImageId = $newTagImageId;
	}

	}

}