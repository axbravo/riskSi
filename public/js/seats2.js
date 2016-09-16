$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
})

var price; //price
var map = [];
var taken = [];
var reserved = [];

$('document').ready(function () {
	getTakenSlots();
	

});

function getTakenSlots(){
    funcion = $('#pres_selection').val();
    zona = $('#zone_id').val();
    evento = $('#event_id').val();
    $.ajax({
        url: config.routes[5].takenSlots,
        type: 'get',
        async: false,
        data: 
        { 
            function_id: funcion,
            zone_id: zona,
            event_id: evento,
        },
        success: function( response ){
            //console.log("hola");
            $('#quantity').val(0);
            if(response != -1 )
            {
                taken = response[0];
                reserved = response[1];
                makeArray();
            }else if (response == ""){
            	console.log('vacio');
            	taken = [];
            	resetPay();
            	getPrice();
                makeArray();
            }
        },
        error: function( response ){
            console.log(response);
        }
    });
}

function makeArray(){
	zona = $('#zone_id').val();
	console.log(zona);
	$.ajax({
        url: config.routes[4].makeArray,
        type: 'get',
        async: false,
        data: 
        { 
            zone_id: zona,
        },
        success: function( response ){
            if(response != "")
            {
            	
            	map = response;
            	console.log(map);
                $('#parent-map').empty();
                $('#legend').empty();
                $('#selected-seats').empty();
		        $('#total').empty();
		        $('#counter').empty();
                $('#parent-map').append('<div id="seat-map"><div class="front">Escenario</div></div>');
                renderSeats();
            }
            else
            {
             	console.log('no respuesta');  
            }
        },
        error: function( response ){
            
        }
    });
	
}

function renderSeats() {



	var $cart = $('#selected-seats'), //Sitting Area

	$counter = $('#counter'), //Votes
	$total = $('#total'); //Total money
	$total2 = $('#total2'); //Total money
	var selected = [];
	var sc = $('#seat-map').seatCharts({
		map: map,
		naming : {
			top : false,
			getLabel : function (character, row, column) {
				return column;
			}
		},
		legend : { //Definition legend
			node : $('#legend'),
			items : [
				[ 'a', 'available',   'Libre' ],
				[ 'a', 'unavailable', 'Ocupado'],
				[ 'a', 'reserved', 'Reservado']
			]					
		},
		click: function () { //Click event
			
			if (this.status() == 'available') { //optional seat
				$('<li>R'+(this.settings.row+1)+' S'+this.settings.label+'</li>')
					.attr('id', 'cart-item-'+this.settings.id)
					.data('seatId', this.settings.id)
					.appendTo($cart);
				
				$counter.text(sc.find('selected').length+1);
				$total.text(recalculateTotal(sc)+parseFloat(price));
				$total2.val(recalculateTotal(sc)+price);
				
				selected.push(this.settings.id);
				//console.log(JSON.stringify(selected));
				count = selected.length;
				$('#quantity').val(count);
				if(count == 0){
			        $('#payModal').prop('disabled',true);
			        $('#total2').val("");
			    }else{
			        $('#payModal').prop('disabled',false);
			        $('#total2').val(count*price);
			    }
				$('#seats').val(JSON.stringify(selected));
				$('#payModal').prop('disabled',false);
				return 'selected';
			} else if (this.status() == 'selected') { //Checked
				//Update Number
				$counter.text(sc.find('selected').length-1);
				//update totalnum
				$total.text(recalculateTotal(sc)-price);
				$total2.val(recalculateTotal(sc)-price);
				//Delete reservation
				$('#cart-item-'+this.settings.id).remove();
				//optional
				
				var index = selected.indexOf(this.settings.id);
				if(index > -1){
					selected.splice(index,1);
					$('#seats').val(JSON.stringify(selected));
					if(selected.length == 0){
						$('#payModal').prop('disabled',true);
						$('#seats').val("");
					}
					//console.log(JSON.stringify(selected));
					count = selected.length;
					$('#quantity').val(count);
					if(count == 0){
				        $('#payModal').prop('disabled',true);
				        $('#total2').val("");
				    }else{
				        $('#payModal').prop('disabled',false);
				        $('#total2').val(count*price);
				    }
				}

				return 'available';
			} else if (this.status() == 'unavailable') { //sold
				return 'unavailable';
			} else if (this.status() == 'reserved'){
				return 'reserved';
			} else {
				return this.style();
			}
		}
	});

	//sold seat
	
	sc.get(taken).status('unavailable');
	sc.get(reserved).status('reserved');
	
};
//sum total money
function recalculateTotal(sc) {
	var total = 0;
	sc.find('selected').each(function () {
		total += parseFloat(price);
	});
			
	return total;
}

