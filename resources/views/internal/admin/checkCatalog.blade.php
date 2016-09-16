@extends('layout.admin')

@section('style')

@stop

@section('title')
	Ideas para {{$risk->name}} 

@stop

@section('content')
        <!-- Contenido-->
        <div class="row">
          <div class="col-sm-8">
            {!!Form::open(array('url' => 'admin/risk/new','files'=>true,'id'=>'form','class'=>'form-horizontal'))!!}
               
                @foreach($check_list as $check)
                <div class="form-group">
                  <input class="col-sm-2" id="#{{$check->id}}" name="name[]" type="checkbox" value="{{$check->risk}}"> 
                  <div class="col-sm-10">
                  {{$check->question}}
               
                  </div>
                  <br>
                 </div>  
               @endforeach

              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                 <a href="admin/risk/{id}/subrisks"></a> <button type="submit" class="btn btn-info">Guardar</button>
                  <a href="{{url('admin/risk/'.$risk->id.'/subrisks')}}"><button type="button" class="btn btn-info">Cancelar</button></a>
                </div>
              </div>

            </form>
          </div>
        </div>

@stop

@section('javascript')
<script type="text/javascript">
  $("#isSub").isChecked()
</script>

@stop