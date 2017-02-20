$(function () {
	var locale = $('.datepicker .input').attr('data-locale');

   $('.datepicker').datepicker({
	    format: 'yyyy-mm-dd',
	    todayHighlight: true,
	    autoclose: true,
	    orientation: "bottom left",
	    language: locale,
	});
});

$.fn.datepicker.dates.es = {
	days: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sabado", "Domingo"],
	daysShort: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab", "Dom"],
	daysMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa", "Do"],
	months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
	monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"]
};