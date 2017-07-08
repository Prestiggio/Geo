<ng-form name="frm_geo">
	<h4>Localisation</h4>
	<div layout="row">
		<md-input-container>
			<md-button ng-click="data.raw=$root.selectedText" aria-label="Assign" class="md-icon-button"><md-icon md-font-icon="fa fa-long-arrow-right"></md-icon></md-button>
		</md-input-container>
		<md-input-container>
			<label>@lang("rygeo::overall.address")</label>
			<input type="text" name="adresse_raw" ng-model="data.raw" required/>
			<div ng-messages="frm_geo.adresse_raw.$error">
		 		<div ng-message="required">@lang("rygeo::overall.address_required")</div>
		 	</div>
		</md-input-container>
		<md-input-container>
			<md-button class="md-icon-button" ng-click="$root.ask('latlng')" aria-label="Questionner l'auteur"><md-icon md-font-icon="fa fa-send"></md-icon></md-button>
		</md-input-container>
	</div>
	<div layout="row">
		<md-input-container>
			<md-button ng-click="data.ville.nom=$root.selectedText" aria-label="Assign" class="md-icon-button"><md-icon md-font-icon="fa fa-long-arrow-right"></md-icon></md-button>
		</md-input-container>
		<md-input-container>
			<label>@lang("rygeo::overall.city")</label>
			<input type="text" name="adresse_ville_nom" ng-model="data.ville.nom" required/>
			<div ng-messages="frm_geo.adresse_ville_nom.$error">
		 		<div ng-message="required">@lang("rygeo::overall.city_required")</div>
		 	</div>
		</md-input-container>
	</div>
	<div layout="row">
		<md-input-container>
			<md-button ng-click="data.ville.country.nom=$root.selectedText" aria-label="Assign" class="md-icon-button"><md-icon md-font-icon="fa fa-long-arrow-right"></md-icon></md-button>
		</md-input-container>
		<md-input-container>
			<label>@lang("rygeo::overall.country")</label>
			<input type="text" name="adresse_ville_country_nom" ng-model="data.ville.country.nom" required/>
			<div ng-messages="frm_geo.adresse_ville_country_nom.$error">
		 		<div ng-message="required">@lang("rygeo::overall.country_required")</div>
		 	</div>
		</md-input-container>
	</div>
</ng-form>
<rymap ng-model="data" style="min-height:600px;"></rymap>