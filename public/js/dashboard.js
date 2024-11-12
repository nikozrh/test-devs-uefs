const selectescola = document.getElementById('codescola');
const selecturma = document.getElementById('turmas');
const stepone = document.getElementById('bar-step-1');
const steptwo = document.getElementById('bar-step-2');
stepone.style.transition = 'width 1s ease-in-out';
steptwo.style.transition = 'width 1s ease-in-out';
stepone.style.width = '0%';
steptwo.style.width = '0%';



function validacampos() {

    stepone.style.width = '100%'
    steptwo.style.width = '100%';
    setTimeout(() => {
        stepone.style.width = '0%';
        steptwo.style.width = '0%';
        alert('Dados de postagem baixados para sua pasta de downloads!');
    }, "3000");

}


function buscarDados() {
    let url = "/getdata";
    $.ajax({
        url: url,
        type: 'POST',
        dataType: 'json',
        data: {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            "exec": 'buscar'
        },
        success: function (response) {
            console.log(response);
            steptwo.style.width = '100%';
        },
        error: function (data) {

            if (data.status === 422) {

                var errors = $.parseJSON(data.responseText);
                alert(errors);

            }
            return false;
        }
    })
}