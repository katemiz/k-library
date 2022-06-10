function swalConfirm(type) {
  let msg, cbutton, title

  switch (type) {
    case 'asset':
      action = 'deleteAsset'
      msg = "This action is irreversible. You won't be able to revert this!"
      cbutton = 'Delete Asset'
      title = 'Delete Asset and Attachments?'
      break

    case 'image':
      action = 'deleteImage'
      msg = "You won't be able to revert this!"
      cbutton = 'Delete'
      title = 'Delete Image?'
      break

    case 'audio':
      action = 'deleteAudio'
      msg = "You won't be able to revert this!"
      cbutton = 'Delete'
      title = 'Delete Audio?'
      break

    case 'video':
      action = 'deleteVideo'
      msg = "You won't be able to revert this!"
      cbutton = 'Delete'
      title = 'Delete Video?'
      break

    case 'doc':
      action = 'deleteDoc'
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
      return action
    } else {
      return false
    }
  })
}
