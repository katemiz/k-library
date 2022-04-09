<script>
  import { onMount } from 'svelte'

  import { createEventDispatcher } from 'svelte'
  const dispatch = createEventDispatcher()

  export let props

  let editor

  export let toolbarOptions = [
    [{ header: 1 }, { header: 2 }, 'blockquote', 'link', 'image', 'video'],
    ['bold', 'italic', 'underline', 'strike'],
    [{ list: 'bullet' }, { list: 'ordered' }],
    [{ align: [] }],
    ['clean'],
  ]

  onMount(async () => {
    const { default: Quill } = await import('quill')

    if (props.placeholder == undefined || props.placeholder == null) {
      props.placeholder = 'Type something ...'
    }

    let quill = new Quill(editor, {
      modules: {
        toolbar: toolbarOptions,
      },
      theme: 'snow',
      placeholder: props.placeholder,
    })

    if (props.content != undefined || props.content != null) {
      const delta = quill.clipboard.convert(props.content)
      quill.setContents(delta, 'silent')
    }

    quill.on('text-change', function () {
      dispatch('editordata', {
        id: props.id,
        icerik: {
          html: quill.root.innerHTML,
          text: quill.getText(),
        },
      })
    })
  })
</script>

<div class="field">
  <label class="label" for={props.id}>{props.label}</label>
  <div class="control" id={props.id}>
    <div class="editor" bind:this={editor} />
  </div>
</div>
