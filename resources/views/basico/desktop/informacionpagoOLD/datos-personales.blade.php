<div id="datos-personales">
    <div class="row  bg-light p-3 border-bottom mb-3">
        <div class="col-12 text-center">
            <h3>@lang('informacion.datos_personales')</h3>
        </div>
    </div>
    <div id="validation-errors" class="alert alert-danger d-none"></div>
    @if($propiedadMotor->campo_titulo != 'apagado')
        <div class="row">
            <div class="col-6">
                <div class="form-group row">
                    <label for="titulo" class="col-sm-4 col-form-label">
                                                <span>@if($propiedadMotor->campo_titulo == 'requerido')
                                                        *@endif</span>
                        @lang('informacion.titulo_personal')
                    </label>
                    <div class="col-sm-8">
                        <select
                            class="selectpicker form-control @if($errors->has('titulo')){{'is-invalid'}}@endif"
                            title="---" id="titulo" name="titular[titulo]"
                            @if($propiedadMotor->campo_titulo == 'requerido') required @endif>
                            {{--<option value=""></option>--}}
                            @foreach($titulos as $item)
                                <option
                                    value="{{$item->titulo}}" {{ old('titulo') == $item->titulo ? 'selected' : '' }}>{{$item->descripcion}}</option>
                            @endforeach
                        </select>
                        @if($propiedadMotor->campo_titulo == 'requerido' && $errors->has('titulo'))
                            <small class="invalid-feedback">{{$errors->first('titulo')}}</small>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="row mb-3">
        <div class="col-6 float-left">
            <div class="form-group row">
                <label for="nombres"
                       class="col-sm-4 col-form-label">*@lang('informacion.nombre')</label>
                <div class="col-sm-8">
                    <input type="text"
                           class="form-control @if($errors->has('nombres')){{'border-danger'}}@endif"
                           id="nombres" maxlength="150" required autocomplete="off"
                           name="titular[nombres]"
                           value="{{ old('nombres') }}">
                    @if($errors->has('nombres'))
                        <small class="invalid-feedback">{{$errors->first('nombres')}}</small>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-6 float-left">
            <div class="form-group row">
                <label for="apellidos"
                       class="col-sm-4 col-form-label">*@lang('informacion.apellido')</label>
                <div class="col-sm-8">
                    <input type="text"
                           class="form-control @if($errors->has('apellidos')){{'border-danger'}}@endif"
                           id="apellidos" maxlength="150" required autocomplete="off"
                           name="titular[apellidos]" value="{{ old('apellidos') }}">
                    @if($errors->has('apellidos'))
                        <small class="invalid-feedback">{{$errors->first('apellidos')}}</small>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-6 float-left">
            <div class="form-group row">
                <label for="correo"
                       class="col-sm-4 col-form-label">*@lang('informacion.correo')</label>
                <div class="col-sm-8">
                    <input type="email"
                           class="form-control @if($errors->has('correo')){{'border-danger'}}@endif"
                           id="correo" maxlength="85" required autocomplete="off" name="titular[correo]"
                           value="{{ old('correo') }}">
                    @if($errors->has('correo'))
                        <small class="invalid-feedback">{{$errors->first('correo')}}</small>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-6 float-left">
            <div class="form-group row">
                <label for="telefono"
                       class="col-sm-4 col-form-label">*@lang('informacion.telefono_movil')</label>
                <div class="col-sm-8">
                    <input type="text"
                           class="form-control @if($errors->has('telefono')){{'border-danger'}}@endif"
                           id="telefono" minlength="10" maxlength="20" required autocomplete="off"
                           name="titular[telefono]" value="{{ old('telefono') }}">
                    @if($errors->has('telefono'))
                        <small
                            class="invalid-feedback">{{$errors->first('telefono')}}</small>
                    @endif
                </div>
            </div>
        </div>
        @if($propiedadMotor->campo_telefono_otro != 'apagado')
            <div class="col-6 float-left">
                <div class="form-group row">
                    <label for="telefono_otro" class="col-sm-4 col-form-label">
                                                <span>@if($propiedadMotor->campo_telefono_otro == 'requerido')
                                                        *@endif</span>@lang('informacion.otro_telefono')</label>
                    <div class="col-sm-8">
                        <input type="text"
                               class="form-control @if($errors->has('telefono_otro')){{'border-danger'}}@endif"
                               id="telefono_otro" maxlength="20" autocomplete="off"
                               minlength="10"
                               name="titular[telefono_otro]"
                               @if($propiedadMotor->campo_telefono_otro == 'requerido') required
                               @endif value="{{ old('telefono_otro') }}">
                        @if($errors->has('telefono_otro'))
                            <small
                                class="invalid-feedback">{{$errors->first('telefono_otro')}}</small>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>
    <hr>
    <div class="row">
        @if($propiedadMotor->campo_direccion != 'apagado')
            <div class="col-12 float-left">
                <div class="form-group row">
                    <label for="direccion" class="col-sm-2 col-form-label">
                                                <span>@if($propiedadMotor->campo_direccion == 'requerido')
                                                        *@endif</span>@lang('informacion.direccion')
                    </label>
                    <div class="col-sm-10">
                        <input type="text"
                               class="form-control @if($errors->has('direccion')){{'border-danger'}}@endif"
                               id="direccion" maxlength="190" autocomplete="off"
                               name="titular[direccion]"
                               @if($propiedadMotor->campo_direccion == 'requerido') required
                               @endif value="{{ old('direccion') }}">
                        @if($errors->has('direccion'))
                            <small
                                class="invalid-feedback">{{$errors->first('direccion')}}</small>
                        @endif
                    </div>
                </div>
            </div>
        @endif
        @if($propiedadMotor->campo_ciudad != 'apagado')
            <div class="col-6 float-left">
                <div class="form-group row">
                    <label for="ciudad" class="col-sm-4 col-form-label">
                                                <span>@if($propiedadMotor->campo_ciudad == 'requerido')
                                                        *@endif</span>@lang('informacion.ciudad')
                    </label>
                    <div class="col-sm-8">
                        <input type="text"
                               class="form-control @if($errors->has('ciudad')){{'border-danger'}}@endif"
                               id="ciudad" maxlength="20" autocomplete="off" name="titular[ciudad]"
                               @if($propiedadMotor->campo_ciudad == 'requerido') required
                               @endif value="{{ old('ciudad') }}">
                        @if($errors->has('ciudad'))
                            <small class="invalid-feedback">{{$errors->first('ciudad')}}</small>
                        @endif
                    </div>
                </div>
            </div>
        @endif
        @if($propiedadMotor->campo_estado != 'apagado')
            <div class="col-6 float-left">
                <div class="form-group row">
                    <label for="estado" class="col-sm-4 col-form-label">
                                                <span>@if($propiedadMotor->campo_estado == 'requerido')
                                                        *@endif</span>@lang('informacion.estado')
                    </label>
                    <div class="col-sm-8">
                        <input type="text"
                               class="form-control @if($errors->has('estado')){{'border-danger'}}@endif"
                               id="estado" maxlength="25" autocomplete="off" name="titular[estado]"
                               @if($propiedadMotor->campo_estado == 'requerido') required
                               @endif value="{{ old('estado') }}">
                        @if($errors->has('estado'))
                            <small class="invalid-feedback">{{$errors->first('estado')}}</small>
                        @endif
                    </div>
                </div>
            </div>
        @endif
        @if($propiedadMotor->campo_pais != 'apagado')
            <div class="col-6 float-left">
                <div class="form-group row">
                    <label for="pais" class="col-sm-4 col-form-label">
                                                <span>@if($propiedadMotor->campo_pais == 'requerido')
                                                        *@endif</span>@lang('informacion.pais')
                    </label>
                    <div class="col-sm-8">
                        <select
                            class="selectpicker form-control @if($errors->has('pais')){{'border-danger'}}@endif"
                            data-live-search="true"
                            data-live-search-normalize="true"
                            title="---" id="pais" name="titular[pais]"
                            @if($propiedadMotor->campo_pais == 'requerido') required @endif>
                            @foreach($paises as $pais)
                                <option
                                    value="{{$pais->id}}" {{ old('pais') == $pais->id ? 'selected' : '' }}>{{$pais->nombre}}
                            @endforeach
                        </select>
                        @if($errors->has('pais'))
                            <small class="invalid-feedback">{{$errors->first('pais')}}</small>
                        @endif
                    </div>
                </div>
            </div>
        @endif
        @if($propiedadMotor->campo_cp != 'apagado')
            <div class="col-6 float-left">
                <div class="form-group row">
                    <label for="codigo_postal" class="col-sm-4 col-form-label">
                                                <span>@if($propiedadMotor->campo_cp == 'requerido')
                                                        *@endif</span>@lang('informacion.cp')
                    </label>
                    <div class="col-sm-8">
                        <input type="text"
                               class="form-control @if($errors->has('codigo_postal')){{'border-danger'}}@endif"
                               id="codigo_postal" maxlength="25" autocomplete="off" name="titular[codigo_postal]"
                               @if($propiedadMotor->campo_cp == 'requerido') required
                               @endif value="{{ old('codigo_postal') }}">
                        @if($errors->has('codigo_postal'))
                            <small class="invalid-feedback">{{$errors->first('codigo_postal')}}</small>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>
    @if($propiedadMotor->campo_direccion != 'apagado' ||
                                   $propiedadMotor->campo_ciudad != 'apagado' ||
                                   $propiedadMotor->campo_estado != 'apagado' ||
                                   $propiedadMotor->campo_pais != 'apagado' ||
                                   $propiedadMotor->campo_cp != 'apagado')
        <hr>
    @endif
    <div class="row">
        <div class="col-12 float-left">
            <div class="form-group row">
                <label for="comentarios" class="col-sm-2 col-form-label">
                    @lang('informacion.comentarios')
                </label>
                <div class="col-sm-10">
                                        <textarea
                                            class="form-control"
                                            rows="7"
                                            id="comentarios" autocomplete="off"
                                            name="titular[comentarios]"
                                            value="{{ old('comentarios') }}"></textarea>
                </div>
            </div>
        </div>
    </div>
</div>
