function mydChangeTab(e) {
	e.preventDefault();
	let tabs = document.querySelectorAll('.myd-tab'),
	tabContent = document.querySelectorAll('.myd-tabs-content'),
	clicked = e.target;

	tabs.forEach(item => {
		item.classList.remove('nav-tab-active');
	});
	tabContent.forEach(item => {
		item.classList.remove('myd-tabs-content--active');
	});
	clicked.classList.add('nav-tab-active');
	document.getElementById(clicked.id + '-content').classList.add('myd-tabs-content--active');
}

window.mydChangeTab = mydChangeTab;

function owmInitConditionalSubsettings() {
	const conditionals = document.querySelectorAll('[data-owm-show-when]');
	const watched = new Map();

	conditionals.forEach(el => {
		const raw = el.getAttribute('data-owm-show-when') || '';
		const sep = raw.indexOf(':');
		if (sep === -1) return;
		const name = raw.slice(0, sep);
		const value = raw.slice(sep + 1);
		if (!watched.has(name)) watched.set(name, []);
		watched.get(name).push({ el, value });
	});

	watched.forEach((items, name) => {
		const radios = document.querySelectorAll('input[type="radio"][name="' + name + '"]');
		if (!radios.length) return;
		const update = () => {
			let checkedValue = '';
			radios.forEach(r => { if (r.checked) checkedValue = r.value; });
			items.forEach(({ el, value }) => {
				el.hidden = checkedValue !== value;
			});
		};
		radios.forEach(r => r.addEventListener('change', update));
	});
}

if (document.readyState === 'loading') {
	document.addEventListener('DOMContentLoaded', owmInitConditionalSubsettings);
} else {
	owmInitConditionalSubsettings();
}
