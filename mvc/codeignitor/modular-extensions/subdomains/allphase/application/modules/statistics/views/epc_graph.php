<script type="text/javascript">

	$(document).ready(function(){

		$('#pnl-epc-custom-date .button').live('click',function(e){

			if (typeof drawn_charts === 'undefined' || drawn_charts.length < 1){
				return;
			}

			var 
				from_date = $('#startdateepc').val(),
				to_date   = $('#enddateepc').val(),
				ch_series,
				ch_cats,
				ch_num = $(this).closest('.graph_form').find('.highchart').data('hchart');

			if (from_date==''){
				from_date = $('#startdateepc').attr('placeholder');
			}

			if (to_date==''){
				to_date   = $('#enddateepc').attr('placeholder');
			}

			if (from_date=='' || to_date=='') {

				return;
			}

			$.ajax({
				url: '/statistics/graphs/ajax_epc',
				async: false,
				type: 'POST',
				data: {
					start_date: from_date,
					end_date: to_date
				},
				dataType: 'json',
				success: function(response){

					var 
						ch_series = new Array(), 
						ch_cats   = new Array();

					if ( ! response.success){

						return;
					}

					for (i in response.data){
					
						ch_cats[i]   = response.data[i]['date'];
						ch_series[i] = parseFloat(response.data[i]['epc']);

					}
					
					drawn_charts[ch_num].xAxis[0].setCategories(ch_cats, false);
					drawn_charts[ch_num].setTitle(null, {text: 'Custom date range'});
					drawn_charts[ch_num].series[0].setData(ch_series, false);
					drawn_charts[ch_num].redraw();

				}

			});

			e.preventDefault();

		});

	});

</script>


