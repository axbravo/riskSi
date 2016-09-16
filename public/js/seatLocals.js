$('document').ready(function () {

  $('#column').on('change', function() { 
    var filas = $('#row').val();

    if(filas.trim()){
      $('#parent').empty();
      $('#parent').append('<div id="seat-map"></div>');
      generarSeats($(this).val(),filas);
      $('#multiple-mode-on').show();
      $('#single-mode-on').show();
    }
  });
  $('#multiple-mode-on').on('click', function(){
    //alert("boolean val: "+$('#multiple-mode-on').is(":checked"));
    if($('.reserved').length > 0){
      $('#multiple-mode-on').prop('checked', false);
      $('#single-mode-on').prop('checked', true);
      alert("tiene que guardar sus cambios en la distribución antes de pasar a otro modo!");
    }
  });
  $('#single-mode-on').on('click', function(){
    //alert("boolean val: "+$('#multiple-mode-on').is(":checked"));
    if($('.reserved').length > 0){
      $('#multiple-mode-on').prop('checked', true);
      $('#single-mode-on').prop('checked', false);
      alert("tiene que guardar sus cambios en la distribución antes de pasar a otro modo!");
    }
  });
  $('#form').submit(function(){
    var columnas = $('#column').val();
    var filas = $('#row').val();
    for(i = 1; i<=columnas; i++)
      for(j=1; j<=filas; j++){
        var estado = '0';
        var id = ''+j+'_'+i;
        if($('#'+id).hasClass('unavailable')) estado = '1';
        if($('#submitting_'+id).length)$('#submitting_'+id).remove();
        $('#distribution_id').append('<input type="hidden" id="submitting_' +id + '" name="seats[]" value="'+estado+'" >');
      }
    //alert("agrego? "+$('#submitting_5_4').val());
  });
});

function commitSeats(){
  if($('.reserved').hasClass('available')) 
    $('.reserved').removeClass('available');
  $('.reserved').removeClass('reserved').addClass('unavailable');
  $('.selected').removeClass('selected').addClass('unavailable');
}

function resetSeats(){
  $('.reserved').removeClass('reserved').addClass('available');
  $('.selected').removeClass('selected').addClass('available');
  $('.unavailable').removeClass('unavailable').addClass('available');
}

function generarSeats(columnas, filas){
  var arreglo = new Array();

          for(i=0; i<filas;i++){
            var texto = 'a';
            for(j=1; j<columnas; j++){
              texto += 'a';
            }
            //console.log(texto);
            arreglo.push(texto);
          }
  var sc = $('#seat-map').seatCharts({
            map: arreglo,
          naming : {
            top : false,
            getLabel : function (character, row, column) {
              return column;
            }
          },
          click : function(){
            if($('#multiple-mode-on').is(":checked")){
                  if(this.node().hasClass('unavailable')){
                    alert("No se puede seleccionar un asiento no disponible!");
                    this.status('unavailable');
                    return 'unavailable';
                  }

                  if(this.status()=='available' && this.status()!='selected'){
                      var num_cant = $('.seatCharts-cell.selected').length;
                      var unavailable = false;
                      if(num_cant<2){
                        if(num_cant == 1){
                          var id_selec1 = $('.seatCharts-cell.selected').first().attr('id');
                          var id_selec2 = this.node().attr('id');
                          var res = id_selec1.split("_");
                          var fil_ini = parseInt(res[0]);
                          var col_ini = parseInt(res[1]);
                          var res = id_selec2.split("_");
                          var fil_ini2 = parseInt(res[0]);
                          var col_ini2 = parseInt(res[1]);

                          var cant_col = (Math.abs(col_ini - col_ini2)+1);
                          var cant_fil = (Math.abs(fil_ini - fil_ini2)+1);
                          if(col_ini > col_ini2)
                            col_ini = col_ini2;
                          if(fil_ini > fil_ini2)
                            fil_ini = fil_ini2;
                          unavailable = false;
                          for(i = col_ini; i<col_ini+cant_col;i++){
                            for(j=fil_ini; j<fil_ini + cant_fil; j++){
                              var id = ''+j+'_'+i;
                              if(id!= id_selec2 && id!= id_selec1){
                                  if($('#'+id).hasClass('unavailable')){
                                    $('.reserved').removeClass('reserved').addClass('available');
                                    $('.selected').removeClass('selected').addClass('available');
                                    alert('No se puede seleccionar estos asientos porque ya están ocupados por otra zona');
                                    unavailable = true;
                                    break;
                                  }
                                  $('#'+id).addClass('reserved'); //<---- este es el que funciona
                    
                              }
                            }
                            if(unavailable) break;
                          }
                        }
                        if(!unavailable){
                          this.status('selected');
                          return 'selected';
                        } else {
                          this.status('available');
                          return 'available';
                        }
                      } else{
                        alert('Ya hay dos asientos seleccionados');
                        this.status('available');
                        return 'available';
                      }
                    }
                    if(this.status()=='selected'){
                      $('.seatCharts-cell.reserved').removeClass("reserved").addClass("available");
                      this.status('available');
                      return 'available';
                    }
                  }
            if($('#single-mode-on').is(":checked")){
              if(this.node().hasClass('unavailable')){
                    alert("No se puede seleccionar un asiento no disponible!");
                    this.status('unavailable');
                    return 'unavailable';
                  }

                  if(this.status()=='available'){
                    this.status('reserved');
                    return 'selected';
                  }
              if(this.status()=='selected'){
                      $('.seatCharts-cell.reserved').removeClass("reserved").addClass("available");
                      this.status('available');
                      return 'available';
                    }
            }
          },
          focus  : function() {
              if (!this.node().hasClass('unavailable')) {
                  return 'focused';
              
              } else  {
                  return this.style();
              }
          },
          legend : { //Definition legend
            node : $('#legend'),
            items : [
              [ 'a', 'available',   'Libre' ],
              [ 'b', 'unavailable', 'Ocupado'],
              [ 'c', 'reserved', 'Reservado']
            ]
          }
        });
}