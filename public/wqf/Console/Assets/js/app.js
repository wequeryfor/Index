$app = new Vue({
	'el': '#main',
	'data': {
		'error': {
			'login': []
		}
	},
	methods: {
		count: function(item){
			return item.length > 0 ? true : null;
		}
	}
});

function searchBellow(elem){
	txt = elem.val();
	$('.console-table tbody tr').hide();
	$('.console-table tbody tr:contains("'+txt+'")').show();
}