<?php

//retorna um grande pedaço antigo de JSON de uma página de conta não privada do IG.
function scrape_insta($username) {
	$insta_source = file_get_contents('http://instagram.com/'.$username);
	$shards = explode('window._sharedData = ', $insta_source);
	$insta_json = explode(';</script>', $shards[1]); 
	$insta_array = json_decode($insta_json[0], TRUE);
	return $insta_array;
}

//Forneça um nome de usuário
$my_account = 'fulano'; 

//Faça a escritura
$results_array = scrape_insta($my_account);

//Um exemplo de onde ir a partir daí
$latest_array = $results_array['entry_data']['ProfilePage'][0]['user']['media']['nodes'][0];

echo 'Latest Photo:<br/>';
echo '<a href="http://instagram.com/p/'.$latest_array['code'].'"><img src="'.$latest_array['display_src'].'"></a></br>';
echo 'Likes: '.$latest_array['likes']['count'].' - Comments: '.$latest_array['comments']['count'].'<br/>';

/* Uma reformulação do site do Instagram em junho de 2015 quebrou a recuperação rápida de legendas, locais e outras coisas.
echo 'Taken at '.$latest_array['location']['name'].'<br/>';
//Heck, lets compare it to a useful API, just for kicks.
echo '<img src="http://maps.googleapis.com/maps/api/staticmap?markers=color:red%7Clabel:X%7C'.$latest_array['location']['latitude'].','.$latest_array['location']['longitude'].'&zoom=13&size=300x150&sensor=false">';
?>
*/
