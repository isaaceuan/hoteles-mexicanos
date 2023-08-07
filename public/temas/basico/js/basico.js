/**
 * Devuelve el número de días entre un rango de fechas
 *
 * @param date1 format yy/mm/dd
 * @param date2 format yy/mm/dd
 * @returns {number}
 */
function dateDiff(date1, date2) {
    return Math.abs(Math.floor((date1.getTime() - date2.getTime()) / (1000 * 3600 * 24)));
}

/**
 * Suma un número de días a una fecha y devuelve la fecha resultante
 * @param date format yy/mm/dd
 * @param days int
 * @returns {Date}
 */
function addDate(date, days) {
    var timestamp = date.getTime() + (days * (1000 * 3600 * 24));
    return new Date(timestamp);
}

function convertDateMysqltoDate(date) {
    let parts = date.split('-');
    return new Date(parseInt(parts[0]), parseInt(parts[1]) - 1, parseInt(parts[2]));
}

var cacheDatesInvalid = {},
    cacheDatesPromo = {},
    reqDates = null;


function setInvalidDates(calendar, dates) {
    for (var i = 0; i < dates.length; i++) {
        var invalid = dates[i];
        calendar._markup.find(
            '.mbsc-cal-day[data-full="' +
            invalid.getFullYear() + '-' +
            invalid.getMonth() + '-' +
            invalid.getDate() + '"]'
        ).addClass('mbsc-cal-day-closed');
    }
};

function setPromoDates(calendar, dates) {
    for (var i = 0; i < dates.length; i++) {
        var invalid = dates[i];
        calendar._markup.find(
            '.mbsc-cal-day[data-full="' +
            invalid.getFullYear() + '-' +
            invalid.getMonth() + '-' +
            invalid.getDate() + '"] .mbsc-cal-day-i'
        ).addClass('mbsc-cal-day-promo ');
    }
};


function loadInvalidDates(year, month, nights, inst) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    if (reqDates != null) reqDates.abort();
    reqDates = $.ajax({
            url: window.url_get_restricciones_calendario,
            method: "post",
            data: {
                anio: year,
                mes: month,
                noches: nights,
            },
            success: function (response) {
                // Convertir las fechas en objetos y almacenarlas en caché.
                for (var dateKey of response.paro_ventas) {
                    var dates = [];
                    for (var i = 0; i < response.paro_ventas.length; i++) {
                        dates.push(convertDateMysqltoDate(response.paro_ventas[i]));
                    }
                    cacheDatesInvalid[dateKey] = dates;
                    setInvalidDates(inst, dates);
                }
                for (var dateKeyPromo of response.promociones) {
                    var datesP = [];
                    for (var i = 0; i < response.promociones.length; i++) {
                        datesP.push(convertDateMysqltoDate(response.promociones[i]));
                    }
                    cacheDatesPromo[dateKeyPromo] = datesP;
                    setPromoDates(inst, datesP);
                }

            },
            error:
                function (jqXHR, textStatus, errorThrown) {
                    console.log(textStatus + " -> " + errorThrown);
                }
        }
    );

};


var today = new Date(),
    displayMonths = 1,
    dateFormat = "yy-mm-dd",
    maxStay = parseInt('60'),
    //maxDate = parseDate('2020-08-31'),
    maxNights = parseInt('60'),
    cacheDates = {},
    reqDates = null,
    msDay = 86400000;


fillDateBox = function (id, date, lang) {
    // Mostrar la fecha en su idioma.
    var settings = mobiscroll.i18n[lang],
        iso = mobiscroll.util.datetime.formatDate(dateFormat, date, settings),
        str = mobiscroll.util.datetime.formatDate('DD/dd/MM/yy/D/M', date, settings),
        parts = str.split('/');

    $(id).find(".dia").html(parts[0]);
    $(id).find(".dia_corto").html(parts[4]);
    $(id).find(".fecha").html(parts[1]);
    $(id).find(".mes").html(parts[2] + " " + parts[3]);
    $(id).find(".mes_corto").html(parts[5] + " " + parts[3]);

    str = mobiscroll.util.datetime.formatDate(dateFormat, date, settings);
    $("input." + $(id).data("display")).val(str);
    $("." + $(id).data("display") + ":not(input)").html(str);
    $("#" + $(id).data("input")).val(iso);
};

var fillNightBox = function (checkin, checkout) {
    var diff = checkout.getTime() - checkin.getTime(),
        nights = Math.floor(diff / msDay);
    $("#nights").html(nights);
    $("[name=nights]").val(nights);
};

function setLabelPromo(calendar) {
    calendar._markup.find(
        '.mbsc-cal-c'
    ).addClass('mbsc-cal-tag-promo');
}

var parseDate = function (strDate) {
    var parts = strDate.match(/(\d+)/g);
    return new Date(parseInt(parts[0]), parseInt(parts[1]) - 1, parseInt(parts[2]), 0, 0, 0);
};


