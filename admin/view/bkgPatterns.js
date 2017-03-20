$( document ).ready(function() {

	var patterns = [
		"Uni",
		"Stairs",
		"Half-Rombes",
		"Zig-Zag",
		"Weave",
		"Upholstery",
		"Starry-night",
		"Carbon",
		"Carbon-fibre",
		"Argyle",
		"Steps",
		"Waves",
		"Japanese-cube",
		"Checkerboard",
		"Diagonal-checkerboard",
		"Lined-paper",
		"Diagonal-stripes",
		"Cicada-stripes",
		"Vertical-stripes",
		"Horizontal-stripes"
	];

	var testText = "\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"";

	var lastPattern = "";

	$("#style #patternSelection").html(getSelectHTML());
	setInterval(updatePatternDemo, 100);

	function getSelectHTML() {
		var content = "<select id='selectPattern'>";
		for (var i = 0; i < patterns.length; i++) {
		    content += "<option value='" + patterns[i] + "'>" + patterns[i] + "</option>";
		}
		content += "</select>";
		return content;
	}

	function updatePatternDemo() {
		var patternName = $("#style #patternSelection option:selected").val();

		p = getPattern(patternName);
		var curColor = "";
		if (lastPattern != patternName) {
			setBkgColor(p[1]);
			curColor = p[1];
		} else {
			curColor = $("#style #backgroundColor").val();
		}
		lastPattern = patternName;

		var content = '<div style=\"color: ' + $("#style #fontColor").val() + '; ';
		if (p[2]) {
			content += "background-color: " + curColor + "; ";
			content += p[0];
		} else {
			content += p[0];
			content += "background-color: " + curColor + "; ";
		}
		content += '\">' + testText + '</div>';
		$("#style #patternDemo").html(content);
	}

	function setBkgColor(color) {
		$("#style #backgroundColor").val(color);
	}

	function getPattern(name) {

		var pattern = "";
		var color = "#dfdfdf";
		var isColBefore = false;

		switch(name) {
			case "Uni":
				pattern = "";
				break;
		    case "Stairs":
		        pattern = "background: " +
					"linear-gradient(63deg, #999 23%, transparent 23%) 7px 0, " +
					"linear-gradient(63deg, transparent 74%, #999 78%), " +
					"linear-gradient(63deg, transparent 34%, #999 38%, #999 58%, transparent 62%); " +
					"background-size: 16px 48px;";
				color = "#444444";
		        break;
		    case "Half-Rombes":
		        pattern = "background: " +
					"linear-gradient(115deg, transparent 75%, rgba(255,255,255,.8) 75%) 0 0," +
					"linear-gradient(245deg, transparent 75%, rgba(255,255,255,.8) 75%) 0 0," +
					"linear-gradient(115deg, transparent 75%, rgba(255,255,255,.8) 75%) 7px -15px," +
					"linear-gradient(245deg, transparent 75%, rgba(255,255,255,.8) 75%) 7px -15px," +
					"#36c;" +
					"background-size: 15px 30px;";
				color = "#3366cc";
				isColBefore = true;
				break;
			case "Zig-Zag":
		        pattern = "background: " +
		        	"linear-gradient(135deg, #ECEDDC 25%, transparent 25%) -50px 0," +
					"linear-gradient(225deg, #ECEDDC 25%, transparent 25%) -50px 0," +
					"linear-gradient(315deg, #ECEDDC 25%, transparent 25%)," +
					"linear-gradient(45deg, #ECEDDC 25%, transparent 25%);" +
					"background-size: 100px 100px;";
				color = "#EC173A";
				break;
			case "Weave":
		        pattern = "background:" +
					"linear-gradient(135deg, #708090 22px, #d9ecff 22px, #d9ecff 24px, transparent 24px, transparent 67px, #d9ecff 67px, #d9ecff 69px, transparent 69px)," +
					"linear-gradient(225deg, #708090 22px, #d9ecff 22px, #d9ecff 24px, transparent 24px, transparent 67px, #d9ecff 67px, #d9ecff 69px, transparent 69px)0 64px;" +
					"background-size: 64px 128px;";
				color = "#708090";
				break;
			case "Upholstery":
		        pattern = "background:" +
					"radial-gradient(hsl(0, 100%, 27%) 4%, hsl(0, 100%, 18%) 9%, hsla(0, 100%, 20%, 0) 9%) 0 0," +
					"radial-gradient(hsl(0, 100%, 27%) 4%, hsl(0, 100%, 18%) 8%, hsla(0, 100%, 20%, 0) 10%) 50px 50px," +
					"radial-gradient(hsla(0, 100%, 30%, 0.8) 20%, hsla(0, 100%, 20%, 0)) 50px 0," +
					"radial-gradient(hsla(0, 100%, 30%, 0.8) 20%, hsla(0, 100%, 20%, 0)) 0 50px," +
					"radial-gradient(hsla(0, 100%, 20%, 1) 35%, hsla(0, 100%, 20%, 0) 60%) 50px 0," +
					"radial-gradient(hsla(0, 100%, 20%, 1) 35%, hsla(0, 100%, 20%, 0) 60%) 100px 50px," +
					"radial-gradient(hsla(0, 100%, 15%, 0.7), hsla(0, 100%, 20%, 0)) 0 0," +
					"radial-gradient(hsla(0, 100%, 15%, 0.7), hsla(0, 100%, 20%, 0)) 50px 50px," +
					"linear-gradient(45deg, hsla(0, 100%, 20%, 0) 49%, hsla(0, 100%, 0%, 1) 50%, hsla(0, 100%, 20%, 0) 70%) 0 0," +
					"linear-gradient(-45deg, hsla(0, 100%, 20%, 0) 49%, hsla(0, 100%, 0%, 1) 50%, hsla(0, 100%, 20%, 0) 70%) 0 0;";
				color = "#330000";
				break;
			case "Starry-night":
		        pattern = "background-image:" +
					"radial-gradient(white, rgba(255,255,255,.2) 2px, transparent 40px)," +
					"radial-gradient(white, rgba(255,255,255,.15) 1px, transparent 30px)," +
					"radial-gradient(white, rgba(255,255,255,.1) 2px, transparent 40px)," +
					"radial-gradient(rgba(255,255,255,.4), rgba(255,255,255,.1) 2px, transparent 30px);" +
					"background-size: 550px 550px, 350px 350px, 250px 250px, 150px 150px;" +
					"background-position: 0 0, 40px 60px, 130px 270px, 70px 100px;";
				color = "black";
				isColBefore = true;
				break;
			case "Carbon":
		        pattern = "background: " +
					"linear-gradient(27deg, #151515 5px, transparent 5px) 0 5px," +
					"linear-gradient(207deg, #151515 5px, transparent 5px) 10px 0px," +
					"linear-gradient(27deg, #222 5px, transparent 5px) 0px 10px," +
					"linear-gradient(207deg, #222 5px, transparent 5px) 10px 5px," +
					"linear-gradient(90deg, #1b1b1b 10px, transparent 10px)," +
					"linear-gradient(#1d1d1d 25%, #1a1a1a 25%, #1a1a1a 50%, transparent 50%, transparent 75%, #242424 75%, #242424);" +
					"background-size: 20px 20px;";
				color = "#131313";
				break;
			case "Carbon-fibre":
		        pattern = "background:" +
					"radial-gradient(black 15%, transparent 16%) 0 0," +
					"radial-gradient(black 15%, transparent 16%) 8px 8px," +
					"radial-gradient(rgba(255,255,255,.1) 15%, transparent 20%) 0 1px," +
					"radial-gradient(rgba(255,255,255,.1) 15%, transparent 20%) 8px 9px;" +
					"background-size:16px 16px;";
				color = "#282828";
				break;
			case "Argyle":
		        pattern = "background-image:" +
					"repeating-linear-gradient(120deg, rgba(255,255,255,.1), rgba(255,255,255,.1) 1px, transparent 1px, transparent 60px)," +
					"repeating-linear-gradient(60deg, rgba(255,255,255,.1), rgba(255,255,255,.1) 1px, transparent 1px, transparent 60px)," +
					"linear-gradient(60deg, rgba(0,0,0,.1) 25%, transparent 25%, transparent 75%, rgba(0,0,0,.1) 75%, rgba(0,0,0,.1))," +
					"linear-gradient(120deg, rgba(0,0,0,.1) 25%, transparent 25%, transparent 75%, rgba(0,0,0,.1) 75%, rgba(0,0,0,.1));" +
					"background-size: 70px 120px;";
				color = "#6d695c";
				isColBefore = true;
				break;
			case "Steps":
		        pattern = "background-size: 58px 58px;" +
					"background-position: 0px 2px, 4px 35px, 29px 31px, 33px 6px," +
					"0px 36px, 4px 2px, 29px 6px, 33px 30px;" +
					"background-image: " +
					"linear-gradient(335deg, #C90032 23px, transparent 23px)," +
					"linear-gradient(155deg, #C90032 23px, transparent 23px)," +
					"linear-gradient(335deg, #C90032 23px, transparent 23px)," +
					"linear-gradient(155deg, #C90032 23px, transparent 23px)," +
					"linear-gradient(335deg, #C90032 10px, transparent 10px)," +
					"linear-gradient(155deg, #C90032 10px, transparent 10px)," +
					"linear-gradient(335deg, #C90032 10px, transparent 10px)," +
					"linear-gradient(155deg, #C90032 10px, transparent 10px);";
				color = "#FF7D9D";
				isColBefore = true;
				break;
			case "Waves":
		        pattern = "background: " +
					"radial-gradient(circle at 100% 50%, transparent 20%, rgba(255,255,255,.3) 21%, rgba(255,255,255,.3) 34%, transparent 35%, transparent)," +
					"radial-gradient(circle at 0% 50%, transparent 20%, rgba(255,255,255,.3) 21%, rgba(255,255,255,.3) 34%, transparent 35%, transparent) 0 -50px;" +
					"background-size:75px 100px;";
				color = "#708090";
				isColBefore = false;
				break;
			case "Japanese-cube":
		        pattern = "background-image: linear-gradient(30deg, #445 12%, transparent 12.5%, transparent 87%, #445 87.5%, #445)," +
					"linear-gradient(150deg, #445 12%, transparent 12.5%, transparent 87%, #445 87.5%, #445)," +
					"linear-gradient(30deg, #445 12%, transparent 12.5%, transparent 87%, #445 87.5%, #445)," +
					"linear-gradient(150deg, #445 12%, transparent 12.5%, transparent 87%, #445 87.5%, #445)," +
					"linear-gradient(60deg, #99a 25%, transparent 25.5%, transparent 75%, #99a 75%, #99a), " +
					"linear-gradient(60deg, #99a 25%, transparent 25.5%, transparent 75%, #99a 75%, #99a);" +
					"background-size:80px 140px;" +
					"background-position: 0 0, 0 0, 40px 70px, 40px 70px, 0 0, 40px 70px;";
				color = "#555566";
				isColBefore = true;
				break;
			case "Checkerboard":
		        pattern = "background-image: linear-gradient(45deg, black 25%, transparent 25%, transparent 75%, black 75%, black), " +
					"linear-gradient(45deg, black 25%, transparent 25%, transparent 75%, black 75%, black);" +
					"background-size:60px 60px;" +
					"background-position:0 0, 30px 30px";
				color = "#eeeeee";
				isColBefore = true;
				break;
			case "Diagonal-checkerboard":
		        pattern = "background-image: linear-gradient(45deg, black 25%, transparent 25%, transparent 75%, black 75%, black), " +
					"linear-gradient(-45deg, black 25%, transparent 25%, transparent 75%, black 75%, black);" +
					"background-size:60px 60px;";
				color = "#eeeeee";
				isColBefore = true;
				break;
			case "Lined-paper":
		        pattern = "background-image: " +
					"linear-gradient(90deg, transparent 79px, #abced4 79px, #abced4 81px, transparent 81px)," +
					"linear-gradient(#eee .1em, transparent .1em);" +
					"background-size: 100% 1.2em;";
				color = "#ffffff";
				isColBefore = true;
				break;
			case "Diagonal-stripes":
		        pattern = "background-image: repeating-linear-gradient(45deg, transparent, transparent 35px, rgba(255,255,255,.5) 35px, rgba(255,255,255,.5) 70px);";
				color = "#808080";
				isColBefore = true;
				break;
			case "Cicada-stripes":
		        pattern = "background-image: linear-gradient(90deg, rgba(255,255,255,.07) 50%, transparent 50%)," +
					"linear-gradient(90deg, rgba(255,255,255,.13) 50%, transparent 50%)," +
					"linear-gradient(90deg, transparent 50%, rgba(255,255,255,.17) 50%)," +
					"linear-gradient(90deg, transparent 50%, rgba(255,255,255,.19) 50%);" +
					"background-size: 13px, 29px, 37px, 53px;";
				color = "#026873";
				isColBefore = true;
				break;
			case "Vertical-stripes":
		        pattern = "background-image: linear-gradient(90deg, transparent 50%, rgba(255,255,255,.5) 50%);" +
					"background-size: 50px 50px;";
				color = "#808080";
				isColBefore = true;
				break;
			case "Horizontal-stripes":
		        pattern = "background-image: linear-gradient(transparent 50%, rgba(255,255,255,.5) 50%);" +
					"background-size: 50px 50px;";
		    	color = "#808080";
		    	isColBefore = true;
		    	break;
		    default:
		        alert("Erreur: motif inconnu (" + name + ")");
		}

		return [pattern, color, isColBefore];
	}

});