function Sim(sldrId) {

	let id = document.getElementById(sldrId);
	if(id) {
		this.sldrRoot = id
	}
	else {
		this.sldrRoot = document.querySelector('.slider')
	};

	// объекты из разметки сайта
	this.sldrList = this.sldrRoot.querySelector('.sliderList');
	this.sldrElements = this.sldrList.querySelectorAll('.sliderElem');
	this.sldrElemFirst = this.sldrList.querySelector('.sliderElem');
	this.leftArrow = this.sldrRoot.querySelector('div.leftArrow');
	this.rightArrow = this.sldrRoot.querySelector('div.rightArrow');
	this.indicatorDots = this.sldrRoot.querySelector('div.sliderDots');

	// инициализация
	this.options = Sim.defaults;
	Sim.initialize(this)
};

Sim.defaults = {

	// опции для карусели
	loop: true,     // Бесконечное зацикливание слайдера
	auto: true,     // Автоматическое пролистывание
	interval: 10000, // Интервал между пролистыванием элементов (мс)
	arrows: true,   // Пролистывание стрелками
	dots: true      // Индикаторные точки
};

Sim.prototype.elemPrev = function(num) {
	var paragraph = document.querySelector(".textSlider");
	num = num || 1;

	let prevElement = this.currentElement;
	this.currentElement -= num;
	if(this.currentElement < 0) this.currentElement = this.elemCount-1; // переход в конец слайдов

	if(!this.options.loop) { // отключение левой стрелки при переходе в начало
		if(this.currentElement == 0) {
			this.leftArrow.style.display = 'none'
		};
		this.rightArrow.style.display = 'block'
	};
	
	this.sldrElements[this.currentElement].style.opacity = '1';
	this.sldrElements[prevElement].style.opacity = '0';

	if(this.options.dots) {
		this.dotOn(prevElement); this.dotOff(this.currentElement)
	}

	switch(this.currentElement) {
		case 0: 
			paragraph.innerHTML = "<b>'Boeing 777-300ER'</b> - В 2008 году мы добавили в наш парк Boeing 777-300ER — удлиненную версию модели 777-200ER. Благодаря двум реактивным двигателям мощностью 175 000 лошадиных сил эта модель «трех семерок» может развить скорость от 0 до 96 км/ч всего за 6 секунд. Именно поэтому этот двигатель включен в Книгу рекордов Гиннеса как самый мощный реактивный двигатель. Эти воздушные судна совершают рейсы в Буэнос-Айрес, Сантьяго, Сингапур, Денпасар, Токио и другие удивительные города, в зависимости от времени года."; 
			break;
		case 1: 
			paragraph.innerHTML = "<b>'Airbus A350-900'</b>, Пассажирский авиалайнер Airbus A350-900 (Аэробус 350-900) является базовой версией нового семейства дальнемагистральных широкофюзеляжных самолетов производства европейской компании Airbus. Новая разработка призвана заменить авиалайнеры предыдущих поколений - А330 и А340. Коммерческая эксплуатация самолетов Airbus A350-900 началась в январе 2015 года. Производство авиалайнеров продолжается высокими темпами. Количество заказов уже превысило 600 штук и постоянно растет. В 2017 году начались летные испытания следующей модели семейства Аэробус А350, более крупного самолета с удлиненным фюзеляжем А350-1000."; 
			break;
		case 2:
			paragraph.innerHTML = "<b>'ATR EVO'</b> Перспективный региональный авиалайнер ATR EVO разработанный европейской компанией ATR для замены самолетов семейства ATR 42/72. В конструкции нового регионального пассажирского самолета будут использоваться новые двигатели и крыло, более совершенная электроника, а также абсолютно новый дизайн пассажирского салона. Применение современных технологий позволит снизить эксплуатационные расходы примерно на 20%."; 
			break;
	}
};

Sim.prototype.elemNext = function(num) {
	var paragraph = document.querySelector(".textSlider");
	num = num || 1;
	
	let prevElement = this.currentElement;
	this.currentElement += num;
	if(this.currentElement >= this.elemCount) this.currentElement = 0; // переход в начало слайдов

	if(!this.options.loop) { // отключение правой стрелки при переходе в конец
		if(this.currentElement == this.elemCount-1) {
			this.rightArrow.style.display = 'none'
		};
		this.leftArrow.style.display = 'block'
	};

	this.sldrElements[this.currentElement].style.opacity = '1';
	this.sldrElements[prevElement].style.opacity = '0';

	if(this.options.dots) {
		this.dotOn(prevElement); this.dotOff(this.currentElement)
	}

	switch(this.currentElement) {
		case 0: 
			paragraph.innerHTML = "<b>'Boeing 777-300ER'</b> - В 2008 году мы добавили в наш парк Boeing 777-300ER — удлиненную версию модели 777-200ER. Благодаря двум реактивным двигателям мощностью 175 000 лошадиных сил эта модель «трех семерок» может развить скорость от 0 до 96 км/ч всего за 6 секунд. Именно поэтому этот двигатель включен в Книгу рекордов Гиннеса как самый мощный реактивный двигатель. Эти воздушные судна совершают рейсы в Буэнос-Айрес, Сантьяго, Сингапур, Денпасар, Токио и другие удивительные города, в зависимости от времени года."; 
			break;
		case 1: 
			paragraph.innerHTML = "<b>'Airbus A350-900'</b>, Пассажирский авиалайнер Airbus A350-900 (Аэробус 350-900) является базовой версией нового семейства дальнемагистральных широкофюзеляжных самолетов производства европейской компании Airbus. Новая разработка призвана заменить авиалайнеры предыдущих поколений - А330 и А340. Коммерческая эксплуатация самолетов Airbus A350-900 началась в январе 2015 года. Производство авиалайнеров продолжается высокими темпами. Количество заказов уже превысило 600 штук и постоянно растет. В 2017 году начались летные испытания следующей модели семейства Аэробус А350, более крупного самолета с удлиненным фюзеляжем А350-1000."; 
			break;
		case 2:
			paragraph.innerHTML = "<b>'ATR EVO'</b> Перспективный региональный авиалайнер ATR EVO разработанный европейской компанией ATR для замены самолетов семейства ATR 42/72. В конструкции нового регионального пассажирского самолета будут использоваться новые двигатели и крыло, более совершенная электроника, а также абсолютно новый дизайн пассажирского салона. Применение современных технологий позволит снизить эксплуатационные расходы примерно на 20%."; 
			break;
	}
};

Sim.prototype.dotOn = function(num) {
	this.indicatorDotsAll[num].style.cssText = 'background-color:#556; cursor:pointer;'
};

Sim.prototype.dotOff = function(num) {
	this.indicatorDotsAll[num].style.cssText = 'background-color:#BBB; cursor:default;'
};

Sim.initialize = function(that) {
	var paragraph = document.querySelector(".textSlider");
	paragraph.innerHTML = "<b>'Boeing 777-300ER'</b> - В 2008 году мы добавили в наш парк Boeing 777-300ER — удлиненную версию модели 777-200ER. Благодаря двум реактивным двигателям мощностью 175 000 лошадиных сил эта модель «трех семерок» может развить скорость от 0 до 96 км/ч всего за 6 секунд. Именно поэтому этот двигатель включен в Книгу рекордов Гиннеса как самый мощный реактивный двигатель. Эти воздушные судна совершают рейсы в Буэнос-Айрес, Сантьяго, Сингапур, Денпасар, Токио и другие удивительные города, в зависимости от времени года."; 

	that.elemCount = that.sldrElements.length; // Количество элементов

	that.currentElement = 0;
	let bgTime = getTime();

	function getTime() {
		return new Date().getTime();
	};
	function setAutoScroll() { // функция автопрокрутки
		that.autoScroll = setInterval(function() {
			let fnTime = getTime();
			if(fnTime - bgTime + 10 > that.options.interval) {
				bgTime = fnTime; that.elemNext()
			}
		}, that.options.interval)
	};

	if(that.elemCount <= 1) {   // Отключить навигацию
		that.options.auto = false; that.options.arrows = false; that.options.dots = false;
		that.leftArrow.style.display = 'none'; that.rightArrow.style.display = 'none'
	};
	if(that.elemCount >= 1) {   // показать первый элемент
		that.sldrElemFirst.style.opacity = '1';
	};

	if(!that.options.loop) {
		that.leftArrow.style.display = 'none';  // отключить левую стрелку
		that.options.auto = false; // отключить автопркрутку
	}
	else if(that.options.auto) {   // инициализация автопрокруки
		setAutoScroll();
		// Остановка прокрутки при наведении мыши на элемент
		that.sldrList.addEventListener('mouseenter', function() {clearInterval(that.autoScroll)}, false);
		that.sldrList.addEventListener('mouseleave', setAutoScroll, false)
	};

	if(that.options.arrows) {  // инициализация стрелок
		that.leftArrow.addEventListener('click', function() {
			let fnTime = getTime();
			if(fnTime - bgTime > 1000) {
				bgTime = fnTime; that.elemPrev()
			}
		}, false);
		that.rightArrow.addEventListener('click', function() {
			let fnTime = getTime();
			if(fnTime - bgTime > 1000) {
				bgTime = fnTime; that.elemNext()
			}
		}, false)
	}
	else {
		that.leftArrow.style.display = 'none'; that.rightArrow.style.display = 'none'
	};

	if(that.options.dots) {  // инициализация индикаторных точек
		let sum = '', diffNum;
		for(let i=0; i<that.elemCount; i++) {
			sum += '<span class="dot"></span>'
		};
		that.indicatorDots.innerHTML = sum;
		that.indicatorDotsAll = that.sldrRoot.querySelectorAll('span.dot');
		// Назначаем точкам обработчик события 'click'
		for(let n=0; n<that.elemCount; n++) {
			that.indicatorDotsAll[n].addEventListener('click', function() {
				diffNum = Math.abs(n - that.currentElement);
				if(n < that.currentElement) {
					bgTime = getTime(); that.elemPrev(diffNum)
				}
				else if(n > that.currentElement) {
					bgTime = getTime(); that.elemNext(diffNum)
				}
				// Если n == that.currentElement ничего не делаем
			}, false)
		};
		that.dotOff(0);  // точка[0] выключена, остальные включены
		for(let i=1; i<that.elemCount; i++) {
			that.dotOn(i)
		}
	}
};

new Sim();