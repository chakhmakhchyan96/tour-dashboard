
$(document).ready(function ()
{
    $('.select2-hotel').select2({
        ajax: {
            url: '/ajax/hotels',
            processResults: function (data) {


                return {
                    results: data.hotels
                };
            },
        },
    }).on('select2:select', function (e) {
        var id = e.params.data.id;
        $.ajax({
            type: 'GET',
            url: '/ajax/room-types',
            contentType: "application/json",
            data: {
                id: id
            },
            success: function (data) {

                var select = $('#roomTypeSelect');
                var error  = $('#roomTypeError');
                if(data.types.length >0 ) {
                    error.text('')
                    select.removeAttr('disabled')
                    for (i in data.types) {
                        select.append("<option value='" + data.types[i].id + "'>" + data.types[i].details[0].title + "</option>")
                    }
                    return;
                }
                select.text('')
                select.attr('disabled',true)
                error.text("This hotel don't have any room types ")


            }
        });
    });

    $('.select2-tour').select2({
        ajax: {
            url: '/ajax/tours',
            processResults: function (data) {

                return {
                    results: data.tours
                };
            },


        },
    })


    $('.select2-users-by-email').select2({
        ajax: {
            url: '/ajax/users-by-email',
            processResults: function (data) {

                if (data.users.length <= 0) {

                    $('#names').css('display', 'block')

                } else {

                    $('#names').css('display', 'none')

                }
                if($('.js-example-basic-email').val()!== null && $('.js-example-basic-email').val()>0){
                    $('#names').css('display', 'none');
                    clearErrorsUser();
                }
                return {

                    results: data.users
                };
            },

        },
    });


    $('.phone_arm').mask('(000) 000-000');


});

function getCities(id) {
    $.ajax({
        type: 'GET',
        url: '/ajax/cities/region/'+id,
        contentType: "application/json",

        success: function (data) {

            let select = $('#citySelect');
            let error = $('#cityError');

            if(data.cities.length > 0) {
                select.removeAttr('disabled')
                select.text('')

                for(var i in data.cities) {
                    select.append("<option value="+data.cities[i].id+">"+data.cities[i].detail[0].title+"</option>")
                }
                error.text("");

                return;
            }

            error.text("We can't find any cities for this region");
            select.attr('disabled',true)
            select.text('')
        },error: function (error) {

        }
    });
}

