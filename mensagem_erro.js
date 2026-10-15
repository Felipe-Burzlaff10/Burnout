function erro_mensagem(mensagem)
{
    Swal.fire({
            title: 'ERRO',
            text: mensagem,
            icon: 'error',
            confirmButtonText: 'OK'
        });
}
