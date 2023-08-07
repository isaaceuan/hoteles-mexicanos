<div class="row">
    <div class="col-md-12 pr-0">
        <div class="mb-4 card rounded-0 border-0 shadow-sm sidebar ">
            <div class="card-body py-2">
                <form id="frmCheckAvailability"
                      action="{{ route('app.disponibilidad',app()->getLocale(), false)}}"
                      method="get">
                    <div class="container p-0">
                        <div class="content-calendar row align-items-end">
                            <div class="col-md-2 pr-1">
                                <label>@lang('calendar.llegada')</label>
                                <div class="input-group">
                                    <input type="text" class="form-control cursor-pointer mbsc-comp" id="startHome"
                                           readonly
                                           value="{{AppBusqueda::recuperar()->getLlegada()}}"
                                           disabled
                                           name="checkin">
                                    <div class="input-group-append">
                                        <button class="btn btn-default form-control checkin" type="button">
                                            <span class="far fa-calendar-alt"></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 px-1">
                                <label>@lang('calendar.salida')</label>
                                <div class="input-group">
                                    <input type="text" class="form-control cursor-pointer mbsc-comp" id="endHome"
                                           readonly
                                           value="{{AppBusqueda::recuperar()->getSalida()}}"
                                           disabled
                                           name="checkout">
                                    <div class="input-group-append">
                                        <button class="btn btn-default form-control checkout" type="button">
                                            <span class="far fa-calendar-alt"></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1 px-1">
                                <label>@lang('calendar.noches')</label>
                                <select id="nights" name="nights" class="form-control cursor-pointer">
                                    @for ($i = 1; $i <= $propiedad->estancia_maxima; $i++)
                                        <option value="{{$i}}" selected="">{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-1 px-1">
                                <label>@lang('calendar.adultos')</label>
                                <select id="adults" name="adults" class="form-control cursor-pointer">
                                    @for ($i = 1; $i <= $propiedad->max_adultos; $i++)
                                        <option value="{{$i}}" selected="">{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-1 px-1 {{ ($propiedad->tiene_ninos_1) ? 'd-block' : 'd-none'  }}">
                                <label>@lang('calendar.nino') ({{$propiedad->ninos_min_1}}-{{$propiedad->ninos_max_1}}
                                    )</label>
                                <select id="children1" name="children1" class="form-control cursor-pointer">
                                    @for ($i = 0; $i <= ($propiedad->max_adultos)-1; $i++)
                                        <option value="{{$i}}" selected="">{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-1 px-1 {{ ($propiedad->tiene_ninos_2) ? 'd-block' : 'd-none'  }}">
                                <label>@lang('calendar.nino') ({{$propiedad->ninos_min_2}}-{{$propiedad->ninos_max_2}}
                                    )</label>
                                <select id="children2" name="children2" class="form-control cursor-pointer">
                                    @for ($i = 0; $i <= ($propiedad->max_adultos)-1; $i++)
                                        <option value="{{$i}}" selected="">{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-1 px-1 {{ ($propiedad->tiene_ninos_3) ? 'd-block' : 'd-none'  }}">
                                <label>@lang('calendar.nino') ({{$propiedad->ninos_min_3}}-{{$propiedad->ninos_max_3}}
                                    )</label>
                                <select id="children3" name="children3" class="form-control cursor-pointer">
                                    @for ($i = 0; $i <= ($propiedad->max_adultos)-1; $i++)
                                        <option value="{{$i}}" selected="">{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-primary btn-block my-2"
                                        type="submit">@lang('calendar.buscar')</button>
                            </div>
                            <div class="col-md-12 Cpromocion">
                                <a class="cursor-pointer">
                                    @lang('calendar.promocion') <span class="fa fa-tag"></span>
                                </a>
                            </div>
                            <div class="col-md-4 inptCpromocion" style="display: none;">
                                <div class="input-group mb-3">
                                    <input id="promocode" name="promocode" class="form-control"
                                           value="{{AppBusqueda::recuperarBusqueda()->getPromoCode()}}"
                                           autocomplete="off">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="button">
                                            <a class="cursor">
                                                <i class="fa fa-times inline"></i>
                                            </a>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="demo"></div>
</div>
