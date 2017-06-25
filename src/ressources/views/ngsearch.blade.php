<div ng-controller="GeoSearchController">
	<h4>Localisation</h4>
	<div>
		<md-input-container>
			<label>Pays</label>
			<md-select name="adresse_ville_country_nom" ng-model="$parent.data.country" aria-label="pays" ng-change="countrychange()">
				<md-option value=""></md-option>
				<md-option ng-repeat="country in countries" ng-value="country">@{{country.nom}}</md-option>
			</md-select>
		</md-input-container>
		<md-input-container>
			<label>Ville</label>
			<md-select name="adresse_ville_nom" ng-model="$parent.data.ville" aria-label="ville">
				<md-option value=""></md-option>
				<md-option ng-repeat="ville in villes" ng-value="ville">@{{ville.nom}}</md-option>
			</md-select>
		</md-input-container>
	</div>
</div>
