<?php
use App\Models\User;


function generateRandomNumber($len = 16) {
    return substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'),1,$len);
}

function strReplaceAssoc(array $replace, $subject) 
{ 
	return str_replace(array_keys($replace), array_values($replace), $subject);
}

function ratingAvg($uuid)
{
	$rating = \DB::table('review_and_ratings')
	->where('package_uuid', $uuid)
	->where('status',1)
	->avg('rating');
	$rating = (($rating>0) ? round($rating, 2) : 0);
	return $rating;
}

?>