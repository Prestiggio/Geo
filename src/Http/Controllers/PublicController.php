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
		$adresse = Adresse::where("raw", "LIKE", $ar["raw"])->first();
		
		if(!$adresse) {
			
			Model::unguard ();
			
			$country = false;
			$ville = false;
			if(isset($ar["ville"]["country"]["id"]) && $ar["ville"]["country"]["id"] > 0) {
				$country = Country::where("id", "=", $ar["ville"]["country"]["id"])->first();
			}
			elseif(isset($ar  ["ville"] ["country"] ["nom"])){
				$country = Country::where ( "nom", "LIKE", $ar  ["ville"] ["country"] ["nom"] )->first ();
			}
			
			if (!$country) {
				$country = new Country ();
				$country->nom = $ar  ["ville"] ["country"] ["nom"];
				$country->save ();
				
				$ville = $country->villes ()->create ( [
						"nom" => $ar  ["ville"] ["nom"],
						"cp" => isset($ar  ["ville"] ["cp"]) ? $ar  ["ville"] ["cp"] : ""
				] );
			}
			else {
				if(isset($ar["ville"]["id"]) && $ar["ville"]["id"]>0) {
					$ville = $country->villes ()->where ( "id", "=", $ar  ["ville"] ["id"] )
					->where("nom", "LIKE", $ar  ["ville"] ["nom"])->first ();
				}
				elseif(isset($ar  ["ville"] ["nom"])) {
					$ville = $country->villes ()->where ( "nom", "LIKE", $ar  ["ville"] ["nom"] )->first ();
				}
				
				if (! $ville) {
					$ville = $country->villes ()->create ( [
							"nom" => $ar  ["ville"] ["nom"],
							"cp" => isset($ar  ["ville"] ["cp"]) ? $ar  ["ville"] ["cp"] : ""
					] );
				}
			}
			
			Model::unguard ();
			
			$adresse = new Adresse ();
			$adresse->ville_id = $ville->id;
		}
		
		$adresse->raw = $ar  ["raw"];
		$adresse->lat = isset($ar["lat"]) ? $ar["lat"] : "-18.913396429147";
		$adresse->lng = isset($ar["lng"]) ? $ar["lng"] : "47.521104812622";
		
		$adresse->save ();
		
		return $adresse;
	}
}
?>