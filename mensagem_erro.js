function erro_mensagem(mensagem)
{
    Swal.fire({
            title: 'ERRO',
            text: mensagem,
            icon: 'error',
            confirmButtonText: 'OK'
        });
}

function sucesso_mensagem(mensagem)
{
    Swal.fire({
            title: 'Bombou',
            text: mensagem,
            icon: 'success',
            confirmButtonText: 'OK'
        });
}

function deletar_mensagem()
{
   const swalWithBootstrapButtons = Swal.mixin({
  customClass: {
    confirmButton: "btn btn-success",
    cancelButton: "btn btn-danger"
  },
  buttonsStyling: false
});
swalWithBootstrapButtons.fire({
  title: "Are you sure?",
  text: "You won't be able to revert this!",
  icon: "warning",
  showCancelButton: true,
  confirmButtonText: "SIm",
  cancelButtonText: "No, cancel!",
  reverseButtons: true
}).then((result) => {
  if (result.isConfirmed) swalWithBootstrapButtons.fire({
    title: "Deleted!",
    text: "Your file has been deleted.",
    icon: "success"
  });
  else if (result.dismiss === Swal.DismissReason.cancel)

  swalWithBootstrapButtons.fire({
    title: "Cancelled",
    text: "Your imaginary file is safe :)",
    icon: "error"
  });
});
}
