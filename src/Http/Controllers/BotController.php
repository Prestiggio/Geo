<?php 
namespace Ry\Geo\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ry\Socin\Bot\Form;
use Ry\Socin\Models\Bot;
use Illuminate\Support\Facades\Log;

class BotController extends Controller
{
	public function postPosition(Request $request) {
		$form = new Form(null, null, null, false);
		$ar = $request->all();
		$model = $request->get("model");
		if(isset($ar["message"]["attachments"])) {
			foreach($ar["message"]["attachments"] as $loc) {
				Bot::gotField(Form::dot2ar($model, function(&$ar) use ($loc){
					$ar["adresse"] = [
							"lat" => $loc["payload"]["coordinates"]["lat"],
							"lng" => $loc["payload"]["coordinates"]["long"]
					];
				}), $form);
			}
		}
		else {
			$form->append(app("\Ry\Socin\Http\Controllers\JsonController")->continueForm(Bot::currentField()->form));	
		}		
		return $form;
	}
}

?>