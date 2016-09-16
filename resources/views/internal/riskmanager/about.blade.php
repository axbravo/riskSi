@extends('layout.admin')

@section('style')

@stop

@section('title')
    Acerca de nosotros
@stop

@section('content')
        <div class="row">
          <div class="col-sm-8">
            {!!Form::open(['route'=>'config.about.update','files'=>true,'id'=>'form', 'class'=>'form-horizontal'])!!}
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Imagen About Us</label>
                <div class="col-sm-10">
                    <input type="file" name="image" class="form-control" id="inputEmail3" placeholder="">
                    {{$about->image}}
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Descripción</label>
                <div class="col-sm-10">
                  {!!Form::textarea('description', $about->description ,['class'=>'form-control','size' => '6x6','required'])!!}
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Misión</label>
                <div class="col-sm-10">
                  {!!Form::textarea('mision', $about->mision ,['class'=>'form-control','size' => '6x6','required'])!!}
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Visión</label>
                <div class="col-sm-10">
                  {!!Form::textarea('vision', $about->vision ,['class'=>'form-control','size' => '6x6','required'])!!}
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Historia</label>
                <div class="col-sm-10">
                  {!!Form::textarea('history', $about->history ,['class'=>'form-control','size' => '6x6','required'])!!}
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">URL Youtube</label>
                <div class="col-sm-10">
                  {!!Form::text('youtube_url', $about->youtube_url ,['class'=>'form-control','id'=>'inputEmail3','required'])!!}
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <a class="btn btn-info" href="" title="submit" data-toggle="modal" data-target="#submitModal" >Guardar</a>
                  <a href="{{route('admin.home')}}"><button type="button" class="btn btn-info">Cancelar</button></a>
                </div>
              </div>
              <!-- MODAL -->
              <div class="modal fade"  id="submitModal">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title">¿Estas seguro que desea cambiar la informacion?</h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info" data-dismiss="modal">No</button>
                        <button id="yes" type="submit" class="btn btn-info">Si</button>
                    </div>
                  </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
              </div><!-- /.modal -->
            {!!Form::close()!!}
          </div>
        </div>
@stop

@section('javascript')
<script type="text/javascript">
  $('#yes').click(function(){
    $('#submitModal').modal('hide');  
  });
  
</script>
@stop