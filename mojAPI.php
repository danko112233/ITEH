<?php
require 'flight/Flight.php';
Flight::register('db', 'Database', array('userregistration'));
$json_podaci = file_get_contents("php://input");
Flight::set('json_podaci', $json_podaci );

Flight::route('/home.php', function(){
    echo 'hello world!';
});

//Vraca listu profila
Flight::route('GET /usertable.json', function(){
	header ("Content-Type: application/json; charset=utf-8");
	$db = Flight::db();
	$db->select();
	$niz=array();
	while ($red=$db->getResult()->fetch_object()){
		$niz[] = $red;
	}
	$json_niz = json_encode ($niz,JSON_UNESCAPED_UNICODE);
    echo $json_niz;

	return false;
});
//Vraca listu (ako @id=1 prijatelja), (ako @id=0 poslatih requestova), (ako @id=2 ili @id=3 listu "neprijatelja")
Flight::route('GET /friends/@id.json', function($id){
	header ("Content-Type: application/json; charset=utf-8");
	$db = Flight::db();
	$db->select1("friends", 'user1_id, user2_id' ,"status = ".$id);
	$niz=array();
	while ($red=$db->getResult()->fetch_object()){
		$niz[] = $red;
	}
 
	$json_niz = json_encode ($niz,JSON_UNESCAPED_UNICODE);
    echo $json_niz;
    
	return false;
});
//Dodaje novog user-a
Flight::route('POST /usertable', function(){
	header ("Content-Type: application/json; charset=utf-8");
	$db = Flight::db();
	$podaci_json = Flight::get("json_podaci");
	$podaci = json_decode ($podaci_json);
	if ($podaci == null){
		$odgovor["poruka"] = "Niste prosledili podatke";
		$json_odgovor = json_encode ($odgovor);
		echo $json_odgovor;
		return false;
	} else {
	if (!property_exists($podaci,'name')||!property_exists($podaci,'password')){
			$odgovor["poruka"] = "Niste prosledili korektne podatke";
			$json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
			echo $json_odgovor;
			return false;	
	} else {
			$podaci_query = array();
			foreach ($podaci as $k=>$v){
				$v = "'".$v."'";
				$podaci_query[$k] = $v;
			}
			if ($db->insert("usertable", "name, password", array($podaci_query["name"], $podaci_query["password"]))){
				$odgovor["poruka"] = "Korisnik je uspešno ubačen";
				$json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
				echo $json_odgovor;
				return false;
			} else {
				$odgovor["poruka"] = "Došlo je do greške pri ubacivanju korisnika";
				$json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
				echo $json_odgovor;
				return false;
			}
	}
	}	
	}
);
//Menjamo tekst poruke (za id postavljamo poruku koju trazimo i zelimo da izmenimo)
Flight::route('PUT /chat/@id', function($id){
	header ("Content-Type: application/json; charset=utf-8");
	$db = Flight::db();
	$podaci_json = Flight::get("json_podaci");
	$podaci = json_decode ($podaci_json);
	if ($podaci == null){
	$odgovor["poruka"] = "Niste prosledili podatke";
	$json_odgovor = json_encode ($odgovor);
	echo $json_odgovor;
	} else {
	if (!property_exists($podaci,'novaporuka')){
			$odgovor["poruka"] = "Niste prosledili korektne podatke";
			$json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
			echo $json_odgovor;
			return false;
	
	} else {
			$podaci_query = array();
			foreach ($podaci as $k=>$v){
				$v = "'".$v."'";
				$podaci_query[$k] = $v;
			}
			if ($db->update("chat", $id, array('message'),array($podaci->novaporuka))){
				$odgovor["poruka"] = "Poruka je uspešno izmenjena";
				$json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
				echo $json_odgovor;
				return false;
			} else {
				$odgovor["poruka"] = "Došlo je do greške pri izmeni poruke";
				$json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
				echo $json_odgovor;
				return false;
			}
	}
	}	

});

Flight::route('DELETE /usertable/@id', function($id){
	header ("Content-Type: application/json; charset=utf-8");
	$db = Flight::db();
	if ($db->delete("usertable", "name", $id)){
			$odgovor["poruka"] = "Korisnik je uspešno izbrisan";
			$json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
			echo $json_odgovor;
			return false;
	} else {
			$odgovor["poruka"] = "Došlo je do greške prilikom brisanja korisnika";
			$json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
			echo $json_odgovor;
			return false;
	
	}		
			
});


Flight::start();
?>