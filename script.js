var sliderSprites = [{x: "0px"   , y: "0px"   }, //F1 @ 5
					 {x: "-128px", y: "0px"   }, //F2 @ 10
					 {x: "-256px", y: "0px"   }, //F3 @ 25
					 {x: "0px"   , y: "-128px"}, //F4 @ 50 default
					 {x: "-128px", y: "-128px"}, //F5 @ 100
					 {x: "-256px", y: "-128px"}, //F6 @ 175
					 {x: "0px"   , y: "-256px"}, //F7 @ 250
					 {x: "-128px", y: "-256px"}, //F8 @ 500
					 {x: "-256px", y: "-256px"}  //F9 @ 1000
					];

function setSprites(amount) {
	var e = document.getElementById('slider');
	var o;

	//Horrible, I know, but it works until I optimise it
		 if(amount >= 0  && amount < 10) o = 0; //F1
	else if(amount >= 10 && amount < 25) o = 1; //F2
	else if(amount >= 25 && amount < 50) o = 2; //F3
	else if(amount >= 50 && amount < 100) o = 3; //F4
	else if(amount >= 100 && amount < 175) o = 4; //F5
	else if(amount >= 175 && amount < 250) o = 5; //F6
	else if(amount >= 250 && amount < 500) o = 6; //F7
	else if(amount >= 500 && amount < 1000) o = 7; //F8
	else if(amount == 1000) o = 8; //F9

	var f = e.children[5].children[0].style;
		//f.backgroundImage = "url(images/slider_f.png)";
		f.backgroundPositionX = sliderSprites[o].x;
		f.backgroundPositionY = sliderSprites[o].y;
	var b = e.children[5].children[1].style;
		//b.backgroundImage = "url(images/slider_b.png)";
		b.backgroundPositionX = sliderSprites[o].x;
		b.backgroundPositionY = sliderSprites[o].y;
}

function updateSlider() {
	this.step = "500";
	document.getElementById('amountinput').value = (this.value / 100).toFixed(2);
	var e = document.getElementById('slider');
	e.children[4].style.width = "" + ((this.value - this.min) / (this.max - this.min) * 75) + "%";
	setSprites(Number(this.value / 100));
	document.getElementById('contribute').setAttribute("value", (this.value / 100).toFixed(2));
}

function updateAmount() {
	if(Number(this.value) < 0) this.value = 0;
	else if(Number(this.value) > Number(this.max) * 4) this.value = this.max * 4;
	var e = document.getElementById('slider');
	var v = (((Number(this.value) - Number(this.min)) / (Number(this.max) - Number(this.min)) * 75) < 75) ? ((Number(this.value) - Number(this.min)) / (Number(this.max) - Number(this.min)) * 75) : 75;
	e.children[2].step = "";
	e.children[2].value = this.value * 100;
	e.children[4].style.width = "" + v + "%";
	setSprites(Number(this.value));
	document.getElementById('contribute').setAttribute("value", this.value);
}

function validateAmount() {
	if(this.value < 5) this.value = (5).toFixed(2);
	else this.value = Number(this.value).toFixed(2);
	setSprites(Number(this.value));
	document.getElementById('contribute').setAttribute("value", this.value);
}

function toggleExpand(elem) {
	for(var i = 0; i < elem.childElementCount; ++i) {
        elem.children[i].classList.toggle("flip");
    }
    elem.parentElement.parentElement.getElementsByClassName("description")[0].classList.toggle("expand");
}

function toggleInfo() {
	document.getElementById('info_overlay').classList.toggle("hidden");
	document.getElementById('cover').classList.toggle("hidden");
}

function toggleMailList() {
	document.getElementById('maillist_overlay').classList.toggle("hidden");
	document.getElementById('cover').classList.toggle("hidden");
}

document.getElementById('amountinput').addEventListener('input', updateAmount);
document.getElementById('amountinput').addEventListener('blur', validateAmount);
document.getElementById('sliderbar').addEventListener('input', updateSlider);