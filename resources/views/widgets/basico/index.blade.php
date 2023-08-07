<div id="content{{$id}}">
    <a class="ez-wdt-btn ez-wdt-d-block ez-wdt-d-md-none" id="booknow">@lang('calendar.disponibilidad_tarifas')&nbsp;<i
            class="fa slideInDown animated fa-chevron-down"></i></a>
    <div id="child{{$id}}">
        <form id="frmCheckAvailability"
              action="{{ route('app.disponibilidad',app()->getLocale(), true)}}"
              target="_blank"
              class="ez-wdt-d-none ez-wdt-d-md-block"
              method="get">
            <div class="ez-wdt-container">
                <div class="content-calendar ez-wdt-row ez-wdt-align-items-end">
                    <div class="ez-wdt-col-12 ez-wdt-col-md-2 field">
                        <label>@lang('calendar.llegada')</label>
                        <div class="ez-wdt-input-group">
                            <input type="text" class="ez-wdt-form-control ez-wdt-cursor-pointer mbsc-comp" id="startHome"
                                   readonly
                                   name="checkin">
                            <div class="ez-wdt-input-group-append">
                                <button class="ez-wdt-icon-calendar checkin" type="button">
                                    <span class="fa fa-calendar"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="ez-wdt-col-12 ez-wdt-col-md-2 ez-wdt-px-md-1 field">
                        <label>@lang('calendar.salida')</label>
                        <div class="ez-wdt-input-group">
                            <input type="text" class="ez-wdt-form-control ez-wdt-cursor-pointer mbsc-comp" id="endHome"
                                   readonly
                                   name="checkout">
                            <div class="ez-wdt-input-group-append">
                                <button class="ez-wdt-icon-calendar checkout" type="button">
                                    <span class="fa fa-calendar"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="ez-wdt-col-12 ez-wdt-col-md-1 ez-wdt-px-md-1 field">
                        <label>@lang('calendar.noches')</label>
                        <select id="nights" name="nights" class="ez-wdt-form-control ez-wdt-cursor-pointer">
                            @for ($i = 1; $i <= $propiedad->estancia_maxima; $i++)
                                <option value="{{$i}}" selected="">{{$i}}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="ez-wdt-col-12 ez-wdt-col-md-1 ez-wdt-px-md-1 field">
                        <label>@lang('calendar.adultos')</label>
                        <select id="adults" name="adults" class="ez-wdt-form-control ez-wdt-cursor-pointer">
                            @for ($i = 1; $i <= $propiedad->max_adultos; $i++)
                                <option value="{{$i}}" selected="">{{$i}}</option>
                            @endfor
                        </select>
                    </div>
                    <div
                        class="ez-wdt-col-12 ez-wdt-col-md-1 ez-wdt-px-md-1 field {{ ($propiedad->tiene_ninos_1) ? 'ez-wdt-d-block' : 'ez-wdt-d-none'  }}">
                        <label>@lang('calendar.nino') ({{$propiedad->ninos_min_1}}
                            -{{$propiedad->ninos_max_1}}
                            )</label>
                        <select id="children1" name="children1" class="ez-wdt-form-control ez-wdt-cursor-pointer">
                            @for ($i = 0; $i <= ($propiedad->max_adultos)-1; $i++)
                                <option value="{{$i}}" selected="">{{$i}}</option>
                            @endfor
                        </select>
                    </div>
                    <div
                        class="ez-wdt-col-12 ez-wdt-col-md-1 ez-wdt-px-md-1 field {{ ($propiedad->tiene_ninos_2) ? 'ez-wdt-d-block' : 'ez-wdt-d-none'  }}">
                        <label>@lang('calendar.nino') ({{$propiedad->ninos_min_2}}
                            -{{$propiedad->ninos_max_2}}
                            )</label>
                        <select id="children2" name="children2" class="ez-wdt-form-control ez-wdt-cursor-pointer">
                            @for ($i = 0; $i <= ($propiedad->max_adultos)-1; $i++)
                                <option value="{{$i}}" selected="">{{$i}}</option>
                            @endfor
                        </select>
                    </div>
                    <div
                        class="ez-wdt-col-12 ez-wdt-col-md-1 ez-wdt-px-md-1 field {{ ($propiedad->tiene_ninos_3) ? 'ez-wdt-d-block' : 'ez-wdt-d-none'  }}">
                        <label>@lang('calendar.nino') ({{$propiedad->ninos_min_3}}
                            -{{$propiedad->ninos_max_3}}
                            )</label>
                        <select id="children3" name="children3" class="ez-wdt-form-control ez-wdt-cursor-pointer">
                            @for ($i = 0; $i <= ($propiedad->max_adultos)-1; $i++)
                                <option value="{{$i}}" selected="">{{$i}}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="ez-wdt-col-12 ez-wdt-col-md-1 ez-wdt-d-none ez-wdt-d-md-block ez-wdt-pr-1">
                        <button id="btnBuscar" class="ez-wdt-btn btn-primary ez-wdt-btn-block ez-wdt-cursor-pointer"
                                type="submit">@lang('calendar.buscar')</button>
                    </div>
                    <div class="ez-wdt-col-12 ez-wdt-col-md-12 Cpromocion">
                        <a class="ez-wdt-cursor-pointer">
                            @lang('calendar.promocion') <span class="fa fa-tag"></span>
                        </a>
                    </div>
                    <div class="ez-wdt-col-12 ez-wdt-col-md-4 inptCpromocion" style="display: none;">
                        <div class="ez-wdt-input-group">
                            <input id="promocode" name="promocode" class="ez-wdt-form-control"
                                   value="{{AppBusqueda::recuperar()->getPromoCode()}}"
                                   autocomplete="off">
                            <div class="ez-wdt-input-group-append">
                                <button class="ez-wdt-btn btn-primary" type="button">
                                    <a class="ez-wdt-cursor-pointer">
                                        <i class="fa fa-times inline"></i>
                                    </a>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="ez-wdt-col-12 ez-wdt-col-md-1 ez-wdt-d-block ez-wdt-d-md-none">
                        <button id="btnBuscar" class="ez-wdt-btn btn-primary ez-wdt-btn-block"
                                type="submit">@lang('calendar.buscar')</button>
                    </div>
                </div>
            </div>
        </form>
        <div id="demo{{$id}}"></div>
    </div>
</div>

