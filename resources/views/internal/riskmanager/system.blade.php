@extends('layout.admin')

@section('style')

@stop

@section('title')
  Inf. Sistema
@stop

@section('content')
  <div class="row">
  <div class="col-sm-8">
    {!!Form::open(['class'=>'form-horizontal','id'=>'form','files'=>true])!!}
    
      <div class="form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">Razon Social</label>
        <div class="col-sm-10">
        {!!Form::text('business_name', $system->business_name,['class'=>'form-control', 'required'])!!}
        </div>
      </div>
      <div class="form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">RUC:</label>
        <div class="col-sm-10">
            {!!Form::number('ruc', $system->ruc,['class'=>'form-control', 'required'])!!}
        </div>
      </div>
      <div class="form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">Dirección</label>
        <div class="col-sm-10">
            {!!Form::text('address', $system->address,['class'=>'form-control', 'required'])!!}
        </div>
      </div>
      <div class="form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">Logo</label>
        <div class="col-sm-10">
          <input type="file" name="logo" class="form-control" id="inputEmail3" placeholder="">
          {{$system->logo}}
        </div>
      </div>
      <div class="form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">Favicon</label>
        <div class="col-sm-10">
          <input type="file" name="favicon" class="form-control" id="inputEmail3" placeholder="">
          {{$system->favicon}}
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

@stop