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
		currentBackgroundPattern = $("#style #currentBackgroundPattern").val();

		var content = "<select name='selectPattern' id='selectPattern'>";
		for (var i = 0; i < patterns.length; i++) {
		    content += "<option ";
		    if (currentBackgroundPattern === patterns[i]) {
		    	content += "selected='selected' ";
		    }
		   	content += "value='" + patterns[i] + "'>" + patterns[i] + "</option>";
		}
		content += "</select>";
		return content;
	}

	function updatePatternDemo() {
		var patternName = $("#style #patternSelection option:selected").val();

		var p = getPattern(patternName);
		var curColor = "";
		if (lastPattern != "" && lastPattern != patternName) {
			setBkgColor(p[1]);
			curColor = p[1];
		} else {
			curColor = $("#style #backgroundColor").val();
		}
		lastPattern = patternName;
		
		p[0] = p[0].replace('<BG-COLOR>', curColor);
		p[0] = p[0].replace('<FONT-COLOR>', $("#style #fontColor").val());

		var content = '<div style=\"' + p[0] + '\">' + testText + '</div>';
		$("#style #patternDemo").html(content);
	}

	function setBkgColor(color) {
		$("#style #backgroundColor").val(color);
	}

	function getPattern(name) {

		var color = "#dfdfdf";

		switch(name) {
			case "Uni":
				break;
		    case "Stairs":
				color = "#444444";
		        break;
		    case "Half-Rombes":
				color = "#3366cc";
				break;
			case "Zig-Zag":
				color = "#EC173A";
				break;
			case "Weave":
				color = "#708090";
				break;
			case "Upholstery":
				color = "#330000";
				break;
			case "Starry-night":
				color = "black";
				break;
			case "Carbon":
				color = "#131313";
				break;
			case "Carbon-fibre":
				color = "#282828";
				break;
			case "Argyle":
				color = "#6d695c";
				break;
			case "Steps":
				color = "#FF7D9D";
				break;
			case "Waves":
				color = "#708090";
				break;
			case "Japanese-cube":
				color = "#555566";
				break;
			case "Checkerboard":
				color = "#eeeeee";
				break;
			case "Diagonal-checkerboard":
				color = "#eeeeee";
				break;
			case "Lined-paper":
				color = "#ffffff";
				break;
			case "Diagonal-stripes":
				color = "#808080";
				break;
			case "Cicada-stripes":
				color = "#026873";
				break;
			case "Vertical-stripes":
				color = "#808080";
				break;
			case "Horizontal-stripes":
		    	color = "#808080";
		    	break;
		    default:
		        alert("Erreur: motif inconnu (" + name + ")");
		}

		var pattern = "";
		$.ajaxSetup({async:false});
		$.get('patterns/' + name + '.css', function(data) {
			pattern = data;
		});
		$.ajaxSetup({async:true});
		return [pattern, color];
	}

});