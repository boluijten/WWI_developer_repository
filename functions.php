<?php

// Homepage - index.php
	function laadCategorie(){
		// Verbinden met database
		include("connect.php");
		// Kijk of er een categorie is geselecteerd
		$groupID = "";
		if(filter_input(INPUT_GET, 'categorie') != ""){
			$groupID = filter_input(INPUT_GET, 'categorie');

		}
		$aantalProducten = 10;
		if(isset($_GET['aantalProducten'])){
			$aantalProducten = filter_input(INPUT_GET, 'aantalProducten');
		}
		//Verkrijg alle productgroepen
		$groupQuery = "SELECT StockGroupName, StockGroupID FROM stockgroups";
		$resultGroups = mysqli_query($connect, $groupQuery);
		if (mysqli_num_rows($resultGroups) > 0) {
		    // Maak categorie menu
		    echo "<div class=\"vertical-menu\">";
		    while($row = mysqli_fetch_assoc($resultGroups)) {
		    	$class = "";
		    	// Als er een categorie is geselecteerd controlleer of dat deze is
		    	if($groupID == $row['StockGroupID']){
		    		// Als deze categorie is geselecteerd is krijgt de link de class 'inUse' van toepassing (zie style.css)
		    		$class = "inUse";
		    	}else{
		    		// In het geval de de klasse niet is geselecteerd krijgt de link de class 'notInUse' (zie style.css)
		    		$class = "notInUse";
		    	}
		    	// Print de rij met de class die eerder is geset
		    	
		    	
		    	
		    	echo "<a href=\"index.php?categorie=".$row['StockGroupID']."&naamCategorie=".$row['StockGroupName'] ."&aantalProducten=$aantalProducten&paginaNr=0\" class='$class'>".$row['StockGroupName']."</a>";
		    }
		    if($groupID != ""){
		    	echo "<a href=\"index.php?aantalProducten=$aantalProducten&paginaNr=0\" class='clear'>See all</a>";
		    }
		    echo "</div>";
		} else {
		    echo "No groups yet!<br>";
		}

	}


	function laadProducten(){
		// Verbinden met database
		include("connect.php");
		
		$items = array();
		// Kijk of er een categorie is geselecteerd
		if(filter_input(INPUT_GET, 'categorie') != ""){
			// Verkrijg ID van de categorie uit de GET en maak een query die alle producren verkrijgt met dat speciale categorie ID
			$groupID = filter_input(INPUT_GET, 'categorie');
			$groupQuery = "SELECT StockItemName, StockItemID, MarketingComments, StockGroupName, StockGroupID, Photo, UnitPrice FROM stockitems JOIN stockitemstockgroups USING(StockItemID) JOIN stockgroups USING(StockGroupID) WHERE StockGroupID = ".$groupID." GROUP BY StockItemID";
			// Sla de naam van de groep op uit de GET
			$groupName = filter_input(INPUT_GET, 'naamCategorie');
		}else{
			// In het geval dat er geen categorie is geselecteerd alle producten laden
			$groupQuery = "SELECT StockItemName, StockItemID, MarketingComments, StockGroupID, Photo, UnitPrice FROM stockitems JOIN stockitemstockgroups USING(StockItemID) GROUP BY StockItemID";
		}
		// Voer de groupQuery uit
		$resultGroups = mysqli_query($connect, $groupQuery);
		// Check of er data beschikbaar is:
		if (mysqli_num_rows($resultGroups) > 0) {
		    
		    // Voor elk gevangen resultaat een productweergave printen
		    while($row = mysqli_fetch_assoc($resultGroups)) {
		    	$items[] = $row['StockItemID'];
		    }
		    
		} else {
		    echo "<div class='geenProducten'>Nog geen producten in deze categorie!</div>";
		}

		$pagina = 0;
		if(isset($_GET['paginaNr'])){
			$pagina = filter_input(INPUT_GET, 'paginaNr');
		}

		

		// Laden pagina nummers
		ladenPaginaNummers($items);
		
		
		// Laden producten
		echo "<div class=\"grid-container-seach2\">";

		$aantalProducten = 10;
		if(filter_input(INPUT_GET, 'aantalProducten') != ""){
			$aantalProducten = filter_input(INPUT_GET, 'aantalProducten');
		}

		if(isset($_GET['paginaNr'])){
			if($pagina != 0){
				$max = $pagina*$aantalProducten+$aantalProducten;
			}else{
				$max = $aantalProducten;
			}
			for ($i = $pagina*$aantalProducten+1; $i < $max+1; $i++) {
				if($items[$i-1] != NULL){
					laadProduct($items[$i-1]);
				}else{
					break;
				}
				
				
			}
		}else{
			for ($i = 0; $i < $aantalProducten; $i++) {
				if($items[$i] != NULL){
					laadProduct($items[$i]);
				}else{
					break;
				}
				
				
			}
		}
	
		
		echo "</div>";
		
		
	}

	function ladenPaginaNummers($items){
		if(isset($_GET['aantalProducten'])){
			$paginas = ceil(count($items) / filter_input(INPUT_GET, 'aantalProducten'));

		}else{
			$paginas = ceil(count($items) / 10);
		}
		echo "<div class='paginaNummers'>";
		for($i = 0; $i < $paginas; $i++){
			$classCurrent="notCurrentPage";
			if($i == filter_input(INPUT_GET, 'paginaNr')){
				$classCurrent="currentPage";
			}
			$pageCipher = $i + 1;
			$streepje = "";
			if($i != 0){
				$streepje = " - ";
			}

			$varURL = "";
			if(isset($_GET['categorie'])){
				$varURL .= "categorie=".filter_input(INPUT_GET, 'categorie')."&";
			}
			if(isset($_GET['sortSelect'])){
				$varURL .= "sortSelect=".filter_input(INPUT_GET, 'sortSelect')."&";
			}
			
			if(isset($_GET['aantalProducten'])){
				$varURL .= "aantalProducten=".filter_input(INPUT_GET, 'aantalProducten')."&";
			}else{
				$varURL .= "aantalProducten=10&";
			}
			$varURL .= "paginaNr=".$i;

			echo $streepje."<a href='index.php?$varURL' class='$classCurrent'>$pageCipher</a>";
			
		}
		echo "</div>";
	}

	function laadProduct($itemID){
		include("connect.php");
		$query = "SELECT StockItemName, StockItemID, MarketingComments, StockGroupName, StockGroupID, Photo, UnitPrice FROM stockitems JOIN stockitemstockgroups USING(StockItemID) JOIN stockgroups USING(StockGroupID) WHERE StockItemID = ".$itemID." GROUP BY StockItemID";
		$queryResult = mysqli_query($connect, $query);
		if (mysqli_num_rows($queryResult) > 0) {

		    // Voor elk gevangen resultaat een productweergave printen
		    while($row = mysqli_fetch_assoc($queryResult)){
			    echo "<a href='artikel.php?artikel=".$row['StockItemID']."&group=".$row['StockGroupID']."'>";
		    	echo "<div class=\"grid-item\">";
		    	echo "<h3>".$row['StockItemName']."</h3>";
			    if(file_exists("assets/producten/".$row['StockItemID']."/1.jpg")){
			    	echo "<img src='assets/producten/".$row['StockItemID']."/1.jpg' class='productImageHome'>";
			    }else{
			    	echo "<img src='assets/geen.jpg' class='productImageHome'>";
			    }
		    	echo "<p>".$row['MarketingComments']."</p>";
		    	echo "<div class='priceInDiv'>&euro;".$row['UnitPrice']."</div>";
		    	echo "</div>";
		    	echo "</a>";
			}
		}else {
		    echo "<div class='geenProducten'>Nog geen producten in deze categorie!</div>";
		}
						
	}

	// laad de aanbiedingen op de homepage
	function laadDeals(){
		include("connect.php");
		$query = "SELECT D.StockItemID ja, StockGroupID, StockItemName, UnitPrice, discountPercentage FROM discount D LEFT JOIN stockitems S USING(StockItemID) LEFT JOIN stockitemstockgroups USING(StockItemID)";
		$resultSpecialdeal = mysqli_query($connect, $query);
	    if(mysqli_num_rows($resultSpecialdeal) > 0){
	        while($row = mysqli_fetch_assoc($resultSpecialdeal)){
	        	$nieuwprijs = "";
	           echo "<a href='artikel.php?artikel=".$row['ja']."&group=".$row['StockGroupID']."'><div style=\"z-index:10; \" class=\"aanbieding-product\">
					    <p style=\"float:left;\">".$row['StockItemName']."</p>
					    <p style=\"float:right\">".number_format($row['UnitPrice'] * ((100-$row['discountPercentage'])/100), 2, ',', '.')."</p>
					    <sub><p style=\"float:right;text-decoration: line-through;\">".$row['UnitPrice']."  </p></sub>
					    <p>".$row['discountPercentage']."% korting! </p>
					  </div></a>";
	        }
	    }
	}

// Zoekpagina - action_search.php
	function laadCategorieZoekpagina(){
		// Verbinden met database
		include("connect.php");
		$searchID = htmlspecialchars(mysqli_real_escape_string($connect, filter_input(INPUT_GET, 'search')));
		// Kijk of er een categorie is geselecteerd
		$groupName = "";
		if(filter_input(INPUT_GET, 'categorie') != ""){
			$groupName = filter_input(INPUT_GET, 'categorie');

		}
		//Verkrijg alle productgroepen
		$groupQuery = "SELECT StockGroupName, StockGroupID FROM stockgroups";
		$resultGroups = mysqli_query($connect, $groupQuery);
		if (mysqli_num_rows($resultGroups) > 0) {
		    // Maak categorie menu
		    echo "<div class=\"vertical-menu\">";
		    while($row = mysqli_fetch_assoc($resultGroups)) {
		    	$class = "";
		    	// Als er een categorie is geselecteerd controlleer of dat deze is
		    	if($groupName == $row['StockGroupID']){
		    		// Als deze categorie is geselecteerd is krijgt de link de class 'inUse' van toepassing (zie style.css)
		    		$class = "inUse";
		    	}else{
		    		// In het geval de de klasse niet is geselecteerd krijgt de link de class 'notInUse' (zie style.css)
		    		$class = "notInUse";
		    	}
		    	// Print de rij met de class die eerder is geset
		    	if(isset($_GET['sortSelect'])){
		    		echo "<a href=\"action_search.php?search=".$searchID."&categorie=".$row['StockGroupID']."&sortSelect=".filter_input(INPUT_GET, 'sortSelect')."\" class='$class'>".$row['StockGroupName']."</a>";
		    	}else{
		    		echo "<a href=\"action_search.php?search=".$searchID."&categorie=".$row['StockGroupID']."\" class='$class'>".$row['StockGroupName']."</a>";
		    	}

		    }
		    if($groupName != ""){
		    	echo "<a href=\"index.php\" class='clear'>See all</a>";
		    }
		    echo "</div>";
		} else {
		    echo "No groups yet!<br>";
		}

	}

	function zoekProduct(){
		// Verbinden met database
		include("connect.php");
		// Verkrijg de zoekterm
		$searchID = htmlspecialchars(mysqli_real_escape_string($connect, filter_input(INPUT_GET, 'search')));
		// Zoekterm zonder escape string voor weergeven op pagina
		$searchHTML = htmlspecialchars(filter_input(INPUT_GET, 'search'));
		$categorieID = htmlspecialchars(filter_input(INPUT_GET, 'categorie'));

		$onCategory = false;
		if($searchID != ""){

			if($categorieID != ""){
				$searchQuery = "SELECT StockItemName, StockItemID, UnitPrice, MarketingComments, StockGroupID, Photo FROM stockitems JOIN stockitemstockgroups USING(StockItemID) WHERE SearchDetails LIKE '%$searchID%' AND StockGroupID = $categorieID GROUP BY StockItemID";
				$onCategory = true;
			}else{
				$searchQuery = "SELECT StockItemName, StockItemID, UnitPrice, MarketingComments, StockGroupID, Photo FROM stockitems JOIN stockitemstockgroups USING(StockItemID) WHERE SearchDetails LIKE '%$searchID%' GROUP BY StockItemID";
			}
			// Zoek in de database naar producten die de zoekterm in de naam hebben


			// Haal naam id en comments uit de database
			$resultSearch = mysqli_query($connect, $searchQuery);
			// Check of er data beschikbaar is:
			if (mysqli_num_rows($resultSearch) > 0) {
				echo "<div class='search'><h3>Zoekresultaten voor \"<i>".htmlspecialchars($searchID)."</i>\"</h3></div>";

			    echo "<div class=\"grid-container-seach\">";
			    // Voor elk gevangen resultaat een productweergave printen
			    while($row = mysqli_fetch_assoc($resultSearch)) {
			    	echo "<a href='artikel.php?artikel=".$row['StockItemID']."&group=".$row['StockGroupID']."'>";
			    	echo "<div class=\"grid-item\">";
			    	echo "<h3>".$row['StockItemName']."</h3>";
				    if(file_exists("assets/producten/".$row['StockItemID']."/1.jpg")){
			    		echo "<img src='assets/producten/".$row['StockItemID']."/1.jpg' class='productImageHome'>";
			    	}else{
			    		echo "<img src='assets/geen.jpg' class='productImageHome'>";
			    	}
			    	echo "<p>".$row['MarketingComments']."</p>";
						echo "<p>".$row['UnitPrice']."</p>";
			    	echo "</div>";
			    	echo "</a>";
			    }
			    echo "</div>";
			} else {
				if($onCategory){
					echo "<div class='search'><h3>Nog geen producten met de zoekterm \"<i>$searchID</i>\" in deze categorie!</h3></div>";
				}else{
					echo "<div class='search'><h3>Nog geen producten met de zoekterm \"<i>$searchID</i>\"!</h3></div>";
				}

			}
		}else{
			header("location: index.php");

		}


	}
	// Sorteer functions
		function sorteerAlgemeenZoekpagina($method){
			// Verbinden met database
			include("connect.php");
			// Verkrijg de zoekterm
			$searchID = filter_input(INPUT_GET, 'search');
			$categorieID = filter_input(INPUT_GET, 'categorie');
			// Zoek in de database naar producten die de zoekterm in de naam hebben
			if(isset($_GET['categorie'])){
				if ($method == "Naam_a"){
				  $searchQuery = "SELECT StockItemName, StockItemID, MarketingComments, UnitPrice, StockGroupID, Photo FROM stockitems JOIN stockitemstockgroups USING(StockItemID) WHERE SearchDetails LIKE '%$searchID%' AND StockGroupID = $categorieID GROUP BY StockItemID ORDER BY StockItemName ASC ";
				} elseif ($method == "Naam_z"){
				  $searchQuery = "SELECT StockItemName, StockItemID, MarketingComments, UnitPrice, StockGroupID, Photo FROM stockitems JOIN stockitemstockgroups USING(StockItemID) WHERE SearchDetails LIKE '%$searchID%' AND StockGroupID = $categorieID GROUP BY StockItemID ORDER BY StockItemName DESC ";
				} elseif ($method == "Prijs_hoog"){
				  $searchQuery = "SELECT StockItemName, StockItemID, MarketingComments, UnitPrice, StockGroupID, Photo FROM stockitems JOIN stockitemstockgroups USING(StockItemID) WHERE SearchDetails LIKE '%$searchID%' AND StockGroupID = $categorieID GROUP BY StockItemID ORDER BY UnitPrice DESC ";
				} elseif ($method == "Prijs_laag"){
				  $searchQuery = "SELECT StockItemName, StockItemID, MarketingComments, UnitPrice, StockGroupID, Photo FROM stockitems JOIN stockitemstockgroups USING(StockItemID) WHERE SearchDetails LIKE '%$searchID%' AND StockGroupID = $categorieID GROUP BY StockItemID ORDER BY UnitPrice ASC ";
				}
			}else{
				if ($method == "Naam_a"){
				  $searchQuery = "SELECT StockItemName, StockItemID, MarketingComments, UnitPrice, StockGroupID, Photo FROM stockitems JOIN stockitemstockgroups USING(StockItemID) WHERE SearchDetails LIKE '%$searchID%' GROUP BY StockItemID ORDER BY StockItemName ASC ";
				} elseif ($method == "Naam_z"){
				  $searchQuery = "SELECT StockItemName, StockItemID, MarketingComments, UnitPrice, StockGroupID, Photo FROM stockitems JOIN stockitemstockgroups USING(StockItemID) WHERE SearchDetails LIKE '%$searchID%' GROUP BY StockItemID ORDER BY StockItemName DESC ";
				} elseif ($method == "Prijs_hoog"){
				  $searchQuery = "SELECT StockItemName, StockItemID, MarketingComments, UnitPrice, StockGroupID, Photo FROM stockitems JOIN stockitemstockgroups USING(StockItemID) WHERE SearchDetails LIKE '%$searchID%' GROUP BY StockItemID ORDER BY UnitPrice DESC ";
				} elseif ($method == "Prijs_laag"){
				  $searchQuery = "SELECT StockItemName, StockItemID, MarketingComments, UnitPrice, StockGroupID, Photo FROM stockitems JOIN stockitemstockgroups USING(StockItemID) WHERE SearchDetails LIKE '%$searchID%' GROUP BY StockItemID ORDER BY UnitPrice ASC ";
				}
			}

			// Haal naam id en comments uit de database
			$resultSearch = mysqli_query($connect, $searchQuery);
			// Check of er data beschikbaar is:
			if (mysqli_num_rows($resultSearch) > 0) {
				echo "<div class='search'><h3>Zoekresultaten voor \"<i>".htmlspecialchars($searchID)."</i>\"</h3></div>";
				echo "<div class=\"grid-container-seach\">";
				// Voor elk gevangen resultaat een productweergave printen
				while($row = mysqli_fetch_assoc($resultSearch)) {
					echo "<a href='artikel.php?artikel=".$row['StockItemID']."&group=".$row['StockGroupID']."'>";
		    	echo "<div class=\"grid-item\">";
		    	echo "<h3>".$row['StockItemName']."</h3>";
			    if(file_exists("assets/producten/".$row['StockItemID']."/1.jpg")){
		    		echo "<img src='assets/producten/".$row['StockItemID']."/1.jpg' class='productImageHome'>";
		    	}else{
		    		echo "<img src='assets/geen.jpg' class='productImageHome'>";
		    	}
		    	echo "<p>".$row['MarketingComments']."</p>";
					echo "<p>".$row['UnitPrice']."</p>";
					echo "</div>";
					echo "</a>";
				}
				echo "</div>";
			} else {
				echo "<div class='search'><h3>Nog geen producten met de zoekterm \"<i>$searchID</i>\"!</h3></div>";
			}
		}

		function sorteerAlgemeenIndex($method){
			// Verbinden met database
			include("connect.php");
			// Verkrijg de zoekterm
			$items = array();
			// Zoek in de database naar producten die de zoekterm in de naam hebben
			if(isset($_GET['categorie'])){
				$categorieID = filter_input(INPUT_GET, 'categorie');
				if ($method == "Naam_a"){
				  $searchQuery = "SELECT StockItemName, StockItemID, MarketingComments, UnitPrice, StockGroupID, Photo FROM stockitems JOIN stockitemstockgroups USING(StockItemID) WHERE StockGroupID = $categorieID GROUP BY StockItemID ORDER BY StockItemName ASC ";
				} elseif ($method == "Naam_z"){
				  $searchQuery = "SELECT StockItemName, StockItemID, MarketingComments, UnitPrice, StockGroupID, Photo FROM stockitems JOIN stockitemstockgroups USING(StockItemID) WHERE StockGroupID = $categorieID GROUP BY StockItemID ORDER BY StockItemName DESC ";
				} elseif ($method == "Prijs_hoog"){
				  $searchQuery = "SELECT StockItemName, StockItemID, MarketingComments, UnitPrice, StockGroupID, Photo FROM stockitems JOIN stockitemstockgroups USING(StockItemID) WHERE StockGroupID = $categorieID GROUP BY StockItemID ORDER BY UnitPrice DESC ";
				} elseif ($method == "Prijs_laag"){
				  $searchQuery = "SELECT StockItemName, StockItemID, MarketingComments, UnitPrice, StockGroupID, Photo FROM stockitems JOIN stockitemstockgroups USING(StockItemID) WHERE StockGroupID = $categorieID GROUP BY StockItemID ORDER BY UnitPrice ASC ";
				}
			}else{
				if ($method == "Naam_a"){
				  $searchQuery = "SELECT StockItemName, StockItemID, MarketingComments, UnitPrice, StockGroupID, Photo FROM stockitems JOIN stockitemstockgroups USING(StockItemID) GROUP BY StockItemID ORDER BY StockItemName ASC ";
				} elseif ($method == "Naam_z"){
				  $searchQuery = "SELECT StockItemName, StockItemID, MarketingComments, UnitPrice, StockGroupID, Photo FROM stockitems JOIN stockitemstockgroups USING(StockItemID) GROUP BY StockItemID ORDER BY StockItemName DESC ";
				} elseif ($method == "Prijs_hoog"){
				  $searchQuery = "SELECT StockItemName, StockItemID, MarketingComments, UnitPrice, StockGroupID, Photo FROM stockitems JOIN stockitemstockgroups USING(StockItemID) GROUP BY StockItemID ORDER BY UnitPrice DESC ";
				} elseif ($method == "Prijs_laag"){
				  $searchQuery = "SELECT StockItemName, StockItemID, MarketingComments, UnitPrice, StockGroupID, Photo FROM stockitems JOIN stockitemstockgroups USING(StockItemID) GROUP BY StockItemID ORDER BY UnitPrice ASC ";
				}
			}
			

			// Haal naam id en comments uit de database
			$resultSearch = mysqli_query($connect, $searchQuery);
			// Check of er data beschikbaar is:
			if (mysqli_num_rows($resultSearch) > 0) {
				// Voor elk gevangen resultaat een productweergave printen
			    while($row = mysqli_fetch_assoc($resultSearch)) {
			    	$items[] = $row['StockItemID'];
			    }
			} else {
					echo "<div class='geenProducten'>Nog geen producten met de zoekterm $searchID!</div>";
			}
			$pagina = 0;
			if(isset($_GET['paginaNr'])){
				$pagina = filter_input(INPUT_GET, 'paginaNr');
			}

			// Laden pagina nummers
			ladenPaginaNummers($items);
			echo "<div class=\"grid-container-seach2\">";

			
			if(isset($_GET['paginaNr'])){
				if($pagina != 0){
					$max = $pagina*filter_input(INPUT_GET, 'aantalProducten')+filter_input(INPUT_GET, 'aantalProducten');
				}else{
					$max = filter_input(INPUT_GET, 'aantalProducten');
				}
				for ($i = $pagina*filter_input(INPUT_GET, 'aantalProducten')+1; $i < $max+1; $i++) {
					if($items[$i-1] != NULL){
						laadProduct($items[$i-1]);
					}else{
						break;
					}
					
					
				}
			}else{
				for ($i = 0; $i < filter_input(INPUT_GET, 'aantalProducten'); $i++) {
					if($items[$i-1] != NULL){
						laadProduct($items[$i-1]);
					}else{
						break;
					}
					
				}
			}
	
			
			echo "</div>";

		}


// Artikelpagina - Artikel.php
	// Laad alle productinfo van het geselecteerde product.
	function laadProductpagina(){
		// Verbinden met database
		include("connect.php");
		// Verkrijg de zoekterm
		$artikelID = filter_input(INPUT_GET, 'artikel');

		// Zoek in de database naar producten die overeen komen met het geselecteerde artikel
		// JOIN stockitemholdings USING('StockItemID')
		// , QuantityOnHand
		if($artikelID != ""){
			$artikelQuery = "SELECT StockItemName, StockItemID, MarketingComments, UnitPrice, QuantityOnHand, IsChillerStock, CustomFields, ColorName, discountPercentage FROM stockitems JOIN stockitemholdings USING(StockItemID) LEFT JOIN colors USING(ColorID) LEFT JOIN discount USING(StockItemID) WHERE StockItemID = $artikelID";

			// Haal naam id en comments uit de database
			$resultArtikel = mysqli_query($connect, $artikelQuery);
			// Check of er data beschikbaar is:
			if (mysqli_num_rows($resultArtikel) > 0) {
				// Voor elk gevangen resultaat een productweergave printen
			    $row = mysqli_fetch_assoc($resultArtikel);

			    $stukprijs = $row['UnitPrice'];
			    $oldPrice = "";
			    $korting = "";
			    if($row['discountPercentage'] != NULL){
			    	$oldPrice = "&euro;".$row['UnitPrice'];
			    	$stukprijs = number_format($row['UnitPrice'] * (1 - $row['discountPercentage'] / 100),2);
			    	$korting = $row['discountPercentage']."% korting!";
			    }

			    echo "<h2>".$row['StockItemName']."</h2>";
			    echo "<hr>";
			    echo "<div class=\"grid-container-artikel-ondertitel\">
						<div class=\"grid-item-artikel-ondertitel\">
						<div class=\"w3-content\" style=\"max-width:20vw; margin-left:0vw;\">";


				//laad de hoofdafbeeldigen
				laadHoofdafbeeldigen($row['StockItemID']);


				echo "<div class=\"grid-item-artikel-ondertitel\"><div class=\"prijspaneel\">";
		  		if($row['IsChillerStock'] == 1){
		  			echo "<p>Gekoeld product!</p>";
		  		}
				echo "<form method='post' action='addToCart.php'>
						<p>$korting</p>
						<sub style='text-decoration: line-through'>$oldPrice</sub>
	  					<h2>&euro;<span id='prijs'>".$stukprijs."</span></h2>
	  					<input  type=\"number\" name=\"aantal\" min=\"1\" max=\"".number_format($row['QuantityOnHand'], 0, '', '')."\" value='1' onchange='setPrice(this.value)'>
	  					<span style='display: none;' id='prijsBegin'>".$stukprijs."</span>
	  					<input type='text' style='display: none;' name='artikelID' value='".$row['StockItemID']."'>
	  					<input type=\"image\" src=\"assets/artikelpag/winkelmandjegijs.png\" style=\"width:auto; height:40px; position:relative; \" align=\"middle\" border=\"0\" alt=\"Submit\" />
	  					<p>Only ".number_format($row['QuantityOnHand'], 0, ',', '.')." left in stock!</p>
	  				</form> </div></div></div>" ;

		  		// Laad de thumbnails
		  		laadThumbnails($row['StockItemID']);
		  		echo "<hr><p>";
		  		$fields = json_decode($row['CustomFields'], true);
		  		if($row['ColorName'] != NULL){
		  			echo "- <strong>Color:</strong> ".$row['ColorName']."<br>";
		  		}
		  		if($fields['CountryOfManufacture'] != ""){
		  			echo "- <strong>Country of manufacture:</strong> ".$fields['CountryOfManufacture'];
		  		}
		  		if($fields['Tags'] != NULL){
		  			$aantal = count($fields['Tags']);
		  			$current = 1;
		  			echo "<br>- <strong>Tags:</strong> ";
		  			foreach ($fields['Tags'] as $tag) {
		  				echo "$tag";
		  				if($current < $aantal){
		  					echo ", ";
		  				}
		  				$current++;
		  			}
		  		}
			  		

			  	echo "</p>";
	  		}
					
		

		}else{
			echo "<div class='geenProducten'>Sorry er ging iets mis met het vinden van het product</div>";
		}


	}

	// random product (artikel.php)
	function RandomProduct(){
	    include("connect.php");
	    $groupID = filter_input(INPUT_GET, 'group');
	    $itemID = filter_input(INPUT_GET, 'artikel');
	    $sql = "SELECT StockItemName, StockGroupID, StockItemID, Photo FROM stockitems JOIN stockitemstockgroups USING(StockItemID) WHERE StockGroupID = $groupID AND StockItemID <> $itemID ORDER BY rand(), StockItemName ASC LIMIT 6";
	    $resultAanbevolen = mysqli_query($connect, $sql);
	    if(mysqli_num_rows($resultAanbevolen) > 0){
	        while($row = mysqli_fetch_assoc($resultAanbevolen)){
	            echo "<a href='artikel.php?artikel=".$row['StockItemID']."&group=".$row['StockGroupID']."'><div class=\"grid-item-artikel-voorgesteld\">";
	            if($row['Photo'] != ""){
			    		echo "<img src='data:image/jpeg;base64,".base64_encode( $row['Photo'] )."'>";
			    	}else{
			    		echo "<img src='assets/geen.jpg'>";
			    	}
	            echo "<p class='voorgesteldTekst'>".$row['StockItemName']."</p>

	                    </div></a>";
	        }
	    }
	}



// Subfunctions Artikelpagina
	function laadHoofdafbeeldigen($itemID){
		if(file_exists("assets/producten/".$itemID."/1.jpg")){
			echo "
  				<img class=\"mySlides\" src=\"assets/producten/".$itemID."/1.jpg\" style=\"width:300px; height:250px;\">
  				<img class=\"mySlides\" src=\"assets/producten/".$itemID."/2.jpg\" style=\"width:300px; height:250px; display:none;\">
  				<img class=\"mySlides\" src=\"assets/producten/".$itemID."/3.jpg\" style=\"width:300px; height:250px; display:none\">
				</div></div>";
		}else{
			echo "<img class=\"mySlides\" src=\"assets/geen.jpg\" style=\"width:300px; height:250px; display:none\">
  				</div></div>";
			}
	}

	function laadThumbnails($itemID){
		echo "<hr><!-- SlideShow Van De Afbeeldingen --><div class=\"w3-row-padding w3-section\">";

	  	if(file_exists("assets/producten/".$itemID."/1.jpg")){
		  echo "
		    <div class=\"w3-col s4\">
		      <img class=\"demo w3-opacity w3-hover-opacity-off\" src=\"assets/producten/".$itemID."/1.jpg\" style=\"width:170px;height:110px;cursor:pointer\" onclick=\"currentDiv(1)\">
		    </div>
		    <div class=\"w3-col s4\">
		      <img class=\"demo w3-opacity w3-hover-opacity-off\" src=\"assets/producten/".$itemID."/2.jpg\" style=\"width:170px;height:110px;cursor:pointer\" onclick=\"currentDiv(2)\">
		    </div>
		    <div class=\"w3-col s4\">
		      <img class=\"demo w3-opacity w3-hover-opacity-off\" src=\"assets/producten/".$itemID."/3.jpg\" style=\"width:170px;height:110px;cursor:pointer\" onclick=\"currentDiv(3)\">
		    </div>
		  </div>";
		}else{
			echo "
				<div class=\"w3-col s4\">
			      <img class=\"demo w3-opacity w3-hover-opacity-off\" src=\"assets/geen.jpg\" style=\"width:170px;height:110px;cursor:pointer\" onclick=\"currentDiv(1)\">
			    </div>
			   </div>
			";
		}
	}



?>