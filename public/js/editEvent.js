$('document').ready(function () {

  $('#multiple-mode-on').on('click', function(){
    //alert("boolean val: "+$('#multiple-mode-on').is(":checked"));
    $('.selected').removeClass('selected').addClass('reserved');
  });
  $('#single-mode-on').on('click', function(){
    //alert("boolean val: "+$('#multiple-mode-on').is(":checked"));
    $('.selected').removeClass('selected').addClass('reserved');
  });
  makeArray1();
});

function makeArray1(){
  $("[name^='seats_ids']").remove();
  var e = $('[name=local_id]')[0];
    var index= e.options[e.selectedIndex].value;
  local = index;
  console.log(local);
  $.ajax({
        url: config.routes[4].makeArray,
        type: 'get',
        async: false,
        data: 
        { 
            local_id: local,
        },
        success: function( response ){
            if(response != "")
            {
              
              map = response;
              console.log(map);
                $('#parent-map').empty();
                $('#legend').empty();
                $('#selected-seats').empty();
                $('#parent-map').append('<div id="seat-map"><div class="front">Escenario</div></div>');
                $('#capacity-display').hide();
                $('#capacity-display-label').hide();
                renderSeats();
            }
            else
            {
              $('#capacity-display').show();
              $('#capacity-display-label').show();
              $('#parent-map').empty();
                $('#legend').empty();
                $('#selected-seats').empty();
              console.log('no respuesta');  
            }
        },
        error: function( response ){
            
        }
    });
}

function renderSeats() {

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
        [ 'b', 'unavailable', 'Ocupado'],
        [ 'c', 'reserved', 'Reservado']
      ]         
    },
    click: function () { //Click event
      
      if(this.status()=='unavailable'){
                this.status('unavailable');
                return 'unavailable';
              }
              if(this.status()=='reserved'){
                this.status('reserved');
                return 'reserved';
              }
              if($('#multiple-mode-on').is(':checked')){
                  if(this.status()=='selected'){
                    console.log("clic en un selected");
                    //validarSiUnavailable();
                    
                    if($('.selected').length>=1){
                      var selec1 = $('.selected')[0].id;
                      var selec2 = this.node().attr('id');
                      var col_ini1 = parseInt(selec1.split("_")[1]);
                      var fil_ini1 = parseInt(selec1.split("_")[0]);
                      var col_ini2 = parseInt(selec2.split("_")[1]);
                      var fil_ini2 = parseInt(selec2.split("_")[0]);
                      var col_ini = col_ini2;
                      var fil_ini = fil_ini2;
                      if(col_ini1 < col_ini2) col_ini = col_ini1;
                      if(fil_ini1 < fil_ini2) fil_ini = fil_ini1;
                      var dif1 = Math.abs(col_ini1 - col_ini2);
                      var dif2 = Math.abs(fil_ini1 - fil_ini2);
                      //ponerAvailable(col_ini, fil_ini,dif1,dif2,selec1,selec2);
                      
                      for(i=col_ini;i<= col_ini+dif1;i++) 
                        for(j=fil_ini;j<= fil_ini+dif2;j++){
                          var id = ""+j+"_"+i;
                          if($('#'+id).length && id!=selec1 && id!=selec2){
                            $('#'+id).removeClass('reserved').addClass('available');
                          }
                        } 
                        
                    }

                    this.node().removeClass('selected').addClass('available');
                    this.status('available');
                    return 'available';
                  }
                  if(this.status()=='available'){
                     
                    if($('.selected').length>=2){
                      alert('primero pase a single y luego regrese a multi');
                      this.status('available');
                      this.node().removeClass('selected').addClass('available');
                      return 'available';
                    }

                    console.log('tiene available');
                    this.status('selected');
                    this.node().addClass('selected');
                    //var res = validarSiAvailable();
                    //if(res!=null) return 'available';
                    

                    if($('.selected').length >1){
                      var selec1 = $('.selected')[0].id;
                      var selec2 = $('.selected')[1].id;
                      var col_ini1 = parseInt(selec1.split("_")[1]);
                      var fil_ini1 = parseInt(selec1.split("_")[0]);
                      var col_ini2 = parseInt(selec2.split("_")[1]);
                      var fil_ini2 = parseInt(selec2.split("_")[0]);
                      var col_ini = col_ini2;
                      var fil_ini = fil_ini2;
                      if(col_ini1 < col_ini2) col_ini = col_ini1;
                      if(fil_ini1 < fil_ini2) fil_ini = fil_ini1;
                        var dif1 = Math.abs(col_ini1 - col_ini2);
                        var dif2 = Math.abs(fil_ini1 - fil_ini2);
                      for(i=col_ini;i<= col_ini+dif1;i++) 
                        for(j=fil_ini;j<= fil_ini+dif2;j++){
                          var id = ""+j+"_"+i;
                          if($('#'+id).length){
                            if($('#'+id).hasClass('unavailable')){
                              alert("hay asientos pertencientes a otras zonas en el area seleccionada");
                              this.node().removeClass('selected').addClass('available');
                              this.status('available');
                              return 'available';
                            }
                          }
                        }
                       // ponerUnavailable(col_ini, fil_ini,dif1, dif2);
                        
                      for(i=col_ini;i<= col_ini+dif1;i++) 
                        for(j=fil_ini;j<= fil_ini+dif2;j++){
                          var id = ""+j+"_"+i;
                          if($('#'+id).length && !$('#'+id).hasClass('selected')){
                            $('#'+id).removeClass('available').addClass('reserved');
                          }
                        }
                        
                    }

                    
                    this.status('selected');
                    return 'selected';
                  }
              }
              if($('#single-mode-on').is(':checked')){
                if(this.status()=='selected'){
                  this.node().removeClass('selected').addClass('available');
                  this.status('available');
                  return 'available';
                }
                if(this.status()=='available'){
                  this.node().removeClass('available').addClass('selected');
                  this.status('selected');
                  return 'selected';
                }
                if(this.status()=='reserved'){
                  this.status('reserved');
                  return 'reserved';
                }
              }
    },
    focus  : function() {
              if(this.node().hasClass('reserved')|| this.node().hasClass('unavailable'))
                return this.style();
              if (!this.node().hasClass('unavailable')) {
                  return 'focused';
              
              } else  {
                  return this.style();
              }
            },
  });

  //sold seat
  
  //sc.get(taken).status('unavailable');
  //sc.get(reserved).status('reserved');
  
};

$(document).ready(function() {

       holi();

       function holi(){

        var e = document.getElementsByName('local_id')[0];
        var index= e.options[e.selectedIndex].value;
        document.getElementById('capacity-display').value = document.getElementsByName('capacity_'+index)[0].value;        
        var zones=document.getElementsByName("zone_names[]");
        var numZones=zones.length;
        console.log("numero de zonas " + numZones);
        var capacity=document.getElementsByName("zone_capacity[]");

      
       for(var i=0;i<numZones;i++){
         document.getElementById('capacity-display').value=document.getElementById('capacity-display').value-capacity[i].value;
       }  
        
      var e = $('[name=local_id]')[0];

        var index= e.options[e.selectedIndex].value;
        console.log(index);
        var algo = $('#row_' + index).val();
        //console.log("algo "+algo);
        var table = document.getElementById("table-zone");

        for(var i = table.rows.length - 1; i > 0; i--)
        {
            table.deleteRow(i);
        }

        if(algo !== undefined && algo >=1){
          //si el local tiene asientos y filas numeradas Do this 
          //console.log("index "+index);
          var rows = $('#row_'+index).val();
          var columns = $('#column_'+index).val();

          // setear maximo filas maxima col
          document.getElementById("input-column").max=columns;
          document.getElementById("input-row").max=rows;
          document.getElementById("input-colIni").max=columns;
          document.getElementById("input-rowIni").max=rows;

          var tam= $('[id=invisible_id]').size();
        
          //$('#seat-map-'+index).show();
          $('#input-column').show();
          $('#input-row').show();
          $('#input-colIni').show();
          $('#input-rowIni').show();
          $('#label_col').show();
          $('#label_fil').show();
          $('#label_fini').show();
          $('#label_cini').show();
          $('#dist').show();
          $('#label_capacity').hide();
          $('#input-capacity').hide();

          document.getElementById('input-capacity').disabled=true;
        }else{
          //si el local no tiene asientos numerados Do this 
          //$('#seat-map').empty();

          document.getElementById('input-capacity').disabled=false;
          var tam= $('[id=invisible_id]').size();

          
          $('#input-column').hide();
          $('#input-row').hide();
          $('#input-colIni').hide();
          $('#input-rowIni').hide();
          $('#label_col').hide();
          $('#label_fil').hide();
          $('#label_fini').hide();
          $('#label_cini').hide();
          $('#dist').hide();
          $('#label_capacity').show();
          $('#input-capacity').show();
        }
      }
    });

$('document').ready(function(){
  if($('#input-capacity').attr('disabled')){
      var cantZones = $('[name=zones_ids]').length;
      var i=0;
      for(i = 0;i<cantZones;i++){
        var seat_ids = getZoneSeatsIds($('#zones_ids_'+i).val());
        var j=0;
        for(j=0; j<seat_ids.length;j++){
          $('#'+seat_ids[j]).addClass('reserved');
        }

        $('#input-zone').val($('#zones_names2_'+i).val());
        $('#input-price').val($('#zones_prices2_'+i).val());
        addZone();
        
      }
  }
});

$('[name=local_id]').on('click', function(){
        var e = $('[name=local_id]')[0];

        var index= e.options[e.selectedIndex].value;
        console.log(index);
        var algo = $('#row_' + index).val();
        //console.log("algo "+algo);
        var table = document.getElementById("table-zone");

        for(var i = table.rows.length - 1; i > 0; i--)
        {
            table.deleteRow(i);
        }

        if(algo !== undefined && algo >=1){
          //si el local tiene asientos y filas numeradas Do this 
          //console.log("index "+index);
          var rows = $('#row_'+index).val();
          var columns = $('#column_'+index).val();

          // setear maximo filas maxima col
          document.getElementById("input-column").max=columns;
          document.getElementById("input-row").max=rows;
          document.getElementById("input-colIni").max=columns;
          document.getElementById("input-rowIni").max=rows;

          
          $('#input-column').show();
          $('#input-row').show();
          $('#input-colIni').show();
          $('#input-rowIni').show();
          $('#label_col').show();
          $('#label_fil').show();
          $('#label_fini').show();
          $('#label_cini').show();
          $('#dist').show();
          $('#label_capacity').hide();
          $('#input-capacity').hide();

          document.getElementById('input-capacity').disabled=true;
        }else{
          //si el local no tiene asientos numerados Do this 
          //$('#seat-map').empty();

          document.getElementById('input-capacity').disabled=false;
          var tam= $('[id=invisible_id]').size();

          $('#input-column').hide();
          $('#input-row').hide();
          $('#input-colIni').hide();
          $('#input-rowIni').hide();
          $('#label_col').hide();
          $('#label_fil').hide();
          $('#label_fini').hide();
          $('#label_cini').hide();
          $('#dist').hide();
          $('#label_capacity').show();
          $('#input-capacity').show();
        }
      });

function addZone(){


    if($('#input-capacity').attr('disabled')){
    $('.selected').removeClass('selected').addClass('reserved');
    var col_min=100000000;
    var fil_min=100000000;
    var col_max=0;
    var fil_max=0;
    $('.reserved').each(function(index, element){
      var id = $(this).attr('id');
      var col = parseInt(id.split("_")[1]);
      var fil = parseInt(id.split("_")[0]);
      
      if(col<col_min) col_min = col;
      if(fil<fil_min) fil_min = fil;
      if(col>col_max) col_max = col;
      if(fil>fil_max) fil_max = fil;
    });
    $('#input-column').val(''+(col_max-col_min+1));
    $('#input-row').val(''+(fil_max-fil_min+1));
    $('#input-rowIni').val(''+fil_min);
    $('#input-colIni').val(''+col_min);
    }
    var new_capacity = document.getElementById('capacity-display').value;

    var zone = document.getElementById('input-zone').value;

    var price = document.getElementById('input-price').value;

    var capacity = document.getElementById('input-capacity').value;

    if(price<0) return;
    if( document.getElementById('input-capacity').disabled==false){
      if(capacity<0) return;
      if( new_capacity-capacity<0) return;
      if(zone.length==0 || price.length==0) return;
    }
    if( document.getElementById('input-capacity').disabled==true){
      var column= "";
      var row= "";
      var rowini= "";
      var colini= "";
      column= document.getElementById('input-column').value;
      row= document.getElementById('input-row').value ;
      rowini= document.getElementById('input-rowIni').value;
      colini= document.getElementById('input-colIni').value;
      //if(new_capacity-row*column<0) return;
      //if(column.length==0 || row.length==0 || rowini.length==0 || colini.length==0) return;
    }
    else if(capacity.length==0) return;
    var tableRef = document.getElementById('table-zone').getElementsByTagName('tbody')[0];

    // Insert a row in the table at the last row
    var newRow   = tableRef.insertRow(tableRef.rows.length);

    // Insert a cell in the row at index 0
    var newCell  = newRow.insertCell(0);
    var newCell2 = newRow.insertCell(1);
    var newCell3 = newRow.insertCell(2);

    var newCell6 = newRow.insertCell(3);
    var newCell7 = newRow.insertCell(4);
    var newCell8 = newRow.insertCell(5);
    var newCell9 = newRow.insertCell(6);

    var newCell5 = newRow.insertCell(7);


    var y1 = document.createElement("INPUT");
    //y1.setAttribute("type", "hidden");
    y1.setAttribute("value", column);
    y1.setAttribute("name", "zone_columns[]");
    y1.style.border = 'none';
    y1.style.background = 'transparent';
    y1.style.width='40px';
    y1.required = false;
    y1.setAttribute("readonly","readonly");

    var y2 = document.createElement("INPUT");
    //y2.setAttribute("type", "hidden");
    y2.setAttribute("value", row);
    y2.setAttribute("name", "zone_rows[]");
    y2.style.border = 'none';
    y2.style.background = 'transparent';
    y2.style.width='40px';
    y2.required = false;
    y2.setAttribute("readonly","readonly");

    var y3 = document.createElement("INPUT");
    //y3.setAttribute("type", "hidden");
    y3.setAttribute("value", colini);
    y3.setAttribute("name", "start_column[]");
    y3.style.border = 'none';
    y3.style.background = 'transparent';
    y3.style.width='40px';
    y3.required = false;
    y3.setAttribute("readonly","readonly");

    var y4 = document.createElement("INPUT");
    //y4.setAttribute("type", "hidden");
    y4.setAttribute("value", rowini);
    y4.setAttribute("name", "start_row[]");
    y4.style.border = 'none';
    y4.style.background = 'transparent';
    y4.style.width='40px';
    y4.required = false;   
    y4.setAttribute("readonly","readonly");

    if( document.getElementById('input-capacity').disabled==true){ 
    //  Add values when is a numerated local but dont show it
        y1.required=true;
        y2.required=true;
        y3.required=true;
        y4.required=true;
        capacity=row*column;       
       newCell6.appendChild(y1);
      newCell7.appendChild(y2);
      newCell8.appendChild(y3);
      newCell9.appendChild(y4);       
    }
    // Append values to cells
    var newText  = document.createTextNode(zone);
    var x = document.createElement("INPUT");
    x.setAttribute("type", "text");
    x.setAttribute("value", zone);
    x.setAttribute("name", "zone_names[]");
    x.style.border = 'none';
    x.style.background = 'transparent';
    x.required = true;
    x.setAttribute("readonly","readonly");

    var newText2 = document.createElement("INPUT");
    newText2.setAttribute("type", "text");
    newText2.setAttribute("value", capacity);
    newText2.setAttribute("name", "zone_capacity[]");
    newText2.style.border = 'none';
    newText2.style.background = 'transparent';
    newText2.style.width='40px';
    newText2.required = true;
    newText2.setAttribute("readonly","readonly");

    var textPrice = document.createElement("INPUT");
    textPrice.setAttribute("type", "text");
    textPrice.setAttribute("value", price);
    textPrice.setAttribute("name", "price[]");
    textPrice.style.border = 'none';
    textPrice.style.background = 'transparent';
    textPrice.style.width='80px';
    textPrice.required = true;
    textPrice.setAttribute("readonly","readonly");
    // buttons

    var newDelete = document.createElement('button');
    newDelete.className = "btn";
    newDelete.className += " btn-info glyphicon glyphicon-remove";
    if (newDelete.addEventListener) {  // all browsers except IE before version 9
      newDelete.addEventListener("click", function(){deleteZone(newDelete);}, false);
    } else {
      if (newDelete.attachEvent) {   // IE before version 9
        newDelete.attachEvent("click", function(){deleteZone(newDelete);});
      }
    }
    newCell.appendChild(x);
    newCell2.appendChild(newText2);
    newCell3.appendChild(textPrice);
    newCell5.appendChild(newDelete);



    document.getElementById('input-zone').value = '';
    document.getElementById('input-capacity').value = '';
    document.getElementById('input-price').value = '';
    // document.getElementById('input-column').value = '';
    // document.getElementById('input-row').value = '';
    // document.getElementById('input-colIni').value = '';
    // document.getElementById('input-rowIni').value = '';
    if( document.getElementById('input-capacity').disabled==true){
      var elementos = $('.reserved');
      var index_table = $('#table-zone').find('tr').length-2;
      $('.reserved').each(function(){
        $('#table-zone').append('<input type="hidden" name="seats_ids['+index_table+'][]" value="'+this.id+'" id="seats_id_'+index_table+'" >');
      });
      $('.selected').each(function(){
        $('#table-zone').append('<input type="hidden" name="seats_ids['+index_table+'][]" value="'+this.id+'" id="seats_id_'+index_table+'" >');
      });
      if($('.reserved').hasClass('available')) $('.reserved').removeClass('available');
      $('.reserved').removeClass('reserved').addClass('unavailable');
      $('.selected').removeClass('selected').addClass('unavailable');
      document.getElementById('input-column').value = '';
      document.getElementById('input-row').value = '';
      document.getElementById('input-colIni').value = '';
      document.getElementById('input-rowIni').value = '';
    }
    new_capacity = new_capacity - capacity;
    if( document.getElementById('input-capacity').disabled==false){
      document.getElementById('capacity-display').value = new_capacity;
      document.getElementById("input-capacity").max=new_capacity;
    }
  }


function getZoneSeatsIds(idZone){
  var map = new Array;
  console.log("idzone: "+idZone);
  $.ajax({
        url: config.routes[6].getZonesSeatsIds,
        type: 'get',
        async: false,
        data: 
        { 
            zone_id: idZone,
        },
        success: function( response ){
            if(response != "")
            {
              for(i=0; i<response.length;i++){
                map.push(response[i]);
              }
            }
            else
            {
              console.log('no respuesta');  
            }
        },
        error: function( response ){
            console.log(response);
        }
    });
  return map;
}
    

function getSeatsArray(idLocal){
  var map = new Array;
  $.ajax({
        url: config.routes[0].getSeatsArray,
        type: 'get',
        async: false,
        data: 
        { 
            local_id: idLocal,
        },
        success: function( response ){
            if(response != "")
            {
              for(i=0; i<response.length;i++){
                var texto ="";
                for(j=0;j<response[i].length;j++)
                  texto += response[i][j];
                map.push(texto);
              }
              //return map;
            }
            else
            {
              console.log('no respuesta');  
            }
        },
        error: function( response ){
            console.log(response);
        }
    });
  return map;
}