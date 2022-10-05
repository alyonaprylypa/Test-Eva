var Cal = function (params) {
	this.divId = params.nodeId;
	this.events = params.events.reduce((r, a) => {
		r[a.date] = r[a.date] || [];  
		r[a.date].push(a.event);  
		return r; 
	  }, {});
	this.weekDays = ['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс'];
	this.months = ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'];
	let d = new Date();
	this.currMonth = d.getMonth();
	this.currYear = d.getFullYear();
	this.currDay = d.getDate();
}

Cal.prototype.init = function () {
	this.show();
	BX.bind(BX('btnNext'), 'click', () => {
		this.nextMonth();
	});
	BX.bind(BX('btnPrev'), 'click', () => {
		this.previousMonth();
	});
	BX.bind(BX('sendRequest'), 'click', () => {
		this.addNotice(BX('eventDate').value, BX('eventText').value);
		$('#exampleModalCenter').modal('hide');
		BX.ajax({
			url: '/local/components/custom/intranet.absence.calendar/ajax.php',
			data: {
				date: BX('eventDate').value,
				event: BX('eventText').value
			},
			method: 'POST',
			dataType: 'json',
			timeout: 10,
			onsuccess: function (res) {
			},
			onfailure: e => {
				console.error(e)
			}
		});
		this.show();
	})
}

Cal.prototype.addNotice = function(date, text) {
	if(date in this.events) {
		this.events[date].push(text);
	} else {
		this.events[date] = [text];
	}
}

Cal.prototype.getNotice = function(date) {
	return date in this.events ? this.events[date] : false;
}

Cal.prototype.getNotices = function(date) {
	let nots = this.getNotice(date);
	if(nots.length) {
		let nodes = '<ul class="col notices">'
		nots.forEach(e => {
			nodes +=`<li title="${e}"><button type="button" onclick="alert('${e}')" class="btn btn-outline-warning">.</button></li>`
		})
		nodes +='</ul>'
		return nodes;
	} else {
		return '';
	}
}

Cal.prototype.nextMonth = function () {
	if (this.currMonth == 11) {
		this.currMonth = 0;
		this.currYear = this.currYear + 1;
	}
	else {
		this.currMonth = this.currMonth + 1;
	}
	this.show();
}

Cal.prototype.previousMonth = function () {
	if (this.currMonth == 0) {
		this.currMonth = 11;
		this.currYear = this.currYear - 1;
	}
	else {
		this.currMonth = this.currMonth - 1;
	}
	this.show();
}

Cal.prototype.show = function () {
	this.showMonth(this.currYear, this.currMonth);
}

Cal.prototype.formatDate = (year, month, day) => {
	return new Date(year, month, day).toISOString().split('T')[0];
}

Cal.prototype.showMonth = function (y, m) {
	let firstDayOfMonth = new Date(y, m, 7).getDay()
		, lastDateOfMonth = new Date(y, m + 1, 0).getDate()
		, lastDayOfLastMonth = m == 0 ? new Date(y - 1, 11, 0).getDate() : new Date(y, m, 0).getDate();
	let html = `<table><thead><tr><td colspan="7">${this.months[m]} ${y}</td></tr></thead><tr class="days">`;
	for (let i = 0; i < this.weekDays.length; i++) {
		html += `<td>${this.weekDays[i]}'</td>`;
	}
	html += '</tr>';
	let i = 1;
	do {
		let dow = new Date(y, m, i).getDay();
		if (dow == 1) {
			html += '<tr>';
		}
		else if (i == 1) {
			html += '<tr>';
			let k = lastDayOfLastMonth - firstDayOfMonth + 1;
			let date = this.formatDate(this.currYear, this.currMonth - 1, k + 1);
			for (let j = 0; j < firstDayOfMonth; j++) {
				html += `<td class="not-current"><span class='col' date="${date}"> ${k} </span>${this.getNotices(date)}</td>`;
				k++;
			}
		}
		let chk = new Date();
		let chkY = chk.getFullYear();
		let chkM = chk.getMonth();
		let date = this.formatDate(this.currYear, this.currMonth, i + 1);
		if (chkY == this.currYear && chkM == this.currMonth && i == this.currDay) {
			html += `<td class="today"><span class='col' date="${date}"> ${i} </span>${this.getNotices(date)}</td>`;
		} else {
			html += `<td class="normal"><span class='col' date="${date}"> ${i} </span>${this.getNotices(date)}</td>`;
		}
		if (dow == 0) {
			html += '</tr>';
		}
		else if (i == lastDateOfMonth) {
			let k = 1;
			for (dow; dow < 7; dow++) {
				let date = this.formatDate(this.currYear, this.currMonth + 1, k + 1);
				html += `<td class="not-current"><span class='col' date="${date}"> ${k} </span>${this.getNotices(date)}</td>`;
				k++;
			}
		}
		i++;
	} while (i <= lastDateOfMonth);
	html += '</table>';
	document.getElementById(this.divId).innerHTML = html;
}