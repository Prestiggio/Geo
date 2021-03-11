<?php 
namespace Ry\Geo\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ry\Geo\Models\Country;
use Ry\Geo\Models\Ville;
use Ry\Geo\Models\Adresse;
use Illuminate\Database\Eloquent\Model;

class PublicController extends Controller
{
	public function villes($country) {
		return $country->villes;
	}
	
	public function getCountries() {
		return Country::all();
	}
	
	public function getNgmodel() {
		return view("rygeo::ngmodel");
	}
	
	public function getNgsearch() {
		return view("rygeo::ngsearch");
	}
	
	public function generate($ar) {
	    if(!isset($ar["raw"]))
	        return;
	    
		$adresse = Adresse::where("raw", "LIKE", $ar["raw"])->first();
		
		if(!$adresse) {	
		    if(!isset($ar['ville']))
		        return;
			$adresse = new Adresse();
			$ville = $this->generateVilleChanged($ar['ville']);
		}
		else {
		    $ville = $this->generateVilleChanged($ar['ville'], (isset($ar['ville']['id']) && $ar['ville']['id'] != $adresse->ville_id)
		        ||(isset($ar['ville']['cp']) && $ar['ville']['cp'] != $adresse->ville->cp)
		        ||(isset($ar['ville']['country']['id']) && $ar['ville']['country']['id'] != $adresse->ville->country_id));
		    if($ville->id != $adresse->ville_id) {
		        $adresse = new Adresse();
		    }
		}
		
		$adresse->ville_id = $ville->id;
		$adresse->raw = $ar["raw"];
		$adresse->raw2 = isset($ar["raw2"]) ? $ar["raw2"] : null;
		$adresse->lat = isset($ar["lat"]) ? $ar["lat"] : "-18.913396429147";
		$adresse->lng = isset($ar["lng"]) ? $ar["lng"] : "47.521104812622";
		
		$adresse->save();
		
		return $adresse;
	}
	
	private function generateVilleChanged($arville, $recreate=false) {	    
	    if(!isset($arville['country']))
	        return;
	    
	    $ville = false;
	    $country = $this->generateCountryChanged($arville['country']);
	    
	    if($recreate) {
	        Ville::unguard();
	        $ville = $country->villes()->create([
	            "nom" => $arville["nom"],
	            "cp" => isset($arville["cp"]) ? $arville["cp"] : ""
	        ]);
	        Ville::reguard();
	        return $ville;
	    }
	    
	    if(isset($arville["id"]) && $arville["id"]>0) {
	        $ville = $country->villes()->where( "id", "=", $arville["id"])->first();
	    }
	    elseif(isset($arville['nom'])) {
	        $ville = $country->villes()->where("nom","LIKE",$arville["nom"])->first();
	    }
	    
	    if(!$ville || ($ville && $ville->country_id != $country->id)) {
	        if(!isset($arville["nom"]))
	            return;
	        
	        Ville::unguard();
	        $ville = $country->villes()->create([
	            "nom" => $arville["nom"],
	            "cp" => isset($arville["cp"]) ? $arville["cp"] : ""
	        ]);
	        Ville::reguard();
	    }
	    
	    return $ville;
	}
	
	private function generateCountryChanged($arcountry, $recreate=false) {
	    if(isset($arcountry["id"]) && $arcountry["id"] > 0) {
	        return Country::where("id","=",$arcountry["id"])->first();
	    }
	    elseif(isset($arcountry["nom"])){
	        $country = Country::where("nom","LIKE",$arcountry["nom"])->first();
	        if(!$country) {
	            $country = new Country();
	            $country->nom = $arcountry["nom"];
	            $country->save ();
	        }
	        return $country;
	    }
	}
}
?>