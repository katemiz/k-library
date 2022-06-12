function swalConfirm(type, assetId, id) {
  let msg, cbutton, title

  switch (type) {
    case 'asset':
      msg = "This action is irreversible. You won't be able to revert this!"
      cbutton = 'Delete Asset'
      title = 'Delete Asset and Attachments?'
      break

    case 'image':
      msg = "You won't be able to revert this!"
      cbutton = 'Delete'
      title = 'Delete Image?'
      break

    case 'audio':
      msg = "You won't be able to revert this!"
      cbutton = 'Delete'
      title = 'Delete Audio?'
      break

    case 'video':
      msg = "You won't be able to revert this!"
      cbutton = 'Delete'
      title = 'Delete Video?'
      break

    case 'document':
      msg = "You won't be able to revert this!"
      cbutton = 'Delete'
      title = 'Delete Doc?'
      break

    case 'dosya':
      action = 'deleteDosya'
      msg = "You won't be able to revert this!"
      cbutton = 'Delete'
      title = 'Delete File?'
      break

    default:
      break
  }

  Swal.fire({
    title: title,
    text: msg,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: cbutton,
  }).then((result) => {
    if (result.isConfirmed) {
      window.livewire.emit('delete', type, assetId, id)
    } else {
      return false
    }
  })
}
