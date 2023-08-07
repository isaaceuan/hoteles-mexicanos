/**
 * https://www.virtuosoft.eu/code/bootstrap-touchspin/
 */

$(".addon-quantity").each(function () {
    $(this).TouchSpin({
        verticalbuttons: true,
        min: parseFloat($(this).data("min")),
        max: parseFloat($(this).data("max")),
        step: parseFloat($(this).data("step")),
        stepinterval: 200,
        buttondown_class: 'btn btn-default',
        buttonup_class: 'btn btn-default'
    });
});